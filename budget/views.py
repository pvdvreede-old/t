from django.forms.formsets import form_factory
from t.budget.forms import BudgetForm


def budget_new(request):
    BudgetFormSet = form_factory(BudgetForm, formset=BaseBudgetFormSet)
    if request.method == 'POST':
        pass
    else:
        form_set = BudgetFormSet()
    return render_to_response('budget_form.html', {
          'form_set' : form_set
      })