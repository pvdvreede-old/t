from django.conf.urls.defaults import patterns, url
from t.transimport.views import *
from t.urls import urlpatterns

urlpatterns += patterns('',
    url(r'^import/$', ProcessUpload.as_view()), 
)
