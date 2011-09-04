from django.forms import ModelForm
from t.transactions.models import *

class TransactionForm(ModelForm):
    class Meta:
        model=Transaction
        
        
class CategoryForm(ModelForm):
    class Meta:
        model=Category
