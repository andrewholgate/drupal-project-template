#!/bin/bash
#
# Code review and audit.
#

echo
if [ "$1" = "all" ]; then
  # Declare constants
  DIR_OUTPUT=docroot/review
  DIR_RESULTS=results

  # Create output directory if it does not exist.
  [ -d "$DIR_OUTPUT" ] || mkdir $DIR_OUTPUT

  # Clean-up existing tests.
  echo "Cleaning up existing test data."
  rm -Rf $DIR_OUTPUT/* $DIR_RESULTS/*.xml
  echo "Reviewing all custom code.."

  # Generate report XML files.

  # Mess Detector
  ./vendor/bin/phpmd code xml cleancode,codesize,design,unusedcode --suffixes php,module,info,install,test,profile,admin.inc --reportfile $DIR_RESULTS/phpmd.xml
  # Copy/Paste Detector
  ./vendor/bin/phpcpd code --names '*.php','*.module','*.info','*.install','*.test','*.profile','*.admin.inc' --min-lines 4 --min-tokens 10 --fuzzy --quiet --log-pmd $DIR_RESULTS/phpcpd.xml
  # Code Sniffer Features (Standards: Drupal, DrupalStandard & DrupalSecure)
  ./vendor/bin/phpcs --standard=Drupal,DrupalStrict,vendor/drupal/drupalstrict/security_ruleset.xml --extensions=php,module,info,install,test,profile,drush.inc,admin.inc,js,css --report=checkstyle --report-file=$DIR_RESULTS/phpcs.xml -- code
  # PDepend
  ./vendor/bin/pdepend --jdepend-xml=$DIR_RESULTS/jdepend.xml --summary-xml=$DIR_RESULTS/jdepend-summary.xml --suffix=php,module,install,test,profile,admin.inc code

  # Generate report outputs.

  # Unit Code Coverage
  ./vendor/bin/phpunit --coverage-html $DIR_OUTPUT/code-coverage code
  # Code browser output
  ./vendor/bin/phpcb --log=$DIR_RESULTS --source=code --output=$DIR_OUTPUT/code-browser
  # PHP Metrics
  ./vendor/bin/metrics.php --report-html=$DIR_OUTPUT/metrics.html --extensions="php|module|info|install|test|profile|admin.inc" code

  # Generate static report outputs.

  # CodeSpell (requires Python3)
  python3 ./vendor/lucasdemarchi/codespell/codespell.py --skip="*.png" code/ > $DIR_OUTPUT/codespell.out
  # Dead Code Detector
  ./vendor/bin/phpdcd --names='*.php','*.module','*.info','*.install','*.test','*.profile','*.admin.inc' code > $DIR_OUTPUT/phpdcd.out


  echo
  echo "REPORTS"
  echo
  echo "PHP Metrics: /review/metrics.html"
  echo "Code Browser: /review/code-browser"
  echo "Test Coverage: /review/code-coverage/"
  echo "Code Spell: /review/codespell.out"
  echo "Dead Code Detector: /review/phpdcd.out"
else
  # Retreive the git file changes
  GIT_CHANGES=`git diff --name-only`
  if [ -z "$GIT_CHANGES" ]; then
    echo "No code changes to review."
  else
   echo "Reviewing code changes.."
    ./vendor/bin/phpcs --standard=Drupal,DrupalStrict,vendor/drupal/drupalstrict/security_ruleset.xml --extensions=php,module,info,install,test,profile,admin.inc,js,css -- $GIT_CHANGES
   echo "Code review completed."
  fi
fi
