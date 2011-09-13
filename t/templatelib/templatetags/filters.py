from django import template
import locale
locale.setlocale(locale.LC_ALL, 'en_CA.UTF-8')
import sys

register = template.Library()

@register.filter()
def in_list(value, arg):
    value = str(value)
    return value in arg
    
@register.filter()
def currency(value):
    if value != None:
      return locale.currency(value, grouping=True)