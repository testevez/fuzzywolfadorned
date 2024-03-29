<?php
//Shortcode for year
function kad_year_shortcode_function() {
    $year = date('Y');
	return $year;
}
function kad_copyright_shortcode_function() {
	return '&copy;';
}
function kad_sitename_shortcode_function() {
	$sitename = get_bloginfo('name');
	return $sitename;
}
function kad_themecredit_shortcode_function() {
	$my_theme = wp_get_theme();
	$output = '- Wordpress Theme by <a href="'.$my_theme->{'Author URI'}.'">Kadence Themes</a>';
	return $output;
}
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active('virtue-toolkit/virtue_toolkit.php') ) {
function virtue_plugin_admin_notice(){
    echo '<div class="error"><p>Please <strong>Disable</strong> the Virtue ToolKit Plugin. It is not needed with Virtue Premium.</p></div>';
}
add_action('admin_notices', 'virtue_plugin_admin_notice');
}

//Shortcode for accordion
function kadence_accordion_shortcode_function($atts, $content ) {
	extract(shortcode_atts(array(
'id' => rand(1, 99)
), $atts));
	$GLOBALS['pane_count'] = 0;
	$GLOBALS['panes'] = '';
	do_shortcode( $content );
	if( is_array( $GLOBALS['panes'] ) ){
		$i = 0;
	foreach( $GLOBALS['panes'] as $tab ){
		if ($i % 2 == 0) {$eo = "even";} else {$eo = "odd";}
	$tabs[] = '<div class="panel panel-default panel-'.$eo.'"><div class="panel-heading"><a class="accordion-toggle '.$tab['open'].'" data-toggle="collapse" data-parent="#accordionname'.$id.'" href="#collapse'.$id.$tab['link'].'"><h5><i class="icon-minus primary-color"></i><i class="icon-plus"></i>'.$tab['title'].'</h5></a></div><div id="collapse'.$id.$tab['link'].'" class="panel-collapse collapse '.$tab['in'].'"><div class="panel-body postclass">'.$tab['content'].'</div></div></div>';
	$i++;
}
$return = "\n".'<div class="panel-group" id="accordionname'.$id.'">'.implode( "\n", $tabs ).'</div>'."\n";
}
return $return;
}

function kadence_accordion_pane_function($atts, $content ) {
	extract(shortcode_atts(array(
'title' => 'Pane %d',
'start' => ''
), $atts));
if ($start != '') {$open = '';} else {$open = 'collapsed';}
if ($start != '') {$in = 'in';} else {$in = '';}

$x = $GLOBALS['pane_count'];
$GLOBALS['panes'][$x] = array( 'title' => $title, 'open' => $open, 'in' => $in, 'link' => $GLOBALS['pane_count'], 'content' =>  do_shortcode( $content ) );

$GLOBALS['pane_count']++;
}
function kadence_tab_shortcode_function($atts, $content ) {
	extract(shortcode_atts(array(
'id' => rand(1, 99)
), $atts));
	$GLOBALS['tab_count'] = 0;
	$GLOBALS['tabs'] = '';
	do_shortcode( $content );
	if( is_array( $GLOBALS['tabs'] ) ){
		
	foreach( $GLOBALS['tabs'] as $nav ){
	$tabnav[] = '<li class="'.$nav['active'].'"><a href="#sctab'.$id.$nav['link'].'" rel="nofollow">'.$nav['title'].'</a></li>';
	}
		
	foreach( $GLOBALS['tabs'] as $tab ){
	$tabs[] = '<div class="tab-pane clearfix '.$tab['active'].'" id="sctab'.$id.$tab['link'].'">'.$tab['content'].'</div>';
	}
	
$return = "\n".'<ul class="nav nav-tabs sc_tabs">'.implode( "\n", $tabnav ).'</ul> <div class="tab-content postclass">'.implode( "\n", $tabs ).'</div>'."\n";
}
return $return;
}
function kadence_tab_pane_function($atts, $content ) {
	extract(shortcode_atts(array(
'title' => 'Tab %d',
'start' => ''
), $atts));
if ($start != '') {$active = 'active';} else {$active = '';}

$x = $GLOBALS['tab_count'];
$GLOBALS['tabs'][$x] = array( 'title' => $title, 'active' => $active, 'link' => $GLOBALS['tab_count'], 'content' =>  do_shortcode( $content ) );

$GLOBALS['tab_count']++;
}
//product toggle
function kadence_product_toggle_shortcode_function( $atts) {
	return '<div class="kt_product_toggle_container"><div title="'.__("Grid View", "virtue").'" class="toggle_grid toggle_active" data-toggle="product_grid"><i class="icon-grid5"></i></div> <div title="'.__("List View", "virtue").'" class="toggle_list" data-toggle="product_list"><i class="icon-menu4"></i></div></div>';
}

