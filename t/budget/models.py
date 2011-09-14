from django.contrib.auth.models import User
from django.db import models
from t.transactions.models import Category

class Budget(models.Model):
    category = models.ForeignKey(Category)
    type = models.CharField(max_length=10)
    limit = models.DecimalField(max_digits=10, decimal_places=2, default=0.00)
    rollover = models.BooleanField(default=False)
    rollover_start = models.DateField(blank=True, null=True)
    rollover_initial_amount = models.DecimalField(blank=True, null=True, max_digits=10, decimal_places=2, default=0.00)
    user = models.ForeignKey(User)
    created_date = models.DateTimeField(editable=False, auto_now_add=True)
    modified_date = models.DateTimeField(null=False, editable=False, auto_now=True)
    
class BudgetItem(models.Model):
    category = models.ForeignKey(Category)
    user = models.ForeignKey(User)
    budget = models.ForeignKey(Budget)
    start_date = models.DateField()
    end_date = models.DateField()
    balance = models.DecimalField(max_digits=10, decimal_places=2, default=0.00)
    limit = models.DecimalField(max_digits=10, decimal_places=2, default=0.00)
    rollover = models.DecimalField(max_digits=10, decimal_places=2, default=0.00)
    spent = models.DecimalField(max_digits=10, decimal_places=2, default=0.00)
    created_date = models.DateTimeField(editable=False, auto_now_add=True)
    modified_date = models.DateTimeField(null=False, editable=False, auto_now=True)
