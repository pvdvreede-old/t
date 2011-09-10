from django import template
import sys

register = template.Library()

@register.filter()
def in_list(value, arg):
    value = str(value)
    return value in arg
   