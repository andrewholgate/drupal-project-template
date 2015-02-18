# Drupal 7 Project Template

## Overview

The Drupal 7 Project Template is designed to overcome common workflow issues during the Drupal development lifecycle.

It has the following set of functionality:

* Project builds using Composer.
    * Module patching.
    * Effortless Drupal core and module upgrades.
    * Project level dependency management.
* Organised project directory structure.
* PHPUnit testing (for Drupal 7).
* Automated code review, site audit and security review reports.
* Easy updating of code and database changes.
* Workflow and developer helper scripts.
* Separate environment settings (not stored in the code repository)
* Code documentation using DoxyGen and Sphinx.

### Roadmap

* Behat BDD testing.

* * *

## Getting Started

### 1. Install Composer
[Composer](https://getcomposer.org/) is used to build projects and their dependencies.

```bash
# Install Composer globally.
curl -sS https://getcomposer.org/installer | php
# Move Composer to globally accessible directory.
mv composer.phar /usr/local/bin/composer
```

### 2. Setup Project Structure

```bash
# Create initial project release directory.
mkdir -p project_name/release && cd project_name
# Link initial directory as the current project root.
ln -s release/v0.1-dev current && cd release
```

Rename *project_name* to the name of the project.


### 3. Install Project Template

```bash
# Fetch only the latest commit for the Drupal 7 Project Template.
git clone https://github.com/andrewholgate/drupal-project-template.git v0.1-dev
# Use Composer to install the project template
cd v0.1-dev && composer install
# Copy the default developer environment settings file out side of the repo.
cp environments/settings.develop.php ../../settings.local.php
# Update Composer to install the local settings file.
composer update
```

### 4. Symlink Code Review Tools
Symlink Drupal [Coder Sniffer](https://www.drupal.org/project/coder) coding standards sniffer.

```bash
ln -s $(pwd)/vendor/drupal/coder/coder_sniffer/Drupal $(pwd)/vendor/squizlabs/php_codesniffer/CodeSniffer/Standards/
```

Symlink [DrupalStrict Sniffer](https://github.com/andrewholgate/drupalstrict) coding standards sniffer.

```bash
ln -s $(pwd)/vendor/andrewholgate/drupalstrict/DrupalStrict $(pwd)/vendor/squizlabs/php_codesniffer/CodeSniffer/Standards/
```

### 5. Install and Configure Drush

```bash
# Install latest, stable drush system wide.
composer global require drush/drush:6.*
# Symlink drush executable into common user directory.
ln -s $HOME/vendor/drush/drush/drush /usr/local/bin/drush
```

Append the following code snippet into the `drushrc.php` file, found in `~/.drush/drushrc.php` in order to load custom drush commands, aliases and configurations from the project directory.

```php
// Load a drushrc.php file from the 'drush' folder at the root
// of the current git repository. Customize as desired.
// (Script by grayside; @see: http://grayside.org/node/93)
exec('git rev-parse --git-dir 2> /dev/null', $output);
if (!empty($output)) {
  $repo = $output[0];
  $options['config'] = $repo . '/../drush/drushrc.php';
  $options['include'] = array($repo . '/../drush/commands', $repo . '/../drush/modules');
  $options['alias-path'] = $repo . '/../drush/aliases';
}
```

### 6. Install Documentation Tools

This project template can be used with [Doxygen](http://www.stack.nl/~dimitri/doxygen/) and [Sphinx](http://sphinx.readthedocs.org/) to create beautiful project documentation, such as is found on [Read The Docs](http://read-the-docs.readthedocs.org/).

```bash
# Install Doxygen, Sphinx and pip
apt-get -y install python-sphinx python-pip doxygen
# Install Breathe and Read the Docs plugins for Sphinx.
pip install sphinx_rtd_theme breathe
```

You can generate Read the Docs styled documentation with the following command

```bash
./scripts/builddocs.sh
```

* * *

## Workflow Tools
To update a project with the latest code from the `develop` branch, apply all database changes and revert all [Features](https://www.drupal.org/project/features), execute the following script:

```bash
# Update and build the project with the latest changes (production safe)
./script/update.sh
```

To retrieve the current git revision of an environment, use the following drush shell alias:

```bash
drush @proj-production revision
```

Drush commands and aliases should be used for all database and file sync tasks, such as:

```bash
# Drop all tables in the current project.
drush @proj-develop sql-drop
# Synchronise the development database with production.
drush sql-sync @proj-production @proj-develop
# Synchronise the development files folder with production.
drush rsync @proj-production:%files @proj-develop:%files
# Flush the cache
drush cc all
```

Note that synchronising a database to the development alias will also trigger additional commands such as enabling the [Devel](https://www.drupal.org/project/devel), [Environment Indicator](https://www.drupal.org/project/environment_indicator) and Field UI modules as well as setting development permissions.

* * *

## Drush

### Drush Aliases
Read [Using drush to synchronize and deploy sites](https://www.drupal.org/node/670460) for more information on aliases

```bash
# Customise drush aliases for the project.
vim drush/aliases/aliases.drushrc.php
```

### Drush Commands
A full Drupal [Registry Rebuild](https://www.drupal.org/project/registry_rebuild) can be executing using the following command:

```bash
# Rebuild the Drupal registry.
cd docroot
drush rr
```

A full Features revert and database update can be executed using:

```bash
cd docroot
drush build
```

Note that this is one of the commands that is executed when `./scripts/update.sh` is executed.

* * *

## Automated Audit Reports

### Code Reviews
An automated code review of the local code changes can be generated using:

```bash
# Commandline output code review.
./scripts/review.sh
```

A full, graphical code review report of all the custom code can be generated using:

```bash
./scripts/review.sh all
```

The results can be navigated from the project URL at:

```
# PHP Metrics report
http://example.com/review/metrics.html

# Code Browser report
http://example.com/review/code-browser

# Test Coverage
http://example.com/review/code-coverage/

# Code Spell
http://example.com/review/codespell.out

# Dead Code Detector
http://example.com/review/phpdcd.out
```

### Site and Security Audit
An automated site and security audit of the project can be generated using:

```bash
./scripts/audit.sh
```

The results can be navigated from the project URL at:

```
# Site audit
http://example.com/review/site_audit.html

# Security audit
http://example.com/review/security_audit.out
```

* * *

## Project Directory Structure

### docroot/
The project document root. This directory contains files which are generated during `composer install` and `composer install`. This directory is not version controlled but can be regenerated using Composer.

### code/
Contains the project specific code for all custom Drupal Features and custom themes.
The directories `features/` and `themes/` are symlinked into the appropriate directories inside of `docroot/` on `composer install`.

### copy/
Files that will be copied into the `docroot/` directory on `composer update`
Files such as `.htaccess`, `settings.php` and `favicon.ico` should be placed here.

### docs/
Generated code documentation files are stored in this directory.

### drush/
Contains all project drush commands, aliases and additional modules.

### environments/
Contains `settings.php` templates for the different server environment. The appropriate file should be copied to `../../settings.php` of each environment and customisations made there.

### patches/
Patches for Drupal core and contributed modules are kept in this directory. All patches must be documented inside of the `README.md` file in the directory.

### results/
Results generated from code and audit review scripts are stored in this directory. Files in this directory should not be version controlled.

### scripts/
Helper scripts for use during development and deployment workflows.

### tests/
For external test such as [phpunit](http://phpunit.de/).

* * *

## Composer and Drupal Overview

### Dependency Management
Drupal core, contributed modules, contributed themes, third party libraries and project tools are all seen as dependencies using [Composer](https://getcomposer.org/).

As contributed Drupal 7 modules and themes do not contain their own `composer.json` files, they need to be added manually in the `"repositories": []` configuration of the main project `composer.json` file found in the project root.

```json
{
  "require": {
    "drupal/views": "7.3.8"
  },
  "repositories": [
    {
      "type": "package",
      "package": {
        "name": "drupal/views",
        "version": "7.3.8",
        "type": "drupal-module",
        "dist": {
          "url": "http://ftp.drupal.org/files/projects/views-7.x-3.8.tar.gz",
          "type": "tar"
        }
      }
    }
  ]
}
```

Read the [composer.json schema](https://getcomposer.org/doc/04-schema.md) for more information.

### Build File Structure
In order to make Composer create the correct Drupal project directory structure, the plugin [composer/installers](https://packagist.org/packages/composer/installers) is used. Read more on the [project homepage](https://github.com/composer/installers).

### Drupal Core as a Dependency
Drupal core is a special dependency case as when upgrading core, all of the directories should be removed (including all of the contributed modules directories, etc.) before the new version is installed.

To work around this issue the Composer plugin [azt3k/non-destructive-archive-installer](https://packagist.org/packages/azt3k/non-destructive-archive-installer) is used. Read more on the [project homepage](https://github.com/azt3k/non-destructive-archive-installer).

### Patching Contributed Modules
Patching of contributed modules is handled by the Composer plugin [netresearch/composer-patches-plugin](https://packagist.org/packages/netresearch/composer-patches-plugin).
For information on usage consult the [project documentation](https://github.com/netresearch/composer-patches-plugin).

All project patches must be put inside the `patches/` directory and clearly documented in the `README.md` file found inside the directory.
