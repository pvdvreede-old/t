from django.forms import ChoiceField
from django.forms.formsets import BaseFormSet
from t.transactions.forms import UserModelForm
from t.budget.models import *

BUDGET_TYPES = (
    ("week", "Weekly"),
    ("month", "Monthly"),
    ("year", "Yearly"),
)

class BudgetForm(UserModelForm):
    
    type = ChoiceField(choices=BUDGET_TYPES)
    
    class Meta(UserModelForm.Meta):
        model=Budget

    