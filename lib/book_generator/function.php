<?php

add_action('wp_ajax_book_generator_save_image', 'book_generator_save_image');
add_action('wp_ajax_nopriv_book_generator_save_image', 'book_generator_save_image');
function book_generator_save_image()
{
    $url = $_POST['url'];
    echo uploadAttachment($url);
    exit();
}


add_action('wp_ajax_book_generator_show_image', 'book_generator_show_image');
add_action('wp_ajax_nopriv_book_generator_show_image', 'book_generator_show_image');
function book_generator_show_image()
{
    $args = array(
        'posts_per_page' => -1,
        'post_type' => 'attachment',
        'meta_query' => array(
            array(
                'key' => 'image_gallery',
                'value' => 'it_is',
            )
        )
    );
    $posts = get_posts($args);
    if (!empty($posts)) {
        $links = array();
        foreach ($posts as $post) {
            $links[] = $post->guid;
        }
    }
    echo json_encode($links);
    exit();
}


add_action('wp_ajax_book_generator_save_page', 'book_generator_save_page');
add_action('wp_ajax_nopriv_book_generator_save_page', 'book_generator_save_page');
function book_generator_save_page()
{
    $html = $_POST['html'];
    $page = $_POST['page'];
    $post = $_POST['post'];
    if (!empty($html && $page && $post)) {
        update_post_meta($post, $page, $html);
    }
    exit();
}

add_action('wp_ajax_book_generator_delete_image', 'book_generator_delete_image');
add_action('wp_ajax_nopriv_book_generator_delete_image', 'book_generator_delete_image');
function book_generator_delete_image()
{
    $src = $_POST['src'];
    $attachment = getIDfromGUID($src);
    $upload_dir = wp_upload_dir();
    $path = $upload_dir['path'] . "/book_generator_image/".basename($src);
    wp_delete_file( $path );
    wp_delete_attachment($attachment);
    echo $attachment;
    exit();
}

function getIDfromGUID($guid)
{
    global $wpdb;
    return $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid=%s", $guid));

}

