<div class="item_product <?php echo (get_post_meta(get_the_ID(), 'not_in_vip', true) == 1)?'vip':''; ?>">
    <a class="thumbnail" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>" rel="nofollow">
        <img alt="<?php the_title(); ?>" src="<?php the_post_thumbnail_url('170x115'); ?>" />
        <?php
        $today = strtotime(date('Y-m-d H:i:s'));
        $end_time = strtotime(get_post_meta(get_the_ID(), 'end_time', true));
        if($today > $end_time):
        ?>
        <div class="ribbon ribbon-blue"><div class="banner"><div class="text">Hết hạn</div></div> </div>
        <?php endif; ?>
    </a>
    <div class="info">
        <h4 class="title"><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
        <div class="date">
            <?php
            $start_time = date('d/m/Y', strtotime(get_post_meta(get_the_ID(), 'start_time', true)));
            ?>
            <span class="glyphicon glyphicon-calendar"></span> <?php echo $start_time; ?> 
            <span class="glyphicon glyphicon glyphicon-arrow-right"></span> <?php echo date('d/m/Y', $end_time); ?>
        </div>
        <a class="edit-link" href="<?php echo get_page_link(get_option(SHORT_NAME . "_pageEdit")) ?>?postid=<?php the_ID() ?>">Chỉnh sửa</a>
    </div>
</div>