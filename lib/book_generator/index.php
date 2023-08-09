<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Book Generator</title>
    <link rel="stylesheet" href="<?php echo plugins_url('arta_safir/lib/book_generator/assets/css/jquery-ui.css') ?>">
    <link href="<?php echo plugins_url('arta_safir/lib/book_generator/assets/css/css.css') ?>" rel="stylesheet"
          type="text/css">
    <script src="<?php echo plugins_url('arta_safir/lib/book_generator/assets/js/jquery.js') ?>"></script>
    <script src="<?php echo plugins_url('arta_safir/lib/book_generator/assets/js/jquery-ui.js') ?>"></script>
    <script src="<?php echo plugins_url('arta_safir/lib/book_generator/assets/js/js.js') ?>"></script>
    <style>
        <?php
        $fonts = get_option('safir_fonts',[]);
        $fonts = json_decode($fonts);
        foreach ($fonts as $font){
            $font1 = explode('.',$font,'2');
            $font1=$font1[0];
            ?>
        @font-face {
            font-family:<?php echo $font1?>;
            src: url(<?php echo plugins_url('/arta_safir/lib/book_generator/assets/fonts/'.$font)?>);
        }

        <?php
        }
        ?>
    </style>
</head>
<body>
<script>
    var plugin_url = '<?php echo plugins_url('arta_safir/lib/book_generator/assets/images/')?>';
    var ajax_url = '<?php echo admin_url('admin-ajax.php')?>';
</script>

<div id="container" style="display: flex;">
    <div class="tools_container">
        <div class="item" data-object="image">
            <label style="cursor: pointer" for="upload_image_book_generator">
                <img src="<?php echo plugins_url('arta_safir/lib/book_generator/assets/images/upload.png') ?>">
                <input style="opacity: 0" accept="image/jpeg, image/png" type="file" name="upload_image_book_generator"
                       id="upload_image_book_generator">
            </label>
            <span class="tooltiptext">بارگزاری تصویر</span>
        </div>
        <div class="item" id="show_gallery" data-object="gallery" draggable="true">
            <img src="<?php echo plugins_url('arta_safir/lib/book_generator/assets/images/gallery.png') ?>">
            <span class="tooltiptext">تصاویر بارگزاری شده</span>
        </div>

        <div class="item" data-object="image" draggable="true">
            <img src="<?php echo plugins_url('arta_safir/lib/book_generator/assets/images/import.png') ?>">
            <span class="tooltiptext">درون ریزی تصویر با شرتکد</span>
        </div>

        <div class="item" data-object="paragraph_shortcode">
            <img src="<?php echo plugins_url('arta_safir/lib/book_generator/assets/images/brackets.png') ?>">
            <span class="tooltiptext">درون ریزی متن با شرتکد</span>
        </div>

        <div class="item" data-object="paragraph" draggable="true">
            <img src="<?php echo plugins_url('arta_safir/lib/book_generator/assets/images/textbox.png') ?>">
            <span class="tooltiptext">ایجاد متن</span>
        </div>
        <div class="item">
            <button type="button" id="generate_book_submit_page"
                    style="background: url('<?php echo plugins_url('arta_safir/lib/book_generator/assets/images/save.png') ?>');background-size: 100%;"></button>
            <span class="tooltiptext">ذخیره</span>
        </div>
        <div class="lock" data-object="paragraph" draggable="true">
            <img id="locker_icon" width="50%"
                 src="<?php echo plugins_url('arta_safir/lib/book_generator/assets/images/unlock.png') ?>"
                 style="position: relative">
            <span class="locktooltiptext">قفل/باز</span>
        </div>
    </div>
    <div id="exportable" style="margin: auto;">
        <?php
        $post_id = $_GET['post'];
        $page = $_GET['page'];
        $content = get_post_meta($post_id, $page, true);

        if (empty($content)) {
            ?>
            <div class="main_container" id="main_container"
                 style="overflow: hidden;width: <?php echo get_post_meta($post_id, 'w_safir_book', true) . 'px'; ?>;height: <?php echo get_post_meta($post_id, 'h_safir_book', true) . 'px'; ?>;"></div>
        <?php } else {
            echo $content;
        } ?>
    </div>

    <div class="tools_container" id="right_box_container"
         style="width: 130px;direction: rtl;padding: 15px; right: 0;overflow-y: scroll;">
        <div class="right_box_label">رنگ زمینه :</div>
        <input type="color" id="bg-color" value="#ffffff" class="right_box_input_number">
        <div class="right_box_label">اندازه فونت (px) :</div>
        <input type="number" id="font-size" class="right_box_input_number">
        <div class="right_box_label">تغییر فونت :</div>
        <select id="font-family"
                style="width: 100%; border-radius: 6px;height: 30px;margin-top: 5px;margin-bottom: 15px;">
            <option value="none">پیش فرض</option>
            <?php
            $fonts = get_option('safir_fonts',[]);
            $fonts = json_decode($fonts);
            foreach ($fonts as $font){
                $font = explode('.',$font,'2');
                $font=$font[0];
                ?>
                <option value="<?php echo $font?>"><?php echo $font?></option>
                <?php
            }
            ?>
        </select>
        <div class="right_box_label">رنگ متن :</div>
        <input type="color" id="font-color" class="right_box_input_number">
        <div class="right_box_label">فاصله خطوط (px) :</div>
        <input type="number" id="line-height" class="right_box_input_number">
        <div class="right_box_label">اولویت لایه :</div>
        <input type="number" id="z-index" class="right_box_input_number">
        <div class="right_box_label">عرض محیط :</div>
        <input type="number" max="9999999999" id="w-width" class="right_box_input_number" value="547">
        <div class="right_box_label">ارتفاع محیط :</div>
        <input type="number" max="9999999999" id="w-height" class="right_box_input_number" value="724">

        <button style="font-family: 'IranSansNormal';
    border: none;
    background: #ff1717;
    width: inherit;
    border-radius: 5px;
    padding: 5px;
    color: #FFF;cursor: pointer" type="button" id="fit_to_screen">جایگذاری خودکار
        </button>
    </div>
