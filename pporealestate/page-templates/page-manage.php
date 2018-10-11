<?php 
/*
  Template Name: Quản lý tin đăng
 */
if (!is_user_logged_in()) {
    wp_redirect( home_url('/login/') );
}
get_header(); 

$author = wp_get_current_user();
$display_name = $author->user_lastname . ' ' . $author->user_firstname;
if(empty($display_name)){
    $display_name = $author->display_name;
}
?>
<div class="container main_content">
    <div class="ppo_breadcrumb">
        <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<div class="breadcrumbs">','</div>'); } ?>
    </div>
    <div class="banner_logo mt10 mb30">
        <?php get_template_part('template', 'logo_banner'); ?>
    </div>
    <div class="row">
        <div class="left col-md-8 col-sm-12">
            <div class="dashboard">
                <div class="section-header">
                    <div class="list-header">
                        <h1 class="span-title">
                            <?php echo $display_name; ?>
                        </h1>
                    </div>
                </div>
                <div class="dashboard-items">
                    <?php
                    $query = new WP_Query( array(
                        'author' => $author->ID,
                        'post_type' => 'product',
                    ) );
                    if($query->found_posts > 0){
                        while ($query->have_posts()) : $query->the_post();
                            get_template_part('template/dashboard-product_item');
                        endwhile;
                        getpagenavi(array('query' => $query));
                    } else {
                        echo '<h3>Chưa có bài đăng nào!</h3>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="cat-sidebar sidebar col-md-4 col-sm-6">
            <?php get_template_part('template', 'sidebarsearch'); ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
