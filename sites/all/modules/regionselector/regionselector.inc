<?php
function cart_checkout(){
    global $base_url;
    global $user;
    $output='<div class="plzwtMsg">Please wait while we process you request...</div><div class="cartErrMsg">Please fill the highlighted Complete information trip</div>
        <div class="commMsg"></div>
        <div>
            <table>
                <thead>
                    <tr>
                        <th>Remove</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="cartCont">';
                
    if(isset($_SESSION['products'])){
    $cart = unserialize($_SESSION['products']);    
    }
    else
    $cart =array();   
   //$sortArry = $cart;
    $sortArry = array();
     /*echo "<pre>";
     print_r($cart);
     echo "</pre>";*/
    foreach($cart as $row)  {        
         $serviceType = $row['product_details']['serv_type'];
         if(($row['product_details']['serv_type'] == 'meet_greet') && isset($row['product_details']['IN'])) {    
             $sortArry[$row['product_details']['IN']['id']] = $row;
         }         
    }
    foreach($cart as $row)   {        
         $serviceType = $row['product_details']['serv_type'];
         if(($row['product_details']['serv_type'] == 'service_as_transfer') && isset($row['product_details']['in'])) {    
             $sortArry[$row['product_details']['in']['id']] = $row;
         }         

    }
    foreach($cart as $row)  {        
         $serviceType = $row['product_details']['serv_type'];
           if(($row['product_details']['serv_type'] == 'driver_at_disposal')) {    
             $sortArry[$row['product_details']['driv']['id']] = $row;
         } 
    }
    foreach($cart as $row)   {   
            if(($row['product_details']['serv_type'] == 'meet_greet') && isset($row['product_details']['Commute'])) {    
                     $sortArry[$row['product_details']['Commute']['id']] = $row;
                 }
    }   
    foreach($cart as $row) {        
         if(($row['product_details']['serv_type'] == 'service_as_transfer') && isset($row['product_details']['in&out'])) {    
             $sortArry[$row['product_details']['in&out']['id']] = $row;
         }  
    }
             
    foreach($cart as $row)  {        
         $serviceType = $row['product_details']['serv_type'];
         if(($row['product_details']['serv_type'] == 'service_as_transfer') && isset($row['product_details']['out'])) {    
             $sortArry[$row['product_details']['out']['id']] = $row;
         }         

    }
    foreach($cart as $row)  {        
         $serviceType = $row['product_details']['serv_type'];
         if(($row['product_details']['serv_type'] == 'meet_greet') && isset($row['product_details']['Out'])) {    
             $sortArry[$row['product_details']['Out']['id']] = $row;
         }         

    }
    
    
    
    
    
    
   /* $_SESSION['products'] = serialize($sortArry);*/
    unset($_SESSION['products']);
    unset($cart);
    $_SESSION['products'] = serialize($sortArry);
    //$cart = unserialize($_SESSION['products']);
    $tot_price=0;
    $subtot_price=0;
    $classAppend='';
    
    $cart = $sortArry;
    
    /*echo "<pre>";
    print_r($cart);
    echo "</pre>";*/
    
    foreach($cart as $row)
    {  
        $classCompInfo='';
        for($i=0;$i<3;$i++)
        {
            $type='';
            switch ($i)
            {
            case 0:
              //$type='in';
              if(isset($row['product_details']['serv_type']) && $row['product_details']['serv_type']=='service_as_transfer')
              $type='in';
              elseif(isset($row['product_details']['serv_type']) && $row['product_details']['serv_type']=='meet_greet')
              $type='IN';
              elseif(isset($row['product_details']['serv_type']) && $row['product_details']['serv_type']=='driver_at_disposal')
              $type='driv';
              break;
            case 1:              
              if(isset($row['product_details']['serv_type']) && $row['product_details']['serv_type']=='service_as_transfer')
              $type='out';
              elseif(isset($row['product_details']['serv_type']) && $row['product_details']['serv_type']=='meet_greet')
              $type='Out';
              break;
            case 2:
              if(isset($row['product_details']['serv_type']) && $row['product_details']['serv_type']=='service_as_transfer')
              $type='in&out';
              elseif(isset($row['product_details']['serv_type']) && $row['product_details']['serv_type']=='meet_greet')
              $type='Commute';  
              break;
            } 
            if(isset($row['product_details'][$type]['status']) && $row['product_details'][$type]['status']=='not_complete'){
                $classCompInfo='disableCompt';
                if($classAppend==''){ $classAppend='disableCompt';}
            }
            else{ $classCompInfo=''; }
            
           if(isset($row['product_details'][$type]))
           { 
            $id=$row['product_details'][$type]['id'];
            $node=node_load($id);
            $qty=$row['product_details'][$type]['qty'];
            $price=$row['product_details'][$type]['qty']*$row['product_details'][$type]['price'];
            $totcomprice='';
            //Check for travek agent Login
            if(isset($user->roles[5]))
            { 
                if(trim($row['product_details']['serv_type'])=='meet_greet')
                {
                   if($row['product_details'][$type]['srch']['applied']=='weekday')                   
                   $totcomprice=$row['product_details'][$type]['qty']*$row['product_details'][$type]['srch']['custday_price']; 
                   else
                   $totcomprice=$row['product_details'][$type]['qty']*$row['product_details'][$type]['srch']['custend_price']; 
                   
                   $price=$totcomprice;
                }
                else
                {
                    $totcomprice=$row['product_details'][$type]['qty']*$row['product_details'][$type]['price'];
                    //$totcomprice=$row['product_details'][$type]['qty']*$row['product_details'][$type]['srch']['cust_price'];
                //
                }
            }
            else
            {   
                $totcomprice=$row['product_details'][$type]['qty']*$row['product_details'][$type]['price'];
                //$totcomprice=$row['product_details'][$type]['qty']*$row['product_details'][$type]['srch']['cust_price'];  
            }
             
            $night_comm_price=0;
            $nigth_rate_comm=$row['product_details'][$type]['srch']['night_rate_comm'];
            if($type == 'in&out' || $type == 'Commute') {
                $night_comm_price=(($totcomprice/2)*$nigth_rate_comm)/100;
            }
            else
            {
                $night_comm_price=($totcomprice*$nigth_rate_comm)/100;
            }
            
            
            if(isset($row['person_details'][$type]['arrival_tm']) && trim($row['person_details'][$type]['arrival_tm'])=='2')
            {   
                $totcomprice=$totcomprice+$night_comm_price;
                $price=$price+$night_comm_price;
            }
            
            //Check for nightservice applied in out service for IN&OUT or COMMUTE
            if(($type == 'in&out' || $type == 'Commute') && (isset($row['product_details'][$type]['out']['decol_hr_out']) && isset($row['product_details'][$type]['out']['decol_meridian_out']) && trim($row['product_details'][$type]['out']['decol_hr_out'])!='' && trim($row['product_details'][$type]['out']['decol_meridian_out'])!='')) {
                $hr=trim($row['product_details'][$type]['out']['decol_hr_out']); 
                $meridian=trim($row['product_details'][$type]['out']['decol_meridian_out']);
                if(chknightService($hr, $meridian))
                {
                    $totcomprice=$totcomprice+$night_comm_price;
                    $price=$price+$night_comm_price;
                }
            }
            
            
           
            $subtot_price+=$price;
            $tot_price+=$totcomprice; 
            //  
            $typ_id=str_replace("&","_",$type);
            
            // Display type of service to customer
            $serviceType = $row['product_details']['serv_type'];
            $productType = $type;            
             
            $serviceInfo = '';
            if($serviceType == 'driver_at_disposal') {
                $serviceInfo = ' - Driver at disposal';
            }
           
            if($serviceType == 'service_as_transfer'){
                $serviceInfo = ' - Transfer ';
                if($productType == 'in') {
                    $serviceInfo.=' in';
                }else if($productType == 'out'){
                    $serviceInfo.= 'out';
                }else {
                    $serviceInfo.= ' in&out';
                }
                
            }
          
            $output.='<tr id="cart_'.$id.$typ_id.'">
                    <td><a href="javascript:void(0);" onclick="removefromCartCheckout('.$id.','.$price.',\''.$type.'\');"><div class="remove">remove</div></a></td>
                    <td>'.$node->title.''.$serviceInfo.'</td>
                    <td><input type="text" value="'.$qty.'" class="onlyNum" onkeyup="updateQtyCheckout(this,\'qty\','.$id.',\''.$type.'\')" name="qty_'.$id.'" id="qty_'.$id.'" size="3" style="text-align:right;padding-right:5px;"/></td>
                    <td><b>&euro; </b> '.$price.' <b>Euro</b></td>
                    <td><div class="compDiv" id="comp_'.$id.$typ_id.'">';
            
            
            ctools_include('ajax');
            ctools_include('modal');
            ctools_modal_add_js();
            
            $custom_style = array(
                'my-simple-ass-modal-style' => array(
                  'modalSize' => array(
                    'type' => 'fixed',
                    'width' => 'auto',
                    'height' => 'auto',
                  ),
                  'animation' => 'fadeIn',
                ),
              );
            drupal_add_js($custom_style, 'setting');
            
            $url='travel_information/'.$id.'/'.$type.'/'.urlencode($node->title);
            $compinfo='Complete details on this trip';
            if($classCompInfo==''){  $compinfo='Information completed';  }
            $output .= ctools_modal_text_button(t($compinfo), $url, 
                                                        t($compinfo), 'ctools-modal-my-simple-ass-modal-style compInfo '.$classCompInfo);
            ctools_include('plugins'); 
           
            //$output .='<a href="javascript:void(0);" onclick="complete_info('.$id.',\''.$type.'\')"><div class="compInfo">Complete information on this trip</div></a>';
            $output .='</div></td>
                        </tr>';
           }
        }
        
    }
    $comm=$tot_price-$subtot_price;
    $comm_percent='';
    if(isset($_SESSION['comm_percent']) && trim($_SESSION['comm_percent'])!='')
    {
        $comm_percent=trim($_SESSION['comm_percent']);
    }
    
    $extracommsion='';
        if($comm_percent!='')
        {
            $extracommsion=(($comm_percent*$tot_price)/100);
            $tot_price=$tot_price+(($comm_percent*$tot_price)/100);
        }
      $output.='</tbody>
            </table>
            </div>';
     $output .='<div style="float:left;clear:both;"></div>
                <div style="float:right;">
                <div style="text-align:right;">Total price without commission : <b>&euro; </b> <span id="tot_price">'.$subtot_price.'</span> <b>Euro</b></div>';
     //Check for travek agent Login
    if(isset($extracommsion) && trim($extracommsion)!='')
    { 
      $output .='<div style="text-align:right;">Commission : <b>&euro; </b> <span id="tot_price">'.$extracommsion.'</span> <b>Euro</b></div>';
    }
      $output .='<div style="text-align:right;">Total price with commission : <b>&euro; </b> <span id="tot_price">'.$tot_price.'</span> <b>Euro</b></div>    
                </div>'; 
      $output .='<div style="float:left;clear:both;"></div>
          <div class="completeDiv">
          <a href="javascript:void(0);" onClick="document.location.href=\''.$base_url.'\'" ><div class="btn '.$classAppend.'">Adding other products</div></a>
          <a href="javascript:void(0);" onClick="cartComplete()" ><div class="btn '.$classAppend.'" id="cartcomplete">';
      if($classAppend==''){
          $output.='Complete your Order';
      }
      else
      {
          $output.='Completion of command';
      }
      
      $output .='</div></a>
          </div>';    
    $form['field'] = array(
              '#type' => 'fieldset', 
              '#title' => '', 
              '#description' => $output, 
              '#tree' => TRUE,
      );
   
   
    return $form;  
}

