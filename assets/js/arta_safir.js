jQuery(document).ready(function () {
    var x = jQuery('#safir_page_count').val();
    jQuery('#add_new_page_safir_book').on('click', function () {
        x++;
        jQuery('#safir_book_pages').append('<div class="safir_book_pages_item" page="page_' + x + '"><div class="title">صفحه ' + x + '</div><input name="safir_page[]" type="hidden" value="صفحه ' + x + '"><div style="display: none" class="edit"><a href="">ویرایش</a></div></div>');
        jQuery('#safir_page_count').val(x)
    });

    jQuery('#safir_delete_book_pages_item').click(function () {
        var post_id = jQuery(this).attr('post_id');
        jQuery.ajax({
            type: 'post',
            url:safir_object.ajaxurl,
            data: {
                "action": 'safir_delete_book_pages_item',
                "post_id": post_id
            },
            beforeSend: function () {
                jQuery("#safir_delete_book_pages_item").prop('disabled', true);
            },
            success: function (data) {
                jQuery('.safir_book_pages_item:last-child').remove()
            },
            complete: function () {
                jQuery("#safir_delete_book_pages_item").prop('disabled', false);
            }
        });
    })
})