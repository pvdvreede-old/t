from django import forms
from django.conf import settings
from django.utils.safestring import mark_safe

class DatePickerWidget(forms.TextInput):
  
    def __init__(self, language=None, attrs=None):
        self.language = language or settings.LANGUAGE_CODE[:2]
        super(DatePickerWidget, self).__init__(attrs=attrs)

    def render(self, name, value, attrs=None):
        rendered = super(DatePickerWidget, self).render(name, value, attrs)
        return rendered + mark_safe(u'''<script type="text/javascript">
            $('#id_%s').datepicker({ dateFormat: 'yy-mm-dd'});
            </script>''' % name)
            
class ColourPickerWidget(forms.TextInput):
  
    def __init__(self, language=None, attrs=None):
        self.language = language or settings.LANGUAGE_CODE[:2]
        super(ColourPickerWidget, self).__init__(attrs=attrs)

    def render(self, name, value, attrs=None):
        rendered = super(ColourPickerWidget, self).render(name, value, attrs)
        return rendered + mark_safe(u'''<script type="text/javascript">
            $('#id_%s').ColorPicker({ 
	      onSubmit: function(hsb, hex, rgb, el) {
		$(el).val(hex);
		$(el).ColorPickerHide();
	      },
	      onBeforeShow: function () {
		      $(this).ColorPickerSetColor(this.value);
	      }
            })
            .bind('keyup', function(){
		      $(this).ColorPickerSetColor(this.value);
	     });
            </script>''' % name)