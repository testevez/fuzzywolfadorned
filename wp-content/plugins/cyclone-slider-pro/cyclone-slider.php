<?php
/*
Plugin Name: Cyclone Slider Pro
Plugin URI: http://www.codefleet.net/cyclone-slider-pro/
Description: Create and manage sliders with ease. Built for both casual users and developers.
Version: 2.10.0
Author: Nico Amarilla
Author URI: http://www.codefleet.net/
License:

  Copyright 2015 (kosinix@codefleet.net)

  A single purchase allows the developer to use Cyclone Slider Pro in unlimited websites.
  For use in commercial products, a single purchase allows the use in one commercial product only.
  Example: You can use one Cyclone Slider Pro purchase in one WordPress theme that will be sold.
  If you create a new theme to be sold, you need to make another purchase.
  
*/

// Autoloader
function cycloneslider_autoloader( $class_name ) {
    if( false !== strpos( $class_name, 'CycloneSlider' ) ){
        $classes_dir = realpath( plugin_dir_path( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR;
        $class_file = str_replace( '_', DIRECTORY_SEPARATOR, $class_name ) . '.php';
        require_once $classes_dir . $class_file;
    }
}
spl_autoload_register('cycloneslider_autoloader');

$cyclone_slider_plugin_instance = null;
$cyclone_slider_saved_done = false;

// Hook the plugin
add_action('plugins_loaded', 'cycloneslider_init');
function cycloneslider_init() {
    global $cyclone_slider_plugin_instance;
    
    $plugin = new CycloneSlider_Plugin();
    
    $plugin['path'] = realpath(plugin_dir_path(__FILE__)) . DIRECTORY_SEPARATOR;
    $plugin['url'] = plugin_dir_url(__FILE__);
    $plugin['version'] = 'cycloneslider_service_plugin_version';
    $plugin['debug'] = false;
    $plugin['textdomain'] = 'cycloneslider';
    $plugin['slug'] = 'cyclone-slider-pro/cyclone-slider.php'; 
    $plugin['nonce_name'] = 'cyclone_slider_builder_nonce';
    $plugin['nonce_action'] = 'cyclone-slider-save';
    $plugin['wp_upload_location'] = 'cycloneslider_wp_upload_location';
    $plugin['wp_content_dir'] = 'cycloneslider_service_wp_content_dir';
    $plugin['wp_content_url'] = content_url();
    $plugin['cyclone_slider_dir'] = 'cycloneslider_service_cyclone_slider_dir'; // Folder where plugin related functions are performed
    $plugin['view_folder'] = $plugin['path'].'views';
    $plugin['view'] = 'cycloneslider_service_view';
    
    $plugin['image_resizer'] = 'cycloneslider_service_image_resizer';
    $plugin['image_editor'] = 'CycloneSlider_ImageEditor';
    $plugin['image_sizes'] = array(
        '40_40_crop' => array( // Used by thumbnail template
            'width' => 40,
            'height' => 40,
            'resize_option' => 'crop'
        ),
        '60_60_crop' => array( // Used by Galleria template
            'width' => 60,
            'height' => 60,
            'resize_option' => 'crop'
        )
    );
    $plugin['image_sizes'] = apply_filters('cycloneslider_image_sizes', $plugin['image_sizes']);
    
    $plugin['data'] = 'cycloneslider_service_data';

    $plugin['nextgen_integration'] = 'cycloneslider_service_nextgen';
    
    $plugin['exporter'] = 'cycloneslider_service_exporter';
    $plugin['exports_dir'] = $plugin['cyclone_slider_dir'].'/exports';
    $plugin['export_json_file'] = 'export.json';
    
    $plugin['importer'] = 'cycloneslider_service_importer';
    $plugin['imports_dir'] = $plugin['cyclone_slider_dir'].'/imports';
    $plugin['imports_extracts_dir'] = $plugin['imports_dir'].'/extracts';
    $plugin['import_zip_name'] = 'import.zip';
    
    
    $plugin['zip_archive'] = 'ZipArchive';
    
    // Order is important. core is overridden by active-theme which in turn is overridden by wp-content.
    $plugin['template_locations'] = array(
        array(
            'path' => $plugin['path'].'templates'.DIRECTORY_SEPARATOR, // This resides in the plugin
            'url' => $plugin['url'].'templates/',
            'location_name' => 'core'
        ),
        array(
            'path' => realpath(get_stylesheet_directory()).DIRECTORY_SEPARATOR.'cycloneslider'.DIRECTORY_SEPARATOR, // This resides in the current theme or child theme. Gets deleted when theme is deleted.
            'url' => get_stylesheet_directory_uri()."/cycloneslider/",
            'location_name' => 'active-theme'
        ),
        array(
            'path' => $plugin['wp_content_dir'].DIRECTORY_SEPARATOR.'cycloneslider'.DIRECTORY_SEPARATOR, // This resides in the wp-content folder to prevent deleting when upgrading themes. Recommended location
            'url' => $plugin['wp_content_url']."/cycloneslider/",
            'location_name' => 'wp-content'
        )
    );
    
    $plugin['settings_page'] = 'cycloneslider_service_settings_page';
    $plugin['settings_page_properties'] = array(
        'parent_slug' => 'edit.php?post_type=cycloneslider',
        'page_title' =>  __('Cyclone Slider Settings', $plugin['textdomain']),
        'menu_title' =>  __('Settings', $plugin['textdomain']),
		'capability' => 'manage_options',
        'menu_slug' => 'cycloneslider-settings',
        'option_group' => 'cyclone_option_group',
        'option_name' => 'cyclone_option_name'
    );
    
    $plugin['export_page'] = 'cycloneslider_service_export_page';
    $plugin['export_page_properties'] = array(
        'parent_slug' => 'edit.php?post_type=cycloneslider',
        'page_title' => __('Cyclone Slider Export', $plugin['textdomain']),
		'menu_title' => __('Export/Import', $plugin['textdomain']),
        'capability' => 'manage_options',
        'menu_slug' => 'cycloneslider-export',
        'transient_name' => 'cycloneslider_export_transient',
        'nonce_name' => 'cycloneslider_export_nonce',
        'nonce_action' => 'cycloneslider_export',
        'url' => get_admin_url( get_current_blog_id(), 'edit.php?post_type=cycloneslider&page=cycloneslider-export' )
    );
    
    //$plugin['export_page_nextgen'] = 'cycloneslider_service_export_page_nextgen';
    $plugin['export_page_nextgen_properties'] = array(
        'parent_slug' => '',
        'page_title' => __('Cyclone Slider Nextgen Export', $plugin['textdomain']),
		'menu_title' => __('Export Nextgen', $plugin['textdomain']),
        'capability' => 'manage_options',
        'menu_slug' => 'cycloneslider-export-nextgen',
        'transient_name' => 'cycloneslider_export_nextgen_transient',
        'nonce_name' => 'cycloneslider_export_nextgen_nonce',
        'nonce_action' => 'cycloneslider_export_nextgen',
        'url' => get_admin_url( get_current_blog_id(), 'edit.php?post_type=cycloneslider&page=cycloneslider-export-nextgen' )
    );
    
    $plugin['import_page'] = 'cycloneslider_service_import_page';
	$plugin['import_page_properties'] = array(
        'parent_slug' => '',
		'page_title' => __('Cyclone Slider Import', $plugin['textdomain']),
		'menu_title' => __('Import', $plugin['textdomain']),
		'capability' => 'manage_options',
		'menu_slug' => 'cycloneslider-import',
        'nonce_name' => 'cycloneslider_import_nonce',
        'nonce_action' => 'cycloneslider_import',
        'url' => get_admin_url( get_current_blog_id(), 'edit.php?post_type=cycloneslider&page=cycloneslider-import' )
    );
    
    $plugin['zip_archive'] = 'cycloneslider_service_zip_archive';
    
    $plugin['youtube'] = new CycloneSlider_Youtube();
    
    $plugin['vimeo'] = new CycloneSlider_Vimeo();
    
    $plugin['asset_loader'] = 'cycloneslider_service_asset_loader';
    
    $plugin['admin'] = 'cycloneslider_service_admin';
    
    $plugin['frontend'] = 'cycloneslider_service_frontend';
    
    $plugin['updater'] = 'cycloneslider_service_updater';
	$plugin['updater_properties'] = array(
		'info_url' => 'http://support.codefleet.net/api/plugins/cyclone-slider-pro/latest/info',
		'download_url' => 'http://support.codefleet.net/api/plugins/cyclone-slider-pro/latest/download'
	);
    
    $plugin['widgets'] = new CycloneSlider_Widgets();
    
    require_once($plugin['path'].'src/functions.php'); // Function not autoloaded from the old days. Deprecated
    
    $plugin->run();
    
    $cyclone_slider_plugin_instance = $plugin;
}

// Service Definitions
function cycloneslider_service_plugin_version( $plugin ) {
    static $object;

    if (null !== $object) {
        return $object;
    }
    
    $default_headers = array(
        'name' => 'Plugin Name',
        'plugin_uri' => 'Plugin URI',
        'version' => 'Version'
    );
    $plugin_data = get_file_data( __FILE__, $default_headers, 'plugin' ); // WP Func
    
    $object = $plugin_data['version'];
    return $object;
}

function cycloneslider_wp_upload_location( $plugin ) {
    static $object;

    if (null !== $object) {
        return $object;
    }
    $wp_locations = wp_upload_dir();
    $object = $wp_locations;
    return $object;
}

function cycloneslider_service_wp_content_dir( $plugin ) {
    static $object;

    if (null !== $object) {
        return $object;
    }
    
    $wp_upload_dir = $plugin['wp_upload_location'];
    
    $object = dirname( $wp_upload_dir['basedir'] );
    return $object;
}

function cycloneslider_service_cyclone_slider_dir( $plugin ) {
    static $object;

    if (null !== $object) {
        return $object;
    }
    
    $object = $plugin['wp_content_dir'].'/cyclone-slider';
    return $object;
}

function cycloneslider_service_image_resizer( $plugin ) {
    static $object;

    if (null !== $object) {
        return $object;
    }
    
    $object = new CycloneSlider_ImageResizer( $plugin['image_sizes'], $plugin['image_editor'] );
    return $object;
}

function cycloneslider_service_data( $plugin ) {
    static $object;

    if (null !== $object) {
        return $object;
    }
    
    $object = new CycloneSlider_Data( $plugin['nonce_name'], $plugin['nonce_action'], $plugin['image_resizer'], $plugin['template_locations'], $plugin['settings_page_properties'] );
    return $object;
}

function cycloneslider_service_nextgen( $plugin ) {
    static $object;

    if (null !== $object) {
        return $object;
    }
    
    $object = new CycloneSlider_NextgenIntegration( $plugin['data'] );
    return $object;
}

function cycloneslider_service_exporter( $plugin ){
    static $object;

    if (null !== $object) {
        return $object;
    }
    
    $wp_upload_location = $plugin['wp_upload_location'];
    $object = new CycloneSlider_Exporter( $plugin['data'], $plugin['zip_archive'], $plugin['export_json_file'], $plugin['textdomain'] );
    return $object;
}
function cycloneslider_service_importer( $plugin ) {
    static $object;

    if (null !== $object) {
        return $object;
    }
    
    $wp_upload_location = $plugin['wp_upload_location'];
    $object = new CycloneSlider_Importer( $plugin['data'], $plugin['imports_dir'], $wp_upload_location['path'], $plugin['zip_archive'], $plugin['import_zip_name'], $plugin['imports_extracts_dir'], $plugin['export_json_file'], $plugin['textdomain'] );
    return $object;
}

function cycloneslider_service_view( $plugin ) {
    static $object;

    if (null !== $object) {
        return $object;
    }
    
    $object = new CycloneSlider_View( $plugin['view_folder'] );
    return $object;
}

function cycloneslider_service_settings_page( $plugin ) {
    static $object;

    if (null !== $object) {
        return $object;
    }
    
    $object = new CycloneSlider_SettingsPage( $plugin['settings_page_properties'], $plugin['data'], $plugin['textdomain'], $plugin['debug'], $plugin['view'] );
    return $object;
}

function cycloneslider_service_export_page( $plugin ) {
    static $object;

    if (null !== $object) {
        return $object;
    }
    
    $object = new CycloneSlider_ExportPage(
        $plugin['export_page_properties']['parent_slug'],
        $plugin['export_page_properties']['page_title'],
        $plugin['export_page_properties']['menu_title'],
        $plugin['export_page_properties']['capability'],
        $plugin['export_page_properties']['menu_slug'],
        $plugin['data']->get_sliders(),
        $plugin['view'],
        $plugin['exporter'],
        $plugin['wp_content_dir'],
        $plugin['wp_content_url'],
        $plugin['textdomain'],
        $plugin['export_page_properties']['transient_name'],
        $plugin['export_page_properties']['nonce_name'],
        $plugin['export_page_properties']['nonce_action'],
        $plugin['export_page_properties']['url'],
        $plugin['import_page_properties']['url'],
        $plugin['export_page_nextgen_properties']['url']
    );
    return $object;
}

function cycloneslider_service_import_page( $plugin ){
    static $object;

    if (null !== $object) {
        return $object;
    }
    
    $object = new CycloneSlider_ImportPage(
        $plugin['import_page_properties']['parent_slug'],
        $plugin['import_page_properties']['page_title'],
        $plugin['import_page_properties']['menu_title'],
        $plugin['import_page_properties']['capability'],
        $plugin['import_page_properties']['menu_slug'],
        $plugin['data'],
        $plugin['view'],
        $plugin['import_page_properties']['nonce_name'],
        $plugin['import_page_properties']['nonce_action'],
        $plugin['importer'],
        $plugin['cyclone_slider_dir'],
        $plugin['wp_content_dir'],
        $plugin['wp_content_url'],
        $plugin['textdomain'],
        $plugin['export_page_properties']['url'],
        $plugin['import_page_properties']['url'],
        $plugin['export_page_nextgen_properties']['url']
    );
    return $object;
}

function cycloneslider_service_export_page_nextgen( $plugin ) {
    static $object;

    if (null !== $object) {
        return $object;
    }
    
    $object = new CycloneSlider_ExportPageNextgen(
        $plugin['export_page_nextgen_properties']['parent_slug'],
        $plugin['export_page_nextgen_properties']['page_title'],
        $plugin['export_page_nextgen_properties']['menu_title'],
        $plugin['export_page_nextgen_properties']['capability'],
        $plugin['export_page_nextgen_properties']['menu_slug'],
        $plugin['view'],
        $plugin['exporter'],
        $plugin['wp_content_dir'],
        $plugin['wp_content_url'],
        $plugin['textdomain'],
        $plugin['export_page_nextgen_properties']['transient_name'],
        $plugin['export_page_nextgen_properties']['nonce_name'],
        $plugin['export_page_nextgen_properties']['nonce_action'],
        $plugin['export_page_properties']['url'],
        $plugin['import_page_properties']['url'],
        $plugin['export_page_nextgen_properties']['url']
    );
    return $object;
}

function cycloneslider_service_zip_archive( $plugin ){
    return new ZipArchive;
}

function cycloneslider_service_asset_loader( $plugin ) {
    static $object;

    if (null !== $object) {
        return $object;
    }
    
    $object = new CycloneSlider_AssetLoader( $plugin['data']->get_settings_page_data(), $plugin['url'], $plugin['version'], $plugin['data'] );
    return $object;
}

function cycloneslider_service_admin( $plugin ) {
    static $object;

    if (null !== $object) {
        return $object;
    }
    
    $object = new CycloneSlider_Admin($plugin['asset_loader'], $plugin['textdomain'], $plugin['data'], $plugin['debug'], $plugin['view'], $plugin['nonce_name'], $plugin['nonce_action'], $plugin['url'] );
    return $object;
}

function cycloneslider_service_frontend( $plugin ) {
    static $object;

    if (null !== $object) {
        return $object;
    }
    
    $object = new CycloneSlider_Frontend( $plugin['data'], $plugin['image_sizes'], $plugin['youtube'], $plugin['vimeo'], $plugin['view'] );
    return $object;
}

function cycloneslider_service_updater( $plugin ) {
    static $object;

    if (null !== $object) {
        return $object;
    }
	
    $object = new CycloneSlider_Updater( $plugin['data']->get_settings_page_data(), $plugin['slug'], $plugin['version'], $plugin['updater_properties']['info_url'], $plugin['updater_properties']['download_url'] );
    return $object;
}

