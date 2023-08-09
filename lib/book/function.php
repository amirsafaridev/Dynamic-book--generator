<?php
add_action('wp_ajax_safir_book_add_to_cart', 'safir_book_add_to_cart');
add_action('wp_ajax_nopriv_safir_book_add_to_cart', 'safir_book_add_to_cart');

function safir_book_add_to_cart()
{

    $product_id = $_POST['product_id'];
    $book_id = $_POST['book_id'];

    if (!empty($product_id)) {
        //WC()->cart->empty_cart();
        $book_type = $_POST['book_type'];

        update_post_meta($product_id, '_type', $book_type);
        update_post_meta($product_id, 'product_is_book', "it_is");
        update_post_meta($product_id, 'product_book_id', $book_id);

        $WC_Cart = new WC_Cart();
        $WC_Cart->add_to_cart($product_id, 1,0,array(),array('product_is_book'=>true,"book_id"=>$book_id,"book_type"=>$book_type));

        $cart_url = wc_get_cart_url();
        echo $cart_url;
    }
    exit();
}

function getProductUserSell()
{
    $product_id = array();
    //require ARTA_STORY_BOOK_PLUGIN_DIR . '/vendor/autoload.php';
    $customer = get_current_user_id();


// Get all customer orders
    $customer_orders = get_posts(array(
        'numberposts' => -1,
        'meta_key' => '_customer_user',
        'orderby' => 'date',
        'order' => 'DESC',
        'meta_value' => get_current_user_id(),
        'post_type' => wc_get_order_types(),
        'post_status' => array_keys(wc_get_order_statuses()), 'post_status' => array('wc-processing'),
    ));

    $Order_Array = []; //
    foreach ($customer_orders as $customer_order) {
        $orderq = wc_get_order($customer_order);
        $Order_Array[] = [
            "ID" => $orderq->get_id(),
            "Value" => $orderq->get_total(),
            "Date" => $orderq->get_date_created()->date_i18n('Y-m-d'),
        ];
    }
    foreach ($Order_Array as $order) {
        $order_id = $order['ID'];
        $order_obj = wc_get_order($order_id);
        $items = $order_obj->get_items();
        foreach ($items as $item) {
            $item = json_decode($item);
            $product_id[] = $item->product_id;
        }
    }
    return $product_id;
}

add_action('woocommerce_before_calculate_totals', 'webroom_change_price_of_product');

function webroom_change_price_of_product($cart_object)
{

  
        // Product is already in cart
        foreach ($cart_object->get_cart() as $key => $value) {
        
            if(isset($value['product_is_book'])) {
                $is_book =$value['product_is_book'];
            $book_id = $value['book_id'];
            $book_type = $value['book_type'];
            
            if($book_type == "elect") {
                $price = get_post_meta($book_id, 'el_book_price', true);
            }elseif($book_type == "printed") {
                $price = get_post_meta($book_id, 'pr_book_price', true);
            }
         
            $value['data']->set_price($price); // CHANGE THIS: set the new price
            $new_price = $value['data']->get_price();
            }
        
        }
       
}

add_filter( 'woocommerce_order_item_permalink', 'arta_filter_order_item_permalink_callback', 10, 3 );
function arta_filter_order_item_permalink_callback( $product_permalink, $item, $order ) {
    
    $parent_product = wc_get_product( $item->get_product_id() );
    $product_id = $parent_product->id;
    if(!empty($product_id)){
        $is_book =get_post_meta($product_id,'product_is_book',true);
        if(!empty($is_book)){
            $book_id =get_post_meta($product_id,'product_book_id',true);
            $product_permalink = site_url().'/book?book_id='.$book_id;
        }
    }
    
    return $product_permalink;
}