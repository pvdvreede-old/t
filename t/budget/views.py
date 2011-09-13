from django.views.generic import *
from transactions.views import UserBaseCreateView, UserBaseUpdateView, BaseDeleteView
from budget.forms import BudgetForm
from budget.models import Budget

class BudgetListView(ListView):
    model=Budget
    template_name="budget_list.html"
    paginate_by=15
    
    def get_queryset(self):
        return Budget.objects.filter(user=self.request.user)
    
class BudgetCreateView(UserBaseCreateView):
    model=Budget
    template_name="budget_form.html"
    form_class=BudgetForm  
    success_url="/budget"
    
class BudgetUpdateView(UserBaseUpdateView):
    model=Budget
    template_name="budget_form.html"
    form_class=BudgetForm
    success_url="/budget"

class BudgetDeleteView(BaseDeleteView):
    model=Budget
    success_url="/budget"