<div id="footer">
    <div class="footer-contact hidden-xs">
        <div class="container">
            <div class="row">
                <div class="col-sm-9">
                    <img class="mr15" alt="Contact Us" src="<?php echo THEME_URI ?>assets/images/footer-contact.png" /> 
                    <span class="mr15">HOTLINE: <strong><?php echo get_option(SHORT_NAME . "_hotline") ?></strong></span>
                    <span>Email: <strong><?php echo get_option("info_email") ?></strong></span>
                </div>
                <div class="col-sm-3 btn-wrap">
                    <a href="tel:<?php echo get_option(SHORT_NAME . "_hotline") ?>" class="btn"><?php _e('Liên hệ', SHORT_NAME) ?></a>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-widgets">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <?php if ( is_active_sidebar( 'footer1' ) ) { dynamic_sidebar( 'footer1' ); } ?>
                </div>
                <div class="col-md-3 col-sm-6">
                    <?php if ( is_active_sidebar( 'footer2' ) ) { dynamic_sidebar( 'footer2' ); } ?>
                </div>
                <div class="col-md-3 col-sm-6">
                    <?php if ( is_active_sidebar( 'footer3' ) ) { dynamic_sidebar( 'footer3' ); } ?>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="widget">
                        <h3 class="widget-title">MẠNG XÃ HỘI</h3>
                        <!--<p>Theo dõi chúng tôi trên mạng xã hội</p>-->
                        <ul class="socials">
                            <li><a href="<?php echo get_option(SHORT_NAME . "_fbURL") ?>" class="icon-fb"></a></li>
                            <li><a href="<?php echo get_option(SHORT_NAME . "_googlePlusURL") ?>" class="icon-gplus"></a></li>
                            <li><a href="<?php echo get_option(SHORT_NAME . "_twitterURL") ?>" class="icon-twitter"></a></li>
                            <li><a href="<?php echo get_option(SHORT_NAME . "_linkedInURL") ?>" class="icon-in"></a></li>
                        </ul>
                    </div>
                    <div class="widget">
                        <h3 class="widget-title">NEWSLETTER</h3>
                        <!--<p>Đăng ký để nhận bản tin định kỳ</p>-->
                        <div class="newsletter">
                            <?php echo do_shortcode(stripslashes_deep(get_option("follow_form"))); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-md-6 left">
                    <?php
                    $copyright = get_option('copyright_text');
                    if(!empty($copyright)):
                    ?>
                    <span>Copyright &copy; <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo $copyright; ?>"><?php echo $copyright; ?></a>. All rights reserved. </span>
                    <a href="http://ppo.vn" title="Thiết kế web chuyên nghiệp" target="_blank"><?php _e('Thiết kế web bởi PPO.VN', SHORT_NAME) ?></a>
                    <?php else: ?>
                    <span>Copyright &COPY; <a href="http://vrx.vn" title="Thiết kế website">VRX.VN</a>. All rights reserved.</span>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <?php
                    if ( has_nav_menu( 'footermenu' ) ) {
                        wp_nav_menu(array(
                            'container' => '',
                            'theme_location' => 'footermenu',
                            'menu_class' => 'nav footer-nav',
                            'menu_id' => '',
                        ));
                    } else {
                        _e('Please add a menu to Footer Location', SHORT_NAME);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SUPPORT -->
<section id="floating-buttons">
    <a href="#" class="cta"><i class="fa fa-question"></i></a>
    <div class="wrap-bookmarks">
        <div class="title-bookmarks">
            Chúng tôi có thể giúp gì cho bạn?
            <div class="btn-close pull-right">X</div>
        </div>
        <div class="list-bookmarts">
            <?php
                $bookmarks = get_bookmarks( array(
                    'orderby' => 'name',
                    'order' => 'ASC',
                    'category' => '',
                    'category_name'  => ''
                ) );
            ?>
            <div class="text-selectbox">Tôi muốn</div> 
            <select id="lstbookmarts">
                <?php foreach ( $bookmarks as $bookmark ) { ?>
                  <?php printf( '<option value="%1$s">%2$s</option>', esc_attr( $bookmark->link_url ), $bookmark->link_name ); ?>
                <?php } ?>
            </select>
            <a class="btn" id="btn-view-link">XEM</a>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <div class="row">
                    <div class="col-xs-3">
                        <img src="<?php echo THEME_URI ?>assets/images/icon-building.png">
                    </div>
                    <div class="col-xs-9 pdleft-0">
                        <div class="text-building">Tư vấn cho chủ đầu tư</div>
                        <div class="phone-building"><?php echo get_option(SHORT_NAME . "_hotline-support-1") ?></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="row">
                    <div class="col-xs-3">
                        <img src="<?php echo THEME_URI ?>assets/images/icon-home-support.png">
                    </div>
                    <div class="col-xs-9 pdleft-0">
                        <div class="text-building">Tư vấn cho chủ nhà</div>
                        <div class="phone-building"><?php echo get_option(SHORT_NAME . "_hotline-support-2") ?></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="row">
                    <div class="col-xs-3">
                        <img src="<?php echo THEME_URI ?>assets/images/icon-user-support.png">
                    </div>
                    <div class="col-xs-9 pdleft-0">
                        <div class="text-building">Tư vấn cho môi giới</div>
                        <div class="phone-building"><?php echo get_option(SHORT_NAME . "_hotline-support-3") ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- HOTLINE -->
<div class="callus">
    <i class="glyphicon glyphicon-earphone"></i>
    <a href="tel:<?php echo get_option(SHORT_NAME . "_hotline") ?>"><?php echo get_option(SHORT_NAME . "_hotline") ?></a>
</div>

<div id="scrollToTop"><i class="fa fa-angle-up" aria-hidden="true"></i></div>
<div id="fb-root"></div>
<?php wp_footer(); ?>
<noscript id="deferred-styles">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,300italic,300,700,700italic,400italic&subset=vietnamese,latin" rel="stylesheet" />
    <link href="http://fonts.googleapis.com/css?family=BenchNine:400" rel="stylesheet" />
</noscript>
<script>
var loadDeferredStyles = function() {
  var addStylesNode = document.getElementById("deferred-styles");
  var replacement = document.createElement("div");
  replacement.innerHTML = addStylesNode.textContent;
  document.body.appendChild(replacement);
  addStylesNode.parentElement.removeChild(addStylesNode);
};
var raf = requestAnimationFrame || mozRequestAnimationFrame ||
    webkitRequestAnimationFrame || msRequestAnimationFrame;
if (raf){ raf(function() { window.setTimeout(loadDeferredStyles, 0); });}
else{ window.addEventListener('load', loadDeferredStyles);}
</script>
</body>
</html>
