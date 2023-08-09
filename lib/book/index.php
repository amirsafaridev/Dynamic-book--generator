<html>
<!-- Mirrored from business-flipbook-jquery-plugin.flashmaniac.net/index.php by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 29 Nov 2022 14:55:44 GMT -->
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <meta content="width=device-width,initial-scale=1" name="viewport">
    <!-- title -->
    <title>Madaransafir | book </title>
    <!-- BEGIN CSS AND SCRIPT -->
    <link type="text/css" href="<?php echo plugin_dir_url(__DIR__) . '/book/css/style.css' ?>" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Play:400,700">
    <script src="<?php echo plugin_dir_url(__DIR__) . '/book/js/jquery.js' ?>"></script>
    <script src="<?php echo plugin_dir_url(__DIR__) . '/book/js/turn.js' ?>"></script>
    <script src="<?php echo plugin_dir_url(__DIR__) . '/book/js/jquery.fullscreen.js' ?>"></script>
    <script src="<?php echo plugin_dir_url(__DIR__) . '/book/js/jquery.address-1.6.min.js' ?>"></script>
    <script src="<?php echo plugin_dir_url(__DIR__) . '/book/js/onload.js' ?>"></script>
    <script src="<?php echo plugin_dir_url(__DIR__) . '/book/js/arta.js' ?>"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>

    <!-- BEGIN CSS  -->
    <style>
        html, body {
            margin: 0;
            padding: 0;
            overflow: auto !important;
        }

        @font-face {
            font-family: IranSansBold;
            src: url('<?php echo plugin_dir_url(__DIR__). "/book/fonts/iran_sans2.woff2"; ?>');
            font-weight: bold;
        }

        @font-face {
            font-family: IranSansNormal;
            src: url('<?php echo plugin_dir_url(__DIR__). "/book/fonts/iran_sans1.woff2"; ?>');
            font-weight: bold;
        }

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
    <!-- END CSS  -->

</head>

<body>

<script>
    var ajax_url = '<?php echo admin_url('admin-ajax.php')?>';
</script>
<?php

