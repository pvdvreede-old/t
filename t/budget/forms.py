from django.forms import ChoiceField
from django.forms.formsets import BaseFormSet
from t.transactions.forms import UserModelForm
from t.budget.models import *
from t.transactions.widgets import DatePickerWidget

BUDGET_TYPES = (
    ("Weekly", "Weekly"),
    ("Monthly", "Monthly"),
    ("Yearly", "Yearly"),
)

class BudgetForm(UserModelForm):
    
    type = ChoiceField(choices=BUDGET_TYPES)
    
    class Meta(UserModelForm.Meta):
        model=Budget
	widgets={
	    'rollover_start' : DatePickerWidget(),
	}
    