# Files for project build

This directory is where project specific files that need to be copied into the project directory root `docroot` are kept.

As part of the `composer install` and `composer update` build processes, the files in this directory will be copied into the `docroot/` directory.

Examples of common files to keep in this directory are:

* `sites/default/settings.php`
* `favicon.ico`
