from django.contrib import admin
from t.transimport.models import TransImport

class TransImportAdmin(admin.ModelAdmin):
    pass


admin.site.register(TransImport, TransImportAdmin)
