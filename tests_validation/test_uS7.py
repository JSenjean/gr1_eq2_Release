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

class TestUS7(unittest.TestCase):

  def wait_for_element_visible_by_id_selector(self, id, timeout=20):
    WebDriverWait(self.driver, timeout).until(EC.visibility_of(self.driver.find_element(By.ID, id)))

  def waitAjax(self, driver):
    wait = WebDriverWait(self.driver, 15)
    try:
      wait.until(lambda driver: self.driver.execute_script('return jQuery.active') == 0)
      wait.until(lambda driver: self.driver.execute_script('return document.readyState') == 'complete')
    except Exception as e:
       pass
  
  def test_uS7(self):

    result = True

    self.driver = webdriver.Chrome()
    self.vars = {}
    
    with open('url.txt', 'r') as file:
      url = file.read().replace('\n', '')

    self.driver.get(url)
    self.driver.set_window_size(1868, 784)
    self.driver.find_element(By.CSS_SELECTOR, ".btn-outline-secondary").click()
    self.driver.implicitly_wait(2)
    self.wait_for_element_visible_by_id_selector('signupModal')
    self.driver.find_element(By.ID, "InputLogin1").click()
    self.driver.find_element(By.ID, "InputLogin1").send_keys("user2")
    self.driver.find_element(By.ID, "InputFirstname").send_keys("user2")
    self.driver.find_element(By.ID, "InputLastname").send_keys("user2")
    self.driver.find_element(By.ID, "InputEmail").send_keys("user2@mail.com")
    self.driver.find_element(By.ID, "InputEmail2").send_keys("user2@mail.com")
    self.driver.find_element(By.ID, "InputPassword1").send_keys("user2")
    self.driver.find_element(By.ID, "InputPassword2").send_keys("user2")
    self.driver.find_element(By.ID, "InputPassword2").send_keys(Keys.ENTER)
    self.driver.find_element(By.CSS_SELECTOR, ".btn-outline-primary").click()
    self.driver.implicitly_wait(2)
    self.wait_for_element_visible_by_id_selector('loginModal')
    self.driver.find_element(By.ID, "InputLogin2").click()
    self.driver.find_element(By.ID, "InputLogin2").send_keys("user2")
    self.driver.find_element(By.ID, "InputPassword3").send_keys("user2")
    self.driver.find_element(By.CSS_SELECTOR, ".btn:nth-child(3)").click()
    self.driver.find_element(By.ID, "myInputSearch").click()
    self.driver.find_element(By.ID, "myInputSearch").send_keys("Mon")
    
    try:
      success = self.driver.find_element(By.ID, "projectNameMon\ Projet")
      if not(success.is_displayed()):
        result = result and False
        print("The searched projet did not appear in test#7")
    except NoSuchElementException as exception:
      pass

    self.driver.close()
    self.driver.quit()

    self.assertEqual(result, True)  
  
if __name__ == "__main__":
    unittest.main()
  
