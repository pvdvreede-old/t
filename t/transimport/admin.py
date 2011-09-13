from django.contrib import admin
from transimport.models import TransImport, DateFormat

class TransImportAdmin(admin.ModelAdmin):
    pass
  
class DateFormatAdmin(admin.ModelAdmin):
    pass


admin.site.register(TransImport, TransImportAdmin)
admin.site.register(DateFormat, DateFormatAdmin)
