<?php

function search_reports()
{
	
	global $user;
	global $base_url;
	global $base_path;
	$cond='';
	$qstr='';
        $startDt='';
        $endDt='';
        
        if(isset($_REQUEST['startDt']) && trim($_REQUEST['startDt'])!='')
	{
		$startDt = trim($_REQUEST['startDt']);
                $dtarr=explode('/',$startDt);
                $startDtq=$dtarr[2].'-'.$dtarr[1].'-'.$dtarr[0]; 
                $startDtq = strtotime($startDtq);                
		$cond.=" and logck.created_dt>='".$startDtq."'";
		$qstr.='&startDt='.$startDt;
	}
        
        if(isset($_REQUEST['endDt']) && trim($_REQUEST['endDt'])!='')
	{
		$endDt = trim($_REQUEST['endDt']);
                $dtarr=explode('/',$endDt);
                $endDtq=$dtarr[2].'-'.$dtarr[1].'-'.$dtarr[0]; 
                $endDtq = strtotime($endDtq);                
		$cond.=" and logck.created_dt<='".$endDtq."'";
		$qstr.='&endDt='.$endDt;
	}
	$downlink='';
        if(isset($user->roles['6']))
        {
           $downlink='<a href="javascript:void(0)" onclick="downloadReprt()" id="downpdf" >DOWNLOAD : <img src="'.drupal_get_path('theme', 'privatetransfer_theme').'/images/pdf_gen.png" title="Generate PDF" /></a>';
        }
        else
        {
           $downlink='<a href="javascript:void(0)" onclick="generatePdf(\'member\')" id="downpdf" >DOWNLOAD : <img src="'.drupal_get_path('theme', 'privatetransfer_theme').'/images/pdf_gen.png" title="Generate PDF" /></a>';
        }
        
	$form['some_text'] = array(
	  '#type' => 'item',
	  '#markup' => '<div class="cartErrMsg"></div>
                        <div >
                         Start date: <input type="text" class="arrivDayCal" name="startDt" readonly="true" id="startDt" value="'.$startDt.'" maxlength="10" /><img src="'.drupal_get_path('theme', 'privatetransfer_theme').'/scripts/cal.gif" class="calimg" id="startDt_calimg"/>
                         End date: <input type="text" class="arrivDayCal" name="endDt" readonly="true" id="endDt" value="'.$endDt.'" maxlength="10" /><img src="'.drupal_get_path('theme', 'privatetransfer_theme').'/scripts/cal.gif" class="calimg" id="endDt_calimg"/>
                        <span class="btn" id="edit-submit">OK</span></div>');
	
	$form['by_startDt'] = array(
        '#type' => 'text',
        '#title' => 'By startDt',        
        '#default_value' => $startDt,
		/*'#attributes' => array('onchange' => 'onChangeChamiloSearch();'),*/	
        );	
		
	$adjacents = 3;
        $uid = $user->uid;
        $gid = db_query("SELECT gid FROM `og_users_roles` WHERE uid ='".$uid."' AND rid =3 LIMIT 0 , 1")->fetchField();
        
	//$query = "SELECT COUNT(*) as num from  log_detailed_transfer_results_checkout where trav_agent_id!='' $cond";
        
       //echo  $query = "SELECT COUNT(*) as num FROM `og_membership` WHERE gid ='".$gid."' and entity_type='node'";
        //$query = "SELECT DISTINCT og.etid FROM `og_membership` as og left join log_detailed_transfer_results_checkout as logck on og.etid=logck.trav_agent_id  WHERE og.gid ='".$gid."' and og.entity_type='node' $cond";
        $query = "SELECT DISTINCT og.etid FROM `og_membership` as og 
                        join node as n on og.etid=n.nid 
                        join log_detailed_transfer_results_checkout as logck on n.uid=logck.trav_agent_id  
                        WHERE og.gid ='".$gid."' and og.entity_type='node' $cond ";
        $result = db_query($query);
        $total_pages = $result->rowCount();
        $global_buss_tot='0.00';
        $gross_margin_tot='0.00';
        foreach($result as $memrow) {
            // Do your thing for each result.
            $memberArry =  node_load($memrow->etid);
            $memberid=$memberArry->uid;
            $gross_margin=0;
            $globalbuss=db_query("SELECT  SUM(total_amt) FROM log_detailed_transfer_results_checkout where trav_agent_id='".$memberid."' ")->fetchField();
            if($globalbuss!='' &&  $globalbuss!='NULL')
            {
            $gross_margin=($globalbuss*5)/100;
            }
            else {
                $globalbuss=0;
            }
            $global_buss_tot+=$globalbuss;
            $gross_margin_tot+=$gross_margin;
        }
	//$total_pages=db_query($query)->fetchField();
	
	$targetpage = "search-reports"; 	
	$limit = 10;
        
        $page =1;
	if(isset($_GET['page']))
	$page = $_GET['page'];
	
        $start = 0; 
	if($page) 
        $start = ($page - 1) * $limit;
		      
      /*
        $report_result = db_query("SELECT * from  log_detailed_transfer_results_checkout where trav_agent_id!='' $cond
        LIMIT $start, $limit");*/
        //echo "SELECT DISTINCT etid FROM `og_membership` WHERE gid ='".$gid."' and entity_type='node'  LIMIT $start, $limit ";
        
        $query = "SELECT DISTINCT og.etid FROM `og_membership` as og 
                        join node as n on og.etid=n.nid 
                        join log_detailed_transfer_results_checkout as logck on n.uid=logck.trav_agent_id  
                        WHERE og.gid ='".$gid."' and og.entity_type='node' ".$cond." LIMIT ".$start.", ".$limit;
        
        $result  = db_query($query);
        //$result  = db_query("SELECT DISTINCT etid FROM `og_membership` WHERE gid ='".$gid."' and entity_type='node'  LIMIT $start, $limit ");
        
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"item-list\"><ul class=\"pager clearfix\">";
		//previous button
		if ($page > 1) 
			$pagination.= "<li class=\"pager-previous\"><a href=\"$targetpage?page=$prev$qstr\">&lsaquo; prev</a></li>";
			
		if($page <> 1)	
			$pagination.= "<li class=\"pager-first first\"><a class=\"active\" title=\"Go to first page\" href=\"$targetpage?page=1$qstr\">&laquo; first</a></li>";	
		/*else
			$pagination.= "<span class=\"disabled\">&lsaquo; prev</span>";	*/
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<li class=\"pager-current\">$counter</li>";
				else
					$pagination.= "<li class=\"pager-item\"><a href=\"$targetpage?page=$counter$qstr\">$counter</a></li>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class=\"pager-current\">$counter</li>";
					else
						$pagination.= "<li class=\"pager-item\"><a href=\"$targetpage?page=$counter$qstr\">$counter</a></li>";					
				}
				$pagination.= "...";
				$pagination.= "<li class=\"pager-item\"><a href=\"$targetpage?page=$lpm1$qstr\">$lpm1</a></li>";
				$pagination.= "<li class=\"pager-item\"><a href=\"$targetpage?page=$lastpage$qstr\">$lastpage</a></li>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<li class=\"pager-item\"><a href=\"$targetpage?page=1$qstr\">1</a></li>";
				$pagination.= "<li class=\"pager-item\"><a href=\"$targetpage?page=2$qstr\">2</a></li>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class=\"pager-current\">$counter</li>";
					else
						$pagination.= "<li class=\"pager-item\"><a href=\"$targetpage?page=$counter$qstr\">$counter</a></li>";					
				}
				$pagination.= "...";
				$pagination.= "<li class=\"pager-item\"><a href=\"$targetpage?page=$lpm1$qstr\">$lpm1</a></li>";
				$pagination.= "<li class=\"pager-item\"><a href=\"$targetpage?page=$lastpage$qstr\">$lastpage</a></li>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<li class=\"pager-item\"><a href=\"$targetpage?page=1$qstr\">1</a></li>";
				$pagination.= "<li class=\"pager-item\"><a href=\"$targetpage?page=2$qstr\">2</a></li>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class=\"pager-current\">$counter</li>";
					else
						$pagination.= "<li class=\"pager-item\"><a href=\"$targetpage?page=$counter$qstr\">$counter</a></li>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<li class=\"pager-next\"><a href=\"$targetpage?page=$next$qstr\">next &rsaquo;</a></li>";
		/*else
			$pagination.= "<span class=\"disabled\">next &rsaquo;</span>";*/
		if($page <> $lastpage)	
			$pagination.= "<li class=\"pager-last last\"><a class=\"active\" title=\"Go to last page\" href=\"$targetpage?page=$lastpage$qstr\">last &raquo;</a></li>";
		$pagination.= "</ul></div>\n";		
	}
	
	$description ='<div>
                        ';
	 $description .='<table class="privatemsg-list sticky-enabled table-select-processed tableheader-processed sticky-table">';
