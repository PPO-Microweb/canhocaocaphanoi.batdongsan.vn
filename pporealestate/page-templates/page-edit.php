<?php
/*
  Template Name: Sửa tin
 */
if(!is_user_logged_in()){
    $login_url = get_page_link(get_option(SHORT_NAME . "_pagelogin"));
    wp_redirect($login_url);
    exit;
}
if(!getRequest('postid') or !get_post(getRequest('postid'))){
    wp_redirect(get_page_link(get_option(SHORT_NAME . "_pageManage")));
    exit;
}

$post_id = getRequest('postid');
if (isset($_POST['bntSave'])) {
    global $current_user;
    get_currentuserinfo();
    
    $category = intval(getRequest('category'));
    $price = getRequest('price');
    $currency = getRequest('currency');
    $unitPrice = getRequest('unitPrice');
    $com = getRequest('com');
    $area = getRequest('area');
    $mat_tien = getRequest('mat_tien');
    $duong_truoc_nha = getRequest('duong_truoc_nha');
    $direction = getRequest('direction');
    $direction_balcony = getRequest('direction_balcony');
    $so_tang = getRequest('so_tang');
    $so_phong = getRequest('so_phong');
    $toilet = getRequest('toilet');
    $project = getRequest('project');
    $post_title = getRequest('post_title');
    $post_content = getRequest('post_content');
    $post_video = getRequest('post_video');
    $object_poster = getRequest('object_poster');
    $product_permission = getRequest('product_permission');
    $tin_vip = intval(getRequest('not_in_vip'));
    $start_time = getRequest('start_time');
    $start_time_arr = explode("/", $start_time);
    if(count($start_time_arr) == 3){
        $start_time = $start_time_arr[2] . "/" . $start_time_arr[1] . "/" . $start_time_arr[0];
    }
    $end_time = getRequest('end_time');
    $end_time_arr = explode("/", $end_time);
    if(count($end_time_arr) == 3){
        $end_time = $end_time_arr[2] . "/" . $end_time_arr[1] . "/" . $end_time_arr[0];
    }
    $contact_name = getRequest('contact_name');
    $contact_tel = getRequest('contact_tel');
    $contact_email = getRequest('contact_email');

    $my_post = array(
        'ID' => $post_id,
        'post_title' => $post_title,
        'post_content' => $post_content,
        'post_status' => 'draft',
    );
    $post_id = wp_update_post($my_post);
    if (!is_wp_error($post_id)) {
        $notify = "Bạn đã chỉnh sửa thành công!";
        // update meta data
        update_post_meta($post_id, 'price', $price);
        update_post_meta($post_id, 'currency', $currency);
        update_post_meta($post_id, 'unitPrice', $unitPrice);
        update_post_meta($post_id, 'com', $com);
        update_post_meta($post_id, 'area', $area);
        update_post_meta($post_id, 'direction', $direction);
        update_post_meta($post_id, 'direction_balcony', $direction_balcony);
        update_post_meta($post_id, 'mat_tien', $mat_tien);
        update_post_meta($post_id, 'duong_truoc_nha', $duong_truoc_nha);
        update_post_meta($post_id, 'so_tang', $so_tang);
        update_post_meta($post_id, 'so_phong', $so_phong);
        update_post_meta($post_id, 'toilet', $toilet);
        update_post_meta($post_id, 'project', $project);
        update_post_meta($post_id, 'video', $post_video);
        update_post_meta($post_id, 'object_poster', $object_poster);
        update_post_meta($post_id, 'product_permission', $product_permission);
        update_post_meta($post_id, 'not_in_vip', $tin_vip);
        update_post_meta($post_id, 'start_time', $start_time);
        update_post_meta($post_id, 'end_time', $end_time);
        update_post_meta($post_id, 'contact_name', $contact_name);
        update_post_meta($post_id, 'contact_tel', $contact_tel);
        update_post_meta($post_id, 'contact_email', $contact_email);
        
        // upload images
        $gallery_ids = array();
        for ($i = 0; $i < count($_FILES['images']['name']); $i++) {
            $filename = $_FILES['images']['name'][$i];
            $file = file_get_contents($_FILES['images']['tmp_name'][$i]);
            $res = wp_upload_bits($filename, '', $file);
            $attach_id = insert_attachment($res['file'], $post_id);
            $gallery_ids[] = $attach_id;
        }
        if(!empty($gallery_ids)){
            set_post_thumbnail($post_id, $gallery_ids[0]);
            update_field('gallery', $gallery_ids, $post_id);
        }
    } else {
        $contact_page = get_page_link(get_option(SHORT_NAME . "_pagecontact"));
        $notify1 = 'Có lỗi xảy ra, bạn hãy thử lại hoặc <a href="'.$contact_page.'" target="_blank">liên hệ</a> với chúng tôi để được trợ giúp.';
    }
}

