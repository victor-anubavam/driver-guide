<?php

define('DRUPAL_ROOT', getcwd());
$base_url = 'http://'.$_SERVER['HTTP_HOST']; // THIS IS IMPORTANT
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL); // Could be DRUPAL_BOOTSTRAP_SESSION if that's all you need.
global $base_url;
/*
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);*/

$_REQUEST['chkoutId']='240';
$_REQUEST['payment_Success']='Y';
$_REQUEST['paybaxId']='PBX123';
$contentAgtArr=array();
$contentCltArr=array();
if(isset($_REQUEST['payment_Success']) && trim($_REQUEST['payment_Success'])=='Y' && isset($_REQUEST['chkoutId']) 
   && trim($_REQUEST['chkoutId'])!='' && isset($_REQUEST['paybaxId']) && trim($_REQUEST['paybaxId'])!='')
{
    $checkout_id=trim($_REQUEST['chkoutId']);
    $paybax_trans_id=trim($_REQUEST['paybaxId']);
    db_update('log_detailed_transfer_results_checkout')
    ->fields(array(
              'paybax_trans_id' => $paybax_trans_id,
              'trans_status' => 1,
            ))
    ->condition ('id', $checkout_id, '=')
    ->execute();   
    
    $html_cont_Header='    
    <html>
    <head>
    <title></title>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <style type="text/css">
    @media only screen and (max-device-width: 480px) { 
    table[class=w0], td[class=w0] { width: 0 !important; }
    table[class=w10], td[class=w10], img[class=w10] { width:10px !important; }
    table[class=w15], td[class=w15], img[class=w15] { width:5px !important; }
    table[class=w30], td[class=w30], img[class=w30] { width:10px !important; }
    table[class=w60], td[class=w60], img[class=w60] { width:10px !important; }
    table[class=w125], td[class=w125], img[class=w125] { width:80px !important; }
    table[class=w130], td[class=w130], img[class=w130] { width:55px !important; }
    table[class=w140], td[class=w140], img[class=w140] { width:90px !important; }
    table[class=w160], td[class=w160], img[class=w160] { width:180px !important; }
    table[class=w170], td[class=w170], img[class=w170] { width:100px !important; }
    table[class=w180], td[class=w180], img[class=w180] { width:80px !important; }
    table[class=w195], td[class=w195], img[class=w195] { width:80px !important; }
    table[class=w220], td[class=w220], img[class=w220] { width:80px !important; }
    table[class=w240], td[class=w240], img[class=w240] { width:180px !important; }
    table[class=w255], td[class=w255], img[class=w255] { width:185px !important; }
    table[class=w275], td[class=w275], img[class=w275] { width:135px !important; }
    table[class=w280], td[class=w280], img[class=w280] { width:135px !important; }
    table[class=w300], td[class=w300], img[class=w300] { width:140px !important; }
    table[class=w325], td[class=w325], img[class=w325] { width:95px !important; }
    table[class=w360], td[class=w360], img[class=w360] { width:140px !important; }
    table[class=w410], td[class=w410], img[class=w410] { width:180px !important; }
    table[class=w470], td[class=w470], img[class=w470] { width:200px !important; }
    table[class=w580], td[class=w580], img[class=w580] { width:280px !important; }
    table[class=w640], td[class=w640], img[class=w640] { width:300px !important; }
    table[class*=hide], td[class*=hide], img[class*=hide], p[class*=hide], span[class*=hide] { display:none !important; }
    table[class=h0], td[class=h0] { height: 0 !important; }
    p[class=footer-content-left] { text-align: center !important; }
    #headline p { font-size: 30px !important; }
    .article-content, #left-sidebar{ -webkit-text-size-adjust: 90% !important; -ms-text-size-adjust: 90% !important; }
    .header-content, .footer-content-left {-webkit-text-size-adjust: 80% !important; -ms-text-size-adjust: 80% !important;}
    img { height: auto; line-height: 100%;}
     } 
    #headertable{border: 1px solid #014F7D;color:#FFF;}
    #outlook a { padding: 0; }	
    body { width: 100% !important; }
    .ReadMsgBody { width: 100%; }
    .ExternalClass { width: 100%; display:block !important; }
    body { background-color: #ececec; margin: 0; padding: 0; }
    img { outline: none; text-decoration: none; display: block;}
    br, strong br, b br, em br, i br { line-height:100%; }
    h1, h2, h3, h4, h5, h6 { line-height: 100% !important; -webkit-font-smoothing: antialiased; }
    h1 a, h2 a, h3 a, h4 a, h5 a, h6 a { color: blue !important; }
    h1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {	color: red !important; }
    h1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited { color: purple !important; }
    table td, table tr { border-collapse: collapse; }
    .yshortcuts, .yshortcuts a, .yshortcuts a:link,.yshortcuts a:visited, .yshortcuts a:hover, .yshortcuts a span {
    color: black; text-decoration: none !important; border-bottom: none !important; background: none !important;
    }
    .rowTable{padding:10px;background:#FFF;border-width: 0 1px;border-style: none solid solid; border-color: #014F7D;}
    code { white-space: normal;word-break: break-all;}
    #background-table { background-color: #ececec; }
    #top-bar { border-radius:6px 6px 0px 0px; -moz-border-radius: 6px 6px 0px 0px; -webkit-border-radius:6px 6px 0px 0px; -webkit-font-smoothing: antialiased; background-color: #014F7D; color: #FFFFFF; }
    #top-bar a { font-weight: bold; color: #FFFFFF; text-decoration: none;}
    #footer { border-radius:0px 0px 6px 6px; -moz-border-radius: 0px 0px 6px 6px; -webkit-border-radius:0px 0px 6px 6px; -webkit-font-smoothing: antialiased; }
    body, td { font-family: Helvetica Neue, Arial, Helvetica, sans-serif; }
    .header-content, .footer-content-left, .footer-content-right { -webkit-text-size-adjust: none; -ms-text-size-adjust: none; }
    .header-content { font-size: 12px; color: #FFFFFF; }
    .header-content a { font-weight: bold; color: #FFFFFF; text-decoration: none; }
    #headline p { color: #FFFFFF; font-family: Helvetica Neue, Arial, Helvetica, Geneva, sans-serif; font-size: 36px; text-align: center; margin-top:0px; margin-bottom:30px; }
    #headline p a { color: #FFFFFF; text-decoration: none; }
    .article-title { font-size: 18px; line-height:24px; color: #014F7D; font-weight:bold; margin-top:0px; margin-bottom:18px; font-family: Helvetica Neue, Arial, Helvetica, sans-serif; }
    .article-title a { color: #014F7D; text-decoration: none; }
    .article-title.with-meta {margin-bottom: 0;}
    .article-meta { font-size: 13px; line-height: 20px; color: #ccc; font-weight: bold; margin-top: 0;}
    .article-content { padding-left: 30px; font-size: 13px; line-height: 18px; color: #6C6C6C; margin-top: 0px; margin-bottom: 18px; font-family: Helvetica Neue, Arial, Helvetica, sans-serif; }
    .article-content a { color: #014F7D; font-weight:bold; text-decoration:none; }
    .article-content img { max-width: 100% }
    .article-content ol, .article-content ul { margin-top:0px; margin-bottom:18px; margin-left:19px; padding:0; }
    .article-content li { font-size: 13px; line-height: 18px; color: #444444; }
    .article-content li a { color: #014F7D; text-decoration:underline; }
    .article-content p {margin-bottom: 15px;}
    .footer-content-left { font-size: 12px; line-height: 15px; color: #e2e2e2; margin-top: 0px; margin-bottom: 15px; }
    .footer-content-left a { color: #FFFFFF; font-weight: bold; text-decoration: none; }
    .footer-content-right { font-size: 11px; line-height: 16px; color: #e2e2e2; margin-top: 0px; margin-bottom: 15px; }
    .footer-content-right a { color: #FFFFFF; font-weight: bold; text-decoration: none; }
    #footer { background-color: #014F7D; color: #e2e2e2; }
    #footer a { color: #FFFFFF; text-decoration: none; font-weight: bold; }
    #permission-reminder { white-space: normal; }
    #street-address { color: #FFFFFF; white-space: normal; }
    .bdFont{font-size: 16px;}
    .blueTagR{font-weight:bold;font-size: 16px; color: #2283BC;  float: right;  text-align: right;  clear: both;}
     .serviceInfo {
    border-top: 1px solid #CCCCCC;
    color: #6C6C6C;
    font-weight: normal;
    padding-top: 5px;
    }
    .fRight{float:right;text-align: right;}
    </style>
    </head
    <body><table width="100%" cellspacing="0" cellpadding="0" border="0" id="background-table" >
            <tbody><tr>
                    <td align="center" bgcolor="#ececec">
                    <table width="640" cellspacing="0" cellpadding="0" border="0" style="margin:0 10px;" class="w640">
                    <tbody><tr><td width="640" height="20" class="w640"></td></tr>                   
                    <tr>
                            <td width="640" class="w640">
                            <table width="640" cellspacing="0" cellpadding="0" border="0" bgcolor="#014F7D" class="w640" id="top-bar" style="border-radius: 6px 6px 0 0;">
        <tbody><tr>
            <td width="15" class="w15"></td>
            <td align="left" width="350" valign="middle" class="w325">
                <table width="350" cellspacing="0" cellpadding="0" border="0" class="w325">
                    <tbody><tr><td width="350" height="8" class="w325"></td></tr>
                </tbody></table>
                <div class="header-content" style="color:#FFFFFF"><a style="color: #FFFFFF;font-weight: bold;text-decoration:none;" class="cm-webversion" href="http://www.private-transfer.fr">www.private-transfer.fr</a><span class="hide">&nbsp;&nbsp;|&nbsp;Toll free from US: <strong>1 866 813 7381</strong><br/><span style="color: #FFFFFF;font-weight: bold;text-decoration:none;"><a style="color:#FFFFFF;text-decoration:none;" target="_blank" href="mailto:reservation@private-transfer.fr">reservation@private-transfer.fr</a></span></span></div>
                <table width="350" cellspacing="0" cellpadding="0" border="0" class="w325">
                    <tbody><tr><td width="350" height="8" class="w325"></td></tr>
                </tbody></table>
            </td>
            <td width="30" class="w30"></td>
            <td align="right" width="255" valign="middle" class="w255">
                <table width="255" cellspacing="0" cellpadding="0" border="0" class="w255">
                    <tbody><tr><td width="255" height="8" class="w255"></td></tr>
                </tbody></table>
                <table cellspacing="0" cellpadding="0" border="0">
        <tbody><tr></tr>
</tbody></table>
            <table width="255" cellspacing="0" cellpadding="0" border="0" class="w255">
                <tbody><tr><td width="255" height="8" class="w255"></td></tr>
            </tbody></table>
        </td>
        <td width="15" class="w15"></td>
    </tr>
</tbody></table>              
                    </td>
                </tr>
                <tr>
                <td align="center" width="640" class="w640" id="header" bgcolor="#FFFFFF">
    
    <table width="640" id="headertable" cellspacing="0" cellpadding="0" border="0" class="w640" style="1px solid #014F7D" style="border-color: #014F7D;border-style:solid;border-width: 0 1px 1px;padding:10px;">
        <tbody><tr><td width="30" class="w30"></td><td width="580" height="30" class="w580"></td><td width="30" class="w30"></td></tr>
        <tr>
            <td width="30" class="w30"></td>
            <td width="580" class="w580">
                <div align="center" id="headline">
                    <p> 
                        <img  src="'.$base_url.'/'.drupal_get_path('theme', 'privatetransfer_theme').'/logo.png" >
                    </p>
                </div>
            </td>
            <td width="30" class="w30"></td>
        </tr>
    </tbody></table>
</td>
                </tr> ';
   
        
        
   $html_cont_footer.='<!--<tr><td width="640" height="15" bgcolor="#ffffff" class="w640"></td></tr> -->              
                <tr>
                <td width="640" class="w640" align="center">
    <table width="640" cellspacing="0" cellpadding="0" border="0" bgcolor="#014F7D" class="w640" id="footer" style="color:#FFFFFF;border-radius: 0 0 6px 6px ;">
        <tbody><tr><td width="30" class="w30"></td><td width="360" height="30" class="w580 h0"></td><td width="60" class="w0"></td><td width="160" class="w0"></td><td width="30" class="w30"></td></tr>
        <tr>
            <td width="30" class="w30"></td>
            <td width="360" valign="top" class="w580">
            <span class="hide"><p align="left" class="footer-content-left" id="permission-reminder"></p></span>
            <p align="left" class="footer-content-left">
                <strong>Découvertes SARL</strong><br/>
                2012 Découvertes SARL, 8 bis avenue du Cegares, <br/>13840 Rognes, France
Decouvertes Inc., 256 Carlton Avenue, Brooklyn, NY 11205-4002- Licence n. L1.013.00.0004
               </p>
            </td>
            <td width="60" class="hide w0"></td>
            <td width="160" valign="top" class="hide w0">
            <p align="right" class="footer-content-right" id="street-address" style="color:#FFFFFF;font-size: 11px;">
                Private-transfer.fr / Contact us<br/>
Toll free from US:1 866 813 7381<br/>
<span style="#FFFFFF"><a style="color:#FFFFFF;text-decoration:none;" target="_blank" href="mailto:reservation@private-transfer.fr">reservation@private-transfer.fr</a></span><br/>
Tel: +33 442 50 14<br/>
Fax:+33 442 50 30 63</p>
            </td>
            <td width="30" class="w30"></td>
        </tr>
        <tr><td width="30" class="w30"></td><td width="360" height="15" class="w580 h0"></td><td width="60" class="w0"></td><td width="160" class="w0"></td><td width="30" class="w30"></td></tr>
    </tbody></table>
</td>
                </tr>
                <tr><td width="640" height="60" class="w640"></td></tr>
            </tbody></table>
        </td>
	</tr>
</tbody></table>
</body>
</html>';
    
    
    
    
    
   $html_cont_body='';
    $res_checkout=db_query("SELECT trav_agent_id, paybax_trans_id, client_email, act_price, comm_percent, total_amt
        from log_detailed_transfer_results_checkout WHERE id='".$checkout_id."'")->fetchAssoc();
    $trav_agent_id=$res_checkout['trav_agent_id'];
    $paybax_trans_id=$res_checkout['paybax_trans_id'];
    //$user = user_load($trav_agent_id);
    
    $userDetail=user_load($trav_agent_id);
    $agentUserName='';
    if(isset($userDetail->field_first_name['und'][0]['value']) && isset($userDetail->field_last_name['und'][0]['value']))
    {
        $agentUserName=ucfirst($userDetail->field_first_name['und'][0]['value']). ' '.ucfirst($userDetail->field_last_name['und'][0]['value']);
    }
    $agencyName='';
    $gid=db_query("SELECT gid FROM  og_users_roles where uid=".$user->uid)->fetchField();
    if($gid!='')
    {
        $etid='';
        $agtres=db_query("SELECT label,etid FROM  og where gid=".$gid);
        foreach($agtres as $res)
        {
            $etid=$res->etid;
            $agentName=$res->label;
        }
        if(trim($etid)!='')
        {
           $agencyName=db_query("SELECT og.label FROM og_membership as ogm left join og on ogm.gid=og.gid where ogm.etid=".$etid)->fetchField();
        }
        
    }
  
    $client_email=$res_checkout['client_email'];
    $act_price=$res_checkout['act_price'];    
    $comm_percent=$res_checkout['comm_percent'];
    $total_amt=$res_checkout['total_amt'];
    
    $res_service=db_query("SELECT id, service_type, service_selector_id, delta, qty,price,agt_price,day_applied,service_id, servtitle, arrival_time, 
            night_rate_percent,region,fromplace,toplace,driv_details,no_wheel_luggage, no_regular_luggage, no_people, no_odd_luggage, 
            desc_odd_luggage from log_detailed_service_Info 
            WHERE checkout_id='".$checkout_id."' order by FIELD (service_selector_id,  'Commute','IN',  'in', 'in&out', 'driv' ,'Out','out')");
    
    
    $output='';     
    $tot_price=0;
    $subtot_price=0;
    $output_client='';  
    
    $outputContent='';
    $retval=array();
    $userInfo='';
    
    $output_reviewCart='<div id="payCont">
        <a class="print-preview fRight btn">Print</a>
        <table width="640" cellspacing="0" cellpadding="0" border="0" >
        <tbody>
        <tr>
            <td><div class="invTitle">Review your cart & Payment</div></td>
        </tr>
        <tr>
            <td id="content-column" ><table>'; 
    
     $output_custInvoice='<div id="payCont">
        <a class="print-preview fRight btn">Print</a>
        <table width="640" cellspacing="0" cellpadding="0" border="0" >
        <tbody>
        <tr>
            <td><p><div class="invTitle">Customer Invoice</div><br/>Our reference:  ('.$paybax_trans_id.')<br/>
    Clients Name: '.$userInfo.'<br/>
   Agent: '.$agentUserName.'. / '.$agentName.'<br/>
    Agency: '.$agencyName.'<br/></p></td>
        </tr>
        <tr>
            <td id="content-column" ><table>'; 
    $output_travagtCommInvoice='<div id="payCont">
        <a class="print-preview fRight btn">Print</a>
        <table width="640" cellspacing="0" cellpadding="0" border="0" >
        <tbody>
        <tr>
            <td><p><div class="invTitle">Travel Agent Commission Invoice</div><br/>Our reference:  ('.$paybax_trans_id.')<br/>
    Clients Name: '.$userInfo.'<br/>
    Agent: '.$agentUserName.'. / '.$agentName.'<br/>
    Agency: '.$agencyName.'<br/></p></td>
        </tr>
        <tr>
            <td id="content-column" ><table>'; 
    
    
    
    $output_supmeetInvoice='<div id="payCont">
        <a class="print-preview fRight btn">Print</a>
        <table width="640" cellspacing="0" cellpadding="0" border="0" >
        <tbody>
        <tr>
            <td><p><div class="invTitle">Passengers Travel Document for Suppliers</div><br/>Our reference:  ('.$paybax_trans_id.')<br/>
    Clients Name: '.$userInfo.'<br/>
    Agent: '.$agentUserName.'. / '.$agentName.'<br/>
    Agency: '.$agencyName.'<br/><br/>
    Dear [PassengerInfo],<br/>
    It is my pleasure on behalf of Découvertes to wish you a safe and enjoyable journey in France.  I hope that you are looking forward to your visit here!<br/><br/>
    Should you need to contact Découvertes for whatever reason during your stay, below are our Office Hours and contact information.<br/><br/>
    Office Hours: Monday to Friday 9.30am – 7.00pm<br/>
    Office Direct Line: +33 (0)4 4250 3564<br/>
    Découvertes’ 24/7 contact number: +33(0)6 1406 1967<br/><br/>
    It has been a pleasure for us to help you  organize your stay in France.  Should you wish to add anything or have any questions concerning your itinerary, please do not hesitate to contact us and we will do our utmost to accommodate you.<br/><br/>
    Have a wonderful stay in France!<br/><br/>
    Very best regards,<br/>
    Découvertes\' team. </p></td>
        </tr>
        <tr>
            <td id="content-column" ><table>';
    
   
    $reviewInvoice='';
    $custInvoice='';
    $travagtCommInvoice='';   
    $suptransInvoice='';
    $supmeetInvoice='';
    $meetOutshtArr=array();
    $transOutshtArr=array();
    $meetOutArr=array();
    $meetOutArrSup=array();
    $transOutArr=array();
    $transOutArrSup=array();
    $totclt_price=0;
    $transSup=array();
     
     foreach ($res_service as $record) {
            $service_info_id=$record->id;            
            $service_type=$record->service_type;
            $type=$record->service_selector_id;
            $delta=$record->delta;
            $qty=$record->qty;
            $price=$record->price;
            $agt_comm=$record->agt_price;
            $service_id=$record->service_id;
            $servtitle=$record->servtitle;
            $arrival_time=$record->arrival_time;
            $night_rate_percent=$record->night_rate_percent;
            $region=$record->region;
            $from=$record->fromplace;
            $to=$record->toplace;
            $driv_details=$record->driv_details;
            $no_wheel_luggage=$record->no_wheel_luggage;
            $no_regular_luggage=$record->no_regular_luggage;
            $no_people=$record->no_people;
            $no_odd_luggage=$record->no_odd_luggage;
            $desc_odd_luggage=$record->desc_odd_luggage;
      
            if($service_type=='service_as_transfer')
            {
                if($type=='in')
                {
                    $res_in=db_query("SELECT id, arrival_airport, arriv_dt, airline, flight_no, arriv_hr,
                    arriv_mt, arriv_meridian, driver_hostess_lang, comments, dest_addr from log_detailed_in_travel_Info 
                    WHERE checkout_id='".$checkout_id."' and ls_id='".$service_info_id."' and service_type='".$service_type."'")->fetchAssoc();
                    
                    $trav_id=$res_in['id'];
                    $arrival_airport=$res_in['arrival_airport'];
                    $arriv_dt=$res_in['arriv_dt'];
                    $airline=$res_in['airline'];
                    $flight_no=$res_in['flight_no'];
                    $arriv_hr=$res_in['arriv_hr'];
                    $arriv_mt=$res_in['arriv_mt'];
                    $arriv_meridian=$res_in['arriv_meridian'];
                    $driver_hostess_lang=$res_in['driver_hostess_lang'];
                    $comments=$res_in['comments'];
                    $dest_addr=$res_in['dest_addr'];
                    
                    $passengerDetails='';
                    $res_passenger=db_query("SELECT title, first_name, middle_name, last_name,	ph_no from login_trav_person_details 
                    WHERE trav_id='".$trav_id."'");
                    
                    foreach ($res_passenger as $rec_pass) {
                        if(trim($passengerDetails)!=''){$passengerDetails.=' and ';}
                        $passengerDetails.=$rec_pass->title;
                        $passengerDetails.='.'.$rec_pass->first_name;
                        $passengerDetails.=' '.$rec_pass->last_name;
                        $passengerDetails.=', Tel: '.$rec_pass->ph_no.'.';
                        if(trim($userInfo)!=''){$userInfo.=' and ';}
                        $userInfo.=ucfirst($rec_pass->first_name).' '.ucfirst($rec_pass->last_name);
                    }
                  
                   
                    $clientprice=0;
                    //Check for travel agent Login
                    if(isset($user->roles[5]))
                    {
                        $price=$agt_comm;
                        $clientprice=$price;
                    }
                    else {
                        $clientprice=$agt_comm;
                    }
                   
                  
                    if(isset($arrival_time) && trim($arrival_time)=='2')
                    {   
                        $night_comm_price=($clientprice*$night_rate_percent)/100;
                        $clientprice=$clientprice+$night_comm_price;
                        $night_comm_price=($price*$night_rate_percent)/100;
                        $price=$price+$night_comm_price;
                    }
                    
                    $subtot_price+=$price;
                    $qtyCont='';
                    $qtyCont_client='';
                    if($comm_percent!='' && $comm_percent!='0')
                    {
                        $clientprice=$clientprice+(($comm_percent*$clientprice)/100);
                    }
                    if($qty>1)
                    {
                        $qtyCont=$qty.' (Qty)  * '.$price.' = ';                        
                        $qtyCont_client=$qty.' (Qty)  * '.$clientprice.' = ';
                        $price=$price* $qty;
                        $clientprice=$clientprice* $qty;
                    }
                    
                    $tot_price+=$price; 
                    $totclt_price+=$clientprice;
                    
                    
                    $output_buffsmCont=$output_buff='<tr><td><table  cellspacing="0" cellpadding="0" width="640"  border="0" bgcolor="#FFFFFF" class="rowTable" style="border-color: #014F7D;border-style:none ;border-width: 0 1px;padding:10px;">
                    <tbody><tr>
                        <td >
                            <p align="left" class="article-title serviceInfo">Services for '._dt_day($arriv_dt).' '.$arriv_dt.'</p>
                            <p align="left" class="article-title">Transfer In from '.$from.' to '.$to.'</p>
                            <div align="left" class="article-content">
                                <p>Flight '.$airline.' #'.$flight_no.' arrives at '.$arriv_hr.':'.$arriv_mt.strtolower($arriv_meridian).', coming from '.$from.',</p>
                                <p>'.$arriv_hr.':'.$arriv_mt.strtolower($arriv_meridian).': Meet your '.$driver_hostess_lang.'-speaking driver at  '.$arrival_airport.' upon arrival,</p>
                                <p>Private transfer service with a '.$servtitle.' from  '.$arrival_airport.' to '.$dest_addr.',</p>
                                <p>For '.$passengerDetails.' / '.$no_people.' passengers,</p>
				<p>Your driver contact: '.$driv_details.'.</p>';
                $reviewInvoice.=$output_buff;    
                $custInvoice.=$output_buffsmCont.'<p><div class="fRight" style="float:right;text-align:right;">Price for this service: '.$qtyCont_client.'<strong>'.$clientprice.' €uros</strong></div></p>'; 
                $travagtCommInvoice.=$output_buffsmCont; 
                $suptransInvoice.=$output_buff; 
                $reviewInvoice.='<p><div class="fRight" style="float:right;text-align:right;">Price for this service: '.$qtyCont.'<strong>'.$price.' €uros</strong></div></p>';
                $output_buff='</div>
                        </td>
                    </tr>
                    <tr><td><div class="separator"></div></td></tr>
                </tbody></table></td></tr>';                    
                      $reviewInvoice.=$output_buff;    
                      $custInvoice.=$output_buff; 
                      $suptransInvoice.=$output_buff;
                      $transSup[$region]['transfer']['in'][]=$suptransInvoice;
                      $suptransInvoice='';
                      
                    
                }
                elseif($type=='out')
                {
                    $res_out=db_query("SELECT id, service_dt, airport_dept,airline, flight_no, decol_hr, decol_mt,
                    decol_meridian, pickup_hr, pickup_mt, pickup_meridian, pickup_addr, drop_addr, lang_driv_hostess, 
                    comments from log_detailed_out_travel_Info  WHERE checkout_id='".$checkout_id."' and 
                    ls_id='".$service_info_id."' and service_type='".$service_type."'")->fetchAssoc();
                    
                    $trav_id=$res_out['id'];                    
                    $service_dt=$res_out['service_dt'];
                    $arrival_airport=$res_out['airport_dept'];
                    $airline=$res_out['airline'];
                    $flight_no=$res_out['flight_no'];
                    $decol_hr=$res_out['decol_hr'];
                    $decol_mt=$res_out['decol_mt'];
                    $decol_meridian=$res_out['decol_meridian'];
                    $pickup_hr=$res_out['pickup_hr'];
                    $pickup_mt=$res_out['pickup_mt'];
                    $pickup_meridian=$res_out['pickup_meridian'];
                    $pickup_addr=$res_out['pickup_addr'];
                    $drop_addr=$res_out['drop_addr'];
                    $lang_driv_hostess=$res_out['lang_driv_hostess'];
                    $comments=$res_out['comments'];
                    
                    $passengerDetails='';
                    $res_passenger=db_query("SELECT title, first_name, middle_name, last_name,	ph_no from logout_trav_person_details 
                    WHERE trav_id='".$trav_id."'");
                    
                    foreach ($res_passenger as $rec_pass) {
                        if(trim($passengerDetails)!=''){$passengerDetails.=' and ';}
                        $passengerDetails.=$rec_pass->title;
                        $passengerDetails.='.'.$rec_pass->first_name;
                        $passengerDetails.=' '.$rec_pass->last_name;
                        $passengerDetails.=', Tel: '.$rec_pass->ph_no.'.';
                        if(trim($userInfo)!=''){$userInfo.=' and ';}
                        $userInfo.=ucfirst($rec_pass->first_name).' '.ucfirst($rec_pass->last_name);
                    }
                    $clientprice=0;
                    //Check for travel agent Login
                    if(isset($user->roles[5]))
                    {
                        //$agt_price=$price-(($price*$agt_comm)/100);
                        //$price=$agt_price;
                         $price=$agt_comm;
                         $clientprice=$price;
                    }  
                    else {
                         $clientprice=$agt_comm;
                    }
                    
                    
                    if(isset($arrival_time) && trim($arrival_time)=='2')
                    {   
                        $night_comm_price=($clientprice*$night_rate_percent)/100;
                        $clientprice=$clientprice+$night_comm_price;
                        $night_comm_price=($price*$night_rate_percent)/100;
                        $price=$price+$night_comm_price;
                    }
                    $subtot_price+=$price;
                    $qtyCont='';
                    $qtyCont_client='';
                    if($comm_percent!='' && $comm_percent!='0')
                    {
                        $clientprice=$clientprice+(($comm_percent*$clientprice)/100);
                    }
                    if($qty>1)
                    {
                        $qtyCont=$qty.' (Qty)  * '.$price.' = ';                        
                        $qtyCont_client=$qty.' (Qty)  * '.$clientprice.' = ';
                        $price=$price* $qty;
                        $clientprice=$clientprice* $qty;
                    }
                    $tot_price+=$price; 
                    $totclt_price+=$clientprice;
                   
                    $output_buffsmCont=$output_buff='<tr><td style="padding-left:0;"><table   cellspacing="0" cellpadding="0"  width="640" border="0" bgcolor="#FFFFFF" class="rowTable" style="border-color: #014F7D;border-style:none ;border-width: 0 1px;padding:10px;" >
                    <tbody><tr>
                        <td>
                            <p align="left" class="article-title serviceInfo">Services for '._dt_day($service_dt).' '.$service_dt.'</p>
                            <p align="left" class="article-title">Transfer Out from '.$from.' to '.$to.'</p>
                            <div align="left" class="article-content">
                                <p>'.$pickup_hr.':'.$pickup_mt.strtolower($pickup_meridian).' pickup : Meet your '.$lang_driv_hostess.'-speaking driver  pickup from '.$pickup_addr.' to '.$drop_addr.',</p>
                                <p>Private transfer service with a '.$servtitle.' from the pickup from '.$pickup_addr.' to '.$to.',</p>
                                <p>Flight '.$airline.' #'.$flight_no.' departs at '.$decol_hr.':'.$decol_mt.' '.$decol_meridian.', flying to '.$arrival_airport.'</p>
                                <p>For '.$passengerDetails.' / '.$no_people.' passengers,</p>
				<p>Your driver contact: '.$driv_details.',</p>';
                $reviewInvoice.=$output_buff;    
                $custInvoice.=$output_buffsmCont.'<p><div class="fRight" style="float:right;text-align:right;">Price for this service: '.$qtyCont_client.'<strong>'.$clientprice.' €uros</strong></div></p>'; 
                $travagtCommInvoice.=$output_buffsmCont;
                $suptransInvoice.=$output_buff; 
                $reviewInvoice.='<p><div class="fRight" style="float:right;text-align:right;">Price for this service: '.$qtyCont.'<strong>'.$price.' €uros</strong></div></p>';
                                
                      $output_buff='</div>
                        </td>
                    </tr>
                    <tr><td><div class="separator"></div></td></tr>
                </tbody></table></td></tr>';
                    $reviewInvoice.=$output_buff;    
                    $custInvoice.=$output_buff; 
                    $suptransInvoice.=$output_buff;
                   
                    $transSup[$region]['transfer']['out'][]=$suptransInvoice;
                    $suptransInvoice='';
                }                
                elseif($type=='in&out')
                {
                   
                    $res_in=db_query("SELECT id, arrival_airport, arriv_dt, airline, flight_no, arriv_hr,
                    arriv_mt, arriv_meridian, driver_hostess_lang, comments, dest_addr from log_detailed_in_travel_Info 
                    WHERE checkout_id='".$checkout_id."' and ls_id='".$service_info_id."' and service_type='".$service_type."'")->fetchAssoc();
                    $agt_comm=$agt_comm*2;
                    $trav_id=$res_in['id'];
                    $arrival_airport=$res_in['arrival_airport'];
                    $arriv_dt=$res_in['arriv_dt'];
                    $airline=$res_in['airline'];
                    $flight_no=$res_in['flight_no'];
                    $arriv_hr=$res_in['arriv_hr'];
                    $arriv_mt=$res_in['arriv_mt'];
                    $arriv_meridian=$res_in['arriv_meridian'];
                    $driver_hostess_lang=$res_in['driver_hostess_lang'];
                    $comments=$res_in['comments'];
                    $dest_addr=$res_in['dest_addr'];
                    
                    
                    $res_out=db_query("SELECT id, service_dt, airport_dept, airline, flight_no, decol_hr, decol_mt,
                    decol_meridian, pickup_hr, pickup_mt, pickup_meridian, pickup_addr, drop_addr, lang_driv_hostess, 
                    comments from log_detailed_out_travel_Info  WHERE checkout_id='".$checkout_id."' and 
                    ls_id='".$service_info_id."' and service_type='".$service_type."'")->fetchAssoc();
                    
                    $service_dt=$res_out['service_dt'];
                    $airport_dept=$res_out['airport_dept'];
                    $airline_out=$res_out['airline'];
                    $flight_no_out=$res_out['flight_no'];
                    $decol_hr=$res_out['decol_hr'];
                    $decol_mt=$res_out['decol_mt'];
                    $decol_meridian=$res_out['decol_meridian'];
                    $pickup_hr=$res_out['pickup_hr'];
                    $pickup_mt=$res_out['pickup_mt'];
                    $pickup_meridian=$res_out['pickup_meridian'];
                    $pickup_addr=$res_out['pickup_addr'];
                    $drop_addr=$res_out['drop_addr'];
                    $lang_driv_hostess=$res_out['lang_driv_hostess'];
                    $comments_out=$res_out['comments'];
                    
                    
                    $passengerDetailsin='';
                    $res_passenger=db_query("SELECT title, first_name, middle_name, last_name,	ph_no from login_trav_person_details 
                    WHERE trav_id='".$trav_id."'");
                    
                    foreach ($res_passenger as $rec_pass) {
                        if(trim($passengerDetailsin)!=''){$passengerDetailsin.=' and ';}
                        $passengerDetailsin.=$rec_pass->title;
                        $passengerDetailsin.='.'.$rec_pass->first_name;
                        $passengerDetailsin.=' '.$rec_pass->last_name;
                        $passengerDetailsin.=', Tel: '.$rec_pass->ph_no.'.';
                        if(trim($userInfo)!=''){$userInfo.=' and ';}
                        $userInfo.=ucfirst($rec_pass->first_name).' '.ucfirst($rec_pass->last_name);
                    }
                    
                    $passengerDetailsout='';
                    $res_passenger=db_query("SELECT title, first_name, middle_name, last_name,	ph_no from login_trav_person_details 
                    WHERE trav_id='".$trav_id."'");
                    
                    foreach ($res_passenger as $rec_pass) {
                        if(trim($passengerDetailsout)!=''){$passengerDetailsout.=' and ';}
                        $passengerDetailsout.=$rec_pass->title;
                        $passengerDetailsout.='.'.$rec_pass->first_name;
                        $passengerDetailsout.=' '.$rec_pass->last_name;
                        $passengerDetailsout.=', Tel: '.$rec_pass->ph_no.'.';
                        if(trim($userInfo)!=''){$userInfo.=' and ';}
                        $userInfo.=ucfirst($rec_pass->first_name).' '.ucfirst($rec_pass->last_name);
                    }
                    $clientprice=0;
                    //Check for travel agent Login
                    if(isset($user->roles[5]))
                    {
                        //$agt_price=$price-(($price*$agt_comm)/100);
                        //$price=$agt_price;
                         $price=$agt_comm;
                         $clientprice=$price;
                    }
                    else {
                        $clientprice=$agt_comm;
                    }
                
                    
                    $night_comm_price=0;
                    $night_comm_price_clt=0;
                    $night_comm_price_clt=(($clientprice/2)*$night_rate_percent)/100;
                    $night_comm_price=(($price/2)*$night_rate_percent)/100;
                    if(isset($arrival_time) && trim($arrival_time)=='2')
                    {                  
                        $clientprice=$clientprice+$night_comm_price_clt;
                        $price=$price+$night_comm_price;
                    }

                    //Check for nightservice applied in out service for IN&OUT or COMMUTE
                    if(trim($decol_hr)!='' && trim($decol_meridian)!='') {
                        if(chknightService($decol_hr, $decol_meridian))
                        {
                            $clientprice=$clientprice+$night_comm_price_clt;
                            $price=$price+$night_comm_price;
                        }
                    }
                    
                    
                    $subtot_price+=$price;
                    $qtyCont='';
                    $qtyCont_client='';
                    if($comm_percent!='' && $comm_percent!='0')
                    {
                        $clientprice=$clientprice+(($comm_percent*$clientprice)/100);
                    }
                    
                    
                    if($qty>1)
                    {
                        $qtyCont=$qty.' (Qty)  * '.$price.' = ';                        
                        $qtyCont_client=$qty.' (Qty)  * '.$clientprice.' = ';
                        $price=$price* $qty;
                        $clientprice=$clientprice* $qty;
                    }
                    $tot_price+=$price; 
                    $totclt_price+=$clientprice;
                    $output_buffsmCont=$output_buff='<tr><td style="padding-left:0;"><table style="border-color: #014F7D;border-style:none ;border-width: 0 1px;padding:10px;" bgcolor="#FFFFFF" width="640" class="rowTable" cellspacing="0" cellpadding="0" border="0" >
                    <tbody><tr>
                        <td>
                            <p align="left" class="article-title serviceInfo">Services for '._dt_day($arriv_dt).' '.$arriv_dt.'</p>
                            <p align="left" class="article-title">Transfer In from '.$from.' to '.$to.'</p>
                            <div align="left" class="article-content">
                                <p>Flight '.$airline.' #'.$flight_no.' arrives at '.$arriv_hr.':'.$arriv_mt.strtolower($arriv_meridian).', coming from '.$from.',</p>
                                <p>'.$arriv_hr.':'.$arriv_mt.strtolower($arriv_meridian).': Meet your '.$driver_hostess_lang.'-speaking driver at '.$arrival_airport.' upon arrival,</p>    
                                <p>Private transfer service with a '.$servtitle.' from  '.$arrival_airport.' to '.$dest_addr.',</p>
                                <p>For '.$passengerDetailsin.' / '.$no_people.' passengers,</p>
				<p>Your driver contact:'.$driv_details.',</p>';
                                
                   $output_buffout='<tr><td style="padding-left:0;"><table style="border-color: #014F7D;border-style:none ;border-width: 0 1px;padding:10px;" bgcolor="#FFFFFF" width="640" class="rowTable" cellspacing="0" cellpadding="0" border="0" >
                    <tbody><tr>
                        <td><p align="left" class="article-title serviceInfo">Services for '._dt_day($service_dt).' '.$service_dt.'</p>
                            <p align="left" class="article-title" >Transfer Out from '.$to.' to '.$from.'</p>
                            <div align="left" class="article-content">
                                <p>'.$pickup_hr.':'.$pickup_mt.strtolower($pickup_meridian).' pickup : Meet your '.$lang_driv_hostess.'-speaking driver in the lobby of the '.$pickup_addr.',</p>
                                <p>Private transfer service with a '.$servtitle.' from the '.$pickup_addr.' to '.$to.',</p>
                                <p>Flight '.$airline_out.' #'.$flight_no_out.' departs at '.$decol_hr.':'.$decol_mt.' '.$decol_meridian.' flying to '.$airport_dept.',</p>
                                <p>For '.$passengerDetailsout.' / '.$no_people.' passengers,</p>
				<p>Your driver contact: '.$driv_details.'.</p>';
               
                $output_buffoutPass=$output_buffout;   
                $output_buffsmCont.='<p style="float:right;text-align:right;" align="right" >Price for transfer in&out service (IN): '.$qtyCont_client.'<strong>'.$clientprice.' €uros</strong></p>';   
                $reviewInvoice.=$output_buff;    
                $custInvoice.=$output_buffsmCont; 
                $travagtCommInvoice.=$output_buffsmCont;
                $suptransInvoice.=$output_buff; 
                $reviewInvoice.='<p style="float:right;text-align:right;" align="right">Price for transfer in&out service (IN): '.$qtyCont.'<strong>'.$price.' €uros</strong></p>';
                $output_buffout.='<p style="float:right;text-align:right;" align="right" >Price for transfer in&out service (OUT): '.$qtyCont.'<strong>'.$price.' €uros</strong></p>';
                    
                      $output_buff='</div>
                        </td>
                    </tr>
                    <tr><td><div class="separator"></div></td></tr>
                </tbody></table></td></tr>';
                 
                  $reviewInvoice.=$output_buff;    
                  $custInvoice.=$output_buff;                 
                  $suptransInvoice.=$output_buff; 
                  $transSup[$region]['transfer']['in'][]=$suptransInvoice;
                  $suptransInvoice='';
                  
                  
                  
                  $transOutArr[]=$output_buffout.$output_buff;
                  $transOutArrSup[]=$output_buffoutPass.$output_buff;
                  $transOutshtArr[]=$output_buffout.$output_buff;                  
                  
                  $transSup[$region]['transfer']['out'][]=$output_buffoutPass.$output_buff;
                 
                  
                }
                
            }
             elseif($service_type=='meet_greet'){
                if($type=='IN')
                {
                    $res_in=db_query("SELECT id, arrival_airport, arriv_dt, airline, flight_no, arriv_hr,
                    arriv_mt, arriv_meridian, driver_hostess_lang, comments, dest_addr from log_detailed_in_travel_Info 
                    WHERE checkout_id='".$checkout_id."' and ls_id='".$service_info_id."' and service_type='".$service_type."'")->fetchAssoc();
                    
                    $trav_id=$res_in['id'];
                    $arrival_airport=$res_in['arrival_airport'];
                    $arriv_dt=$res_in['arriv_dt'];
                    $airline=$res_in['airline'];
                    $flight_no=$res_in['flight_no'];
                    $arriv_hr=$res_in['arriv_hr'];
                    $arriv_mt=$res_in['arriv_mt'];
                    $arriv_meridian=$res_in['arriv_meridian'];
                    $driver_hostess_lang=$res_in['driver_hostess_lang'];
                    $comments=$res_in['comments'];
                    $dest_addr=$res_in['dest_addr'];
                    
                    $passengerDetailsin='';
                    $res_passenger=db_query("SELECT title, first_name, middle_name, last_name,	ph_no from login_trav_person_details 
                    WHERE trav_id='".$trav_id."'");
                    
                    foreach ($res_passenger as $rec_pass) {
                        if(trim($passengerDetailsin)!=''){$passengerDetailsin.=' and ';}
                        $passengerDetailsin.=$rec_pass->title;
                        $passengerDetailsin.='.'.$rec_pass->first_name;
                        $passengerDetailsin.=' '.$rec_pass->last_name;
                        $passengerDetailsin.=', Tel: '.$rec_pass->ph_no.'.';
                        if(trim($userInfo)!=''){$userInfo.=' and ';}
                        $userInfo.=ucfirst($rec_pass->first_name).' '.ucfirst($rec_pass->last_name);
                    }  
                   
                  
                   $date=$arriv_dt;  
                   $dtarr=explode('/',$date);
                   $date=$dtarr[2].'-'.$dtarr[1].'-'.$dtarr[0]; 
                   $date = strtotime($date);
                   $date = date("l", $date);
                   $date = strtolower($date);  
                   
                   $clientprice=0;
                    //Check for travel agent Login
                    if(isset($user->roles[5]))
                    {
                        //$agt_price=$price-(($price*$agt_comm)/100);
                        //$price=$agt_price;
                         $price=$agt_comm;
                         $clientprice=$price;
                    }
                    else{
                        $clientprice=$agt_comm;
                    }
                    
                    
                    
                    if(isset($arrival_time) && trim($arrival_time)=='2')
                    {   
                        $night_comm_price=($clientprice*$night_rate_percent)/100;
                        $clientprice=$clientprice+$night_comm_price;
                        $night_comm_price=($price*$night_rate_percent)/100;
                        $price=$price+$night_comm_price;
                    }
                    
                    $subtot_price+=$price;
                    $qtyCont='';
                    $qtyCont_client='';
                    if($comm_percent!='' && $comm_percent!='0')
                    {
                        $clientprice=$clientprice+(($comm_percent*$clientprice)/100);
                    }
                    if($qty>1)
                    {
                        $qtyCont=$qty.' (Qty)  * '.$price.' = ';                        
                        $qtyCont_client=$qty.' (Qty)  * '.$clientprice.' = ';
                        $price=$price* $qty;
                        $clientprice=$clientprice* $qty;
                    }
                    $tot_price+=$price; 
                    $totclt_price+=$clientprice;
                    $output_buffsmCont=$output_buff='<tr><td><table style="border-color: #014F7D;border-style:none;border-width: 0 1px;padding:10px;" bgcolor="#FFFFFF"  width="640" class="rowTable"  cellspacing="0" cellpadding="0" border="0" >
                    <tbody><tr>
                        <td >
                        <p align="left" class="article-title serviceInfo">Services for '._dt_day($arriv_dt).' '.$arriv_dt.'</p>
                            <p align="left" class="article-title">Meet & Greet In, at '.$arrival_airport.' in '.$region.'</p>
                            <div align="left" class="article-content">
                                <!--<p>Meet and Greet In at '.$arrival_airport.'</p>-->
                                <p>'.$arriv_hr.':'.$arriv_mt.strtolower($arriv_meridian).':  Meet your '.$driver_hostess_lang.'-speaking hostess on the jetway on the gate of your aircraft upon arrival at '.$arrival_airport.' in '.$region.',</p>
                                <p>Flight '.$airline.' '.$flight_no.' arrives at '.$arriv_hr.':'.$arriv_mt.$arriv_meridian.' coming from '.$arrival_airport.',</p>    
                                <p>For '.$passengerDetailsin.' / '.$no_people.' passengers,</p>
				<p>'.$no_regular_luggage.' regular piece(s) to be Handled,</p>
                                <p>'.$no_odd_luggage.' Odd piece(s) to be Handled,</p>
                                <p>Your Hostess contact at airport : '.$driv_details.',</p>';
                    $reviewInvoice.=$output_buff;    
                    $custInvoice.=$output_buffsmCont.'<p style="float:right;text-align:right;" align="right" >Price for this service: '.$qtyCont_client.'<strong>'.$clientprice.' €uros</strong></p>'; 
                    $travagtCommInvoice.=$output_buffsmCont;
                   
                    $supmeetInvoice.=$output_buff; 
                    $reviewInvoice.='<p style="float:right;text-align:right;" align="right" >Price for this service: '.$qtyCont.'<strong>'.$price.' €uros</strong></p>';
                    
                    $output_buff='</div>
                            </td>
                        </tr>
                        <tr><td><div class="separator"></div></td></tr>
                    </tbody></table></td></tr>';
                    $reviewInvoice.=$output_buff;    
                    $custInvoice.=$output_buff;  
                 
                    $supmeetInvoice.=$output_buff;
                    $transSup[$region]['meet_greet']['in'][]=$supmeetInvoice;
                    $supmeetInvoice='';
                    
                }
                elseif($type=='Out')
                {
                    $res_out=db_query("SELECT id, service_dt, airport_dept, airline, flight_no, decol_hr, decol_mt,
                    decol_meridian, pickup_hr, pickup_mt, pickup_meridian, pickup_addr, drop_addr, lang_driv_hostess, 
                    comments from log_detailed_out_travel_Info  WHERE checkout_id='".$checkout_id."' and 
                    ls_id='".$service_info_id."' and service_type='".$service_type."'")->fetchAssoc();
                    
                    $trav_id=$res_out['id'];                    
                    $service_dt=$res_out['service_dt'];
                    $airport_dept=$res_out['airport_dept'];
                    $airline=$res_out['airline'];
                    $flight_no=$res_out['flight_no'];
                    $decol_hr=$res_out['decol_hr'];
                    $decol_mt=$res_out['decol_mt'];
                    $decol_meridian=$res_out['decol_meridian'];
                    $pickup_hr=$res_out['pickup_hr'];
                    $pickup_mt=$res_out['pickup_mt'];
                    $pickup_meridian=$res_out['pickup_meridian'];
                    $decol_shed=$res_out['pickup_addr'];
                    $drop_addr=$res_out['drop_addr'];
                    $lang_driv_hostess=$res_out['lang_driv_hostess'];
                    $comments=$res_out['comments'];
                    
                    
                    $passengerDetails='';
                    $res_passenger=db_query("SELECT title, first_name, middle_name, last_name,	ph_no from logout_trav_person_details 
                    WHERE trav_id='".$trav_id."'");
                    
                    foreach ($res_passenger as $rec_pass) {
                        if(trim($passengerDetails)!=''){$passengerDetails.=' and ';}
                        $passengerDetails.=$rec_pass->title;
                        $passengerDetails.='.'.$rec_pass->first_name;
                        $passengerDetails.=' '.$rec_pass->last_name;
                        $passengerDetails.=', Tel: '.$rec_pass->ph_no.'.';
                        if(trim($userInfo)!=''){$userInfo.=' and ';}
                        $userInfo.=ucfirst($rec_pass->first_name).' '.ucfirst($rec_pass->last_name);
                    } 
                    
                  
                   $date=$service_dt;  
                   $dtarr=explode('/',$date);
                   $date=$dtarr[2].'-'.$dtarr[1].'-'.$dtarr[0]; 
                   $date = strtotime($date);
                   $date = date("l", $date);
                   $date = strtolower($date);  
                   
                   $clientprice=0;
                    //Check for travel agent Login
                    if(isset($user->roles[5]))
                    {
                        //$agt_price=$price-(($price*$agt_comm)/100);
                        //$price=$agt_price;
                         $price=$agt_comm;
                         $clientprice=$price;
                    }
                    else{
                        $clientprice=$agt_comm;
                    }  
                    
                    if(isset($arrival_time) && trim($arrival_time)=='2')
                    {   
                        $night_comm_price=($clientprice*$night_rate_percent)/100;
                        $clientprice=$clientprice+$night_comm_price;
                        $night_comm_price=($price*$night_rate_percent)/100;
                        $price=$price+$night_comm_price;
                    }
                    $subtot_price+=$price;
                    $qtyCont='';
                    $qtyCont_client='';
                    if($comm_percent!='' && $comm_percent!='0')
                    {
                        $clientprice=$clientprice+(($comm_percent*$clientprice)/100);
                    }
                    if($qty>1)
                    {
                        $qtyCont=$qty.' (Qty)  * '.$price.' = ';                        
                        $qtyCont_client=$qty.' (Qty)  * '.$clientprice.' = ';
                        $price=$price* $qty;
                        $clientprice=$clientprice* $qty;
                    }
                    $tot_price+=$price; 
                    $totclt_price+=$clientprice;
                    $output_buffsmCont=$output_buffpass='<tr><td><table style="border-color: #014F7D;border-style:none;border-width: 0 1px;padding:10px;" bgcolor="#FFFFFF"  width="640" class="rowTable"  cellspacing="0" cellpadding="0" border="0" >
                    <tbody><tr>
                        <td>
                            <p align="left" class="article-title serviceInfo">Services for '._dt_day($service_dt).' '.$service_dt.' </p>
                            <p align="left" class="article-title">Meet & Greet Out, at '.$airport_dept.' in '.$region.'</p>   
                            <div align="left" class="article-content">
                                <p>Flight '.$airline.' #'.$flight_no.' departs at '.$decol_hr.':'.$decol_mt.strtolower($decol_meridian).', flying to '.$airport_dept.' in '.$region.',</p>
                                <p>Meet your '.$lang_driv_hostess.'-speaking of the hostess upon arrival at '.$airline.' at '.$pickup_hr.':'.$pickup_mt.strtolower($pickup_meridian).',</p>
                                <p>Estimated arrival time at the airport: '.$pickup_hr.':'.$pickup_mt.strtolower($pickup_meridian).',</p>    
                                <p>For '.$passengerDetails.' / '.$no_people.' passengers,</p>
				<p>'.$no_regular_luggage.' regular piece(s) to be Handled,</p>
                                <p>'.$no_odd_luggage.' Odd piece(s) to be Handled,</p>
                                <p>Your Hostess contact at airport : '.$driv_details.',</p>';                    
                    $output_buffout='<p style="float:right;text-align:right;" align="right" >Price for this service: '.$qtyCont.'<strong>'.$price.' €uros</strong></p>';
                    $output_buff='</div>
                            </td>
                        </tr>
                        <tr><td><div class="separator"></div></td></tr>
                    </tbody></table></td></tr>';                   
                    $output_buffsmCont.='<p style="float:right;text-align:right;" align="right" >Price for this service: '.$qtyCont_client.'<strong>'.$clientprice.' €uros</strong></p>';
                    $meetOutArr[]=$output_buffpass.$output_buffout.$output_buff;
                    $meetOutArrSup[]=$output_buffpass.$output_buff;
                    $meetOutshtArr[]=$output_buffsmCont.$output_buff;
                
                    $transSup[$region]['meet_greet']['out'][]=$output_buffpass.$output_buff;
                    
                }
                 elseif($type=='Commute')
                {
                     $res_in=db_query("SELECT id, arrival_airport, arriv_dt, airline, flight_no, arriv_hr,
                    arriv_mt, arriv_meridian, driver_hostess_lang, comments, dest_addr from log_detailed_in_travel_Info 
                    WHERE checkout_id='".$checkout_id."' and ls_id='".$service_info_id."' and service_type='".$service_type."'")->fetchAssoc();
                    //$agt_comm=$agt_comm*2;
                    $trav_id=$res_in['id'];
                    $arrival_airport=$res_in['arrival_airport'];
                    $arriv_dt=$res_in['arriv_dt'];
                    $airline=$res_in['airline'];
                    $flight_no=$res_in['flight_no'];
                    $arriv_hr=$res_in['arriv_hr'];
                    $arriv_mt=$res_in['arriv_mt'];
                    $arriv_meridian=$res_in['arriv_meridian'];
                    $driver_hostess_lang=$res_in['driver_hostess_lang'];
                    $comments=$res_in['comments'];
                    $dest_addr=$res_in['dest_addr'];
                    
                    $passengerDetailsin='';
                    $res_passenger=db_query("SELECT title, first_name, middle_name, last_name,	ph_no from login_trav_person_details 
                    WHERE trav_id='".$trav_id."'");
                    
                    foreach ($res_passenger as $rec_pass) {
                        if(trim($passengerDetailsin)!=''){$passengerDetailsin.=' and ';}
                        $passengerDetailsin.=$rec_pass->title;
                        $passengerDetailsin.='.'.$rec_pass->first_name;
                        $passengerDetailsin.=' '.$rec_pass->last_name;
                        $passengerDetailsin.=', Tel: '.$rec_pass->ph_no.'.';
                        if(trim($userInfo)!=''){$userInfo.=' and ';}
                        $userInfo.=ucfirst($rec_pass->first_name).' '.ucfirst($rec_pass->last_name);
                    }                    
                     
                     
                     
                    $res_out=db_query("SELECT id, service_dt,airport_dept, airline, flight_no, decol_hr, decol_mt,
                    decol_meridian, pickup_hr, pickup_mt, pickup_meridian, pickup_addr, drop_addr, lang_driv_hostess, 
                    comments from log_detailed_out_travel_Info  WHERE checkout_id='".$checkout_id."' and 
                    ls_id='".$service_info_id."' and service_type='".$service_type."'")->fetchAssoc();
                    
                    $service_dt=$res_out['service_dt'];
                    $airport_dept=$res_out['airport_dept'];
                    $airline_out=$res_out['airline'];
                    $flight_no_out=$res_out['flight_no'];
                    $decol_hr=$res_out['decol_hr'];
                    $decol_mt=$res_out['decol_mt'];
                    $decol_meridian=$res_out['decol_meridian'];
                    $pickup_hr=$res_out['pickup_hr'];
                    $pickup_mt=$res_out['pickup_mt'];
                    $pickup_meridian=$res_out['pickup_meridian'];
                    $decol_shed=$res_out['pickup_addr'];
                    $drop_addr=$res_out['drop_addr'];
                    $lang_driv_hostess=$res_out['lang_driv_hostess'];
                    $comments=$res_out['comments'];
                    
                    $passengerDetails='';
                    $res_passenger=db_query("SELECT title, first_name, middle_name, last_name,	ph_no from logout_trav_person_details 
                    WHERE trav_id='".$trav_id."'");
                    
                    foreach ($res_passenger as $rec_pass) {
                        if(trim($passengerDetails)!=''){$passengerDetails.=' and ';}
                        $passengerDetails.=$rec_pass->title;
                        $passengerDetails.='.'.$rec_pass->first_name;
                        $passengerDetails.=' '.$rec_pass->last_name;
                        $passengerDetails.=', Tel: '.$rec_pass->ph_no.'.';
                        if(trim($userInfo)!=''){$userInfo.=' and ';}
                        $userInfo.=ucfirst($rec_pass->first_name).' '.ucfirst($rec_pass->last_name);
                    } 
                    
                  
                   $date=$service_dt;  
                   $dtarr=explode('/',$date);
                   $date=$dtarr[2].'-'.$dtarr[1].'-'.$dtarr[0]; 
                   $date = strtotime($date);
                   $date = date("l", $date);
                   $date = strtolower($date);  
                   
                    $clientprice=0;
                    //Check for travel agent Login
                    if(isset($user->roles[5]))
                    {
                        //$agt_price=$price-(($price*$agt_comm)/100);
                        //$price=$agt_price;
                         $price=$agt_comm; 
                         $clientprice=$price;
                    }else{
                        $clientprice=$agt_comm;
                    }  
                    
                    $night_comm_price=0;
                    $night_comm_price_clt=0;
                    $night_comm_price_clt=(($clientprice/2)*$night_rate_percent)/100;
                    $night_comm_price=(($price/2)*$night_rate_percent)/100;
                    if(isset($arrival_time) && trim($arrival_time)=='2')
                    {                  
                        $clientprice=$clientprice+$night_comm_price_clt;
                        $price=$price+$night_comm_price;
                    }

                    //Check for nightservice applied in out service for IN&OUT or COMMUTE
                    if(trim($decol_hr)!='' && trim($decol_meridian)!='') {
                        if(chknightService($decol_hr, $decol_meridian))
                        {
                            $clientprice=$clientprice+$night_comm_price_clt;
                            $price=$price+$night_comm_price;
                        }
                    }
                    
                    $subtot_price+=$price;
                    $qtyCont='';
                    $qtyCont_client='';
                    if($comm_percent!='' && $comm_percent!='0')
                    {
                        $clientprice=$clientprice+(($comm_percent*$clientprice)/100);
                    }
                    if($qty>1)
                    {
                        $qtyCont=$qty.' (Qty)  * '.$price.' = ';                        
                        $qtyCont_client=$qty.' (Qty)  * '.$clientprice.' = ';
                        $price=$price* $qty;
                        $clientprice=$clientprice* $qty;
                    }
                    $tot_price+=$price;
                    $totclt_price+=$clientprice;
                    $output_buffsmCont=$output_buff='<tr><td><table style="border-color: #014F7D;border-style:none;border-width: 0 1px;padding:10px;" bgcolor="#FFFFFF"  width="640" class="rowTable"  cellspacing="0" cellpadding="0" border="0" >
                    <tbody><tr>
                        <td>
                            <p align="left" class="article-title serviceInfo">Services for '._dt_day($arriv_dt).' '.$arriv_dt.'</p>
                             <p align="left" class="article-title">Meet & Greet In, at '.$arrival_airport.' in '.$region.'</p>
                             <div align="left" class="article-content">
                                <!--<p>Meet & Greet In at '.$arrival_airport.'</p>-->
                                <p>'.$arriv_hr.':'.$arriv_mt.strtolower($arriv_meridian).':  Meet your '.$lang_driv_hostess.'-speaking  hostess on the jetway on the gate of your aircraft upon arrival at '.$arrival_airport.' in '.$region.'</p>
                                <p>Flight '.$airline.' #'.$flight_no.' arrives at: '.$arriv_hr.':'.$arriv_mt.' '.$arriv_meridian.' coming from '.$arrival_airport.',</p>
                                <p>For '.$passengerDetailsin.' / '.$no_people.' passengers,</p>
				<p>'.$no_regular_luggage.' regular piece(s) to be Handled,</p>
                                <p>'.$no_odd_luggage.' Odd piece(s) to be Handled,</p>
                                <p>Your Hostess contact at airport : '.$driv_details.'.</p> ';   
                   $output_buffout='<tr><td><table style="border-color: #014F7D;border-style:none;border-width: 0 1px;padding:10px;" bgcolor="#FFFFFF"  width="640" class="rowTable"  cellspacing="0" cellpadding="0" border="0" >
                    <tbody><tr>
                        <td>                           
                            <p align="left" class="article-title serviceInfo">Services for '._dt_day($service_dt).' '.$service_dt.' </p>
                            <p align="left" class="article-title">Meet & Greet Out, at '.$airport_dept.' in '.$region.'</p>
                            <div align="left" class="article-content">
                                <p>Flight '.$airline_out.' '.$flight_no_out.' departs at '.$decol_hr.':'.$decol_mt.strtolower($decol_meridian).', flying to '.$airport_dept.' in '.$region.',</p>
                                <p>Meet your '.$lang_driv_hostess.'-speaking of the hostess upon arrival at '.$airline_out.' at '.$decol_hr.':'.$decol_mt.strtolower($decol_meridian).',</p>
                                <p>Estimated arrival time at the airport: '.$pickup_hr.':'.$pickup_mt.strtolower($pickup_meridian).',</p>
                                <p>For '.$passengerDetails.' / '.$no_people.' passengers,</p>
				<p>'.$no_regular_luggage.' regular piece(s) to be Handled,</p>
                                <p>'.$no_odd_luggage.' Odd piece(s) to be Handled,</p>
                                <p>Your Hostess contact at airport : '.$driv_details.',</p>';
                    $output_buffoutPass=$output_buffout;
                    $reviewInvoice.=$output_buff;
                    $output_buffsmCont.='<p style="float:right;text-align:right;" align="right" >Price for meet&greet in&out service (IN): '.$qtyCont_client.'<strong>'.$clientprice.' €uros</strong></p>';
                    $custInvoice.=$output_buffsmCont; 
                   
                    $travagtCommInvoice.=$output_buffsmCont;                   
                    $supmeetInvoice.=$output_buff;
                    $transSup[$region]['meet_greet']['in'][]=$supmeetInvoice;
                    $supmeetInvoice='';
                    
                    
                    $reviewInvoice.='<p style="float:right;text-align:right;" align="right" >Price for meet&greet in&out service (IN): '.$qtyCont.'<strong>'.$price.' €uros</strong></p>';
                    $output_buffout.='<p style="float:right;text-align:right;" align="right" >Price for meet&greet in&out service (OUT): '.$qtyCont.'<strong>'.$price.' €uros</strong></p>';                    
                    $output_buff='</div>
                            </td>
                        </tr>
                        <tr><td><div class="separator"></div></td></tr>
                    </tbody></table></td></tr>';
                    $reviewInvoice.=$output_buff;    
                    $custInvoice.=$output_buff;
                    $travagtCommInvoice.=$output_buff;
                    $supmeetInvoice.=$output_buff; 
                    $meetOutArr[]=$output_buffout.$output_buff;
                    $meetOutArrSup[]=$output_buffoutPass.$output_buff;
                    $meetOutshtArr[]=$output_buffout.$output_buff;
                    
                    $transSup[$region]['meet_greet']['out'][]=$output_buffoutPass.$output_buff;
                }
                
                
                
                
            }
     
        }
        
        foreach($transOutArr as $key => $value)
            {
                $reviewInvoice.=$value;
            }
            /*foreach($transOutArrSup as $key => $value)
            {  
                $suptransInvoice.=$value;
            }*/
            foreach($transOutshtArr as $key => $value)
            {
                $custInvoice.=$value;
                $travagtCommInvoice.=$value;
            }
            
            foreach($meetOutArr as $key => $value)
            {
                $reviewInvoice.=$value;
            }
            /*foreach($meetOutArrSup as $key => $value)
            {  
                $supmeetInvoice.=$value;
            }*/
            foreach($meetOutshtArr as $key => $value)
            {
                $custInvoice.=$value;
                $travagtCommInvoice.=$value;
            }
       
   
        if(isset($user->roles[5]))
        {   
            $tot_price=$subtot_price;
            $extracommsion='';
            if($comm_percent!='')
            {
                $extracommsion=(($comm_percent*$tot_price)/100);
                $tot_price=$tot_price+(($comm_percent*$tot_price)/100);
            }
            
            
            

            $reviewInvoice.='<tr><td><table style="border-color: #014F7D;border-style:none;border-width: 0 1px;padding:10px;" bgcolor="#FFFFFF"  width="640" class="rowTable"  cellspacing="0" cellpadding="0" border="0">
                        <tbody><tr style="border-top: none;">
                            <td >
                                <div align="left" class="article-content">
                                    <p style="float:right;text-align: right;font-size:14px;font-weight:bold;">
                                       Net price:'.$subtot_price.' €<br/>';
                                        if($extracommsion!='')
                                        {
                                            $reviewInvoice.='<span>Commission: '.$comm_percent.'</span> %<br/>';
                                            $reviewInvoice.='<span>Commission: '.$extracommsion.'</span> €<br/>';
                                        }
                                        $reviewInvoice.='<p class="blueTagR bdFont" style="color: #2283BC;font-size:16px;">Total price including your Commission: <span id="total_amt_comm_agt">'.$tot_price.'</span> €uros</p>
                                        
                                    </p>
                                </div>
                            </td>
                        </tr>
                        <tr><td width="580" height="10" class="w580"></td></tr>
                    </tbody></table></td></tr>';

          $custInvoice.='<tr><td align="center"><table style="border-color: #014F7D;border-style:none;border-width: 0 1px;padding:10px;" bgcolor="#FFFFFF"  width="640" class="rowTable"  cellspacing="0" cellpadding="0" border="0">
                        <tbody><tr style="border-top: none;">
                            <td >
                                <div align="left"  class="article-content">
                                    <p id="netCont" style="float:right;text-align: right;">
                                        <strong class="blueTagR">Total Price for the above services: '.$tot_price.' €uros
                                        </strong>

                                    </p>
                                </div>
                            </td>
                        </tr>
                        <tr><td width="580" height="10" class="w580"></td></tr>
                    </tbody></table></td></tr>'; 
           $travagtCommInvoice.='<tr><td><table style="border-color: #014F7D;border-style:none;border-width: 0 1px;padding:10px;" bgcolor="#FFFFFF"  width="640" class="rowTable"  cellspacing="0" cellpadding="0" border="0">
                        <tbody><tr style="border-top: none;">
                            <td >
                                <div align="left" class="article-content">
                                    <p style="float:right;text-align: right;">
                                        Net price:'.$subtot_price.' €uros<br/>';
            $travagtCommInvoice.='<span class="blueTag" >Total price including your Commission:'.$tot_price.' €uros</span><br/>';
                                        if($extracommsion!='')
                                        {
                                            $travagtCommInvoice.='<span style="clear:both;">Commission : '.$comm_percent.' %</span><br/>';
                                            $travagtCommInvoice.='<span id="commDue">Commission due : '.$extracommsion.' €uros</span><br/>';
                                        }
                                        $travagtCommInvoice.='
                                    </p>
                                </div>
                            </td>
                        </tr>
                        <tr><td width="580" height="10" class="w580"></td></tr>
                    </tbody></table></td></tr>';
                                    
    }
    else
    {
        
        $custInvoice.='<tr><td><table style="border-color: #014F7D;border-style:none solid solid;border-width: 0px;padding:10px;"  bgcolor="#FFFFFF"  width="640" class="rowTable"  cellspacing="0" cellpadding="0" border="0">
                <tbody><tr style="border-top: none;">
                    <td >
                        <div align="left"  class="article-content">
                            <p id="netCont" style="float:right;text-align: right;">
                                <strong>Total Price for the above services:'.$totclt_price.' €uros
                                </strong>
                            </p>
                        </div>
                        <input type="hidden" name="tot_price" id="tot_price" value="'.$totclt_price.'" />
                    </td>
                </tr>
                <tr><td width="580" height="10" class="w580"></td></tr>
            </tbody></table></td></tr>';

    }
  
  
   //$output_travagtCommInvoice.=$travagtCommInvoice."</table></td></tr></tbody></table></div>";
   //$output_suptransInvoice.=$suptransInvoice."</table></td></tr></tbody></table></div>";
   //$output_supmeetInvoice.=$supmeetInvoice."</table></td></tr></tbody></table></div>";
    
   $output_reviewCart='<table class="w640" cellspacing="0" cellpadding="0" width="640" border="0" style="background:#FFFFFF;border: 1px solid #014F7D;" >'.$reviewInvoice.'</table>';
   $output_custInvoice='<table class="w640" cellspacing="0" cellpadding="0" width="640" border="0" style="background:#FFFFFF;border: 1px solid #014F7D;" >'.$custInvoice.'</table>';
   
   
  // $htmlContAgt=$html_cont_Header.$output_reviewCart.$html_cont_footer;
  // $htmlContClt=$html_cont_Header.$output_custInvoice.$html_cont_footer;
  
   $contentAgtArr[]=$output_reviewCart;
   $contentCltArr[]=$output_custInvoice;
   
   $cltfname='PTX_CLT_'.time();
   $agtfname='PTX_AGT_'.time();  
   
   
    //echo "<pre>";
    //print_r($transSup);
        
       foreach ($transSup as $region => $v) {
           // echo $region."\n\n";
            $suptransfname='PTX_SUP_TRANS_'.time();
            $supmeetfname='PTX_SUP_MEET_'.time();
            
            
             if(isset($v['meet_greet']) && count($v['meet_greet'])>0)
             {
                 //print_r($v['meet_greet']);
                  for($inc=0,$cnt=count($v['meet_greet']['in']);$inc<$cnt;$inc++)
                  {
                    $supmeetInvoice.=$v['meet_greet']['in'][$inc];
                  }
                  for($inc=0,$cnt=count($v['meet_greet']['out']);$inc<$cnt;$inc++)
                  {
                    $supmeetInvoice.=$v['meet_greet']['out'][$inc];
                  }
                  
                  $output_supmeetInvoice='<table class="w640" cellspacing="0" cellpadding="0" width="640" border="0" style="background:#FFFFFF;border: 1px solid #014F7D;" >'.$supmeetInvoice.'</table>';
                  //echo $htmlSupMeet=$html_cont_Header.$output_supmeetInvoice.$html_cont_footer;
                  $contentSUPMEETArr[]=$output_supmeetInvoice;
                  
                  //Sending mail for supplier Meet & Greet
                  _generatePdf($supmeetfname,$contentSUPMEETArr,$base_url);
                  db_insert('log_detailed_checkout_report')
                        ->fields(array(
                          'checkout_id' => $checkout_id,
                          'file' => $supmeetfname,
                          'report_type' => 'SUP',
                          'created' => REQUEST_TIME, 
                        ))->execute();
                  
                  $result=db_query("SELECT su_e.field_suppliers_email_email FROM `node` as n left join  `field_data_field_supplier_info` as su on n.nid=su.entity_id 
left join field_data_field_suppliers_email su_e on su.field_supplier_info_value=su_e.entity_id 
left join  field_data_field_service_type su_serv on su.field_supplier_info_value=su_serv.entity_id 
WHERE n.`type`='Suppliers' and n.`title`='".$region."' and su_serv.field_service_type_value='Meet & Greet'");
                foreach ($result as $record) { 
                    $suppliers_email=$record->field_suppliers_email_email;
                    if(trim($suppliers_email)!='')
                    { 
                        //Sending email for Supplier            
                       $body=$html_cont_Header.$output_supmeetInvoice.$html_cont_footer;

                       $fileatt = dirname(__FILE__).'/sites/default/files/pdf/'.$supmeetfname.'.pdf'; // Path to the file
                       $fileatt_type = "application/pdf"; // File Type
                       $fileatt_name = $supmeetfname.".pdf"; // Filename that will be used for the file as the attachment
                       $email_from = 'saravanan@anubavam.com'; // Who the email is from
                       $email_subject =  'Private Transfer Supplier Invoice. Reference invoice Id-'.$checkout_id; // The Subject of the email
                       $email_message = $body;
                       $email_to = $suppliers_email; // Who the email is to
                       $headers = "From: ".$email_from;
                       $file = fopen($fileatt,'rb');
                       $data = fread($file,filesize($fileatt));
                       fclose($file);
                       $semi_rand = md5(time());
                       $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
                       $headers .= "\nMIME-Version: 1.0\n" .
                       "Content-Type: multipart/mixed;\n" .
                       " boundary=\"{$mime_boundary}\"";
                       $email_message .= "This is a multi-part message in MIME format.\n\n" .
                       "--{$mime_boundary}\n" .
                       "Content-Type:text/html; charset=\"iso-8859-1\"\n" .
                       "Content-Transfer-Encoding: 7bit\n\n" .
                       $email_message .= "\n\n";
                       $data = chunk_split(base64_encode($data));
                       $email_message .= "--{$mime_boundary}\n" .
                       "Content-Type: {$fileatt_type};\n" .
                       " name=\"{$fileatt_name}\"\n" .        
                       "Content-Transfer-Encoding: base64\n\n" .
                       $data .= "\n\n" .
                       "--{$mime_boundary}--\n";
                       $sent = @mail($email_to, $email_subject, $email_message, $headers);
                       if($sent) {
                       echo "mail sent";
                       } else {
                       echo "mail failed"; 
                       }  
                    }
                }
                  
             }
             if(isset($v['transfer'])  && count($v['transfer'])>0)
             {
                  //print_r($v['transfer']);
                  for($inc=0,$cnt=count($v['transfer']['in']);$inc<$cnt;$inc++)
                  {
                    $suptransInvoice.=$v['transfer']['in'][$inc];
                  }
                  for($inc=0,$cnt=count($v['transfer']['out']);$inc<$cnt;$inc++)
                  {
                    $suptransInvoice.=$v['transfer']['out'][$inc];
                  }
                  
                  
                  $output_suptransInvoice='<div id="payCont">
        <a class="print-preview fRight btn">Print</a>
        <table width="640" cellspacing="0" cellpadding="0" border="0" >
        <tbody>
        <tr>
            <td><p><div class="invTitle">Passengers Travel Document for Suppliers </div><br/>Our reference:  ('.$paybax_trans_id.')<br/>
    Clients Name: '.$userInfo.'<br/>
    Agent: '.$agentUserName.'. / '.$agentName.'<br/>
    Agency: '.$agencyName.'<br/><br/>
    Dear [PassengerInfo],<br/>
    It is my pleasure on behalf of Découvertes to wish you a safe and enjoyable journey in France.  I hope that you are looking forward to your visit here!<br/><br/>
    Should you need to contact Découvertes for whatever reason during your stay, below are our Office Hours and contact information.<br/><br/>
    Office Hours: Monday to Friday 9.30am – 7.00pm<br/>
    Office Direct Line: +33 (0)4 4250 3564<br/>
    Découvertes’ 24/7 contact number: +33(0)6 1406 1967<br/><br/>
    It has been a pleasure for us to help you  organize your stay in France.  Should you wish to add anything or have any questions concerning your itinerary, please do not hesitate to contact us and we will do our utmost to accommodate you.<br/><br/>
    Have a wonderful stay in France!<br/><br/>
    Very best regards,<br/>
    Découvertes\' team. </p></td>
        </tr>
        <tr>
            <td id="content-column" ><table>';
                    
                $output_suptransInvoice='<table class="w640" cellspacing="0" cellpadding="0" width="640" border="0" style="background:#FFFFFF;border: 1px solid #014F7D;" >'.$suptransInvoice.'</table>';
                //echo $htmlSupTrans=$html_cont_Header.$output_suptransInvoice.$html_cont_footer;
                $contentSUPTRANSArr[]=$output_suptransInvoice;
                //Sending mail for supplier  Transfers and Driver at disposals
                _generatePdf($suptransfname,$contentSUPTRANSArr,$base_url);
                 db_insert('log_detailed_checkout_report')
                        ->fields(array(
                          'checkout_id' => $checkout_id,
                          'file' => $suptransfname,
                          'report_type' => 'SUP', 
                          'created' => REQUEST_TIME, 
                        ))->execute();
                 $result=db_query("SELECT su_e.field_suppliers_email_email FROM `node` as n left join  `field_data_field_supplier_info` as su on n.nid=su.entity_id 
left join field_data_field_suppliers_email su_e on su.field_supplier_info_value=su_e.entity_id 
left join  field_data_field_service_type su_serv on su.field_supplier_info_value=su_serv.entity_id 
WHERE n.`type`='Suppliers' and n.`title`='".$region."' and su_serv.field_service_type_value='Transfer & Driver at Disposal'");
                foreach ($result as $record) { 
                    $suppliers_email=$record->field_suppliers_email_email;
                    if(trim($suppliers_email)!='')
                    { 
                        //Sending email for Supplier            
                        $body=$html_cont_Header.$output_suptransInvoice.$html_cont_footer;

                        $fileatt = dirname(__FILE__).'/sites/default/files/pdf/'.$suptransfname.'.pdf'; // Path to the file
                        $fileatt_type = "application/pdf"; // File Type
                        $fileatt_name = $suptransfname.".pdf"; // Filename that will be used for the file as the attachment
                        $email_from = 'saravanan@anubavam.com'; // Who the email is from
                        $email_subject =  'Private Transfer Supplier Invoice. Reference invoice Id-'.$checkout_id; // The Subject of the email
                        $email_message = $body;
                        $email_to = $suppliers_email; // Who the email is to
                        $headers = "From: ".$email_from;
                        $file = fopen($fileatt,'rb');
                        $data = fread($file,filesize($fileatt));
                        fclose($file);
                        $semi_rand = md5(time());
                        $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
                        $headers .= "\nMIME-Version: 1.0\n" .
                        "Content-Type: multipart/mixed;\n" .
                        " boundary=\"{$mime_boundary}\"";
                        $email_message .= "This is a multi-part message in MIME format.\n\n" .
                        "--{$mime_boundary}\n" .
                        "Content-Type:text/html; charset=\"iso-8859-1\"\n" .
                        "Content-Transfer-Encoding: 7bit\n\n" .
                        $email_message .= "\n\n";
                        $data = chunk_split(base64_encode($data));
                        $email_message .= "--{$mime_boundary}\n" .
                        "Content-Type: {$fileatt_type};\n" .
                        " name=\"{$fileatt_name}\"\n" .        
                        "Content-Transfer-Encoding: base64\n\n" .
                        $data .= "\n\n" .
                        "--{$mime_boundary}--\n";
                        $sent = @mail($email_to, $email_subject, $email_message, $headers);
                        if($sent) {
                        echo "mail sent";
                        } else {
                        echo "mail failed"; 
                        }
                    }

                 }
             }
              
       
             
       }
       
    
   
   
   
   
    //Check for travel agent Login
    if(isset($user->roles[5]))
    {
       _generatePdf($agtfname,$contentAgtArr,$base_url);
       _generatePdf($cltfname,$contentCltArr,$base_url); 
        db_insert('log_detailed_checkout_report')
                        ->fields(array(
                          'checkout_id' => $checkout_id,
                          'file' => $agtfname,
                          'report_type' => 'AGT', 
                          'created' => REQUEST_TIME, 
                        ))->execute();
        db_insert('log_detailed_checkout_report')
                       ->fields(array(
                         'checkout_id' => $checkout_id,
                         'file' => $cltfname,
                         'report_type' => 'CLT', 
                         'created' => REQUEST_TIME, 
                       ))->execute();
       
       //Sending email for agent
        $body = $html_cont_Header.$output_reviewCart.$html_cont_footer;
        $subject = t('Private Transfer Agent Invoice. Reference invoice Id-'.$checkout_id);
        $my_module = 'regionselector';//og_add_users_ng
        $my_mail_token = 'send_invoice';//feedback_review_approval
        $from = 'saravanan@anubavam.com';
        $to='mahalingam@anubavam.com';//$user->mail
     
        //Sending Email to
        $mailto ='mahalingam@anubavam.com';  //gift to a friend
        $mailfrom ='mahalingam@anubavam.com';
        $subject = "another message for  HTML email from privatetransfer.com";
        $params['subject']=$subject;
        $params['body']=$html_cont_Header.$output_reviewCart.$html_cont_footer;
        $body=$html_cont_Header.$output.$html_cont_footer;
        
        
        $fileatt = dirname(__FILE__).'/sites/default/files/pdf/'.$agtfname.'.pdf'; // Path to the file
        $fileatt_type = "application/pdf"; // File Type
        $fileatt_name = $agtfname.".pdf"; // Filename that will be used for the file as the attachment
        $email_from = 'saravanan@anubavam.com'; // Who the email is from
        $email_subject = 'Private Transfer Agent Invoice. Reference invoice Id-'.$checkout_id; // The Subject of the email
        $email_message = $body;
        $email_to = 'mahalingam@anubavam.com'; // Who the email is to
        $headers = "From: ".$email_from;
        $file = fopen($fileatt,'rb');
        $data = fread($file,filesize($fileatt));
        fclose($file);
        $semi_rand = md5(time());
        $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
        $headers .= "\nMIME-Version: 1.0\n" .
        "Content-Type: multipart/mixed;\n" .
        " boundary=\"{$mime_boundary}\"";
        $email_message .= "This is a multi-part message in MIME format.\n\n" .
        "--{$mime_boundary}\n" .
        "Content-Type:text/html; charset=\"iso-8859-1\"\n" .
        "Content-Transfer-Encoding: 7bit\n\n" .
        $email_message .= "\n\n";
        $data = chunk_split(base64_encode($data));
        $email_message .= "--{$mime_boundary}\n" .
        "Content-Type: {$fileatt_type};\n" .
        " name=\"{$fileatt_name}\"\n" .        
        "Content-Transfer-Encoding: base64\n\n" .
        $data .= "\n\n" .
        "--{$mime_boundary}--\n";
        $sent = @mail($email_to, $email_subject, $email_message, $headers);
        if($sent) {
        echo "mail sent";
        } else {
        echo "mail failed"; 
        }
        
        
        
       
       if($client_email!='')
        {
            //Sending email for Customer            
            $body=$html_cont_Header.$output_custInvoice.$html_cont_footer;
             
            $fileatt = dirname(__FILE__).'/sites/default/files/pdf/'.$cltfname.'.pdf'; // Path to the file
            $fileatt_type = "application/pdf"; // File Type
            $fileatt_name = $cltfname.".pdf"; // Filename that will be used for the file as the attachment
            $email_from = 'saravanan@anubavam.com'; // Who the email is from
            $email_subject =  'Private Transfer Customer Invoice. Reference invoice Id-'.$checkout_id; // The Subject of the email
            $email_message = $body;
            $email_to = 'mahalingam@anubavam.com'; // Who the email is to
            $headers = "From: ".$email_from;
            $file = fopen($fileatt,'rb');
            $data = fread($file,filesize($fileatt));
            fclose($file);
            $semi_rand = md5(time());
            $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
            $headers .= "\nMIME-Version: 1.0\n" .
            "Content-Type: multipart/mixed;\n" .
            " boundary=\"{$mime_boundary}\"";
            $email_message .= "This is a multi-part message in MIME format.\n\n" .
            "--{$mime_boundary}\n" .
            "Content-Type:text/html; charset=\"iso-8859-1\"\n" .
            "Content-Transfer-Encoding: 7bit\n\n" .
            $email_message .= "\n\n";
            $data = chunk_split(base64_encode($data));
            $email_message .= "--{$mime_boundary}\n" .
            "Content-Type: {$fileatt_type};\n" .
            " name=\"{$fileatt_name}\"\n" .        
            "Content-Transfer-Encoding: base64\n\n" .
            $data .= "\n\n" .
            "--{$mime_boundary}--\n";
            $sent = @mail($email_to, $email_subject, $email_message, $headers);
            if($sent) {
            echo "mail sent";
            } else {
            echo "mail failed"; 
            }
             
        }
       
       
    }  
    else
    {   
        _generatePdf($cltfname,$contentCltArr,$base_url); 
        db_insert('log_detailed_checkout_report')
                        ->fields(array(
                          'checkout_id' => $checkout_id,
                          'file' => $cltfname,
                          'report_type' => 'CLT',  
                          'created' => REQUEST_TIME, 
                        ))->execute();
        
        //Sending email for Customer            
        $body=$html_cont_Header.$output_custInvoice.$html_cont_footer;
             
        $fileatt = dirname(__FILE__).'/sites/default/files/pdf/'.$cltfname.'.pdf'; // Path to the file
        $fileatt_type = "application/pdf"; // File Type
        $fileatt_name = $cltfname.".pdf"; // Filename that will be used for the file as the attachment
        $email_from = 'saravanan@anubavam.com'; // Who the email is from
        $email_subject =  'Private Transfer Customer Invoice. Reference invoice Id-'.$checkout_id; // The Subject of the email
        $email_message = $body;
        $email_to = 'mahalingam@anubavam.com'; // Who the email is to
        $headers = "From: ".$email_from;
        $file = fopen($fileatt,'rb');
        $data = fread($file,filesize($fileatt));
        fclose($file);
        $semi_rand = md5(time());
        $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
        $headers .= "\nMIME-Version: 1.0\n" .
        "Content-Type: multipart/mixed;\n" .
        " boundary=\"{$mime_boundary}\"";
        $email_message .= "This is a multi-part message in MIME format.\n\n" .
        "--{$mime_boundary}\n" .
        "Content-Type:text/html; charset=\"iso-8859-1\"\n" .
        "Content-Transfer-Encoding: 7bit\n\n" .
        $email_message .= "\n\n";
        $data = chunk_split(base64_encode($data));
        $email_message .= "--{$mime_boundary}\n" .
        "Content-Type: {$fileatt_type};\n" .
        " name=\"{$fileatt_name}\"\n" .        
        "Content-Transfer-Encoding: base64\n\n" .
        $data .= "\n\n" .
        "--{$mime_boundary}--\n";
        $sent = @mail($email_to, $email_subject, $email_message, $headers);
        if($sent) {
        echo "mail sent";
        } else {
        echo "mail failed"; 
        }
        
        
    }
    
    
    
    
       
            
   echo "<center><a href='".$base_url.'/sites/default/files/pdf/'.$suptransfname.".pdf' >Click to Download for supplier trans<a><center><br/><br/><br/>";     
   echo "<center><a href='".$base_url.'/sites/default/files/pdf/'.$supmeetfname.".pdf' >Click to Download for supplier meet<a><center><br/><br/><br/>";
   echo "<center><a href='".$base_url.'/sites/default/files/pdf/'.$agtfname.".pdf' >Click to Download agent<a><center><br/><br/><br/>";
    echo "<center><a href='".$base_url.'/sites/default/files/pdf/'.$cltfname.".pdf' >Click to Download client<a><center><br/><br/><br/>";
   
}

function _generatePdf($fname='', $contentArr, $base_url)
{
echo dirname(__FILE__).'/sites/default/files/pdf/'.$fname.'.pdf<br/>';
require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
// get the HTML
 ob_start();
 
$content='<style type="text/css">
<!--
table.page_header {width: 100%; border: none; background-color: #ffffff; border-bottom: solid 1mm #014F7D; padding: 2mm;color:#014F7D }
table.page_header a {color:#014F7D;text-decoration: none;}
    table.page_footer {width: 100%; border: none; background-color: #014F7D; border-top: solid 1mm #014F7D; padding: 2mm;color:#ffffff}
    div.note {border: solid 1mm #DDDDDD;background-color: #EEEEEE; padding: 2mm; border-radius: 2mm; width: 100%; }
    ul.main { width: 95%; list-style-type: square; }
    ul.main li { padding-bottom: 2mm; }
    h1 { text-align: center; font-size: 20mm}
    h3 { text-align: center; font-size: 14mm}
    
 /* Mobile-specific Styles */
@media only screen and (max-device-width: 480px) { 
table[class=w0], td[class=w0] { width: 0 !important; }
table[class=w10], td[class=w10], img[class=w10] { width:10px !important; }
table[class=w15], td[class=w15], img[class=w15] { width:5px !important; }
table[class=w30], td[class=w30], img[class=w30] { width:10px !important; }
table[class=w60], td[class=w60], img[class=w60] { width:10px !important; }
table[class=w125], td[class=w125], img[class=w125] { width:80px !important; }
table[class=w130], td[class=w130], img[class=w130] { width:55px !important; }
table[class=w140], td[class=w140], img[class=w140] { width:90px !important; }
table[class=w160], td[class=w160], img[class=w160] { width:180px !important; }
table[class=w170], td[class=w170], img[class=w170] { width:100px !important; }
table[class=w180], td[class=w180], img[class=w180] { width:80px !important; }
table[class=w195], td[class=w195], img[class=w195] { width:80px !important; }
table[class=w220], td[class=w220], img[class=w220] { width:80px !important; }
table[class=w240], td[class=w240], img[class=w240] { width:180px !important; }
table[class=w255], td[class=w255], img[class=w255] { width:185px !important; }
table[class=w275], td[class=w275], img[class=w275] { width:135px !important; }
table[class=w280], td[class=w280], img[class=w280] { width:135px !important; }
table[class=w300], td[class=w300], img[class=w300] { width:140px !important; }
table[class=w325], td[class=w325], img[class=w325] { width:95px !important; }
table[class=w360], td[class=w360], img[class=w360] { width:140px !important; }
table[class=w410], td[class=w410], img[class=w410] { width:180px !important; }
table[class=w470], td[class=w470], img[class=w470] { width:200px !important; }
table[class=w580], td[class=w580], img[class=w580] { width:280px !important; }
table[class=w640], td[class=w640], img[class=w640] { width:300px !important; }
table[class*=hide], td[class*=hide], img[class*=hide], p[class*=hide], span[class*=hide] { display:none !important; }
table[class=h0], td[class=h0] { height: 0 !important; }
p[class=footer-content-left] { text-align: center !important; }
#headline p { font-size: 30px !important; }
.article-content, #left-sidebar{ -webkit-text-size-adjust: 90% !important; -ms-text-size-adjust: 90% !important; }
.header-content, .footer-content-left {-webkit-text-size-adjust: 80% !important; -ms-text-size-adjust: 80% !important;}
img { height: auto; line-height: 100%;}
 } 
#headertable{border: 1px solid #014F7D;color:#FFF;}
/* Client-specific Styles */
#outlook a { padding: 0; }	/* Force Outlook to provide a "view in browser" button. */
body { width: 100% !important; }
.ReadMsgBody { width: 100%; }
.ExternalClass { width: 100%; display:block !important; } /* Force Hotmail to display emails at full width */

body { background-color: #ececec; margin: 0; padding: 0; }
img { outline: none; text-decoration: none; display: block;}
br, strong br, b br, em br, i br { line-height:100%; }
h1, h2, h3, h4, h5, h6 { line-height: 100% !important; -webkit-font-smoothing: antialiased; }
h1 a, h2 a, h3 a, h4 a, h5 a, h6 a { color: blue !important; }
h1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {	color: red !important; }
/* Preferably not the same color as the normal header link color.  There is limited support for psuedo classes in email clients, this was added just for good measure. */
h1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited { color: purple !important; }
/* Preferably not the same color as the normal header link color. There is limited support for psuedo classes in email clients, this was added just for good measure. */  
table td, table tr { border-collapse: collapse; }
.yshortcuts, .yshortcuts a, .yshortcuts a:link,.yshortcuts a:visited, .yshortcuts a:hover, .yshortcuts a span {
color: black; text-decoration: none !important; border-bottom: none !important; background: none !important;
}	
code {
  white-space: normal;
  word-break: break-all;
}

#background-table { background-color: #ececec; }

#top-bar { border-radius:6px 6px 0px 0px; -moz-border-radius: 6px 6px 0px 0px; -webkit-border-radius:6px 6px 0px 0px; -webkit-font-smoothing: antialiased; background-color: #014F7D; color: #FFFFFF; }
#top-bar a { font-weight: bold; color: #FFFFFF; text-decoration: none;}
#footer { border-radius:0px 0px 6px 6px; -moz-border-radius: 0px 0px 6px 6px; -webkit-border-radius:0px 0px 6px 6px; -webkit-font-smoothing: antialiased; }
body, td { }
.header-content, .footer-content-left, .footer-content-right { -webkit-text-size-adjust: none; -ms-text-size-adjust: none; }
.header-content { font-size: 12px; color: #FFFFFF; }
.header-content a { font-weight: bold; color: #FFFFFF; text-decoration: none; }
#headline p { color: #FFFFFF; font-size: 36px; text-align: center; margin-top:0px; margin-bottom:20px; }
#headline p a { color: #FFFFFF; text-decoration: none; }

.article-title { font-size: 18px; line-height:24px; color: #014F7D; font-weight:bold; margin-top:0px; margin-bottom:10px; }
.article-title a { color: #014F7D; text-decoration: none; }
.article-title.with-meta {margin-bottom: 0;}
.article-meta { font-size: 13px; line-height: 20px; color: #ccc; font-weight: bold; margin-top: 0;}
.article-content { padding-left: 30px; font-size: 13px; line-height: 14px; color: #444444; margin-top: 0px; margin-bottom: 10px; }
.article-content a { color: #014F7D; font-weight:bold; text-decoration:none; }
.article-content img { max-width: 100% }
.article-content ol, .article-content ul { margin-top:0px; margin-bottom:10px; margin-left:19px; padding:0; }
.article-content li { font-size: 13px; line-height: 14px; color: #444444; }
.article-content li a { color: #014F7D; text-decoration:underline; }
.footer-content-left { font-size: 12px; line-height: 15px; color: #e2e2e2; margin-top: 0px; margin-bottom: 10px; }
.footer-content-left a { color: #FFFFFF; font-weight: bold; text-decoration: none; }
.footer-content-right { font-size: 11px; line-height: 16px; color: #e2e2e2; margin-top: 0px; margin-bottom: 10px; }
.footer-content-right a { color: #FFFFFF; font-weight: bold; text-decoration: none; }
#footer { background-color: #014F7D; color: #e2e2e2; }
#footer a { color: #FFFFFF; text-decoration: none; font-weight: bold; }
#permission-reminder { white-space: normal; }
#street-address { color: #FFFFFF; white-space: normal; }   
-->
</style>
<page backtop="28mm" backbottom="23mm" backleft="10mm" backright="10mm" style="font-size: 12pt">
    <page_header>
        <table class="page_header">
            <tr>
                <td style="width: 50%; text-align: left">
                   <img  src="'.dirname(__FILE__).'/sites/all/themes/privatetransfer_theme/logo.png" >
                </td>
                <td style="width: 50%; text-align: right">
                    <a style="text-decoration:none;" href="http://www.private-transfer.fr">www.private-transfer.fr</a> | Toll free from US: <strong>1 866 813 7381</strong> <br/><a style="text-decoration:none;" target="_blank" href="mailto:reservation@private-transfer.fr">reservation@private-transfer.fr</a>                   
                </td>
            </tr>
        </table>
    </page_header>
    <page_footer>
        <table class="page_footer">
            <tr>
                <td style="width: 43%; text-align: left;">
                    <strong>Découvertes SARL</strong><br/>
                2012 Découvertes SARL, 8 bis avenue du Cegares, <br/>13840 Rognes, France
Decouvertes Inc., 256 Carlton Avenue, Brooklyn, NY 11205-4002- Licence n. L1.013.00.0004
                   
                </td>
                <td style="width: 24%; text-align: center">
                    page [[page_cu]]/[[page_nb]]
                </td>
                <td style="width: 33%; text-align: right">
                    Private-transfer.fr / Contact us<br/>
Toll free from US:1 866 813 7381<br/>
<a style="color:#FFFFFF;text-decoration:none;" target="_blank" href="mailto:reservation@private-transfer.fr">reservation@private-transfer.fr</a><br/>
Tel: +33 442 50 14<br/>
Fax:+33 442 50 30 63
                </td>
            </tr>
        </table>
    </page_footer>
    <table id="content" cellspacing="0">';

 
    if(isset($contentArr[0]) && trim($contentArr[0])!='')
    {   
        $content.=trim($contentArr[0]);
        if(count($contentArr)==2)
        {
            $content.=$contentArr[1];
        }
    }
    
    $content.='</table></page>';
    if(count($contentArr)>2)
    {
        for ($i=1, $j=count($contentArr); $i<($j-1) ; $i++)
        {
           $content.='<page pageset="old">
           <table style="margin-top:100px;">';
          
          $content.=$contentArr[$i];
           $content.='</table>
            </page>';
        }
    }  
    try
    {
        
        $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', array(0, 0, 0, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        if($fname==''){$fname='PTX'.time();}        
        //$html2pdf->Output($fname.'.pdf');
        
        $html2pdf->Output(dirname(__FILE__).'/sites/default/files/pdf/'.$fname.'.pdf','F');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        /*exit;*/
    }
}

function _dt_day($dt)
{
	$day='';
	if(trim($dt)!=''){
		$dtarr=explode("/",$dt);
		$day = $dtarr[2].'-'.$dtarr[1].'-'.$dtarr[0];
		$day=date("l",strtotime($day));
	}
return $day;
}
function chknightService($hr, $meridian)
{
    if($meridian=='AM')
    {
       if($hr>6)
       {
            return false;     
       }
    }
    else if($meridian=='PM')
    {
       if($hr<8)
       {
           return false;     
       }
    }
    return true;
}

?>
