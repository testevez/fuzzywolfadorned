<?php
/**
 * Theme wrapper
 *
 * @link http://scribu.net/wordpress/theme-wrappers.html
 */
function kadence_template_path() {
  return Kadence_Wrapping::$main_template;
}

function kadence_sidebar_path() {
  return new Kadence_Wrapping('templates/sidebar.php');
}

class Kadence_Wrapping {
  // Stores the full path to the main template file
  static $main_template;

  // Stores the base name of the template file; e.g. 'page' for 'page.php' etc.
  static $base;

  public function __construct($template = 'base.php') {
    $this->slug = basename($template, '.php');
    $this->templates = array($template);

    if (self::$base) {
      $str = substr($template, 0, -4);
      array_unshift($this->templates, sprintf($str . '-%s.php', self::$base));
    }
  }

  public function __toString() {
    $this->templates = apply_filters('kadence_wrap_' . $this->slug, $this->templates);
    return locate_template($this->templates);
  }

  static function wrap($main) {
    self::$main_template = $main;
    self::$base = basename(self::$main_template, '.php');

    if (self::$base === 'index') {
      self::$base = false;
    }

    return new Kadence_Wrapping();
  }
}
add_filter('template_include', array('Kadence_Wrapping', 'wrap'), 101);

/**
 * Page titles
 */
function kadence_title() {
  if (is_home()) {
    if (get_option('page_for_posts', true)) {
      return get_the_title(get_option('page_for_posts', true));
    } else {
     return __('Latest Posts', 'virtue');
    }
  } elseif (is_archive()) {
    $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
    if ($term) {
      return $term->name;
    } elseif (is_post_type_archive()) {
      return get_queried_object()->labels->name;
    } elseif (is_day()) {
      return sprintf(__('Daily Archives: %s', 'virtue'), get_the_date());
    } elseif (is_month()) {
      return sprintf(__('Monthly Archives: %s', 'virtue'), get_the_date('F Y'));
    } elseif (is_year()) {
      return sprintf(__('Yearly Archives: %s', 'virtue'), get_the_date('Y'));
    } elseif (is_author()) {
      return sprintf(__('Author Archives: %s', 'virtue'), get_the_author());
    } else {
      return single_cat_title("", false);
    }
  } elseif (is_search()) {
    return sprintf(__('Search Results for %s', 'virtue'), get_search_query());
  } elseif (is_404()) {
    return __('Not Found', 'virtue');
  } else {
    return get_the_title();
  }
}

/**
 * Return WordPress subdirectory if applicable
 */
function wp_base_dir() {
  preg_match('!(https?://[^/|"]+)([^"]+)?!', site_url(), $matches);
  if (count($matches) === 3) {
    return end($matches);
  } else {
    return '';
  }
}

/**
 * Opposite of built in WP functions for trailing slashes
 */
function leadingslashit($string) {
  return '/' . unleadingslashit($string);
}

function unleadingslashit($string) {
  return ltrim($string, '/');
}

function add_filters($tags, $function) {
  foreach($tags as $tag) {
    add_filter($tag, $function);
  }
}

function is_element_empty($element) {
  $element = trim($element);
  return empty($element) ? false : true;
}


add_action( "after_setup_theme", 'kadence_permalinks');
function kadence_permalinks() {

global $wp_rewrite, $virtue_premium;
if(!empty($virtue_premium['portfolio_permalink'])) {$port_rewrite = $virtue_premium['portfolio_permalink'];} else {$port_rewrite = 'portfolio';}
$portfolio_structure = '/'.$port_rewrite.'/%portfolio%';
$wp_rewrite->add_rewrite_tag("%portfolio%", '([^/]+)', "portfolio=");
$wp_rewrite->add_permastruct('portfolio', $portfolio_structure, false);

// Add filter to plugin init function
add_filter('post_type_link', 'portfolio_permalink', 10, 3);   
// Adapted from get_permalink function in wp-includes/link-template.php

function portfolio_permalink($permalink, $post_id, $leavename) {
    $post = get_post($post_id);
    $rewritecode = array(
        '%year%',
        '%monthnum%',
        '%day%',
        '%hour%',
        '%minute%',
        '%second%',
        $leavename? '' : '%postname%',
        '%post_id%',
        '%category%',
        '%author%',
        $leavename? '' : '%pagename%',
    );
 
    if ( '' != $permalink && !in_array($post->post_status, array('draft', 'pending', 'auto-draft')) ) {
        $unixtime = strtotime($post->post_date);
     
        $category = '';
        if ( strpos($permalink, '%category%') !== false ) {
            $cats = wp_get_post_terms($post->ID, 'portfolio-type', array( 'orderby' => 'parent', 'order' => 'DESC' ));
            if ( $cats ) {
                //usort($cats, '_usort_terms_by_ID'); // order by ID
                $category = $cats[0]->slug;
            }
            // show default category in permalinks, without
            // having to assign it explicitly
            if ( empty($category) ) {
                $category = 'portfolio-category';
            }
        }
     
        $author = '';
        if ( strpos($permalink, '%author%') !== false ) {
            $authordata = get_userdata($post->post_author);
            $author = $authordata->user_nicename;
        }
     
        $date = explode(" ",date('Y m d H i s', $unixtime));
        $rewritereplace =
        array(
            $date[0],
            $date[1],
            $date[2],
            $date[3],
            $date[4],
            $date[5],
            $post->post_name,
            $post->ID,
            $category,
            $author,
            $post->post_name,
        );
        $permalink = str_replace($rewritecode, $rewritereplace, $permalink);
    } else { // if they're not using the fancy permalink option
    }
    return $permalink;
}
}
