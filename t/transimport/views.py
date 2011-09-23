from django.views.generic import *
from t.transimport.forms import ImportForm
from t.transactions.views import UserBaseCreateView
from t.transimport.qifparser import *
from t.transimport.models import TransStaging
from t.transactions.models import Transaction
from django.contrib import messages
from django.http import HttpResponseRedirect
from django.db import transaction
from django.db.models import F

class ProcessUploadView(UserBaseCreateView):
    form_class=ImportForm  
    success_url="/import/staging"
    template_name="transimport_form.html"
    
class ImportStagingView(ListView):
    model=TransStaging
    template_name="transimport_staging.html" 

    def get_queryset(self):
        duplicates = TransStaging.objects.filter(user=self.request.user).extra(
            tables=['transactions_transaction'],
            where=['transactions_transaction.date = transimport_transstaging.date',
                   'transactions_transaction.description = transimport_transstaging.description',
                   'transactions_transaction.amount = transimport_transstaging.amount']
        )

        return duplicates


class ImportCompleteView(View):

    def post(self, request):
      objects = TransStaging.objects.filter(user=self.request.user)

      if request.POST.__contains__("ids"):
        objects = objects.exclude(id__in=request.POST.getlist("ids"))

      with transaction.commit_on_success():

          for object in objects:
            new_trans = Transaction()
            new_trans.date = object.date
            new_trans.amount = object.amount
            new_trans.description = object.description
            new_trans.account = object.account
            new_trans.user = self.request.user
            new_trans.save()

          TransStaging.objects.filter(user=self.request.user).delete()
          
      messages.success(self.request, "Items imported!")
      return HttpResponseRedirect("/transaction")
    
