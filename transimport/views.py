from t.transimport.forms import UploadForm
from t.transactions.views import UserBaseCreateView
from t.transimport.qifparser import *

class ProcessUpload(UserBaseCreateView):
    form_class=ImportForm  
    success_url="/transaction"
    template_name="base_form.html"   
    
        