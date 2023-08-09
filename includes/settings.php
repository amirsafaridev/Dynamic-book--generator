<?php
add_action('add_meta_boxes', 'safir_book_setting');
if (!function_exists('safir_book_setting')) {
    function safir_book_setting()
    {
        add_meta_box('safir_book_sizing', __('اندازه کتاب', ''), 'safir_book_sizing_callback', 'gv_safir_books', 'normal', 'core');
        add_meta_box('safir_book_pages_box', __('صفحات کتاب', ''), 'safir_book_pages_callback', 'gv_safir_books', 'normal', 'core');
        add_meta_box('safir_product_select', __('انتخاب محصول', ''), 'safir_product_select_callback', 'gv_safir_books', 'normal', 'core');
        add_meta_box('safir_products_price', __('قیمت محصول', ''), 'safir_products_price', 'gv_safir_books', 'normal', 'core');
    }
}
function safir_book_sizing_callback($post)
{
    $post_id = $post->ID;
    ?>
    <div style="display: flex;align-items: center;justify-content: space-around;width: 100%">
        <fieldset>
            <label for="w_safir_book">
                عرض کتاب(px)
                <input type="text" max="9999999999" name="w_safir_book" id="w_safir_book"
                       value="<?php echo get_post_meta($post_id, 'w_safir_book', true) ?>">
            </label>
        </fieldset>
        <fieldset>
            <label for="h_safir_book">
                ارتفاع کتاب(px)
                <input type="text" max="9999999999" name="h_safir_book" id="h_safir_book"
                       value="<?php echo get_post_meta($post_id, 'h_safir_book', true) ?>">
            </label>
        </fieldset>
    </div>
    <?php
}

function safir_product_select_callback($post)
{
    $post_id = $post->ID;
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
    );
    $products = get_posts($args);
    if ($products != null) :
        ?>
        <div>
            <fieldset>
                <select style="width: 100%;overflow: hidden!important;" name="select_safir_product"
                        id="select_safir_product">
                    <?php
                    foreach ($products as $product) {
                        $title = $product->post_title != '' ? $product->post_title : 'بدون عنوان';
                        $title = mb_strimwidth($title, 0, 100, '...');
                        if ($product->ID == (int)get_post_meta($post_id, 'select_safir_product', true)) {
                            $selected = 'selected';
                        } else {
                            $selected = '';
                        }
                        echo "<option style='overflow: hidden!important;max-width: 400px' $selected   value='$product->ID'>$title</option>";
                    }
                    ?>
                </select>
            </fieldset>
        </div>
    <?php
    endif;
}

function safir_products_price($post)
{
    $post_id = $post->ID;
    ?>
    <div>
        <fieldset>
            <label for="el_book_price">قیمت نسخه الکترونیکی</label>
            <input type="number" name="el_book_price" id="el_book_price"
                   value="<?php echo get_post_meta($post_id, 'el_book_price', true) ?>">
        </fieldset>
        <fieldset>
            <label for="pr_book_price">قیمت نسخه چاپی</label>
            <input type="number" name="pr_book_price" id="pr_book_price"
                   value="<?php echo get_post_meta($post_id, 'pr_book_price', true) ?>">
        </fieldset>
    </div>
    <?php
}

add_action('admin_menu', 'add_menu_to_gv_safir_books');

function add_menu_to_gv_safir_books()
{
    add_submenu_page(
        'edit.php?post_type=gv_safir_books',
        'راهنما',
        'راهنما',
        'manage_options',
        'book-guide',
        'arta_book_guide');
}

function arta_book_guide()
{
    if (isset($_POST['arta_book_guide_submit'])) {
        $font = $_FILES['arta_add_font_family'];
        if (!empty($font)) {
            $fileContent = file_get_contents($font['tmp_name']);
            $address = SAFIR_PLUGIN_DIR . ('/lib/book_generator/assets/fonts/');
            file_put_contents($address . $font['name'], $fileContent);
            $last_fonts = get_option('safir_fonts', '[]');
            $last_fonts = json_decode($last_fonts);
            $last_fonts[] = $font['name'];

            $fonts_arr = json_encode(array_unique($last_fonts));
            update_option('safir_fonts', $fonts_arr);
        }
    }
    ?>
    <h1>تنظیمات و راهنما</h1>
    <form action="#" enctype="multipart/form-data" method="post">
        <table class="form-table" role="presentation">
            <tbody>
            <tr>
                <th scope="row"><label for="default_category">شورت کد لینک کتاب</label></th>
                <td>
                    [show-book book_id="10"]
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="default_category">شورت کد مقادیر فرم با عنوان</label></th>
                <td>
                    [ms form_title field_title]
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="default_category">شورت کد مقادیر فرم با id</label></th>
                <td>
                    [ms_id form_id field_id]
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="arta_add_font_family">اضافه کردن فونت</label></th>
                <td>
                    <input type="file" accept=".woff,.woff2,.ttf" id="arta_add_font_family" name="arta_add_font_family">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="submit" name="arta_book_guide_submit" class="button" value="ذخیره">
                </td>
            </tr>
            </tbody>
        </table>
    </form>

    <?php
}

