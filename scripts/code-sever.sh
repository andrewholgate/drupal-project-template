#!/bin/bash
#
# Sever the codebase into the build directory.
#

cp -R code/features build/sites/all/modules/
mkdir build/sites/all/modules/custom
cp -R code/modules/*  build/sites/all/modules/custom/
cp -R code/themes build/sites/all/themes/custom/
