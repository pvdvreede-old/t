from django.conf.urls.defaults import patterns, url
from t.budget.views import *
from t.urls import urlpatterns

urlpatterns += patterns('',
    url(r'^budget/new', BudgetCreateView.as_view()),
    url(r'^budget/delete', BudgetDeleteView.as_view()),
    url(r'^budget/(?P<pk>\d)', BudgetUpdateView.as_view()),
    url(r'^budget/$', BudgetListView.as_view()),
)
