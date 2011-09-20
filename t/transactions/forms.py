from django.forms import ModelForm, DateField
from django.forms.widgets import Textarea
from t.transactions.models import *
from t.transactions.widgets import DatePickerWidget, ColourPickerWidget

class UserModelForm(ModelForm): 
    user = None
    
    def __init__(self, *args, **kwargs):
        user = kwargs.pop("user", None)
        super(UserModelForm, self).__init__(*args, **kwargs)
        if user:
           self.user = user

    def save(self):
        self.instance.user = self.user
        return super(UserModelForm, self).save()
    
    class Meta:
        exclude=("user",)

class TransactionForm(UserModelForm):
    
    class Meta(UserModelForm.Meta):
        model=Transaction
        exclude=("user", "split_parent")
        widgets={
            'date' : DatePickerWidget(),
            'description' : Textarea(attrs={'rows' : '5'}),
	    }
             
class CategoryForm(UserModelForm):
    class Meta(UserModelForm.Meta):
        model=Category
        widgets={
	        'colour' : ColourPickerWidget(),
	    }

class RuleForm(UserModelForm):
    class Meta(UserModelForm.Meta):
        model=Rule


class AccountForm(UserModelForm):
    class Meta(UserModelForm.Meta):
        model=Account
