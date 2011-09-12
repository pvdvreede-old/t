from django.forms import ModelForm, DateField
from django.forms.formsets import BaseFormSet
from t.transactions.forms import UserModelForm
from t.budget.models import *

class BudgetForm(UserModelForm):
    
    class Meta(UserModelForm.Meta):
        model=Budget
    
class BaseBudgetFormSet(BaseFormSet):
    pass