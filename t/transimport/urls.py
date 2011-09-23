from django.conf.urls.defaults import patterns, url
from t.transimport.views import *

url_import = patterns('',
    url(r'^$', ProcessUploadView.as_view()), 
    url(r'^staging', ImportStagingView.as_view()),
    url(r'^complete', ImportCompleteView.as_view()),
)