//Shortcode for columns
function kadence_column_shortcode_function( $atts, $content ) {
	return '<div class="row">'.do_shortcode($content).'</div>';
}
function kadence_hcolumn_shortcode_function( $atts, $content ) {
	return '<div class="row">'.do_shortcode($content).'</div>';
}
function kadence_column11_function( $atts, $content ) {
	extract(shortcode_atts(array(
			'tablet' => '',
			'phone' => ''
			), $atts));
		if(empty($tablet)) {$tclass = "";} else if ($tablet == 'span2') {$tclass = "col-sm-2";} else if ($tablet == 'span3') {$tclass = "col-sm-3";} else if ($tablet == 'span4') {$tclass = "col-sm-4";} else if ($tablet == 'span6') {$tclass = "col-sm-6";} else if ($tablet == 'span8') {$tclass = "col-sm-8";} else {$tclass = "";}
		if(empty($phone)) {$pclass = "";} else if ($phone == 'span2') {$pclass = "col-ss-2";} else if ($phone == 'span3') {$pclass = "col-ss-3";} else if ($phone == 'span4') {$pclass = "col-ss-4";} else if ($phone == 'span6') {$pclass = "col-ss-6";} else if ($phone == 'span8') {$pclass = "col-ss-8";} else {$tclass = "";}
	return '<div class="col-md-11 '.$tclass.' '.$pclass.'">'.do_shortcode($content).'</div>';
}
function kadence_column10_function( $atts, $content ) {
	extract(shortcode_atts(array(
			'tablet' => '',
			'phone' => ''
			), $atts));
		if(empty($tablet)) {$tclass = "";} else if ($tablet == 'span2') {$tclass = "col-sm-2";} else if ($tablet == 'span3') {$tclass = "col-sm-3";} else if ($tablet == 'span4') {$tclass = "col-sm-4";} else if ($tablet == 'span6') {$tclass = "col-sm-6";} else if ($tablet == 'span8') {$tclass = "col-sm-8";} else {$tclass = "";}
		if(empty($phone)) {$pclass = "";} else if ($phone == 'span2') {$pclass = "col-ss-2";} else if ($phone == 'span3') {$pclass = "col-ss-3";} else if ($phone == 'span4') {$pclass = "col-ss-4";} else if ($phone == 'span6') {$pclass = "col-ss-6";} else if ($phone == 'span8') {$pclass = "col-ss-8";} else {$tclass = "";}
	return '<div class="col-md-10 '.$tclass.' '.$pclass.'">'.do_shortcode($content).'</div>';
}
function kadence_column9_function( $atts, $content ) {
	extract(shortcode_atts(array(
			'tablet' => '',
			'phone' => ''
			), $atts));
		if(empty($tablet)) {$tclass = "";} else if ($tablet == 'span2') {$tclass = "col-sm-2";} else if ($tablet == 'span3') {$tclass = "col-sm-3";} else if ($tablet == 'span4') {$tclass = "col-sm-4";} else if ($tablet == 'span6') {$tclass = "col-sm-6";} else if ($tablet == 'span8') {$tclass = "col-sm-8";} else {$tclass = "";}
		if(empty($phone)) {$pclass = "";} else if ($phone == 'span2') {$pclass = "col-ss-2";} else if ($phone == 'span3') {$pclass = "col-ss-3";} else if ($phone == 'span4') {$pclass = "col-ss-4";} else if ($phone == 'span6') {$pclass = "col-ss-6";} else if ($phone == 'span8') {$pclass = "col-ss-8";} else {$tclass = "";}
	return '<div class="col-md-9 '.$tclass.' '.$pclass.'">'.do_shortcode($content).'</div>';
}
function kadence_column8_function( $atts, $content ) {
	extract(shortcode_atts(array(
			'tablet' => '',
			'phone' => ''
			), $atts));
		if(empty($tablet)) {$tclass = "";} else if ($tablet == 'span2') {$tclass = "col-sm-2";} else if ($tablet == 'span3') {$tclass = "col-sm-3";} else if ($tablet == 'span4') {$tclass = "col-sm-4";} else if ($tablet == 'span6') {$tclass = "col-sm-6";} else if ($tablet == 'span8') {$tclass = "col-sm-8";} else {$tclass = "";}
		if(empty($phone)) {$pclass = "";} else if ($phone == 'span2') {$pclass = "col-ss-2";} else if ($phone == 'span3') {$pclass = "col-ss-3";} else if ($phone == 'span4') {$pclass = "col-ss-4";} else if ($phone == 'span6') {$pclass = "col-ss-6";} else if ($phone == 'span8') {$pclass = "col-ss-8";} else {$tclass = "";}
	return '<div class="col-md-8 '.$tclass.' '.$pclass.'">'.do_shortcode($content).'</div>';
}
function kadence_column7_function( $atts, $content ) {
	extract(shortcode_atts(array(
			'tablet' => '',
			'phone' => ''
			), $atts));
		if(empty($tablet)) {$tclass = "";} else if ($tablet == 'span2') {$tclass = "col-sm-2";} else if ($tablet == 'span3') {$tclass = "col-sm-3";} else if ($tablet == 'span4') {$tclass = "col-sm-4";} else if ($tablet == 'span6') {$tclass = "col-sm-6";} else if ($tablet == 'span8') {$tclass = "col-sm-8";} else {$tclass = "";}
		if(empty($phone)) {$pclass = "";} else if ($phone == 'span2') {$pclass = "col-ss-2";} else if ($phone == 'span3') {$pclass = "col-ss-3";} else if ($phone == 'span4') {$pclass = "col-ss-4";} else if ($phone == 'span6') {$pclass = "col-ss-6";} else if ($phone == 'span8') {$pclass = "col-ss-8";} else {$tclass = "";}
	return '<div class="col-md-7 '.$tclass.' '.$pclass.'">'.do_shortcode($content).'</div>';
}
function kadence_column6_function( $atts, $content ) {
	extract(shortcode_atts(array(
			'tablet' => '',
			'phone' => ''
			), $atts));
		if(empty($tablet)) {$tclass = "";} else if ($tablet == 'span2') {$tclass = "col-sm-2";} else if ($tablet == 'span3') {$tclass = "col-sm-3";} else if ($tablet == 'span4') {$tclass = "col-sm-4";} else if ($tablet == 'span6') {$tclass = "col-sm-6";} else if ($tablet == 'span8') {$tclass = "col-sm-8";} else {$tclass = "";}
		if(empty($phone)) {$pclass = "";} else if ($phone == 'span2') {$pclass = "col-ss-2";} else if ($phone == 'span3') {$pclass = "col-ss-3";} else if ($phone == 'span4') {$pclass = "col-ss-4";} else if ($phone == 'span6') {$pclass = "col-ss-6";} else if ($phone == 'span8') {$pclass = "col-ss-8";} else {$tclass = "";}
	return '<div class="col-md-6 '.$tclass.' '.$pclass.'">'.do_shortcode($content).'</div>';
}
function kadence_column5_function( $atts, $content ) {
	extract(shortcode_atts(array(
			'tablet' => '',
			'phone' => ''
			), $atts));
		if(empty($tablet)) {$tclass = "";} else if ($tablet == 'span2') {$tclass = "col-sm-2";} else if ($tablet == 'span3') {$tclass = "col-sm-3";} else if ($tablet == 'span4') {$tclass = "col-sm-4";} else if ($tablet == 'span6') {$tclass = "col-sm-6";} else if ($tablet == 'span8') {$tclass = "col-sm-8";} else {$tclass = "";}
		if(empty($phone)) {$pclass = "";} else if ($phone == 'span2') {$pclass = "col-ss-2";} else if ($phone == 'span3') {$pclass = "col-ss-3";} else if ($phone == 'span4') {$pclass = "col-ss-4";} else if ($phone == 'span6') {$pclass = "col-ss-6";} else if ($phone == 'span8') {$pclass = "col-ss-8";} else {$tclass = "";}
	return '<div class="col-md-5 '.$tclass.' '.$pclass.'">'.do_shortcode($content).'</div>';
}
function kadence_column4_function( $atts, $content ) {
	extract(shortcode_atts(array(
			'tablet' => '',
			'phone' => ''
			), $atts));
		if(empty($tablet)) {$tclass = "";} else if ($tablet == 'span2') {$tclass = "col-sm-2";} else if ($tablet == 'span3') {$tclass = "col-sm-3";} else if ($tablet == 'span4') {$tclass = "col-sm-4";} else if ($tablet == 'span6') {$tclass = "col-sm-6";} else if ($tablet == 'span8') {$tclass = "col-sm-8";} else {$tclass = "";}
		if(empty($phone)) {$pclass = "";} else if ($phone == 'span2') {$pclass = "col-ss-2";} else if ($phone == 'span3') {$pclass = "col-ss-3";} else if ($phone == 'span4') {$pclass = "col-ss-4";} else if ($phone == 'span6') {$pclass = "col-ss-6";} else if ($phone == 'span8') {$pclass = "col-ss-8";} else {$tclass = "";}
	return '<div class="col-md-4 '.$tclass.' '.$pclass.'">'.do_shortcode($content).'</div>';
}
function kadence_column3_function( $atts, $content ) {
	extract(shortcode_atts(array(
			'tablet' => '',
			'phone' => ''
			), $atts));
		if(empty($tablet)) {$tclass = "";} else if ($tablet == 'span2') {$tclass = "col-sm-2";} else if ($tablet == 'span3') {$tclass = "col-sm-3";} else if ($tablet == 'span4') {$tclass = "col-sm-4";} else if ($tablet == 'span6') {$tclass = "col-sm-6";} else if ($tablet == 'span8') {$tclass = "col-sm-8";} else {$tclass = "";}
		if(empty($phone)) {$pclass = "";} else if ($phone == 'span2') {$pclass = "col-ss-2";} else if ($phone == 'span3') {$pclass = "col-ss-3";} else if ($phone == 'span4') {$pclass = "col-ss-4";} else if ($phone == 'span6') {$pclass = "col-ss-6";} else if ($phone == 'span8') {$pclass = "col-ss-8";} else {$tclass = "";}
	return '<div class="col-md-3 '.$tclass.' '.$pclass.'">'.do_shortcode($content).'</div>';
}
function kadence_column2_function( $atts, $content ) {
	extract(shortcode_atts(array(
			'tablet' => '',
			'phone' => ''
			), $atts));
		if(empty($tablet)) {$tclass = "";} else if ($tablet == 'span2') {$tclass = "col-sm-2";} else if ($tablet == 'span3') {$tclass = "col-sm-3";} else if ($tablet == 'span4') {$tclass = "col-sm-4";} else if ($tablet == 'span6') {$tclass = "col-sm-6";} else if ($tablet == 'span8') {$tclass = "col-sm-8";} else {$tclass = "";}
		if(empty($phone)) {$pclass = "";} else if ($phone == 'span2') {$pclass = "col-ss-2";} else if ($phone == 'span3') {$pclass = "col-ss-3";} else if ($phone == 'span4') {$pclass = "col-ss-4";} else if ($phone == 'span6') {$pclass = "col-ss-6";} else if ($phone == 'span8') {$pclass = "col-ss-8";} else {$tclass = "";}
	return '<div class="col-md-2 '.$tclass.' '.$pclass.'">'.do_shortcode($content).'</div>';
}
function kadence_column25_function( $atts, $content ) {
	extract(shortcode_atts(array(
			'tablet' => '',
			'phone' => ''
			), $atts));
		if(empty($tablet)) {$tclass = "";} else if ($tablet == 'span2') {$tclass = "col-sm-2";} else if ($tablet == 'span3') {$tclass = "col-sm-3";} else if ($tablet == 'span4') {$tclass = "col-sm-4";} else if ($tablet == 'span6') {$tclass = "col-sm-6";} else if ($tablet == 'span8') {$tclass = "col-sm-8";} else {$tclass = "";}
		if(empty($phone)) {$pclass = "";} else if ($phone == 'span2') {$pclass = "col-ss-2";} else if ($phone == 'span3') {$pclass = "col-ss-3";} else if ($phone == 'span4') {$pclass = "col-ss-4";} else if ($phone == 'span6') {$pclass = "col-ss-6";} else if ($phone == 'span8') {$pclass = "col-ss-8";} else {$tclass = "";}
	return '<div class="col-md-25 '.$tclass.' '.$pclass.'">'.do_shortcode($content).'</div>';
}
function kadence_column1_function( $atts, $content ) {
	extract(shortcode_atts(array(
			'tablet' => '',
			'phone' => ''
			), $atts));
		if(empty($tablet)) {$tclass = "";} else if ($tablet == 'span2') {$tclass = "col-sm-2";} else if ($tablet == 'span3') {$tclass = "col-sm-3";} else if ($tablet == 'span4') {$tclass = "col-sm-4";} else if ($tablet == 'span6') {$tclass = "col-sm-6";} else if ($tablet == 'span8') {$tclass = "col-sm-8";} else {$tclass = "";}
		if(empty($phone)) {$pclass = "";} else if ($phone == 'span2') {$pclass = "col-ss-2";} else if ($phone == 'span3') {$pclass = "col-ss-3";} else if ($phone == 'span4') {$pclass = "col-ss-4";} else if ($phone == 'span6') {$pclass = "col-ss-6";} else if ($phone == 'span8') {$pclass = "col-ss-8";} else {$tclass = "";}
	return '<div class="col-md-1 '.$tclass.' '.$pclass.'">'.do_shortcode($content).'</div>';
}
//Shortcode for Icons
function kadence_icon_shortcode_function( $atts) {
	extract(shortcode_atts(array(
		'icon' => '',
		'size' => '',
		'color' => '',
		'style' => '',
		'background' => '',
		'float'=> ''
), $atts));
	if($style == 'circle') {$stylecss = 'kad-circle-iconclass';}
	 else if($style == 'smcircle') {$stylecss = 'kad-smcircle-iconclass';}
	 else if($style == 'square') {$stylecss = 'kad-square-iconclass';}
	 else if($style == 'smsquare') {$stylecss = 'kad-smsquare-iconclass';}
	 else {$stylecss = '';}
	if(empty($background)) {$background = '#eee';}
	if(empty($icon)) {$icon = 'icon-home';}
	if(empty($size)) {$size = '20px';}
	if(empty($color)) {$color = '#444';}
	if(empty($float)) {$float = '';}
	ob_start(); ?>
			<i class="<?php echo $icon;?> <?php if(!empty($stylecss)){echo $stylecss;}?>" style="font-size:<?php echo $size; ?>; display:inline-block; color:<?php echo $color;?>; <?php if(!empty($float)){echo 'float:'.$float.';';} if(!empty($stylecss)){echo 'background:'.$background.';';} ?>
			"></i>
			<?php if(!empty($link)) {echo '<a href="'.$link.'" class="kadinfolink">'; } ?>
	<?php  $output = ob_get_contents();
		ob_end_clean();
	return $output;
}
//Shortcode for Info Boxes
function kadence_info_boxes_shortcode_function( $atts, $content) {
	extract(shortcode_atts(array(
		'icon' => '',
		'image' => '',
		'id' => (rand(10,100)),
		'size' => '',
		'link' => '',
		'target' => '_self',
		'iconbackground' => '',
		'style' => '',
		'color' => '',
		'tcolor' => '',
		'background' => ''
), $atts));
	ob_start(); ?>
	<?php if(!empty($link)) {echo '<a href="'.$link.'" target="'.$target.'" class="kadinfolink">'; } ?>
	<div class="kad-info-box kad-info-box-<?php echo $id;?> clearfix" style="<?php if(!empty($background)) echo 'background:'.$background;?>">
		<?php if(!empty($image)){?> <img src="<?php echo $image; ?>" > <?php } else if(!empty($icon)){?> <i class="<?php echo $icon;?> <?php if(!empty($style)) {echo $style;}?>" style="<?php if(!empty($iconbackground)) echo 'background:'.$iconbackground;?>; font-size:<?php echo $size;?>px; <?php if(!empty($color)) echo 'color:'.$color;?>"></i><?php }?>
		<?php echo $content; ?>
	</div>
	<?php if(!empty($link)) {echo '</a>'; } 
	if(!empty($tcolor)) {echo '<style type="text/css" media="screen">.kad-info-box-'.$id.' h1, .kad-info-box-'.$id.' h2, .kad-info-box-'.$id.' h3, .kad-info-box-'.$id.' h4, .kad-info-box-'.$id.' h5, .kad-info-box-'.$id.' p {color:'.$tcolor.';}</style>';}?>
	<?php  $output = ob_get_contents();
		ob_end_clean();
	return $output;
}
//Shortcode for Icons Boxes
function kadence_icon_boxes_shortcode_function( $atts, $content) {
	extract(shortcode_atts(array(
		'icon' => '',
		'id' => (rand(10,100)),
		'iconsize' => '',
		'color' => '',
		'image' => '',
		'background' => '',
		'hcolor' => '',
		'hbackground' => '',
		'link' => '',
		'target' => '_self'
), $atts));
	if(empty($color)) {$color = '#444';}
	if(empty($background)) {$background = 'transparent';}
	$hover_bright = '';
	if($hbackground == 'primary') {$hbackground = ''; $hover_bright = "kad-hover-bg-primary";}
	if(!empty($link)) {
		$output = '<a href="'.$link.'" target="'.$target.'" class="kad-icon-box-'.$id.' kad-icon-box '.$hover_bright.'">';
	} else {
		$output = '<div class="kad-icon-box-'.$id.' kad-icon-box '.$hover_bright.'">';
	}
	if(!empty($image)) {
	$output .= '<img src="'.$image.'" class="kad-icon-box-img">'.$content;
	} else {
	$output .= '<i class="'.$icon.'" style="font-size:'.$iconsize.';"></i>'.$content;
	}
	if(!empty($link)) {
		$output .= '</a>';
	} else {
		$output .= '</div>';
	}
	$output .= '<style type="text/css" media="screen">.kad-icon-box-'.$id.' {background:'.$background.';} .kad-icon-box-'.$id.', .kad-icon-box-'.$id.' h1, .kad-icon-box-'.$id.' h2, .kad-icon-box-'.$id.' h3, .kad-icon-box-'.$id.' h4, .kad-icon-box-'.$id.' h5 {color:'.$color.' !important;} .kad-icon-box-'.$id.':hover {background:'.$hbackground.';} .kad-icon-box-'.$id.':hover, .kad-icon-box-'.$id.':hover h1, .kad-icon-box-'.$id.':hover h2, .kad-icon-box-'.$id.':hover h3, .kad-icon-box-'.$id.':hover h4, .kad-icon-box-'.$id.':hover h5 {color:'.$hcolor.' !important;}</style>';

	return $output;
}
//Shortcode for modal
function kadence_modal_shortcode_function( $atts, $content) {
	extract(shortcode_atts(array(
		'title' => 'Modal Title',
		'close' => 'true',
		'btntitle' => 'Click Here',
		'id' => '',
		'btnfont' => 'body',
		'btnsize' => 'medium',
		'btncolor' => '',
		'btnbackground' => ''
), $atts));
	if(empty($id)) {$id = rand(1, 99);}
	if($btnsize == 'large'){$sizeclass = "lg-kad-btn";} else if ($btnsize == 'small') {$sizeclass = "sm-kad-btn";} else {$sizeclass = "";}
	if($btnfont == 'h1-family'){$fontclass = "headerfont";} else {$fontclass = "";}
	ob_start(); ?>
	<button class="kad-btn kad-btn-primary <?php echo $sizeclass.' '.$fontclass;?>" style="<?php if(!empty($btnbackground)) {echo 'background-color:'.$btnbackground.';'; } if(!empty($btncolor)) { echo 'color:'.$btncolor.';';}?>" data-toggle="modal" data-target="#kt-modal-<?php echo $id;?>">
	 <?php echo $btntitle; ?>
	</button>

	<!-- Modal -->
	<div class="modal fade" id="kt-modal-<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="#kt-modal-label-<?php echo $id;?>" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="kt-modal-label-<?php echo $id;?>"><?php echo $title; ?></h4>
	      </div>
	      <div class="modal-body">
	        <?php echo do_shortcode($content); ?>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="kad-btn" data-dismiss="modal"><?php echo __('Close', 'virtue');?></button>
	      </div>
	    </div>
	  </div>
	</div>

	<?php  $output = ob_get_contents();
		ob_end_clean();
	return $output;
}
// Video Shortcode
function kadence_video_shortcode_function( $atts, $content) {
	extract(shortcode_atts(array(
		'width' => '',
		'height' => '',
		'mp4' => '',
		'm4v' => ''
), $atts));
	if(!empty($mp4)) {
		 $output = '<div class="videofit-embed"><video style="max-width:'.$width.'px; width:100%;" controls><source type="video/mp4" src="'.$mp4.'"/></video></div>';
	} elseif(!empty($m4v)) {
		 $output = '<div class="videofit-embed"><video style="max-width:'.$width.'px; width:100%;" controls><source type="video/m4v" src="'.$m4v.'"/></video></div>';
	} elseif(!empty($width)) { $output = '<div style="max-width:'.$width.'px;"><div class="videofit">'.$content.'</div></div>';}
	else { $output = '<div class="videofit">'.$content.'</div>'; }
	return $output;
}
function kadence_youtube_shortcode_function( $atts, $content) {
		// Prepare data
		$return = array();
		$params = array();
		$atts = shortcode_atts(array(
				'url'  => false,
				'width' => 600,
				'height' => 400,
				'maxwidth' => '',
				'autoplay' => 'false',
				'controls' => 'true',
				'hidecontrols' => 'false',
				'fs' => 'true',
				'modestbranding' => 'false',
				'theme' => 'dark'
		), $atts, 'kad_youtube' );

		if ( !$atts['url'] ) return '<p class="error">YouTube: ' . __( 'please specify correct url', 'virtue' ) . '</p>';
		$id = ( preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $atts['url'], $match ) ) ? $match[1] : false;
		// Check that url is specified
		if ( !$id ) return '<p class="error">YouTube: ' . __( 'please specify correct url', 'virtue' ) . '</p>';
		// Prepare params
		if($atts['hidecontrols'] == 'true') {$atts['controls'] = 'false';}
		foreach ( array('autoplay', 'controls', 'fs', 'modestbranding', 'theme' ) as $param ) $params[$param] = str_replace( array( 'false', 'true', 'alt' ), array( '0', '1', '2' ), $atts[$param] );
		// Prepare player parameters
		$params = http_build_query( $params );
		if($atts['maxwidth']) {$maxwidth = 'style="max-width:'.$atts['maxwidth'].'px;"';} else{ $maxwidth = '';}
		// Create player
		$return[] = '<div class="kad-youtube-shortcode videofit" '.$maxwidth.' >';
		$return[] = '<iframe width="' . $atts['width'] . '" height="' . $atts['height'] . '" src="https://www.youtube.com/embed/' . $id . '?' . $params . '" frameborder="0" allowfullscreen="true"></iframe>';
		$return[] = '</div>';
		// Return result
		return implode( '', $return );
}
function kadence_vimeo_shortcode_function( $atts, $content) {
		$return = array();
		$atts = shortcode_atts( array(
				'url'        => false,
				'width'      => 600,
				'height'     => 400,
				'maxwidth' => '',
				'autoplay'   => 'no'
			), $atts, 'vimeo' );
		if ( !$atts['url'] ) return '<p class="error">Vimeo: ' . __( 'please specify correct url', 'virtue' ) . '</p>';
		$id = ( preg_match( '~(?:<iframe [^>]*src=")?(?:https?:\/\/(?:[\w]+\.)*vimeo\.com(?:[\/\w]*\/videos?)?\/([0-9]+)[^\s]*)"?(?:[^>]*></iframe>)?(?:<p>.*</p>)?~ix', $atts['url'], $match ) ) ? $match[1] : false;
		// Check that url is specified
		if ( !$id ) return '<p class="error">Vimeo: ' . __( 'please specify correct url', 'virtue' ) . '</p>';

		if($atts['maxwidth']) {$maxwidth = 'style="max-width:'.$atts['maxwidth'].'px;"';} else{ $maxwidth = '';}
		$autoplay = ( $atts['autoplay'] === 'yes' ) ? '&amp;autoplay=1' : '';
		// Create player
		$return[] = '<div class="kad-vimeo-shortcode  videofit" '.$maxwidth.'>';
		$return[] = '<iframe width="' . $atts['width'] . '" height="' . $atts['height'] .
			'" src="http://player.vimeo.com/video/' . $id . '?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff' .
			$autoplay . '" frameborder="0" allowfullscreen="true"></iframe>';
		$return[] = '</div>';
		// Return result
		return implode( '', $return );
	}

