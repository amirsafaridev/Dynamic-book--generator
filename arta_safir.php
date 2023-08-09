<?php

/**
 * Plugin Name: Arta Safir
 * Description: افزونه کتاب مادران سفیر
 * Version: 1.0.0
 * Author: ArtaCode
 * Author URI: http://artacode.net
 */


defined('ABSPATH') || exit;

if (!defined('SAFIR_PLUGIN_DIR')) {
    define('SAFIR_PLUGIN_FILE', __FILE__);
    define('SAFIR_PLUGIN_DIR', untrailingslashit(dirname(SAFIR_PLUGIN_FILE)));
}


// List Define Tracking
require __DIR__ . '/includes/main.php';