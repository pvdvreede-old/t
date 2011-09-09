from django import forms
from t.transactions.models import Account
from t.transimport.models import TransStaging
from t.transimport.qifparser import *
import time
import string
import datetime

class ImportForm(forms.Form):
    account = forms.ModelChoiceField(queryset=Account.objects)
    import_file = forms.FileField()
    
    def __init__(self, *args, **kwargs):
        user = kwargs.pop("user", None)  
        kwargs.pop("instance", None)
        super(ImportForm, self).__init__(*args, **kwargs)
        if user:
           self.user = user
    
    def save(self):
        imported_file = self.cleaned_data["import_file"]  
        parser = QifParser()
        items = parser.parseQif(imported_file)
        
        for item in items:
	    
            object = TransStaging()
            object.date = datetime.datetime.today()
            object.description = item.payee
            object.amount = item.amount
            object.user = self.user
            object.account = self.cleaned_data["account"]
            object.status=1
            object.created_date=datetime.datetime.today()
            object.save()
            
        return object          
            
    