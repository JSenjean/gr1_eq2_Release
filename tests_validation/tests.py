#!/usr/bin/env python
# -*- coding: utf-8 -*-

import test_uS1
import test_uS2
import test_uS3
import test_uS4
import test_uS5
import test_uS6
import test_uS7
import test_uS8
import test_uS9
import test_uS27
import test_uS28
import test_uS29

import unittest
import pytest
import time
import json
import sys
import time
import os
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.support import expected_conditions
from selenium.webdriver.support.wait import WebDriverWait
from selenium.webdriver.common.keys import Keys
from selenium.common.exceptions import NoSuchElementException



def main(out = sys.stderr, verbosity = 3):
    suite = unittest.TestSuite()
    suite.addTest(unittest.makeSuite(test_uS1.TestUS1))
    suite.addTest(unittest.makeSuite(test_uS2.TestUS2))
    suite.addTest(unittest.makeSuite(test_uS3.TestUS3))
    suite.addTest(unittest.makeSuite(test_uS4.TestUS4))
    suite.addTest(unittest.makeSuite(test_uS5.TestUS5))
    suite.addTest(unittest.makeSuite(test_uS6.TestUS6))
    suite.addTest(unittest.makeSuite(test_uS7.TestUS7))
    suite.addTest(unittest.makeSuite(test_uS8.TestUS8))
    suite.addTest(unittest.makeSuite(test_uS9.TestUS9))
    suite.addTest(unittest.makeSuite(test_uS27.TestUS27))
    suite.addTest(unittest.makeSuite(test_uS28.TestUS28))
    suite.addTest(unittest.makeSuite(test_uS29.TestUS29))
    unittest.TextTestRunner(out, verbosity = verbosity).run(suite)

if __name__ == '__main__': 

    if not os.path.exists("logs"):
        os.makedirs("logs")

    timestr = time.strftime("%Y%m%d-%H%M%S")
    
    with open('logs' + os.path.sep + 'log_' + timestr + '.txt', 'w') as f: 
        main(f) 