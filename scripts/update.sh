#!/bin/bash
#
# Project update
#

CONFIG=""

if [ "$1" == "production" ]; then
  CONFIG="--no-dev"
fi

cd build

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

cd build

echo
echo "Building project.."
drush build

echo
echo "Taking site out of maintenance mode.."
drush vset maintenance_mode 0

echo
echo "Project update completed."
