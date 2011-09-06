from django.conf.urls.defaults import patterns, include, url
from django.contrib.staticfiles.urls import staticfiles_urlpatterns
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
    url(r'^transaction/new', TransactionCreateView.as_view()),
    url(r'^transaction/(?P<pk>\d)', TransactionUpdateView.as_view()),
    url(r'^transaction/', TransactionsListView.as_view()),
    url(r'^category/new', CategoryCreateView.as_view()),
    url(r'^category/(?P<pk>\d)', CategoryUpdateView.as_view()),
    url(r'^category/', CategoryListView.as_view()),
    url(r'^account/new', AccountCreateView.as_view()),  
    url(r'^account/(?P<pk>\d)', AccountUpdateView.as_view()),
)

urlpatterns += staticfiles_urlpatterns()