$(document).ready(function (e) {


    $(document).keydown(function (event) {
        if (event.ctrlKey) {
            if (lock == true) {
                console.log('islock')
                $(".the_image").draggable('enable');
                $(".the_paragraph").draggable('enable');
                lock = false;
                $("#locker_icon").attr("src", plugin_url + "unlock.png");
            } else {
                console.log('is not lock')
                $(".the_image").draggable('disable');
                $(".the_paragraph").draggable('disable');
                lock = true;
                $("#locker_icon").attr("src", plugin_url + "lock.png");
            }
        }
        if ($(':focus').length == 0) {
            if (event.key == "ArrowLeft") {
                if (paragraph != "") {
                    $("#" + paragraph).parent().css("left", "-=5")
                }
                if (image != "") {
                    $("#" + image).css("left", "-=5")
                }
            }

            if (event.key == "ArrowRight") {
                if (paragraph != "") {
                    $("#" + paragraph).parent().css("left", "+=5")
                }
                if (image != "") {
                    $("#" + image).css("left", "+=5")
                }
            }

            if (event.key == "ArrowUp") {
                if (paragraph != "") {
                    $("#" + paragraph).parent().css("top", "-=5")
                }
                if (image != "") {
                    $("#" + image).css("top", "-=5")
                }
            }

            if (event.key == "ArrowDown") {
                if (paragraph != "") {
                    $("#" + paragraph).parent().css("top", "+=5")
                }
                if (image != "") {
                    $("#" + image).css("top", "+=5")
                }
            }
        }
    });
    $("#locker_icon").on("click", function (event) {
        if (lock == true) {
            console.log('islock')
            $(".the_image").draggable('enable');
            $(".the_paragraph").draggable('enable');
            lock = false;
            $("#locker_icon").attr("src", plugin_url + "unlock.png");
        } else {
            console.log('is not lock')
            $(".the_image").draggable('disable');
            $(".the_paragraph").draggable('disable');
            lock = true;
            $("#locker_icon").attr("src", plugin_url + "lock.png");
        }

    });

    let lock = false;
    let bkp_html = "";
    let object = "";
    var paragraph = "";
    let image = "";
    let currentMousePos = {x: -1, y: -1};
    let hexDigits = new Array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f");
    let selected_blob = '';
    preparingPage(e);
    $(document).mousemove(function (event) {
        currentMousePos.x = event.pageX;
        currentMousePos.y = event.pageY;
    });
    $(".tools_container").css("min-height", window.innerHeight + "px");
    //$(".main_container").css("height", window.innerHeight + "px");
    $("#w-height").val($(".main_container").height());
    $("#w-width").val($(".main_container").width());
    $(".main_container").css('overflow', 'hidden');
    $(".tools_container .item").on("dragstart", function (event) {
        object = $(this).attr('data-object');
    });

    $(".main_container").resizable({
        resize: function (event, ui) {
            $("#w-width").val($(".main_container").css('width').replaceAll('px', ''));
            $("#w-height").val($(".main_container").css('height').replaceAll('px', ''));
        }
    });

    $(".main_container").draggable({});

    $(".main_container").on("dragover", function (event) {
        event.preventDefault();
        event.stopPropagation();
        $(this).css({'opacity': '0.8', 'border': 'inset dashed 4px black'});
    });

    $(".main_container").on("dragleave", function (event) {
        event.preventDefault();
        event.stopPropagation();
        $(this).css({'opacity': '1', 'border': 'none'});
    });

    $(".main_container").on("drop", function (event) {
        event.preventDefault();
        event.stopPropagation();
        $(this).css({'opacity': '1', 'border': 'none'});
        createObject(object, event);
    });

    $("#font-color").on("change input", function () {
        $("#" + paragraph).css('color', $(this).val());
    });

    $("#bg-color").on("change input", function () {
        $(".main_container").css('background-color', $(this).val());
    });

    $("#font-size").on("change input", function () {
        $("#" + paragraph).css('font-size', $(this).val() + 'px');
    });

    $("#font-family").on("change", function () {
        $("#" + paragraph).css('font-family', $(this).val());
    });

    $("#z-index").on("change input", function () {
        console.log(paragraph + "," + image)
        if (paragraph != "") {
            $("#" + paragraph).parent().css('z-index', $(this).val());
        }
        if (image != "") {
            $("#" + image).css('z-index', $(this).val());
        }
    });

    $("#line-height").on("change input", function () {
        console.log(paragraph)
        if (paragraph != "") {
            $("#" + paragraph).css('line-height', $(this).val() + "px");
        }
    });

    $("#w-width").on("change input", function () {
        $('.main_container').css("width", $(this).val() + "px");
    });

    $("#w-height").on("change input", function () {
        $('.main_container').css("height", $(this).val() + "px");
    });

    $(".setting_overlayer #add_image_btn").on('click', function (event) {
        let form_name_img = $('#form_name_img').val();
        let field_title_img = $('#field_title_img').val();
        addImageFromGravity(form_name_img, field_title_img, event);
    });

    $(".setting_overlayer #close_image_btn").on('click', function (event) {
        $(".setting_overlayer").hide();
    });

    $("#export_btn").on("click", function () {

    });

    $("#import_btn").on("click", function () {
        $("#import_overlayer").show();
    });

    $("#cancel_import_book_btn").on("click", function (event) {
        $("#import_overlayer").hide();
    });

    $('#upload_image_book_generator').on('input', function () {
        let image = $(this).val();
        readURL(this);
    });

    $('#close_image_gallery').on('click', function () {
        $('.image_gallery_overlayer').hide()
    });

    $('#show_gallery').on('click', function () {
        $.ajax({
            type: 'post',
            url: ajax_url,
            data: {
                "action": 'book_generator_show_image',
            },
            beforeSend: function () {
                $("#show_gallery").prop('disabled', true);
                $('.loading_img_gallery').css('opacity', 1);
            },
            success: function (data) {
                data = JSON.parse(data);
                if (data){
                    $('.gallery_item').remove();
                    data.forEach(function (item) {
                        $('#image_gallery').append('<div style="cursor: pointer" class="gallery_item"><button class="gallery_item_trash"></button>\n' +
                            '            <img  src="' + item + '"\n' +
                            '                 alt="">\n' +
                            '        </div>')

                    });
                    $('.gallery_item img').on('click', function (e) {
                        let src = $(this).attr('src');
                        createImage(e, src);
                    })
                    $('.gallery_item_trash').click(function () {
                        let src = $(this).parent().find('img').attr('src');
                        $(this).parent().remove();
                        $.ajax({
                            type: 'post',
                            url: ajax_url,
                            data: {
                                "action": 'book_generator_delete_image',
                                'src': src
                            },
                            beforeSend: function () {
                                $(".gallery_item_trash").prop('disabled', true);
                            },
                            success: function (data) {
                                console.log(data)
                            },
                            complete: function () {
                                $(".gallery_item_trash").prop('disabled', false);
                            }
                        });
                    })
                }

            },
            complete: function () {
                $("#show_gallery").prop('disabled', false);
                $('.loading_img_gallery').css('opacity', 0);
            }
        });

        $('.image_gallery_overlayer').show();

    });

    $('#fit_to_screen').on('click', function () {
        if (image != '') {
            $('#' + image).css('width', $('#w-width').val());
            $('#' + image).css('height', $('#w-height').val());
            $('#' + image).css('left', '0px');
            $('#' + image).css('top', '0px');

        }
    });

    $('#generate_book_submit_page').on('click', function () {

        $(".move_icon").css('display', 'none');
        $(".close_icon").attr('display', 'none');
        //$("#export_overlayer").show();
        $(".main_container textarea").prop('disabled', true);
        $('.main_container').css('top', 'initial');
        $('.main_container').css('left', 'initial');
        $("#export_overlayer div").text($("#exportable").html().replaceAll('&quot;', "'"));
        $('.main_container').css('transform', 'scale(1,1)');
        savePage();
        //$("#import_overlayer").show();
        //$("#editor").text($("#exportable").html().replaceAll('&quot;', "'"));
        //$("#editor").val($("#exportable").html().replaceAll('&quot;', "'"));

        $(".move_icon").css('display', '');
        $(".close_icon").attr('display', '');
        $(".main_container textarea").prop('disabled', false);
    });

    $('#container_zooming').on('change input', function () {
        let step = $(this).val();
        if (step < 50) {
            $('.main_container').css('transform', 'scale(.9)')
        }
        if (step <= 40) {
            $('.main_container').css('transform', 'scale(.8)')
        }
        if (step <= 30) {
            $('.main_container').css('transform', 'scale(.7)')
        }
        if (step <= 20) {
            $('.main_container').css('transform', 'scale(.6)')
        }
        if (step <= 10) {
            $('.main_container').css('transform', 'scale(.5)')
        }
        if (step == 50) {
            $('.main_container').css('transform', 'unset')
        }
        if (step > 50) {
            $('.main_container').css('transform', 'scale(1.1)')
        }
        if (step >= 60) {
            $('.main_container').css('transform', 'scale(1.2)')
        }
        if (step >= 70) {
            $('.main_container').css('transform', 'scale(1.3)')
        }
        if (step >= 80) {
            $('.main_container').css('transform', 'scale(1.4)')
        }
        if (step >= 90) {
            $('.main_container').css('transform', 'scale(1.5)')
        }

    });

    $('#container_zooming_reset').click(function () {
        $('#container_zooming').val(50);
        $('.main_container').css('transform', 'scale(1,1)')
    })


    ////// Helper Functions

    function createObject(object_name, event) {
        switch (object_name) {
            case 'image': {
                $(".setting_overlayer").show();
                break;
            }
            case 'paragraph_shortcode': {
                createShortcodeParagraph();
                break;
            }
            case 'paragraph': {
                createParagraph(event);
                break;
            }
        }
    }

    function createImage(event, src) {
        let address = src;
        var offset = $(".main_container").offset();
        let id = "image-" + Math.random().toString(16).slice(2)
        $(".main_container").append(`
            <div id="${id}" class="the_image" draggable="true" style="position: absolute;width:200px; z-index: 1; height:100px; left: ${event.pageX - offset.left - 100}px; top: ${event.pageY - offset.top - 60}px; background-image: url('${address}');background-size: 100% 100%"></div>
            `);
        setDraggable($("#" + id));
        if (lock) {
            $("#" + id).draggable('disable');
        }
        $("#" + id).on('contextmenu', function (event) {
            if (!lock) {
                event.preventDefault();
                event.stopPropagation();
                $("#" + id).remove();
            }
        });
        $(".image_gallery_overlayer").hide();
        $(".setting_overlayer").hide();
        $("#" + id).on("click", function () {
            $("#font-color").val("#000000");
            $("#font-size").val("14");
            $("#font-family").val("none");
            $("#z-index").val($("#" + id).css('z-index'));
            paragraph = "";
            image = id;

        });
        $("#z-index").val($("#" + id).css('z-index'));
        paragraph = "";
        image = id;
        return id;
        /**/
    }

    function addImageFromGravity(form_id, field_id, e) {
        let def_image = plugin_url + 'default.png';
        if (form_id != "" && field_id != "") {
            let id = createImage(e, def_image);
            


            $('#' + id).attr('data-src', "[ms_id form_id='"+form_id+"' field_id='"+field_id+"']");
        } else {
            $('#validation_add_image').text('*لطفا موارد بالا را وارد کنید')
        }
    }

    function createShortcodeParagraph() {
        let id = Math.random().toString(16).slice(2);
        $("body").append(`
            <div id="${id}" class="generate_paragraph_shortcode">
                <div class="generate_paragraph_shortcode_box">
                   <img class="close_icon" id="close-${id}" src="${plugin_url}cancel.png" style="float: right;cursor: pointer;margin-bottom: 15px" width="20" />
                   <div class="the_paragraph_shortcode">
                        <div class="select_paragraph_type">
                        <label for="select_paragraph_type_${id}">شرتکد با آی دی</label>
                        <input type="checkbox" id="select_paragraph_type_${id}">
                        </div>
                        <div class="paragraph_inputs">
                           <input type="text" placeholder="نام  فرم" id="shortcode_form_${id}">
                           <input type="text" placeholder="نام عنوان" id="shortcode_title_${id}">
                        </div>
                        <div class="the_paragraph_shortcode_copy">
                        <p id="the_paragraph_shortcode_res"></p>
                        <button type="button" id="the_paragraph_shortcode_copy">کپی شرتکد</button>
                        </div>
                   </div>
                </div>
            </div>
        `);
        $('#select_paragraph_type_' + id).change(function () {
            if (this.checked) {
                $('#shortcode_form_' + id).attr('placeholder', 'آی دی  فرم');
                $('#shortcode_title_' + id).attr('placeholder', 'آی دی  عنوان');
            } else {
                $('#shortcode_form_' + id).attr('placeholder', 'نام  فرم');
                $('#shortcode_title_' + id).attr('placeholder', 'نام عنوان');
            }
        });
        $('#the_paragraph_shortcode_copy').click(function () {

            if ($('#select_paragraph_type_' + id).is(':checked')) {

                let form_id = $('#shortcode_form_' + id).val();
                let title_id = $('#shortcode_title_' + id).val();

                let copy = "[ms_id form_id='" + form_id + "' field_id='" + title_id + "']";
                $('#the_paragraph_shortcode_res').text('');
                $('#the_paragraph_shortcode_res').text(copy)
                copyText(copy);
            } else {
                let form_name = $('#shortcode_form_' + id).val();
                let title_name = $('#shortcode_title_' + id).val();
                let copy = "[ms form_title='" + form_name + "' field_title='" + title_name + "']";
                $('#the_paragraph_shortcode_res').text('');
                $('#the_paragraph_shortcode_res').text(copy);
                copyText(copy);
            }
        });
        $("#close-" + id).on("click", function (event) {
            event.preventDefault();
            event.stopPropagation();
            $("#" + id).remove();
        });
        $("#handler-" + id).on("mousedown", function (event) {
            $("#handler-" + id).css('opacity', '1');
            $("#" + id).removeClass('paragraph_blur');
            event.preventDefault();
        });
    }

    function createParagraph(event) {
        let id = "paragraph-" + Math.random().toString(16).slice(2)
        var offset = $(".main_container").offset();
        $(".main_container").append(`
            <div id="${id}" class="the_paragraph ui-widget-content"  style="position: absolute; z-index:1;min-width: 50px; width: 200px; height: 200px; overflow: hidden;left: ${event.pageX - offset.left - 100}px; top: ${event.pageY - offset.top - 60}px;">
              <p id="handler-${id}" class="ui-widget-header" style="margin: 0 !important; padding: 3px;">
              <img class="move_icon" src="${plugin_url}move.png" width="20" />
               <img class="close_icon" id="close-${id}" src="${plugin_url}cancel.png" style="float: right;cursor: pointer;" width="20" />
              </p>
              <textarea id="textarea-${id}" style="position:absolute;width:100%; z-index: 1; height:85%;  font-size: 14px; font-family: 'none'; line-height: 35px; color: #000000; text-align: right;padding: 10px;border: none; outline: none; background-color: transparent;resize: none; overflow: hidden; direction: rtl;" placeholder="متن خود را وارد کنید و در صورت نیاز شرتکد کپی شده را در جای دلخواه paste کنید"></textarea>
            </div>
        `);
        $("#textarea-" + id).focus();
        $("#textarea-" + id).on("blur", function (event) {
            $("#handler-" + id).css('opacity', '0');
            $("#" + id).addClass('paragraph_blur');
        });
        $("#textarea-" + id).on("focus", function (event) {
            $("#handler-" + id).css('opacity', '1');
            $("#" + id).removeClass('paragraph_blur');
            paragraph = "textarea-" + id;
            $("#font-color").val(rgb2hex($("#textarea-" + id).css('color')));
            $("#font-size").val($("#textarea-" + id).css('font-size').replaceAll('px', ''));
            let font_family = $("#textarea-" + id).css('font-family');
            if (font_family == '') {
                font_family = 'none';
            }
            $("#font-family").val(font_family);
            $("#z-index").val($("#" + id).css('z-index'));
            $("#line-height").val($("#textarea-" + id).css('line-height').replaceAll('px', ''));
            image = "";
        });
        $("#textarea-" + id).on("input", function () {
            $(this).text($(this).val());
        });
        $("#" + id).on("drag", function (event) {
            $("#handler-" + id).css('opacity', '1');
            $("#" + id).removeClass('paragraph_blur');
            $("#textarea-" + id).focus();
        });
        $("#close-" + id).on("click", function (event) {
            event.preventDefault();
            event.stopPropagation();
            $("#" + id).remove();
        });
        $("#handler-" + id).on("mousedown", function (event) {
            $("#handler-" + id).css('opacity', '1');
            $("#" + id).removeClass('paragraph_blur');
            event.preventDefault();
        });


        paragraph = "textarea-" + id;
        image = "";
        $("#font-color").val("#000000");
        $("#font-size").val('14');
        $("#font-family").val('none');
        $("#z-index").val($("#" + id).css('z-index'));
        $("#line-height").val($("#textarea-" + id).css('line-height').replaceAll('px', ''));
        $("#right_box_container").show();
        setDraggable($("#" + id), "p");
        if (lock) {
            $("#" + id).draggable('disable');
        }
    }

    function setDraggable(element, handle = '', cancel = '') {
        $(element).draggable({/*containment: "#main_container",*/ scroll: false, handle: handle, cancel: cancel});
        $(element).resizable({
            /*  containment: "#main_container"*/
        });
    }

    function rgb2hex(rgb) {
        rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
        return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
    }

    function hex(x) {
        return isNaN(x) ? "00" : hexDigits[(x - x % 16) / 16] + hexDigits[x % 16];
    }

    function savePage() {
        // Get the text field
        var copyText = $("#exportable").html().replaceAll('&quot;', "'");
        var page = $.urlParam('page');
        page = decodeURIComponent(page);
        var post = $.urlParam('post');
        post = decodeURIComponent(post);
        $.ajax({
            type: 'post',
            url: ajax_url,
            data: {
                "action": 'book_generator_save_page',
                "html": copyText,
                "page": page,
                "post": post
            },
            beforeSend: function () {
                $("#generate_book_submit_page").prop('disabled', true);
                $('body').css('cursor', 'progress');
                $("#generate_book_submit_page").css('cursor', 'progress');
                $('#container_zooming').val(50);
                $('.save_image_loading_overlayer').show()

            },
            success: function (data) {
                alert('ویرایش صفحه با موفقیت انجام شد')
            },
            complete: function () {
                $("#generate_book_submit_page").prop('disabled', false);
                $('body').css('cursor', 'default');
                $("#generate_book_submit_page").css('cursor', 'default');
                $('.save_image_loading_overlayer').hide()

            }
        });
    }

    function prepareWorkspace() {
        $(".main_container").resizable({
            resize: function (event, ui) {
                $("#w-width").val($(".main_container").css('width').replaceAll('px', ''));
                $("#w-height").val($(".main_container").css('height').replaceAll('px', ''));
            }
        });
        $(".main_container").draggable();
        $(".main_container").on("dragover", function (event) {
            event.preventDefault();
            event.stopPropagation();
            $(this).css({'opacity': '0.8', 'border': 'inset dashed 4px black', 'transform': 'scale(0.9,0.9)'});
        });
        $(".main_container").on("dragleave", function (event) {
            event.preventDefault();
            event.stopPropagation();
            $(this).css({'opacity': '1', 'border': 'none', 'transform': 'scale(1,1)'});
        });
        $(".main_container").on("drop", function (event) {
            event.preventDefault();
            event.stopPropagation();
            $(this).css({'opacity': '1', 'border': 'none', 'transform': 'scale(1,1)'});
            //createObject(object, event);
        });
        $(".main_container").on("click", function (event) {

        });
    }

    function resetDragAndResizeImages() {
        $(".main_container .the_image").each(function (event) {
            setDraggable($(this));
            $(this).on('contextmenu', function (event) {
                event.preventDefault();
                event.stopPropagation();
                $(this).remove();
            });
            $(".setting_overlayer").hide();
            $(this).on("click", function () {
                $("#font-color").val("#000000");
                $("#font-size").val("14");
                $("#font-family").val("none");
                $("#z-index").val($(this).css('z-index'));
                paragraph = "";
                image = $(this).attr("id");
            });
            $("#z-index").val($(this).css('z-index'));
            paragraph = "";
            image = $(this).attr("id");
        });
    }

    function resetDragAndResizeParagraphs() {
        $(".main_container .the_paragraph").each(function () {
            let id = $(this).attr('id');
            $("#textarea-" + id).focus();
            $("#textarea-" + id).on("blur", function (event) {
                $("#handler-" + id).css('opacity', '0');
                $("#" + id).addClass('paragraph_blur');
            });
            $("#textarea-" + id).on("focus", function (event) {
                $("#handler-" + id).css('opacity', '1');
                $("#" + id).removeClass('paragraph_blur');
                paragraph = "textarea-" + id;
                $("#font-color").val(rgb2hex($("#textarea-" + id).css('color')));
                $("#font-size").val($("#textarea-" + id).css('font-size').replaceAll('px', ''));
                let font_family = $("#textarea-" + id).css('font-family');
                if (font_family == '') {
                    font_family = 'none';
                }
                $("#font-family").val(font_family);
                $("#z-index").val($("#" + id).css('z-index'));
                $("#line-height").val($("#textarea-" + id).css('line-height').replaceAll('px', ''));
                image = "";
            });
            $("#textarea-" + id).on("input", function () {
                $(this).text($(this).val());
            });
            $("#" + id).on("drag", function (event) {
                $("#handler-" + id).css('opacity', '1');
                $("#" + id).removeClass('paragraph_blur');
                $("#textarea-" + id).focus();
            });
            $("#close-" + id).on("click", function (event) {
                event.preventDefault();
                event.stopPropagation();
                $("#" + id).remove();
            });
            $("#handler-" + id).on("mousedown", function (event) {
                $("#handler-" + id).css('opacity', '1');
                $("#" + id).removeClass('paragraph_blur');
                event.preventDefault();
            });
            paragraph = "textarea-" + id;
            image = "";
            $("#font-color").val("#000000");
            $("#font-size").val('14');
            $("#font-family").val('none');
            $("#z-index").val($("#" + id).css('z-index'));
            $("#line-height").val($("#textarea-" + id).css('line-height').replaceAll('px', ''));
            $("#right_box_container").show();
            setDraggable($("#" + id), "p");
        });
    }

    function readURL(input) {
        if (input.files) {
            var reader = new FileReader();
            reader.onload = function (e) {
                readUrlCallback(e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function readUrlCallback(res) {
        $.ajax({
            type: 'post',
            url: ajax_url,
            data: {
                "action": 'book_generator_save_image',
                "url": res
            },
            beforeSend: function () {
                $("#upload_image_book_generator").prop('disabled', true);
                $(".save_image_loading_overlayer").show();

            },
            success: function (data) {
                alert('تصویر  با موفقیت در رسانه ها بارگذاری شد')
                $('#upload_image_book_generator').val('')
            },
            complete: function () {
                $("#upload_image_book_generator").prop('disabled', false);
                $(".save_image_loading_overlayer").hide();
            }
        });
    }

    $.urlParam = function (name) {
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        return results[1] || 0;
    }

    function preparingPage(event) {
        prepareWorkspace();
        resetDragAndResizeImages();
        resetDragAndResizeParagraphs(event);
        $(".move_icon").css('display', '');
        $(".close_icon").attr('display', '');
        $(".main_container textarea").prop('disabled', false);
    }

    function copyText(myInput) {
        // Get the text field
        var copyText = myInput;

        // Copy the text inside the text field
        navigator.clipboard.writeText(copyText);
        // Alert the copied text
        alert("شرتکد کپی شد برای استفاده، در جای مناسب paste کنید");
    }
});
