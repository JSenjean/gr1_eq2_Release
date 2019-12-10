#!/bin/bash
rm -rf html/ latex/
doxygen Doxyfile


sensible-browser html/index.html &

cd latex

make

ls | grep -v *.pdf | xargs rm

cd ..
sensible-browser latex/refman.pdf &
