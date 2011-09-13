from django.conf.urls.defaults import patterns, include, url
from django.contrib.staticfiles.urls import staticfiles_urlpatterns
from transactions.urls import *
from transimport.urls import *
from budget.urls import *

from django.contrib import admin
admin.autodiscover()

urlpatterns = patterns('',
    url(r'^admin/', include(admin.site.urls)),  
    url(r'^account/', include(url_accounts)), 
    url(r'^category/', include(url_categories)), 
    url(r'^transaction/', include(url_transactions)),
    url(r'^import/', include(url_import)),
    url(r'^budget/', include(url_budget)),
)

urlpatterns += staticfiles_urlpatterns()
