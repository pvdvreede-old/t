from django.dispatch import receiver
from django.db.models.signals import post_save, pre_save, post_delete
from django.db.models import Sum
from models import Transaction, Category
import sys

@receiver(post_save, sender=Transaction, dispatch_uid="trans_post_save_acc")
def update_account_balance(sender, **kwargs):
    print "Post save fired."
    recalculate_amount(kwargs["instance"])   
    print "Post save instance saved."
    
@receiver(post_delete, sender=Transaction, dispatch_uid="trans_post_delete_acc")
def update_account_balance_after_delete(sender, **kwargs):
    print "Post delete fired."
    recalculate_amount(kwargs["instance"])   
    print "Post delete instance saved."

@receiver(post_save, sender=Transaction, dispatch_uid="trans_post_save_cat")
def update_category_balance(sender, **kwargs):
    print "Post cat save fired."
    recalculate_category_amount(kwargs["instance"])   
    print "Post cat save instance saved."
    
@receiver(post_delete, sender=Transaction, dispatch_uid="trans_post_delete_cat")
def update_category_balance_after_delete(sender, **kwargs):
    print "Post cat delete fired."
    recalculate_category_amount(kwargs["instance"])   
    print "Post cat delete instance saved."

def recalculate_category_amount(instance):
    if instance.category != None:
	amount = Transaction.objects.filter(user=instance.user).filter(category=instance.category).aggregate(Sum('amount'))
	instance.category.spent = amount['amount__sum']
	instance.category.save()
    
def recalculate_amount(instance):
    amount = Transaction.objects.filter(user=instance.user).filter(account=instance.account).aggregate(Sum('amount'))   
    instance.account.balance = amount["amount__sum"]
    instance.account.save()
    
def recalcuate_budget(instance):
	from django.db import connection, transaction
	cursor = connection.cursor
	cursor.execute("""
		insert into budget_budgetitem (budget, user, category, spent, limit, balance, start_date, end_date)
		select b.id, b.user, b.category, b.limit, b.limit, b.limit, 
		CASE 
		  WHEN b.type = 'Yearly' THEN MAKEDATE( EXTRACT(YEAR FROM '{0}'),1);
		  WHEN b.type = 'Monthly' THEN DATE_FORMAT(CONCAT(SUBSTR('{0}',1,8),'01'),'%a');
		  WHEN b.type = 'Weekly' THEN SUBDATE('{0}', INTERVAL 8 DAY) AND DAYOFWEEK({date}) >= 1;
		END CASE,
		CASE 
		  WHEN b.type = 'Yearly' THEN STR_TO_DATE(CONCAT(12,31,EXTRACT(YEAR FROM {date})), '%Y-%m-%d') ;
		  WHEN b.type = 'Monthly' THEN DATE_FORMAT(LAST_DAY('{0}'),'%a');
		  WHEN b.type = 'Weekly' THEN SUBDATE('{0}', INTERVAL 8 DAY) AND DAYOFWEEK(column1) >= 1;
		END CASE,
		from budget_budget b
		left join budget_budgetitem bi on b.user = bi.user and b.category = bi.category
		where bi.start_date <= '{0}'
		and b.user = {1}
		and b.category = {2}
		and bi.end_date >= '{0}'
		and bi.id is null
	""".format(instance.date, instance.user, instance.category))
	
	cursor.execute("""
		update budget_budgetitem bi
		set spent = (select SUM(t.amount)
					 from transactions_transaction t
					 where t.user = {1}
					  and t.category = {2}
					  and t.date >= bi.start_date
					  and t.date <= bi.end_date)
			,balance = limit - spent
		where bi.user = {1}
		 and bi.category = {2}
		 and bi.start_date <= '{0}'
		 and bi.end_date >= '{0}'
	""".format(instance.date, instance.user, instance.category))
	transaction.commit_unless_managed()
	