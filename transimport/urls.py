from django.conf.urls.defaults import patterns, url
from t.transimport.views import *
from t.urls import urlpatterns

urlpatterns += patterns('',
    url(r'^import/$', ProcessUploadView.as_view()), 
    url(r'^import/staging/$', ImportStagingView.as_view()), 
)
