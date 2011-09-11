from django import template
import locale
locale.setlocale(locale.LC_ALL, '')
import sys

register = template.Library()

@register.filter()
def in_list(value, arg):
    value = str(value)
    return value in arg
    
@register.filter()
def currency(value):
    return locale.currency(value, grouping=True)