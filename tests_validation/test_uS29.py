#!/usr/bin/env python
# -*- coding: utf-8 -*-

import unittest
import pytest
import time
import json
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.support import expected_conditions
from selenium.webdriver.support.wait import WebDriverWait
from selenium.webdriver.common.keys import Keys
from selenium.common.exceptions import NoSuchElementException
from selenium.webdriver.support import expected_conditions as EC

class TestUS29(unittest.TestCase):

  def wait_for_element_visible_by_id_selector(self, id, timeout=20):
    WebDriverWait(self.driver, timeout).until(EC.visibility_of(self.driver.find_element(By.ID, id)))

  def waitAjax(self, driver):
    wait = WebDriverWait(self.driver, 15)
    try:
      wait.until(lambda driver: self.driver.execute_script('return jQuery.active') == 0)
      wait.until(lambda driver: self.driver.execute_script('return document.readyState') == 'complete')
    except Exception as e:
       pass
  
  def test_uS6(self):

    result = True

    self.driver = webdriver.Chrome()
    self.vars = {}

    with open('url.txt', 'r') as file:
      url = file.read().replace('\n', '')

    try:
      self.driver.get(url)
      self.driver.set_window_size(1868, 784)
      self.driver.find_element(By.LINK_TEXT, "FAQ").click()
    except Exception as e:
      result = False
      print("Test#29 failed")
      print(e)

    self.driver.close()
    self.driver.quit()

    self.assertEqual(result, True)  
  
if __name__ == "__main__":
    unittest.main()
  
