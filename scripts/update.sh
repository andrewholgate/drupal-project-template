#!/bin/bash
#
# Full project update and build.
#

CONFIG=""
DATETIME=$(date +%Y%m%d-%H%M%S)
DOCROOT=docroot

if [ "$1" == "production" ]; then
  CONFIG="--no-dev"
fi

cd $DOCROOT

# Backup current database.
drush sql-dump --gzip --result-file="../../../databases/update_$DATETIME.sql"

echo
echo "Putting site into maintenance mode.."
drush vset maintenance_mode 1

echo
echo "Updating project code.."

cd ..
git reset --hard
git pull origin develop

echo
echo "Updating project dependencies.."
composer update $CONFIG

cd $DOCROOT

echo
echo "Building project into $DOCROOT/"
drush build

echo
echo "Taking site out of maintenance mode.."
drush vset maintenance_mode 0
