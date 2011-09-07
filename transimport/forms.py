from django import forms
from t.transactions.models import Account
from t.transimport.models import TransStaging
from t.transimport.qifparser import *

class ImportForm(Form):
    account = forms.ModelChoiceField(queryset=Account.objects.filter(user=self.user))
    import_file = forms.FileField()
    
    def save(self):
        file = self.cleaned_data["import_file"]      
        items = parseQif(file)
        
        for item in items:
            object = TransStaging()
            object.date = item.date
            object.description = item.memo
            object.amount = item.amount
            object.user = self.user
            object.account = self.cleaned_data["account"]
            object.save()
            
        return True
            
    