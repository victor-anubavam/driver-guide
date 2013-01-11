<?php

function myreports()
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
        if(isset($user->roles[3]))
        {
            //Administrator
            $query = "SELECT logck.id FROM log_detailed_transfer_results_checkout as logck
                        join `log_detailed_checkout_report` as repck on logck.id=repck.checkout_id  
                        WHERE logck.trav_agent_id !=''  $cond group by logck.id";
        }
        if(isset($user->roles[6]) || isset($user->roles[7]))
        {
            //Members  Head Quarters Admin || Network Admin
            $gid = db_query("SELECT gid FROM `og_users_roles` WHERE uid ='".$uid."' AND rid =3 LIMIT 0 , 1")->fetchField();
            $query = "SELECT DISTINCT og.etid, logck.id FROM `og_membership` as og 
                        join node as n on og.etid=n.nid 
                        join log_detailed_transfer_results_checkout as logck on n.uid=logck.trav_agent_id 
                        join `log_detailed_checkout_report` as repck on logck.id=repck.checkout_id 
                        WHERE og.gid ='".$gid."' and og.entity_type='node' $cond group by logck.id ";
            
            
        }
        else
        {
         
            $query = "SELECT logck.id FROM log_detailed_transfer_results_checkout as logck
                        join `log_detailed_checkout_report` as repck on logck.id=repck.checkout_id  
                        WHERE logck.trav_agent_id ='".$uid."'  $cond group by logck.id";
        }
        $result = db_query($query);
        $total_pages = $result->rowCount();
	
	$targetpage = "myreports"; 	
	$limit = 10;
        
        $page =1;
	if(isset($_GET['page']))
	$page = $_GET['page'];
	
        $start = 0; 
	if($page) 
        $start = ($page - 1) * $limit;		      
        
        
        $query = "SELECT logck.id,created_dt FROM log_detailed_transfer_results_checkout as logck
                        join `log_detailed_checkout_report` as repck on logck.id=repck.checkout_id  
                        WHERE logck.trav_agent_id ='".$uid."' ". $cond." group by logck.id LIMIT ".$start.", ".$limit;
        
        $result  = db_query($query);
        
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
                    <tr><th>Checkout ID</th>
                    <th >Reports</th>
                    <th>Date</th>
                    </tr>
                </thead>';
$description .='<tbody>';		
               
                if(isset($result))
                {  
                    foreach ($result as $row) {	
                                            
                        $checkout_id=$row->id;
                        $reportfiles='';
                        $acc_cond='';
                        // Travel agent
                        if(isset($user->roles[5]))
                        {
                          $acc_cond=" and report_type!='SUP'";  
                        }
                        elseif(isset($user->roles[6]) || isset($user->roles[7]))
                        {
                          //Network Admin  || Members  Head Quarters Admin 
                          $acc_cond=" ";  
                        }
                        elseif(isset($user->roles[8]))
                        {
                          //Client  
                          $acc_cond=" and report_type!='SUP' and  report_type!='AGT' ";  
                        }
                        $reportfilelists=db_query("SELECT file FROM log_detailed_checkout_report where checkout_id='".$checkout_id."' " .$acc_cond);
                        foreach ($reportfilelists as $rec) {
                        $reportfiles.="<div id='fileList'><a href='".$base_url."/sites/default/files/pdf/".$rec->file.".pdf'>".$rec->file."</a></div>";
                        }
                       
                        $mysqldate = date("d/m/Y", $row->created_dt);
                        
                        $description .='<tr><td>'.$checkout_id.'</td>
                        <td >'.$reportfiles.'</td>
                        <td>'.$mysqldate.'</td>
                        </tr>';
                    }
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
                document.location.href='myreports?startDt='+startDt+'&endDt='+endDt;
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
