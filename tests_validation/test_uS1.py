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

class TestUS1(unittest.TestCase):

  def wait_for_element_visible_by_id_selector(self, id, timeout=20):
    WebDriverWait(self.driver, timeout).until(EC.visibility_of(self.driver.find_element(By.ID, id)))

  def waitAjax(self, driver):
    wait = WebDriverWait(self.driver, 15)
    try:
      wait.until(lambda driver: self.driver.execute_script('return jQuery.active') == 0)
      wait.until(lambda driver: self.driver.execute_script('return document.readyState') == 'complete')
    except Exception as e:
       pass
  
  def test_uS1(self):

    result = True

    self.driver = webdriver.Chrome()
    self.vars = {}
    
    with open('url.txt', 'r') as file:
      url = file.read().replace('\n', '')

    self.driver.get(url)
    self.driver.set_window_size(1936, 1056)
    self.driver.find_element(By.CSS_SELECTOR, ".btn-outline-secondary").click()
    self.driver.implicitly_wait(2)
    self.wait_for_element_visible_by_id_selector('signupModal')
    self.driver.find_element(By.ID, "InputLogin1").click()
    self.driver.find_element(By.ID, "InputLogin1").send_keys("jdupont")
    self.driver.find_element(By.ID, "InputFirstname").send_keys("Jean")
    self.driver.find_element(By.ID, "InputLastname").send_keys("Dupont")
    self.driver.find_element(By.ID, "InputEmail").send_keys("jean.dupont@mail.com")
    self.driver.find_element(By.ID, "InputEmail2").send_keys("jean.dupont@mail.com")
    self.driver.find_element(By.ID, "InputPassword1").click()
    self.driver.find_element(By.ID, "InputPassword1").send_keys("jdupont1234")
    self.driver.find_element(By.ID, "InputPassword2").send_keys("jdupont1234")
    self.waitAjax(self.driver)
    self.driver.find_element(By.NAME, "submit").click()
    self.driver.implicitly_wait(2)
    try:
      error = self.driver.find_element(By.ID, "alreadyUsedMail")
      if error.is_displayed():
        result = result and False
      error = self.driver.find_element(By.ID, "alreadyUsedId")
      if error.is_displayed():
        result = result and False
      error = self.driver.find_element(By.ID, "wrongPassword")
      if error.is_displayed():
        result = result and False
      print("An error message was detected during test#1")
    except NoSuchElementException as exception:
      pass
    
    self.driver.quit()

    self.assertEqual(result, True)  
  
if __name__ == "__main__":
    unittest.main()