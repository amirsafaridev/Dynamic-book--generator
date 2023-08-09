<?php

add_shortcode('show-book', function ($attr) {
    echo '<a href=' . home_url('/book?book_id=' . $attr['book_id']) . '>نمایش کتاب</a>';
});

add_shortcode('ms', function ($attr) {
    $form_name = $attr["form_title"];
    $form_title = $attr["field_title"];
    if (is_admin()) {
        $user_id = get_customerorderid();
        return arta_get_field_id_by_label($form_name, $form_title, $user_id);

    } else {
        return arta_get_field_id_by_label($form_name, $form_title, get_current_user_id());
    }
});

add_shortcode('ms_id', function ($attr) {
    $form_id = $attr["form_id"];
    $field_id = $attr["field_id"];
    if (is_admin()){
        $user_id = get_customerorderid();
        return arta_get_field_id_by_id($form_id, $field_id, $user_id);
    }else{
        return arta_get_field_id_by_id($form_id, $field_id, get_current_user_id());
    }
});

function get_customerorderid(){
    global $order, $post;

    if( ! is_a($order, 'WC_Order') ) {
        $order_id = $post->ID;

        // Get an instance of the WC_Order object
        $order = wc_get_order($order_id);
    } else {
        $order_id = $order->id;
    }

    // Get the user ID from WC_Order methods
    $user_id = $order->get_user_id(); // or $order->get_customer_id();

    return $user_id;
}