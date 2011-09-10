from django import template

register = template.Library()

@register.inclusion_tag("base_paginator.html", takes_context=True)
def get_pagination(context):
    return context
		
@register.inclusion_tag("base_modal.html", takes_context=True)
def get_modal(context):
    return context
    
@register.inclusion_tag("base_form.html", takes_context=True)
def get_form(context):
    return context