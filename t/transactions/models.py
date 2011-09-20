from django.contrib.auth.models import User
from django.db import models
from datetime import datetime
from django.dispatch import receiver
from django.db.models.signals import post_save, pre_save
import sys

class AccountType(models.Model):
    name = models.CharField(max_length=50, unique=True)
    description = models.CharField(blank=True, null=True, max_length=300)
    created_date = models.DateTimeField(editable=False, auto_now_add=True)
    modified_date = models.DateTimeField(null=False, editable=False, auto_now=True)
    
    def __unicode__(self):
        return self.name

class Account(models.Model):
    name = models.CharField(max_length=50)
    account_type = models.ForeignKey(AccountType)
    balance = models.DecimalField(max_digits=10, decimal_places=2, default=0.00)
    user = models.ForeignKey(User)
    created_date = models.DateTimeField(editable=False, auto_now_add=True)
    modified_date = models.DateTimeField(null=False, editable=False, auto_now=True)
    
    def __unicode__(self):
        return self.name
        
    class Meta:
	    unique_together = ("name", "user", "account_type")
    
class Category(models.Model): 
    parent = models.ForeignKey('self', blank=True, null=True)
    name = models.CharField(max_length=50)
    colour = models.CharField(max_length=10)
    reportable = models.BooleanField(default=True)
    user = models.ForeignKey(User)
    created_date = models.DateTimeField(editable=False, auto_now_add=True)
    modified_date = models.DateTimeField(null=False, editable=False, auto_now=True)
    
    def __unicode__(self):
        return self.name
        
    class Meta:
	    unique_together = ("name", "user")

class Rule(models.Model):
    user = models.ForeignKey(User)
    category = models.ForeignKey(Category)
    type = models.CharField(max_length=10)
    value = models.CharField(max_length=250)
    created_date = models.DateTimeField(editable=False, auto_now_add=True)
    modified_date = models.DateTimeField(null=False, editable=False, auto_now=True)

    def __unicode__(self):
        return self.type + self.value

class Transaction(models.Model):
    date = models.DateField()
    description = models.CharField(max_length=200)
    amount = models.DecimalField(max_digits=10, decimal_places=2)
    split_parent = models.ForeignKey('self', blank=True, null=True)
    reportable = models.BooleanField(default=True)
    account = models.ForeignKey(Account)
    category = models.ForeignKey(Category, blank=True, null=True)
    user = models.ForeignKey(User)
    created_date = models.DateTimeField(editable=False, auto_now_add=True)
    modified_date = models.DateTimeField(null=False, editable=False, auto_now=True)
    
    def __unicode__(self):
        return self.description
