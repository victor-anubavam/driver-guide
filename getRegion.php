<?php

define('DRUPAL_ROOT', getcwd());
$base_url = 'http://'.$_SERVER['HTTP_HOST']; // THIS IS IMPORTANT
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL); // Could be DRUPAL_BOOTSTRAP_SESSION if that's all you need.
$process='';
if(isset($_REQUEST['process']) )
{
    $process=trim($_REQUEST['process']);
}
if($process == 'get-regionfrom'){
    $retval=array();
    if($_REQUEST['regionfr'] && trim($_REQUEST['regionfr'])!='')
    {
        $regionfr=trim(urldecode($_REQUEST['regionfr']));
        $result = db_query("SELECT field_add_region_given from field_data_field_add_region as r LEFT JOIN node as n on n.nid=r.entity_id
                           WHERE n.title LIKE '%".($regionfr)."' AND r.bundle='transfer_region'
                           GROUP BY r.field_add_region_given");
        foreach ($result as $record) {
                $retval[] = $record->field_add_region_given;
        }
    }
    echo json_encode($retval);
}
if($process == 'get-regionto'){ 
    $retval=array();
    if($_REQUEST['regionto'] && trim($_REQUEST['regionto'])!='')
    {
        $regionto=trim(($_REQUEST['regionto']));
	$regionto = str_replace("'","\'",$regionto);
        $regionfr=trim(($_REQUEST['regionfr']));
	$regionfr = str_replace("'","\'",$regionfr);
        $result = db_query("SELECT field_add_region_middle from field_data_field_add_region as r LEFT JOIN node as n on n.nid=r.entity_id
                           WHERE n.title LIKE '%".($regionfr)."' AND r.bundle='transfer_region' AND
                           r.field_add_region_given LIKE '%".($regionto)."' GROUP BY r.field_add_region_middle");
        foreach ($result as $record) {
                $retval[] = $record->field_add_region_middle;
        }
    }
    echo json_encode($retval);
}
if($process == 'get-homeregionto'){  
    $retval=array();
    if($_REQUEST['region'] && trim($_REQUEST['region'])!='' && $_REQUEST['regionfr'] && trim($_REQUEST['regionfr'])!='')
    {
        $region=trim(($_REQUEST['region']));
	$region =  str_replace("'","\'",$region);
        $regionfr=trim(($_REQUEST['regionfr']));     
        $regionfr = str_replace("'","\'",$regionfr);
        $result = db_query("SELECT field_add_region_middle from field_data_field_add_region as r LEFT JOIN node as n on n.nid=r.entity_id
                           WHERE n.title ='".($region)."' AND r.bundle='transfer_region' AND
                           r.field_add_region_given ='".($regionfr)."' GROUP BY r.field_add_region_middle");   
        foreach ($result as $record) {
                $retval[] = $record->field_add_region_middle;
        }
    }
    echo json_encode($retval);
}
if($process == 'members-head-quarters') {
    $network =$_REQUEST['network'];
    $email = $_REQUEST['email'];
    $emailSplit = explode("@",$email);
    if((empty($network)) && (!empty($emailSplit))) {
	$networkMatch = db_query("SELECT og.etid AS network_id FROM og_membership
JOIN og ON og.gid = og_membership.gid
JOIN field_data_field_company_email_id ON field_data_field_company_email_id.entity_id = og_membership.etid
WHERE field_company_email_id_email LIKE '%$emailSplit[1]%'
AND og_membership.entity_type = 'node' and field_data_field_company_email_id.bundle='group'")->fetchField();
	if($networkMatch) {
	     $options['snetwork'][] = $networkMatch;
	     echo json_encode($options);
	}
    }else {
    /*$result = db_query("SELECT og_membership.etid AS nid, og_membership.entity_type AS TYPE ,og.label as title, og_membership.gid AS group_id FROM og_membership
JOIN og ON og.gid = og_membership.gid WHERE og.etid =".$network." AND og_membership.entity_type =  'node'");*/
    $result = db_query("SELECT og_membership.etid AS nid,og_membership.entity_type AS TYPE ,og_membership.gid AS network_id, og.label AS title,
                                           og.gid as member_id,field_data_field_company_email_id.field_company_email_id_email AS cmymail FROM og_membership
                                           JOIN og ON og.gid = og_membership.gid
                                           JOIN field_data_field_company_email_id ON field_data_field_company_email_id.entity_id = og_membership.etid
                                           WHERE og.etid = ".$network." AND field_company_email_id_email LIKE '%$emailSplit[1]%' AND og_membership.entity_type = 'node' and field_data_field_company_email_id.bundle='group'");    
  
   
        $option = array();
	foreach ($result as $record) {
		    $nodeid = $record->nid;	
		    $regDuration = $record->group_id;
		    $nodeTitle = db_query("select title from node where nid = ".$nodeid." and type='group'")->fetchField();
		    $options[] = $nodeTitle."||".$nodeid ;
	}	
	
	if(!empty($options)) {
	echo json_encode($options);
	}else {
	    $options[] = "others||00";               
	    echo json_encode($options);
	}
    }
}
if($process == 'travel-agency-filter') {
    $mailId = trim($_REQUEST['mail']);
    $network = trim($_REQUEST['network']);
    $emailSplit = explode("@",$mailId );
     if((empty($network)) && (!empty($emailSplit))) {
	$networkMatch = db_query("SELECT og.etid AS network_id FROM og_membership
JOIN og ON og.gid = og_membership.gid
JOIN field_data_field_company_email_id ON field_data_field_company_email_id.entity_id = og_membership.etid
WHERE field_company_email_id_email LIKE '%$emailSplit[1]%'
AND og_membership.entity_type = 'node' and field_data_field_company_email_id.bundle='group'")->fetchField();
	if($networkMatch) {
	     $options['snetwork'][] = $networkMatch;
	     echo json_encode($options);
	}
    }else {
        $memberResult = db_query("SELECT og_membership.etid AS nid,og_membership.entity_type AS TYPE ,og_membership.gid AS network_id, og.label AS title,
                                           og.gid as member_id,field_data_field_company_email_id.field_company_email_id_email AS cmymail FROM og_membership
                                           JOIN og ON og.gid = og_membership.gid
                                           JOIN field_data_field_company_email_id ON field_data_field_company_email_id.entity_id = og_membership.etid
                                           WHERE og.etid = ".$network." AND field_company_email_id_email LIKE '%$emailSplit[1]%' AND og_membership.entity_type = 'node' and field_data_field_company_email_id.bundle='group'");
	     foreach($memberResult as $record) {
		    $nodeid = $record->nid;	
		    $regDuration = $record->group_id;
		    $nodeTitle = db_query("select title from node where nid = ".$nodeid." and type='group'")->fetchField();
		    $options['member'][] = $nodeTitle."||".$nodeid ;
		  // $options['member'][] = $row->title."||".$row->nid;
	    }
	if(!empty($options['member'])) {
	echo json_encode($options);
	}/*else if((empty($options['agency'])) && (!empty($options['member']))){
	   // $options['agency'][] = "others||00";
	   // echo json_encode($options); 
	}else if((!empty($options['agency'])) && (empty($options['member']))){
	    //$options['member'][] = "others||00"; 
	    echo json_encode($options); 
	}*/
	else {
	$options['agency'][] = "others||00";
	$options['member'][] = "others||00"; 
	echo json_encode($options);  		 
	}
    }
	
    }
if($process == 'get-agency-filter-stage-one')
{
     $mailId = trim($_REQUEST['mail']);
    $network = trim($_REQUEST['network']);
    $emailSplit = explode("@",$mailId );
          $memberResult = db_query("SELECT og_membership.etid AS nid,og_membership.entity_type AS TYPE ,og_membership.gid AS network_id, og.label AS title,
                                           og.gid as member_id,field_data_field_company_email_id.field_company_email_id_email AS cmymail FROM og_membership
                                           JOIN og ON og.gid = og_membership.gid
                                           JOIN field_data_field_company_email_id ON field_data_field_company_email_id.entity_id = og_membership.etid
                                           WHERE og.etid = ".$network." AND og_membership.entity_type = 'node' and field_data_field_company_email_id.bundle='travel_agency'");
	
	
 
        foreach($memberResult as $record) {
		    $nodeid = $record->nid;	
		    $regDuration = $record->group_id;
		    $nodeTitle = db_query("select title from node where nid = ".$nodeid." and type='travel_agency'")->fetchField();
		    $options['agency'][] = $nodeTitle."||".$nodeid ;
		  // $options['member'][] = $row->title."||".$row->nid;
	    }
	    if(!empty($options['agency'])) {
	echo json_encode($options);
	}/*else if((empty($options['agency'])) && (!empty($options['member']))){
	   // $options['agency'][] = "others||00";
	   // echo json_encode($options); 
	}else if((!empty($options['agency'])) && (empty($options['member']))){
	    //$options['member'][] = "others||00"; 
	    echo json_encode($options); 
	}*/
	else {
	//$options['agency'][] = "others||00";
	$options['agency'][] = "others||00"; 
	echo json_encode($options);  		 
	}
}

if($process == 'get-regiondriveratdisposal') {
    $region =$_REQUEST['region'];
    
    $result = db_query("SELECT title,vid,field_regions_given,field_regions_middle,field_regions_family from node
    join field_data_field_regions on node.vid = field_data_field_regions.entity_id
    where node.title = '".$region."' and type='car_at_disposal_region'");

    
    $options=array();
	foreach ($result as $record) {
	$regName = $record->field_regions_given;
	$regDuration = $record->field_regions_middle;
	$options[] = $regName." - ".$regDuration;
	}

    echo json_encode($options);
}

if($process == 'get-arrivaltime') {
    $arrTime = $_REQUEST['dtime'];
    $duration = $_REQUEST['dur'];
    $arrMin = $_REQUEST['durmin'];
   // print_r($_REQUEST);
    $arrTimeArry = explode("-",$duration);  
    $timesp =explode("h",$arrTimeArry[1]);
    
    $departitme = ($arrTime + $timesp[0]);
    $departcalc = $departitme /12;
   
    if($departcalc >= 1) {
	$departitme = $departitme % 12 ; 
    }
    if($timesp[1] == "00") {
	$departMin = $arrMin;
    } else {	
	$departMin = $timesp[1] + $arrMin;	
        $durationcalc = $departMin / 60;	
	if($durationcalc >= 1) {
	$departMin = $departMin % 60;

	$departitme = $departitme + $durationcalc;
	} else {
	    $departMin = $departMin;
	}
    }
   // if($departMin = 0)
   // $departMin == 00;  

    
    $arrtime = $departitme."||".$departMin;
    echo json_encode($arrtime);
}

if($process == 'get-arrivaldifftime') {
    
    $duration = $_REQUEST['dur'];
    $arrTime = $_REQUEST['dtime'];
    $arrMin = $_REQUEST['durmin'];
    $arrpart = $_REQUEST['arrpart'];
    $arrmins = $_REQUEST['arrmins'];
    $drop_day_night = $_REQUEST['drop_day_night'];
    $arri_day_night = $_REQUEST['arr_day_night'];
    $arrTimeArry = explode("-",$duration);    
    $timesp =explode("h",$arrTimeArry[1]);
    
     if($arri_day_night != $drop_day_night) {	
	$balanceHour = (12 - $arrTime);	
	if($arrMin!= "00") {
	$balanceMin = (60 - $arrMin);
	$balanceHour = $balanceHour -1 ;
	$durationCalc = ($balanceMin + $arrmins)/60;
	    if($durationCalc >= 1) {
		$balanceHour = round($balanceHour + $durationCalc);
		$totalmins =  ($balanceMin + $arrmins)%60;		
	    }  else {
		$totalmins = $balanceMin + $arrmins;
	    }
	} 
	$totalHours = $balanceHour + $arrpart;
	if($totalmins == "60")
	$totalmins = "00";
	else
	$totalmins = $totalmins;
	
    $temMin = $totalmins; 	
    if($timesp[1] == "00") {
	$totalHours = $totalHours - $timesp[0];
    } else {
	$totalmins = $totalmins - $timesp[1];
	echo $totalmins;
        if(strstr($totalmins, '-')){
	    $temmin = (60 - $timesp[1]);
	    $min = ($timesp[1] + $temmin)/ 60;
	    if($min >= 1) {
		$totalHours = $totalHours + round($min);
	    } else {
		$totalmins = $totalmins + $temmin;
	    }
	} else{
	    $totalmins = 60 - $timesp[1];
	    $totalHours = $totalHours - 1 ;
	}
    }

	$arrtime = $totalHours.":".$totalmins;
	
	echo json_encode($arrtime);
    } else {
    
    $departitme = ($arrTime + $timesp[0]);
    $arrpartcalc = $arrpart-$departitme;
    
    if($timesp[1] == "00") {
	$departMinCalc = $arrmins-$arrMin;
    } else {	
        $departMin = $timesp[1] + $arrMin;	
        $durationcalc = $departMin / 60;
        $departMinCalc = ($durationcalc+$arrmins)-($arrMin+$timesp[1]);
        
	if($departMinCalc < 0) {
           $arrpartcalc= $arrpartcalc+$departMinCalc;
       } 
    } 
    
    if($departMinCalc < 0) {
        $departMinCalc=$departMinCalc-(2*$departMinCalc);
    }
    
    
    if($arrpartcalc==0 && $departMinCalc==0)
    $arrtime = '';
    else
    $arrtime = $arrpartcalc.":".$departMinCalc;
    
    
    echo json_encode($arrtime);
    }
}

if($process == 'get-agency-info') {
    $nid = $_REQUEST['nid'];
    $option=array();
    $nodeDetails = node_load($nid);
   // print_r($nodeDetails);
       if(isset($nodeDetails->field_zip_codde['und'][0]['value'])) 
	$option['zipcode'] = $nodeDetails->field_zip_codde['und'][0]['value'];
       if(isset($nodeDetails->field_country_addr['und'][0]['iso2'])) 
	$option['countrycode'] = $nodeDetails->field_country_addr['und'][0]['iso2'];
	if(isset($nodeDetails->field_statte['und'][0]['value'])) 
	$option['state'] = $nodeDetails->field_statte['und'][0]['value'];
	if(isset($nodeDetails->field_cityy['und'][0]['value'])) 
	$option['field_cityy'] = $nodeDetails->field_cityy['und'][0]['value'];
	if(isset($nodeDetails->field_street_adress['und'][0]['value'])) 
	$option['street_address'] = $nodeDetails->field_street_adress['und'][0]['value'];
	if(isset($nodeDetails->field_website_url['und'][0]['url'])) 
	$option['website'] = $nodeDetails->field_website_url['und'][0]['url'];    
    
   // print_r($option);
     echo json_encode($option);
}

?>