//Image Split
function kadence_image_split_shortcode_function( $atts, $content) {
	extract(shortcode_atts(array(
		'height' => '500',
		'image' => '',
		'imageside' => 'left',
		'id' => rand(1, 99),
), $atts));
	ob_start(); ?>
	<!-- Image Split -->
	<div class="kt-image-slit" id="kt-image-split-<?php echo $id;?>">
	  <div class="row">
	    <div class="col-sm-6 kt-si-imagecol img-ktsi-<?php echo $imageside;?>">
	      <div class="kt-si-table-box" style="height:<?php echo $height;?>px">
	      	<div class="kt-si-cell-box">
	      		<?php if(!empty($image)) echo '<img src="'.esc_url($image).'" class="kt-si-image">'; ?>
	        </div>
	      </div>
	     </div>
	     <div class="col-sm-6 kt-si-imagecol content-ktsi-<?php echo $imageside;?>">
	      <div class="kt-si-table-box" style="height:<?php echo $height;?>px">
	      	<div class="kt-si-cell-box">
 				<?php echo do_shortcode($content); ?>
	        </div>
	      </div>
	     </div>
	  </div>
	</div>

	<?php  $output = ob_get_contents();
		ob_end_clean();
	return $output;
}
	//Simple Box
function kadence_simple_box_shortcode_function( $atts, $content ) {
	extract(shortcode_atts(array(
		'padding_top' => '15',
		'padding_bottom' => '15',
		'padding_left' => '15',
		'padding_right' => '15',
		'min_height' => '1',
		'background' => '#ffffff',
		'style' => '',
		'opacity' => '1'
), $atts));
	$bg_color_rgb = kad_hex2rgb($background);
	if(!empty($style)) {$style = $style;} else {$style = '';}
    $bcolor = 'rgba('.$bg_color_rgb[0].', '.$bg_color_rgb[1].', '.$bg_color_rgb[2].', '.$opacity.');';
	return '<div class="kt-simple-box" style="background-color:'.$bcolor.' min-height:'.$min_height.'px; padding-top:'.$padding_top.'px; padding-bottom:'.$padding_bottom.'px; padding-left:'.$padding_left.'px; padding-right:'.$padding_right.'px; '.$style.'">'. do_shortcode($content) .'</div>';
}
//Button
function kadence_button_shortcode_function( $atts) {
	extract(shortcode_atts(array(
		'id' => rand(1, 99),
		'bcolor' => '',
		'bhovercolor' => '',
		'thovercolor' => '',
		'link' => '',
		'target' => '',
		'border' => '0',
		'bordercolor' => '#000',
		'borderhovercolor' => '',
		'text' => '',
		'size' => 'medium',
		'font' => 'body',
		'icon' => '',
		'tcolor' => '',
), $atts));
	if($target == 'true' || $target == '_blank') {$target = '_blank';} else {$target = '_self';} 
	if($size == 'large'){$sizeclass = "lg-kad-btn";} else if ($size == 'small') {$sizeclass = "sm-kad-btn";} else {$sizeclass = "";}
	if($font == 'h1-family'){$fontclass = "headerfont";} else {$fontclass = "";}
	if(!empty($icon)) {$iconhtml = '<i class="'.$icon.'""></i>';} else {$iconhtml = "";}
	$output =  '<a href="'.$link.'" id="kadbtn'.$id.'" target="'.$target.'" class="kad-btn btn-shortcode kad-btn-primary '.$sizeclass.' '.$fontclass.'" style="background-color:'.$bcolor.'; border: '.$border.' solid; border-color:'.$bordercolor.'; color:'.$tcolor.'">'.$text.' '.$iconhtml.'</a>';
	$output .= '<style type="text/css" media="screen">#kadbtn'.$id.':hover {';
	if(!empty($bhovercolor)) { $output .= 'background:'.$bhovercolor.' !important;';}
	if(!empty($thovercolor)) { $output .= 'color:'.$thovercolor.' !important;';}
	if(!empty($borderhovercolor)) {$output .= 'border-color:'.$borderhovercolor.'!important;';}
	$output .= '} </style>';
return $output;
}
function kadence_blockquote_shortcode_function( $atts, $content) {
	extract(shortcode_atts(array(
		'align' => 'center',
), $atts));
		switch ($align)
	{
		case "center":
		$output = '<div class="blockquote-full postclass clearfix">' . do_shortcode($content) . '</div>';
		break;
		
		case "left":
		$output = '<div class="blockquote-left postclass clearfix">' . do_shortcode($content) . '</div>';
		break;
		
		case "right":
		$output = '<div class="blockquote-right postclass clearfix">' . do_shortcode($content) . '</div>';
		break;
	}
	  return $output;
}
function kadence_pullquote_shortcode_function( $atts, $content) {
   extract( shortcode_atts( array(
	  'align' => 'center'
  ), $atts ));

	switch ($align)
	{
		case "center":
		$output = '<div class="pullquote-center">' . do_shortcode($content) . '</div>';
		break;
		
		case "right":
		$output = '<div class="pullquote-right">' . do_shortcode($content) . '</div>';
		break;
		
		case "left":
		$output = '<div class="pullquote-left">' . do_shortcode($content) . '</div>';
		break;
	}

   return $output;
}
function kadence_hrule_function($atts) {
	extract(shortcode_atts(array(
		'color' => '',
		'style' => 'line',
		'size' => ''
), $atts));
	if($style == 'dots') {
		$output = '<div class="hrule_dots clearfix" style="';
		if(!empty($color)) {$output .= 'border-color:'.$color.';';}
		if(!empty($size)) {$output .= ' border-top-width:'.$size; }
		$output .= '"></div>';
	} elseif ($style == 'gradient') {
		$output = '<div class="hrule_gradient"></div>';
	} else {
		$output = '<div class="hrule clearfix" style="';
		if(!empty($color)) {$output .= 'background:'.$color.';';}
		if(!empty($size)) {$output .= ' height:'.$size; }
		$output .= '"></div>';
	}

	return $output;
}
function kadence_popover_function($atts, $content) {
	extract(shortcode_atts(array(
		'direction' => 'top',
		'text' => '',
		'title' => ''
), $atts));
		$output = '<a class="kad_popover" data-toggle="popover" data-placement="'.$direction.'" data-content="'.$text.'" data-original-title="'.$title.'">';
		$output .= $content;
		$output .= '</a>';

	return $output;
}
function kadence_hrule_dots_function($atts) {
	extract(shortcode_atts(array(
		'color' => '',
		'size' => ''
), $atts));
	$output = '<div class="hrule_dots clearfix" style="';
	if(!empty($color)) {$output .= 'border-color:'.$color.';';}
	if(!empty($size)) {$output .= ' border-top-width:'.$size.'px;'; }
	$output .= '"></div>';

	return $output;
}
function kadence_hrule_gradient_function() {
	$output = '<div class="hrule_gradient"></div>';
	return $output;
}
function kadence_hrpadding_function($atts ) {
	extract(shortcode_atts(array(
		'size' => ''
), $atts));
	if(empty($size)) {$size = '10px';}
	return '<div class="kad-spacer clearfix" style="height:'.$size.'"></div>';
}
function kadence_hrpadding_minus_10_function( ) {
	return '<div class="space_minus_10 clearfix"></div>';
}
function kadence_hrpadding_minus_20_function( ) {
	return '<div class="space_minus_20 clearfix"></div>';
}
function kadence_hrpadding10_function( ) {
	return '<div class="space_10 clearfix"></div>';
}
function kadence_hrpadding20_function( ) {
	return '<div class="space_20 clearfix"></div>';
}
function kadence_hrpadding40_function( ) {
	return '<div class="space_40 clearfix"></div>';
}
function kadence_hrpadding30_function( ) {
	return '<div class="space_30 clearfix"></div>';
}
function kadence_hrpadding80_function( ) {
	return '<div class="space_80 clearfix"></div>';
}
function kadence_clearfix_function( ) {
	return '<div class="clearfix"></div>';
}
function kadence_columnhelper_function( ) {
	return '';
}
function kadence_extra_shortcodes(){
add_shortcode('accordion', 'kadence_accordion_shortcode_function');
   add_shortcode('pane', 'kadence_accordion_pane_function');
   add_shortcode('tabs', 'kadence_tab_shortcode_function');
   add_shortcode('tab', 'kadence_tab_pane_function');
   add_shortcode('columns', 'kadence_column_shortcode_function');
   add_shortcode('hcolumns', 'kadence_hcolumn_shortcode_function');
   add_shortcode('span11', 'kadence_column11_function');
   add_shortcode('span10', 'kadence_column10_function');
   add_shortcode('span9', 'kadence_column9_function');
   add_shortcode('span8', 'kadence_column8_function');
   add_shortcode('span7', 'kadence_column7_function');
   add_shortcode('span6', 'kadence_column6_function');
   add_shortcode('span5', 'kadence_column5_function');
   add_shortcode('span4', 'kadence_column4_function');
   add_shortcode('span3', 'kadence_column3_function');
   add_shortcode('span25', 'kadence_column25_function');
   add_shortcode('span2', 'kadence_column2_function');
   add_shortcode('span1', 'kadence_column1_function');
   add_shortcode('columnhelper', 'kadence_columnhelper_function');
   add_shortcode('icon', 'kadence_icon_shortcode_function');
   add_shortcode('pullquote', 'kadence_pullquote_shortcode_function');
   add_shortcode('blockquote', 'kadence_blockquote_shortcode_function');
   add_shortcode('btn', 'kadence_button_shortcode_function');
   add_shortcode('hr', 'kadence_hrule_function');
   add_shortcode('hr_dots', 'kadence_hrule_dots_function');
   add_shortcode('hr_gradient', 'kadence_hrule_gradient_function');
   add_shortcode('minus_space_10', 'kadence_hrpadding_minus_10_function');
   add_shortcode('minus_space_20', 'kadence_hrpadding_minus_20_function');
   add_shortcode('space_10', 'kadence_hrpadding10_function');
   add_shortcode('space_20', 'kadence_hrpadding20_function');
   add_shortcode('space_30', 'kadence_hrpadding30_function');
   add_shortcode('space_40', 'kadence_hrpadding40_function');
   add_shortcode('space_80', 'kadence_hrpadding80_function');
   add_shortcode('space', 'kadence_hrpadding_function');
   add_shortcode('clear', 'kadence_clearfix_function');
   add_shortcode('infobox', 'kadence_info_boxes_shortcode_function');
   add_shortcode('iconbox', 'kadence_icon_boxes_shortcode_function');
   add_shortcode('carousel', 'kad_carousel_shortcode_function');
   add_shortcode('blog_posts', 'kad_blog_shortcode_function');
   add_shortcode('testimonial_posts', 'kad_testimonial_shortcode_function');
   add_shortcode('custom_carousel', 'kad_custom_carousel_shortcode_function');
   add_shortcode('carousel_item', 'kad_custom_carousel_item_shortcode_function');
   add_shortcode('img_menu', 'kad_image_menu_shortcode_function');
   add_shortcode('gmap', 'kad_map_shortcode_function');
   add_shortcode('portfolio_posts', 'kad_portfolio_shortcode_function');
   add_shortcode('portfolio_types', 'kad_portfolio_type_shortcode_function');
   add_shortcode('staff_posts', 'kad_staff_shortcode_function');
   add_shortcode('kad_youtube', 'kadence_youtube_shortcode_function');
   add_shortcode('kad_vimeo', 'kadence_vimeo_shortcode_function');
   add_shortcode('kad_popover', 'kadence_popover_function');
   add_shortcode('kad_modal', 'kadence_modal_shortcode_function');
   add_shortcode('kad_blog', 'kad_blog_simple_shortcode_function');
   add_shortcode('blog_grid', 'kad_blog_grid_shortcode_function');
   add_shortcode('kt_box', 'kadence_simple_box_shortcode_function');
   add_shortcode('kt_imgsplit', 'kadence_image_split_shortcode_function');
   add_shortcode('kt_product_toggle', 'kadence_product_toggle_shortcode_function');
}
add_action( 'init', 'kadence_extra_shortcodes');

