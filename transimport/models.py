from django.contrib.auth.models import User
from django.db import models
from t.transactions.models import Account

class TransImport(models.Model):
    name = models.CharField(max_length=50)
    account = models.ForeignKey(Account)
    description_field = models.IntegerField()
    date_field = models.IntegerField()
    amount_field = models.IntegerField()
    user = models.ForeignKey(User)
    created_date = models.DateTimeField(editable=False, auto_now_add=True)
    modified_date = models.DateTimeField(null=False, editable=False, auto_now=True)
    
    def __unicode__(self):
        return self.name
        
class TransStaging(models.Model):
    date = models.DateField()
    description = models.CharField(max_length=200)
    amount = models.DecimalField(max_digits=10, decimal_places=2)
    account = models.ForeignKey(Account)
    user = models.ForeignKey(User)
    status = models.IntegerField()
    created_date = models.DateTimeField(editable=False, auto_now_add=True)
    modified_date = models.DateTimeField(null=False, editable=False, auto_now=True)
    
    def __unicode__(self):
        return self.description