$(document).ready(function (e) {
var type = '';

    $('#book_add_to_cart').click(function () {
        let product_id = $(this).attr('product_id');
        let book_id = $(this).attr('book_id');
        if ($('.book_type input[name=book_price]').is(":checked")){
            let price = $('.book_type input[name=book_price]').val();
            let book_type =type;
           
            $.ajax({
                type: 'post',
                url: ajax_url,
                data: {
                    "action": 'safir_book_add_to_cart',
                    "product_id": product_id,
                    'price':price,
                    "book_type":book_type,
                    'book_id':book_id
                },
                beforeSend: function () {
                    $("#book_add_to_cart").prop('disabled', true);
                },
                success: function (data) {
                    console.log(data);
                    createCookie('book_id_for_buy',book_id,10)
                   window.location.href = data
                },
                complete: function () {
                    $("#book_add_to_cart").prop('disabled', false);
                }
            });
        }else {
            $('.book_type').show();
        }

    });

    function replaceImageFromGravity() {
        $('.the_image').each(function () {
            let src = $(this).attr('data-src');
            let id = $(this).attr('id');
            if (typeof src != "undefined") {
                $(this).css('background-image', 'url(' + src + ')');
            }
        })

    }
   replaceImageFromGravity();

    $('.book_type .pr_book').click(function (){
        $('.book_type .el_book').css('border',0)
        $(this).css('border','2px solid red');
        $(this).parent().hide();
        $("#book_add_to_cart #buy_book_text").text('خرید نسخه چاپی');
        $("#book_add_to_cart").css('width','124px');
        $("#show_book_type").css('left','172px');
        $('#loader').show();
        $('.loader_text').text('درحال انتقال به سبد خرید')
         $('#book_add_to_cart').click();
         type = 'printed'
    });

    $('.book_type .el_book').click(function (){
        $('.book_type .pr_book').css('border',0)
        $(this).css('border','2px solid red');
        $(this).parent().hide();
        $("#book_add_to_cart #buy_book_text").text('خرید نسخه الکترونیکی');
        $("#book_add_to_cart").css('width','149px');
        $("#show_book_type").css('left','196px');
        $('#loader').show();
        $('.loader_text').text('درحال انتقال به سبد خرید');
          $('#book_add_to_cart').click();
          type = 'elect';
    });

    $('#show_book_type').click(function (){
        $('.book_type').toggle();
    });

    function createCookie(name, value, days) {
        var expires;

        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toGMTString();
        } else {
            expires = "";
        }
        document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
    }
});
