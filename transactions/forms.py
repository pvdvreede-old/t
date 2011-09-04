from django.forms import ModelForm, DateField
from t.transactions.models import *

class UserModelForm(ModelForm):
    
    def clean_user(self):
        self.user=self.request.user
    
    class Meta:
        includes=('name')
        excludes=('description')

class TransactionForm(ModelForm):
    class Meta:
        model=Transaction

               
class CategoryForm(UserModelForm):
    class Meta:
        model=Category
        includes=('name')
