<header id="kad-banner" class="banner headerclass" role="banner" data-header-shrink="0" data-mobile-sticky="0">
<?php if (kadence_display_topbar()) : ?>
  <?php get_template_part('templates/header', 'topbar'); ?>
<?php endif; ?>
<?php global $virtue_premium; if(isset($virtue_premium['logo_layout'])) {
            if($virtue_premium['logo_layout'] == 'logocenter') {$logocclass = 'col-md-12'; $menulclass = 'col-md-12';} 
            else if($virtue_premium['logo_layout'] == 'logohalf') {$logocclass = 'col-md-6'; $menulclass = 'col-md-6';}
            else if($virtue_premium['logo_layout'] == 'logowidget') {$logocclass = 'col-md-4'; $menulclass = 'col-md-12';}
            else {$logocclass = 'col-md-4'; $menulclass = 'col-md-8';}
          }
          else {$logocclass = 'col-md-4'; $menulclass = 'col-md-8';} ?>
  <div class="container">
    <div class="row">
          <div class="<?php echo esc_attr($logocclass); ?> clearfix kad-header-left">
            <div id="logo" class="logocase">
              <a class="brand logofont" href="<?php echo home_url(); ?>/">
                       <?php if (!empty($virtue_premium['x1_virtue_logo_upload']['url'])) { ?> 
                       <div id="thelogo"><img src="<?php echo esc_url($virtue_premium['x1_virtue_logo_upload']['url']); ?>" alt="<?php bloginfo('name');?>" class="kad-standard-logo" />
                         <?php if(!empty($virtue_premium['x2_virtue_logo_upload']['url'])) {?>
                          <img src="<?php echo esc_url($virtue_premium['x2_virtue_logo_upload']['url']);?>" class="kad-retina-logo" alt="<?php bloginfo('name');?>" style="max-height:<?php echo esc_attr($virtue_premium['x1_virtue_logo_upload']['height']);?>px" /> <?php } ?>
                        </div> <?php } else { echo apply_filters('kad_site_name', get_bloginfo('name')); } ?>
              </a>
              <?php if (!empty($virtue_premium['logo_below_text']) ) { ?> <p class="kad_tagline belowlogo-text"><?php echo $virtue_premium['logo_below_text']; ?></p> <?php }?>
            </div> <!-- Close #logo -->
          </div><!-- close col-md-4 -->
          <?php if(isset($virtue_premium['logo_layout']) && $virtue_premium['logo_layout'] == 'logowidget') { ?>
              <div class="col-md-8 kad-header-widget"> <?php 
                if(is_active_sidebar('headerwidget')) { dynamic_sidebar('headerwidget'); } ?>
              </div>
            </div>
          <div class="row"> 
          <?php } ?>
          <div class="<?php echo esc_attr($menulclass); ?> kad-header-right">
          <?php if (has_nav_menu('primary_navigation')) : ?>
            <?php do_action( 'virtue_above_primarymenu' ); ?>
            <nav id="nav-main" class="clearfix" role="navigation">
                <?php wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'sf-menu'));  ?>
            </nav>
           <?php  endif; ?>
          </div> <!-- Close span7 -->       
    </div> <!-- Close Row -->
    <?php if (has_nav_menu('mobile_navigation')) : ?>
           <div id="mobile-nav-trigger" class="nav-trigger">
              <button class="nav-trigger-case mobileclass" data-toggle="collapse" rel="nofollow" data-target=".mobile_menu_collapse">
                <span class="kad-navbtn clearfix"><i class="icon-menu"></i></span>
                <?php if(!empty($virtue_premium['mobile_menu_text'])) {$menu_text = $virtue_premium['mobile_menu_text'];} else {$menu_text = __('Menu', 'virtue');} ?>
                <span class="kad-menu-name"><?php echo $menu_text; ?></span>
              </button>
            </div>
            <div id="kad-mobile-nav" class="kad-mobile-nav">
              <div class="kad-nav-inner mobileclass">
                <div id="mobile_menu_collapse" class="kad-nav-collapse collapse mobile_menu_collapse">
                  <?php if(isset($virtue_premium['menu_search']) && $virtue_premium['menu_search'] == '1') {  
                    get_search_form(); 
                  } 
                  if(isset($virtue_premium['mobile_submenu_collapse']) && $virtue_premium['mobile_submenu_collapse'] == '1') {
                    wp_nav_menu( array('theme_location' => 'mobile_navigation','items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>', 'menu_class' => 'kad-mnav', 'walker' => new kadence_mobile_walker()));
                  } else {
                    wp_nav_menu( array('theme_location' => 'mobile_navigation','items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>', 'menu_class' => 'kad-mnav'));
                  } ?>
               </div>
            </div>
          </div>   
          <?php  endif; ?> 
  </div> <!-- Close Container -->
  <?php do_action('kt_before_secondary_navigation'); ?>
  <?php if (has_nav_menu('secondary_navigation')) : ?>
  <section id="cat_nav" class="navclass">
    <div class="container">
     <nav id="nav-second" class="clearfix" role="navigation">
     <?php wp_nav_menu(array('theme_location' => 'secondary_navigation', 'menu_class' => 'sf-menu')); ?>
   </nav>
    </div><!--close container-->
    </section>
    <?php endif; ?> 
      <?php if (!empty($virtue_premium['virtue_banner_upload']['url'])) {  ?> 
        <div class="container virtue_sitewide_banner"><div class="virtue_banner">
          <?php if (!empty($virtue_premium['virtue_banner_link'])) { ?> <a href="<?php echo esc_url($virtue_premium['virtue_banner_link']);?>"> <?php }?>
          <?php $alt_text = get_post_meta($virtue_premium['virtue_banner_upload']['id'], '_wp_attachment_image_alt', true); ?>
          <img src="<?php echo esc_url($virtue_premium['virtue_banner_upload']['url']); ?>" width="<?php echo esc_attr($virtue_premium['virtue_banner_upload']['width']); ?>" height="<?php echo esc_attr($virtue_premium['virtue_banner_upload']['height']); ?>" alt="<?php echo esc_attr($alt_text);?>" /></div>
          <?php if (!empty($virtue_premium['virtue_banner_link'])) { ?> </a> <?php }?>
        </div> <?php } ?>
        <?php do_action('kt_after_header_content'); ?>
</header>