</div>
<div class="setting_overlayer">
    <div class="url_box">
        <div>
            کد تصویر را وارد کنید
        </div>
        <input type="text" id="form_name_img"
               value="" placeholder="شناسه فرم">
        <input type="text" id="field_title_img"
               value="" placeholder="شناسه فیلد">
        <button class="add_image_btn" id="add_image_btn">افزودن تصویر</button>
        <button class="add_image_btn" id="close_image_btn" style="background-color: #eb4646;">انصراف</button>
        <p style="color: red;font-size: 10px;font-family: IranSansNormal" id="validation_add_image"></p>
    </div>
</div>
<div id="import_overlayer"
     style="position: fixed;top: 0;left:0;background-color: rgba(37,37,37,0.55);width: 100%;height: 100%;display: none;z-index: 1000;">
    <textarea id="editor" style=""></textarea>
    <div style="
    position: absolute;
    margin: auto;
    left: 0;
    right: 0;
bottom: 0;">
        <button class="import_book_btn" id="import_book_btn" style="left: 177px;">درون ریزی کتاب</button>
        <button class="import_book_btn" id="cancel_import_book_btn" style="background-color: #eb4646;left: -253px;">
            بستن
        </button>
    </div>

</div>
<div style="display: none" class="image_gallery_overlayer">
    <div id="image_gallery">
        <button class="import_book_btn" id="close_image_gallery"
                style="z-index:100;background-color: #eb4646;position: fixed;bottom: 60px">
            بستن
        </button>
        <div style="opacity: 0" class="loading_img_gallery"></div>
    </div>
</div>
<div style="display:none" class="save_image_loading_overlayer">
    <div class="save_image_loading"></div>
</div>
<div class="container_zooming">
    <div> -</div>
    <input type="range" step="10" id="container_zooming">
    <div> +</div>
    <div id="container_zooming_reset"></div>
</div>
</body>
</html>



