<?php

/**
 * --------------------------
 * Autoload Function And Hook
 * --------------------------
 */


add_action('init', 'arta_safir_book_register_style_and_scripts');
function arta_safir_book_register_style_and_scripts()
{
    //wp_register_script('arta_safir_jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js', array('jquery'), '3.6.0', true);
    wp_register_script('arta_safir_js', plugin_dir_url(__DIR__) . 'assets/js/arta_safir.js', array('jquery'), time(), true);
    wp_register_style('arta_safir_css', plugin_dir_url(__DIR__) . 'assets/css/arta_safir.css', false, time(), 'all');
}


function add_admin_scripts_arta_safir($hook)
{
    wp_enqueue_media();
    //javascript
    //wp_enqueue_script('arta_safir_jquery');
    wp_enqueue_script('arta_safir_js');
    wp_enqueue_style('arta_safir_css');

    wp_localize_script('arta_safir_js', 'safir_object',
        array(
            'ajaxurl' => admin_url('admin-ajax.php'),
        )
    );
}

add_action('admin_enqueue_scripts', 'add_admin_scripts_arta_safir');

