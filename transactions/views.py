from django.views.generic import *
from t.transactions.models import *
from t.transactions.forms import *

class TransactionsListView(ListView):
    model=Transaction
    #query_set = Transaction.objects.get(user__exact=request.user.user_id)
    template_name="transaction_list.html" 
  
class TransactionFormView(CreateView):
    model=Transaction
    template_name="transaction_form.html"
    form_class=TransactionForm
    success_url="/transaction"
    
class TransactionEditView(UpdateView):
    model=Transaction
    template_name="transaction_form.html"
    form_class=TransactionForm
    success_url="/transaction"
    
    
class CategoryListView(ListView):
    model=Category
    template_name="transaction_list.html"
    extra_content = { "url" : "category" }
    
class CategoryFormView(CreateView):
    model=Category
    template_name="transaction_form.html"
    form_class=CategoryForm
    success_url="/category"
    
class CategoryEditView(UpdateView):
    model=Category
    template_name="transaction_form.html"
    form_class=CategoryForm
    success_url="/category"