$description .=' <thead>
                    <tr><th>Member</th>
                    <th >Contact Name</th>
                    <th>Headquarter Location</th>
                    <th >Global business ($) of the period</th>
                    <th >Global gross margin due by BEF per Agency($)</th>
                    </tr>
                </thead>';
$description .='<tbody>';		
               
                if(isset($result))
                {  
                    foreach ($result as $row) {	
                        $memberArry =  node_load($row->etid);                        
                        $memberid=$memberArry->uid;
                        $user_mem=  user_load($memberid);                     
                        $gross_margin='0.00';                       
                        $globalbuss=db_query("SELECT  SUM(total_amt) FROM log_detailed_transfer_results_checkout where trav_agent_id='".$memberid."' ")->fetchField();
                        if($globalbuss!='' &&  $globalbuss!='NULL')
                        {
                        $gross_margin=($globalbuss*5)/100;
                        }
                        else {
                            $globalbuss='0.00';
                        }
                        $description .='<tr><td>';
                        if($user->roles['6'])
                        {
                           $description.='<a href="javascript:void(0);" onclick="gotomember_search(\''.$memberArry->uid.'\')" >'.$memberArry->title.'<a>';
                        }
                        else
                        {
                           $description.=$memberArry->title;
                        }
                        $description .='</td>
                    <td >'.$memberArry->field_hqfirst_name['und'][0]['value'].' '.$memberArry->field_last_name['und'][0]['value'].'</td>
                    <td>'.$memberArry->field_hq_state['und'][0]['value'].'/'.$memberArry->field_street_adress['und'][0]['value'].'<br/>'.$memberArry->field_hq_city['und'][0]['value'].'-'.$memberArry->field_hq_zip['und'][0]['value'].'</td>
                    <td>$ '.$globalbuss.'</td>
                    <td >$ '.$gross_margin.'</td>
                    </tr>';
                    }
                    
                     $description .='<tr><td>Total</td>
                    <td ></td>
                    <td></td>
                    <td>$ '.$global_buss_tot.'</td>
                    <td >$ '.$gross_margin_tot.'</td>
                    </tr>';
                     $description .='<tr><td colspan="5" style="height:30px">'.$pagination.'</td></tr>';
                }
                else
                {
                    $description .='<tr><td colspan="2">No records found</td></tr>';
                }
                
