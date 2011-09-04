from django.conf.urls.defaults import patterns, include, url
from t.transactions.views import *

from django.contrib import admin
admin.autodiscover()

urlpatterns = patterns('',
    # Examples:
    # url(r'^$', 't.views.home', name='home'),
    # url(r'^t/', include('t.foo.urls')),

    # Uncomment the admin/doc line below to enable admin documentation:
    # url(r'^admin/doc/', include('django.contrib.admindocs.urls')),

    # Uncomment the next line to enable the admin:
    url(r'^admin/', include(admin.site.urls)),
    url(r'^transaction/new', TransactionFormView.as_view()),
    url(r'^transaction/', TransactionsListView.as_view()),
    url(r'^category/new', CategoryFormView.as_view()),
    url(r'^category/', CategoryListView.as_view()),
    
)
