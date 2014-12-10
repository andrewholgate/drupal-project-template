#!/bin/bash
#
# Perform a site audit
#

echo "Generating site audit.."
echo
cd build

[ -d "review" ] || mkdir review
drush secrev 2>&1 | tee ./review/security_audit.out
drush aa --html --bootstrap --detail > ./review/site_audit.html

echo
echo "REPORTS"
echo
echo "Site audit: /review/site_audit.html"
echo "Security audit: /review/security_audit.out"
echo
