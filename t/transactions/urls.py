from django.conf.urls.defaults import patterns, url
from t.transactions.views import *

url_accounts = patterns('',
    url(r'^new', AccountCreateView.as_view()),  
    url(r'^(?P<pk>\d)', AccountUpdateView.as_view()),  
    url(r'^$', AccountListView.as_view()),
    url(r'^delete', AccountDeleteView.as_view()),
)

url_categories = patterns('',
    url(r'^new', CategoryCreateView.as_view()),
    url(r'^delete', CategoryDeleteView.as_view()),
    url(r'^(?P<pk>\d)', CategoryUpdateView.as_view()),
    url(r'^$', CategoryListView.as_view()),  
)

url_transactions = patterns('',
    url(r'^new', TransactionCreateView.as_view()),
    url(r'^actions', TransactionActionView.as_view()),
    url(r'^(?P<pk>\d)', TransactionUpdateView.as_view()),
    url(r'^$', TransactionsListView.as_view()),
)

