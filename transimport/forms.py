from django import forms
from t.transactions.models import Account
from t.transimport.models import TransStaging, DateFormat
from t.transimport.qifparser import *
import time
import string
import datetime

class ImportForm(forms.Form):
    FILE_CHOICES = (
	("qif", "Quicken Format")
    )
  
    account = forms.ModelChoiceField(queryset=Account.objects)
    #file_type = forms.ChoiceField(choices=FILE_CHOICES)
    date_format = forms.ModelChoiceField(queryset=DateFormat.objects)
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
	    if hasattr(item, "description"):
		description = item.description
	    elif hasattr(item, "memo"):
		description = item.memo
	    else:
		description = item.payee
	  
            object = TransStaging()
            object.date = datetime.datetime.strptime(item.date, self.cleaned_data["date_format"].expression)
            object.description = description
            object.amount = item.amount
            object.user = self.user
            object.account = self.cleaned_data["account"]
            object.status=1
            object.save()
            
        return object          
            
    