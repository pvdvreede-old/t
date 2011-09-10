from django import template

register = template.Library()

@register.inclusion_tag("base_paginator.html", takes_context=True)
def get_pagination(context):
    return {
	'page' : context["page_obj"]
	}