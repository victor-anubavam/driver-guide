<?php
define('DRUPAL_ROOT', getcwd());
$base_url = 'http://'.$_SERVER['HTTP_HOST']; // THIS IS IMPORTANT
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL); // Could be DRUPAL_BOOTSTRAP_SESSION if that's all you need.

global $base_url;
?>

<html>
<head>
<script type="text/javascript" language="javascript">
 function subpaybox(){
 document.getElementById('paybox_frm').submit();
 }
 </script>

</head>
<body onload="subpaybox()">


<?PHP
$REFERENCE=$_REQUEST['PBX_CMD'];
$MONTANT=$_REQUEST['PBX_TOTAL']*100;
$PORTEUR=$_REQUEST['PBX_PORTEUR'];
//PBX_SITE : 6110572
//PBX_RANG : 01 for live act activate
//PBX_IDENTIFIANT : 2
$datetime = date("c");
$msg = "PBX_SITE=1999888".
"&PBX_RANG=32".
"&PBX_IDENTIFIANT=2".
"&PBX_TOTAL=".$MONTANT.
"&PBX_DEVISE=978".
"&PBX_CMD=".$REFERENCE.
"&PBX_PORTEUR=".$PORTEUR.
"&PBX_RETOUR=Mt:Mt:M;Ref:R;Auto:A;Erreur:E".
"&PBX_HASH=SHA512".
"&PBX_TIME=".$datetime;
$pbx_hash = "SHA512";
//$keyTest = '5FAB2E1D95ACAA0083736C7D7C8DF3321B76A1B7C7E6D3B387A72FC00F62837F8CB4604223E7B58AA64647D277CC6E1FFA48C76327CEDBE1CCF9DEE8D629AEB3';
$keyTest="0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF";
$binKey = pack("H*", $keyTest);
$hmac = strtoupper(hash_hmac($pbx_hash, $msg, $binKey));
$pbx_hmac = $hmac;
?>
<img src="sites/all/themes/privatetransfer_theme/images/connecting.gif" style="border:none;position:absolute;left:48%;top:18%;z-index:1;"/>
<img src="sites/all/themes/privatetransfer_theme/images/paybox_pic.png" style="border:none;position:absolute;left:35%;top:30%;z-index:1;"/>    
<form name="paybox_frm" id="paybox_frm"  method="GET" action="https://preprod-tpeweb.paybox.com/cgi/MYchoix_pagepaiement.cgi">
<input type="hidden" name="PBX_SITE" value="1999888">
<input type="hidden" name="PBX_RANG" value="32">
<input type="hidden" name="PBX_IDENTIFIANT" value="2">
    <input type="hidden"  name="PBX_TOTAL" value="<?PHP echo $MONTANT;?>">
    <input type="hidden"  name="PBX_DEVISE" value="978">
    <input type="hidden"  name="PBX_CMD" value="<?PHP echo $REFERENCE;?>">
    <input type="hidden"  name="PBX_PORTEUR" value="<?PHP echo $PORTEUR;?>">
    <input type="hidden"  name="PBX_RETOUR" value="Mt:Mt:M;Ref:R;Auto:A;Erreur:E">
 <input type="hidden" name="PBX_HASH" value="SHA512">
  <input type="hidden" name="PBX_TIME" value="<?PHP echo $datetime;?>">
  <input type="hidden" name="PBX_HMAC" value="<?PHP echo $pbx_hmac;?>">
<!-- Code added for return url-->
  <!--<input type="hidden" name="PBX_REFUSE" value="http://test.fr/" />
    <input type="hidden" name="PBX_ANNULE" value="http://test.fr/" />
    <input type="hidden" name="PBX_EFFECTUE" value="http://test.fr/" />-->
<input type="submit"   value="PAIEMENT" style="display:none;">
</form> 
</body>
</html>
