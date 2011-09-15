from django.core.paginator import Paginator
from django.db.models.aggregates import Sum
from django.template.response import TemplateResponse
from django.views.generic import *
from t.transactions.views import UserBaseCreateView, UserBaseUpdateView, BaseDeleteView
from t.budget.forms import BudgetForm
from t.budget.models import Budget


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

class BudgetShowView(ListView):
    model=Budget
    template_name="budget_show.html"
    budget_type = None
    budget_date = None

    def dispatch(self, request, *args, **kwargs):
        self.budget_type = kwargs.pop('type')
        self.budget_date = kwargs.pop('date')
        return super(BudgetShowView, self).dispatch(request, *args, **kwargs)

    """
    Need to override because or rawqueryset not being countable
    """

    def get_paginator(self, queryset, per_page, orphans=0, allow_empty_first_page=True):
        paginator = Paginator(queryset, per_page, orphans=0, allow_empty_first_page=True)
        paginator._count = len(list(queryset))
        return paginator

    def get_queryset(self):
        budgets =  Budget.objects.raw(r'''
            select  b.id as id
                    , c.id as category_id
                    , SUM(t.amount) * -1 as spent
                    , b.limit as `limit`
                    , b.limit + SUM(t.amount) as balance
                    , t.user_id as user_id
                    , b.type as type
            from transactions_category c
            inner join transactions_transaction t
                on c.id = t.category_id
            inner join budget_budget b
                on b.category_id = c.id
            where t.user_id = {0}
            and t.amount < 0
            and b.type = '{1}'
            and t.date >= '2011-08-01'
            and t.date <= '2011-08-30'
            group by c.id
        '''.format(self.request.user.id, self.budget_type))
        return budgets

