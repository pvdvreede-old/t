from django.views.generic import *
from t.transactions.models import *
from t.transactions.forms import *
from django.utils.decorators import method_decorator
from django.contrib.auth.decorators import login_required
from django.contrib import messages
from django.http import HttpResponseRedirect

class AccountMixin:
    def get_context_data(self, **kwargs):
        if self.request.GET.__contains__("account"):
            kwargs["current_account"] = Account.objects.get(pk=self.request.GET["account"]).name
        else:
            kwargs["current_account"] = "All"
            
        kwargs["accounts"] = Account.objects.filter(user=self.request.user)
        return kwargs


class BaseDeleteView(View):
    model=None
    success_url=None
    action_message="Items deleted!"
    
    def get_success_url(self):
        return self.success_url
    
    def post(self, request):
        self.model.objects.filter(user=request.user).filter(id__in=request.POST.getlist("ids")).delete()     
        messages.success(self.request, self.action_message)        
        return HttpResponseRedirect(self.get_success_url())
        
        


class UserBaseCreateView(CreateView):  
    action_message = "Item created!"

    def form_valid(self, form):
        value = super(UserBaseCreateView, self).form_valid(form)
        messages.success(self.request, self.action_message)
        return value

    def get_form_kwargs(self):
        kwargs = super(UserBaseCreateView, self).get_form_kwargs()
        kwargs.update({ "user" : self.request.user })
        return kwargs
    
class UserBaseUpdateView(UpdateView):
    action_message = "Item updated!"

    def form_valid(self, form):
        value = super(UserBaseUpdateView, self).form_valid(form)
        messages.success(self.request, self.action_message)
        return value

    def get_form_kwargs(self):
        kwargs = super(UserBaseUpdateView, self).get_form_kwargs()
        kwargs.update({ "user" : self.request.user })
        return kwargs



class TransactionsListView(AccountMixin, ListView):
    model=Transaction
    template_name="transaction_list.html" 
    paginated_by=2
       
    def get_queryset(self):
        objects = Transaction.objects.filter(user=self.request.user)
        if self.request.GET.__contains__("account"):
            objects = objects.filter(account=self.request.GET["account"])
        
        return objects
  
class TransactionCreateView(UserBaseCreateView):
    model=Transaction
    template_name="transaction_form.html"
    form_class=TransactionForm
    success_url="/transaction"   
    
class TransactionUpdateView(UserBaseUpdateView):
    model=Transaction
    template_name="transaction_form.html"
    form_class=TransactionForm
    success_url="/transaction"

class TransactionDeleteView(BaseDeleteView):
    model=Transaction
    success_url="/transaction"

    
class CategoryListView(ListView):
    model=Category
    template_name="category_list.html"
    
    def get_queryset(self):
        return Category.objects.filter(user=self.request.user)
    
class CategoryCreateView(UserBaseCreateView):
    model=Category
    template_name="transaction_form.html"
    form_class=CategoryForm
    success_url="/category"
    
class CategoryUpdateView(UserBaseUpdateView):
    model=Category
    template_name="transaction_form.html"
    form_class=CategoryForm
    success_url="/category"

class CategoryDeleteView(BaseDeleteView):
    model=Category
    success_url="/category"

    
class AccountCreateView(UserBaseCreateView):
    model=Account
    template_name="transaction_form.html"
    form_class=AccountForm
    success_url="/transaction"
    
class AccountUpdateView(UserBaseUpdateView):
    model=Account
    template_name="transaction_form.html"
    form_class=AccountForm
    success_url="/transaction"