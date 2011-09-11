from django.forms import ModelForm, DateField
from t.transactions.models import *
from t.transactions.widgets import DatePickerWidget

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
        excludes=("user",)

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

class AccountForm(UserModelForm):
    class Meta(UserModelForm.Meta):
        model=Account