function checkout_payment(){
    global $user;   
    global $base_url;
    $userDetail=user_load($user->uid);
    $agentName='';
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
    
    $cart =array();
    if(isset($_SESSION['products']))
    $cart = unserialize($_SESSION['products']);  
    $comm_percent='';
    if(isset($_SESSION['comm_percent']) && trim($_SESSION['comm_percent'])!='')
    {
        $comm_percent=trim($_SESSION['comm_percent']);
    }
    
     $output='';     
     $tot_price=0;
     $subtot_price=0;
     $output_client='';  
    $outputContent='';
    $retval=array();
    $userInfo='';
    
    /*echo "<pre>";
    print_r($cart);
    echo "</pre>";*/
    
    $output_client=$output='<div id="payCont">
        <table width="100%" cellspacing="0" cellpadding="0" border="0" >
        <tbody>
        <tr>
            <td><div class="invTitle">Review your cart & Payment</div></td>
        </tr>
        <tr>
            <td id="content-column" >'; 
   
    foreach ($cart as $key => $row)
    {      
       for($i=0;$i<3;$i++)
        {
           $type=''; 
           switch ($i)
            {
            case 0:
              if($row['product_details']['serv_type']=='service_as_transfer')
              $type='in';
              elseif($row['product_details']['serv_type']=='meet_greet')
              $type='IN';
              elseif($row['product_details']['serv_type']=='driver_at_disposal')
              $type='driv';
              break;
            case 1:
              if($row['product_details']['serv_type']=='service_as_transfer')
              $type='out';
              elseif($row['product_details']['serv_type']=='meet_greet')
              $type='Out';
              break;
            case 2:
              if($row['product_details']['serv_type']=='service_as_transfer')
              $type='in&out';
              elseif($row['product_details']['serv_type']=='meet_greet')
              $type='Commute'; 
              break;
            }
            if(isset($row['product_details'][$type]['status']) && $row['product_details'][$type]['status']=='complete'){
           if(isset($row['product_details'][$type]))
           { 
               
            $id=$row['product_details'][$type]['id'];
            $node=node_load($id);
            
             ctools_include('ajax');
            ctools_include('modal');
            ctools_modal_add_js();
            
            $custom_style = array(
                'my-simple-ass-modal-style' => array(
                  'modalSize' => array(
                    'type' => 'fixed',
                    'width' => 'auto',
                    'height' => 'auto',
                  ),
                  'animation' => 'fadeIn',
                ),
              );
            drupal_add_js($custom_style, 'setting');
            
            $url='travel_information/'.$id.'/'.$type.'/'.urlencode($node->title);
            $compinfo='Complete details on this trip';
            
            $editLink = ctools_modal_text_button(t('Edit'), $url, 
                        t('Edit'), 'ctools-modal-my-simple-ass-modal-style compInfo ');
            ctools_include('plugins'); 
            
            
            $qty=$row['product_details'][$type]['qty'];           
            $price=$row['product_details'][$type]['qty']*$row['product_details'][$type]['price'];
            $totcomprice='';
            
            //Check for travek agent Login
            if(isset($user->roles[5]))
            { 
                if(trim($row['product_details']['serv_type'])=='meet_greet')
                {
                   if($row['product_details'][$type]['srch']['applied']=='weekday')                   
                   $totcomprice=$row['product_details'][$type]['qty']*$row['product_details'][$type]['srch']['custday_price']; 
                   else
                   $totcomprice=$row['product_details'][$type]['qty']*$row['product_details'][$type]['srch']['custend_price']; 
                   
                   $price=$totcomprice;
                }
                else
                {
                    //$totcomprice=$row['product_details'][$type]['qty']*$row['product_details'][$type]['srch']['cust_price'];
                    $totcomprice=$row['product_details'][$type]['qty']*$row['product_details'][$type]['price'];
                }
            }
            else
            {   
                //$totcomprice=$row['product_details'][$type]['qty']*$row['product_details'][$type]['srch']['cust_price']; 
                $totcomprice=$row['product_details'][$type]['qty']*$row['product_details'][$type]['price'];
            }
            
            $night_comm_price=0;
            $nigth_rate_comm=$row['product_details'][$type]['srch']['night_rate_comm'];
            if($type == 'in&out' || $type == 'Commute') {
                $night_comm_price=(($totcomprice/2)*$nigth_rate_comm)/100;
            }
            else
            {
                $night_comm_price=($totcomprice*$nigth_rate_comm)/100;
            }
            
            if(isset($row['person_details'][$type]['arrival_tm']) && trim($row['person_details'][$type]['arrival_tm'])=='2')
            {
                $totcomprice=$totcomprice+$night_comm_price;
                $price=$price+$night_comm_price;                
            }
            
            
            //Check for nightservice applied in out service for IN&OUT or COMMUTE
            if(($type == 'in&out' || $type == 'Commute') && (isset($row['product_details'][$type]['out']['decol_hr_out']) && isset($row['product_details'][$type]['out']['decol_meridian_out']) && trim($row['product_details'][$type]['out']['decol_hr_out'])!='' && trim($row['product_details'][$type]['out']['decol_meridian_out'])!='')) {
                $hr=trim($row['product_details'][$type]['out']['decol_hr_out']); 
                $meridian=trim($row['product_details'][$type]['out']['decol_meridian_out']);
                if(chknightService($hr, $meridian))
                {
                    $totcomprice=$totcomprice+$night_comm_price;
                    $price=$price+$night_comm_price;
                }
            }
            $subtot_price+=$price;
            $tot_price+=$totcomprice;
            /*echo "<pre>";
            print_r($row);
            echo "</pre>";*/
            $typ_id=str_replace("&","_",$type);
            $servtitle=$row['product_details'][$type]['servtitle'];
            switch (trim($row['product_details']['serv_type']))
            {
            case "service_as_transfer":
              switch ($type)
                {
                case "in":
                    $airport_arrival=$row['product_details'][$type]['airline'];
                    if($airport_arrival=='Others'){ $airport_arrival= $row['product_details'][$type]['airline_OthersTxt'];} 
                    $passengerDetails='';
                    for($inc=0;$inc<count($row['product_details'][$type]['passengerDetails']);$inc++)
                    {
                        if(trim($passengerDetails)!=''){$passengerDetails.=' and ';}
                        $passengerDetails.=$row['product_details'][$type]['passengerDetails'][$inc]['surtitle'];
                        $passengerDetails.='.'.$row['product_details'][$type]['passengerDetails'][$inc]['pasengername'];
                        $passengerDetails.=' '.$row['product_details'][$type]['passengerDetails'][$inc]['fname'];
                        $passengerDetails.=', Tel: '.$row['product_details'][$type]['passengerDetails'][$inc]['tnum'].'.';
                        if(trim($userInfo)!=''){$userInfo.=' and ';}
                        $userInfo.=ucfirst($row['product_details'][$type]['passengerDetails'][$inc]['pasengername']).' '.ucfirst($row['product_details'][$type]['passengerDetails'][$inc]['fname']);
                        
                    }
                    $no_people=$row['person_details'][$type]['no_people'];
                    if($no_people=='Others'){ $no_people= $row['person_details'][$type]['no_people_OthersTxt'];} 
                    $dest_addr=$row['product_details'][$type]['dest_addr'];
                    if($dest_addr=='Others'){ $dest_addr= $row['product_details'][$type]['dest_addr_OthersTxt'];} 
                    else{$dest_addr.=' '.$row['product_details'][$type]['dest_addr_OthersTxt'];}
                    $qty=$row['product_details'][$type]['qty'];
                    $price=$row['product_details'][$type]['price'];
                    $clientprice=0;
                    //Check for travek agent Login
                    if(isset($user->roles[5]))
                    { 
                        //$clientprice=$row['product_details'][$type]['srch']['cust_price'];
                        $clientprice=$price;
                    }
                    
                    $qtyCont='';
                    $qtyCont_client='';
                    if($comm_percent!='')
                    {
                        $clientprice=$clientprice+(($comm_percent*$clientprice)/100);
                    }
                    if(isset($row['person_details'][$type]['arrival_tm']) && trim($row['person_details'][$type]['arrival_tm'])=='2')
                    {
                        $nigth_rate_comm=$row['product_details'][$type]['srch']['night_rate_comm'];
                        $night_comm_price=($clientprice*$nigth_rate_comm)/100;
                        $clientprice=$clientprice+$night_comm_price;
                        $night_comm_price=($price*$nigth_rate_comm)/100;
                        $price=$price+$night_comm_price;
                    }
                    if($qty>1)
                    {
                        $qtyCont=$qty.' (Qty)  * '.$price.' = ';
                        /*if($comm_percent!='')
                        {
                            $clientprice=$clientprice+(($comm_percent*$clientprice)/100);
                        }*/
                        $qtyCont_client=$qty.' (Qty)  * '.$clientprice.' = ';
                        $price=$price* $qty;
                        $clientprice=$clientprice* $qty;
                    }                   
                    
                  $driv_details=$row['product_details'][$type]['driv_name'].' - Tel: '.$row['product_details'][$type]['driv_num'];
                  $output_buff='<table  cellspacing="0" cellpadding="0" border="0" >
                    <tbody><tr>
                        <td >
                            <p align="left" class="article-title serviceInfo">Services for '._dt_day($row['product_details'][$type]['arriv_day']).' '.$row['product_details'][$type]['arriv_day'].'</p>
                            <p align="left" class="article-title">Transfer In from '.$row['product_details'][$type]['srch']['from'].' to '.$row['product_details'][$type]['srch']['to'].'</p>
                            <div align="left" class="article-content">
                                <p>Flight '.$row['product_details'][$type]['airline'].' '.$row['product_details'][$type]['flight_no'].' arrives at '.$row['product_details'][$type]['arriv_hr'].':'.$row['product_details'][$type]['arriv_mt'].strtolower($row['product_details'][$type]['arriv_meridian']).', coming from '.$row['product_details'][$type]['srch']['from'].',</p>
                                <p>'.$row['product_details'][$type]['arriv_hr'].':'.$row['product_details'][$type]['arriv_mt'].strtolower($row['product_details'][$type]['arriv_meridian']).': Meet your '.$row['product_details'][$type]['driv_lang'].'-speaking driver at '.$row['product_details'][$type]['ariport_origin'].' upon arrival,</p>
                                <p>Private transfer service with a '.$row['product_details'][$type]['servtitle'].' from  '.$row['product_details'][$type]['ariport_origin'].' to '.$dest_addr.',</p>
                                <p>For '.$passengerDetails.' / '.$no_people.' passengers,</p>
				<p>Your driver contact: '.$driv_details.',</p>';
                
                $output_client.=$output_buff;
                $output_buff.='<p><div class="fLeftW">'.$editLink.'<a href="javascript:void(0)" onclick="removefromCartPayment('.$id.',\''.$type.'\');"><div  class="remove btn">Remove</div></a></div></div><div class="fRight">Price for this service: '.$qtyCont.'<strong>'.$price.' €uros</strong></div></p>';
                $output_client.='<p><div class="fRight">Price for this service: '.$qtyCont_client.'<strong>'.$clientprice.' €uros</strong></div></p>';
                $output.=$output_buff; 
                
                $output_buff='</div>
                        </td>
                    </tr>
                    <tr><td><div class="separator"></div></td></tr>
                </tbody></table>';
                  $output.=$output_buff;
                  $output_client.=$output_buff; 
                  
                  break;
                case "out":
                $pickout_addr=$row['product_details'][$type]['pickout_addr'];
                if($pickout_addr=='Others'){ $pickout_addr= $row['product_details'][$type]['pickout_addrTxt'];} 
                else{$pickout_addr.=' '.$row['product_details'][$type]['pickout_addrTxt'];} 
                $passengerDetails='';
                for($inc=0;$inc<count($row['product_details'][$type]['passengerDetails']);$inc++)
                {
                    if(trim($passengerDetails)!=''){$passengerDetails.=' and ';}
                    $passengerDetails.=$row['product_details'][$type]['passengerDetails'][$inc]['surtitle_out'];
                    $passengerDetails.='.'.$row['product_details'][$type]['passengerDetails'][$inc]['pasengername_out'];
                    $passengerDetails.=' '.$row['product_details'][$type]['passengerDetails'][$inc]['fname_out'];
                    $passengerDetails.=', Tel: '.$row['product_details'][$type]['passengerDetails'][$inc]['tnum_out'].'.';
                    if(trim($userInfo)!=''){$userInfo.=' and ';}
                    $userInfo.=ucfirst($row['product_details'][$type]['passengerDetails'][$inc]['pasengername_out']).' '.ucfirst($row['product_details'][$type]['passengerDetails'][$inc]['fname_out']);

                }
                $no_people=$row['person_details'][$type]['no_people'];
                if($no_people=='Others'){ $no_people= $row['person_details'][$type]['no_people_OthersTxt'];} 
                $dropoffout_addr=$row['product_details'][$type]['dropoffout_addr'];
                if($dropoffout_addr=='Others'){ $dropoffout_addr= $row['product_details'][$type]['dropoffout_addrTxt'];} 
                else{$dropoffout_addr.=' '.$row['product_details'][$type]['dropoffout_addrTxt'];}    
                    
                    
                $qty=$row['product_details'][$type]['qty'];
                $price=$row['product_details'][$type]['price'];
                $clientprice=0;
                
                //Check for travek agent Login
                if(isset($user->roles[5]))
                { 
                    //$clientprice=$row['product_details'][$type]['srch']['cust_price'];
                    $clientprice=$price;
                }
                $qtyCont='';
                $qtyCont_client='';
                if($comm_percent!='')
                {
                    $clientprice=$clientprice+(($comm_percent*$clientprice)/100);
                }
                if(isset($row['person_details'][$type]['arrival_tm']) && trim($row['person_details'][$type]['arrival_tm'])=='2')
                {
                    $nigth_rate_comm=$row['product_details'][$type]['srch']['night_rate_comm'];
                    $night_comm_price=($clientprice*$nigth_rate_comm)/100;
                    $clientprice=$clientprice+$night_comm_price;
                    $night_comm_price=($price*$nigth_rate_comm)/100;
                    $price=$price+$night_comm_price;
                }
                if($qty>1)
                {
                    $qtyCont=$qty.' (Qty)  * '.$price.' = ';
                    /*if($comm_percent!='')
                    {
                        $clientprice=$clientprice+(($comm_percent*$clientprice)/100);
                    }*/
                    $qtyCont_client=$qty.' (Qty)  * '.$clientprice.' = ';
                    $price=$price* $qty;
                    $clientprice=$clientprice* $qty;
                }  
                
                
                $driv_details=$row['product_details'][$type]['driv_name'].' - Tel: '.$row['product_details'][$type]['driv_num'];
                  $output_buff='<table  cellspacing="0" cellpadding="0" border="0" >
                    <tbody><tr>
                        <td>
                            <p align="left" class="article-title serviceInfo">Services for '._dt_day($row['product_details'][$type]['serv_day']).' '.$row['product_details'][$type]['serv_day'].'</p>
                            <p align="left" class="article-title">Transfer Out from '.$row['product_details'][$type]['srch']['from'].' to '.$row['product_details'][$type]['srch']['to'].'</p>
                            <div align="left" class="article-content">
                                <p>'.$row['product_details'][$type]['pickup_hr'].':'.$row['product_details'][$type]['pickup_mt'].strtolower($row['product_details'][$type]['pickup_meridian']).' pickup : Meet your '.$row['product_details'][$type]['driv_lang_out'].'-speaking driver in the lobby of the '.$pickout_addr.',</p>
                                <p>Private transfer service with a '.$servtitle.' '.$pickout_addr.' to '.$row['product_details'][$type]['srch']['to'].',</p>    
                                <p>Flight '.$row['product_details'][$type]['airlineout'].' #'.$row['product_details'][$type]['flight_no_out'].' departs at '.$row['product_details'][$type]['decol_hr_out'].':'.$row['product_details'][$type]['decol_mt_out'].strtolower($row['product_details'][$type]['decol_meridian_out']).' flying to '.$row['product_details'][$type]['airport_dept'].',</p>
                                <p>For '.$passengerDetails.' / '.$no_people.' passengers,</p>
				<p>Your driver contact: '.$driv_details.',</p>';
                $output_client.=$output_buff; 
                $output_buff.='<p><div class="fLeftW">'.$editLink.'<a href="javascript:void(0)" onclick="removefromCartPayment('.$id.',\''.$type.'\');"><div  class="remove btn">Remove</div></a></div></div><div class="fRight">Price for this service: '.$qtyCont.'<strong>'.$price.' €uros</strong></div></p>';
                $output_client.='<p><div class="fRight">Price for this service: '.$qtyCont_client.'<strong>'.$clientprice.' €uros</strong></div></p>';
                $output.=$output_buff; 
                                
                      $output_buff='</div>
                        </td>
                    </tr>
                    <tr><td><div class="separator"></div></td></tr>
                </tbody></table>';
                  $output.=$output_buff;
                  $output_client.=$output_buff; 
                  
                  break;
                case "in&out":
                $airport_arrival=$row['product_details'][$type]['in']['airline'];
                if($airport_arrival=='Others'){ $airport_arrival= $row['product_details'][$type]['in']['airline_OthersTxt'];}     
                
                $passengerDetailsin='';
                for($inc=0;$inc<count($row['product_details'][$type]['in']['passengerDetails']);$inc++)
                {
                    if(trim($passengerDetailsin)!=''){$passengerDetailsin.=' and ';}
                    $passengerDetailsin.=$row['product_details'][$type]['in']['passengerDetails'][$inc]['surtitle'];
                    $passengerDetailsin.='.'.$row['product_details'][$type]['in']['passengerDetails'][$inc]['pasengername'];
                    $passengerDetailsin.=' '.$row['product_details'][$type]['in']['passengerDetails'][$inc]['fname'];
                    $passengerDetailsin.=', Tel: '.$row['product_details'][$type]['in']['passengerDetails'][$inc]['tnum'].'.';
                    if(trim($userInfo)!=''){$userInfo.=' and ';}
                    $userInfo.=ucfirst($row['product_details'][$type]['in']['passengerDetails'][$inc]['pasengername']).' '.ucfirst($row['product_details'][$type]['in']['passengerDetails'][$inc]['fname']);

                }
                 $passengerDetailsout='';
                for($inc=0;$inc<count($row['product_details'][$type]['out']['passengerDetails']);$inc++)
                {
                    if(trim($passengerDetailsout)!=''){$passengerDetailsout.=' and ';}
                    $passengerDetailsout.=$row['product_details'][$type]['out']['passengerDetails'][$inc]['surtitle_out'];
                    $passengerDetailsout.='.'.$row['product_details'][$type]['out']['passengerDetails'][$inc]['pasengername_out'];
                    $passengerDetailsout.=' '.$row['product_details'][$type]['out']['passengerDetails'][$inc]['fname_out'];
                    $passengerDetailsout.=' '.$row['product_details'][$type]['out']['passengerDetails'][$inc]['tnum_out'].'.';
                    if(trim($userInfo)!=''){$userInfo.=' and ';}
                    $userInfo.=ucfirst($row['product_details'][$type]['out']['passengerDetails'][$inc]['pasengername_out']).' '.ucfirst($row['product_details'][$type]['out']['passengerDetails'][$inc]['fname_out']);

                }
                
                $no_people=$row['person_details'][$type]['no_people'];
                if($no_people=='Others'){ $no_people= $row['person_details'][$type]['no_people_OthersTxt'];} 
                $dest_addr=$row['product_details'][$type]['in']['dest_addr'];
                if($dest_addr=='Others' || $dest_addr=='others'){ $dest_addr= $row['product_details'][$type]['in']['dest_addr_OthersTxt'];} 
                if(trim($row['product_details'][$type]['in']['dest_addr_OthersTxt'])!=''){$dest_addr.=' '.$row['product_details'][$type]['in']['dest_addr_OthersTxt'];}
                $pickout_addr=$row['product_details'][$type]['out']['pickout_addr'];
                if($pickout_addr=='Others'){ $pickout_addr= $row['product_details'][$type]['out']['pickout_addrTxt'];} 
                else{$pickout_addr.=' '.$row['product_details'][$type]['out']['pickout_addrTxt'];} 
                
                $dropoffout_addr=$row['product_details'][$type]['out']['dropoffout_addr'];
                if($dropoffout_addr=='Others'){ $dropoffout_addr= $row['product_details'][$type]['out']['dropoffout_addrTxt'];} 
                else{$dropoffout_addr.=' '.$row['product_details'][$type]['out']['dropoffout_addrTxt'];}    
                    
                $airport_dept=$row['product_details'][$type]['out']['airlineout'];
                if($airport_dept=='Others'){ $airport_dept= $row['product_details'][$type]['out']['airlineout_OthersTxt'];}     
                
                
                $qty=$row['product_details'][$type]['qty'];
                $price=$row['product_details'][$type]['price'];
                $clientprice=0;
                
                //Check for travek agent Login
                if(isset($user->roles[5]))
                { 
                    //$clientprice=$row['product_details'][$type]['srch']['cust_price'];
                    $clientprice=$price;
                }
                $qtyCont='';
                $qtyCont_client='';
                if($comm_percent!='')
                {
                    $clientprice=$clientprice+(($comm_percent*$clientprice)/100);
                }
                
                
                $night_comm_price=0;
                $night_comm_price_clt=0;
                $nigth_rate_comm=$row['product_details'][$type]['srch']['night_rate_comm'];
                $night_comm_price_clt=(($clientprice/2)*$nigth_rate_comm)/100;
                $night_comm_price=(($price/2)*$nigth_rate_comm)/100;
                if(isset($row['person_details'][$type]['arrival_tm']) && trim($row['person_details'][$type]['arrival_tm'])=='2')
                {                  
                    $clientprice=$clientprice+$night_comm_price_clt;
                    $price=$price+$night_comm_price;
                }
                
                //Check for nightservice applied in out service for IN&OUT or COMMUTE
                if(isset($row['product_details'][$type]['out']['decol_hr_out']) && isset($row['product_details'][$type]['out']['decol_meridian_out']) && trim($row['product_details'][$type]['out']['decol_hr_out'])!='' && trim($row['product_details'][$type]['out']['decol_meridian_out'])!='') {
                    $hr=trim($row['product_details'][$type]['out']['decol_hr_out']); 
                    $meridian=trim($row['product_details'][$type]['out']['decol_meridian_out']);
                    if(chknightService($hr, $meridian))
                    {
                        $clientprice=$clientprice+$night_comm_price_clt;
                        $price=$price+$night_comm_price;
                    }
                }
                
                
                if($qty>1)
                {
                    $qtyCont=$qty.' (Qty)  * '.$price.' = ';
                    /*if($comm_percent!='')
                    {
                        $clientprice=$clientprice+(($comm_percent*$clientprice)/100);
                    }*/
                    $qtyCont_client=$qty.' (Qty)  * '.$clientprice.' = ';
                    $price=$price* $qty;
                    $clientprice=$clientprice* $qty;
                } 
                
                
                $driv_details=$row['product_details'][$type]['driv_name'].' - Tel: '.$row['product_details'][$type]['driv_num'];
                
                  $output_buff='<table  cellspacing="0" cellpadding="0" border="0" >
                    <tbody><tr>
                        <td>
                            <p align="left" class="article-title serviceInfo">Services for '._dt_day($row['product_details'][$type]['in']['arriv_day']).' '.$row['product_details'][$type]['in']['arriv_day'].'</p>
                            <p align="left" class="article-title">Transfer In from '.$row['product_details'][$type]['srch']['from'].' to '.$row['product_details'][$type]['srch']['to'].'</p>
                            <div align="left" class="article-content">
                                <p>Flight '.$airport_arrival.' #'.$row['product_details'][$type]['in']['flight_no'].' arrives at '.$row['product_details'][$type]['in']['arriv_hr'].':'.$row['product_details'][$type]['in']['arriv_mt'].strtolower($row['product_details'][$type]['in']['arriv_meridian']).' coming from '.$row['product_details'][$type]['srch']['from'].',</p>
                                <p>'.$row['product_details'][$type]['in']['arriv_hr'].':'.$row['product_details'][$type]['in']['arriv_mt'].strtolower($row['product_details'][$type]['in']['arriv_meridian']).' Meet your '.$row['product_details'][$type]['in']['driv_lang'].'-speaking driver at '.$row['product_details'][$type]['in']['ariport_origin'].' upon arrival,</p>
                                <p>Private transfer service with a '.$servtitle.' from '.$row['product_details'][$type]['in']['ariport_origin'].' to '.$dest_addr.',</p>
                                <p>For '.$passengerDetailsin.' / '.$no_people.' passengers,</p>
				<p>Your driver contact: '.$driv_details.',</p>       
                            </div>
                            <p align="left" class="article-title serviceInfo">Services for '._dt_day($row['product_details'][$type]['out']['serv_day']).' '.$row['product_details'][$type]['out']['serv_day'].'</p>
                            <p align="left" class="article-title" >Transfer Out from '.$row['product_details'][$type]['srch']['to'].' to '.$row['product_details'][$type]['srch']['from'].'</p>
                            <div align="left" class="article-content">
                                <p>'.$row['product_details'][$type]['out']['pickup_hr'].':'.$row['product_details'][$type]['out']['pickup_mt'].strtolower($row['product_details'][$type]['out']['pickup_meridian']).' pickup : Meet your '.$row['product_details'][$type]['out']['driv_lang_out'].'-speaking driver in the lobby of the '.$pickout_addr.',</p>
                                <p>Private transfer service with a '.$servtitle.' '.$pickout_addr.' to '.$row['product_details'][$type]['srch']['from'].',</p>    
                                <p>Flight '.$airport_dept.' #'.$row['product_details'][$type]['out']['flight_no_out'].' departs at '.$row['product_details'][$type]['out']['decol_hr_out'].':'.$row['product_details'][$type]['out']['decol_mt_out'].strtolower($row['product_details'][$type]['out']['decol_meridian_out']).' flying to '.$row['product_details'][$type]['out']['airport_dept'].',</p>
                                <p>For '.$passengerDetailsout.' / '.$no_people.' passengers,</p>
				<p>Your driver contact: '.$driv_details.',</p>';
                $output_client.=$output_buff; 
                $output_buff.='<p><div class="fLeftW">'.$editLink.'<a href="javascript:void(0)" onclick="removefromCartPayment('.$id.',\''.$type.'\');"><div  class="remove btn">Remove</div></a></div></div><div class="fRight">Price for this service: '.$qtyCont.'<strong>'.$price.' €uros</strong></div></p>';
                $output_client.='<p><div class="fRight">Price for this service: '.$qtyCont_client.'<strong>'.$clientprice.' €uros</strong></div></p>';
                $output.=$output_buff; 
                        $output_buff='</div>
                        </td>
                    </tr>
                    <tr><td><div class="separator"></div></td></tr>
                </tbody></table>';
                  $output.=$output_buff;
                  $output_client.=$output_buff; 
                  break;            
                }
              break;
            case "meet_greet":               
               switch (trim($row['product_details'][$type]['typeTransfer']))
                {
                case "IN":
                $airport_arrival=$row['product_details'][$type]['airline'];
                if($airport_arrival=='Others'){ $airport_arrival= $row['product_details'][$type]['airline_OthersTxt'];}     
                   
                $qty=$row['product_details'][$type]['qty'];
                $price=$row['product_details'][$type]['price'];
                $clientprice=0;
                
                //Check for travek agent Login
                if(isset($user->roles[5]))
                { 
                    if(trim($row['product_details']['serv_type'])=='meet_greet')
                    {
                       if($row['product_details'][$type]['srch']['applied']=='weekday')                   
                       $clientprice=$row['product_details'][$type]['srch']['custday_price']; 
                       else
                       $clientprice=$row['product_details'][$type]['srch']['custend_price']; 
                       
                       $price=$clientprice;
                    }
                    else
                    {
                        //$clientprice=$row['product_details'][$type]['srch']['cust_price'];
                        $clientprice=$price;
                    }
                    
                }
                $qtyCont='';
                $qtyCont_client='';
                if($comm_percent!='')
                {
                    $clientprice=$clientprice+(($comm_percent*$clientprice)/100);
                }
                 if(isset($row['person_details'][$type]['arrival_tm']) && trim($row['person_details'][$type]['arrival_tm'])=='2')
                {
                    $nigth_rate_comm=$row['product_details'][$type]['srch']['night_rate_comm'];
                    $night_comm_price=($clientprice*$nigth_rate_comm)/100;
                    $clientprice=$clientprice+$night_comm_price;
                    $night_comm_price=($price*$nigth_rate_comm)/100;
                    $price=$price+$night_comm_price;
                }
                if($qty>1)
                {
                    $qtyCont=$qty.' (Qty)  * '.$price.' = ';
                    /*if($comm_percent!='')
                    {
                        $clientprice=$clientprice+(($comm_percent*$clientprice)/100);
                    }*/
                    $qtyCont_client=$qty.' (Qty)  * '.$clientprice.' = ';
                    $price=$price* $qty;
                    $clientprice=$clientprice* $qty;
                } 
               
                
                $resrow=$row['product_details'][$type];
                
                $passengerDetailsin='';
                for($inc=0;$inc<count($resrow['passengerDetails']);$inc++)
                {
                    if(trim($passengerDetailsin)!=''){$passengerDetailsin.=' and ';}
                    $passengerDetailsin.=$resrow['passengerDetails'][$inc]['surtitle'];
                    $passengerDetailsin.='.'.$resrow['passengerDetails'][$inc]['pasengername'];
                    $passengerDetailsin.=' '.$resrow['passengerDetails'][$inc]['fname'];
                    $passengerDetailsin.=', Tel: '.$resrow['passengerDetails'][$inc]['tnum'].'.';
                    if(trim($userInfo)!=''){$userInfo.=' and ';}
                    $userInfo.=ucfirst($resrow['passengerDetails'][$inc]['pasengername']).' '.ucfirst($resrow['passengerDetails'][$inc]['fname']);

                }
                $no_people=$row['person_details'][$type]['no_people'];
                if($no_people=='Others'){ $no_people= $row['person_details'][$type]['no_people_OthersTxt'];} 
                
                
                $odd_bag=$row['person_details'][$type]['odd_bag'];
                if($odd_bag=='Others'){ $odd_bag= $row['person_details'][$type]['odd_bag_OthersTxt'];} 
                $driv_details=$resrow['driv_name'].' - Tel: '.$resrow['driv_num'];
                  $output_buff='<table  cellspacing="0" cellpadding="0" border="0" >
                    <tbody><tr>
                        <td>
                            <p align="left" class="article-title serviceInfo">Services for '._dt_day($resrow['arriv_day']).' '.$resrow['arriv_day'].' </p>
                            <p align="left" class="article-title">Meet & Greet In, at '.$resrow['ariport_origin'].' in '.$resrow['srch']['selectregion'].'</p>    
                            <div align="left" class="article-content">
                                <p>'.$resrow['arriv_hr'].':'.$resrow['arriv_mt'].strtolower($resrow['arriv_meridian']).' Meet your '.$resrow['driv_lang'].'-speaking hostess on the jetway on the gate of your aircraft upon arrival at '.$resrow['ariport_origin'].' in '.$resrow['srch']['selectregion'].',</p>
                                <p>Flight '.$airport_arrival.' #'.$resrow['flight_no'].' arrives at '.$resrow['arriv_hr'].':'.$resrow['arriv_mt'].strtolower($resrow['arriv_meridian']).' coming from '.$resrow['ariport_origin'].',</p>
                                <p>For '.$passengerDetailsin.' / '.$no_people.' passengers,</p>
				<p>'.$row['person_details'][$type]['regular_bag'].' regular piece(s) to be Handled,</p>
                                <p>'.$odd_bag.' Odd piece(s) to be Handled,</p>
                                <p>Your Hostess contact at airport : '.$driv_details.',</p>';
                $output_client.=$output_buff; 
                $output_buff.='<p><div class="fLeftW">'.$editLink.'<a href="javascript:void(0)" onclick="removefromCartPayment('.$id.',\''.$type.'\');"><div  class="remove btn">Remove</div></a></div></div><div class="fRight">Price for this service: '.$qtyCont.'<strong>'.$price.' €uros</strong></div></p>';
                $output_client.='<p><div class="fRight">Price for this service: '.$qtyCont_client.'<strong>'.$clientprice.' €uros</strong></div></p>';
                $output.=$output_buff; 
                    $output_buff='</div>
                        </td>
                    </tr>
                    <tr><td><div class="separator"></div></td></tr>
                </tbody></table>';
                  $output.=$output_buff;
                  $output_client.=$output_buff;
                  break;
                case "Out":
                $qty=$row['product_details'][$type]['qty'];
                $price=$row['product_details'][$type]['price'];
                $clientprice=0;
                
                //Check for travek agent Login
                if(isset($user->roles[5]))
                { 
                    if(trim($row['product_details']['serv_type'])=='meet_greet')
                    {
                       if($row['product_details'][$type]['srch']['applied']=='weekday')                   
                       $clientprice=$row['product_details'][$type]['srch']['custday_price']; 
                       else
                       $clientprice=$row['product_details'][$type]['srch']['custend_price']; 
                       
                       $price=$clientprice;
                    }
                    else
                    {
                        //$clientprice=$row['product_details'][$type]['srch']['cust_price'];
                        $clientprice=$price;
                    }
                    
                }
                $qtyCont='';
                $qtyCont_client='';
                if($comm_percent!='')
                {
                    $clientprice=$clientprice+(($comm_percent*$clientprice)/100);
                }
                if(isset($row['person_details'][$type]['arrival_tm']) && trim($row['person_details'][$type]['arrival_tm'])=='2')
                {
                    $nigth_rate_comm=$row['product_details'][$type]['srch']['night_rate_comm'];
                    $night_comm_price=($clientprice*$nigth_rate_comm)/100;
                    $clientprice=$clientprice+$night_comm_price;
                    $night_comm_price=($price*$nigth_rate_comm)/100;
                    $price=$price+$night_comm_price;
                }
                
                if($qty>1)
                {
                    $qtyCont=$qty.' (Qty)  * '.$price.' = ';
                    /*if($comm_percent!='')
                    {
                        $clientprice=$clientprice+(($comm_percent*$clientprice)/100);
                    }*/
                    $qtyCont_client=$qty.' (Qty)  * '.$clientprice.' = ';
                    $price=$price* $qty;
                    $clientprice=$clientprice* $qty;
                } 
                
                $resrow=$row['product_details'][$type];
                
                $airport_arrival=$resrow['airlineout'];
                if($airport_arrival=='Others'){ $airport_arrival= $resrow['airlineout_OthersTxt'];}     
                 
                
                $no_people=$row['person_details'][$type]['no_people'];
                if($no_people=='Others'){ $no_people= $row['person_details'][$type]['no_people_OthersTxt'];} 
                
                $passengerDetailsout='';
                for($inc=0;$inc<count($resrow['passengerDetails']);$inc++)
                {
                    if(trim($passengerDetailsout)!=''){$passengerDetailsout.=' and ';}
                    $passengerDetailsout.=$resrow['passengerDetails'][$inc]['surtitle_out'];
                    $passengerDetailsout.='.'.$resrow['passengerDetails'][$inc]['pasengername_out'];
                    $passengerDetailsout.=' '.$resrow['passengerDetails'][$inc]['fname_out'];
                    $passengerDetailsout.=', Tel: '.$resrow['passengerDetails'][$inc]['tnum_out'].'.';
                    if(trim($userInfo)!=''){$userInfo.=' and ';}
                    $userInfo.=ucfirst($resrow['passengerDetails'][$inc]['pasengername_out']).' '.ucfirst($resrow['passengerDetails'][$inc]['fname_out']);
                }
                
                $airport_depture=$resrow['airport_dept'];
                if($airport_depture=='others'){ $airport_depture= $resrow['airport_dept_OthersTxt'];}
               
                $odd_bag=$row['person_details'][$type]['odd_bag'];
                if($odd_bag=='Others'){ $odd_bag= $row['person_details'][$type]['odd_bag_OthersTxt'];}
                $driv_details=$resrow['driv_name'].' - Tel: '.$resrow['driv_num'];
                  $output_buff='<table  cellspacing="0" cellpadding="0" border="0" >
                    <tbody><tr>
                        <td>
                            <p align="left" class="article-title serviceInfo">Services for '._dt_day($resrow['serv_day']).' '.$resrow['serv_day'].'</p>
                            <p align="left" class="article-title">Meet & Greet Out, at '.$airport_depture.' in '.$resrow['srch']['selectregion'].'</p>
                            <div align="left" class="article-content">
                                <p>Flight '.$airport_arrival.' #'.$resrow['flight_no_out'].' departs at '.$resrow['arrivout_hr'].':'.$resrow['arrivout_mt'].strtolower($resrow['arrivout_meridian']).' flying to '.$airport_depture.' in '.$resrow['srch']['selectregion'].',</p>
                                <p>Meet your '.$resrow['driv_lang_out'].'-speaking of the hostess upon arrival at '.strtolower($resrow['arriv_estim_tm']).',</p>
                                <p>Estimated arrival time at the airport: '.strtolower($resrow['arriv_estim_tm']).',</p>    
                                <p>For '.$passengerDetailsout.' / '.$no_people.' passengers,</p>
				<p>'.$row['person_details'][$type]['regular_bag'].' regular piece(s) to be Handled,</p>
                                <p>'.$odd_bag.' Odd piece(s) to be Handled,</p>
                                <p>Your Hostess contact at airport : '.$driv_details.',</p>';
                $output_client.=$output_buff; 
                $output_buff.='<p><div class="fLeftW">'.$editLink.'<a href="javascript:void(0)" onclick="removefromCartPayment('.$id.',\''.$type.'\');"><div  class="remove btn">Remove</div></a></div></div><div class="fRight">Price for this service: '.$qtyCont.'<strong>'.$price.' €uros</strong></div></p>';
                $output_client.='<p><div class="fRight">Price for this service: '.$qtyCont_client.'<strong>'.$clientprice.' €uros</strong></div></p>';
                $output.=$output_buff; 
                    $output_buff='</div>
                        </td>
                    </tr>
                    <tr><td><div class="separator"></div></td></tr>
                </tbody></table>';
                  $output.=$output_buff;
                  $output_client.=$output_buff;
                  break;
                case "Commute":
                $qty=$row['product_details'][$type]['qty'];
                $price=$row['product_details'][$type]['price'];
                $clientprice=0;
                
                //Check for travek agent Login
                if(isset($user->roles[5]))
                { 
                    if(trim($row['product_details']['serv_type'])=='meet_greet')
                    {
                       if($row['product_details'][$type]['srch']['applied']=='weekday')                   
                       $clientprice=$row['product_details'][$type]['srch']['custday_price']; 
                       else
                       $clientprice=$row['product_details'][$type]['srch']['custend_price']; 
                       
                       $price=$clientprice;
                    }
                    else
                    {
                        //$clientprice=$row['product_details'][$type]['srch']['cust_price'];
                        $clientprice=$price;
                    }
                    
                    
                }
                $qtyCont='';
                $qtyCont_client='';
                if($comm_percent!='')
                {
                    $clientprice=$clientprice+(($comm_percent*$clientprice)/100);
                }
                
                $night_comm_price=0;
                $night_comm_price_clt=0;
                $nigth_rate_comm=$row['product_details'][$type]['srch']['night_rate_comm'];
                
                if(isset($row['person_details'][$type]['arrival_tm']) && trim($row['person_details'][$type]['arrival_tm'])=='2')
                {
                    
                    $night_comm_price_clt=(($clientprice/2)*$nigth_rate_comm)/100;               
                    $clientprice=$clientprice+$night_comm_price_clt;
                    $night_comm_price=(($price/2)*$nigth_rate_comm)/100;
                    $price=$price+$night_comm_price;
                }
                
                //Check for nightservice applied in out service for IN&OUT or COMMUTE
                if(isset($row['product_details'][$type]['out']['decol_hr_out']) && isset($row['product_details'][$type]['out']['decol_meridian_out']) && trim($row['product_details'][$type]['out']['decol_hr_out'])!='' && trim($row['product_details'][$type]['out']['decol_meridian_out'])!='') {
                    $hr=trim($row['product_details'][$type]['out']['decol_hr_out']); 
                    $meridian=trim($row['product_details'][$type]['out']['decol_meridian_out']);
                    if(chknightService($hr, $meridian))
                    {
                        $clientprice=$clientprice+$night_comm_price_clt;
                        $price=$price+$night_comm_price;
                    }
                }
                if($qty>1)
                {
                    $qtyCont=$qty.' (Qty)  * '.$price.' = ';
                    /*if($comm_percent!='')
                    {
                        $clientprice=$clientprice+(($comm_percent*$clientprice)/100);
                    }*/
                    $qtyCont_client=$qty.' (Qty)  * '.$clientprice.' = ';
                    $price=$price*$qty;
                    $clientprice=$clientprice*$qty;
                }
                
                
                $resrow=$row['product_details'][$type]['IN'];
                
                $passengerDetailsin='';
                for($inc=0;$inc<count($resrow['passengerDetails']);$inc++)
                {
                    if(trim($passengerDetailsin)!=''){$passengerDetailsin.=' and ';}
                    $passengerDetailsin.=$resrow['passengerDetails'][$inc]['surtitle'];
                    $passengerDetailsin.='.'.$resrow['passengerDetails'][$inc]['pasengername'];
                    $passengerDetailsin.=' '.$resrow['passengerDetails'][$inc]['fname'];
                    $passengerDetailsin.=', Tel: '.$resrow['passengerDetails'][$inc]['tnum'].'.';
                    if(trim($userInfo)!=''){$userInfo.=' and ';}
                    $userInfo.=ucfirst($resrow['passengerDetails'][$inc]['pasengername']).' '.ucfirst($resrow['passengerDetails'][$inc]['fname']);
                }
                $no_people=$row['person_details'][$type]['no_people'];
                if($no_people=='Others'){ $no_people= $row['person_details'][$type]['no_people_OthersTxt'];} 
                
                $airport_arrival=$resrow['airline'];
                if($airport_arrival=='Others'){ $airport_arrival= $resrow['airline_OthersTxt'];}
                
                 
                
                $odd_bag=$row['person_details'][$type]['odd_bag'];
                if($odd_bag=='Others'){ $odd_bag= $row['person_details'][$type]['odd_bag_OthersTxt'];} 
                
                $resrowout=$row['product_details'][$type]['Out'];
                $passengerDetails='';
                for($inc=0;$inc<count($resrowout['passengerDetails']);$inc++)
                {
                    if(trim($passengerDetails)!=''){$passengerDetails.=' and ';}
                    $passengerDetails.=$resrowout['passengerDetails'][$inc]['surtitle_out'];
                    $passengerDetails.='.'.$resrowout['passengerDetails'][$inc]['pasengername_out'];
                    $passengerDetails.=' '.$resrowout['passengerDetails'][$inc]['fname_out'];
                    $passengerDetails.=', Tel: '.$resrowout['passengerDetails'][$inc]['tnum_out'].'.';
                    
                }
                
                $airport_dept=$resrowout['airlineout'];
                if($airport_dept=='Others'){ $airport_dept= $resrowout['airlineout_OthersTxt'];} 
                
                $airport_depture=$resrowout['airport_dept'];
                if($airport_depture=='others'){ $airport_depture= $resrowout['airport_dept_OthersTxt'];}
                $driv_details=$row['product_details'][$type]['driv_name'].' - Tel: '.$row['product_details'][$type]['driv_num'];
                
                  $output_buff='<table  cellspacing="0" cellpadding="0" border="0" >
                    <tbody><tr>
                        <td>
                            <p align="left" class="article-title serviceInfo">Services for '._dt_day($resrow['arriv_day']).' '.$resrow['arriv_day'].' </p>
                            <p align="left" class="article-title">Meet & Greet In, at '.$resrow['ariport_origin'].' in '.$row['product_details'][$type]['srch']['selectregion'].'</p>    
                            <div align="left" class="article-content">
                                 <p>'.$resrow['arriv_hr'].':'.$resrow['arriv_mt'].strtolower($resrow['arriv_meridian']).' Meet your '.$resrow['driv_lang'].'-speaking hostess on the jetway on the gate of your aircraft upon arrival at '.$resrow['ariport_origin'].' in '.$row['product_details'][$type]['srch']['selectregion'].',</p>
                                <p>Flight '.$airport_arrival.' #'.$resrow['flight_no'].' arrives at '.$resrow['arriv_hr'].':'.$resrow['arriv_mt'].strtolower($resrow['arriv_meridian']).' coming from  '.$resrow['ariport_origin'].',</p>
                                <p>For '.$passengerDetailsin.' / '.$no_people.' passengers,</p>
				<p>'.$row['person_details'][$type]['regular_bag'].' regular piece(s) to be Handled,</p>
                                <p>'.$odd_bag.' Odd piece(s) to be Handled,</p>
                                <p>Your Hostess contact at airport : '.$driv_details.',</p>
                            </div>
                            <p align="left" class="article-title serviceInfo">Services for '._dt_day($resrowout['serv_day']).' '.$resrowout['serv_day'].' </p>
                            <p align="left" class="article-title">Meet & Greet Out, at '.$airport_depture.' in '.$row['product_details'][$type]['srch']['selectregion'].'</p>
                            <div align="left" class="article-content">
                               <p>Flight '.$resrowout['airlineout'].' #'.$resrowout['flight_no_out'].' departs at '.$resrowout['arrivout_hr'].':'.$resrowout['arrivout_mt'].strtolower($resrowout['arrivout_meridian']).' flying to '.$airport_depture.' in '.$row['product_details'][$type]['srch']['selectregion'].',</p>
                                <p>Meet your '.$resrowout['driv_lang_out'].'-speaking of the hostess upon arrival at '.strtolower($resrowout['arriv_estim_tm']).',</p>
                                <p>Estimated arrival time at the airport: '.  strtolower($resrowout['arriv_estim_tm']).',</p>
                                <p>For '.$passengerDetails.' / '.$no_people.' passengers,</p>
				<p>'.$row['person_details'][$type]['regular_bag'].' regular piece(s) to be Handled,</p>
                                <p>'.$odd_bag.' Odd piece(s) to be Handled,</p>
                                <p>Your Hostess contact at airport : '.$driv_details.',</p>';
                  
                  
                  
                $output_client.=$output_buff; 
                $output_buff.='<p><div class="fLeftW">'.$editLink.'<a href="javascript:void(0)" onclick="removefromCartPayment('.$id.',\''.$type.'\');"><div  class="remove btn">Remove</div></a></div></div><div class="fRight">Price for this service: '.$qtyCont.'<strong>'.$price.' €uros</strong></div></p>';
                $output_client.='<p><div class="fRight">Price for this service: '.$qtyCont_client.'<strong>'.$clientprice.' €uros</strong></div></p>';
                $output.=$output_buff; 
                         $output_buff='</div> 
                        </td>
                    </tr>
                    <tr><td><div class="separator"></div></td></tr>
                </tbody></table>';
                  $output.=$output_buff;
                  $output_client.=$output_buff;
                  }
                  break; 
              break;
            case "driver_at_disposal":               
              if(trim($row['product_details'][$type]['typeTransfer'])=='driv')
              {
                $qty=$row['product_details'][$type]['qty'];
                $price=$row['product_details'][$type]['price'];
                $clientprice=0;
                
                //Check for travel agent Login
                if(isset($user->roles[5]))
                { 
                   // $custclientprice=$row['product_details'][$type]['srch']['cust_price'];
                    $clientprice=$price;
                }
                $qtyCont='';
                $qtyCont_client='';
                if($comm_percent!='')
                {
                    $clientprice=$clientprice+(($comm_percent*$clientprice)/100);
                }
                if(isset($row['person_details'][$type]['arrival_tm']) && trim($row['person_details'][$type]['arrival_tm'])=='2')
                {
                    $nigth_rate_comm=$row['product_details'][$type]['srch']['night_rate_comm'];
                    $night_comm_price=($clientprice*$nigth_rate_comm)/100;
                    $clientprice=$clientprice+$night_comm_price;
                    $night_comm_price=($price*$nigth_rate_comm)/100;
                    $price=$price+$night_comm_price;
                }
                
                if($qty>1)
                {
                    $qtyCont=$qty.' (Qty)  * '.$price.' = ';
                    /*if($comm_percent!='')
                    {
                        $clientprice=$clientprice+(($comm_percent*$clientprice)/100);
                    }*/
                    $qtyCont_client=$qty.' (Qty)  * '.$clientprice.' = ';
                    $price=$price* $qty;
                    $clientprice=$clientprice* $qty;
                } 
                
                $resrow=$row['product_details'][$type];
                
                $passengerDetails='';
                for($inc=0;$inc<count($resrow['passengerDetails']);$inc++)
                {
                    if(trim($passengerDetails)!=''){$passengerDetails.=' and ';}
                    $passengerDetails.=$resrow['passengerDetails'][$inc]['surtitle'];
                    $passengerDetails.='.'.$resrow['passengerDetails'][$inc]['pasengername'];
                    $passengerDetails.=' '.$resrow['passengerDetails'][$inc]['fname'];
                    $passengerDetails.=', Tel: '.$resrow['passengerDetails'][$inc]['tnum'].'.';
                    if(trim($userInfo)!=''){$userInfo.=' and ';}
                    $userInfo.=ucfirst($resrow['passengerDetails'][$inc]['pasengername']).' '.ucfirst($resrow['passengerDetails'][$inc]['fname']);
                }
                $pick_addr=$resrow['pick_addr'];
                if($pick_addr=='Others'){ $pick_addr= $resrow['pick_addr_OthersTxt'];} 
                else{$pick_addr.=' '.$resrow['pick_addr_OthersTxt'];} 
                
                $dest_addr=$resrow['dest_addr'];
                if($dest_addr=='Others'){ $dest_addr= $resrow['dest_addr_OthersTxt'];} 
                else{$dest_addr.=' '.$resrow['dest_addr_OthersTxt'];} 
                
                $endserv_addr=$resrow['endserv_addr'];
                if($endserv_addr=='Others'){ $endserv_addr= $resrow['endserv_addr_OthersTxt'];} 
                else{$endserv_addr.=' '.$resrow['endserv_addr_OthersTxt'];} 
              $driv_details=$resrow['driv_name'].' - '.$resrow['driv_num'];  
              $output_buff='<table  cellspacing="0" cellpadding="0" border="0" >
                    <tbody><tr>
                        <td>
                           <p align="left" class="article-title serviceInfo">Services for '._dt_day($resrow['service_day']).' '.$resrow['service_day'].'</p>
                            <div align="left" class="article-content">
                                <p>Guest: '.$passengerDetails.'</p>
                                <p>'.$resrow['dept_hr'].':'.$resrow['dept_mt'].strtolower($resrow['dept_meridian']).' pickup : Meet your '.$resrow['driv_lang'].'-speaking driver in the lobby of your pickup address : '.$pick_addr.'.</p>
                                <p>For a '.$resrow['arriv_hr'].':'.$resrow['arriv_mt'].' '.$resrow['arriv_meridian'].' - '.$resrow['dept_hr'].':'.$resrow['dept_mt'].' '.$resrow['dept_meridian'].' hours chauffeur service to '.$dest_addr.'</p>
				<p>End of service: '.$resrow['dept_hr'].':'.$resrow['dept_mt'].' '.$resrow['dept_meridian'].' hours</p>
                                <p>Address of end of service and drop off: '.$endserv_addr.'</p>
                                <p>Your Hostess contact at airport Tel: '.$driv_details.'</p>   
                                <p>Special request for the day : '.$resrow['spl_comment'].'</p>';
                $output_client.=$output_buff; 
                $output_buff.='<p><div class="fLeftW">'.$editLink.'<a href="javascript:void(0)" onclick="removefromCartPayment('.$id.',\''.$type.'\');"><div  class="remove btn">Remove</div></a></div></div><div class="fRight">Price for this service: '.$qtyCont.'<strong>'.$price.' €uros</strong></div></p>';
                $output_client.='<p><div class="fRight">Price for this service: '.$qtyCont_client.'<strong>'.$clientprice.' €uros</strong></div></p>';
                $output.=$output_buff;
                            $output_buff='</div>
                        </td>
                    </tr>
                    <tr><td><div class="separator"></div></td></tr>
                </tbody></table>';
              $output.=$output_buff;
              $output_client.=$output_buff;
              break;  
              }
            }
            
            $output.='</tr>
    </tbody></table>';
            $output_client.='</tr>
    </tbody></table>';
            
           }
        
                
                
                
                
              $retval[]=$key.$type;
            }
        }
    }
    $comm=$tot_price-$subtot_price;
    
   
    if(isset($user->roles[5]))
    {
        /*
        if(isset($cart['comm_percent']) && trim($cart['comm_percent'])!='')
        {
            $tot_price_comm=($tot_price*$cart['comm_percent'])/100;
            $tot_price+=$tot_price_comm;
        }*/
        
        $tot_price=$subtot_price;
        $extracommsion='';
        if($comm_percent!='')
        {
            $extracommsion=(($comm_percent*$tot_price)/100);
            $tot_price=$tot_price+(($comm_percent*$tot_price)/100);
        }
         //$output_client=$output;
         $output.='</div> <table id="gotocommission" cellspacing="0" cellpadding="0" border="0">
                    <tbody><tr style="border-top: none;">
                        <td ><a name="gotocommission"></a>
                            <div align="left" class="article-content">
                                <p style="float:right;text-align: right;margin:0;line-height:25px;">
                                    <strong>Net price:'.$subtot_price.' €uros<br/>Commission<span class="req">*</span>: <select name="commission" id="commission" onchange="commissionUpdate(this)">
                                    <option value="" selected="selected">Select</option>';
                                     //$res_commission=db_query("SELECT title from node WHERE type='travel_agent_commission'");
                                     $res_commission=node_load(997);
                                     foreach ($res_commission->field_commision_['und'] as $record) {
                                        $pick_comm='';
                                        $record['value']=str_replace(".00", '', $record['value']);
                                        if(isset($_SESSION['comm_percent']) && trim($_SESSION['comm_percent'])==$record['value'])
                                        {
                                            $pick_comm='selected="selected"';
                                        }
                                        $output.='<option value="'.$record['value'].'" '.$pick_comm.'>'.$record['value'].'</option>';
                                     }
                                    $output.='</select> %<br/><!--<span id="comm_amt_agt">'.$comm.'</span> €uros<br/>-->';
                                    if($extracommsion!='')
                                    {
                                        $output.='<span >Commission : '.$extracommsion.'</span> €uros<br/>';
                                    }
                                    $output.='<div class="blueTagR">Total price including your Commission:<span id="total_amt_comm_agt">'.$tot_price.'</span> €uros</div>
                                    </strong>
                                </p>
                            </div>
                            <input type="hidden" name="tot_price" id="tot_price" value="'.$tot_price.'" />
                            <input type="hidden" name="comm_amt_agt" id="comm_amt_agt" value="" />
                            <input type="hidden" name="total_amt_comm_agt" id="total_amt_comm_agt" value=""/>

                        </td>
                    </tr>
                    <tr><td width="580" height="10" class="w580"></td></tr>
                </tbody></table>
                 <div id="customerinfo">
                <div class="blueTagL    ">Customer information</div>
                <div>If you desire to send the voucher to your customer, fill the box below</div>
                <div>E-mail address of the end customer: <input type="text" id="client_email" name="client_email"/></div>
                </div>';
        $output_client.='</div> <table cellspacing="0" cellpadding="0" border="0">
                    <tbody><tr style="border-top: none;">
                        <td >
                            <div align="left" class="article-content">
                                <p style="float:right;text-align: right;">
                                    <strong>Total Price for the above services:'.$tot_price.' €uros
                                    </strong>
                                    
                                </p>
                            </div>
                        </td>
                    </tr>
                    <tr><td width="580" height="10" class="w580"></td></tr>
                </tbody></table>'; 
        $reviewCart='<div class="invTitle">Review your cart & Payment</div>';
        $custInvoice='<p><div class="invTitle">Customer Invoice</div><br/>Our reference:  (file number  from the system)<br/>
    Clients Name: '.$userInfo.'<br/>
   Agent: '.$agentUserName.'. / '.$agentName.' <br/>
    Agency: '.$agencyName.'<br/></p>'; 
    $travagtCommInvoice='<p><div class="invTitle">Travel Agent Commission Invoice</div><br/>Our reference:  (file number  from the system)<br/>
    Clients Name: '.$userInfo.'<br/>
    Agent: '.$agentUserName.'. / '.$agentName.'<br/>
    Agency: '.$agencyName.'<br/></p>'; 
    $passtravDoc='<p><div class="invTitle">Passengers Travel Document </div><br/>Our reference:  (file number  from the system)<br/>
    Clients Name: '.$userInfo.'<br/>
    Agent: '.$agentUserName.'. / '.$agentName.'<br/>
    Agency: '.$agencyName.'<br/><br/>
    Dear '.$userInfo.',<br/>
    It is my pleasure on behalf of Découvertes to wish you a safe and enjoyable journey in France.  I hope that you are looking forward to your visit here!<br/><br/>
    Should you need to contact Découvertes for whatever reason during your stay, below are our Office Hours and contact information.<br/><br/>
    Office Hours: Monday to Friday 9.30am – 7.00pm<br/>
    Office Direct Line: +33 (0)4 4250 3564<br/>
    Découvertes’ 24/7 contact number: +33(0)6 1406 1967<br/><br/>
    It has been a pleasure for us to help you  organize your stay in France.  Should you wish to add anything or have any questions concerning your itinerary, please do not hesitate to contact us and we will do our utmost to accommodate you.<br/><br/>
    Have a wonderful stay in France!<br/><br/>
    Very best regards,<br/>
    Découvertes\' team. </p>'; 
        
        $outputContent .='<div class="tabs">
        <div id="tab1"> <a id="tab1link" class="act invoiceTab">Review your cart & Payment</a>
                       <a id="tab2link" class="disact invoiceTab">Customer Invoice</a>
                       <a id="tab3link" class="disact invoiceTab">Travel Agent Commission Invoice</a>
                       <a id="tab4link" class="disact invoiceTab">Passengers Travel Document </a>
        </div>
        <div id="cont_tab1link" class="invoiceContent" style="display:block;" >'.str_replace("[INVOICE]",$reviewCart,$output).'</div>
        <div id="cont_tab2link" class="invoiceContent"></div>
        <div id="cont_tab3link" class="invoiceContent"></div>
        <div id="cont_tab4link" class="invoiceContent"></div>  
       </div>
       ';
          
        
        
    }
    else
    {
        $output.='</div> <table cellspacing="0" cellpadding="0" border="0">
                    <tbody><tr style="border-top: none;">
                        <td >
                            <div align="left" class="article-content">
                                <p style="float:right;text-align: right;">
                                    <strong>Total Price:'.$tot_price.' €uros
                                    </strong>
                                </p>
                            </div>
                            <input type="hidden" name="tot_price" id="tot_price" value="'.$tot_price.'" />
                        </td>
                    </tr>
                    <tr><td width="580" height="10" class="w580"></td></tr>
                </tbody></table>';
        $outputContent .=str_replace("[INVOICE]",'',$output);
    }
     
    $outputContent .='<div>
        <div class="blueTagL"><strong>Payment method</strong> <br/>
                <img src="'.drupal_get_path('theme', 'privatetransfer_theme').'/images/Paybox_100.jpg"><input type="radio" name="paybox" id="paybox" />
                 <span id="payReqMsg">fdsfdsfsdfs</span>
                </div>  
            <div style="float:left;clear:both;"></div>
          <div class="completeDiv">          
          <a href="javascript:void(0);" onClick="cartPayment()" id="paynow"><div class="btn">Pay Now</div></a>
          <a href="'.$base_url.'/mycart"><div class="btn"><div class="fLeft bCart">Back to Cart</div></div></a>
          </div>';    
    
    $form['field'] = array(
              '#type' => 'fieldset', 
              '#title' => '', 
              '#description' => '<div class="cartErrMsg">Please complete your payment process to access the invoice document.</div><a href="'.$base_url.'/mycart"><div class="fRight"><div class="btn bTop"><div class="fLeft bCart">Back to Cart</div></div></a></div><br/>'.$outputContent, 
              '#tree' => TRUE,
      );
    return $form;
}


