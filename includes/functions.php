<?php


/////// Other Helper Functions //////////////////////////////////////
function uploadAttachment($url)
{

    $base64_img = $url;

    // Upload dir.
    $upload_dir = wp_upload_dir();

    if (!is_dir($upload_dir['path'] . "/book_generator_image")) {
        mkdir($upload_dir['path'] . "/book_generator_image");
    }
    $upload_path = $upload_dir['path'] . "/book_generator_image/";
    $img = str_replace('data:image/jpeg;base64,', '', $base64_img);
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $decoded = base64_decode($img);

    $filename = md5(time()) . '.jpg';
    $file_type = 'image/jpg';

    $hashed_filename = $filename;

    // Save the image in the uploads directory.
    $upload_file = file_put_contents($upload_path . $hashed_filename, $decoded);
    $attachment = array(
        'post_mime_type' => $file_type,
        'post_type' => 'attachment',
        'post_title' => preg_replace('/\.[^.]+$/', '', basename($hashed_filename)),
        'post_content' => '',
        'post_status' => 'inherit',
        'guid' => $upload_dir['url'] . '/book_generator_image/' . basename($hashed_filename)
    );

    $attach_id = wp_insert_attachment($attachment, $hashed_filename, 0);
    update_post_meta($attach_id, 'image_gallery', 'it_is');
    $attachment_url = get_the_guid($attach_id);
    return $attachment_url;
}

add_action('gform_after_submission', 'set_user_meta_gv_get_fields', 10, 2);
function set_user_meta_gv_get_fields($entry, $form)
{
    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        update_user_meta($user_id, 'arta_form_' . $form['id'], $entry['id']);
    }
}


