import string
from django.core.paginator import Paginator
from django.db.models.aggregates import Sum
from django.template.response import TemplateResponse
from django.views.generic import *
from t.transactions.views import UserBaseCreateView, UserBaseUpdateView, BaseDeleteView
from t.budget.forms import BudgetForm
from t.budget.models import Budget
from datetime import datetime


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

    def get_context_data(self, **kwargs):
        context = super(BudgetShowView, self).get_context_data(**kwargs)
        context["date"] = self.budget_date
        context["type"] = self.budget_type
        return context

    def get_queryset(self):
        if self.budget_date == 'today':
            current_date = datetime.today()
            if string.lower(self.budget_type) == 'yearly':
                self.budget_date = current_date.year
            elif string.lower(self.budget_type) == 'monthly':
                self.budget_date = str(current_date.year) + str(current_date.month)
            elif string.lower(self.budget_type) == 'weekly':
                self.budget_date = str(current_date.year) + str(current_date.isocalendar()[1])

        if string.lower(self.budget_type) == "yearly":
            start_date = "'%s-01-01'" % self.budget_date
            end_date = "'%s-12-31'" % self.budget_date
        elif string.lower(self.budget_type) == "monthly":
            year = self.budget_date[:4]
            month = self.budget_date[4:6]
            start_date = "'{0}-{1}-01'".format(year, month)
            end_date = "LAST_DAY(%s)" % start_date
        elif string.lower(self.budget_type) == "weekly":
            start_date = "str_to_date('{0} Sunday', '%%X%%V %%W')".format(self.budget_date)
            end_date = "str_to_date('{0} Saturday', '%%X%%V %%W')".format(self.budget_date)

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
            left join budget_budget b
                on b.category_id = c.id
            where t.user_id = {0}
            and t.amount < 0
            and b.type = '{1}'
            and t.date >= {2}
            and t.date <= {3}
            and t.reportable = 1
            group by c.id
        '''.format(self.request.user.id, self.budget_type, start_date, end_date))

        return budgets

