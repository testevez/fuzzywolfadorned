<?php 
/*
 * Virtue Premium Widgets 
 */

class kad_gallery_widget extends WP_Widget{

function kad_gallery_widget() {
        $widget_ops = array('classname' => 'virtue_gallery_widget', 'description' => __('Adds a gallery to any widget area.', 'virtue'));
        $this->__construct('virtue_gallery_widget', __('Virtue: Gallery', 'virtue'), $widget_ops);
        $this->alt_option_name = 'virtue_gallery_widget';
    }
     public function widget($args, $instance){ 
        extract( $args ); 
        $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
        if(!empty($instance["ids"])) {$g_ids = $instance["ids"];} else {$g_ids = '';}
        if(!empty($instance["gallery_width"])) {$g_width = 'width='.$instance["gallery_width"];} else {$g_width = '';}
        if(!empty($instance["gallery_height"])) {$g_height = 'height='.$instance["gallery_height"];} else {$g_height = '';}
        if(!empty($instance["gallery_speed"])) {$g_speed = 'speed='.$instance["gallery_speed"];} else {$g_speed = '';}
        if(!empty($instance["gallery_type"])) { $g_type = $instance["gallery_type"]; } else {$g_type = 'standard';}
        if(!empty($instance["lightbox_size"])) { $l_size = 'lightboxsize="'.$instance["lightbox_size"].'"'; } else {$l_size = '';}
        if(!empty($instance["gallery_columns"])) { $g_columns = $instance["gallery_columns"]; } else {$g_columns = '3';}
        if(!empty($instance["gallery_captions"]) && $instance["gallery_captions"] == 'on') { $g_captions = 'caption=true';} else {$g_captions = '';}
        if($g_type == 'masonry') {$masonry = 'true';} else {$masonry = 'false';}

            ?>

          <?php echo $before_widget;
          if ( $title ) echo $before_title . $title . $after_title; 
          echo do_shortcode('[gallery ids='.$g_ids.' type='.$g_type.' '.$g_captions.' masonry='.$masonry.' columns='.$g_columns.' '.$g_speed.' '.$g_height.' '.$l_size.' '.$g_width .']');
          echo $after_widget;?>

    <?php }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['ids'] = $new_instance['ids'];
        $instance['gallery_type'] = $new_instance['gallery_type'];
        $instance['lightbox_size'] = $new_instance['lightbox_size'];
        $instance['gallery_columns'] = $new_instance['gallery_columns']; 
        $instance['gallery_captions'] = $new_instance['gallery_captions'];
        $instance['gallery_width'] = (int) $new_instance['gallery_width'];
        $instance['gallery_height'] = (int) $new_instance['gallery_height'];
        $instance['gallery_speed'] = (int) $new_instance['gallery_speed'];
        $instance['title'] = strip_tags( $new_instance['title'] );
        $this->flush_widget_cache();
        return $instance;
    }
      function flush_widget_cache() {
        wp_cache_delete('virtue_gallery_widget', 'widget');
      }

  public function form($instance){ 
    $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
    $ids = isset($instance['ids']) ? esc_attr($instance['ids']) : '';
    $gallery_width = isset($instance['gallery_width']) ? esc_attr($instance['gallery_width']) : '';
    $gallery_height = isset($instance['gallery_height']) ? esc_attr($instance['gallery_height']) : '';
    $gallery_speed = isset($instance['gallery_speed']) ? esc_attr($instance['gallery_speed']) : '';
    if (isset($instance['gallery_type'])) { $gallery_type = esc_attr($instance['gallery_type']); } else {$gallery_type = 'standard';}
    if (isset($instance['lightbox_size'])) { $lightbox_size = esc_attr($instance['lightbox_size']); } else {$lightbox_size = 'full';}
    if (isset($instance['gallery_columns'])) { $gallery_columns = esc_attr($instance['gallery_columns']); } else {$gallery_columns = '3';}
    if (isset($instance['gallery_captions'])) { $gallery_captions = esc_attr($instance['gallery_captions']); } else {$gallery_captions = 'off';}
    $gallery_type_array = array();
    $lightbox_size_array = array();
    $gallery_columns_array = array();
    $gallery_captions_array = array();
    $gallery_options = array(array("slug" => "standard", "name" => __('Standard', 'virtue')), array("slug" => "masonry", "name" => __('Masonry', 'virtue')), array( "slug" => "carousel", "name" => __('Carousel', 'virtue')), array( "slug" => "slider", "name" => __('Slider', 'virtue')), array( "slug" => "imagecarousel", "name" => __('Image Carousel', 'virtue')));
    $gallery_columns_options = array(array("slug" => "1", "name" => __('1 Column', 'virtue')), array("slug" => "2", "name" => __('2 Columns', 'virtue')), array("slug" => "3", "name" => __('3 Columns', 'virtue')), array("slug" => "4", "name" => __('4 Columns', 'virtue')), array("slug" => "5", "name" => __('5 Columns', 'virtue')), array("slug" => "6", "name" => __('6 Columns', 'virtue')));
    $gallery_caption_options = array(array("slug" => "off", "name" => __('Off', 'virtue')), array("slug" => "on", "name" => __('On', 'virtue')));
    $lightbox_size_options = array(array("slug" => "full", "name" => __('Full', 'virtue')), array("slug" => "large", "name" => __('Large', 'virtue')), array("slug" => "medium", "name" => __('Medium', 'virtue')), array("slug" => "thumbnail", "name" => __('Thumbnail', 'virtue')));
     foreach ($gallery_caption_options as $gallery_caption_option) {
      if ($gallery_captions == $gallery_caption_option['slug']) { $selected=' selected="selected"';} else { $selected=""; }
      $gallery_captions_array[] = '<option value="' . $gallery_caption_option['slug'] .'"' . $selected . '>' . $gallery_caption_option['name'] . '</option>';
    }
      foreach ($lightbox_size_options as $lightbox_size_option) {
      if ($lightbox_size == $lightbox_size_option['slug']) { $selected=' selected="selected"';} else { $selected=""; }
      $lightbox_size_array[] = '<option value="' . $lightbox_size_option['slug'] .'"' . $selected . '>' . $lightbox_size_option['name'] . '</option>';
    }
    foreach ($gallery_options as $gallery_option) {
      if ($gallery_type == $gallery_option['slug']) { $selected=' selected="selected"';} else { $selected=""; }
      $gallery_type_array[] = '<option value="' . $gallery_option['slug'] .'"' . $selected . '>' . $gallery_option['name'] . '</option>';
    }
    foreach ($gallery_columns_options as $gallery_column_option) {
      if ($gallery_columns == $gallery_column_option['slug']) { $selected=' selected="selected"';} else { $selected=""; }
      $gallery_columns_array[] = '<option value="' . $gallery_column_option['slug'] .'"' . $selected . '>' . $gallery_column_option['name'] . '</option>';
    }?>  

    <div id="virtue_gallery_widget<?php echo esc_attr($this->get_field_id('container')); ?>" class="kad_widget_image_gallery">
        <div class="gallery_images">
            <?php
            $attachments = array_filter( explode( ',', $ids ) );
             if ( $attachments )
            foreach ( $attachments as $attachment_id ) {
                $img = wp_get_attachment_image_src($attachment_id, 'thumbnail');
                $imgfull = wp_get_attachment_image_src($attachment_id, 'full');
                    echo '<a class="of-uploaded-image" target="_blank" rel="external" href="' . $imgfull[0] . '">';
                    echo '<img class="gallery-widget-image" id="gallery_widget_image_'.$attachment_id. '" src="' . $img[0] . '" />';
                    echo '</a>';
                }
?>
        </div>
           <?php  echo '<a href="#" onclick="return false;" id="edit-gallery" class="gallery-attachments button button-primary">' . __('Add/Edit Gallery', 'virtue') . '</a> ';
            echo '<a href="#" onclick="return false;" id="clear-gallery" class="gallery-attachments button">' . __('Clear Gallery', 'virtue') . '</a>';
            echo '<input type="hidden" id="' . esc_attr($this->get_field_id('ids')) . '" class="gallery_values" value="' . $ids . '" name="' . esc_attr($this->get_field_name('ids')) . '" />';
            ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'virtue'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('gallery_type'); ?>"><?php _e('Gallery Type', 'virtue'); ?></label><br />
                <select id="<?php echo $this->get_field_id('gallery_type'); ?>" style="width:100%; max-width:230px" name="<?php echo $this->get_field_name('gallery_type'); ?>"><?php echo implode('', $gallery_type_array);?></select>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('gallery_columns'); ?>"><?php _e('Gallery Columns', 'virtue'); ?></label><br />
                <select id="<?php echo $this->get_field_id('gallery_columns'); ?>" style="width:100%; max-width:230px;" name="<?php echo $this->get_field_name('gallery_columns'); ?>"><?php echo implode('', $gallery_columns_array);?></select>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('gallery_captions'); ?>"><?php _e('Display Captions', 'virtue'); ?></label><br />
               <select id="<?php echo $this->get_field_id('gallery_captions'); ?>" style="width:100%; max-width:230px" name="<?php echo $this->get_field_name('gallery_captions'); ?>"><?php echo implode('', $gallery_captions_array);?></select>  
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('lightbox_size'); ?>"><?php _e('Lightbox Image Size', 'virtue'); ?></label><br />
                <select id="<?php echo $this->get_field_id('lightbox_size'); ?>" style="width:100%; max-width:230px" name="<?php echo $this->get_field_name('lightbox_size'); ?>"><?php echo implode('', $lightbox_size_array);?></select>
            </p>
            <p style="font-weight:bold;"><?php echo __('If Type Slider', 'virtue'); ?></p>
            <p>
                <label for="<?php echo $this->get_field_id('gallery_width'); ?>"><?php _e('Slider Width (e.g. = 600)', 'virtue'); ?></label><br />
                <input type="text" class="widefat kad_img_widget_link" name="<?php echo $this->get_field_name('gallery_width'); ?>" id="<?php echo $this->get_field_id('gallery_width'); ?>" value="<?php echo $gallery_width; ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('gallery_height'); ?>"><?php _e('Slider Height (e.g. = 400)', 'virtue'); ?></label><br />
                <input type="text" class="widefat kad_img_widget_link" name="<?php echo $this->get_field_name('gallery_height'); ?>" id="<?php echo $this->get_field_id('gallery_height'); ?>" value="<?php echo $gallery_height; ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('gallery_speed'); ?>"><?php _e('Slider Speed (e.g. = 7000)', 'virtue'); ?></label><br />
                <input type="text" class="widefat kad_img_widget_link" name="<?php echo $this->get_field_name('gallery_speed'); ?>" id="<?php echo $this->get_field_id('gallery_speed'); ?>" value="<?php echo $gallery_speed; ?>">
            </p>
    </div>

    <style type="text/css">.kad_widget_image_gallery {padding-bottom: 10px;}
.kad_widget_image_gallery .gallery_images:after { content: "."; display: block; height: 0; clear: both; visibility: hidden; }
.kad_widget_image_gallery .gallery_images {padding: 5px 5px 0; margin: 10px 0; background: #f2f2f2;}
.kad_widget_image_gallery .gallery_images img {max-width: 80px; height: auto; float: left; padding: 0 5px 5px 0}
</style>

<?php } }