$description .=' </tbody></table>';
$description .=' </div>';
$description .="<script language='javascript'>
    jQuery(document).ready(function() { 
	//if(jQuery('.page-search-reports #startDt')){jQuery('#startDt').datepick({dateFormat: 'dd/mm/yyyy',showTrigger: '#startDt_calimg'});}
        //if(jQuery('.page-search-reports #endDt')){jQuery('#endDt').datepick({dateFormat: 'dd/mm/yyyy',showTrigger: '#endDt_calimg'});}
        
        jQuery('#edit-submit').click(function() {
            var startDt='';
            var endDt='';
            if(jQuery('#startDt').val()!='' && jQuery('#endDt').val()!='')
            {
                startDt=jQuery('#startDt').val();
                endDt=jQuery('#endDt').val();
                document.location.href='search-reports?startDt='+startDt+'&endDt='+endDt;
            }
            else
            {
                jQuery('.cartErrMsg').html('Please select start date and end date to search').fadeIn();
                setTimeout(function(){jQuery('.cartErrMsg').fadeOut()},4000);
            } 
        });
        
       
        var startDateTextBox = jQuery('#startDt');
        var endDateTextBox = jQuery('#endDt');

        startDateTextBox.datetimepicker({ 
                dateFormat: 'd/mm/yy',
                altField: '#',
                showHour:false,
                showMinute:false,
                showTime:false,
                onClose: function(dateText, inst) {
                        if (endDateTextBox.val() != '') {
                                var testStartDate = startDateTextBox.datetimepicker('getDate');
                                var testEndDate = endDateTextBox.datetimepicker('getDate');
                                if (testStartDate > testEndDate)
                                        endDateTextBox.datetimepicker('setDate', testStartDate);
                        }
                        else {
                                endDateTextBox.val(dateText);
                        }
                },
                onSelect: function (selectedDateTime){
                        endDateTextBox.datetimepicker('option', 'minDate', startDateTextBox.datetimepicker('getDate') );
                }
        });
        endDateTextBox.datetimepicker({ 
                dateFormat: 'd/mm/yy',
                altField: '#',
                showHour:false,
                showMinute:false,
                showTime:false,
                onClose: function(dateText, inst) {
                        if (startDateTextBox.val() != '') {
                                var testStartDate = startDateTextBox.datetimepicker('getDate');
                                var testEndDate = endDateTextBox.datetimepicker('getDate');
                                if (testStartDate > testEndDate)
                                        startDateTextBox.datetimepicker('setDate', testEndDate);
                        }
                        else {
                                startDateTextBox.val(dateText);
                        }
                },
                onSelect: function (selectedDateTime){
                        startDateTextBox.datetimepicker('option', 'maxDate', endDateTextBox.datetimepicker('getDate') );
                }
        });
        
        



    });
    
        function gotomember_search(memid)
        {
            var startDt='';
            var endDt='';
            if(jQuery('#startDt').val()!='' && jQuery('#endDt').val()!='')
            {
                startDt=jQuery('#startDt').val();
                endDt=jQuery('#endDt').val();
            }
            document.location.href='search-reports-member?uid='+memid+'&startDt='+startDt+'&endDt='+endDt;
        }
    
        function generatePdf(rep_type)
        {
            var startDt='';
            var endDt='';
            startDt=jQuery('#startDt').val();
            endDt=jQuery('#endDt').val();
            document.location.href='report.php?process='+rep_type+'&startDt='+startDt+'&endDt='+endDt;
        }
        function generatePdfDetail(rep_type)
        {
            var startDt='';
            var endDt='';
            startDt=jQuery('#startDt').val();
            endDt=jQuery('#endDt').val();
            document.location.href='reportdetail.php?process='+rep_type+'&startDt='+startDt+'&endDt='+endDt;
        }

    
    
    </script>";
   
   $form['field'] = array(
    '#type' => 'fieldset', 
    '#title' => '', 
    '#description' => $description, 
    '#tree' => TRUE,
  ); 
	
	return $form;    
}

