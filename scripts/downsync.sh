#!/bin/bash
#
# Downsync changes from remote environment to local.
#

SOURCE=$1
TARGET=$2
DATETIME=$(date +%Y%m%d-%H%M%S)

if [[ $SOURCE != @* ]] || [[ $TARGET != @* ]]; then
  echo "Usage: $0 [@source] [@target]"
  exit 1;
fi

# Reset project to environment commit revision

# Retreive commit revision
COMMIT=$(drush $SOURCE revision)

echo
echo "Reverting project to commit revision $COMMIT .."
echo

drush $TARGET core-execute git reset --hard
drush $TARGET core-execute git pull origin develop
drush $TARGET core-execute git reset --hard $COMMIT
drush $TARGET core-execute composer update

cd docroot

# Backup current database.
drush $TARGET sql-dump --gzip --result-file="../../../databases/local_$DATETIME.sql"

# Drop all database tables rather than create a new database.
drush $TARGET sql-drop

drush sql-sync $SOURCE $TARGET

# Sync database and rsync file system
drush rsync $SOURCE:%files $TARGET:%files

# Flush all caches.
drush cc all
