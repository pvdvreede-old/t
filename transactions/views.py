from django.views.generic import *
from t.transactions.models import *

class TransactionsListView(ListView):
    model=Transaction
    #query_set = Transaction.objects.get(user__exact=request.user.user_id)
    template_name="transaction_list.html"
  
  
class TransactionFormView(ModelFormMixin):
    model=Transaction
    template_name="transaction_form.html"
    