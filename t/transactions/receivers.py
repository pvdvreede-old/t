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