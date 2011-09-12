from django.forms import ModelForm, DateField
from transactions.models import *
from transactions.widgets import DatePickerWidget, ColourPickerWidget

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
        exclude=("split_parent")
        widgets={
	    'date' : DatePickerWidget(),
	}
             
class CategoryForm(UserModelForm):
    class Meta(UserModelForm.Meta):
        model=Category
        widgets={
	    'colour' : ColourPickerWidget(),
	}

class AccountForm(UserModelForm):
    class Meta(UserModelForm.Meta):
        model=Account
