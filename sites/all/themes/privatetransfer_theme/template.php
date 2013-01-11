<?php

/**
 * @file
 * Process theme data.
 *
 * Use this file to run your theme specific implimentations of theme functions,
 * such preprocess, process, alters, and theme function overrides.
 *
 * Preprocess and process functions are used to modify or create variables for
 * templates and theme functions. They are a common theming tool in Drupal, often
 * used as an alternative to directly editing or adding code to templates. Its
 * worth spending some time to learn more about these functions - they are a
 * powerful way to easily modify the output of any template variable.
 * 
 * Preprocess and Process Functions SEE: http://drupal.org/node/254940#variables-processor
 * 1. Rename each function and instance of "adaptivetheme_subtheme" to match
 *    your subthemes name, e.g. if your theme name is "footheme" then the function
 *    name will be "footheme_preprocess_hook". Tip - you can search/replace
 *    on "adaptivetheme_subtheme".
 * 2. Uncomment the required function to use.
 */


/**
 * Preprocess variables for the html template.
 */
/* -- Delete this line to enable.
function adaptivetheme_subtheme_preprocess_html(&$vars) {
  global $theme_key;

  // Two examples of adding custom classes to the body.
  
  // Add a body class for the active theme name.
  // $vars['classes_array'][] = drupal_html_class($theme_key);

  // Browser/platform sniff - adds body classes such as ipad, webkit, chrome etc.
  // $vars['classes_array'][] = css_browser_selector();

}
// */


/**
 * Process variables for the html template.
 */
/* -- Delete this line if you want to use this function
function adaptivetheme_subtheme_process_html(&$vars) {
}
// */


/**
 * Override or insert variables for the page templates.
 */
/* -- Delete this line if you want to use these functions
function adaptivetheme_subtheme_preprocess_page(&$vars) {
}
function adaptivetheme_subtheme_process_page(&$vars) {
}
// */


/**
 * Override or insert variables into the node templates.
 */
/* -- Delete this line if you want to use these functions
function adaptivetheme_subtheme_preprocess_node(&$vars) {
}
function adaptivetheme_subtheme_process_node(&$vars) {
}
// */


/**
 * Override or insert variables into the comment templates.
 */
/* -- Delete this line if you want to use these functions
function adaptivetheme_subtheme_preprocess_comment(&$vars) {
}
function adaptivetheme_subtheme_process_comment(&$vars) {
}
// */


/**
 * Override or insert variables into the block templates.
 */
/* -- Delete this line if you want to use these functions
function adaptivetheme_subtheme_preprocess_block(&$vars) {
}
function adaptivetheme_subtheme_process_block(&$vars) {



}

// */
 function privatetransfer_theme_breadcrumb($variables) {
	$breadcrumb = $variables['breadcrumb'];
	if (!empty($breadcrumb)) {
		// Provide a navigational heading to give context for breadcrumb links to
		// screen-reader users. Make the heading invisible with .element-invisible.
		$output = '<h2 class="element-invisible">' . t('You are here') . '</h2>';
		$crumbs = '<div class="breadcrumb">';
		$array_size = count($breadcrumb);
		$i = 0;
		while ( $i < $array_size) {
			$crumbs .= '<span class="breadcrumb-' . $i;
			if ($i == 0) {
				$crumbs .= ' first';
			}
			/* if ($i+1 == $array_size) {
			$crumbs .= ' last';
			} */
			$crumbs .=  '">' . $breadcrumb[$i] . '</span> <span class="singlearrow">&rsaquo; </span>';
			$i++;
		}
		$crumbs .= '<span class="active">'. drupal_get_title() .'</span></div>';
		return $crumbs;
	}
        
}
/*
 function privatetransfer_theme_preprocess_html(&$variables) {
  drupal_add_css(drupal_get_path('theme', 'privatetransfer_theme'). '/scripts/datepicknew/css/jquery-ui-timepicker-addon.css', array( 
    'scope' => 'header', 
    'weight' => '4' 
  ));
  drupal_add_js(drupal_get_path('theme', 'privatetransfer_theme') . '/scripts/datepicknew/jquery-ui-sliderAccess.js', array( 
    'scope' => 'header', 
    'weight' => '5' 
  ));
  drupal_add_js(drupal_get_path('theme', 'privatetransfer_theme') . '/scripts/datepicknew/jquery-ui-timepicker-addon.js', array( 
    'scope' => 'header', 
    'weight' => '6' 
  ));
  
  drupal_add_css(drupal_get_path('theme', 'privatetransfer_theme'). '/scripts/datepicknew/css/jquery-ui.css', array( 
    'scope' => 'header', 
    'weight' => '7' 
  ));

  drupal_add_js(drupal_get_path('theme', 'privatetransfer_theme') . '/scripts/datepicknew/jquery-1.8.2.min.js', array( 
    'scope' => 'header', 
    'weight' => '8' 
  ));
  drupal_add_js(drupal_get_path('theme', 'privatetransfer_theme') . '/scripts/datepicknew/jquery-ui.min.js', array( 
    'scope' => 'header', 
    'weight' => '9' 
  ));
  
 }
*/
