from django.views.generic import ListView
from t.transactions.models import *

class TransactionsListView(ListView):
  model = Transaction
  query_set = Transaction.objects.get(user__exact=request.user.user_id)
