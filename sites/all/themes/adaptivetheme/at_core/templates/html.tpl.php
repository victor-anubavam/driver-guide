<?php
/**
 * @file
 * Adaptivetheme implementation to display the basic html structure of a single
 * Drupal page.
 *
 * Adaptivetheme Variables:
 * - $html_attributes: structure attributes, includes the lang and dir attributes
 *   by default, use $vars['html_attributes_array'] to add attributes in preprcess
 * - $polyfills: prints IE conditional polyfill scripts enabled via theme
 *   settings.
 * - $skip_link_target: prints an ID for the skip navigation target, set in
 *   theme settings.
 * - $is_mobile: Bool, requires the Browscap module to return TRUE for mobile
 *   devices. Use to test for a mobile context.
 *
 * Available Variables:
 * - $css: An array of CSS files for the current page.
 * - $language: (object) The language the site is being displayed in.
 *   $language->language contains its textual representation.
 *   $language->dir contains the language direction. It will either be 'ltr' or 'rtl'.
 * - $rdf_namespaces: All the RDF namespace prefixes used in the HTML document.
 * - $grddl_profile: A GRDDL profile allowing agents to extract the RDF data.
 * - $head_title: A modified version of the page title, for use in the TITLE
 *   tag.
 * - $head_title_array: (array) An associative array containing the string parts
 *   that were used to generate the $head_title variable, already prepared to be
 *   output as TITLE tag. The key/value pairs may contain one or more of the
 *   following, depending on conditions:
 *   - title: The title of the current page, if any.
 *   - name: The name of the site.
 *   - slogan: The slogan of the site, if any, and if there is no title.
 * - $head: Markup for the HEAD section (including meta tags, keyword tags, and
 *   so on).
 * - $styles: Style tags necessary to import all CSS files for the page.
 * - $scripts: Script tags necessary to load the JavaScript files and settings
 *   for the page.
 * - $page_top: Initial markup from any modules that have altered the
 *   page. This variable should always be output first, before all other dynamic
 *   content.
 * - $page: The rendered page content.
 * - $page_bottom: Final closing markup from any modules that have altered the
 *   page. This variable should always be output last, after all other dynamic
 *   content.
 * - $classes String of classes that can be used to style contextually through
 *   CSS.
 *
 * @see template_preprocess()
 * @see template_preprocess_html()
 * @see template_process()
 * @see adaptivetheme_preprocess_html()
 * @see adaptivetheme_process_html()
 */
