#!/bin/bash
#
# Sever the codebase into the docroot directory.
#
DOCROOT=docroot

cp -R code/features $DOCROOT/sites/all/modules/
mkdir $DOCROOT/sites/all/modules/custom
cp -R code/modules/*  $DOCROOT/sites/all/modules/custom/
cp -R code/themes $DOCROOT/sites/all/themes/custom/
