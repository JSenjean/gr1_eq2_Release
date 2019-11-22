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

class TestUS6(unittest.TestCase):

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
      self.driver.find_element(By.CSS_SELECTOR, ".btn-outline-secondary").click()
      self.driver.implicitly_wait(2)
      self.wait_for_element_visible_by_id_selector('signupModal')
      self.driver.find_element(By.ID, "InputLogin1").click()
      self.driver.find_element(By.ID, "InputLogin1").send_keys("user1")
      self.driver.find_element(By.ID, "InputFirstname").send_keys("user1")
      self.driver.find_element(By.ID, "InputLastname").send_keys("user1")
      self.driver.find_element(By.ID, "InputEmail").send_keys("user1@mail.com")
      self.driver.find_element(By.ID, "InputEmail2").send_keys("user1@mail.com")
      self.driver.find_element(By.ID, "InputPassword1").send_keys("user1")
      self.driver.find_element(By.ID, "InputPassword2").send_keys("user1")
      self.waitAjax(self.driver)
      self.driver.find_element(By.NAME, "submit").click()
      self.driver.find_element(By.CSS_SELECTOR, ".btn-outline-primary").click()
      self.driver.implicitly_wait(2)
      self.wait_for_element_visible_by_id_selector('loginModal')
      self.driver.find_element(By.ID, "InputLogin2").click()
      self.driver.find_element(By.ID, "InputLogin2").send_keys("jdupont")
      self.driver.find_element(By.ID, "InputPassword3").send_keys("jdupont1234")
      self.waitAjax(self.driver)
      self.driver.find_element(By.CSS_SELECTOR, ".btn:nth-child(3)").click()
      self.driver.implicitly_wait(2)
      self.driver.find_element(By.LINK_TEXT, "Créer un projet").click()
      self.driver.implicitly_wait(2)
      self.wait_for_element_visible_by_id_selector('NewProjectModal')
      self.driver.find_element(By.ID, "projectName").click()
      self.driver.find_element(By.ID, "projectName").send_keys("Mon Projet")
      self.driver.find_element(By.ID, "projectDescription").send_keys("Mon projet")
      self.waitAjax(self.driver)
      self.driver.find_element(By.ID, "confirmNewProject").click()
      self.driver.find_element(By.CSS_SELECTOR, ".fa-plus-square").click()
      self.driver.implicitly_wait(2)
      self.driver.find_element(By.ID, "userName").click()
      self.driver.find_element(By.ID, "userName").send_keys("user1")
      self.driver.find_element(By.ID, "addUser").click()
      self.waitAjax(self.driver)
      self.driver.find_element(By.ID, "confirmInviteToProject").click()
    except Exception as e:
      result = False
      print("Test#6 failed")
      print(e)

    self.driver.close()
    self.driver.quit()

    self.assertEqual(result, True)  
  
if __name__ == "__main__":
    unittest.main()
  