function search_reports_member()
{
	
	global $user;
	global $base_url;
	global $base_path;
	$cond='';
	$qstr='';
        $startDt='';
        $endDt='';
        
        if(isset($_REQUEST['startDt']) && trim($_REQUEST['startDt'])!='')
	{
		$startDt = trim($_REQUEST['startDt']);
                $dtarr=explode('/',$startDt);
                $startDtq=$dtarr[2].'-'.$dtarr[1].'-'.$dtarr[0]; 
                $startDtq = strtotime($startDtq);                
		$cond.=" and logck.created_dt>='".$startDtq."'";
		$qstr.='&startDt='.$startDt;
	}
        
        if(isset($_REQUEST['endDt']) && trim($_REQUEST['endDt'])!='')
	{
		$endDt = trim($_REQUEST['endDt']);
                $dtarr=explode('/',$endDt);
                $endDtq=$dtarr[2].'-'.$dtarr[1].'-'.$dtarr[0]; 
                $endDtq = strtotime($endDtq);                
		$cond.=" and logck.created_dt<='".$endDtq."'";
		$qstr.='&endDt='.$endDt;
	}
        $uid=0;
        if(isset($_REQUEST['uid']) && trim($_REQUEST['uid'])!='')
	{
            $uid=trim($_REQUEST['uid']);
            $qstr.='&uid='.$uid;
	}
	
        
	$form['some_text'] = array(
	  '#type' => 'item',
	  '#markup' => '<div class="cartErrMsg"></div>
                        <div >
                         Start date: <input type="text" class="arrivDayCal" name="startDt" readonly="true" id="startDt" value="'.$startDt.'" maxlength="10" /><img src="'.drupal_get_path('theme', 'privatetransfer_theme').'/scripts/cal.gif" class="calimg" id="startDt_calimg"/>
                         End date: <input type="text" class="arrivDayCal" name="endDt" readonly="true" id="endDt" value="'.$endDt.'" maxlength="10" /><img src="'.drupal_get_path('theme', 'privatetransfer_theme').'/scripts/cal.gif" class="calimg" id="endDt_calimg"/>
                        <span class="btn" id="edit-submit">OK</span>
                         <a href="javascript:void(0)" onclick="generatePdf(\'member\')" id="downpdf" >DOWNLOAD : <img src="'.drupal_get_path('theme', 'privatetransfer_theme').'/images/pdf_gen.png" title="Generate PDF" /></a>
                         </div>
                        '
	);
	
	$form['by_startDt'] = array(
        '#type' => 'text',
        '#title' => 'By startDt',        
        '#default_value' => $startDt,
		/*'#attributes' => array('onchange' => 'onChangeChamiloSearch();'),*/	
        );	
		
	$adjacents = 3;
        //$uid = $user->uid;
        //echo "SELECT gid FROM `og_users_roles` WHERE uid ='".$uid."' LIMIT 0 , 1";
        $gid = db_query("SELECT gid FROM `og_users_roles` WHERE uid ='".$uid."' LIMIT 0 , 1")->fetchField();
        
        $query = "SELECT DISTINCT og.etid FROM `og_membership` as og join node as n on og.etid=n.nid 
                        join log_detailed_transfer_results_checkout as logck on n.uid=logck.trav_agent_id  
                        WHERE og.gid ='".$gid."' and og.entity_type='node' $cond";
        $result = db_query($query);
        $total_pages = $result->rowCount();
        $global_buss_tot='0.00';
        $gross_margin_tot='0.00';
        foreach($result as $memrow) {
            // Do your thing for each result.
            $memberArry =  node_load($memrow->etid);
            $memberid=$memberArry->uid;
            $gross_margin=0;
            $globalbuss=db_query("SELECT  SUM(total_amt) FROM log_detailed_transfer_results_checkout where trav_agent_id='".$memberid."' ")->fetchField();
            if($globalbuss!='' &&  $globalbuss!='NULL')
            {
            $gross_margin=($globalbuss*5)/100;
            }
            else {
                $globalbuss=0;
            }
            $global_buss_tot+=$globalbuss;
            $gross_margin_tot+=$gross_margin;
        }
	//$total_pages=db_query($query)->fetchField();
	
	$targetpage = "search-reports-member"; 	
	$limit = 10;
        
        $page =1;
	if(isset($_GET['page']))
	$page = $_GET['page'];
	
        $start = 0; 
	if($page) 
        $start = ($page - 1) * $limit;
		      
      /*
        $report_result = db_query("SELECT * from  log_detailed_transfer_results_checkout where trav_agent_id!='' $cond
        LIMIT $start, $limit");*/
        //echo "SELECT DISTINCT etid FROM `og_membership` WHERE gid ='".$gid."' and entity_type='node'  LIMIT $start, $limit ";
        
        $query = "SELECT DISTINCT og.etid FROM `og_membership` as og join node as n on og.etid=n.nid 
                        join log_detailed_transfer_results_checkout as logck on n.uid=logck.trav_agent_id  
                        WHERE og.gid ='".$gid."' and og.entity_type='node' ".$cond." LIMIT ".$start.", ".$limit;
        $result  = db_query($query);
        //$result  = db_query("SELECT DISTINCT etid FROM `og_membership` WHERE gid ='".$gid."' and entity_type='node'  LIMIT $start, $limit ");
        
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"item-list\"><ul class=\"pager clearfix\">";
		//previous button
		if ($page > 1) 
			$pagination.= "<li class=\"pager-previous\"><a href=\"$targetpage?page=$prev$qstr\">&lsaquo; prev</a></li>";
			
		if($page <> 1)	
			$pagination.= "<li class=\"pager-first first\"><a class=\"active\" title=\"Go to first page\" href=\"$targetpage?page=1$qstr\">&laquo; first</a></li>";	
		/*else
			$pagination.= "<span class=\"disabled\">&lsaquo; prev</span>";	*/
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<li class=\"pager-current\">$counter</li>";
				else
					$pagination.= "<li class=\"pager-item\"><a href=\"$targetpage?page=$counter$qstr\">$counter</a></li>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class=\"pager-current\">$counter</li>";
					else
						$pagination.= "<li class=\"pager-item\"><a href=\"$targetpage?page=$counter$qstr\">$counter</a></li>";					
				}
				$pagination.= "...";
				$pagination.= "<li class=\"pager-item\"><a href=\"$targetpage?page=$lpm1$qstr\">$lpm1</a></li>";
				$pagination.= "<li class=\"pager-item\"><a href=\"$targetpage?page=$lastpage$qstr\">$lastpage</a></li>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<li class=\"pager-item\"><a href=\"$targetpage?page=1$qstr\">1</a></li>";
				$pagination.= "<li class=\"pager-item\"><a href=\"$targetpage?page=2$qstr\">2</a></li>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class=\"pager-current\">$counter</li>";
					else
						$pagination.= "<li class=\"pager-item\"><a href=\"$targetpage?page=$counter$qstr\">$counter</a></li>";					
				}
				$pagination.= "...";
				$pagination.= "<li class=\"pager-item\"><a href=\"$targetpage?page=$lpm1$qstr\">$lpm1</a></li>";
				$pagination.= "<li class=\"pager-item\"><a href=\"$targetpage?page=$lastpage$qstr\">$lastpage</a></li>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<li class=\"pager-item\"><a href=\"$targetpage?page=1$qstr\">1</a></li>";
				$pagination.= "<li class=\"pager-item\"><a href=\"$targetpage?page=2$qstr\">2</a></li>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class=\"pager-current\">$counter</li>";
					else
						$pagination.= "<li class=\"pager-item\"><a href=\"$targetpage?page=$counter$qstr\">$counter</a></li>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<li class=\"pager-next\"><a href=\"$targetpage?page=$next$qstr\">next &rsaquo;</a></li>";
		/*else
			$pagination.= "<span class=\"disabled\">next &rsaquo;</span>";*/
		if($page <> $lastpage)	
			$pagination.= "<li class=\"pager-last last\"><a class=\"active\" title=\"Go to last page\" href=\"$targetpage?page=$lastpage$qstr\">last &raquo;</a></li>";
		$pagination.= "</ul></div>\n";		
	}
	
	$description ='<div>
                        ';
	 $description .='<table class="privatemsg-list sticky-enabled table-select-processed tableheader-processed sticky-table">';
