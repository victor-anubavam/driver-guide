<?php
/**
 * @file
 * Process theme data.
 *
 * IMPORTANT WARNING: DO NOT MODIFY THIS FILE OR ANY OF THE INCLUDED FILES.
 */
global $theme_key, $path_to_at_core;
$theme_key = $GLOBALS['theme_key'];
$path_to_at_core = drupal_get_path('theme', 'adaptivetheme');

include_once($path_to_at_core . '/inc/get.inc');        // get theme info, settings, css etc
include_once($path_to_at_core . '/inc/plugins.inc');    // the plugin system with wrapper and helper functions
include_once($path_to_at_core . '/inc/generate.inc');   // CSS class generators
include_once($path_to_at_core . '/inc/fonts.inc');      // Required functions for the fonts and headings settings
include_once($path_to_at_core . '/inc/load.inc');       // drupal_add_css() wrappers
include_once($path_to_at_core . '/inc/alter.inc');      // hook_alters
include_once($path_to_at_core . '/inc/preprocess.inc'); // all preprocess functions
include_once($path_to_at_core . '/inc/process.inc');    // all process functions
include_once($path_to_at_core . '/inc/theme.inc');      // theme function overrides


function chktripCompletion()
{
    $retval=array();

    if(isset($_SESSION['products']))
    {
        $cart = unserialize($_SESSION['products']);
        foreach ($cart as $key => $value)
        {      
          for($i=0;$i<3;$i++)
          {            
            switch ($i)
            {
                case 0:
                  if($value['product_details']['serv_type']=='service_as_transfer')
                  $type='in';
                  elseif($value['product_details']['serv_type']=='meet_greet')
                  $type='IN';
                  elseif($value['product_details']['serv_type']=='driver_at_disposal')
                  $type='driv';
                  break;
                case 1:
                  if($value['product_details']['serv_type']=='service_as_transfer')
                  $type='out';
                  elseif($value['product_details']['serv_type']=='meet_greet')
                  $type='Out';
                  elseif($value['product_details']['serv_type']=='driver_at_disposal')
                  $type='';
                  break;
                case 2:
                  if($value['product_details']['serv_type']=='service_as_transfer')
                  $type='in&out';
                  elseif($value['product_details']['serv_type']=='meet_greet')
                  $type='Commute'; 
                  elseif($value['product_details']['serv_type']=='driver_at_disposal')
                  $type='';
                  break;
            }
            if(isset($value['product_details'][$type]['status'])){
              $retval[]=$key.$type;
            }           
          }
           
        }
    }
    

    return count($retval);
}

function aasort (&$array, $key) {
    $sorter=array();
    $ret=array();
    reset($array);
    foreach ($array as $ii => $va) {
        $sorter[$ii]=$va[$key];
    }
    asort($sorter);
    foreach ($sorter as $ii => $va) {
        $ret[$ii]=$array[$ii];
    }
    $array=$ret;
}



