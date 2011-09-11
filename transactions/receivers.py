from django.dispatch import receiver
from django.db.models.signals import post_save, pre_save
from models import Transaction
import sys

@receiver(post_save, sender=Transaction, dispatch_uid="trans_post_save")
def update_account_balance(sender, **kwargs):
    print "Post save fired."
    instance = kwargs["instance"]
    instance.account.balance = instance.account.balance + instance.amount
    instance.account.save()
    print "Post save instance saved."
    
@receiver(pre_save, sender=Transaction, dispatch_uid="trans_pre_save")
def pre_update_account_balance(sender, **kwargs):
    print "Pre save fired."
    instance = kwargs["instance"]
    if instance.id:
      current_instance = Transaction.objects.get(pk=instance.id)
      instance.account.balance = instance.account.balance - current_instance.amount
      instance.account.save()
      print "Pre save instance updated."
    