$description .=' <thead>
                    <tr><th>Agency Name</th>
                    <th >Manager\'s Name</th>
                    <th>Agencies Loaction</th>
                    <th >Global business ($) per agency</th>
                    <th >Global gross margin due by BEF per Agency($)</th>
                    </tr>
                </thead>';
$description .='<tbody>';		
               
                if(isset($result))
                {  
                    foreach ($result as $row) {	
			$memberArry =  node_load($row->etid);
                        $memberid=$memberArry->uid;
                        $user_mem=  user_load($memberid);                     
                        $gross_margin='0.00';                       
                        $globalbuss=db_query("SELECT  SUM(total_amt) FROM log_detailed_transfer_results_checkout where trav_agent_id='".$memberid."' ")->fetchField();
                        if($globalbuss!='' &&  $globalbuss!='NULL')
                        {
                        $gross_margin=($globalbuss*5)/100;
                        }
                        else {
                            $globalbuss='0.00';
                        }
                        $description .='<tr><td>'.$memberArry->title.'</td>
                    <td >'.$memberArry->field_hqfirst_name['und'][0]['value'].' '.$memberArry->field_last_name['und'][0]['value'].'</td>
                    <td>'.$memberArry->field_hq_state['und'][0]['value'].'/'.$memberArry->field_street_adress['und'][0]['value'].'<br/>'.$memberArry->field_hq_city['und'][0]['value'].'-'.$memberArry->field_hq_zip['und'][0]['value'].'</td>
                    <td>$ '.$globalbuss.'</td>
                    <td >$ '.$gross_margin.'</td>
                    </tr>';
                    }
                    
                     $description .='<tr><td>Total</td>
                    <td ></td>
                    <td></td>
                    <td>$ '.$global_buss_tot.'</td>
                    <td >$ '.$gross_margin_tot.'</td>
                    </tr>';
                     $description .='<tr><td colspan="5" style="height:30px">'.$pagination.'</td></tr>';
                }
                else
                {
                    $description .='<tr><td colspan="2">No records found</td></tr>';
                }
                