function paymentComplete(){
    global $user;   
    global $base_url;
    if(!isset($_REQUEST['chkoutId']) || trim($_REQUEST['chkoutId'])=='')
    {
        $_REQUEST['chkoutId']='117';//117
    }
   
    
    
    $checkout_id=trim($_REQUEST['chkoutId']);
   
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
        <table width="100%" cellspacing="0" cellpadding="0" border="0" >
        <tbody>
        <tr>
            <td><div class="invTitle">Review your cart & Payment</div></td>
        </tr>
        <tr>
            <td id="content-column" ><table>'; 
    
     $output_custInvoice='<div id="payCont">
        <a class="print-preview fRight btn">Print</a>
        <table width="100%" cellspacing="0" cellpadding="0" border="0" >
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
        <table width="100%" cellspacing="0" cellpadding="0" border="0" >
        <tbody>
        <tr>
            <td><p><div class="invTitle">Travel Agent Commission Invoice</div><br/>Our reference:  ('.$paybax_trans_id.')<br/>
    Clients Name: '.$userInfo.'<br/>
    Agent: '.$agentUserName.'. / '.$agentName.'<br/>
    Agency: '.$agencyName.'<br/></p></td>
        </tr>
        <tr>
            <td id="content-column" ><table>'; 
    $output_passtravDoc='<div id="payCont">
        <a class="print-preview fRight btn">Print</a>
        <table width="100%" cellspacing="0" cellpadding="0" border="0" >
        <tbody>
        <tr>
            <td><p><div class="invTitle">Passengers Travel Document </div><br/>Our reference:  ('.$paybax_trans_id.')<br/>
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
    $passInvoice='';
    $meetOutshtArr=array();
    $transOutshtArr=array();
    $meetOutArr=array();
    $meetOutArrPass=array();
    $transOutArr=array();
    $transOutArrPass=array();
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
                  
                   
                   
                    //Check for travek agent Login
                    if(isset($user->roles[5]))
                    {
                        $price=$agt_comm;
                    }        
                    
                    $clientprice=0;
                    //Check for travek agent Login
                    if(isset($user->roles[5]))
                    { 
                        $clientprice=$price;
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
                    
                    
                    $output_buffsmCont='<tr><td><table  cellspacing="0" cellpadding="0" border="0" >
                    <tbody>
                    <tr>
                        <td >
                            <p align="left" class="article-title serviceInfo">Services for '._dt_day($arriv_dt).' '.$arriv_dt.'</p>
                            <p align="left">Transfer In from '.$from.' to '.$to.'</p>';
                    
                    $output_buff='<tr><td><table  cellspacing="0" cellpadding="0" border="0" >
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
                $custInvoice.=$output_buffsmCont; 
                $travagtCommInvoice.=$output_buffsmCont; 
                $passInvoice.=$output_buff; 
                $reviewInvoice.='<p><div class="fRight">Price for this service: '.$qtyCont.'<strong>'.$price.' €uros</strong></div></p>';
               
                //$custInvoice.='<p><div class="fRight">Price for this service: '.$qtyCont_client.'<strong>'.$clientprice.' €uros</strong></div></p>';
               // $agtcont.='<p style="float:right" align="right" >Price for this service: '.$qtyCont_client.'<strong>'.$clientprice.' €uros</strong></p>';
          
                $output_buff='</div>
                        </td>
                    </tr>
                    <tr><td><div class="separator"></div></td></tr>
                </tbody></table></td></tr>';                    
                      $reviewInvoice.=$output_buff;    
                      $custInvoice.=$output_buff; 
                      $travagtCommInvoice.=$output_buff;
                      $passInvoice.=$output_buff;
                    
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
                  
                    //Check for travek agent Login
                    if(isset($user->roles[5]))
                    {
                        //$agt_price=$price-(($price*$agt_comm)/100);
                        //$price=$agt_price;
                         $price=$agt_comm;
                    }        
                    
                    $clientprice=0;
                    //Check for travek agent Login
                    if(isset($user->roles[5]))
                    { 
                        $clientprice=$price;
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
                    
                    $output_buffsmCont='<tr><td><table style="border-color: #014F7D;border-style:none ;border-width: 0 1px;padding:10px;" bgcolor="#FFFFFF" width="100%" class="rowTable" cellspacing="0" cellpadding="0" border="0" >
                    <tbody><tr>
                        <td>
                            <p align="left" class="article-title serviceInfo">Services for '._dt_day($service_dt).' '.$service_dt.'</p>
                            <p align="left">Transfer Out from '.$from.' to '.$to.'.</p>
                        ';
                    $output_buff='<tr><td style="padding-left:0;"><table  cellspacing="0" cellpadding="0" border="0" >
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
                $custInvoice.=$output_buffsmCont; 
                $travagtCommInvoice.=$output_buffsmCont;
                $passInvoice.=$output_buff; 
                $reviewInvoice.='<p><div class="fRight">Price for this service: '.$qtyCont.'<strong>'.$price.' €uros</strong></div></p>';
                //$custInvoice.='<p><div class="fRight">Price for this service: '.$qtyCont_client.'<strong>'.$clientprice.' €uros</strong></div></p>';
                                
                      $output_buff='</div>
                        </td>
                    </tr>
                    <tr><td><div class="separator"></div></td></tr>
                </tbody></table></td></tr>';
                    $reviewInvoice.=$output_buff;    
                    $custInvoice.=$output_buff; 
                    $travagtCommInvoice.=$output_buff;
                    $passInvoice.=$output_buff; 
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
                    //Check for travek agent Login
                    if(isset($user->roles[5]))
                    {
                        //$agt_price=$price-(($price*$agt_comm)/100);
                        //$price=$agt_price;
                         $price=$agt_comm;
                    }        
                    
                    $clientprice=0;
                    //Check for travek agent Login
                    if(isset($user->roles[5]))
                    { 
                        $clientprice=$price;
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
                    $output_buffsmCont='<tr><td><table style="border-color: #014F7D;border-style:none ;border-width: 0 1px;padding:10px;" bgcolor="#FFFFFF" width="100%" class="rowTable" cellspacing="0" cellpadding="0" border="0" >
                    <tbody><tr>
                        <td>
                            <p align="left" class="article-title serviceInfo">Services for '._dt_day($arriv_dt).' '.$arriv_dt.'</p>
                            <p align="left">Transfer In from '.$from.' to '.$to.'.</p>
                            ';
                    $transOutshtArr[]='<tr><td><table style="border-color: #014F7D;border-style:none ;border-width: 0 1px;padding:10px;" bgcolor="#FFFFFF" width="100%" class="rowTable" cellspacing="0" cellpadding="0" border="0" >
                    <tbody><tr>
                        <td>
                            <p align="left" class="article-title serviceInfo">Services for '._dt_day($service_dt).' '.$service_dt.'</p>   
                            <p align="left">Transfer Out from '.$to.' to '.$from.'.</p>
                            ';
                    $output_buff='<tr><td style="padding-left:0;"><table style="border-color: #014F7D;border-style:none ;border-width: 0 1px;padding:10px;" bgcolor="#FFFFFF" width="100%" class="rowTable" cellspacing="0" cellpadding="0" border="0" >
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
                                
                   $output_buffout='<tr><td style="padding-left:0;"><table style="border-color: #014F7D;border-style:none ;border-width: 0 1px;padding:10px;" bgcolor="#FFFFFF" width="100%" class="rowTable" cellspacing="0" cellpadding="0" border="0" >
                    <tbody><tr>
                        <td><p align="left" class="article-title serviceInfo">Services for '._dt_day($service_dt).' '.$service_dt.'</p>
                            <p align="left" class="article-title" >Transfer Out from '.$to.' to '.$from.'</p>
                            <div align="left" class="article-content">
                                <p>'.$pickup_hr.':'.$pickup_mt.strtolower($pickup_meridian).' pickup : Meet your '.$lang_driv_hostess.'-speaking driver in the lobby of the '.$pickup_addr.',</p>
                                <p>Private transfer service with a '.$servtitle.' from the '.$pickup_addr.' to '.$airport_dept.',</p>
                                <p>Flight '.$airline_out.' #'.$flight_no_out.' departs at '.$decol_hr.':'.$decol_mt.' '.$decol_meridian.' flying to '.$airport_dept.',</p>
                                <p>For '.$passengerDetailsout.' / '.$no_people.' passengers,</p>
				<p>Your driver contact: '.$driv_details.'.</p>';
                 
                $output_buffoutPass=$output_buffout;   
                   
                $reviewInvoice.=$output_buff;    
                $custInvoice.=$output_buffsmCont; 
                $travagtCommInvoice.=$output_buffsmCont;
                $passInvoice.=$output_buff; 
                $reviewInvoice.='<p style="float:right" align="right" >Price for transfer in&out (IN)service: '.$qtyCont.'<strong>'.$price.' €uros</strong></p>';
                $output_buffout.='<p style="float:right" align="right" >Price for transfer in&out service (OUT): '.$qtyCont.'<strong>'.$price.' €uros</strong></p>';
                //$custInvoice.='<p style="float:right" align="right" >Price for this service: '.$qtyCont_client.'<strong>'.$clientprice.' €uros</strong></p>';
               // $agtcont.='<p style="float:right" align="right" >Price for this service: '.$qtyCont_client.'<strong>'.$clientprice.' €uros</strong></p>';
                                
                      $output_buff='</div>
                        </td>
                    </tr>
                    <tr><td><div class="separator"></div></td></tr>
                </tbody></table></td></tr>';
                 
                  $reviewInvoice.=$output_buff;    
                  $custInvoice.=$output_buff;
                  $travagtCommInvoice.=$output_buff;
                  $passInvoice.=$output_buff; 
                  $transOutArr[]=$output_buffout.$output_buff;
                  $transOutArrPass[]=$output_buffoutPass.$output_buff;
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
                   
                  
                    //Check for travek agent Login
                    if(isset($user->roles[5]))
                    {
                        //$agt_price=$price-(($price*$agt_comm)/100);
                        //$price=$agt_price;
                         $price=$agt_comm;
                    }        
                    
                    $clientprice=0;
                    //Check for travek agent Login
                    if(isset($user->roles[5]))
                    { 
                        $clientprice=$price;
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
                    $output_buffsmCont='<tr><td><table style="border-color: #014F7D;border-style:none;border-width: 0 1px;padding:10px;" bgcolor="#FFFFFF" width="100%" class="rowTable"  cellspacing="0" cellpadding="0" border="0" >
                    <tbody><tr>
                        <td >
                        <p align="left" class="article-title serviceInfo">Services for '._dt_day($arriv_dt).' '.$arriv_dt.'</p>
                        <p align="left" >Meet & Greet In, at '.$arrival_airport.' in '.$region.'</p>
                        ';
                    $output_buff='<tr><td><table style="border-color: #014F7D;border-style:none;border-width: 0 1px;padding:10px;" bgcolor="#FFFFFF" width="100%" class="rowTable"  cellspacing="0" cellpadding="0" border="0" >
                    <tbody><tr>
                        <td >
                        <p align="left" class="article-title serviceInfo">Services for '._dt_day($arriv_dt).' '.$arriv_dt.'</p>
                            <p align="left" class="article-title">Meet & Greet In, at '.$arrival_airport.' in '.$region.'</p>
                            <div align="left" class="article-content">
                                <!--<p>Meet and Greet In at '.$arrival_airport.'</p>-->
                                <p>'.$arriv_hr.':'.$arriv_mt.strtolower($arriv_meridian).':  Meet your '.$driver_hostess_lang.'-speaking hostess on the jetway on the gate of your aircraft upon arrival at '.$arrival_airport.',</p>
                                <p>Flight '.$airline.' '.$flight_no.' arrives at '.$arriv_hr.':'.$arriv_mt.$arriv_meridian.' coming from '.$arrival_airport.',</p>    
                                <p>For '.$passengerDetailsin.' / '.$no_people.' passengers,</p>
				<p>'.$no_regular_luggage.' regular piece(s) to be Handled,</p>
                                <p>'.$no_odd_luggage.' Odd piece(s) to be Handled,</p>
                                <p>Your Hostess contact at airport : '.$driv_details.',</p>';
                    $reviewInvoice.=$output_buff;    
                    $custInvoice.=$output_buffsmCont; 
                    $travagtCommInvoice.=$output_buffsmCont;
                    $passInvoice.=$output_buff; 
                    $reviewInvoice.='<p style="float:right" align="right" >Price for this service: '.$qtyCont.'<strong>'.$price.' €uros</strong></p>';
                    //$custInvoice.='<p style="float:right" align="right" >Price for this service: '.$qtyCont_client.'<strong>'.$clientprice.' €uros</strong></p>';
                   // $agtcont.='<p style="float:right" align="right" >Price for this service: '.$qtyCont_client.'<strong>'.$clientprice.' €uros</strong></p>';
                  
                    $output_buff='</div>
                            </td>
                        </tr>
                        <tr><td><div class="separator"></div></td></tr>
                    </tbody></table></td></tr>';
                    $reviewInvoice.=$output_buff;    
                    $custInvoice.=$output_buff;  
                    $travagtCommInvoice.=$output_buff;
                    $passInvoice.=$output_buff; 
                    
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
                   
                   
                    //Check for travek agent Login
                    if(isset($user->roles[5]))
                    {
                        //$agt_price=$price-(($price*$agt_comm)/100);
                        //$price=$agt_price;
                         $price=$agt_comm;
                    }        
                    
                    $clientprice=0;
                    //Check for travek agent Login
                    if(isset($user->roles[5]))
                    { 
                        $clientprice=$price;
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
                    $output_buffsmCont='<tr><td><table style="border-color: #014F7D;border-style:none;border-width: 0 1px;padding:10px;" bgcolor="#FFFFFF" width="100%" class="rowTable"  cellspacing="0" cellpadding="0" border="0" >
                    <tbody><tr>
                        <td>
                            <p align="left" class="article-title serviceInfo">Services for '._dt_day($service_dt).' '.$service_dt.' </p>
                            <p>Meet & Greet Out, at '.$airport_dept.' in '.$region.'</p></td>
                        </tr>
                        <tr><td><div class="separator"></div></td></tr>
                    </tbody></table></td></tr>
                        ';
                    $output_buffpass='<tr><td><table style="border-color: #014F7D;border-style:none;border-width: 0 1px;padding:10px;" bgcolor="#FFFFFF" width="100%" class="rowTable"  cellspacing="0" cellpadding="0" border="0" >
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
                    /*$reviewInvoice.=$output_buff;    
                    $custInvoice.=$output_buffsmCont; 
                    $travagtCommInvoice.=$output_buffsmCont;
                    $passInvoice.=$output_buff; 
                    $reviewInvoice.='<p style="float:right" align="right" >Price for this service: '.$qtyCont.'<strong>'.$price.' €uros</strong></p>';*/
                    //$custInvoice.='<p style="float:right" align="right" >Price for this service: '.$qtyCont_client.'<strong>'.$clientprice.' €uros</strong></p>';
                    //$agtcont.='<p style="float:right" align="right">Price for this service: '.$qtyCont_client.'<strong>'.$clientprice.' €uros</strong></p>';
                    $output_buffout='<p style="float:right" align="right" >Price for this service: '.$qtyCont.'<strong>'.$price.' €uros</strong></p>';
                    $output_buff='</div>
                            </td>
                        </tr>
                        <tr><td><div class="separator"></div></td></tr>
                    </tbody></table></td></tr>';
                    /*$reviewInvoice.=$output_buff;    
                    $custInvoice.=$output_buff;
                    $travagtCommInvoice.=$output_buff;
                    $passInvoice.=$output_buff; */
                    
                    $meetOutArr[]=$output_buffpass.$output_buffout.$output_buff;
                    $meetOutArrPass[]=$output_buffpass.$output_buff;
                    $meetOutshtArr[]=$output_buffsmCont;
                    
                    
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
                     
                     
                     
                    $res_out=db_query("SELECT id, service_dt, airline, flight_no, decol_hr, decol_mt,
                    decol_meridian, pickup_hr, pickup_mt, pickup_meridian, pickup_addr, drop_addr, lang_driv_hostess, 
                    comments from log_detailed_out_travel_Info  WHERE checkout_id='".$checkout_id."' and 
                    ls_id='".$service_info_id."' and service_type='".$service_type."'")->fetchAssoc();
                    
                    $service_dt=$res_out['service_dt'];
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
                   
                   
                    //Check for travek agent Login
                    if(isset($user->roles[5]))
                    {
                        //$agt_price=$price-(($price*$agt_comm)/100);
                        //$price=$agt_price;
                         $price=$agt_comm;
                    }        
                    
                    $clientprice=0;
                    //Check for travek agent Login
                    if(isset($user->roles[5]))
                    { 
                        $clientprice=$price;
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
                    $output_buffsmCont='<tr><td><table style="border-color: #014F7D;border-style:none;border-width: 0 1px;padding:10px;" bgcolor="#FFFFFF" width="100%" class="rowTable"  cellspacing="0" cellpadding="0" border="0" >
                    <tbody><tr>
                        <td>
                            <p align="left" class="article-title serviceInfo">Services for '._dt_day($arriv_dt).' '.$arriv_dt.'</p>
                             <p align="left" >Meet & Greet In, at '.$arrival_airport.' in '.$region.'</p>
                            </td>
                        </tr>
                        <tr><td><div class="separator"></div></td></tr>
                    </tbody></table></td></tr>';
                    $meetOutshtArr[]='<tr><td><table style="border-color: #014F7D;border-style:none;border-width: 0 1px;padding:10px;" bgcolor="#FFFFFF" width="100%" class="rowTable"  cellspacing="0" cellpadding="0" border="0" >
                    <tbody><tr>
                        <td>
                            <p align="left" class="article-title serviceInfo">Services for '._dt_day($service_dt).' '.$service_dt.'</p>     
                             <p align="left" >Meet & Greet Out, at '.$drop_addr.' in '.$region.'</p>
                            </td>
                        </tr>
                        <tr><td><div class="separator"></div></td></tr>
                    </tbody></table></td></tr>';
                    $output_buff='<tr><td><table style="border-color: #014F7D;border-style:none;border-width: 0 1px;padding:10px;" bgcolor="#FFFFFF" width="100%" class="rowTable"  cellspacing="0" cellpadding="0" border="0" >
                    <tbody><tr>
                        <td>
                            <p align="left" class="article-title serviceInfo">Services for '._dt_day($arriv_dt).' '.$arriv_dt.'</p>
                             <p align="left" class="article-title">Meet & Greet In, at '.$arrival_airport.' in '.$region.'</p>
                             <div align="left" class="article-content">
                                <!--<p>Meet & Greet In at '.$arrival_airport.'</p>-->
                                <p>'.$arriv_hr.':'.$arriv_mt.strtolower($arriv_meridian).':  Meet your '.$lang_driv_hostess.'-speaking  hostess on the jetway on the gate of your aircraft upon arrival at '.$arrival_airport.'</p>
                                <p>Flight '.$airline.' #'.$flight_no.' arrives at: '.$arriv_hr.':'.$arriv_mt.' '.$arriv_meridian.' coming from '.$arrival_airport.',</p>
                                <p>For '.$passengerDetailsin.' / '.$no_people.' passengers,</p>
				<p>'.$no_regular_luggage.' regular piece(s) to be Handled,</p>
                                <p>'.$no_odd_luggage.' Odd piece(s) to be Handled,</p>
                                <p>Your Hostess contact at airport : '.$driv_details.'.</p> ';   
                   $output_buffout='<tr><td><table style="border-color: #014F7D;border-style:none;border-width: 0 1px;padding:10px;" bgcolor="#FFFFFF" width="100%" class="rowTable"  cellspacing="0" cellpadding="0" border="0" >
                    <tbody><tr>
                        <td>                           
                            <p align="left" class="article-title serviceInfo">Services for '._dt_day($service_dt).' '.$service_dt.' </p>
                            <p align="left" class="article-title">Meet & Greet Out, at '.$drop_addr.' in '.$region.'</p>
                            <div align="left" class="article-content">
                                <p>Flight '.$airline_out.' '.$flight_no_out.' departs at '.$decol_hr.':'.$decol_mt.strtolower($decol_meridian).', flying to '.$drop_addr.',</p>
                                <p>Meet your '.$lang_driv_hostess.'-speaking of the hostess upon arrival at '.$airline_out.' at '.$decol_hr.':'.$decol_mt.strtolower($decol_meridian).',</p>
                                <p>Estimated arrival time at the airport: '.$pickup_hr.':'.$pickup_mt.strtolower($pickup_meridian).',</p>
                                <p>For '.$passengerDetails.' / '.$no_people.' passengers,</p>
				<p>'.$no_regular_luggage.' regular piece(s) to be Handled,</p>
                                <p>'.$no_odd_luggage.' Odd piece(s) to be Handled,</p>
                                <p>Your Hostess contact at airport : '.$driv_details.',</p>';
                    $output_buffoutPass=$output_buffout;
                    $reviewInvoice.=$output_buff;    
                    $custInvoice.=$output_buffsmCont;  
                    $travagtCommInvoice.=$output_buffsmCont;
                    $passInvoice.=$output_buff; 
                    $reviewInvoice.='<p style="float:right" align="right" >Price for meet&greet in&out service (IN): '.$qtyCont.'<strong>'.$price.' €uros</strong></p>';
                    $output_buffout.='<p style="float:right" align="right" >Price for meet&greet in&out service (OUT): '.$qtyCont.'<strong>'.$price.' €uros</strong></p>';
                    //$custInvoice.='<p style="float:right" align="right" >Price for this service: '.$qtyCont_client.'<strong>'.$clientprice.' €uros</strong></p>';
                    //$agtcont.='<p style="float:right" align="right" >Price for this service: '.$qtyCont_client.'<strong>'.$clientprice.' €uros</strong></p>';
                   
                    $output_buff='</div>
                            </td>
                        </tr>
                        <tr><td><div class="separator"></div></td></tr>
                    </tbody></table></td></tr>';
                    $reviewInvoice.=$output_buff;    
                    $custInvoice.=$output_buff;
                    $travagtCommInvoice.=$output_buff;
                    $passInvoice.=$output_buff; 
                    $meetOutArr[]=$output_buffout.$output_buff;
                    $meetOutArrPass[]=$output_buffoutPass.$output_buff;
                }
                
                
                
                
            }
     
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
            
            foreach($transOutArr as $key => $value)
            {
                $reviewInvoice.=$value;
            }
            foreach($transOutArrPass as $key => $value)
            {  
                $passInvoice.=$value;
            }
            foreach($transOutshtArr as $key => $value)
            {
                $custInvoice.=$value;
                $travagtCommInvoice.=$value;
            }
            
            foreach($meetOutArr as $key => $value)
            {
                $reviewInvoice.=$value;
            }
            foreach($meetOutArrPass as $key => $value)
            {  
                $passInvoice.=$value;
            }
            foreach($meetOutshtArr as $key => $value)
            {
                $custInvoice.=$value;
                $travagtCommInvoice.=$value;
            }
            

            $reviewInvoice.='<tr><td><table style="border-color: #014F7D;border-style:none;border-width: 0 1px;padding:10px;" bgcolor="#FFFFFF" width="100%" class="rowTable"  cellspacing="0" cellpadding="0" border="0">
                        <tbody><tr style="border-top: none;">
                            <td >
                                <div align="left" class="article-content">
                                    <p style="float:right;text-align: right;font-size:14px;font-weight:bold;">
                                        <strong>Net price:'.$subtot_price.' €<br/>';
                                        if($extracommsion!='')
                                        {
                                            $reviewInvoice.='<span>Commission: '.$comm_percent.'</span> %<br/>';
                                            $reviewInvoice.='<span>Commission: '.$extracommsion.'</span> €<br/>';
                                        }
                                        $reviewInvoice.='<div class="blueTagR bdFont">Total price including your Commission: <span id="total_amt_comm_agt">'.$tot_price.'</span> €uros</div>
                                        </strong>
                                    </p>
                                </div>
                            </td>
                        </tr>
                        <tr><td width="580" height="10" class="w580"></td></tr>
                    </tbody></table></td></tr>';

          $custInvoice.='<tr><td><table style="border-color: #014F7D;border-style:none;border-width: 0 1px;padding:10px;" bgcolor="#FFFFFF" width="100%" class="rowTable"  cellspacing="0" cellpadding="0" border="0">
                        <tbody><tr style="border-top: none;">
                            <td >
                                <div align="left" class="article-content">
                                    <p id="netCont">
                                        <strong class="blueTagR">Total Price for the above services: '.$tot_price.' €uros
                                        </strong>

                                    </p>
                                </div>
                            </td>
                        </tr>
                        <tr><td width="580" height="10" class="w580"></td></tr>
                    </tbody></table></td></tr>'; 
           $travagtCommInvoice.='<tr><td><table style="border-color: #014F7D;border-style:none;border-width: 0 1px;padding:10px;" bgcolor="#FFFFFF" width="100%" class="rowTable"  cellspacing="0" cellpadding="0" border="0">
                        <tbody><tr style="border-top: none;">
                            <td >
                                <div align="left" class="article-content">
                                    <p style="float:right;text-align: right;">
                                        Net price:'.$subtot_price.' €uros<br/>';
            $travagtCommInvoice.='<span class="blueTag">Total price including your Commission:'.$tot_price.' €uros</span><br/>';
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
    $custInvoice.='<tr><td><table style="border-color: #014F7D;border-style:none solid solid;border-width: 0 1px;padding:10px;"  bgcolor="#FFFFFF" width="100%" class="rowTable"  cellspacing="0" cellpadding="0" border="0">
                    <tbody><tr style="border-top: none;">
                        <td >
                            <div align="left" class="article-content">
                                <p id="netCont">
                                    <strong>Total Price for the above services:'.$tot_price.' €uros
                                    </strong>
                                </p>
                            </div>
                            <input type="hidden" name="tot_price" id="tot_price" value="'.$tot_price.'" />
                        </td>
                    </tr>
                    <tr><td width="580" height="10" class="w580"></td></tr>
                </tbody></table></td></tr>';
   
    }
        
        //echo $agtcont;
    
   $output_passtravDoc =str_replace("[PassengerInfo]",$userInfo, $output_passtravDoc);
    
   $output_reviewCart.=$reviewInvoice."</table></td></tr></tbody></table></div>";
   $output_custInvoice.=$custInvoice."</table></td></tr></tbody></table></div>";
   $output_travagtCommInvoice.=$travagtCommInvoice."</table></td></tr></tbody></table></div>";
   $output_passtravDoc.=$passInvoice."</table></td></tr></tbody></table></div>";
   $outputContent .='<div class="tabs">
        <div id="tab1"> <a id="tab1link" class="act invoiceTab">Review your cart & Payment</a>
                       <a id="tab2link" class="disact invoiceTab">Customer Invoice</a>
                       <a id="tab3link" class="disact invoiceTab">Travel Agent Commission Invoice</a>
                       <a id="tab4link" class="disact invoiceTab">Passengers Travel Document </a>
        </div>
        <div id="cont_tab1link" class="invoiceContent" style="display:block;" >'.$output_reviewCart.'</div>
        <div id="cont_tab2link" class="invoiceContent">'.$output_custInvoice.'</div>
        <div id="cont_tab3link" class="invoiceContent">'.$output_travagtCommInvoice.'</div>
        <div id="cont_tab4link" class="invoiceContent">'.$output_passtravDoc.'</div>  
       </div>
       ';
    
    $form['field'] = array(
              '#type' => 'fieldset', 
              '#title' => '', 
              '#description' => $outputContent, 
              '#tree' => TRUE,
      );
    return $form;
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