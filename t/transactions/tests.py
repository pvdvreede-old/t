"""
This file demonstrates writing tests using the unittest module. These will pass
when you run "manage.py test".

Replace this with more appropriate tests for your application.
"""

from django.test import TestCase
from django.test.client import Client
from decimal import *
import sys


class BaseTestTransaction():
    fixtures = ['user_test_data', 'account_test_data']
    url_part = None
    
    def setUp(self):
	self.client = Client()
	self.client.login(username='user1', password='test')
    
    def test_list(self):
        response = self.client.get('/%s/' % self.url_part)       
        self.assertEqual(response.status_code, 200)
        
    def test_new(self):
        response = self.client.get('/%s/new' % self.url_part)       
        self.assertEqual(response.status_code, 200)
    
    def test_update(self):
        response = self.client.get('/%s/1' % self.url_part)       
        self.assertEqual(response.status_code, 200)
     
    def test_user_field_not_visible(self):
	response = self.client.get('/%s/1' % self.url_part)
	self.assertFalse('user' in response.context["form"])
	  
            
class AccountsTest(BaseTestTransaction, TestCase):
    url_part="account"
    
    def test_update_item(self):
	response = self.client.get('/%s/1' % self.url_part)
	self.assertEqual(response.context["form"].instance.name, "Account1")
    
    def test_access_only_my_objects(self):
	response = self.client.get('/%s/3' % self.url_part)
	self.assertEqual(response.status_code, 404)
    
    def test_new_validation(self):
	response = self.client.post('/%s/new' % self.url_part, {
	      'name' : 'validation test',	      
	  }, follow=True)
	self.assertEqual(len(response.context["form"].errors), 2)
	
	response = self.client.post('/%s/new' % self.url_part, {
	      'account_type' : '1',	      
	  }, follow=True)	  
	self.assertEqual(len(response.context["form"].errors), 2)	
	
	response = self.client.post('/%s/new' % self.url_part, {
	      'name' : 'validation test',
	      'type' : '1',
	      'balance' : '0.00'
	  }, follow=True)
	  
	  
class CategoryTest(BaseTestTransaction, TestCase):
    url_part="category"
    fixtures = ['user_test_data', 'account_test_data', 'cat_test_data']
    
    def test_access_only_my_objects(self):
	response = self.client.get('/%s/3' % self.url_part)
	self.assertEqual(response.status_code, 404)
    
class TransactionTest(BaseTestTransaction, TestCase):
    url_part="transaction"
    fixtures = ['user_test_data', 'account_test_data', 'cat_test_data', 'trans_test_data']
    
    def test_access_only_my_objects(self):
	response = self.client.get('/%s/7' % self.url_part)
	self.assertEqual(response.status_code, 404)
	
    def test_account_balance_sum(self):
	response = self.client.get('/account/1')
	self.assertEqual(response.context["form"].instance.balance, 25.00)
	response = self.client.get('/account/2')
	self.assertEqual(Decimal(response.context["form"].instance.balance), Decimal('-975.79'))
	
    def test_account_balance_sum_after_delete(self):
	response = self.client.post('/transaction/actions', {
	      'action' : 'delete',
	      'ids' : '3'
	    })
	response = self.client.get('/account/1')
	self.assertEqual(response.context["form"].instance.balance, 145.00)
	
    def test_category_balance_sum(self):
	response = self.client.get('/category/1')
	self.assertEqual(response.context["form"].instance.spent, 145.00)
	response = self.client.get('/category/2')
	self.assertEqual(Decimal(response.context["form"].instance.spent), Decimal('-240.00'))
	
    def test_category_balance_sum_after_delete(self):
	response = self.client.post('/transaction/actions', {
	      'action' : 'delete',
	      'ids' : '4'
	    })
	response = self.client.get('/category/2')
	self.assertEqual(Decimal(response.context["form"].instance.spent), Decimal('-120.00'))
	