$description .=' </tbody></table>';
$description .=' </div>';
$description .="<script language='javascript'>
    jQuery(document).ready(function() { 
	
        jQuery('#edit-submit').click(function() {
            var startDt='';
            var endDt='';
            if(jQuery('#startDt').val()!='' && jQuery('#endDt').val()!='')
            {
                startDt=jQuery('#startDt').val();
                endDt=jQuery('#endDt').val();
                document.location.href='search-reports?startDt='+startDt+'&endDt='+endDt;
            }
            else
            {
                jQuery('.cartErrMsg').html('Please select start date and end date to search').fadeIn();
                setTimeout(function(){jQuery('.cartErrMsg').fadeOut()},4000);
            } 
        });
        



        var startDateTextBox = jQuery('#startDt');
        var endDateTextBox = jQuery('#endDt');

        startDateTextBox.datetimepicker({ 
                dateFormat: 'd/mm/yy',
                altField: '#',
                showHour:false,
                showMinute:false,
                showTime:false,
                onClose: function(dateText, inst) {
                        if (endDateTextBox.val() != '') {
                                var testStartDate = startDateTextBox.datetimepicker('getDate');
                                var testEndDate = endDateTextBox.datetimepicker('getDate');
                                if (testStartDate > testEndDate)
                                        endDateTextBox.datetimepicker('setDate', testStartDate);
                        }
                        else {
                                endDateTextBox.val(dateText);
                        }
                },
                onSelect: function (selectedDateTime){
                        endDateTextBox.datetimepicker('option', 'minDate', startDateTextBox.datetimepicker('getDate') );
                }
        });
        endDateTextBox.datetimepicker({ 
                dateFormat: 'd/mm/yy',
                altField: '#',
                showHour:false,
                showMinute:false,
                showTime:false,
                onClose: function(dateText, inst) {
                        if (startDateTextBox.val() != '') {
                                var testStartDate = startDateTextBox.datetimepicker('getDate');
                                var testEndDate = endDateTextBox.datetimepicker('getDate');
                                if (testStartDate > testEndDate)
                                        startDateTextBox.datetimepicker('setDate', testEndDate);
                        }
                        else {
                                startDateTextBox.val(dateText);
                        }
                },
                onSelect: function (selectedDateTime){
                        startDateTextBox.datetimepicker('option', 'maxDate', endDateTextBox.datetimepicker('getDate') );
                }
        });


    });
    
        function generatePdf(rep_type)
        {
            var startDt='';
            var endDt='';
            startDt=jQuery('#startDt').val();
            endDt=jQuery('#endDt').val();
            document.location.href='report.php?process='+rep_type+'&startDt='+startDt+'&endDt='+endDt+'&uid=".$uid."';
        }
        
        


    
    
    </script>";
   
   $form['field'] = array(
    '#type' => 'fieldset', 
    '#title' => '', 
    '#description' => $description, 
    '#tree' => TRUE,
  ); 
	
	return $form;    
}

?>
