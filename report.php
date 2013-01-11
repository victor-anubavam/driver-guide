<?php

define('DRUPAL_ROOT', getcwd());
$base_url = 'http://'.$_SERVER['HTTP_HOST']; // THIS IS IMPORTANT
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL); // Could be DRUPAL_BOOTSTRAP_SESSION if that's all you need.
global $base_url;

if(isset($_REQUEST['startDt']) && isset($_REQUEST['endDt']) && isset($_REQUEST['process']) && trim($_REQUEST['process'])!='')
{
  
    //$startDt=$_REQUEST['startDt'];
    //$endDt=$_REQUEST['endDt'];
    if(isset($_REQUEST['startDt']) && trim($_REQUEST['startDt'])!='')
    {
            $startDt = trim($_REQUEST['startDt']);
            $dtarr=explode('/',$startDt);
            $startDtq=$dtarr[2].'-'.$dtarr[1].'-'.$dtarr[0]; 
            $startDtq = strtotime($startDtq);                
            $cond.=" and logck.created_dt>='".$startDtq."'";
    }
    
    if(isset($_REQUEST['endDt']) && trim($_REQUEST['endDt'])!='')
    {
            $endDt = trim($_REQUEST['endDt']);
            $dtarr=explode('/',$endDt);
            $endDtq=$dtarr[2].'-'.$dtarr[1].'-'.$dtarr[0]; 
            $endDtq = strtotime($endDtq);                
            $cond.=" and logck.created_dt<='".$endDtq."'";
    }
    
    $type=$_REQUEST['process'];
    
    $contentArr=array();
    $content='';
   
    switch ($type)
    {
    case 'network':
      $content.='<tr><th>Member</th>
                    <th>Contact Person</th>
                    <th>Headquarter Loaction</th>
                    <th>Global business ($)<br/>of the period</th>
                    <th>Global gross margin<br/>due by BEF per<br>Member($)</th>
                    </tr>';
      break;
    case 'member':
      $content.='<tr><th>Agency Name</th>
                    <th>Manager\'s Name</th>
                    <th>Agenccies Loaction</th>
                    <th>Global business ($)<br/>per agency</th>
                    <th>Global gross margin due by<br> BEF perAgency($)</th>
                    </tr>';
      break;   
    }
    
    
    $uid = $user->uid;
    $gid = db_query("SELECT gid FROM `og_users_roles` WHERE uid ='".$uid."' AND rid =3 LIMIT 0 , 1")->fetchField();
    $query = "SELECT DISTINCT og.etid FROM `og_membership` as og join node as n on og.etid=n.nid 
                        join log_detailed_transfer_results_checkout as logck on n.uid=logck.trav_agent_id  
                        WHERE og.gid ='".$gid."' and og.entity_type='node' $cond ";
    $result = db_query($query);  
    if(isset($result))
    {  
        $globalbuss_tot='0.00';
        $gross_margin_tot='0.00';
        foreach ($result as $row) {	
            
            $memberArry =  node_load($row->etid);
            $memberid=$memberArry->uid;
            $user_mem=  user_load($memberid);                     
            $gross_margin='0.00'; 
         
            //echo "SELECT  SUM(total_amt) FROM log_detailed_transfer_results_checkout where trav_agent_id='".$memberid."' ";
            $globalbuss=db_query("SELECT  SUM(total_amt) FROM log_detailed_transfer_results_checkout where trav_agent_id='".$memberid."' ")->fetchField();
            if($globalbuss!='' &&  $globalbuss!='NULL')
            {
            $gross_margin=($globalbuss*5)/100;
            $globalbuss_tot+=$globalbuss;
            $gross_margin_tot=$gross_margin;
            
            }
            else {
                $globalbuss='0.00';
            }
            
            $content .='<tr><td class="tdtitle">'.$memberArry->title.'</td>
        <td>'.$memberArry->field_hqfirst_name['und'][0]['value'].' '.$memberArry->field_last_name['und'][0]['value'].'</td>
        <td class="location">'.$memberArry->field_hq_state['und'][0]['value'].'/'.$memberArry->field_street_adress['und'][0]['value'].'<br/>'.$memberArry->field_hq_city['und'][0]['value'].'-'.$memberArry->field_hq_zip['und'][0]['value'].'</td>
        <td class="price">$ '.$globalbuss.'</td>
        <td class="price">$ '.$gross_margin.'</td>
        </tr>';  
        }
            $content .='<tr class="lastTr"><td>Total</td>
        <td></td>
        <td></td>
        <td class="price">$ '.$globalbuss_tot.'</td>
        <td class="price">$ '.$gross_margin_tot.'</td>
        </tr>';    
        $contentArr[]=$content;
    }
    
   
   $agtfname=$type.'PTX_RPT_'.time();
    
   _generatePdf($agtfname,$contentArr,$base_url);
  
   
}

function _generatePdf($fname='', $contentArr, $base_url)
{
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
table{width:100%;}
table th{width:auto;background-color: #014F7D;color: #FFFFFF;font-size: 10px;padding-left:5px;padding-bottom: 4px;padding-top: 5px;text-align: left;
font: 10px Verdana, Arial, Helvetica, sans-serif;border:none}
#content tr td {
        font-size: 10px;
	border-bottom: 1px solid #CCC;
	padding-left:5px;
        padding-top:5px;
        }
.location{width:200px;}
.price{text-align:right;padding-right:5px;}
.tdtitle{width:180px;}
.lastTr td{padding-bottom:20px;}

-->
</style>
<page backtop="28mm" backbottom="28mm" backleft="10mm" backright="10mm" style="font-size: 12pt">
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
        $html2pdf->Output($fname.'.pdf');
        
        //$html2pdf->Output(dirname(__FILE__).'/sites/default/files/pdf/'.$fname.'.pdf','F');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        /*exit;*/
    }
}





?>

