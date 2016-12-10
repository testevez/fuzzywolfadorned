<?php

/**
 * Enqueue CSS & JS
 */
function kadence_admin_scripts() {
  wp_register_style('kad_adminstyles', get_template_directory_uri() . '/assets/css/kad_adminstyles.css', false, 295);
  wp_enqueue_style('kad_adminstyles');

  wp_register_script('kad_adminscripts', get_template_directory_uri() . '/assets/js/min/kad_adminscripts-min.js', false, 295, false);
  wp_enqueue_script('kad_adminscripts');

}

add_action('admin_enqueue_scripts', 'kadence_admin_scripts');
