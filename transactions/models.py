from django.contrib.auth.models import User
from django.db import models

class AccountType(models.Model):
    name = models.CharField(max_length=50)
    created_date = models.DateField(editable=False)
    modified_date = models.DateField(null=False, editable=False)
    
    def __unicode__(self):
        return self.name

class Account(models.Model):
    name = models.CharField(max_length=50)
    account_type = models.ForeignKey(AccountType)
    user = models.ForeignKey(User)
    created_date = models.DateField(editable=False)
    modified_date = models.DateField(null=False, editable=False)
    
    def __unicode__(self):
        return self.name
    
class Category(models.Model):
    name = models.CharField(max_length=50)
    colour = models.CharField(max_length=10)
    reportable = models.BooleanField()
    user = models.ForeignKey(User)
    created_date = models.DateField(editable=False)
    modified_date = models.DateField(null=False, editable=False)
    
    def __unicode__(self):
        return self.name
    
class Transaction(models.Model):
    date = models.DateField()
    description = models.CharField(max_length=200)
    amount = models.DecimalField(max_digits=10, decimal_places=2)
    reportable = models.BooleanField()
    account = models.ForeignKey(Account)
    category = models.ForeignKey(Category, blank=True, null=True)
    user = models.ForeignKey(User)
    created_date = models.DateField(editable=False)
    modified_date = models.DateField(null=False, editable=False)
    
    def __unicode__(self):
        return self.description

