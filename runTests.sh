#!/bin/bash
php phpunit --log-junit logTests/$( date '+%Y-%m-%d' )-test.xml  --configuration  tests/phpunit.xml tests
