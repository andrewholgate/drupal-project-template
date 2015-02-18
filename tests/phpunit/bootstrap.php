<?php

// We assume that this script is being executed from the root of the project.
// These constants and variables are needed for the bootstrap process.

define('DRUPAL_ROOT',  'docroot');
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';

// Full bootstrap of Drupal.
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