function kadence_add_plugin( $plugin_array ) {
   $plugin_array['kadcolumns'] = get_template_directory_uri() . '/lib/shortcodes/columns/columns_shortgen.js';
   return $plugin_array;
}
function kadence_tinymce_shortcode_button() {

   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
      return;
   }

   if ( get_user_option('rich_editing') == 'true' ) {
      add_filter( 'mce_external_plugins', 'kadence_add_plugin' );
   }

}
add_action('init', 'kadence_tinymce_shortcode_button');


function kadence_register_shortcodes(){
	add_shortcode('the-year', 'kad_year_shortcode_function');
	add_shortcode('copyright', 'kad_copyright_shortcode_function');
	add_shortcode('site-name', 'kad_sitename_shortcode_function');
	add_shortcode('theme-credit', 'kad_themecredit_shortcode_function');
}
add_action( 'init', 'kadence_register_shortcodes');
//    Clean up Shortcodes

function kad_content_clean_shortcodes($content){   
    $array = array (
        '<p>[' => '[', 
        ']</p>' => ']', 
        ']<br />' => ']'
    );
    $content = strtr($content, $array);
    return $content;
}
add_filter('the_content', 'kad_content_clean_shortcodes');
function kad_widget_clean_shortcodes($text){   
    $array = array (
        '<p>[' => '[', 
        ']</p>' => ']', 
        '<p></p>' => '', 
        ']<br />' => ']',
        '<br />[' => '['
    );
    $text = strtr($text, $array);
    return $text;
}
add_filter('widget_text', 'kad_widget_clean_shortcodes');
add_filter('widget_text', 'do_shortcode', 50);
add_action( 'init', 'kt_remove_bstw_do_shortcode' );
function kt_remove_bstw_do_shortcode() {
    if ( function_exists( 'bstw' ) ) {
        remove_filter( 'widget_text', array( bstw()->text_filters(), 'do_shortcode' ), 10 );
    }
}