class kad_carousel_widget extends WP_Widget{

function kad_carousel_widget() {
        $widget_ops = array('classname' => 'virtue_carousel_widget', 'description' => __('Adds a carousel to any widget area', 'virtue'));
        $this->__construct('virtue_carousel_widget', __('Virtue: Carousel', 'virtue'), $widget_ops);
        $this->alt_option_name = 'virtue_carousel_widget';
    }

       public function widget($args, $instance){ 
        extract( $args ); 
        $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
        if(!empty($instance["type"])) {$c_type = $instance["type"];} else {$c_type = 'post';}
        if(!empty($instance["c_order"])) {$c_order = 'orderby='.$instance["c_order"];} else {$c_order = '';}
        if(!empty($instance["c_items"])) {$c_items = 'items='.$instance["c_items"];} else {$c_items = 'items=6';}
        if(!empty($instance["c_speed"])) {$c_speed = 'speed='.$instance["c_speed"];} else {$c_speed = '';}
         if($c_type == "cat-products" || $c_type == "sale-products") {
            if(!empty($instance["productcat"])) {$c_cat = 'cat='.$instance["productcat"];} else {$c_cat = '';}
        } else if ($c_type == "portfolio") {
            if(!empty($instance["portfoliocat"])) {$c_cat = 'cat='.$instance["portfoliocat"];} else {$c_cat = '';}
        } else {
            if(!empty($instance["postcat"])) {$c_cat = 'cat='.$instance["postcat"];} else {$c_cat = '';}
        }
        if(!empty($instance["c_columns"])) { $c_columns = $instance["c_columns"]; } else {$c_columns = '1';}
        if(!empty($instance["c_scroll"])) { $c_scroll = $instance["c_scroll"]; } else {$c_scroll = '1';}

            ?>


          <?php echo $before_widget;
            if ( $title ) echo $before_title . $title . $after_title; 
           echo do_shortcode('[carousel type='.$c_type.' '.$c_items.' '.$c_order.' columns='.$c_columns.' '.$c_speed.' '.$c_cat.' scroll='.$c_scroll.']');
           echo $after_widget;?>

    <?php }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['type'] = $new_instance['type'];
        $instance['c_items'] = (int) $new_instance['c_items']; 
        $instance['c_columns'] = $new_instance['c_columns'];
        $instance['c_order'] = $new_instance['c_order'];
        $instance['c_scroll'] = $new_instance['c_scroll'];
        $instance['postcat'] = $new_instance['postcat'];
        $instance['portfoliocat'] = $new_instance['portfoliocat'];
        $instance['productcat'] = $new_instance['productcat'];
        $instance['c_speed'] = (int) $new_instance['c_speed'];
        $instance['title'] = strip_tags( $new_instance['title'] );
        $this->flush_widget_cache();
        return $instance;
    }
      function flush_widget_cache() {
        wp_cache_delete('virtue_carousel_widget', 'widget');
      }

  public function form($instance){ 
    $c_items = isset($instance['c_items']) ? esc_attr($instance['c_items']) : '';
    $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
    $c_speed = isset($instance['c_speed']) ? esc_attr($instance['c_speed']) : '';
    if (isset($instance['type'])) { $c_type = esc_attr($instance['type']); } else {$c_type = 'post';}
    if (isset($instance['c_scroll'])) { $c_scroll = esc_attr($instance['c_scroll']); } else {$c_scroll = '1';}
    if (isset($instance['c_order'])) { $c_order = esc_attr($instance['c_order']); } else {$c_order = 'menu_order';}
    if (isset($instance['c_columns'])) { $c_columns = esc_attr($instance['c_columns']); } else {$c_columns = '1';}
    $carousel_type_array = array();
    $carousel_scroll_array = array();
    $carousel_columns_array = array();
    $carousel_order_array = array();
    $carousel_types = array(array("slug" => "post", "name" => __('Blog Posts', 'virtue')), array("slug" => "portfolio", "name" => __('Portfolio Posts', 'virtue')), array( "slug" => "featured-products", "name" => __('Featured Products', 'virtue')), array( "slug" => "sale-products", "name" => __('Sale Products', 'virtue')), array( "slug" => "best-products", "name" => __('Best Products', 'virtue')), array( "slug" => "cat-products", "name" => __('Category of Products', 'virtue')),);
    $carousel_columns_options = array(array("slug" => "1", "name" => __('1 Column', 'virtue')), array("slug" => "2", "name" => __('2 Columns', 'virtue')), array("slug" => "3", "name" => __('3 Columns', 'virtue')), array("slug" => "4", "name" => __('4 Columns', 'virtue')), array("slug" => "5", "name" => __('5 Columns', 'virtue')));
    $carousel_scroll_options = array(array("slug" => "1", "name" => __('1 item', 'virtue')), array("slug" => "all", "name" => __('All Visible', 'virtue')));
    $carousel_order_options = array(array("slug" => "menu_order", "name" => __('Menu Order', 'virtue')), array("slug" => "date", "name" => __('Date', 'virtue')), array("slug" => "rand", "name" => __('Random', 'virtue')));

    if (isset($instance['postcat'])) { $postcat = esc_attr($instance['postcat']); } else {$postcat = '';}
    if (isset($instance['portfoliocat'])) { $portfoliocat = esc_attr($instance['portfoliocat']); } else {$portfoliocat = '';}
    if (isset($instance['productcat'])) { $productcat = esc_attr($instance['productcat']); } else {$productcat = '';}

     $types= get_terms('portfolio-type');
     $type_options = array();
    $type_options[] = '<option value="">All</option>';
 
    foreach ($types as $type) {
      if ($portfoliocat==$type->slug) { $selected=' selected="selected"';} else { $selected=""; }
      $type_options[] = '<option value="' . $type->slug .'"' . $selected . '>' . $type->name . '</option>';
    }
     $categories= get_categories();
    $cat_options = array();
    $cat_options[] = '<option value="">All</option>';
    foreach ($categories as $cat) {
      if ($postcat==$cat->slug) { $selected=' selected="selected"';} else { $selected=""; }
      $cat_options[] = '<option value="' . $cat->slug .'"' . $selected . '>' . $cat->name . '</option>';
    }

    $product_options = array();
    $product_options[] = '<option value="">All</option>';
    if (class_exists('woocommerce')) { 
        $product_categories= get_terms('product_cat');
        foreach ($product_categories as $pcat) {
          if ($productcat==$pcat->slug) { $selected=' selected="selected"';} else { $selected=""; }
          $product_options[] = '<option value="' . $pcat->slug .'"' . $selected . '>' . $pcat->name . '</option>';
        }
    }


    foreach ($carousel_types as $carousel_type) {
      if ($c_type == $carousel_type['slug']) { $selected=' selected="selected"';} else { $selected=""; }
      $carousel_type_array[] = '<option value="' . $carousel_type['slug'] .'"' . $selected . '>' . $carousel_type['name'] . '</option>';
    }
    foreach ($carousel_scroll_options as $carousel_scroll_option) {
      if ($c_scroll == $carousel_scroll_option['slug']) { $selected=' selected="selected"';} else { $selected=""; }
      $carousel_scroll_array[] = '<option value="' . $carousel_scroll_option['slug'] .'"' . $selected . '>' . $carousel_scroll_option['name'] . '</option>';
    }
    foreach ($carousel_columns_options as $carousel_column_option) {
      if ($c_columns == $carousel_column_option['slug']) { $selected=' selected="selected"';} else { $selected=""; }
      $carousel_columns_array[] = '<option value="' . $carousel_column_option['slug'] .'"' . $selected . '>' . $carousel_column_option['name'] . '</option>';
    }
    foreach ($carousel_order_options as $carousel_order_option) {
      if ($c_order == $carousel_order_option['slug']) { $selected=' selected="selected"';} else { $selected=""; }
      $carousel_order_array[] = '<option value="' . $carousel_order_option['slug'] .'"' . $selected . '>' . $carousel_order_option['name'] . '</option>';
    }?>  

    <div id="virtue_carousel_widget<?php echo esc_attr($this->get_field_id('container')); ?>" class="kad_widget_carousel">
          <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'virtue'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('type'); ?>"><?php _e('Carousel Type', 'virtue'); ?></label><br />
                <select id="<?php echo $this->get_field_id('type'); ?>" style="width:100%; max-width:230px" name="<?php echo $this->get_field_name('type'); ?>"><?php echo implode('', $carousel_type_array);?></select>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('c_columns'); ?>"><?php _e('Carousel Columns', 'virtue'); ?></label><br />
                <select id="<?php echo $this->get_field_id('c_columns'); ?>" style="width:100%; max-width:230px;" name="<?php echo $this->get_field_name('c_columns'); ?>"><?php echo implode('', $carousel_columns_array);?></select>
            </p>
             <p>
                <label for="<?php echo $this->get_field_id('c_scroll'); ?>"><?php _e('Scroll Setting', 'virtue'); ?></label><br />
                <select id="<?php echo $this->get_field_id('c_scroll'); ?>" style="width:100%; max-width:230px;" name="<?php echo $this->get_field_name('c_scroll'); ?>"><?php echo implode('', $carousel_scroll_array);?></select>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('c_items'); ?>"><?php _e('Items (e.g. = 8)', 'virtue'); ?></label><br />
                <input type="text" class="widefat kad_img_widget_link" name="<?php echo $this->get_field_name('c_items'); ?>" id="<?php echo $this->get_field_id('c_items'); ?>" value="<?php echo $c_items; ?>">
            </p>
             <p>
                <label for="<?php echo $this->get_field_id('c_order'); ?>"><?php _e('Order by', 'virtue'); ?></label><br />
                <select id="<?php echo $this->get_field_id('c_order'); ?>" style="width:100%; max-width:230px;" name="<?php echo $this->get_field_name('c_order'); ?>"><?php echo implode('', $carousel_order_array);?></select>
            </p>
             <p>
                <label for="<?php echo $this->get_field_id('postcat'); ?>"><?php _e('Blog Post Category', 'virtue'); ?></label><br />
                <select id="<?php echo $this->get_field_id('postcat'); ?>" style="width:100%; max-width:230px;" name="<?php echo $this->get_field_name('postcat'); ?>"><?php echo implode('', $cat_options);?></select>
            </p>
             <p>
                <label for="<?php echo $this->get_field_id('portfoliocat'); ?>"><?php _e('Portfolio Category', 'virtue'); ?></label><br />
                <select id="<?php echo $this->get_field_id('portfoliocat'); ?>" style="width:100%; max-width:230px;" name="<?php echo $this->get_field_name('portfoliocat'); ?>"><?php echo implode('', $type_options);?></select>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('productcat'); ?>"><?php _e('Product Category', 'virtue'); ?></label><br />
                <select id="<?php echo $this->get_field_id('productcat'); ?>" style="width:100%; max-width:230px;" name="<?php echo $this->get_field_name('productcat'); ?>"><?php echo implode('', $product_options);?></select>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('c_speed'); ?>"><?php _e('Carousel Speed (e.g. = 7000)', 'virtue'); ?></label><br />
                <input type="text" class="widefat kad_img_widget_link" name="<?php echo $this->get_field_name('c_speed'); ?>" id="<?php echo $this->get_field_id('c_speed'); ?>" value="<?php echo $c_speed; ?>">
            </p>
    </div>

<?php } }
class kad_infobox_widget extends WP_Widget{

function kad_infobox_widget() {
        $widget_ops = array('classname' => 'virtue_infobox_widget', 'description' => __('Adds a info box with icon options', 'virtue'));
        $this->__construct('virtue_infobox_widget', __('Virtue: Info Box', 'virtue'), $widget_ops);
        $this->alt_option_name = 'virtue_infobox_widget';
    }