$directions = direction_list();
$unitcurrencies = unitCurrency_list();
$unitPrices = unitPrice_list();
$categories = get_categories(array('hide_empty' => 0, 'post_type' => 'product', 'taxonomy' => 'product_category', 'parent' => 0));

get_header();
?>
<div class="container main_content">
    <?php while (have_posts()) : the_post(); ?>
        <div class="ppo_breadcrumb">
            <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<div class="breadcrumbs">','</div>'); } ?>
        </div>
        <div class="banner_logo mt10 mb10">
            <?php get_template_part('template', 'logo_banner'); ?>
        </div>
        <form name="formPost" id="formPost" method="post" action="" enctype="multipart/form-data">
            <div class="formsale postnews">
                <?php //the_content();?>
                <?php if (!empty($notify)): ?>
                    <div class="alert alert-success mt20" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <span class="bold">Chúc mừng:</span>
                        <?php echo $notify; ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($notify1)): ?>
                    <div class="alert alert-danger mt20" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <span class="bold">Rất tiếc:</span>
                        <?php echo $notify1; ?>
                    </div>
                <?php endif; ?>
                <div class="thongtincoban">
                    <h1 class="title_postnews">Thông tin cơ bản</h1>
                    <div class="thongtin-content postnews-content">
                        <div class="item row">
                            <div class="col-sm-2">
                                <label class="text">Lịch đăng <span>(*)</span></label>
                            </div>
                            <div class="col-sm-2">
                                <select name="not_in_vip" class="select" required>
                                    <option value="0">Tin thường</option>
                                    <option value="1" <?php echo (get_post_meta($post_id, 'not_in_vip', true) == '1')?'selected':''; ?>>Tin VIP</option>
                                </select>
                            </div>
                            <div class="col-sm-8">
                                <div class="row">
                                    <?php
                                    $start_time = date('d/m/Y', strtotime(get_post_meta($post_id, 'start_time', true)));
                                    $end_time = date('d/m/Y', strtotime(strtotime(get_post_meta($post_id, 'end_time', true))));
                                    ?>
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="col-sm-6 pdt5">
                                                <label class="text" for="start_time">Bắt đầu <span>(*)</span></label>
                                            </div>
                                            <div class="col-sm-6 date">
                                                <input type="text" value="<?php echo $start_time ?>" placeholder="<?php echo $start_time ?>" name="start_time" id="start_time" class="textbox" maxlength="10" required /> <i class="fa fa-calendar"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="col-sm-6 pdt5">
                                                <label class="text" for="end_time">Kết thúc <span>(*)</span></label>
                                            </div>
                                            <div class="col-sm-6 date">
                                                <input type="text" value="<?php echo $end_time ?>" placeholder="<?php echo $end_time ?>" name="end_time" id="end_time" class="textbox" maxlength="10" required /> <i class="fa fa-calendar"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item row">
                            <div class="col-sm-2">
                                <label class="text">Giá <span>(*)</span></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="text" value="<?php echo get_post_meta($post_id, 'price', true) ?>" name="price" min="0" id="price" class="number textbox" required/>
                            </div>
                            <div class="col-sm-4">
                                <div class="row">
                                    <div class="col-sm-6 pdt5">
                                        <label class="text">Đơn vị tính <span>(*)</span></label>
                                    </div>
                                    <div class="col-sm-6">
                                        <select name="currency" id="currency" class="select" required>
                                            <?php
                                            $currency = get_post_meta($post_id, 'currency', true);
                                            foreach ($unitcurrencies as $key => $value) {
                                                if($currency == $key){
                                                    echo '<option value="' . $key . '" selected>' . $value . '</option>';
                                                } else {
                                                    echo '<option value="' . $key . '">' . $value . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="row">
                                    <div class="col-sm-6 pdt5">
                                        <label class="text">Giá tính <span>(*)</span></label>
                                    </div>
                                    <div class="col-sm-6">
                                        <select name="unitPrice" id="unitPrice" class="select" required>
                                            <?php
                                            $unitPrice = get_post_meta($post_id, 'unitPrice', true);
                                            foreach ($unitPrices as $key => $value) {
                                                if($unitPrice == $key){
                                                    echo '<option value="' . $key . '" selected>' . $value . '</option>';
                                                } else {
                                                    echo '<option value="' . $key . '">' . $value . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item row">
                            <div class="col-sm-4">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class="text">Đối tượng đăng <span>(*)</span></label> 
                                    </div>
                                    <div class="col-sm-6">
                                        <select name="object_poster" class="select" required>
                                            <option value="">Chọn đối tượng</option>
                                            <?php
                                            $object_poster = get_post_meta($post_id, 'object_poster', true);
                                            foreach (get_object_posters() as $key => $value) {
                                                if($object_poster == $key){
                                                    echo '<option value="' . $key . '" selected>' . $value . '</option>';
                                                } else {
                                                    echo '<option value="' . $key . '">' . $value . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="col-sm-6 pdt5">
                                                <label class="text">Quyền hạn BĐS <span>(*)</span></label> 
                                            </div>
                                            <div class="col-sm-6">
                                                <select name="product_permission" class="select" required>
                                                    <option value="">Chọn quyền hạn đối với Bất động sản</option>
                                                    <?php
                                                    $product_permission = get_post_meta($post_id, 'product_permission', true);
                                                    foreach (get_product_permissions() as $key => $value) {
                                                        if($product_permission == $key){
                                                            echo '<option value="' . $key . '" selected>' . $value . '</option>';
                                                        } else {
                                                            echo '<option value="' . $key . '">' . $value . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="col-sm-6 pdt5">
                                                <label class="text">Hoa hồng</label> 
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="text" placeholder="Tính theo %" value="<?php echo get_post_meta($post_id, 'com', true) ?>" name="com" class="textbox" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end .thongtincoban-->
                <div class="motachitiet">
                    <h1 class="title_postnews">Thông tin chi tiết</h1>
                    <div class="mota-content postnews-content">
                        <div class="item row">
                            <div class="col-md-2 col-sm-3">
                                <label class="text">Tiêu đề tin <span>(*)</span></label> 
                            </div>
                            <div class="col-md-10 col-sm-9">
                                <input name="post_title" type="text" maxlength="70" value="<?php echo get_the_title($post_id) ?>" placeholder="Vui lòng gõ tiếng Việt có dấu để tin đăng được kiểm duyệt nhanh hơn" id="contact_name" class="form-control" required/>
                            </div>
                        </div>
                        <div class="item row">
                            <div class="col-md-2 col-sm-3">
                                <label class="text">Nội dung tin <span>(*)</span></label> 
                            </div>
                            <div class="col-md-10 col-sm-9">
                                <?php
                                $tindang = get_post($post_id);
                                $content = apply_filters('the_content', $tindang->post_content);
                                $content = str_replace(']]>', ']]&gt;', $content);
                                wp_editor($content, "post_content", array(
                                    'textarea_name' => "post_content",
                                    'textarea_rows' => 12,
                                    'media_buttons' => false,
                                    'teeny' => true,
                                    'quicktags' => false,
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="item row">
                            <div class="col-sm-2">
                                <label class="text">Video</label>
                            </div>
                            <div class="col-sm-10">
                                <textarea rows="3" name="post_video" class="form-control"><?php echo stripslashes(get_post_meta($post_id, 'video', true)) ?></textarea>
                                <small>Mã nhúng iframe video Youtube hoặc Vimeo. Width: 100% x Height: 400</small>
                            </div>
                        </div>
                        <div class="item row">
                            <div class="col-sm-2">
                                <label class="text">Hình ảnh</label>
                            </div>
                            <div class="col-sm-10">
                                <div class="product-images mb5">
                                    <input type="file" name="images[]" accept="image/jpg,image/jpeg,image/x-png,image/gif" multiple />
                                </div>
                                <small>Tối đa 08 ảnh. Dung lượng mỗi ảnh không quá 1MB. Chấp nhận các định dạng: jpg, jpeg, png, gif.</small>
                            </div>
                        </div>
                    </div>
                </div><!-- end .motachitiet-->
                <div class="thongtinkhac">
                    <h1 class="title_postnews">Thông số Bất động sản</h1>
                    <div class="thongtinkhac-content postnews-content">
                        <div class="item row">
                            <div class="col-sm-4 mb15">
                                <div class="row">
                                    <div class="col-sm-5 pdr0">
                                        <label class="text">Loại BĐS <span>(*)</span></label>
                                    </div>
                                    <div class="col-sm-7">
                                        <select name="category" id="category" class="required select" required>
                                            <?php
                                            $term_id = 0;
                                            if(!empty($categories)){
                                                $term_id = $categories[0]->term_id;
                                            }
                                            $categories = get_categories(array(
                                                'hide_empty' => 0,
                                                'post_type' => 'product',
                                                'taxonomy' => 'product_category',
                                                'parent' => $term_id,
                                            ));
                                            $terms = get_the_terms( $post_id, 'product_category' );
                                            foreach ($categories as $category) :
                                                if(!empty($terms) and $terms[0]->term_id == $category->term_id){
                                                    echo "<option value=\"{$category->term_id}\" selected>{$category->name}</option>";
                                                } else {
                                                    echo "<option value=\"{$category->term_id}\">{$category->name}</option>";
                                                }
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 mb15">
                                <div class="row">
                                    <div class="col-sm-5 pdr0">
                                        <label class="text">Dự án</label>
                                    </div>
                                    <div class="col-sm-7">
                                        <select name="project" id="project" class="select">
                                            <option value="">- Chọn dự án -</option>
                                            <?php
                                            $projects = new WP_Query(array(
                                                'post_type' => 'project',
                                                'showposts' => -1,
                                                'post_status' => 'publish',
                                            ));
                                            $currency_project = get_post_meta($post_id, 'project', true);
                                            while($projects->have_posts()): $projects->the_post();
                                                if($currency_project == get_the_ID()){
                                                    echo "<option value=\"".get_the_ID()."\" selected>".get_the_title()."</option>";
                                                } else {
                                                    echo "<option value=\"".get_the_ID()."\">".get_the_title()."</option>";
                                                }
                                            endwhile;
                                            wp_reset_query();
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 mb15">
                                <div class="row">
                                    <div class="col-sm-5 pdr0">
                                        <label class="text">Diện tích (m<sup>2</sup>)</label>
                                    </div>
                                    <div class="col-sm-7">
                                        <input type="text" value="<?php echo get_post_meta($post_id, 'area', true) ?>" name="area" id="area" class="number textbox" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 mb15">
                                <div class="row">
                                    <div class="col-sm-5 pdr0">
                                        <label class="text">Mặt tiền (m)</label>
                                    </div>
                                    <div class="col-sm-7">
                                        <input type="text" value="<?php echo get_post_meta($post_id, 'mat_tien', true) ?>" name="mat_tien" id="mat_tien" class="number textbox" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 mb15">
                                <div class="row">
                                    <div class="col-sm-5 pdr0">
                                        <label class="text">Đường vào (m)</label>
                                    </div>
                                    <div class="col-sm-7">
                                        <input type="text" value="<?php echo get_post_meta($post_id, 'duong_truoc_nha', true) ?>" name="duong_truoc_nha" id="duong_truoc_nha" class="number textbox" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 mb15">
                                <div class="row">
                                    <div class="col-sm-5 pdr0">
                                        <label class="text">Hướng BĐS</label>
                                    </div>
                                    <div class="col-sm-7">
                                        <select name="direction" id="direction" class="select">
                                            <?php
                                            $current_direction = get_post_meta($post_id, 'direction', true);
                                            foreach ($directions as $key => $value) {
                                                if($current_direction == $key){
                                                    echo '<option value="' . $key . '" selected>' . $value . '</option>';
                                                } else {
                                                    echo '<option value="' . $key . '">' . $value . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 mb15">
                                <div class="row">
                                    <div class="col-sm-5 pdr0">
                                        <label class="text">Hướng ban công</label>
                                    </div>
                                    <div class="col-sm-7">
                                        <select name="direction_balcony" id="direction_balcony" class="select">
                                            <?php
                                            $current_direction_balcony = get_post_meta($post_id, 'direction_balcony', true);
                                            foreach ($directions as $key => $value) {
                                                if($current_direction_balcony == $key){
                                                    echo '<option value="' . $key . '" selected>' . $value . '</option>';
                                                } else {
                                                    echo '<option value="' . $key . '">' . $value . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 mb15">
                                <div class="row">
                                    <div class="col-sm-5 pdr0">
                                        <label class="text">Số tầng</label>
                                    </div>
                                    <div class="col-sm-7">
                                        <input type="text" value="<?php echo get_post_meta($post_id, 'so_tang', true) ?>" name="so_tang" id="so_tang" class="number textbox" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 mb15">
                                <div class="row">
                                    <div class="col-sm-5 pdr0">
                                        <label class="text">Phòng ngủ</label>
                                    </div>
                                    <div class="col-sm-7">
                                        <select name="so_phong" id="so_phong" class="number select">
                                            <?php
                                            $rooms = room_list();
                                            $so_phong = get_post_meta($post_id, 'so_phong', true);
                                            foreach ($rooms as $key => $value) {
                                                if($so_phong == $key){
                                                    echo '<option value="' . $key . '" selected>' . $value . '</option>';
                                                } else {
                                                    echo '<option value="' . $key . '">' . $value . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 mb15">
                                <div class="row">
                                    <div class="col-sm-5 pdr0">
                                        <label class="text">Phòng vệ sinh</label>
                                    </div>
                                    <div class="col-sm-7">
                                        <select name="toilet" id="toilet" class="number select">
                                            <?php
                                            $toilet = get_post_meta($post_id, 'toilet', true);
                                            foreach (range(1, 9) as $key => $value) {
                                                if($toilet == $key){
                                                    echo '<option value="' . $key . '" selected>' . $value . '</option>';
                                                } else {
                                                    echo '<option value="' . $key . '">' . $value . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- .end thongtinkhac -->
                <div class="thongtinlienhe">
                    <h1 class="title_postnews">Thông tin liên hệ</h1>
                    <div class="thongtinlienhe-content postnews-content">
                        <div class="item row">
                            <div class="col-md-2 col-sm-3">
                                <label class="text">Họ tên <span>(*)</span></label>      
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <input type="text" name="contact_name" id="contact_name" value="<?php echo get_post_meta($post_id, 'contact_name', true) ?>" maxlength="100" placeholder="Là Họ tên mà khách hàng sẽ liên hệ với bạn" class="form-control" required/>
                            </div>
                        </div>
                        <div class="item row">
                            <div class="col-md-2 col-sm-3">
                                <label class="text">Điện thoại <span>(*)</span></label>                          
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <input type="text" name="contact_tel" id="contact_tel" maxlength="20" value="<?php echo get_post_meta($post_id, 'contact_tel', true) ?>" placeholder="Là Số điện thoại mà khách hàng sẽ gọi cho bạn" class="form-control" required/>
                            </div>
                        </div>
                        <div class="item row">
                            <div class="col-md-2 col-sm-3">
                                <label class="text">Email</label>  
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <input type="email" name="contact_email" id="contact_email" maxlength="100"  value="<?php echo get_post_meta($post_id, 'contact_email', true) ?>" placeholder="Là Email mà khách hàng sẽ gửi cho bạn" class="form-control"/>
                            </div>
                        </div>
                    </div>
                </div><!-- end .thongtinlienhe-->
                <div class="dangtin">
                    <div class="dangtin-content">
                        <div class="item">
                            <input type="submit" name="bntSave" value="Đăng tin" id="bntSave" class="button">
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>  
        </form>
    <?php endwhile; ?>
</div>
<?php get_footer(); ?>