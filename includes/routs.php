<?php
// template include books
add_action('template_include', function ($template) {

    global $wp_query;
    $query = $wp_query->query_vars;

    if ($query["name"] == "book") {
        if (is_user_logged_in()) {
            return SAFIR_PLUGIN_DIR . '/lib/book/index.php';
        } else {
            wp_safe_redirect(home_url());
        }
    }

    if ($query["name"] == "book-generator") {
        if (is_user_logged_in()) {
            $is_admin = current_user_can('manage_options');
            if ($is_admin) {
                return SAFIR_PLUGIN_DIR . '/lib/book_generator/index.php';
            } else {
                wp_safe_redirect(home_url());
            }
        } else {
            wp_safe_redirect(home_url());
        }
    }
    return $template;
});