<?php
/*
Template Name: Blog Grid
*/
?>

	<div id="pageheader" class="titleclass">
		<div class="container">
			<?php get_template_part('templates/page', 'header'); ?>
		</div><!--container-->
	</div><!--titleclass-->
	
    <div id="content" class="container">
   		<div class="row">
   			<?php global $post, $virtue_premium;
   			if(isset($virtue_premium['virtue_animate_in']) && $virtue_premium['virtue_animate_in'] == 1) {$animate = 1;} else {$animate = 0;} 
   			if(isset($virtue_premium['blog_infinitescroll']) && $virtue_premium['blog_infinitescroll'] == 1) {$infinitescroll = true;} else {$infinitescroll = false;}
   			$blog_grid_column = get_post_meta( $post->ID, '_kad_blog_columns', true );
   			if ($blog_grid_column == 'twocolumn') {$itemsize = 'tcol-md-6 tcol-sm-6 tcol-xs-12 tcol-ss-12'; $slidewidth = 559; $slideheight = 559; $md = 2; $sm = 2; $xs = 1; $ss = 1;} 
		    else if ($blog_grid_column == 'threecolumn'){ $itemsize = 'tcol-md-4 tcol-sm-4 tcol-xs-6 tcol-ss-12'; $slidewidth = 366; $slideheight = 366; $md = 3; $sm = 3; $xs = 2; $ss = 1;} 
		    else {$itemsize = 'tcol-md-3 tcol-sm-4 tcol-xs-6 tcol-ss-12'; $slidewidth = 269; $slideheight = 269; $md = 4; $sm = 3; $xs = 2; $ss = 1;}
      		$blog_category = get_post_meta( $post->ID, '_kad_blog_cat', true ); 
					$blog_cat= get_term_by ('id',$blog_category,'category');
					if($blog_category == '-1' || $blog_category == '') {
      					$blog_cat_slug = '';
					} else {
					$blog_cat = get_term_by ('id',$blog_category,'category');
					$blog_cat_slug = $blog_cat -> slug;
					}
					$blog_items = get_post_meta( $post->ID, '_kad_blog_items', true ); 
					if($blog_items == 'all') {$blog_items = '-1';} 
					?>
      <div class="main <?php echo kadence_main_class();?>" id="ktmain" role="main">
      	<div class="entry-content" itemprop="mainContentOfPage">
					<?php get_template_part('templates/content', 'page'); ?>
		</div>
      	<div id="kad-blog-grid" class="rowtight " data-fade-in="<?php echo $animate;?>">
      		<?php   $temp = $wp_query; 
					$wp_query = null; 
					$wp_query = new WP_Query();
					$wp_query->query(array(
						'paged' => $paged,
						'category_name'=>$blog_cat_slug,
						'posts_per_page' => $blog_items));
					$count =0;
					if ( $wp_query ) : while ( $wp_query->have_posts() ) : $wp_query->the_post();
						if($blog_grid_column == 'twocolumn') { ?>
							<div class="<?php echo esc_attr($itemsize);?> b_item kad_blog_item">
							<?php get_template_part('templates/content', 'twogrid'); ?>
							</div>
						<?php } else {?>
							<div class="<?php echo esc_attr($itemsize);?> b_item kad_blog_item">
							<?php get_template_part('templates/content', 'fourgrid');?>
							</div>
						<?php }
                    endwhile; else: ?>
						<li class="error-not-found"><?php _e('Sorry, no blog entries found.', 'virtue'); ?></li>
					<?php endif; ?>
                

                </div> <!-- Blog Grid -->
				<?php if ($wp_query->max_num_pages > 1) : ?>
				<?php if(function_exists('kad_wp_pagenavi')) { ?>
        			<?php kad_wp_pagenavi(); ?>   
        		<?php } else { ?>      
			        <nav class="post-nav">
		                <ul class="pager">
		                  <li class="previous"><?php next_posts_link(__('&larr; Older posts', 'virtue')); ?></li>
		                  <li class="next"><?php previous_posts_link(__('Newer posts &rarr;', 'virtue')); ?></li>
		                </ul>
		              </nav>
        		<?php } ?> 
				<?php endif; ?>
				<?php $wp_query = null; $wp_query = $temp;  // Reset ?>
				<?php wp_reset_query(); ?>
	<script type="text/javascript">jQuery(document).ready(function ($) {var $container = $('#kad-blog-grid');$container.imagesLoadedn( function(){$container.isotopeb({masonry: {columnWidth: ".b_item"}, transitionDuration: "0.8s"});if($('#kad-blog-grid').attr('data-fade-in') == 1) {$('#kad-blog-grid .kad_blog_fade_in').css('opacity',0); $('#kad-blog-grid .kad_blog_fade_in').each(function(i){$(this).delay(i*150).animate({'opacity':1},350);});}});					
<?php if ($infinitescroll) { ?>
$('#kad-blog-grid').infinitescroll({
    nextSelector: ".wp-pagenavi a.next",
    navSelector: ".wp-pagenavi",
    itemSelector: ".kad_blog_item",
    loading: {
    		msgText: "",
            finishedMsg: '',
            img: "<?php echo get_template_directory_uri() . '/assets/img/loader.gif'; ?>"
        }
    },
    	function( newElements ) {
         var $newElems = jQuery( newElements ).hide(); // hide to begin with
  			// ensure that images load before adding to masonry layout
		  $newElems.imagesLoadedn(function(){
		    $newElems.fadeIn(); // fade in when ready
		    $container.isotopeb( 'appended', $newElems );
		    if($container.attr('data-fade-in') == 1) {
					//fadeIn items one by one
						$newElems.each(function() {
					    $(this).find('.kad_blog_fade_in').delay($(this).attr('data-delay')).animate({'opacity' : 1, 'top' : 0},800,'swing');},{accX: 0, accY: -85},'easeInCubic');
					 
					} 
		  }); 

});	
<?php } ?>
				});
</script>
<?php global $virtue_premium; if(isset($virtue_premium['page_comments']) && $virtue_premium['page_comments'] == '1') { comments_template('/templates/comments.php');} ?>
</div><!-- /.main -->