if (isset($_GET['book_id'])) {
    if (is_user_logged_in()) {
        $book_id = intval($_GET['book_id']);
        $safir_page_lists = get_post_meta($book_id, 'safir_page_list', true);
        $product = intval(get_post_meta($book_id, 'select_safir_product', true));

        $pages = array();
        foreach ($safir_page_lists as $page_list) {
            $pages[] = get_post_meta($book_id, $page_list, true);
        }

        ?>
        <!-- BEGIN FLIPBOOK STRUCTURE -->
        <div data-template="true" data-cat="book6" id="fb6-ajax">
            <!-- BEGIN HTML BOOK -->
            <div data-current="book6" class="fb6" id="fb6">
                <!-- preloader -->
                <div class="fb6-preloader">
                    <div id="wBall_1" class="wBall">
                        <div class="wInnerBall">
                        </div>
                    </div>
                    <div id="wBall_2" class="wBall">
                        <div class="wInnerBall">
                        </div>
                    </div>
                    <div id="wBall_3" class="wBall">
                        <div class="wInnerBall">
                        </div>
                    </div>
                    <div id="wBall_4" class="wBall">
                        <div class="wInnerBall">
                        </div>
                    </div>
                    <div id="wBall_5" class="wBall">
                        <div class="wInnerBall">
                        </div>
                    </div>
                </div>


                <!-- back button -->
                <!--                <a href="http://www.preview.flashmaniac.net/jquery_flipbook_v6_wp" id="fb6-button-back">&lt; Back</a>-->

                <!-- background for book -->
                <div class="fb6-bcg-book"></div>


                <!-- BEGIN CONTAINER BOOK -->
                <div id="fb6-container-book">

                    <!-- BEGIN deep linking -->
                    <section id="fb6-deeplinking">
                        <ul>
                            <?php
                            $c = 1;
                            foreach ($pages as $page) {
                                echo ' <li data-address="page' . $c . '" data-page="' . $c . '"></li>';
                                $c++;
                            } ?>
                            <?php if (count($pages) % 2 != 0) : ?>
                                <li data-address="page<?php echo $c ?>" data-page="<?php echo $c ?>"></li>
                            <?php endif; ?>
                        </ul>
                    </section>
                    <!-- END deep linking -->


                    <!-- BEGIN ABOUT -->
                    <!-- <section id="fb6-about">
                         <h1>Sed vel nulla augue.</h1>
                         <p>Nulla congue pulvinar pharetra. Cras sed malesuada arcu. Duis eleifend nunc laoreet odio dapibus ac
                             convallis sapien ornare. Nullam a est id diam elementum rhoncus.Te amet disputando vel. Cu vim
                             persius consequat consetetur, eam id melius fuisset principes. Eos mutat luptatum ad. Ad <a
                                     href="javascript:setPage(2)">iudico</a> repudiandae nec, mel an tempor accusata eloquentiam,
                             choro forensibus et eam.</p>
                         <p>&nbsp;</p>
                         <h1>Sed vel nulla augue.</h1>
                         <p>Nulla congue pulvinar pharetra. Cras sed malesuada arcu. Duis eleifend nunc laoreet odio dapibus ac
                             convallis sapien ornare. Nullam a est id diam elementum rhoncus.Te amet disputando vel. Cu vim
                             persius consequat consetetur, eam id melius fuisset principes. Clita habemus et vix, ius doming
                             philosophia et. Eos mutat luptatum ad. Ad iudico repudiandae nec, mel an tempor accusata
                             eloquentiam, choro forensibus et eam.</p>
                         <p>&nbsp;</p>
                         <p>&nbsp;</p>
                         <p><a href="javascript:setPage(2)"><img width="136" height="180" src="img/start_browsing.png"
                                                                 alt="start_browsing" class=" wp-image-28 aligncenter"></a></p>
                         <p>&nbsp;</p>
                     </section>-->
                    <!-- END ABOUT -->

                    <!-- BEGIN PAGES -->
                    <div id="fb6-book">
                        <?php
                        $count = 1;

                        foreach ($pages as $page) {

                            ?>
                            <!-- BEGIN PAGE 1-->
                            <div class="my_pages" id="my_page_<?php echo $count ?>">
                                <!-- container page book -->
                                <div class="fb6-cont-page-book">
                                    <!-- description for page -->
                                    <div style="width: 100%!important;height: 100%!important;left: 0!important;right: 0!important;"
                                         class="fb6-page-book">
                                        <div style="text-align: right;height: -webkit-fill-available;"
                                             class="custom_div">
                                            <?php
                                            $page = apply_filters('the_content', $page);
                                            echo preg_replace('/&nbsp;|<br \/>/i', '', $page);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- end container page book -->
                            </div>
                            <!-- END PAGE 1-->
                            <?php
                            $count++;
                        }
                        if (count($pages) % 2 != 0) {
                            ?>
                            <div class="my_pages" id="my_page_<?php echo $count ?>"
                                 style="background-color: #ffffff">
                                <!-- container page book -->
                                <div class="fb6-cont-page-book">
                                    <!-- description for page -->
                                    <div class="fb6-page-book">
                                    </div>
                                </div>
                                <!-- end container page book -->
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <!-- END PAGES -->


                    <!-- arrows -->
                    <a class="fb6-nav-arrow prev"></a>
                    <a class="fb6-nav-arrow next"></a>


                    <div class="fb6-shadow"></div>

                </div>
                <!-- END CONTAINER BOOK  -->


                <!-- BEGIN FOOTER -->
                <div id="fb6-footer">

                    <div class="fb6-bcg-tools"></div>

                    <a id="fb6-logo" target="_blank"
                       href="http://codecanyon.net/collections/3966328-flipbooks-plugins-for-wordpress-jquery">

                    </a>

                    <div style="display: flex;
    align-items: center;" class="fb6-menu" id="fb6-center">
                        <?php

                        ?>
                        <ul>
                            <!-- icon download -->

                            <!-- -->


                            <!-- icon_zoom_in -->
                            <li>
                                <a title="کوچکنمایی" class="fb6-zoom-in"></a>
                            </li>

                            <!-- icon_zoom_out -->
                            <li>
                                <a title="بزرگنمایی" class="fb6-zoom-out"></a>
                            </li>


                            <!-- icon_zoom_auto -->
                            <li>
                                <a title="بزرگ نمایی خودکار" class="fb6-zoom-auto"></a>
                            </li>


                            <!-- icon_zoom_original -->
                            <li>
                                <a title="لغو بزرگنمایی" class="fb6-zoom-original"></a>
                            </li>


                            <!-- icon_allpages -->
                            <li>
                                <a title="نمایش همه صفحات" class="fb6-show-all"></a>
                            </li>


                            <!-- icon_home -->
                            <li>
                                <a title="نمایش صفحه اول" class="fb6-home"></a>
                            </li>

                            <!-- icon fullscreen -->
                            <li>
                                <a title="تمام صفحه" class="fb6-fullscreen"></a>
                            </li>

                        </ul>

                    </div>
                    <?php
                    $sold = getProductUserSell();
                    if (!empty($product)) :
                        if (!in_array($product, $sold)) {
                            $el_price = get_post_meta($book_id, 'el_book_price', true);
                            $pr_price = get_post_meta($book_id, 'pr_book_price', true);
                            ?>
                            <div class="book_add_to_cart">
                                <div style="display: none" class="book_type">
                                    <label class="el_book" for="el_book_price">
                                        <br>خرید نسخه الکترونیکی غیر قابل چاپ
                                        <div style="text-align: center;font-size: 25px;font-family: IranSansBold">
                                            <?php echo number_format($el_price) . " تومان " ?>
                                        </div>
                                        <input style="display: none" type="radio" name="book_price" book_type="elect"
                                               id="el_book_price" value="<?php echo $el_price ?>">
                                    </label>
                                    <label for="pr_book_price" class="pr_book">
                                        <br> خرید نسخه چاپی
                                        <div style="text-align: center;font-size: 25px;font-family: IranSansBold">
                                            <?php echo number_format($pr_price) . " تومان " ?>
                                        </div>
                                        <input style="display: none" type="radio" id="pr_book_price" book_type="printed"
                                               name="book_price" value="<?php echo $pr_price ?>">
                                    </label>
                                </div>
                                <div>
                                    <botton type="button" id="book_add_to_cart" product_id="<?php echo $product; ?>"
                                            book_id="<?php echo $_GET['book_id'] ?>"
                                    <i></i>
                                    <span id="buy_book_text">خرید کتاب</span>
                                    </botton>
                                    <button type="button" id="show_book_type"><i></i></button>
                                </div>
                            </div>
                            <?php
                        } elseif (in_array($product, $sold) || is_admin()) {
                            ?>
                            <div>
                                <a style="font-size: 18px;
    color: #fff;
    background: #0096ff;
    font-family: 'IranSansBold';
    padding: 10px;
    border-radius: 5px;position: absolute;
    top: 7px;
    left: 10px;" title="دانلود فایل PDF" class="fb6-download"
                                   href="javascript:startPDF('<?php echo count($pages); ?>')">دانلود کتاب</a>
                            </div>
                            <?php
                        }
                    endif; ?>
                    <div class="fb6-menu" id="fb6-right">
                        <ul>
                            <!-- icon page manager -->
                            <li class="fb6-goto">
                                <label for="fb6-page-number" id="fb6-label-page-number"></label>
                                <input type="text" id="fb6-page-number" placeholder="صفحه">
                                <button type="button">برو</button>
                            </li>
                        </ul>
                    </div>

                </div>
                <!-- END FOOTER -->


                <!-- BEGIN ALL PAGES -->
                <div id="fb6-all-pages" class="fb6-overlay">

                    <section class="fb6-container-pages">

                    </section>

                </div>
                <!-- END ALL PAGES -->


            </div>
            <!-- END HTML BOOK -->
        </div>
        <div class="static_main_container" style="width: 100%;position:relative;">
            <?php
            $count = 1;
            foreach ($pages as $page) {
                echo "<div id='" . $count . "' style='position : fixed ; left : -500%'>";
                echo "<div class='copy_pages' id='copy_page_$count' style='display: block;width:max-content'>";
                $page = apply_filters('the_content', $page);
                echo preg_replace('/&nbsp;|<br \/>/i', '', $page);
                echo "</div>";
                echo "</div>";

                $count++;
            }
            ?>
        </div>

        <script>

            jQuery('#fb6-ajax').data('config',
                {
                    "page_width": "<?php echo get_post_meta($book_id, 'w_safir_book', true);?>",
                    "page_height": "<?php echo get_post_meta($book_id, 'h_safir_book', true);?>",
                    "go_to_page": "صفحه",
                    "gotopage_width": "100",
                    "zoom_double_click": "1",
                    "zoom_step": "0.06",
                    "tooltip_visible": "true",
                    "toolbar_visible": "true",
                    "deeplinking_enabled": "true",
                    "double_click_enabled": "true",
                    "rtl": "true"
                })
        </script>
        <script>

            function startPDF(count) {
                jQuery('.main_container').attr('id', 'main_container' + getRandomInt(150, 5200))
                jQuery('textarea').css('max-width', function () {
                    return "300px";
                });
                jQuery('textarea').replaceWith(function () {
                    jQuery(this).css({'width': jQuery(this).parent().css('width'), 'padding': 'unset'});
                    let styles = jQuery(this).attr('style');
                    let content = jQuery(this).text().replaceAll('\n', '<br>');
                    return `<p style='${styles}'>${content}</p>`;
                });
                jQuery("#loader").show();
                jQuery('.turn-page-wrapper').css('display', 'unset');
                jQuery(jQuery(".copy_pages").get().reverse()).each(function () {
                    let id = jQuery(this).attr("id");
                    appendCanvas(id);
                });
                export_book_pdf(count);
            }

            function sleep(ms) {
                return new Promise(resolve => setTimeout(resolve, ms));
            }

            async function appendCanvas(id) {
                await html2canvas(document.querySelector('#' + id)).then(canvas => {
                    jQuery(canvas).addClass('canvas_list');
                    jQuery(canvas).attr('id', 'canvas_' + id);
                    document.body.appendChild(canvas);
                });

                $('.static_main_container').remove()
            }

            function addScript(url) {
                var script = document.createElement('script');
                script.type = 'application/javascript';
                script.src = url;
                document.head.appendChild(script);
            }

            function export_book_pdf(count) {

                addScript('https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js');

                let interval = setInterval(function () {
                    if (jQuery('.canvas_list').length == count) {
                        clearInterval(interval);
                        setTimeout(function () {
                            let sample_canvas = jQuery("#canvas_copy_page_1");
                            let canvas_width = 3 / 4 * sample_canvas.width();
                            let canvas_height = 3 / 4 * sample_canvas.height();
                            console.log(sample_canvas.width(), sample_canvas.height());
                            let orientation = 'p'
                            if ((sample_canvas.width() / sample_canvas.height()) > 1) {
                                orientation = 'l'
                            }
                            console.log(sample_canvas.width() / sample_canvas.height())
                            doc = new jsPDF({
                                orientation: orientation,
                                unit: 'pt',
                                format: [canvas_width, canvas_height]
                            });
                            for (let i = 1; i <= count; i++) {
                                let canvas = document.querySelector('#canvas_copy_page_' + i);
                                let canvas_base64 = canvas.toDataURL("image/png")
                                if (canvas_base64.length >= 100) {
                                    doc.addImage(canvas_base64, 'PNG', 0, 0, canvas_width, canvas_height);
                                    if(i<count){
                                       doc.addPage();
                                    }
                                }
                                console.log("add page "+i);
                            }
                            doc.save('book.pdf');
                            jQuery(".canvas_list").remove();
                            location.reload();
                        }, 10000);
                    }
                }, 1000);
            }

            function getRandomInt(min, max) {
                min = Math.ceil(min);
                max = Math.floor(max);
                return Math.floor(Math.random() * (max - min + 1)) + min;
            }

            //////////////////// pdf maker ////////////////////

            /*function startPDF(count) {
                //$("#fb6-ajax").remove();

                jQuery('.book_pages textarea').css('position','unset');
                jQuery('.book_pages .the_image').css('position','unset');

                jQuery('.book_pages textarea').css('max-width', function () {
                    return '300px';
                });

               /!* jQuery('.book_pages textarea').replaceWith(function () {
                    jQuery(this).css({'width': jQuery(this).parent().css('width'), 'padding': 'unset'});
                    let styles = jQuery(this).attr('style');
                    let content = jQuery(this).text().replaceAll('\n', '<br>');
                    return `<p style='${styles}'>${content}</p>`;
                });*!/



                //   jQuery("#loader").show();

                // jQuery('.turn-page-wrapper').css('display', 'unset');
                jQuery(".tmp_pages").each(function () {
                    let id = jQuery(this).attr("id");
                    // jQuery("#" + id).css('transform', 'scale(2,2)');
                    appendCanvas(id);
                });
                //$('.book_pages').remove()
                // export_book_pdf(count);
            }

            function appendCanvas(id) {
                console.log(id)
                html2canvas(document.querySelector("#"+id)).then(canvas => {
                    jQuery(canvas).addClass('canvas_list');
                    jQuery(canvas).attr('id', 'canvas_' + id);
                    jQuery(canvas).css('position', 'relative');
                    console.log(canvas.toDataURL("image/png"))
                    document.body.appendChild(canvas);
                    //jQuery("#" + id).css('transform', 'scale(1,1)');
                });
            }

            function addScript(url) {
                var script = document.createElement('script');
                script.type = 'application/javascript';
                script.src = url;
                document.head.appendChild(script);
            }

            /!* async function invoce_canvasgenerator(selector) {
                 let my_canvas = await html2canvas(document.querySelector(selector)).then(canvas => {
                     document.body.appendChild(canvas);
                     return canvas;
                 });
                 return my_canvas;
             }*!/

            function export_book_pdf(count) {

                addScript('https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js');
                let interval = setInterval(function () {

                    if (jQuery('.canvas_list').length == count) {
                        clearInterval(interval);
                        setTimeout(function () {
                            let sample_canvas = jQuery("#canvas_book_page_1");

                            let canvas_width = 3 / 4 * sample_canvas.width();
                            let canvas_height = 3 / 4 * sample_canvas.height();
                            doc = new jsPDF({
                                unit: 'pt',
                                format: [canvas_width, canvas_height]
                            });
                            for (let i = 1; i <= count; i++) {
                                let canvas = document.querySelector('#canvas_book_page_' + i);
                                let canvas_base64 = canvas.toDataURL("image/png");
                                if (canvas_base64.length > 100) {
                                    doc.addImage(canvas_base64, 'PNG', 0, 0, 0, 0);
                                    doc.addPage();
                                }
                            }
                            $('.book_pages').remove()
                            doc.save('invoice.pdf');
                            //jQuery(".canvas_list").remove();
                            //  location.reload();
                        }, 5000);
                    }
                }, 1000);
            }

            function getRandomInt(min, max) {
                min = Math.ceil(min);
                max = Math.floor(max);
                return Math.floor(Math.random() * (max - min + 1)) + min;
            }*/

        </script>

        <!--<button onclick="startDownlaod()" id="download_pdf">downlaod</button>-->

        <div id="loader"
             style="position: fixed;top: 0;left: 0;width: 100%; height: 100%;background-color:#ffffff; z-index: 1000000000;display: none">
            <div style="position: absolute;left: 0;top: 0;right: 0;bottom: 0;margin: auto;width: max-content;height: max-content">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                     style="margin:auto;background:#fff;display:block;" width="120px" height="120px"
                     viewBox="0 0 100 100"
                     preserveAspectRatio="xMidYMid">
                    <circle cx="50" cy="50" r="35" stroke-width="5" stroke="#56819f"
                            stroke-dasharray="54.97787143782138 54.97787143782138" fill="none" stroke-linecap="round">
                        <animateTransform attributeName="transform" type="rotate" dur="1.282051282051282s"
                                          repeatCount="indefinite" keyTimes="0;1"
                                          values="0 50 50;360 50 50"></animateTransform>
                    </circle>
                    <circle cx="50" cy="50" r="29" stroke-width="5" stroke="#f8b26a"
                            stroke-dasharray="45.553093477052 45.553093477052" stroke-dashoffset="45.553093477052"
                            fill="none"
                            stroke-linecap="round">
                        <animateTransform attributeName="transform" type="rotate" dur="1.282051282051282s"
                                          repeatCount="indefinite" keyTimes="0;1"
                                          values="0 50 50;-360 50 50"></animateTransform>
                    </circle>
                </svg>
                <div class="loader_text"
                     style="display:block;font-family: IranSansNormal;font-size: 18px;width: max-content">
                    درحال ساختن کتاب
                </div>
            </div>

        </div>
    <?php } else {
        echo "<p>برای مشاهده کتاب وارد حساب کاربری خود شوید</p>";
    }
} ?>
</body>

<!-- Mirrored from business-flipbook-jquery-plugin.flashmaniac.net/index.php by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 29 Nov 2022 14:56:25 GMT -->
</html>
