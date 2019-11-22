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

class TestUS5(unittest.TestCase):

  def wait_for_element_visible_by_id_selector(self, id, timeout=20):
    WebDriverWait(self.driver, timeout).until(EC.visibility_of(self.driver.find_element(By.ID, id)))

  def waitAjax(self, driver):
    wait = WebDriverWait(self.driver, 15)
    try:
      wait.until(lambda driver: self.driver.execute_script('return jQuery.active') == 0)
      wait.until(lambda driver: self.driver.execute_script('return document.readyState') == 'complete')
    except Exception as e:
       pass
  
  def test_uS5(self):

    result = True

    self.driver = webdriver.Chrome()
    self.vars = {}

    with open('url.txt', 'r') as file:
      url = file.read().replace('\n', '')

    try:
      self.driver.get(url)
      self.driver.set_window_size(1868, 784)
      self.driver.find_element(By.CSS_SELECTOR, ".btn-outline-primary").click()
      self.driver.implicitly_wait(2)
      self.driver.find_element(By.ID, "InputLogin2").click()
      self.driver.find_element(By.ID, "InputLogin2").send_keys("jdupont")
      self.driver.find_element(By.ID, "InputPassword3").click()
      self.driver.find_element(By.ID, "InputPassword3").send_keys("jdupont1234")
      self.waitAjax(self.driver)
      self.driver.find_element(By.CSS_SELECTOR, ".btn:nth-child(3)").click()
      self.driver.implicitly_wait(2)
      self.driver.find_element(By.CSS_SELECTOR, ".fa-arrow-alt-circle-right").click()
      self.driver.implicitly_wait(2)
      self.waitAjax(self.driver)
      self.driver.find_element(By.CSS_SELECTOR, ".btn-outline-primary").click()
      self.driver.implicitly_wait(2)
      self.driver.find_element(By.ID, "InputName").click()
      self.driver.find_element(By.ID, "InputName").send_keys("Mon Projet 2")
      self.driver.find_element(By.NAME, "description").click()
      self.driver.find_element(By.NAME, "description").send_keys("Ceci est mon premier projet version 2")
      self.driver.find_element(By.ID, "InputVisiblity").click()
      self.waitAjax(self.driver)
      self.driver.find_element(By.NAME, "submit").click()
    except Exception as e:
      print("Project modification in test#5 failed")
      print(e)
      result = result and False

    try:
      self.driver.implicitly_wait(2)
      self.driver.find_element(By.LINK_TEXT, "Mes Projets").click()
      self.driver.implicitly_wait(2)
      self.driver.find_element(By.CSS_SELECTOR, ".fa-trash").click()
      self.driver.implicitly_wait(2)
      self.driver.find_element(By.ID, "confirmDeleteProject").click()
    except Exception as e:
      print("Project deletion in test#5 failed")
      print(e)
      result = result and False

    self.driver.close()
    self.driver.quit()

    self.assertEqual(result, True)  
  
if __name__ == "__main__":
    unittest.main()
  
