#!/bin/bash
#
# Build Doxygen docs and output using Sphinx.
#

cd docs
doxygen doxygen.config
make clean
make html
