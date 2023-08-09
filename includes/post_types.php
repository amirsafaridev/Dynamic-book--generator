<?php
function cptui_register_gv_safir_book() {

    /**
     * Post Type: کتاب ها.
     */

    $labels = [
        "name" => __( "کتاب ها", "twentytwentytwo" ),
        "singular_name" => __( "کتاب", "twentytwentytwo" ),
        "menu_name" => __( "کتاب ها من", "twentytwentytwo" ),
        "all_items" => __( "همه کتاب ها", "twentytwentytwo" ),
        "add_new" => __( "افزودن", "twentytwentytwo" ),
        "add_new_item" => __( "افزودن کتاب جدید", "twentytwentytwo" ),
        "edit_item" => __( "ویرایش کتاب", "twentytwentytwo" ),
        "new_item" => __( "کتاب جدید", "twentytwentytwo" ),
        "view_item" => __( "مشاهده کتاب", "twentytwentytwo" ),
        "view_items" => __( "مشاهده کتاب ها", "twentytwentytwo" ),
        "search_items" => __( "جستجوی کتاب ها", "twentytwentytwo" ),
        "not_found" => __( "هیچ کتاب ها پیدا نشد", "twentytwentytwo" ),
        "not_found_in_trash" => __( "No کتاب ها found in trash.", "twentytwentytwo" ),
        "parent" => __( "والد کتاب:", "twentytwentytwo" ),
        "featured_image" => __( "تصویر شاخص برای کتاب", "twentytwentytwo" ),
        "set_featured_image" => __( "تنظیم تصویر شاخص برای کتاب", "twentytwentytwo" ),
        "remove_featured_image" => __( "حذف تصویر شاخص برای کتاب", "twentytwentytwo" ),
        "use_featured_image" => __( "استفاده به عنوان تصویر شاخص برای کتاب", "twentytwentytwo" ),
        "archives" => __( "آرشیو کتاب", "twentytwentytwo" ),
        "insert_into_item" => __( "درج در کتاب", "twentytwentytwo" ),
        "uploaded_to_this_item" => __( "آپلود در کتاب", "twentytwentytwo" ),
        "filter_items_list" => __( "لیست فیلتر کتاب ها", "twentytwentytwo" ),
        "items_list_navigation" => __( "ناوبری لیست کتاب ها", "twentytwentytwo" ),
        "items_list" => __( "لیست کتاب ها", "twentytwentytwo" ),
        "attributes" => __( "ویژگی های کتاب ها", "twentytwentytwo" ),
        "name_admin_bar" => __( "کتاب", "twentytwentytwo" ),
        "item_published" => __( "کتاب منتشر شد", "twentytwentytwo" ),
        "item_published_privately" => __( "کتاب به صورت خصوصی منتشر شد.", "twentytwentytwo" ),
        "item_reverted_to_draft" => __( "کتاب به پیش نویس بازگشت.", "twentytwentytwo" ),
        "item_scheduled" => __( "کتاب زمانبندی شد", "twentytwentytwo" ),
        "item_updated" => __( "کتاب به‌روزرسانی شد.", "twentytwentytwo" ),
        "parent_item_colon" => __( "والد کتاب:", "twentytwentytwo" ),
    ];

    $args = [
        "label" => __( "کتاب ها", "twentytwentytwo" ),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "rest_namespace" => "wp/v2",
        "has_archive" => false,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "delete_with_user" => false,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "can_export" => false,
        "rewrite" => [ "slug" => "gv_safir_books", "with_front" => true ],
        "query_var" => true,
        "supports" => [ "title", ],
        "show_in_graphql" => false,
    ];

    register_post_type( "gv_safir_books", $args );
}

add_action( 'init', 'cptui_register_gv_safir_book' );