?><!DOCTYPE html>
<!--[if IEMobile 7]><html class="iem7"<?php print $html_attributes; ?>><![endif]-->
<!--[if lte IE 6]><html class="lt-ie9 lt-ie8 lt-ie7"<?php print $html_attributes; ?>><![endif]-->
<!--[if (IE 7)&(!IEMobile)]><html class="lt-ie9 lt-ie8"<?php print $html_attributes; ?>><![endif]-->
<!--[if IE 8]><html class="lt-ie9"<?php print $html_attributes; ?>><![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)]><!--><html<?php print $html_attributes . $rdf_namespaces; ?>><!--<![endif]-->
<head>
<?php print $head; ?>
<title><?php print $head_title; ?></title>
<?php print $styles; ?>
<?php print $scripts; ?>
<script type="text/javascript" src="/sites/all/themes/privatetransfer_theme/scripts/datepicknew/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="/sites/all/themes/privatetransfer_theme/scripts/datepicknew/jquery-ui.min.js"></script>
<script type="text/javascript" src="/sites/all/themes/privatetransfer_theme/scripts/datepicknew/jquery-ui-sliderAccess.js"></script>
<script type="text/javascript" src="/sites/all/themes/privatetransfer_theme/scripts/datepicknew/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="/<?php print $directory;?>/scripts/jquery.placeholder.js"></script>
<?php if($head_title=='Payment Completed | Private Transfer'){ ?>
<link rel="stylesheet" href="<?php echo drupal_get_path('theme', 'privatetransfer_theme') ?>/scripts/printscripts/css/print.css" type="text/css" media="print" />
<link rel="stylesheet" href="<?php echo drupal_get_path('theme', 'privatetransfer_theme') ?>/scripts/printscripts/src/css/print-preview.css" type="text/css" media="screen">
<script src="/sites/all/themes/privatetransfer_theme/scripts/printscripts/src/jquery.tools.min.js"></script>
<script src="/sites/all/themes/privatetransfer_theme/scripts/printscripts/src/jquery.print-preview.js" type="text/javascript" charset="utf-8"></script>
<?php } ?>
<link rel="stylesheet" href="<?php echo drupal_get_path('theme', 'privatetransfer_theme') ?>/scripts/jqueryselect/jquery.selectbox.css" type="text/css"/>
<script type="text/javascript" src="<?php echo drupal_get_path('theme', 'privatetransfer_theme') ?>/scripts/jqueryselect/jquery.selectbox-0.2.js"></script>
<script type="text/javascript" src="/sites/all/themes/privatetransfer_theme/scripts/custom_script.js"></script>
<script type="text/javascript" src="/sites/all/themes/privatetransfer_theme/scripts/cart.js"></script>
<script type="text/javascript" src="/sites/all/themes/privatetransfer_theme/scripts/formwizard.js" type="text/javascript"></script>
<script type="text/javascript" src="/sites/all/themes/privatetransfer_theme/scripts/jquery.multiFieldExtender-2.0.js"></script>
<script type="text/javascript" src="<?php echo drupal_get_path('theme', 'privatetransfer_theme') ?>/jqconfirm/jquery.confirm.js"></script>
<link href="<?php echo drupal_get_path('theme', 'privatetransfer_theme') ?>/jqconfirm/jquery.confirm.css"  rel="stylesheet" type="text/css" />
<link href="/sites/all/themes/privatetransfer_theme/scripts/cal/demo.css"  rel="stylesheet" type="text/css" />
<link href="/sites/all/themes/privatetransfer_theme/scripts/datepick.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
  jQuery(document).ready(function(){
    
  <?php if(!isset($_REQUEST['field_send_mail_member_value'])) { ?>
  //alert('sdfsdf');
  //jQuery("#edit-field-send-mail-member-value option[value='All']").attr("selected",true);
  <?php } ?>

  var watermark = 'Username';
 jQuery('#block-user-login #edit-name').blur(function(){
  if (jQuery(this).val().length == 0)
    jQuery(this).val(watermark).addClass('watermark');
 }).focus(function(){
  if (jQuery(this).val() == watermark)
    jQuery(this).val('').removeClass('watermark');
 }).val(watermark).addClass('watermark');
 
  var watermark1 = 'Password';
 jQuery('#block-user-login #edit-pass').blur(function(){
  if (jQuery(this).val().length == 0)
    jQuery(this).val(watermark1).addClass('watermark');
 }).focus(function(){
  if (jQuery(this).val() == watermark1)
    jQuery(this).val('').removeClass('watermark');
 }).val(watermark1).addClass('watermark');
 
  //jQuery("#block-user-login #edit-name").attr("placeholder","Adresses email");
  //jQuery("#block-user-login #edit-pass").attr("placeholder","Password");                    
  });
</script>
</script>
<?php print $polyfills; ?>
</head>
<body class="<?php print $classes; ?>"<?php print $attributes; ?>>
    <div id="initialContainerMask"></div>
    <div id="loader">
        <div id="loaderAnimator">
	    <img src='/sites/all/themes/privatetransfer_theme/images/loading.gif'>
        </div>
    </div>
  <div id="skip-link">
    <a href="<?php print $skip_link_target; ?>" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
  </div>
  <?php print $page_top; ?>
  <?php print $page; ?>
  <?php print $page_bottom; ?>
</body>
<!--<div id="loader"></div>-->
</html>
