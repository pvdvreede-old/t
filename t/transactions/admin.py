from django.contrib import admin
from t.transactions.models import *

class AccountTypeAdmin(admin.ModelAdmin):
    pass

class AccountAdmin(admin.ModelAdmin):
    pass

class CategoryAdmin(admin.ModelAdmin):
    pass

class TransactionAdmin(admin.ModelAdmin):
    pass

admin.site.register(AccountType, AccountTypeAdmin)
admin.site.register(Account, AccountAdmin)
admin.site.register(Category, CategoryAdmin)
admin.site.register(Transaction, TransactionAdmin)