function safir_book_pages_callback($post)
{
    $post_id = $post->ID;
    $page_list = get_post_meta($post_id, 'safir_page_list', true) != "" ? get_post_meta($post_id, 'safir_page_list', true) : [];

    ?>
    <div style="width: 100%">
        <div style="display: flex;align-items: center">
            <button class="button" type="button" id="add_new_page_safir_book" post_id="<?php echo $post_id ?>">+ایجاد
                صفحه
                جدید
            </button>
            <div style="margin-right: 10px" class="delete">
                <button class="button" id="safir_delete_book_pages_item" type="button" post_id="<?php echo $post_id ?>">
                    حذف اخرین صفحه
                </button>
            </div>
        </div>
        <p>لطفا ابتدا تمامی صفحات را ایجاد کنید سپس با به روز رسانی پست نسبت به ویرایش صفحات اقدام کنید</p>

        <input name="safir_page_count" id="safir_page_count" type="hidden"
               value="<?php echo get_post_meta($post_id, 'safir_page_count', true) != '' ? get_post_meta($post_id, 'safir_page_count', true) : 0 ?>">
        <div id="safir_book_pages">
            <?php
            foreach ($page_list as $item) {
                ?>
                <div class="safir_book_pages_item">
                    <div class="title"><?php echo $item ?></div>
                    <input name="safir_page[]" type="hidden" value="<?php echo $item ?>">
                    <div style="display: flex;align-items: center" class="edit"><a target="_blank"
                                                                                   href="<?php echo home_url() . '/book-generator?page=' . $item . '&post=' . $post_id ?>">ویرایش</a>

                    </div>

                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
}

add_action('save_post_gv_safir_books', 'save_post_gv_safir_books');
function save_post_gv_safir_books()
{
    global $post;
    $post_id = $post->ID;
    $page_list = get_post_meta($post_id, 'safir_page_list', true) != "" ? get_post_meta($post_id, 'safir_page_list', true) : [];

    foreach ($_POST['safir_page'] as $page) {
        if (!metadata_exists('post', $post_id, $page)) {
            update_post_meta($post_id, $page, '');
            $page_list[] = $page;
        }
    }
    update_post_meta($post_id, 'safir_page_list', $page_list);
    update_post_meta($post_id, 'safir_page_count', count($page_list));

    if (isset($_POST['select_safir_product'])) {
        update_post_meta($post_id, 'select_safir_product', $_POST['select_safir_product']);
    }

    if (!empty($_POST['h_safir_book'] && $_POST['w_safir_book'])) {
        update_post_meta($post_id, 'h_safir_book', $_POST['h_safir_book']);
        update_post_meta($post_id, 'w_safir_book', $_POST['w_safir_book']);
    }

    if (isset($_POST['el_book_price'], $_POST['pr_book_price'])) {
        update_post_meta($post_id, 'el_book_price', $_POST['el_book_price']);
        update_post_meta($post_id, 'pr_book_price', $_POST['pr_book_price']);
    }
}


function arta_get_field_id_by_label($form_name, $label, $user_id)
{
    $form_id = RGFormsModel::get_form_id($form_name);

    $form = RGFormsModel::get_form_meta($form_id);
    $entry_id = get_user_meta($user_id, "arta_form_" . $form_id, true);
    foreach ($form['fields'] as $field) {
        if ($field->label == $label) {
            $entry = GFAPI::get_entry($entry_id);
            $field_id = $field["id"];
            return $entry["$field_id"];
        }
    }
    return false;
}


function arta_get_field_id_by_id($form_id, $field_id, $user_id)
{
    $form = RGFormsModel::get_form_meta($form_id);


    $entry_id = get_user_meta($user_id, "arta_form_" . $form_id, true);

    $entry = GFAPI::get_entry($entry_id);
    return $entry["$field_id"];

}

add_action('woocommerce_admin_order_item_headers', 'pd_admin_order_items_headers');
function pd_admin_order_items_headers($order)
{
    $items = $order->get_items();
    foreach ($items as $item) {
        $product_id = $item['product_id'];
        if (empty(get_post_meta($product_id, 'product_is_book'))) {
            return false;
        }
    }
    ?>
    <th class="line_customtitle sortable" data-sort="your-sort-option">
        نوع محصول
    </th>
    <th class="line_customtitle sortable" data-sort="your-sort-option">
        PDF
    </th>

    <?php
}

add_action('woocommerce_admin_order_item_values', 'pd_admin_order_item_values');
function pd_admin_order_item_values($item)
{
    //Get what you need from $product, $item or $item_id
    if (empty(get_post_meta($item->id, 'product_is_book'))) {
        return false;
    }
    $type = get_post_meta($item->id, '_type', true);
    $book_id = get_post_meta($item->id, 'product_book_id', true);
    if ($type == "printed") {
        $type = "نسخه چاپی";
    } elseif ($type == "elect") {
        $type = "نسخه الکترونیکی";
    }

    $cc_args = array(
        'posts_per_page' => -1,
        'post_type' => 'gv_safir_books',
        'meta_key' => 'select_safir_product',
        'meta_value' => $item->id
    );
    $cc_query = new WP_Query($cc_args);
    $target_post_id = $cc_query->posts[0]->ID;
    ?>
    <td class="line_customtitle">
        <?php echo $type ?>
    </td>
    <td class="line_customtitle">
        <?php echo do_shortcode('[show-book book_id=' . $book_id . ']') ?>
    </td>
    <?php
}

add_action('wp_ajax_safir_delete_book_pages_item', 'safir_delete_book_pages_item');
add_action('wp_ajax_nopriv_safir_delete_book_pages_item', 'safir_delete_book_pages_item');
function safir_delete_book_pages_item()
{
    $post_id = $_POST['post_id'];
    $page_list = get_post_meta($post_id, 'safir_page_list', true);
    $item = $page_list[count($page_list) - 1];
    delete_post_meta($post_id, $item);
    unset($page_list[count($page_list) - 1]);
    $page_count = get_post_meta($post_id, 'safir_page_count', true);
    $page_count = $page_count - 1;
    update_post_meta($post_id, 'safir_page_list', $page_list);
    update_post_meta($post_id, 'safir_page_count', $page_count);
    exit();
}