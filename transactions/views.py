from django.views.generic import *
from t.transactions.models import *
from t.transactions.forms import *

class AccountLoader():   
    def get_accounts(user_id):
        accounts = Account.objects.filter(user_id=user_id)       
        return accounts

class TransactionsListView(ListView, AccountLoader):
    model=Transaction
    template_name="transaction_list.html" 
    
    def get_queryset(self):
        return Transaction.objects.filter(user=self.request.user)
  
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
    
    def get_queryset(self):
        return Category.objects.filter(user=self.request.user)
    
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