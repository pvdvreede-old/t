from django.conf.urls.defaults import patterns, include, url
from django.contrib.staticfiles.urls import staticfiles_urlpatterns
from t.transactions.views import *

from django.contrib import admin
admin.autodiscover()

urlpatterns = patterns('',
    url(r'^admin/', include(admin.site.urls)),   
)

from transactions import urls
from transimport import urls
from budget import urls

urlpatterns += staticfiles_urlpatterns()
#urlpatterns += ('', url(r'^$', TransactionsListView.as_view()),)