from django.conf.urls.defaults import patterns, url
from t.budget.views import *
from t.urls import urlpatterns

urlpatterns += patterns('',
    url(r'^budget/new', 't.budget.views.budget_new'),

)
