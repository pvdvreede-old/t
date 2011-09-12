from django.forms import ChoiceField
from django.forms.formsets import BaseFormSet
from transactions.forms import UserModelForm
from budget.models import *
from transactions.widgets import DatePickerWidget

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
    