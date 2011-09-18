from django.conf.urls.defaults import patterns, url
from t.budget.views import *

url_budget = patterns('',
    url(r'^new', BudgetCreateView.as_view()),
    url(r'^delete', BudgetDeleteView.as_view()),
    url(r'^(?P<pk>\d)', BudgetUpdateView.as_view()),
    url(r'^$', BudgetListView.as_view()),
    url(r'^show/(?P<type>[a-zA-Z]+)/(?P<date>\d+)', BudgetShowView.as_view()),
    url(r'^show/(?P<type>[a-zA-Z]+)/today', BudgetShowView.as_view(), { 'date' : 'today' }),
)
