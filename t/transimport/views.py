from django.views.generic import *
from transimport.forms import ImportForm
from transactions.views import UserBaseCreateView
from transimport.qifparser import *
from transimport.models import TransStaging
from transactions.models import Transaction
from django.contrib import messages
from django.http import HttpResponseRedirect

class ProcessUploadView(UserBaseCreateView):
    form_class=ImportForm  
    success_url="/import/staging"
    template_name="transimport_form.html"
    
class ImportStagingView(ListView):
    model=TransStaging
    template_name="transimport_staging.html" 
    paginated_by=10
       
    def get(self, request):
      objects = TransStaging.objects.filter(user=self.request.user)
      for object in objects:
	new_trans = Transaction()
	new_trans.date = object.date
	new_trans.amount = object.amount
	new_trans.description = object.description
	new_trans.account = object.account
	new_trans.user = self.request.user
	new_trans.save()
	
      objects.delete()
      messages.success(self.request, "Items imported!")
      return HttpResponseRedirect("/transaction")
    
        