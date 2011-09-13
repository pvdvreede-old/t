from django.conf.urls.defaults import patterns, url
from transimport.views import *

url_import = patterns('',
    url(r'^$', ProcessUploadView.as_view()), 
    url(r'^staging', ImportStagingView.as_view()), 
)