       public function widget($args, $instance){ 
        extract( $args );
        //title
        $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
        if(!empty($title)) { $title = '<h4>'.$title.'</h4>';} else {$title = '';}
        //description & link
        if(!empty($instance['description'])) { $description = $instance['description'];} else {$description = '';}
        if(!empty($instance['link'])) {$link = $instance["link"];} else {$link = '';}
        if ( function_exists( 'icl_t' )  && ! empty( $this->id_base ) ) {
            $description = icl_t( 'Widgets', 'info_box_description_' . $this->id_base, $description );
            $link = icl_t( 'Widgets', 'info_box_link_' . $this->id_base, $link );
        }
        if(!empty($description)) {$description = '<p>'.$description.'</p>';} else {$description = '';}
        if(!empty($link)) { $link = 'link='.$link; } else {$link = '';}

        if(!empty($instance['image_uri'])) {$imglink = esc_url($instance['image_uri']);} else {$imglink = '';}
        if(!empty($instance["info_icon"])) {$icon = 'icon='.$instance["info_icon"];} else {$icon = '';}
        if(!empty($instance["background"])) {$info_background = 'background='.$instance["background"];} else {$info_background = '';}
        if(!empty($instance["iconbackground"])) {$icon_background = 'iconbackground='.$instance["iconbackground"];} else {$icon_background = '';}
        if(!empty($instance["size"])) {$info_size = 'size='.$instance["size"];} else {$info_size = 'size=48';}
        if(!empty($instance["style"])) { $style = 'style='.$instance["style"]; } else {$style = '';}
        if(!empty($instance["color"])) { $color = 'color='.$instance["color"]; } else {$color = '';}
        if(!empty($instance["tcolor"])) { $tcolor = 'tcolor='.$instance["tcolor"]; } else {$tcolor = '';}
        if(!empty($imglink)) {$info_icon = 'image='.$imglink;} else {$info_icon = $icon;}

            ?>


          <?php echo $before_widget;
           echo do_shortcode('[infobox '.$link.' '.$info_icon.' '.$tcolor.' '.$info_size.' '.$info_background.' '.$style .' '.$icon_background.' '.$color.'] '.$title.' '. $description.'[/infobox]');
           echo $after_widget;?>

    <?php }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['info_icon'] = $new_instance['info_icon'];
        $instance['image_uri'] = strip_tags( $new_instance['image_uri'] );
        $instance['background'] = strip_tags( $new_instance['background'] );
        $instance['iconbackground'] = strip_tags($new_instance['iconbackground'] );
        $instance['color'] = strip_tags( $new_instance['color'] );
        $instance['tcolor'] = strip_tags( $new_instance['tcolor'] );
        $instance['size'] = (int) $new_instance['size']; 
        $instance['style'] = $new_instance['style'];
        $instance['description'] = strip_tags( $new_instance['description'] );
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['link'] = $new_instance['link'];
        if ( function_exists( 'icl_register_string' ) ) {
            icl_register_string( 'Widgets', 'info_box_description_' . $this->id_base, $instance['description'] );
            icl_register_string( 'Widgets', 'info_box_link_' . $this->id_base, $instance['link'] ) ;
        }
        $this->flush_widget_cache();
        return $instance;
    }
      function flush_widget_cache() {
        wp_cache_delete('virtue_infobox_widget', 'widget');
      }

  public function form($instance){ 
    $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
    $link = isset($instance['link']) ? esc_attr($instance['link']) : '';
    $background = isset($instance['background']) ? esc_attr($instance['background']) : '';
    $iconbackground = isset($instance['iconbackground']) ? esc_attr($instance['iconbackground']) : '';
    $color = isset($instance['color']) ? esc_attr($instance['color']) : '';
    $tcolor = isset($instance['tcolor']) ? esc_attr($instance['tcolor']) : '';
    $size = isset($instance['size']) ? esc_attr($instance['size']) : '';
    if (isset($instance['info_icon'])) { $info_icon = esc_attr($instance['info_icon']); } else {$info_icon = '';}
    $image_uri = isset($instance['image_uri']) ? esc_attr($instance['image_uri']) : '';
    if (isset($instance['style'])) { $style = esc_attr($instance['style']); } else {$style = 'none';}
    $icon_style_array = array();
    $icon_array = array();
    $icon_style_options = array(array("slug" => "none", "name" => __('None', 'virtue')), array("slug" => "kad-circle-iconclass", "name" => __('Circle', 'virtue')), array("slug" => "kad-square-iconclass", "name" => __('Square', 'virtue')));
    $icons = kad_icon_list();
    foreach ($icons as $icon) {
      if ($info_icon == $icon) { $selected=' selected="selected"';} else { $selected=""; }
      $icon_array[] = '<option value="' . $icon .'"' . $selected . '>' . $icon . '</option>';
    }
    foreach ($icon_style_options as $icon_style_option) {
      if ($style == $icon_style_option['slug']) { $selected=' selected="selected"';} else { $selected=""; }
      $icon_style_array[] = '<option value="' . $icon_style_option['slug'] .'"' . $selected . '>' . $icon_style_option['name'] . '</option>';
    }
    ?>  

    <div id="virtue_infobox_widget<?php echo esc_attr($this->get_field_id('container')); ?>" class="kad_img_upload_widget kad_infobox_widget">
            <p>
                <label for="<?php echo $this->get_field_id('info_icon'); ?>"><?php _e('Choose an Icon', 'virtue'); ?></label><br />
                <select id="<?php echo $this->get_field_id('info_icon'); ?>" class="kad_icomoon" name="<?php echo $this->get_field_name('info_icon'); ?>"><?php echo implode('', $icon_array);?></select>
            </p>
            <p>
            <img class="kad_custom_media_image" src="<?php if(!empty($instance['image_uri'])){echo $instance['image_uri'];} ?>" style="margin:0;padding:0;max-width:100px;display:block" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('image_uri'); ?>"><?php _e('Or upload a custom icon', 'virtue'); ?></label><br />
                <input type="text" class="widefat kad_custom_media_url" name="<?php echo $this->get_field_name('image_uri'); ?>" id="<?php echo $this->get_field_id('image_uri'); ?>" value="<?php echo $image_uri; ?>">
                <input type="button" value="<?php _e('Upload', 'virtue'); ?>" class="button kad_custom_media_upload" id="kad_custom_image_uploader" />
            </p>
            <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'virtue'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            </p>
             <p>
              <label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('Description', 'virtue'); ?></label><br />
              <textarea name="<?php echo $this->get_field_name('description'); ?>" style="min-height: 100px;" id="<?php echo $this->get_field_id('description'); ?>" class="widefat" ><?php if(!empty($instance['description'])) echo $instance['description']; ?></textarea>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('background'); ?>"><?php _e('Box Background Color (e.g. = #f2f2f2)', 'virtue'); ?></label><br />
                <input type="text" class="widefat kad-widget-colorpicker" style="width: 70px;"  name="<?php echo $this->get_field_name('background'); ?>" id="<?php echo $this->get_field_id('background'); ?>" value="<?php echo $background; ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('tcolor'); ?>"><?php _e('Text Color (e.g. = #444444)', 'virtue'); ?></label><br />
                <input type="text" class="widefat kad-widget-colorpicker" style="width: 70px;"  name="<?php echo $this->get_field_name('tcolor'); ?>" id="<?php echo $this->get_field_id('tcolor'); ?>" value="<?php echo $tcolor; ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('size'); ?>"><?php _e('Icon Size (e.g. = 48)', 'virtue'); ?></label><br />
                <input type="number" class="widefat kad_img_widget_link" name="<?php echo $this->get_field_name('size'); ?>" id="<?php echo $this->get_field_id('size'); ?>" value="<?php echo $size; ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('style'); ?>"><?php _e('Icon Style', 'virtue'); ?></label><br />
                <select id="<?php echo $this->get_field_id('style'); ?>" style="width:100%; max-width:230px;" name="<?php echo $this->get_field_name('style'); ?>"><?php echo implode('', $icon_style_array);?></select>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('iconbackground'); ?>"><?php _e('Icon Background Color (e.g. = #444444)', 'virtue'); ?></label><br />
                <input type="text" class="widefat kad-widget-colorpicker" style="width: 70px;"  name="<?php echo $this->get_field_name('iconbackground'); ?>" id="<?php echo $this->get_field_id('iconbackground'); ?>" value="<?php echo $iconbackground; ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('color'); ?>"><?php _e('Icon Color (e.g. = #f2f2f2)', 'virtue'); ?></label><br />
                <input type="text" class="widefat kad-widget-colorpicker" style="width: 70px;"  name="<?php echo $this->get_field_name('color'); ?>" id="<?php echo $this->get_field_id('color'); ?>" value="<?php echo $color; ?>">
            </p>
            <p>
            <label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Link:', 'virtue'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo $link; ?>" />
            </p>

    </div>

<?php } }

