from t.transimport.forms import ImportForm
from t.transactions.views import UserBaseCreateView
from t.transimport.qifparser import *

class ProcessUpload(UserBaseCreateView):
    form_class=ImportForm  
    success_url="/transaction"
    template_name="transaction_form.html"   
    
        