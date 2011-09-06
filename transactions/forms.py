from django.forms import ModelForm, DateField
from t.transactions.models import *

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
             
class CategoryForm(UserModelForm):
    class Meta(UserModelForm.Meta):
        model=Category

class AccountForm(UserModelForm):
    class Meta(UserModelForm.Meta):
        model=Account
