from django.views.generic import *
from t.transactions.models import *
from t.transactions.forms import *
from django.utils.decorators import method_decorator
from django.contrib.auth.decorators import login_required

class AccountLoader():   
    def get_accounts(user_id):
        accounts = Account.objects.filter(user_id=user_id)       
        return accounts

class TransactionsListView(ListView):
    model=Transaction
    template_name="transaction_list.html" 
    paginated_by=2
    
   ## @method_decorator(login_required)
    def dispatch(self, *args, **kwargs):
        return super(TransactionsListView, self).dispatch(*args, **kwargs)
    
    def get_context_data(self, **kwargs):
        context = super(TransactionsListView, self).get_context_data(**kwargs)
        context['url'] = 'transaction'
        return context
    
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
    
    def get_context_data(self, **kwargs):
        context = super(CategoryListView, self).get_context_data(**kwargs)
        context['url'] = 'category'
        return context
    
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