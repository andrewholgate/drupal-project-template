<?php

/**
 * @file
 * Default drush aliases.drushrc.php file.
 */

/**
 * These are the default configuration so that
 * everyone can just overwrite the different settings.
 */
$aliases['example-develop'] = array (
  'uri' => 'dev.example.com',
  'root' => str_replace('drush/aliases', 'docroot', dirname(__FILE__)),
  'path-aliases' => array(
    '%dump' => '/tmp/drupal-dump.sql',
  ),
  'target-command-specific' => array(
    'sql-sync'  => array(
      'no-cache' => TRUE,
      'no-ordered-dump' => TRUE,
      'structure-tables-key' => 'project',
      'enable'  => array(
        'devel',
        'environment_indicator',
        'field_ui',
      ),
      'permission' => array(
        'authenticated user' => array(
          'add' => array(
            'access devel information',
            'access environment indicator',
          ),
        ),
        'anonymous user' => array(
          'add' => 'access environment indicator',
        ),
      ),
    ),
  ),
);

$aliases['example-staging'] = array (
  'uri' => 'staging.example.com',
  'root' => '/var/www/example/current',
  'remote-host' => 'example-staging',
  'path-aliases' => array(
    '%dump' => '/tmp/drupal-dump.sql',
  ),
);

$aliases['example-production'] = array (
  'uri' => 'example.com',
  'root' => '/var/www/example/current',
  'remote-host' => 'example-production',
  'path-aliases' => array(
    '%dump' => '/tmp/drupal-dump.sql',
  ),
);