class kad_gmap_widget extends WP_Widget{

function kad_gmap_widget() {
        $widget_ops = array('classname' => 'virtue_gmap_widget', 'description' => __('Adds a google map to a widget area', 'virtue'));
        $this->__construct('virtue_gmap_widget', __('Virtue: Google Map', 'virtue'), $widget_ops);
        $this->alt_option_name = 'virtue_gmap_widget';
    }

       public function widget($args, $instance){ 
        extract( $args ); 
        if(!empty($instance["location"])) {$location = $instance["location"];} else {$location = '';}
        if(!empty($instance["locationtitle"])) {$locationtitle = $instance["locationtitle"];} else {$locationtitle = '';}
        if(!empty($instance["location2"])) {$location2 = 'address2="'.$instance["location2"].'"';} else {$location2 = '';}
        if(!empty($instance["locationtitle2"])) {$locationtitle2 = 'title2="'.$instance["locationtitle2"].'"';} else {$locationtitle2 = '';}
        if(!empty($instance["location3"])) {$location3 = 'address3="'.$instance["location3"].'"';} else {$location3 = '';}
        if(!empty($instance["locationtitle3"])) {$locationtitle3 = 'title3="'.$instance["locationtitle3"].'"';} else {$locationtitle3 = '';}
        if(!empty($instance["location4"])) {$location4 = 'address4="'.$instance["location4"].'"';} else {$location4 = '';}
        if(!empty($instance["locationtitle4"])) {$locationtitle4 = 'title4="'.$instance["locationtitle4"].'"';} else {$locationtitle4 = '';}
        if(!empty($instance["center"])) {$center = 'center="'.$instance["center"].'"';} else {$center = '';}
        if(!empty($instance['height'])) {$height = 'height="'.esc_attr($instance['height']).'"';} else {$height = '';}
        if(!empty($instance["maptype"])) {$maptype = 'maptype='.$instance["maptype"];} else {$maptype = '';}
        if(!empty($instance["zoom"])) {$zoom = 'zoom='.$instance["zoom"];} else {$zoom = '';}
        if(!empty($instance["loadscripts"])) {$loadscripts = 'loadscripts='.$instance["loadscripts"];} else {$loadscripts = '';}
            ?>


          <?php echo $before_widget;
           echo do_shortcode('[gmap address="'.$location.'" title="'.$locationtitle.'" '.$height.' '.$maptype.' '.$zoom. ' '.$location2.' '.$location3.' '.$location4.' '.$center.' '.$locationtitle2.' '.$locationtitle3.' '.$locationtitle4.' '.$loadscripts.']');
           echo $after_widget;?>

    <?php }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['locationtitle'] = strip_tags( $new_instance['locationtitle'] );
        $instance['location'] = $new_instance['location'];
        $instance['locationtitle2'] = strip_tags( $new_instance['locationtitle2'] );
        $instance['location2'] = $new_instance['location2'];
        $instance['locationtitle3'] = strip_tags( $new_instance['locationtitle3'] );
        $instance['location3'] = $new_instance['location3'];
        $instance['locationtitle4'] = strip_tags( $new_instance['locationtitle4'] );
        $instance['location4'] = $new_instance['location4'];
        $instance['center'] = $new_instance['center'];
        $instance['height'] = (int) $new_instance['height'];
        $instance['maptype'] = $new_instance['maptype']; 
        $instance['zoom'] = $new_instance['zoom'];
        $instance['loadscripts'] = $new_instance['loadscripts'];
        $this->flush_widget_cache();
        return $instance;
    }
      function flush_widget_cache() {
        wp_cache_delete('virtue_gmap_widget', 'widget');
      }

  public function form($instance){
    $locationtitle = isset($instance['locationtitle']) ? esc_attr($instance['locationtitle']) : '';
    $locationtitle2 = isset($instance['locationtitle2']) ? esc_attr($instance['locationtitle2']) : '';
    $locationtitle3 = isset($instance['locationtitle3']) ? esc_attr($instance['locationtitle3']) : '';
    $locationtitle4 = isset($instance['locationtitle4']) ? esc_attr($instance['locationtitle4']) : '';
    $height = isset($instance['height']) ? esc_attr($instance['height']) : '';
    if (isset($instance['zoom'])) { $zoom = esc_attr($instance['zoom']); } else {$zoom = '15';}
    if (isset($instance['loadscripts'])) { $loadscripts = esc_attr($instance['loadscripts']); } else {$loadscripts = "true";}
    if (isset($instance['maptype'])) { $maptype = esc_attr($instance['maptype']); } else {$maptype = 'ROADMAP';}
    $map_type_array = array();
    $zoom_array = array();
    $loadscripts_array = array();
    $loadscripts_options = array(array("slug" => "true", "name" => __('True', 'virtue')), array("slug" => "false", "name" => __('False', 'virtue')));
    $map_type_options = array(array("slug" => "ROADMAP", "name" => __('ROADMAP', 'virtue')), array("slug" => "HYBRID", "name" => __('HYBRID', 'virtue')), array("slug" => "TERRAIN", "name" => __('TERRAIN', 'virtue')), array("slug" => "SATELLITE", "name" => __('SATELLITE', 'virtue')));
    $zoom_options = array(array("slug" => "1"), array("slug" => "2"), array("slug" => "3"), array("slug" => "4"), array("slug" => "5"), array("slug" => "6"), array("slug" => "7"), array("slug" => "8"), array("slug" => "9"), array("slug" => "10"), array("slug" => "11"), array("slug" => "12"), array("slug" => "13"), array("slug" => "14"), array("slug" => "15"), array("slug" => "16"), array("slug" => "17"), array("slug" => "18"), array("slug" => "19"), array("slug" => "20"), array("slug" => "21"));
    foreach ($zoom_options as $zoom_option) {
      if ($zoom == $zoom_option['slug']) { $selected=' selected="selected"';} else { $selected=""; }
      $zoom_array[] = '<option value="' . $zoom_option['slug'] .'"' . $selected . '>' . $zoom_option['slug'] . '</option>';
    }
    foreach ($map_type_options as $map_type_option) {
      if ($maptype == $map_type_option['slug']) { $selected=' selected="selected"';} else { $selected=""; }
      $map_type_array[] = '<option value="' . $map_type_option['slug'] .'"' . $selected . '>' . $map_type_option['name'] . '</option>';
    }
    foreach ($loadscripts_options as $loadscripts_option) {
      if ($loadscripts == $loadscripts_option['slug']) { $selected=' selected="selected"';} else { $selected=""; }
      $loadscripts_array[] = '<option value="' . $loadscripts_option['slug'] .'"' . $selected . '>' . $loadscripts_option['name'] . '</option>';
    }
    ?>  

    <div id="virtue_gmap_widget<?php echo esc_attr($this->get_field_id('container')); ?>" class="kad_gmap_widget">
            <p>
            <label for="<?php echo $this->get_field_id('locationtitle'); ?>"><?php _e('Marker Title:', 'virtue'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('locationtitle'); ?>" name="<?php echo $this->get_field_name('locationtitle'); ?>" type="text" value="<?php echo $locationtitle; ?>" />
            </p>
            <p>
              <label for="<?php echo $this->get_field_id('location'); ?>"><?php _e('Marker Address', 'virtue'); ?></label><br />
              <textarea name="<?php echo $this->get_field_name('location'); ?>" style="min-height: 50px;" id="<?php echo $this->get_field_id('location'); ?>" class="widefat" ><?php if(!empty($instance['location'])) echo $instance['location']; ?></textarea>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('maptype'); ?>"><?php _e('Map Type', 'virtue'); ?></label><br />
                <select id="<?php echo $this->get_field_id('maptype'); ?>" name="<?php echo $this->get_field_name('maptype'); ?>"><?php echo implode('', $map_type_array);?></select>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('zoom'); ?>"><?php _e('Map Zoom', 'virtue'); ?></label><br />
                <select id="<?php echo $this->get_field_id('zoom'); ?>" style="width:100%; max-width:230px;" name="<?php echo $this->get_field_name('zoom'); ?>"><?php echo implode('', $zoom_array);?></select>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Map Height (e.g. = 300)', 'virtue'); ?></label><br />
                <input type="text" class="widefat kad_map_widget_height" name="<?php echo $this->get_field_name('height'); ?>" id="<?php echo $this->get_field_id('height'); ?>" value="<?php echo $height; ?>">
            </p>
            <p>
            <label for="<?php echo $this->get_field_id('locationtitle2'); ?>"><?php _e('Marker Title Two:', 'virtue'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('locationtitle2'); ?>" name="<?php echo $this->get_field_name('locationtitle2'); ?>" type="text" value="<?php echo $locationtitle2; ?>" />
            </p>
            <p>
              <label for="<?php echo $this->get_field_id('location2'); ?>"><?php _e('Marker Address Two', 'virtue'); ?></label><br />
              <textarea name="<?php echo $this->get_field_name('location2'); ?>" style="min-height: 50px;" id="<?php echo $this->get_field_id('location2'); ?>" class="widefat" ><?php if(!empty($instance['location2'])) echo $instance['location2']; ?></textarea>
            </p>
            <p>
            <label for="<?php echo $this->get_field_id('locationtitle3'); ?>"><?php _e('Marker Title Three:', 'virtue'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('locationtitle3'); ?>" name="<?php echo $this->get_field_name('locationtitle3'); ?>" type="text" value="<?php echo $locationtitle3; ?>" />
            </p>
            <p>
              <label for="<?php echo $this->get_field_id('location3'); ?>"><?php _e('Marker Address Three', 'virtue'); ?></label><br />
              <textarea name="<?php echo $this->get_field_name('location3'); ?>" style="min-height: 50px;" id="<?php echo $this->get_field_id('location3'); ?>" class="widefat" ><?php if(!empty($instance['location3'])) echo $instance['location3']; ?></textarea>
            </p>
            <p>
            <label for="<?php echo $this->get_field_id('locationtitle4'); ?>"><?php _e('Marker Title Four:', 'virtue'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('locationtitle4'); ?>" name="<?php echo $this->get_field_name('locationtitle4'); ?>" type="text" value="<?php echo $locationtitle4; ?>" />
            </p>
            <p>
              <label for="<?php echo $this->get_field_id('location4'); ?>"><?php _e('Marker Address Four', 'virtue'); ?></label><br />
              <textarea name="<?php echo $this->get_field_name('location4'); ?>" style="min-height: 50px;" id="<?php echo $this->get_field_id('location4'); ?>" class="widefat" ><?php if(!empty($instance['location4'])) echo $instance['location4']; ?></textarea>
            </p>
            <p>
              <label for="<?php echo $this->get_field_id('center'); ?>"><?php _e('Map Center (defauts to first address)', 'virtue'); ?></label><br />
              <textarea name="<?php echo $this->get_field_name('center'); ?>" style="min-height: 50px;" id="<?php echo $this->get_field_id('center'); ?>" class="widefat" ><?php if(!empty($instance['center'])) echo $instance['center']; ?></textarea>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('loadscripts'); ?>"><?php _e('Load Core Google Scripts? (Only turn this off if this is the second+ map on a page)', 'virtue'); ?></label><br />
                <select id="<?php echo $this->get_field_id('loadscripts'); ?>" style="width:100%; max-width:230px;" name="<?php echo $this->get_field_name('loadscripts'); ?>"><?php echo implode('', $loadscripts_array);?></select>
            </p>
    </div>

<?php } }

class kad_calltoaction_widget extends WP_Widget{

function kad_calltoaction_widget() {
        $widget_ops = array('classname' => 'virtue_calltoaction_widget', 'description' => __('Adds a simple call to action', 'virtue'));
        $this->__construct('virtue_calltoaction_widget', __('Virtue: Call to Action', 'virtue'), $widget_ops);
        $this->alt_option_name = 'virtue_calltoaction_widget';
    }

       public function widget($args, $instance){ 
        extract( $args );
        //title
        $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
        if(!empty($title)) {$title = $title;} else {$title = '';}
        //description & btn_link
        if(!empty($instance["subtitle"])) { $subtitle = $instance['subtitle'];} else {$subtitle = '';}
        if(!empty($instance["btn_link"])) {$btn_link = $instance["btn_link"];} else {$btn_link = '';}
        if(!empty($instance["btn_text"])) {$btn_text = $instance["btn_text"];} else {$btn_text = '';}
        if ( function_exists( 'icl_t' )  && ! empty( $this->id_base ) ) {
            $subtitle = icl_t( 'Widgets', 'call_to_action_subtitle_' . $this->id_base, $subtitle );
            $btn_link = icl_t( 'Widgets', 'call_to_action_btn_link_' . $this->id_base, $btn_link );
            $btn_text = icl_t( 'Widgets', 'call_to_action_btn_text_' . $this->id_base, $btn_text );
        }
        if(!empty($instance["btn_target"])) {$btn_target = $instance["btn_target"];} else {$btn_target = 'false';}
        if(!empty($instance["tsize"])) {$tsize = 'font-size:'.$instance["tsize"].'px;';} else {$tsize = '';}
        if(!empty($instance["ssize"])) {$ssize = 'font-size:'.$instance["ssize"].'px;';} else {$ssize = '';}
        if(!empty($instance["tlineheight"])) {$tlineheight = 'line-height:'.$instance["tlineheight"].'px;';} else {$tlineheight = '';}
        if(!empty($instance["slineheight"])) {$slineheight = 'line-height:'.$instance["slineheight"].'px;';} else {$slineheight = '';}
        if(!empty($instance["align"])) { $align = $instance["align"];} else {$align = 'center';}
        if(!empty($instance["tcolor"])) { $tcolor = 'color:'.$instance["tcolor"].';'; } else {$tcolor = '';}
        if(!empty($instance["scolor"])) { $scolor = 'color:'.$instance["scolor"].';'; } else {$scolor = '';}
            ?>


          <?php echo $before_widget;
            echo '<h1 style="'.$tcolor.' '.$tsize.' '.$tlineheight.' text-align:'.$align.';">'.$title.'</h1>';
            if($subtitle) { echo '<h5 style="'.$scolor.' '.$ssize.' '.$slineheight.' text-align:'.$align.';">'.$subtitle.'</h5>'; }
            echo '<div style="text-align:'.$align.'">';
            echo do_shortcode('[btn text="'.$btn_text.'" tcolor="#ffffff" link="'.$btn_link.'" size="large" target="'.$btn_target.'" font="h1-family"]');
            echo '</div>';
           echo $after_widget;?>

    <?php }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['align'] = $new_instance['align'];
        $instance['btn_target'] = $new_instance['btn_target'];
        $instance['btn_link'] = strip_tags( $new_instance['btn_link'] );
        $instance['btn_text'] = strip_tags( $new_instance['btn_text'] );
        $instance['tcolor'] = strip_tags( $new_instance['tcolor'] );
        $instance['scolor'] = strip_tags( $new_instance['scolor'] );
        $instance['tsize'] = (int) $new_instance['tsize'];
        $instance['ssize'] = (int) $new_instance['ssize']; 
        $instance['tlineheight'] = (int) $new_instance['tlineheight'];
        $instance['slineheight'] = (int) $new_instance['slineheight']; 
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['subtitle'] = strip_tags( $new_instance['subtitle'] );
        if ( function_exists( 'icl_register_string' ) ) {
            icl_register_string( 'Widgets', 'call_to_action_subtitle_' . $this->id_base, $instance['subtitle'] );
            icl_register_string( 'Widgets', 'call_to_action_btn_link_' . $this->id_base, $instance['btn_link'] );
            icl_register_string( 'Widgets', 'call_to_action_btn_text_' . $this->id_base, $instance['btn_text'] );
        }
        $this->flush_widget_cache();
        return $instance;
    }
      function flush_widget_cache() {
        wp_cache_delete('virtue_calltoaction_widget', 'widget');
      }

  public function form($instance){ 
    $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
    $subtitle = isset($instance['subtitle']) ? esc_attr($instance['subtitle']) : '';
    $tcolor = isset($instance['tcolor']) ? esc_attr($instance['tcolor']) : '';
    $scolor = isset($instance['scolor']) ? esc_attr($instance['scolor']) : '';
    $tsize = isset($instance['tsize']) ? esc_attr($instance['tsize']) : '';
    $ssize = isset($instance['ssize']) ? esc_attr($instance['ssize']) : '';
    $tlineheight = isset($instance['tlineheight']) ? esc_attr($instance['tlineheight']) : '';
    $slineheight = isset($instance['slineheight']) ? esc_attr($instance['slineheight']) : '';
    $btn_link = isset($instance['btn_link']) ? esc_attr($instance['btn_link']) : '';
    $btn_text = isset($instance['btn_text']) ? esc_attr($instance['btn_text']) : '';
    if (isset($instance['align'])) { $align = esc_attr($instance['align']); } else {$align = 'center';}
    if (isset($instance['btn_target'])) { $btn_target = esc_attr($instance['btn_target']); } else {$btn_target = 'false';}
    $align_array = array();
    $btn_target_array = array();
    $align_options = array(array("slug" => "center", "name" => __('Center', 'virtue')), array("slug" => "left", "name" => __('Left', 'virtue')), array("slug" => "right", "name" => __('Right', 'virtue')));
    $btn_target_options = array(array("slug" => "false", "name" => __('Self', 'virtue')), array("slug" => "true", "name" => __('New Window', 'virtue')));
    foreach ($align_options as $align_option) {
      if ($align == $align_option['slug']) { $selected=' selected="selected"';} else { $selected=""; }
      $align_array[] = '<option value="' . $align_option['slug'] .'"' . $selected . '>' . $align_option['name'] . '</option>';
    }
    foreach ($btn_target_options as $btn_target_option) {
      if ($btn_target == $btn_target_option['slug']) { $selected=' selected="selected"';} else { $selected=""; }
      $btn_target_array[] = '<option value="' . $btn_target_option['slug'] .'"' . $selected . '>' . $btn_target_option['name'] . '</option>';
    }
    ?>  

    <div id="virtue_calltoaction_widget<?php echo esc_attr($this->get_field_id('container')); ?>" class="kad_calltoaction_widget kad-colorpick">
            <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'virtue'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('tsize'); ?>"><?php _e('Title Size (e.g. = 48)', 'virtue'); ?></label><br />
                <input type="number" class="widefat kad_img_widget_link" name="<?php echo $this->get_field_name('tsize'); ?>" id="<?php echo $this->get_field_id('tsize'); ?>" style="width: 70px;" value="<?php echo $tsize; ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('tlineheight'); ?>"><?php _e('Title Line height (e.g. = 48)', 'virtue'); ?></label><br />
                <input type="number" class="widefat kad_img_widget_link" name="<?php echo $this->get_field_name('tlineheight'); ?>" id="<?php echo $this->get_field_id('tlineheight'); ?>" style="width: 70px;" value="<?php echo $tlineheight; ?>">
            </p>
             <p>
                <label for="<?php echo $this->get_field_id('tcolor'); ?>"><?php _e('Title Color (e.g. = #f2f2f2)', 'virtue'); ?></label><br />
                <input type="text" class="kad-widget-colorpicker" name="<?php echo $this->get_field_name('tcolor'); ?>" id="<?php echo $this->get_field_id('tcolor'); ?>" style="width: 70px;" value="<?php echo $tcolor; ?>">
            </p>
             <p>
              <label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Subtitle', 'virtue'); ?></label><br />
              <textarea name="<?php echo $this->get_field_name('subtitle'); ?>" style="min-height: 50px;" id="<?php echo $this->get_field_id('subtitle'); ?>" class="widefat" ><?php echo $subtitle; ?></textarea>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('ssize'); ?>"><?php _e('Subtitle Size (e.g. = 48)', 'virtue'); ?></label><br />
                <input type="number" class="widefat kad_img_widget_link" name="<?php echo $this->get_field_name('ssize'); ?>" id="<?php echo $this->get_field_id('ssize'); ?>" style="width: 70px;" value="<?php echo $ssize; ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('slineheight'); ?>"><?php _e('Subtitle Line Height (e.g. = 48)', 'virtue'); ?></label><br />
                <input type="number" class="widefat kad_img_widget_link" name="<?php echo $this->get_field_name('slineheight'); ?>" id="<?php echo $this->get_field_id('slineheight'); ?>" style="width: 70px;" value="<?php echo $slineheight; ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('scolor'); ?>"><?php _e('Subtitle Color (e.g. = #f2f2f2)', 'virtue'); ?></label><br />
                <input type="text" class="widefat kad-widget-colorpicker" name="<?php echo $this->get_field_name('scolor'); ?>" id="<?php echo $this->get_field_id('scolor'); ?>" value="<?php echo $scolor; ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('align'); ?>"><?php _e('Align', 'virtue'); ?></label><br />
                <select id="<?php echo $this->get_field_id('align'); ?>" style="width:100%; max-width:230px;" name="<?php echo $this->get_field_name('align'); ?>"><?php echo implode('', $align_array);?></select>
            </p>
            <p>
            <label for="<?php echo $this->get_field_id('btn_text'); ?>"><?php _e('Button Text:', 'virtue'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('btn_text'); ?>" name="<?php echo $this->get_field_name('btn_text'); ?>" type="text" value="<?php echo $btn_text; ?>" />
            </p>
            <p>
            <label for="<?php echo $this->get_field_id('btn_link'); ?>"><?php _e('Button Link:', 'virtue'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('btn_link'); ?>" name="<?php echo $this->get_field_name('btn_link'); ?>" type="text" value="<?php echo $btn_link; ?>" />
            </p>
             <p>
                <label for="<?php echo $this->get_field_id('btn_target'); ?>"><?php _e('Link Target', 'virtue'); ?></label><br />
                <select id="<?php echo $this->get_field_id('btn_target'); ?>" style="width:100%; max-width:230px;" name="<?php echo $this->get_field_name('btn_target'); ?>"><?php echo implode('', $btn_target_array);?></select>
            </p>
    </div>

<?php } }

class kad_imgmenu_widget extends WP_Widget{

function kad_imgmenu_widget() {
        $widget_ops = array('classname' => 'virtue_imgmenu_widget', 'description' => __('Adds an image background with text, link and hover effect.', 'virtue'));
        $this->__construct('virtue_imgmenu_widget', __('Virtue: Image Menu Item', 'virtue'), $widget_ops);
        $this->alt_option_name = 'virtue_imgmenu_widget';
    }

       public function widget($args, $instance){ 
        extract( $args ); 
        $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
        if(!empty($instance["description"])) {$description = $instance["description"];} else {$description = '';}
        if(!empty($instance['image_uri'])) {$image = esc_url($instance['image_uri']);} else {$image = virtue_img_placeholder();}
        if(!empty($instance["height"])) { $height = $instance["height"];} else {$height = '210';}
        if(!empty($instance["link"])) { $link = $instance["link"];} else {$link = '#';}
        if(!empty($instance["height_setting"])) { $height_setting = $instance["height_setting"];} else {$height_setting = 'normal';}
        if(!empty($instance["target"]) && $instance["target"] == 'true') { $linktarget = 'target="_blank"';} else {$linktarget = '';}
            ?>

                <?php echo $before_widget; ?>
                <?php if($height_setting == 'imgsize') { ?>

                            <div class="kad-animation image-menu-image-size" data-animation="fade-in" data-delay="150">
                                    <?php if(!empty($link)) {echo '<a href="'.esc_attr($link).'" class="homepromolink" target="'.esc_attr($linktarget).'">';} ?>
                                        <div class="image_menu_hover_class"></div>
                                        <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title);?>" />
                                        <div class="image_menu_content">
                                            <div class="image_menu_message">    
                                                <?php if (!empty($title)) {echo '<h4>'.$title.'</h4>';} ?>
                                                <?php if (!empty($description)) {echo '<h5>'.$description.'</h5>';}?>
                                            </div>
                                        </div>
                                    <?php if(!empty($link)) {echo '</a>'; }?>
                                </div>
                 <?php } else { ?>
                <div class="kad-animation" data-animation="fade-in" data-delay="150">
                    <?php if(!empty($link)) echo '<a href="'.esc_url($link).'" '.esc_attr($linktarget).' class="homepromolink">'; ?>
                        <div class="infobanner" style="background: url(<?php echo esc_url($image); ?>) center center no-repeat; height:<?php echo esc_attr($height) ?>px; <?php echo 'background-size:cover;';?>">
                            <div class="home-message" style="height:<?php echo esc_attr($height) ?>px;">
                                <?php if (!empty($title)) echo '<h4>'.$title.'</h4>'; ?>
                                <?php if (!empty($description)) echo '<h5>'.$description.'</h5>';?>
                            </div>
                        </div>
                    <?php if(!empty($link)) echo '</a>'; ?>
                </div>
                <?php } ?>
                <?php echo $after_widget;?>

    <?php }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['image_uri'] = strip_tags( $new_instance['image_uri'] );
        $instance['description'] = strip_tags( $new_instance['description'] );
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['link'] = $new_instance['link'];
        $instance['height'] = (int) $new_instance['height'];
        $instance['target'] = $new_instance['target'];
        $instance['height_setting'] = $new_instance['height_setting'];
        $this->flush_widget_cache();
        return $instance;
    }
      function flush_widget_cache() {
        wp_cache_delete('virtue_imgmenu_widget', 'widget');
      }

  public function form($instance){ 
    $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
    $link = isset($instance['link']) ? esc_attr($instance['link']) : '';
    $height = isset($instance['height']) ? esc_attr($instance['height']) : '';
    $image_uri = isset($instance['image_uri']) ? esc_attr($instance['image_uri']) : '';
    if (isset($instance['target'])) { $target = esc_attr($instance['target']); } else {$target = 'false';}
    if (isset($instance['height_setting'])) { $height_setting = esc_attr($instance['height_setting']); } else {$height_setting = 'normal';}
    $height_options = array(array("slug" => "normal", "name" => __('Height setting Above', 'virtue')), array("slug" => "imgsize", "name" => __('Image Size', 'virtue')));
    $target_options = array(array("slug" => "false", "name" => __('Self', 'virtue')), array("slug" => "true", "name" => __('New Window', 'virtue')));
    foreach ($target_options as $target_option) {
      if ($target == $target_option['slug']) { $selected=' selected="selected"';} else { $selected=""; }
      $target_array[] = '<option value="' . $target_option['slug'] .'"' . $selected . '>' . $target_option['name'] . '</option>';
    }
    foreach ($height_options as $height_option) {
      if ($height_setting == $height_option['slug']) { $selected=' selected="selected"';} else { $selected=""; }
      $height_array[] = '<option value="' . $height_option['slug'] .'"' . $selected . '>' . $height_option['name'] . '</option>';
    }
    ?>  

    <div id="virtue_imgmenu_widget<?php echo esc_attr($this->get_field_id('container')); ?>" class="kad_img_upload_widget kad_infobox_widget">
            <p>
            <img class="kad_custom_media_image" src="<?php if(!empty($instance['image_uri'])){echo $instance['image_uri'];} ?>" style="margin:0;padding:0;max-width:100px;display:block" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('image_uri'); ?>"><?php _e('Upload an image', 'virtue'); ?></label><br />
                <input type="text" class="widefat kad_custom_media_url" name="<?php echo $this->get_field_name('image_uri'); ?>" id="<?php echo $this->get_field_id('image_uri'); ?>" value="<?php echo $image_uri; ?>">
                <input type="button" value="<?php _e('Upload', 'virtue'); ?>" class="button kad_custom_media_upload" id="kad_custom_image_uploader" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Item Height (e.g. = 220)', 'virtue'); ?></label><br />
                <input type="number" class="widefat kad_img_widget_link" name="<?php echo $this->get_field_name('height'); ?>" id="<?php echo $this->get_field_id('height'); ?>" style="width: 70px;" value="<?php echo $height; ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('height_setting'); ?>"><?php _e('Height set by:', 'virtue'); ?></label><br />
                <select id="<?php echo $this->get_field_id('height_setting'); ?>" style="width:100%; max-width:230px;" name="<?php echo $this->get_field_name('height_setting'); ?>"><?php echo implode('', $height_array);?></select>
            </p>
            <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'virtue'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            </p>
             <p>
              <label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('Description', 'virtue'); ?></label><br />
              <textarea name="<?php echo $this->get_field_name('description'); ?>" style="min-height: 20px;" id="<?php echo $this->get_field_id('description'); ?>" class="widefat" ><?php if(!empty($instance['description'])) echo $instance['description']; ?></textarea>
            </p>
            <p>
            <label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Link:', 'virtue'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo $link; ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('target'); ?>"><?php _e('Link Target', 'virtue'); ?></label><br />
                <select id="<?php echo $this->get_field_id('target'); ?>" style="width:100%; max-width:230px;" name="<?php echo $this->get_field_name('target'); ?>"><?php echo implode('', $target_array);?></select>
            </p>

    </div>

<?php } }
