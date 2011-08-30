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
    
    def __unicode__(self):
        return self.name