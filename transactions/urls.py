from django.conf.urls.defaults import patterns, url
from t.transactions.views import *
from t.urls import urlpatterns

urlpatterns += patterns('',
    url(r'^transaction/new', TransactionCreateView.as_view()),
    url(r'^transaction/delete', TransactionDeleteView.as_view()),
    url(r'^transaction/(?P<pk>\d)', TransactionUpdateView.as_view()),
    url(r'^transaction/', TransactionsListView.as_view()),
    url(r'^category/new', CategoryCreateView.as_view()),
    url(r'^category/delete', CategoryDeleteView.as_view()),
    url(r'^category/(?P<pk>\d)', CategoryUpdateView.as_view()),
    url(r'^category/', CategoryListView.as_view()),
    url(r'^account/new', AccountCreateView.as_view()),  
    url(r'^account/(?P<pk>\d)', AccountUpdateView.as_view()),  
)
