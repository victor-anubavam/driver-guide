<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
define('DRUPAL_ROOT', getcwd());
$base_url = 'http://'.$_SERVER['HTTP_HOST']; // THIS IS IMPORTANT
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL); // Could be DRUPAL_BOOTSTRAP_SESSION if that's all you need.
global $user;

if($_REQUEST['process'] == 'addtocart'){
    $cart_id=$_REQUEST['cart_id'];
    $typeTransfer=$_REQUEST['typeTrans'];
    if(isset($_SESSION['products']))
    $cart=unserialize($_SESSION['products']);
    else
    $cart=array();     
    
    $node=node_load($cart_id);
    if(!isset($cart[$cart_id]['product_details']['serv_type']))
    {
    $cart[$cart_id]['product_details']['serv_type']=$node->type; 
    $cart[$cart_id]['person_details']['serv_type']=$node->type; 
    }
    
    $cart[$cart_id]['product_details'][$typeTransfer]['servtitle']=trim($_REQUEST['servtitle']);
    $cart[$cart_id]['product_details'][$typeTransfer]['id']=$cart_id;
    $cart[$cart_id]['product_details'][$typeTransfer]['typeTransfer']=$typeTransfer;
    $cart[$cart_id]['product_details'][$typeTransfer]['qty']='1';
    $cart[$cart_id]['product_details'][$typeTransfer]['price']=trim($_REQUEST['price']);  
    $cart[$cart_id]['product_details'][$typeTransfer]['status']='not_complete';
    $cart[$cart_id]['product_details'][$typeTransfer]['driv_name']='';
    $cart[$cart_id]['product_details'][$typeTransfer]['driv_num']='';
    
    if(isset($_REQUEST['driv_name']) && trim($_REQUEST['driv_name'])!='')
    $cart[$cart_id]['product_details'][$typeTransfer]['driv_name']=trim($_REQUEST['driv_name']);
    
    if(isset($_REQUEST['driv_num']) && trim($_REQUEST['driv_num'])!='')
    $cart[$cart_id]['product_details'][$typeTransfer]['driv_num']=trim($_REQUEST['driv_num']);  
    
   
    if(isset($_REQUEST['selectregion']) && trim($_REQUEST['selectregion'])!='')
    $cart[$cart_id]['product_details'][$typeTransfer]['srch']['selectregion']=trim($_REQUEST['selectregion']); 
    
    if(isset($_REQUEST['from']) && trim($_REQUEST['from'])!='')
    $cart[$cart_id]['product_details'][$typeTransfer]['srch']['from']=trim($_REQUEST['from']); 
    
    if(isset($_REQUEST['to']) && trim($_REQUEST['to'])!='')
    $cart[$cart_id]['product_details'][$typeTransfer]['srch']['to']=trim($_REQUEST['to']); 
    
    if(isset($_REQUEST['region']) && trim($_REQUEST['region'])!='')
    $cart[$cart_id]['product_details'][$typeTransfer]['srch']['region']=trim($_REQUEST['region']);
    
    if(isset($_REQUEST['delta']) && trim($_REQUEST['delta'])!='')
    $cart[$cart_id]['product_details'][$typeTransfer]['srch']['delta']=trim($_REQUEST['delta']); 
    
    if(isset($_REQUEST['max_people']) && trim($_REQUEST['max_people'])!='')
    $cart[$cart_id]['product_details'][$typeTransfer]['srch']['max_people']=trim($_REQUEST['max_people']); 
    
    if(isset($_REQUEST['max_lugg']) && trim($_REQUEST['max_lugg'])!='')
    $cart[$cart_id]['product_details'][$typeTransfer]['srch']['max_lugg']=trim($_REQUEST['max_lugg']); 
    
    if(isset($_REQUEST['agt_comm']) && trim($_REQUEST['agt_comm'])!='')
    $cart[$cart_id]['product_details'][$typeTransfer]['srch']['agt_comm']=trim($_REQUEST['agt_comm']); 
    
    if(isset($_REQUEST['custday_price']) && trim($_REQUEST['custday_price'])!='')
    $cart[$cart_id]['product_details'][$typeTransfer]['srch']['custday_price']=trim($_REQUEST['custday_price']); 
    
    if(isset($_REQUEST['custday_price']) && trim($_REQUEST['custday_price'])!='')
    $cart[$cart_id]['product_details'][$typeTransfer]['srch']['applied']='weekday'; 
    
    
    if(isset($_REQUEST['custend_price']) && trim($_REQUEST['custend_price'])!='')
    $cart[$cart_id]['product_details'][$typeTransfer]['srch']['custend_price']=trim($_REQUEST['custend_price']); 
    
    if(isset($_REQUEST['cust_price']) && trim($_REQUEST['cust_price'])!='')
    $cart[$cart_id]['product_details'][$typeTransfer]['srch']['cust_price']=trim($_REQUEST['cust_price']); 
    
    if(isset($_REQUEST['dtimehours']) && trim($_REQUEST['dtimehours'])!='')
    $cart[$cart_id]['product_details'][$typeTransfer]['srch']['dtimehours']=trim($_REQUEST['dtimehours']); 
    
    if(isset($_REQUEST['dtimemins']) && trim($_REQUEST['dtimemins'])!='')
    $cart[$cart_id]['product_details'][$typeTransfer]['srch']['dtimemins']=trim($_REQUEST['dtimemins']); 
    
    if(isset($_REQUEST['day_night_dep']) && trim($_REQUEST['day_night_dep'])!='')
    $cart[$cart_id]['product_details'][$typeTransfer]['srch']['day_night_dep']=trim($_REQUEST['day_night_dep']); 
    
    if(isset($_REQUEST['arrtimehours']) && trim($_REQUEST['arrtimehours'])!='')
    $cart[$cart_id]['product_details'][$typeTransfer]['srch']['arrtimehours']=trim($_REQUEST['arrtimehours']); 
    
    if(isset($_REQUEST['arrtimemins']) && trim($_REQUEST['arrtimemins'])!='')
    $cart[$cart_id]['product_details'][$typeTransfer]['srch']['arrtimemins']=trim($_REQUEST['arrtimemins']); 
    
    if(isset($_REQUEST['day_night_arr']) && trim($_REQUEST['day_night_arr'])!='')
    $cart[$cart_id]['product_details'][$typeTransfer]['srch']['day_night_arr']=trim($_REQUEST['day_night_arr']); 
    
    if(isset($_REQUEST['desgination']) && trim($_REQUEST['desgination'])!='')
    $cart[$cart_id]['product_details'][$typeTransfer]['srch']['desgination']=trim($_REQUEST['desgination']); 
    
    
    if(isset($_REQUEST['night_rate_comm']) && trim($_REQUEST['night_rate_comm'])!='')
    $cart[$cart_id]['product_details'][$typeTransfer]['srch']['night_rate_comm']=trim($_REQUEST['night_rate_comm']); 
    
    if(!isset($cart[$cart_id]['person_details'][$typeTransfer]['status']))
    {
        $cart[$cart_id]['person_details'][$typeTransfer]['status']='not_complete';
    }  
    
    $_SESSION['products'] = serialize($cart); 
    $retval='added';
    prefillstep();
    echo json_encode($retval); 
}

if($_REQUEST['process'] == 'removefromcart'){
    $cart_id=$_REQUEST['cart_id']; 
    $type=$_REQUEST['typeTrans']; 
    $cart = unserialize($_SESSION['products']); 
    unset($cart[$cart_id]['product_details'][$type]); 
    unset($cart[$cart_id]['person_details'][$type]);
    $_SESSION['products'] = serialize($cart); 
    $retval='removed';
    echo json_encode($retval); 
}

if($_REQUEST['process'] == 'removeall'){   
    $cart = unserialize($_SESSION['products']); 
    foreach($cart as $key=>$value)
    {
        $retval[]=$key;
    }
    unset($cart);
    $cart=array();
    $_SESSION['products'] = serialize($cart); 
    echo json_encode($retval); 
}
if($_REQUEST['process'] == 'get-destaddr'){ 
    $retval='';
    if(isset($_REQUEST['dest_addr']) && trim($_REQUEST['dest_addr'])!='')
    {
        $dest_addr=trim($_REQUEST['dest_addr']);
        
        $res_drop_off_address=db_query("SELECT da.field_drop_address_value from node as n LEFT JOIN field_data_field_drop_address as da ON n.nid=da.entity_id WHERE n.type='drop_off_address' and n.title='".$dest_addr."'");
        foreach ($res_drop_off_address as $record) {
            $retval=$record->field_drop_address_value;
        }
    }
    echo json_encode($retval); 
}
if($_REQUEST['process'] == 'setCheckoutProductValue'){ 
    $cart_id=$_REQUEST['cart_id'];
    $type=$_REQUEST['typeTrans'];
    $field_name=trim($_REQUEST['field']);
    $field_value=$_REQUEST['fieldVal'];
    $cart = unserialize($_SESSION['products']);
    $retval='';
    if(isset($cart[$cart_id]))
    {
       if($field_name=='qty')
       {
           if(isset($cart[$cart_id]['product_details'][$type]['srch']['max_people']) && isset($cart[$cart_id]['person_details'][$type]['no_people']) && trim($cart[$cart_id]['person_details'][$type]['no_people'])>trim($cart[$cart_id]['product_details'][$type]['srch']['max_people']) 
                   && isset($cart[$cart_id]['product_details'][$type]['no_people_updated']) && trim($cart[$cart_id]['product_details'][$type]['no_people_updated'])=='Y' && $field_value<2)
           {
               $retval='failed,'.trim($cart[$cart_id]['product_details'][$type]['srch']['max_people']);
           }
       }
       
       
        if($retval=='')
        {
            $cart[$cart_id]['product_details'][$type][$field_name]=$field_value;
            $retval='updated,'.trim($cart[$cart_id]['product_details'][$type]['srch']['max_people']);
        }
    }
    $_SESSION['products'] = serialize($cart); 
    echo json_encode($retval); 
}

if($_REQUEST['process'] == 'chktripcompletion'){ 
    $cart = unserialize($_SESSION['products']);
    $retval=array();   
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
              break;
            case 2:
              if($value['product_details']['serv_type']=='service_as_transfer')
              $type='in&out';
              elseif($value['product_details']['serv_type']=='meet_greet')
              $type='Commute';  
              break;
            }
            if(isset($value['product_details'][$type]['status']) && $value['product_details'][$type]['status']=='not_complete'){
              $retval[]=$key.$type;
            }
        }
    }
    
     echo json_encode($retval); 
   
}

if($_REQUEST['process'] == 'sessioncart'){
    $cart = unserialize($_SESSION['products']);
    if(isset($_REQUEST['cart_id']) && trim($_REQUEST['cart_id'])!='')
    {
        $cart_id=$_REQUEST['cart_id']; 
        $type=$_REQUEST['typetrans']; 
        
        if(isset($cart[$cart_id]))
        {
           if(isset($_REQUEST['section']) && trim($_REQUEST['section'])=='0')
           {
            if(isset($cart[$cart_id]['person_details']['serv_type']) && (trim($cart[$cart_id]['person_details']['serv_type'])=='service_as_transfer' || trim($cart[$cart_id]['person_details']['serv_type'])=='meet_greet' || trim($cart[$cart_id]['person_details']['serv_type'])=='driver_at_disposal'))
            {               
            $cart[$cart_id]['person_details'][$type]['arrival_tm']=trim($_REQUEST['arrival_tm']);
            if($type=='in&out'){
                $cart[$cart_id]['product_details'][$type]['in']['ariport_arriv']=trim($_REQUEST['arrival_tm']);
            }//if($type=='in')
            else{
                $cart[$cart_id]['product_details'][$type]['ariport_arriv']=trim($_REQUEST['arrival_tm']);
            }
            
            $cart[$cart_id]['person_details'][$type]['arrival_tm']=trim($_REQUEST['arrival_tm']);
            $cart[$cart_id]['person_details'][$type]['wheely_bag']=trim($_REQUEST['wheely_bag']);
            $cart[$cart_id]['person_details'][$type]['regular_bag']=trim($_REQUEST['regular_bag']);
            $cart[$cart_id]['person_details'][$type]['no_people']=trim($_REQUEST['no_people']);
            $cart[$cart_id]['person_details'][$type]['no_people_OthersTxt']='';
            if(isset($_REQUEST['no_people_OthersTxt']) && trim($_REQUEST['no_people_OthersTxt'])!='' && trim($_REQUEST['no_people'])=='Others'){
                $cart[$cart_id]['person_details'][$type]['no_people_OthersTxt']=trim($_REQUEST['no_people_OthersTxt']);
            }
            
            if(isset($cart[$cart_id]['product_details'][$type]['srch']['max_people']) && trim($_REQUEST['no_people'])=='Others' && trim($_REQUEST['no_people_OthersTxt'])>trim($cart[$cart_id]['product_details'][$type]['srch']['max_people']) && (!isset($cart[$cart_id]['product_details'][$type]['no_people_updated']) 
                    || trim($cart[$cart_id]['product_details'][$type]['no_people_updated'])=='N'))
            {
                $cart[$cart_id]['product_details'][$type]['qty']=$cart[$cart_id]['product_details'][$type]['qty']+1;
                $cart[$cart_id]['product_details'][$type]['no_people_updated']='Y';
                
            }
            else if(isset($cart[$cart_id]['product_details'][$type]['srch']['max_people']) && trim($_REQUEST['no_people'])!='Others' && ((isset($cart[$cart_id]['product_details'][$type]['no_people_updated']) 
                    && trim($cart[$cart_id]['product_details'][$type]['no_people_updated'])=='Y'))){
                if(trim($cart[$cart_id]['product_details'][$type]['qty']=$cart[$cart_id]['product_details'][$type]['qty'])>1){
                    $cart[$cart_id]['product_details'][$type]['qty']=$cart[$cart_id]['product_details'][$type]['qty']-1;
                }
                $cart[$cart_id]['product_details'][$type]['no_people_updated']='N';
            }
           
            
            $cart[$cart_id]['person_details'][$type]['odd_bag']=trim($_REQUEST['odd_bag']);
            $cart[$cart_id]['person_details'][$type]['odd_bag_OthersTxt']='';
            if(isset($_REQUEST['odd_bag_OthersTxt']) && trim($_REQUEST['odd_bag_OthersTxt'])!='' && trim($_REQUEST['odd_bag'])=='Others'){
                $cart[$cart_id]['person_details'][$type]['odd_bag_OthersTxt']=trim($_REQUEST['odd_bag_OthersTxt']);
            }
            $cart[$cart_id]['person_details'][$type]['dsec_lugg']=trim($_REQUEST['dsec_lugg']);            
            }
           
            $cart[$cart_id]['person_details'][$type]['status']='complete';          
           } 
           elseif(isset($_REQUEST['section']) && trim($_REQUEST['section'])=='1' )
           {
             if(isset($_REQUEST['serv_type']) && (trim($_REQUEST['serv_type'])=='driver_at_disposal')){
                if(isset($_REQUEST['typetrans']) && (trim($_REQUEST['typetrans'])=='driv'))
                {
                     //$cart[$cart_id]['product_details'][$type]['ariport_arriv']=trim($_REQUEST['ariport_arriv']);
                    //$cart[$cart_id]['product_details'][$type]['ariport_origin']=trim($_REQUEST['ariport_origin']);
                    $cart[$cart_id]['product_details'][$type]['service_day']=trim($_REQUEST['service_day']);
                    
                    $dept_hr_mt=trim($_REQUEST['dept_hr_mt']);
                    $depttime=explode(" ",$dept_hr_mt);                    
                    $dept_hr='';
                    $dept_mt='';
                    if(isset($depttime[0]) && trim($depttime[0])!='')
                    {
                        $depthr=explode(":",$depttime[0]);                       
                        $dept_hr=$depthr[0];
                        $dept_mt=$depthr[1];
                    }
                    $dept_meridian='';
                    if(isset($depttime[1]) && trim($depttime[1])!=''){$dept_meridian=trim($depttime[1]);}
                    
                    $cart[$cart_id]['product_details'][$type]['dept_hr']=$dept_hr;
                    $cart[$cart_id]['product_details'][$type]['dept_mt']=$dept_mt;
                    $cart[$cart_id]['product_details'][$type]['dept_meridian']=$dept_meridian;
                    
                    $arriv_hr_mt=trim($_REQUEST['arriv_hr_mt']);
                    $arrtime=explode(" ",$arriv_hr_mt);                    
                    $arriv_hr='';
                    $arriv_mt='';
                    if(isset($arrtime[0]) && trim($arrtime[0])!='')
                    {
                        $arrhr=explode(":",$arrtime[0]);                       
                        $arriv_hr=$arrhr[0];
                        $arriv_mt=$arrhr[1];
                    }
                    $arriv_meridian='';
                    if(isset($arrtime[1]) && trim($arrtime[1])!=''){$arriv_meridian=trim($arrtime[1]);}
                        
                    $cart[$cart_id]['product_details'][$type]['arriv_hr']=$arriv_hr;
                    $cart[$cart_id]['product_details'][$type]['arriv_mt']=$arriv_mt;
                    $cart[$cart_id]['product_details'][$type]['arriv_meridian']=$arriv_meridian;
                    
                    $cart[$cart_id]['product_details'][$type]['pick_addr']=trim($_REQUEST['pick_addr']);
                    $cart[$cart_id]['product_details'][$type]['pick_addr_OthersTxt']='';
                    if(isset($_REQUEST['pick_addr_OthersTxt']) && trim($_REQUEST['pick_addr_OthersTxt'])!='' && trim($_REQUEST['pick_addr'])!=''){
                        $cart[$cart_id]['product_details'][$type]['pick_addr_OthersTxt']=trim($_REQUEST['pick_addr_OthersTxt']);
                    }
                    
                    $cart[$cart_id]['product_details'][$type]['dest_addr']=trim($_REQUEST['dest_addr']); 
                    $cart[$cart_id]['product_details'][$type]['dest_addr_OthersTxt']='';
                    if(isset($_REQUEST['dest_addr_OthersTxt']) && trim($_REQUEST['dest_addr_OthersTxt'])!='' && trim($_REQUEST['dest_addr'])!=''){
                        $cart[$cart_id]['product_details'][$type]['dest_addr_OthersTxt']=trim($_REQUEST['dest_addr_OthersTxt']);
                    }
                    
                    $cart[$cart_id]['product_details'][$type]['name_addr']=trim($_REQUEST['name_addr']);
                    $cart[$cart_id]['product_details'][$type]['name_addr_OthersTxt']='';
                    if(isset($_REQUEST['name_addr_OthersTxt']) && trim($_REQUEST['name_addr_OthersTxt'])!='' && trim($_REQUEST['name_addr'])!=''){
                        $cart[$cart_id]['product_details'][$type]['name_addr_OthersTxt']=trim($_REQUEST['name_addr_OthersTxt']);
                    }
                    
                    $cart[$cart_id]['product_details'][$type]['endserv_addr']=trim($_REQUEST['endserv_addr']);
                    $cart[$cart_id]['product_details'][$type]['endserv_addr_OthersTxt']='';
                    if(isset($_REQUEST['endserv_addr_OthersTxt']) && trim($_REQUEST['endserv_addr_OthersTxt'])!='' && trim($_REQUEST['endserv_addr'])!=''){
                        $cart[$cart_id]['product_details'][$type]['endserv_addr_OthersTxt']=trim($_REQUEST['endserv_addr_OthersTxt']);
                    }
                    
                    
                    $cart[$cart_id]['product_details'][$type]['driv_lang']=trim($_REQUEST['driv_lang']);
                    $cart[$cart_id]['product_details'][$type]['spl_comment']=trim($_REQUEST['spl_comment']);
                    unset($cart[$cart_id]['product_details'][$type]['passengerDetails']);
                    if(isset($_REQUEST['surtitle']) && trim($_REQUEST['surtitle'])!='')
                    {
                    $cart[$cart_id]['product_details'][$type]['passengerDetails'][0]['surtitle']=trim($_REQUEST['surtitle']);
                    $cart[$cart_id]['product_details'][$type]['passengerDetails'][0]['pasengername']=trim($_REQUEST['pasengername']);
                    $cart[$cart_id]['product_details'][$type]['passengerDetails'][0]['fname']=trim($_REQUEST['fname']); 
                    $cart[$cart_id]['product_details'][$type]['passengerDetails'][0]['tnum']=trim($_REQUEST['tnum']);
                    }
                   // if(isset($_REQUEST['totalfieldsadded']) && trim($_REQUEST['totalfieldsadded'])>0)
                    if(isset($_REQUEST['totalfieldsadded']))    
                    {
                        $inc=1;
                        for($i=0;$i<=trim($_REQUEST['fieldcount']);$i++)
                        {
                           if(isset($_REQUEST['surtitle$'.$i]) && trim($_REQUEST['surtitle$'.$i])!='')
                           {
                            $cart[$cart_id]['product_details'][$type]['passengerDetails'][$inc]['surtitle']=trim($_REQUEST['surtitle$'.$i]);
                            $cart[$cart_id]['product_details'][$type]['passengerDetails'][$inc]['pasengername']=trim($_REQUEST['pasengername$'.$i]);
                            $cart[$cart_id]['product_details'][$type]['passengerDetails'][$inc]['fname']=trim($_REQUEST['fname$'.$i]); 
                            $cart[$cart_id]['product_details'][$type]['passengerDetails'][$inc]['tnum']=trim($_REQUEST['tnum$'.$i]); 
                            $inc++;
                           }
                        }
                    }
                   
                    
                }
                 $cart[$cart_id]['product_details'][$type]['status']='complete';
             } 
               if(isset($_REQUEST['serv_type']) && (trim($_REQUEST['serv_type'])=='service_as_transfer' || trim($cart[$cart_id]['product_details']['serv_type'])=='meet_greet' )){
                if(isset($_REQUEST['typetrans']) && (trim($_REQUEST['typetrans'])=='in' || trim($_REQUEST['typetrans'])=='IN' ))
                { 
                    //$cart[$cart_id]['product_details'][$type]['ariport_arriv']=trim($_REQUEST['ariport_arriv']);
                    $cart[$cart_id]['product_details'][$type]['ariport_origin']=trim($_REQUEST['ariport_origin']);
                    $cart[$cart_id]['product_details'][$type]['arriv_day']=trim($_REQUEST['arriv_day']);
                    if(trim($_REQUEST['typetrans'])=='IN' )
                    {
                        $date=trim($_REQUEST['arriv_day']);  
                        $dtarr=explode('/',$date);
                        $date=$dtarr[2].'-'.$dtarr[1].'-'.$dtarr[0]; 
                        $date = strtotime($date);
                        $date = date("l", $date);
                        $date = strtolower($date);
                        
                         if(($date == "saturday" || $date == "sunday") && $cart[$cart_id]['product_details'][$type]['srch']['applied']=='weekday'){
                            $cart[$cart_id]['product_details'][$type]['srch']['applied']='weekend';
                            $pricetoStore=$cart[$cart_id]['product_details'][$type]['srch']['custend_price'];
                            //Check for travek agent Login
                            if(isset($user->roles[5]))
                            { 
                                $agt_comm=$cart[$cart_id]['product_details'][$type]['srch']['agt_comm'];
                                $pricetoStore=$pricetoStore-(($pricetoStore*$agt_comm)/100);
                            }
                            $cart[$cart_id]['product_details'][$type]['price']=$pricetoStore;
                        }
                        else if(($date != "saturday" && $date != "sunday") && $cart[$cart_id]['product_details'][$type]['srch']['applied']=='weekend'){
                            $cart[$cart_id]['product_details'][$type]['srch']['applied']='weekday';
                            $pricetoStore=$cart[$cart_id]['product_details'][$type]['srch']['custday_price'];
                            //Check for travek agent Login
                            if(isset($user->roles[5]))
                            { 
                                $agt_comm=$cart[$cart_id]['product_details'][$type]['srch']['agt_comm'];
                                $pricetoStore=$pricetoStore-(($pricetoStore*$agt_comm)/100);
                            }
                            
                            $cart[$cart_id]['product_details'][$type]['price']=$pricetoStore;
                        } 
                    }
                    $arriv_hr_mt=trim($_REQUEST['arriv_hr_mt']);
                    $arrtime=explode(" ",$arriv_hr_mt);                    
                    $arriv_hr='';
                    $arriv_mt='';
                    if(isset($arrtime[0]) && trim($arrtime[0])!='')
                    {
                        $arrhr=explode(":",$arrtime[0]);                       
                        $arriv_hr=$arrhr[0];
                        $arriv_mt=$arrhr[1];
                    }
                    $arriv_meridian='';
                    if(isset($arrtime[1]) && trim($arrtime[1])!=''){$arriv_meridian=trim($arrtime[1]);}
                        
                    $cart[$cart_id]['product_details'][$type]['arriv_hr']=$arriv_hr;
                    $cart[$cart_id]['product_details'][$type]['arriv_mt']=$arriv_mt;
                    $cart[$cart_id]['product_details'][$type]['arriv_meridian']=$arriv_meridian;
                    
                    
                    /*
                    $cart[$cart_id]['product_details'][$type]['arriv_hr']=trim($_REQUEST['arriv_hr']);
                    $cart[$cart_id]['product_details'][$type]['arriv_mt']=trim($_REQUEST['arriv_mt']);
                    $cart[$cart_id]['product_details'][$type]['arriv_meridian']=trim($_REQUEST['arriv_meridian']);*/
                    $cart[$cart_id]['product_details'][$type]['airline']=trim($_REQUEST['airline']);
                    $cart[$cart_id]['product_details'][$type]['airline_OthersTxt']='';
                    if(isset($_REQUEST['airline_OthersTxt']) && trim($_REQUEST['airline_OthersTxt'])!='' && trim($_REQUEST['airline'])=='Others'){
                        $cart[$cart_id]['product_details'][$type]['airline_OthersTxt']=trim($_REQUEST['airline_OthersTxt']);
                    }
                    $cart[$cart_id]['product_details'][$type]['flight_no']=trim($_REQUEST['flight_no']); 
                    $cart[$cart_id]['product_details'][$type]['driv_lang']=trim($_REQUEST['driv_lang']);
                    $cart[$cart_id]['product_details'][$type]['spl_comment']=trim($_REQUEST['spl_comment']);
                    unset($cart[$cart_id]['product_details'][$type]['passengerDetails']);
                    if(isset($_REQUEST['surtitle']) && trim($_REQUEST['surtitle'])!='')
                    {
                    $cart[$cart_id]['product_details'][$type]['passengerDetails'][0]['surtitle']=trim($_REQUEST['surtitle']);
                    $cart[$cart_id]['product_details'][$type]['passengerDetails'][0]['pasengername']=trim($_REQUEST['pasengername']);
                    $cart[$cart_id]['product_details'][$type]['passengerDetails'][0]['fname']=trim($_REQUEST['fname']); 
                    $cart[$cart_id]['product_details'][$type]['passengerDetails'][0]['tnum']=trim($_REQUEST['tnum']);
                    }
                   // if(isset($_REQUEST['totalfieldsadded']) && trim($_REQUEST['totalfieldsadded'])>0)
                    if(isset($_REQUEST['totalfieldsadded']))    
                    {
                        $inc=1;
                        for($i=0;$i<=trim($_REQUEST['fieldcount']);$i++)
                        {
                           if(isset($_REQUEST['surtitle$'.$i]) && trim($_REQUEST['surtitle$'.$i])!='')
                           {
                            $cart[$cart_id]['product_details'][$type]['passengerDetails'][$inc]['surtitle']=trim($_REQUEST['surtitle$'.$i]);
                            $cart[$cart_id]['product_details'][$type]['passengerDetails'][$inc]['pasengername']=trim($_REQUEST['pasengername$'.$i]);
                            $cart[$cart_id]['product_details'][$type]['passengerDetails'][$inc]['fname']=trim($_REQUEST['fname$'.$i]); 
                            $cart[$cart_id]['product_details'][$type]['passengerDetails'][$inc]['tnum']=trim($_REQUEST['tnum$'.$i]); 
                            $inc++;
                           }
                        }
                    }
                    if($type=='in')
                    {
                        $cart[$cart_id]['product_details'][$type]['dest_addr']=trim($_REQUEST['dest_addr']); 
                        $cart[$cart_id]['product_details'][$type]['dest_addr_OthersTxt']='';
                        if(isset($_REQUEST['dest_addr_OthersTxt']) && trim($_REQUEST['dest_addr_OthersTxt'])!=''){
                            $cart[$cart_id]['product_details'][$type]['dest_addr_OthersTxt']=trim($_REQUEST['dest_addr_OthersTxt']);
                        }
                    }
                    
                    $cart[$cart_id]['product_details'][$type]['status']='complete';
                } 
                elseif(isset($_REQUEST['typetrans']) && (trim($_REQUEST['typetrans'])=='out' || trim($_REQUEST['typetrans'])=='Out' ))
                { 
                    $cart[$cart_id]['product_details'][$type]['serv_day']=trim($_REQUEST['serv_day']);
                    $cart[$cart_id]['product_details'][$type]['airport_dept']=trim($_REQUEST['airport_dept']);
                    if(isset($_REQUEST['airport_dept_OthersTxt']) && trim($_REQUEST['airport_dept_OthersTxt'])!='' && trim($_REQUEST['airport_dept'])=='others'){
                        $cart[$cart_id]['product_details'][$type]['airport_dept_OthersTxt']=trim($_REQUEST['airport_dept_OthersTxt']);
                    }
                    $cart[$cart_id]['product_details'][$type]['airlineout']=trim($_REQUEST['airlineout']);
                    if(isset($_REQUEST['airlineout_OthersTxt']) && trim($_REQUEST['airlineout_OthersTxt'])!='' && trim($_REQUEST['airlineout'])=='Others'){
                        $cart[$cart_id]['product_details'][$type]['airlineout_OthersTxt']=trim($_REQUEST['airlineout_OthersTxt']);
                    }
                    $cart[$cart_id]['product_details'][$type]['flight_no_out']=trim($_REQUEST['flight_no_out']);
                    
                    $cart[$cart_id]['product_details'][$type]['driv_lang_out']=trim($_REQUEST['driv_lang_out']);
                    $cart[$cart_id]['product_details'][$type]['spl_comment_out']=trim($_REQUEST['spl_comment_out']);
                    unset($cart[$cart_id]['product_details'][$type]['passengerDetails']);
                    if(isset($_REQUEST['surtitle_out']) && trim($_REQUEST['surtitle_out'])!='')
                    {
                    $cart[$cart_id]['product_details'][$type]['passengerDetails'][0]['surtitle_out']=trim($_REQUEST['surtitle_out']);
                    $cart[$cart_id]['product_details'][$type]['passengerDetails'][0]['pasengername_out']=trim($_REQUEST['pasengername_out']);
                    $cart[$cart_id]['product_details'][$type]['passengerDetails'][0]['fname_out']=trim($_REQUEST['fname_out']); 
                    $cart[$cart_id]['product_details'][$type]['passengerDetails'][0]['tnum_out']=trim($_REQUEST['tnum_out']);
                    }
                   //if(isset($_REQUEST['totalfieldsadded']) && trim($_REQUEST['totalfieldsadded'])>0)
                    if(isset($_REQUEST['totalfieldsadded']))
                    {
                        $inc=1;
                        for($i=0;$i<=trim($_REQUEST['fieldcount']);$i++)
                        {
                           if(isset($_REQUEST['surtitle_out$'.$i]) && trim($_REQUEST['surtitle_out$'.$i])!='')
                           {
                            $cart[$cart_id]['product_details'][$type]['passengerDetails'][$inc]['surtitle_out']=trim($_REQUEST['surtitle_out$'.$i]);
                            $cart[$cart_id]['product_details'][$type]['passengerDetails'][$inc]['pasengername_out']=trim($_REQUEST['pasengername_out$'.$i]);
                            $cart[$cart_id]['product_details'][$type]['passengerDetails'][$inc]['fname_out']=trim($_REQUEST['fname_out$'.$i]); 
                            $cart[$cart_id]['product_details'][$type]['passengerDetails'][$inc]['tnum_out']=trim($_REQUEST['tnum_out$'.$i]); 
                            $inc++;
                           }
                        }
                    }
                    
                    
                    if($type=='Out')
                    {
                        $date=trim($_REQUEST['serv_day']);  
                        $dtarr=explode('/',$date);
                        $date=$dtarr[2].'-'.$dtarr[1].'-'.$dtarr[0]; 
                        $date = strtotime($date);
                        $date = date("l", $date);
                        $date = strtolower($date);
                        
                         if(($date == "saturday" || $date == "sunday") && $cart[$cart_id]['product_details'][$type]['srch']['applied']=='weekday'){
                            $cart[$cart_id]['product_details'][$type]['srch']['applied']='weekend';
                            $pricetoStore=$cart[$cart_id]['product_details'][$type]['srch']['custend_price'];
                            //Check for travek agent Login
                            if(isset($user->roles[5]))
                            { 
                                $agt_comm=$cart[$cart_id]['product_details'][$type]['srch']['agt_comm'];
                                $pricetoStore=$pricetoStore-(($pricetoStore*$agt_comm)/100);
                            }
                            $cart[$cart_id]['product_details'][$type]['price']=$pricetoStore;
                        }
                        else if(($date != "saturday" && $date != "sunday") && $cart[$cart_id]['product_details'][$type]['srch']['applied']=='weekend'){
                            $cart[$cart_id]['product_details'][$type]['srch']['applied']='weekday';
                            $pricetoStore=$cart[$cart_id]['product_details'][$type]['srch']['custday_price'];
                            //Check for travek agent Login
                            if(isset($user->roles[5]))
                            { 
                                $agt_comm=$cart[$cart_id]['product_details'][$type]['srch']['agt_comm'];
                                $pricetoStore=$pricetoStore-(($pricetoStore*$agt_comm)/100);
                            }
                            
                            $cart[$cart_id]['product_details'][$type]['price']=$pricetoStore;
                        }   
                        
                        
                        $arriv_hr_mt=trim($_REQUEST['arrivout_hr_mt']);
                        $arrtime=explode(" ",$arriv_hr_mt);                    
                        $arriv_hr='';
                        $arriv_mt='';
                        if(isset($arrtime[0]) && trim($arrtime[0])!='')
                        {
                            $arrhr=explode(":",$arrtime[0]);                       
                            $arriv_hr=$arrhr[0];
                            $arriv_mt=$arrhr[1];
                        }
                        $arriv_meridian='';
                        if(isset($arrtime[1]) && trim($arrtime[1])!=''){$arriv_meridian=trim($arrtime[1]);}
                        
                        $cart[$cart_id]['product_details'][$type]['arrivout_hr']=$arriv_hr;
                        $cart[$cart_id]['product_details'][$type]['arrivout_mt']=$arriv_mt;
                        $cart[$cart_id]['product_details'][$type]['arrivout_meridian']=$arriv_meridian;
                        
                        
                        $cart[$cart_id]['product_details'][$type]['decol_shed']=trim($_REQUEST['decol_shed']);
                        $cart[$cart_id]['product_details'][$type]['arriv_estim_tm']=trim($_REQUEST['arriv_estim_tm']);
                        $cart[$cart_id]['product_details'][$type]['meet_dest']=trim($_REQUEST['meet_dest']);
                    }
                    else{
                        
                        $decol_hr_mt=trim($_REQUEST['decolout_hr_mt']);
                        $decoltime=explode(" ",$decol_hr_mt);                    
                        $decol_hr='';
                        $decol_mt='';
                        if(isset($decoltime[0]) && trim($decoltime[0])!='')
                        {
                            $decolhr=explode(":",$decoltime[0]);                       
                            $decol_hr=$decolhr[0];
                            $decol_mt=$decolhr[1];
                        }
                        $decol_meridian='';
                        if(isset($decoltime[1]) && trim($decoltime[1])!=''){$decol_meridian=trim($decoltime[1]);}
                        
                        
                        $cart[$cart_id]['product_details'][$type]['decol_hr_out']=$decol_hr;
                        $cart[$cart_id]['product_details'][$type]['decol_mt_out']=$decol_mt;
                        $cart[$cart_id]['product_details'][$type]['decol_meridian_out']=$decol_meridian;
                        
                        $pick_hr_mt=trim($_REQUEST['pickout_hr_mt']);
                        $picktime=explode(" ",$pick_hr_mt);                    
                        $pick_hr='';
                        $pick_mt='';
                        if(isset($picktime[0]) && trim($picktime[0])!='')
                        {
                            $pickhr=explode(":",$picktime[0]);                       
                            $pick_hr=$pickhr[0];
                            $pick_mt=$pickhr[1];
                        }
                        $pick_meridian='';
                        if(isset($picktime[1]) && trim($picktime[1])!=''){$pick_meridian=trim($picktime[1]);}
                        
                        
                        $cart[$cart_id]['product_details'][$type]['pickup_hr']=$pick_hr;
                        $cart[$cart_id]['product_details'][$type]['pickup_mt']=$pick_mt;
                        $cart[$cart_id]['product_details'][$type]['pickup_meridian']=$pick_meridian;
                        $cart[$cart_id]['product_details'][$type]['pickout_addr']=trim($_REQUEST['pickout_addr']);

                        $cart[$cart_id]['product_details'][$type]['pickout_addrTxt']=trim($_REQUEST['pickout_addrTxt']);
                        /*if(isset($_REQUEST['pickout_addrTxt']) && trim($_REQUEST['pickout_addrTxt'])!='' && trim($_REQUEST['pickout_addr'])=='Others'){
                            $cart[$cart_id]['product_details'][$type]['pickout_addrTxt']=trim($_REQUEST['pickout_addrTxt']);
                        }*/
                        $cart[$cart_id]['product_details'][$type]['dropoffout_addr']=trim($_REQUEST['dropoffout_addr']);
                        $cart[$cart_id]['product_details'][$type]['dropoffout_addrTxt']='';
                        if(isset($_REQUEST['dropoffout_addrTxt']) && trim($_REQUEST['dropoffout_addrTxt'])!='' && trim($_REQUEST['dropoffout_addr'])=='Others'){
                            $cart[$cart_id]['product_details'][$type]['dropoffout_addrTxt']=trim($_REQUEST['dropoffout_addrTxt']);
                        }
                    }
                    $cart[$cart_id]['product_details'][$type]['status']='complete';
                } 
                elseif(isset($_REQUEST['typetrans']) && (trim($_REQUEST['typetrans'])=='in&out' || trim($_REQUEST['typetrans'])=='Commute') )  
                {
                    $typeIn='in';
                    $typeOut='Out';
                    if($type=='Commute')
                    $typeIn='IN';    
                    if($typeIn=='IN')
                    {
                        $date=trim($_REQUEST['arriv_day']);  
                        $dtarr=explode('/',$date);
                        $date=$dtarr[2].'-'.$dtarr[1].'-'.$dtarr[0]; 
                        $date = strtotime($date);
                        $date = date("l", $date);
                        $date = strtolower($date);
                        
                         if(($date == "saturday" || $date == "sunday") && $cart[$cart_id]['product_details'][$type]['srch']['applied']=='weekday'){
                            $cart[$cart_id]['product_details'][$type]['srch']['applied']='weekend';
                            $pricetoStore=$cart[$cart_id]['product_details'][$type]['srch']['custend_price'];
                            //Check for travek agent Login
                            if(isset($user->roles[5]))
                            { 
                                $agt_comm=$cart[$cart_id]['product_details'][$type]['srch']['agt_comm'];
                                $pricetoStore=$pricetoStore-(($pricetoStore*$agt_comm)/100);
                            }
                            $cart[$cart_id]['product_details'][$type]['price']=$pricetoStore;
                        }
                        else if(($date != "saturday" && $date != "sunday") && $cart[$cart_id]['product_details'][$type]['srch']['applied']=='weekend'){
                            $cart[$cart_id]['product_details'][$type]['srch']['applied']='weekday';
                            $pricetoStore=$cart[$cart_id]['product_details'][$type]['srch']['custday_price'];
                            //Check for travek agent Login
                            if(isset($user->roles[5]))
                            { 
                                $agt_comm=$cart[$cart_id]['product_details'][$type]['srch']['agt_comm'];
                                $pricetoStore=$pricetoStore-(($pricetoStore*$agt_comm)/100);
                            }
                            
                            $cart[$cart_id]['product_details'][$type]['price']=$pricetoStore;
                        }                       
                       
                    }
                    
                    $cart[$cart_id]['product_details'][$type][$typeIn]['ariport_origin']=trim($_REQUEST['ariport_origin']);
                    $cart[$cart_id]['product_details'][$type][$typeIn]['arriv_day']=trim($_REQUEST['arriv_day']);
                    
                    $arriv_hr_mt=trim($_REQUEST['arriv_hr_mt']);
                    $arrtime=explode(" ",$arriv_hr_mt);                    
                    $arriv_hr='';
                    $arriv_mt='';
                    if(isset($arrtime[0]) && trim($arrtime[0])!='')
                    {
                        $arrhr=explode(":",$arrtime[0]);                       
                        $arriv_hr=$arrhr[0];
                        $arriv_mt=$arrhr[1];
                    }
                    $arriv_meridian='';
                    if(isset($arrtime[1]) && trim($arrtime[1])!=''){$arriv_meridian=trim($arrtime[1]);}
                        
                    $cart[$cart_id]['product_details'][$type][$typeIn]['arriv_hr']=$arriv_hr;
                    $cart[$cart_id]['product_details'][$type][$typeIn]['arriv_mt']=$arriv_mt;
                    $cart[$cart_id]['product_details'][$type][$typeIn]['arriv_meridian']=$arriv_meridian;
                    
                    
                   
                    $cart[$cart_id]['product_details'][$type][$typeIn]['airline']=trim($_REQUEST['airline']);
                    $cart[$cart_id]['product_details'][$type][$typeIn]['airline_OthersTxt']='';
                    if(isset($_REQUEST['airline_OthersTxt']) && trim($_REQUEST['airline_OthersTxt'])!='' && trim($_REQUEST['airline'])=='Others'){
                        $cart[$cart_id]['product_details'][$type][$typeIn]['airline_OthersTxt']=trim($_REQUEST['airline_OthersTxt']);
                    }
                    $cart[$cart_id]['product_details'][$type][$typeIn]['flight_no']=trim($_REQUEST['flight_no']); 
                    $cart[$cart_id]['product_details'][$type][$typeIn]['driv_lang']=trim($_REQUEST['driv_lang']);
                    $cart[$cart_id]['product_details'][$type][$typeIn]['spl_comment']=trim($_REQUEST['spl_comment']);
                    unset($cart[$cart_id]['product_details'][$type][$typeIn]['passengerDetails']);
                    if(isset($_REQUEST['surtitle']) && trim($_REQUEST['surtitle'])!='')
                    {
                        $cart[$cart_id]['product_details'][$type][$typeIn]['passengerDetails'][0]['surtitle']=trim($_REQUEST['surtitle']);
                        $cart[$cart_id]['product_details'][$type][$typeIn]['passengerDetails'][0]['pasengername']=trim($_REQUEST['pasengername']);
                        $cart[$cart_id]['product_details'][$type][$typeIn]['passengerDetails'][0]['fname']=trim($_REQUEST['fname']); 
                        $cart[$cart_id]['product_details'][$type][$typeIn]['passengerDetails'][0]['tnum']=trim($_REQUEST['tnum']);
                        if(!isset($cart[$cart_id]['product_details'][$type][$typeOut]['passengerDetails'][0]))
                        {
                            $cart[$cart_id]['product_details'][$type][$typeOut]['passengerDetails'][0]['surtitle_out']=trim($_REQUEST['surtitle']);
                            $cart[$cart_id]['product_details'][$type][$typeOut]['passengerDetails'][0]['pasengername_out']=trim($_REQUEST['pasengername']);
                            $cart[$cart_id]['product_details'][$type][$typeOut]['passengerDetails'][0]['fname_out']=trim($_REQUEST['fname']); 
                            $cart[$cart_id]['product_details'][$type][$typeOut]['passengerDetails'][0]['tnum_out']=trim($_REQUEST['tnum']);
                        }
                    }
                    //if(isset($_REQUEST['totalfieldsadded']) && trim($_REQUEST['totalfieldsadded'])>0)
                    if(isset($_REQUEST['totalfieldsadded']))    
                    {
                        $inc=1;
                        for($i=0;$i<=trim($_REQUEST['fieldcount']);$i++)
                        {
                           if(isset($_REQUEST['surtitle$'.$i]) && trim($_REQUEST['surtitle$'.$i])!='')
                           {
                            $cart[$cart_id]['product_details'][$type][$typeIn]['passengerDetails'][$inc]['surtitle']=trim($_REQUEST['surtitle$'.$i]);
                            $cart[$cart_id]['product_details'][$type][$typeIn]['passengerDetails'][$inc]['pasengername']=trim($_REQUEST['pasengername$'.$i]);
                            $cart[$cart_id]['product_details'][$type][$typeIn]['passengerDetails'][$inc]['fname']=trim($_REQUEST['fname$'.$i]); 
                            $cart[$cart_id]['product_details'][$type][$typeIn]['passengerDetails'][$inc]['tnum']=trim($_REQUEST['tnum$'.$i]); 
                            if(!isset($cart[$cart_id]['product_details'][$type][$typeOut]['passengerDetails'][$inc]))
                            {
                                $cart[$cart_id]['product_details'][$type][$typeOut]['passengerDetails'][$inc]['surtitle_out']=trim($_REQUEST['surtitle$'.$i]);
                                $cart[$cart_id]['product_details'][$type][$typeOut]['passengerDetails'][$inc]['pasengername_out']=trim($_REQUEST['pasengername$'.$i]);
                                $cart[$cart_id]['product_details'][$type][$typeOut]['passengerDetails'][$inc]['fname_out']=trim($_REQUEST['fname$'.$i]); 
                                $cart[$cart_id]['product_details'][$type][$typeOut]['passengerDetails'][$inc]['tnum_out']=trim($_REQUEST['tnum$'.$i]); 
                            }
                            $inc++;
                           }
                        }
                    }
                    if($type=='in&out')
                    {
                        $cart[$cart_id]['product_details'][$type][$typeIn]['dest_addr']=trim($_REQUEST['dest_addr']); 
                        $cart[$cart_id]['product_details'][$type][$typeIn]['dest_addr_OthersTxt']='';
                        if(isset($_REQUEST['dest_addr_OthersTxt']) && trim($_REQUEST['dest_addr_OthersTxt'])!=''){
                            $cart[$cart_id]['product_details'][$type][$typeIn]['dest_addr_OthersTxt']=trim($_REQUEST['dest_addr_OthersTxt']);
                        }
                    }
               }
            }
           }
           elseif(isset($_REQUEST['section']) && trim($_REQUEST['section'])=='2')
           { 
            if(isset($_REQUEST['serv_type']) && (trim($_REQUEST['serv_type'])=='service_as_transfer' || trim($cart[$cart_id]['product_details']['serv_type'])=='meet_greet' )){
                if(isset($_REQUEST['typetrans']) && (trim($_REQUEST['typetrans'])=='in&out' || trim($_REQUEST['typetrans'])=='Commute') )  
                {  
                    $typeOut='out';
                    if($type=='Commute')
                    $typeOut='Out'; 
                    
                    if($typeIn=='Out')
                    {
                        $date=trim($_REQUEST['serv_day']);  
                        $dtarr=explode('/',$date);
                        $date=$dtarr[2].'-'.$dtarr[1].'-'.$dtarr[0]; 
                        $date = strtotime($date);
                        $date = date("l", $date);
                        $date = strtolower($date);
                        
                        if(($date == "saturday" || $date == "sunday") && $cart[$cart_id]['product_details'][$type]['srch']['applied']=='weekday'){
                            $cart[$cart_id]['product_details'][$type]['srch']['applied']='weekend';
                            $pricetoStore=$cart[$cart_id]['product_details'][$type]['srch']['custend_price'];
                            //Check for travek agent Login
                            if(isset($user->roles[5]))
                            { 
                                $agt_comm=$cart[$cart_id]['product_details'][$type]['srch']['agt_comm'];
                                $pricetoStore=$pricetoStore-(($pricetoStore*$agt_comm)/100);
                            }
                            $cart[$cart_id]['product_details'][$type]['price']=$pricetoStore;
                        }
                        else if(($date != "saturday" && $date != "sunday") && $cart[$cart_id]['product_details'][$type]['srch']['applied']=='weekend'){
                            $cart[$cart_id]['product_details'][$type]['srch']['applied']='weekday';
                            $pricetoStore=$cart[$cart_id]['product_details'][$type]['srch']['custday_price'];
                            //Check for travek agent Login
                            if(isset($user->roles[5]))
                            { 
                                $agt_comm=$cart[$cart_id]['product_details'][$type]['srch']['agt_comm'];
                                $pricetoStore=$pricetoStore-(($pricetoStore*$agt_comm)/100);
                            }
                            
                            $cart[$cart_id]['product_details'][$type]['price']=$pricetoStore;
                        }
                    }
                    
                    $cart[$cart_id]['product_details'][$type][$typeOut]['serv_day']=trim($_REQUEST['serv_day']);
                    
                    $cart[$cart_id]['product_details'][$type][$typeOut]['airport_dept']=trim($_REQUEST['airport_dept']);
                    if(isset($_REQUEST['airport_dept_OthersTxt']) && trim($_REQUEST['airport_dept_OthersTxt'])!='' && trim($_REQUEST['airport_dept'])=='others'){
                        $cart[$cart_id]['product_details'][$type][$typeOut]['airport_dept_OthersTxt']=trim($_REQUEST['airport_dept_OthersTxt']);
                    }
                  
                    
                    $cart[$cart_id]['product_details'][$type][$typeOut]['airlineout']=trim($_REQUEST['airlineout']);
                     $cart[$cart_id]['product_details'][$type][$typeOut]['airlineout_OthersTxt']='';
                    if(isset($_REQUEST['airlineout_OthersTxt']) && trim($_REQUEST['airlineout_OthersTxt'])!='' && trim($_REQUEST['airlineout'])=='Others'){
                        $cart[$cart_id]['product_details'][$type][$typeOut]['airlineout_OthersTxt']=trim($_REQUEST['airlineout_OthersTxt']);
                    }
                    
                    $cart[$cart_id]['product_details'][$type][$typeOut]['flight_no_out']=trim($_REQUEST['flight_no_out']);
                    
                    
                    
                    $cart[$cart_id]['product_details'][$type][$typeOut]['driv_lang_out']=trim($_REQUEST['driv_lang_out']);
                    $cart[$cart_id]['product_details'][$type][$typeOut]['spl_comment_out']=trim($_REQUEST['spl_comment_out']);
                    unset($cart[$cart_id]['product_details'][$type][$typeOut]['passengerDetails']);
                    if(isset($_REQUEST['surtitle_out']) && trim($_REQUEST['surtitle_out'])!='')
                    {
                    $cart[$cart_id]['product_details'][$type][$typeOut]['passengerDetails'][0]['surtitle_out']=trim($_REQUEST['surtitle_out']);
                    $cart[$cart_id]['product_details'][$type][$typeOut]['passengerDetails'][0]['pasengername_out']=trim($_REQUEST['pasengername_out']);
                    $cart[$cart_id]['product_details'][$type][$typeOut]['passengerDetails'][0]['fname_out']=trim($_REQUEST['fname_out']); 
                    $cart[$cart_id]['product_details'][$type][$typeOut]['passengerDetails'][0]['tnum_out']=trim($_REQUEST['tnum_out']);
                    }
                    //if(isset($_REQUEST['totalfieldsadded']) && trim($_REQUEST['totalfieldsadded'])>0)
                    if(isset($_REQUEST['totalfieldsadded']))   
                    {
                        $inc=1;
                        for($i=0;$i<=trim($_REQUEST['fieldcount']);$i++)
                        {
                           if(isset($_REQUEST['surtitle_out$'.$i]) && trim($_REQUEST['surtitle_out$'.$i])!='')
                           {
                            $cart[$cart_id]['product_details'][$type][$typeOut]['passengerDetails'][$inc]['surtitle_out']=trim($_REQUEST['surtitle_out$'.$i]);
                            $cart[$cart_id]['product_details'][$type][$typeOut]['passengerDetails'][$inc]['pasengername_out']=trim($_REQUEST['pasengername_out$'.$i]);
                            $cart[$cart_id]['product_details'][$type][$typeOut]['passengerDetails'][$inc]['fname_out']=trim($_REQUEST['fname_out$'.$i]); 
                            $cart[$cart_id]['product_details'][$type][$typeOut]['passengerDetails'][$inc]['tnum_out']=trim($_REQUEST['tnum_out$'.$i]); 
                            $inc++;
                           }
                        }
                    } 
                    
                    if($type=='Commute')
                    {
                        
                        $arriv_hr_mt=trim($_REQUEST['arrivout_hr_mt']);
                        $arrtime=explode(" ",$arriv_hr_mt);                    
                        $arriv_hr='';
                        $arriv_mt='';
                        if(isset($arrtime[0]) && trim($arrtime[0])!='')
                        {
                            $arrhr=explode(":",$arrtime[0]);                       
                            $arriv_hr=$arrhr[0];
                            $arriv_mt=$arrhr[1];
                        }
                        $arriv_meridian='';
                        if(isset($arrtime[1]) && trim($arrtime[1])!=''){$arriv_meridian=trim($arrtime[1]);}
                        
                        
                        $cart[$cart_id]['product_details'][$type][$typeOut]['arrivout_hr']=$arriv_hr;
                        $cart[$cart_id]['product_details'][$type][$typeOut]['arrivout_mt']=$arriv_mt;
                        $cart[$cart_id]['product_details'][$type][$typeOut]['arrivout_meridian']=$arriv_meridian;
                        
                        $cart[$cart_id]['product_details'][$type][$typeOut]['decol_shed']=trim($_REQUEST['decol_shed']);
                        $cart[$cart_id]['product_details'][$type][$typeOut]['arriv_estim_tm']=trim($_REQUEST['arriv_estim_tm']);
                        $cart[$cart_id]['product_details'][$type][$typeOut]['meet_dest']=trim($_REQUEST['meet_dest']);
                    }
                    else{
                        
                        $decol_hr_mt=trim($_REQUEST['decolout_hr_mt']);
                        $decoltime=explode(" ",$decol_hr_mt);                    
                        $decol_hr='';
                        $decol_mt='';
                        if(isset($decoltime[0]) && trim($decoltime[0])!='')
                        {
                            $decolhr=explode(":",$decoltime[0]);                       
                            $decol_hr=$decolhr[0];
                            $decol_mt=$decolhr[1];
                        }
                        $decol_meridian='';
                        if(isset($decoltime[1]) && trim($decoltime[1])!=''){$decol_meridian=trim($decoltime[1]);}
                        
                        $cart[$cart_id]['product_details'][$type][$typeOut]['decol_hr_out']=$decol_hr;
                        $cart[$cart_id]['product_details'][$type][$typeOut]['decol_mt_out']=$decol_mt;
                        $cart[$cart_id]['product_details'][$type][$typeOut]['decol_meridian_out']=$decol_meridian;
                        
                         
                        $pick_hr_mt=trim($_REQUEST['pickout_hr_mt']);
                        $picktime=explode(" ",$pick_hr_mt);                    
                        $pick_hr='';
                        $pick_mt='';
                        if(isset($picktime[0]) && trim($picktime[0])!='')
                        {
                            $pickhr=explode(":",$picktime[0]);                       
                            $pick_hr=$pickhr[0];
                            $pick_mt=$pickhr[1];
                        }
                        $pick_meridian='';
                        if(isset($picktime[1]) && trim($picktime[1])!=''){$pick_meridian=trim($picktime[1]);}
                        
                        $cart[$cart_id]['product_details'][$type][$typeOut]['pickup_hr']=$pick_hr;
                        $cart[$cart_id]['product_details'][$type][$typeOut]['pickup_mt']=$pick_mt;
                        $cart[$cart_id]['product_details'][$type][$typeOut]['pickup_meridian']=$pick_meridian;
                        $cart[$cart_id]['product_details'][$type][$typeOut]['pickout_addr']=trim($_REQUEST['pickout_addr']);

                        $cart[$cart_id]['product_details'][$type][$typeOut]['pickout_addrTxt']='';
                        if(isset($_REQUEST['pickout_addrTxt']) && trim($_REQUEST['pickout_addrTxt'])!='' && trim($_REQUEST['pickout_addr'])=='Others'){
                            $cart[$cart_id]['product_details'][$type][$typeOut]['pickout_addrTxt']=trim($_REQUEST['pickout_addrTxt']);
                        }

                        $cart[$cart_id]['product_details'][$type][$typeOut]['dropoffout_addr']=trim($_REQUEST['dropoffout_addr']);
                        $cart[$cart_id]['product_details'][$type][$typeOut]['dropoffout_addrTxt']='';
                        if(isset($_REQUEST['dropoffout_addrTxt']) && trim($_REQUEST['dropoffout_addrTxt'])!='' && trim($_REQUEST['dropoffout_addr'])=='Others'){
                            $cart[$cart_id]['product_details'][$type][$typeOut]['dropoffout_addrTxt']=trim($_REQUEST['dropoffout_addrTxt']);
                        }
                    }
                    
                    
                    $cart[$cart_id]['product_details'][$type]['status']='complete';
                }
            } 
            
           }
           
        }
        
    }
    
    //$newArry = array_reverse($newArry, true);
    //$cart = $newArry;     
    $_SESSION['products'] = serialize($cart);
    //product reassion process starts
    prefillstep();

}
function prefillstep(){
    $cart = unserialize($_SESSION['products']);    
    if(count($cart)>0)
    {
        $tempArry = $cart;
        /******* prefill data one way to one way & one way to round trip *****************/
        foreach($tempArry as $key => $details) {

           if (($details['product_details']['serv_type'] == 'meet_greet') && (isset($details['product_details']['IN']))) {
                    if($details['product_details']['IN']['status'] == 'complete'){                         
                       $completeInfo = $details;                    
                    }
            }          
           if (($details['product_details']['serv_type'] == 'meet_greet') && (isset($details['product_details']['Out']))) {
                    if($details['product_details']['Out']['status'] == 'complete'){                         
                       $completeInfoOut = $details;                     
                    }
            }
            if (($details['product_details']['serv_type'] == 'service_as_transfer') && (isset($details['product_details']['in']))) {
                    if($details['product_details']['in']['status'] == 'complete'){                      
                       $transferIn = $details;                     
                    }
            }
            if (($details['product_details']['serv_type'] == 'service_as_transfer') && (isset($details['product_details']['out']))) {
                    if($details['product_details']['out']['status'] == 'complete'){                         
                       $transferOut = $details;                     
                    }
            }
            if (($details['product_details']['serv_type'] == 'meet_greet') && (isset($details['product_details']['Commute']))) {
                       if ($details['product_details']['Commute']['status'] == "complete") {
                           $meetinout = $details; 
                        }
            }
            if(($details['product_details']['serv_type'] == 'service_as_transfer') && (isset($details['product_details']['in&out']))) {
               if($details['product_details']['in&out']['status'] == 'complete')    {
                     $transferinout = $details;
               }
            }
            if (($details['product_details']['serv_type'] == 'service_as_transfer') && (isset($details['product_details']['in']))) {
                    if(($details['product_details']['in']['status'] != 'complete') && count($transferIn)){                      
                     
                        $details['person_details']['in']['arrival_tm'] = $transferIn['person_details']['in']['arrival_tm'];
                        $details['person_details']['in']['wheely_bag'] = $transferIn['person_details']['in']['wheely_bag'];
                        $details['person_details']['in']['regular_bag'] = $transferIn['person_details']['in']['regular_bag'];
                        $details['person_details']['in']['no_people'] = $transferIn['person_details']['in']['no_people'];
                        $details['person_details']['in']['no_people_OthersTxt'] = $transferIn['person_details']['in']['no_people_OthersTxt'];
                        $details['person_details']['in']['odd_bag'] = $transferIn['person_details']['in']['odd_bag'];
                        $details['person_details']['in']['odd_bag_OthersTxt'] = $transferIn['person_details']['in']['odd_bag_OthersTxt'];
                        $details['person_details']['in']['dsec_lugg'] = $transferIn['person_details']['in']['dsec_lugg'];
                        /*** Product details ***/
                        $details['product_details']['in']['ariport_arriv'] = $transferIn['product_details']['in']['ariport_arriv'];
                        $details['product_details']['in']['ariport_origin'] = $transferIn['product_details']['in']['ariport_origin'];
                        $details['product_details']['in']['arriv_day'] = $transferIn['product_details']['in']['arriv_day'];
                        $details['product_details']['in']['arriv_hr'] = $transferIn['product_details']['in']['arriv_hr'];
                        $details['product_details']['in']['arriv_mt'] = $transferIn['product_details']['in']['arriv_mt'];
                        $details['product_details']['in']['arriv_meridian'] = $transferIn['product_details']['in']['arriv_meridian'];
                        $details['product_details']['in']['airline'] = $transferIn['product_details']['in']['airline'];
                        $details['product_details']['in']['airline_OthersTxt'] = $transferIn['product_details']['in']['airline_OthersTxt'];
                        $details['product_details']['in']['flight_no'] = $transferIn['product_details']['in']['flight_no'];
                        $details['product_details']['in']['driv_lang'] = $transferIn['product_details']['in']['driv_lang'];
                        $details['product_details']['in']['spl_comment'] = $transferIn['product_details']['in']['spl_comment'];
                        $details['product_details']['in']['passengerDetails'] = $transferIn['product_details']['in']['passengerDetails'];
                    }
            }
            if (($details['product_details']['serv_type'] == 'service_as_transfer') && (isset($details['product_details']['out']))) {
                    if(($details['product_details']['out']['status'] != 'complete') && count($transferOut)){                         

                        $details['person_details']['out']['arrival_tm'] = $transferOut['person_details']['out']['arrival_tm'];
                        $details['person_details']['out']['wheely_bag'] = $transferOut['person_details']['out']['wheely_bag'];
                        $details['person_details']['out']['regular_bag'] = $transferOut['person_details']['out']['regular_bag'];
                        $details['person_details']['out']['no_people'] = $transferOut['person_details']['out']['no_people'];
                        $details['person_details']['out']['no_people_OthersTxt'] = $transferOut['person_details']['out']['no_people_OthersTxt'];
                        $details['person_details']['out']['odd_bag'] = $transferOut['person_details']['out']['odd_bag'];
                        $details['person_details']['out']['odd_bag_OthersTxt'] = $transferOut['person_details']['out']['odd_bag_OthersTxt'];
                        $details['person_details']['out']['dsec_lugg'] = $transferOut['person_details']['out']['dsec_lugg'];
                        /*** Product details ***/
                        $details['product_details']['out']['ariport_arriv'] = $transferOut['product_details']['out']['ariport_arriv'];
                        $details['product_details']['out']['ariport_origin'] = $transferOut['product_details']['out']['ariport_origin'];
                        $details['product_details']['out']['airport_dept']  = $transferOut['product_details']['out']['meet_dest'];
                        $details['product_details']['out']['serv_day'] = $transferOut['product_details']['out']['serv_day'];
                        $details['product_details']['out']['decol_hr_out'] = $transferOut['product_details']['out']['arrivout_hr'];
                        $details['product_details']['out']['decol_mt_out'] = $transferOut['product_details']['out']['arrivout_mt'];
                        $details['product_details']['out']['decol_meridian_out'] = $transferOut['product_details']['out']['arrivout_meridian'];
                        $details['product_details']['out']['airlineout'] = $transferOut['product_details']['out']['airlineout'];
                        $details['product_details']['out']['airline_OthersTxt'] = $transferOut['product_details']['out']['airline_OthersTxt'];
                        $details['product_details']['out']['flight_no_out'] = $transferOut['product_details']['out']['flight_no_out'];
                        $details['product_details']['out']['driv_lang_out'] = $transferOut['product_details']['out']['driv_lang_out'];
                        $details['product_details']['out']['spl_comment'] = $transferOut['product_details']['out']['spl_comment'];
                        $details['product_details']['out']['passengerDetails'] = $transferOut['product_details']['out']['passengerDetails'];       
                    }
            }    
            if (($details['product_details']['serv_type'] == 'meet_greet') && (isset($details['product_details']['Commute']))) {
                       if (($details['product_details']['Commute']['status']!= "complete") && (count($completeInfoOut) || count($completeInfo))) {
                            $details['product_details']['Commute']['Out'] = $completeInfoOut['product_details']['Out'];
                            $details['product_details']['Commute']['IN'] = $completeInfo['product_details']['IN'];
                            $details['person_details']['Commute'] = $completeInfo['person_details']['IN'];
                       }
                       if(($details['product_details']['Commute']['status']!= "complete") && (count($transferIn) || count($transferOut))) {
                            $details['product_details']['Commute']['Out'] = $transferOut['product_details']['out'];
                            $details['product_details']['Commute']['IN'] = $transferIn['product_details']['in'];
                            $details['person_details']['Commute'] = $transferIn['person_details']['in'];
                       }
                       if (($details['product_details']['Commute']['status']!= "complete") && (count($transferinout))) {
                            $details['product_details']['Commute']['Out'] = $transferOut['product_details']['out'];
                            $details['product_details']['Commute']['IN'] = $transferIn['product_details']['in'];
                            $details['person_details']['Commute'] = $transferIn['person_details']['in'];
                       }                       
                       if (($details['product_details']['Commute']['status']!= "complete") && count($meetinout)) {
                            $details['product_details']['Commute']['Out'] = $meetinout['product_details']['Commute']['Out'] ;
                            $details['product_details']['Commute']['IN'] = $meetinout['product_details']['Commute']['IN'];
                            $details['person_details']['Commute'] = $meetinout['person_details']['Commute'];
                       }
                        
             }
             if (($details['product_details']['serv_type'] == 'meet_greet') && (isset($details['product_details']['IN']))) {
                    if(($details['product_details']['IN']['status'] != 'complete') && count($completeInfo)){                         
                            $details['person_details']['IN']['arrival_tm'] = $completeInfo['person_details']['IN']['arrival_tm'];
                            $details['person_details']['IN']['wheely_bag'] = $completeInfo['person_details']['IN']['wheely_bag'];
                            $details['person_details']['IN']['regular_bag'] = $completeInfo['person_details']['IN']['regular_bag'];
                            $details['person_details']['IN']['no_people'] = $completeInfo['person_details']['IN']['no_people'];
                            $details['person_details']['IN']['no_people_OthersTxt'] = $completeInfo['person_details']['IN']['no_people_OthersTxt'];
                            $details['person_details']['IN']['odd_bag'] = $completeInfo['person_details']['IN']['odd_bag'];
                            $details['person_details']['IN']['odd_bag_OthersTxt'] = $completeInfo['person_details']['IN']['odd_bag_OthersTxt'];
                            $details['person_details']['IN']['dsec_lugg'] = $completeInfo['person_details']['IN']['dsec_lugg'];
                            /*** Product details ***/
                            $details['product_details']['IN']['ariport_arriv'] = $completeInfo['product_details']['IN']['ariport_arriv'];
                            $details['product_details']['IN']['ariport_origin'] = $completeInfo['product_details']['IN']['ariport_origin'];
                            $details['product_details']['IN']['arriv_day'] = $completeInfo['product_details']['IN']['arriv_day'];
                            $details['product_details']['IN']['arriv_hr'] = $completeInfo['product_details']['IN']['arriv_hr'];
                            $details['product_details']['IN']['arriv_mt'] = $completeInfo['product_details']['IN']['arriv_mt'];
                            $details['product_details']['IN']['arriv_meridian'] = $completeInfo['product_details']['IN']['arriv_meridian'];
                            $details['product_details']['IN']['airline'] = $completeInfo['product_details']['IN']['airline'];
                            $details['product_details']['IN']['airline_OthersTxt'] = $completeInfo['product_details']['IN']['airline_OthersTxt'];
                            $details['product_details']['IN']['flight_no'] = $completeInfo['product_details']['IN']['flight_no'];
                            $details['product_details']['IN']['driv_lang'] = $completeInfo['product_details']['IN']['driv_lang'];
                            $details['product_details']['IN']['spl_comment'] = $completeInfo['product_details']['IN']['spl_comment'];
                            $details['product_details']['IN']['passengerDetails'] = $completeInfo['product_details']['IN']['passengerDetails'];                       
                    }
            }

             if (($details['product_details']['serv_type'] == 'meet_greet') && (isset($details['product_details']['Out']))) {
                    if(($details['product_details']['Out']['status'] != 'complete') && count($completeInfoOut)) {
                         $details['person_details']['Out']['arrival_tm'] = $completeInfoOut['person_details']['Out']['arrival_tm'];
                        $details['person_details']['Out']['wheely_bag'] = $completeInfoOut['person_details']['Out']['wheely_bag'];
                        $details['person_details']['Out']['regular_bag'] = $completeInfoOut['person_details']['Out']['regular_bag'];
                        $details['person_details']['Out']['no_people'] = $completeInfoOut['person_details']['Out']['no_people'];
                        $details['person_details']['Out']['no_people_OthersTxt'] = $completeInfoOut['person_details']['Out']['no_people_OthersTxt'];
                        $details['person_details']['Out']['odd_bag'] = $completeInfoOut['person_details']['Out']['odd_bag'];
                        $details['person_details']['Out']['odd_bag_OthersTxt'] = $completeInfoOut['person_details']['Out']['odd_bag_OthersTxt'];
                        $details['person_details']['Out']['dsec_lugg'] = $completeInfoOut['person_details']['Out']['dsec_lugg'];
                        /*** Product details ***/
                        $details['product_details']['Out']['ariport_arriv'] = $completeInfoOut['product_details']['Out']['ariport_arriv'];
                        $details['product_details']['Out']['ariport_origin'] = $completeInfoOut['product_details']['Out']['ariport_origin'];
                        $details['product_details']['Out']['airport_dept']  = $completeInfoOut['product_details']['Out']['meet_dest'];
                        $details['product_details']['Out']['serv_day'] = $completeInfoOut['product_details']['Out']['serv_day'];
                        $details['product_details']['Out']['decol_hr_out'] = $completeInfoOut['product_details']['Out']['arrivout_hr'];
                        $details['product_details']['Out']['decol_mt_out'] = $completeInfoOut['product_details']['Out']['arrivout_mt'];
                        $details['product_details']['Out']['decol_meridian_out'] = $completeInfoOut['product_details']['Out']['arrivout_meridian'];
                        $details['product_details']['Out']['airlineout'] = $completeInfoOut['product_details']['Out']['airlineout'];
                        $details['product_details']['Out']['airline_OthersTxt'] = $completeInfoOut['product_details']['Out']['airline_OthersTxt'];
                        $details['product_details']['Out']['flight_no_out'] = $completeInfoOut['product_details']['Out']['flight_no_out'];
                        $details['product_details']['Out']['driv_lang_out'] = $completeInfoOut['product_details']['Out']['driv_lang_out'];
                        $details['product_details']['Out']['spl_comment'] = $completeInfoOut['product_details']['Out']['spl_comment'];
                        $details['product_details']['Out']['passengerDetails'] = $completeInfoOut['product_details']['Out']['passengerDetails'];                     
                    }
             }
            if(($details['product_details']['serv_type'] == 'service_as_transfer') && (isset($details['product_details']['in']))) {
                if (($details['product_details']['in']['status'] != 'complete') && (count($completeInfo))){                 
                $details['person_details']['in']['arrival_tm'] = $completeInfo['person_details']['IN']['arrival_tm'];
                $details['person_details']['in']['wheely_bag'] = $completeInfo['person_details']['IN']['wheely_bag'];
                $details['person_details']['in']['regular_bag'] = $completeInfo['person_details']['IN']['regular_bag'];
                $details['person_details']['in']['no_people'] = $completeInfo['person_details']['IN']['no_people'];
                $details['person_details']['in']['no_people_OthersTxt'] = $completeInfo['person_details']['IN']['no_people_OthersTxt'];
                $details['person_details']['in']['odd_bag'] = $completeInfo['person_details']['IN']['odd_bag'];
                $details['person_details']['in']['odd_bag_OthersTxt'] = $completeInfo['person_details']['IN']['odd_bag_OthersTxt'];
                $details['person_details']['in']['dsec_lugg'] = $completeInfo['person_details']['IN']['dsec_lugg'];
                /*** Product details ***/
                $details['product_details']['in']['ariport_arriv'] = $completeInfo['product_details']['IN']['ariport_arriv'];
                $details['product_details']['in']['ariport_origin'] = $completeInfo['product_details']['IN']['ariport_origin'];
                $details['product_details']['in']['arriv_day'] = $completeInfo['product_details']['IN']['arriv_day'];
                $details['product_details']['in']['arriv_hr'] = $completeInfo['product_details']['IN']['arriv_hr'];
                $details['product_details']['in']['arriv_mt'] = $completeInfo['product_details']['IN']['arriv_mt'];
                $details['product_details']['in']['arriv_meridian'] = $completeInfo['product_details']['IN']['arriv_meridian'];
                $details['product_details']['in']['airline'] = $completeInfo['product_details']['IN']['airline'];
                $details['product_details']['in']['airline_OthersTxt'] = $completeInfo['product_details']['IN']['airline_OthersTxt'];
                $details['product_details']['in']['flight_no'] = $completeInfo['product_details']['IN']['flight_no'];
                $details['product_details']['in']['driv_lang'] = $completeInfo['product_details']['IN']['driv_lang'];
                $details['product_details']['in']['spl_comment'] = $completeInfo['product_details']['IN']['spl_comment'];
                $details['product_details']['in']['passengerDetails'] = $completeInfo['product_details']['IN']['passengerDetails'];

                }
            }
          if(($details['product_details']['serv_type'] == 'service_as_transfer') && (isset($details['product_details']['out']))) {

                 if ($details['product_details']['out']['status']!='complete' && count($completeInfoOut)){               
                $details['person_details']['out']['arrival_tm'] = $completeInfoOut['person_details']['Out']['arrival_tm'];
                $details['person_details']['out']['wheely_bag'] = $completeInfoOut['person_details']['Out']['wheely_bag'];
                $details['person_details']['out']['regular_bag'] = $completeInfoOut['person_details']['Out']['regular_bag'];
                $details['person_details']['out']['no_people'] = $completeInfoOut['person_details']['Out']['no_people'];
                $details['person_details']['out']['no_people_OthersTxt'] = $completeInfoOut['person_details']['Out']['no_people_OthersTxt'];
                $details['person_details']['out']['odd_bag'] = $completeInfoOut['person_details']['Out']['odd_bag'];
                $details['person_details']['out']['odd_bag_OthersTxt'] = $completeInfoOut['person_details']['Out']['odd_bag_OthersTxt'];
                $details['person_details']['out']['dsec_lugg'] = $completeInfoOut['person_details']['Out']['dsec_lugg'];
                /*** Product details ***/
                $details['product_details']['out']['ariport_arriv'] = $completeInfoOut['product_details']['Out']['ariport_arriv'];
                $details['product_details']['out']['ariport_origin'] = $completeInfoOut['product_details']['Out']['ariport_origin'];
                $details['product_details']['out']['airport_dept']  = $completeInfoOut['product_details']['Out']['meet_dest'];
                $details['product_details']['out']['serv_day'] = $completeInfoOut['product_details']['Out']['serv_day'];
                $details['product_details']['out']['decol_hr_out'] = $completeInfoOut['product_details']['Out']['arrivout_hr'];
                $details['product_details']['out']['decol_mt_out'] = $completeInfoOut['product_details']['Out']['arrivout_mt'];
                $details['product_details']['out']['decol_meridian_out'] = $completeInfoOut['product_details']['Out']['arrivout_meridian'];
                $details['product_details']['out']['airlineout'] = $completeInfoOut['product_details']['Out']['airlineout'];
                $details['product_details']['out']['airline_OthersTxt'] = $completeInfoOut['product_details']['Out']['airline_OthersTxt'];
                $details['product_details']['out']['flight_no_out'] = $completeInfoOut['product_details']['Out']['flight_no_out'];
                $details['product_details']['out']['driv_lang_out'] = $completeInfoOut['product_details']['Out']['driv_lang_out'];
                $details['product_details']['out']['spl_comment'] = $completeInfoOut['product_details']['Out']['spl_comment'];
                $details['product_details']['out']['passengerDetails'] = $completeInfoOut['product_details']['Out']['passengerDetails'];                 
                 }
            }

            if(($details['product_details']['serv_type'] == 'service_as_transfer') && (isset($details['product_details']['in&out']))) {
                   if(($details['product_details']['in&out']['status']!='complete') && (count($transferIn) || count($transferOut))) {                     
                     $details['product_details']['in&out']['in'] = $transferIn['product_details']['in'];
                     $details['product_details']['in&out']['out'] = $transferOut['product_details']['out'];
                     $details['person_details']['in&out'] = $transferIn['person_details']['in'];
                   }
                   if (($details['product_details']['in&out']['status']!='complete') && (count($completeInfoOut) || count($completeInfo))) {
                            $details['product_details']['in&out']['out']= $completeInfoOut['product_details']['Out'];
                            $details['product_details']['in&out']['in']  = $completeInfo['product_details']['IN'];
                            $details['person_details']['in&out'] = $completeInfo['person_details']['IN'];
                    }

            }

            if(($details['product_details']['serv_type'] == 'service_as_transfer') && (isset($details['product_details']['in&out']))) {
                   if(($details['product_details']['in&out']['status']!='complete') && (count($meetinout))) {
                            $details['person_details']['in&out'] = $meetinout['person_details']['Commute'];
                            $details['product_details']['in&out']['in']['ariport_origin'] = $meetinout['product_details']['Commute']['IN']['ariport_origin'];
                            $details['product_details']['in&out']['in']['arriv_day'] = $meetinout['product_details']['Commute']['IN']['arriv_day'];
                            $details['product_details']['in&out']['in']['arriv_hr'] =  $meetinout['product_details']['Commute']['IN']['arriv_hr'];
                            $details['product_details']['in&out']['in']['arriv_mt'] =  $meetinout['product_details']['Commute']['IN']['arriv_mt'];
                            $details['product_details']['in&out']['in']['arriv_meridian'] = $meetinout['product_details']['Commute']['IN']['arriv_meridian'];
                            $details['product_details']['in&out']['in']['airline'] = $meetinout['product_details']['Commute']['IN']['airline'];
                            $details['product_details']['in&out']['in']['airline_OthersTxt'] =  $meetinout['product_details']['Commute']['IN']['airline_OthersTxt'];
                            $details['product_details']['in&out']['in']['flight_no'] = $meetinout['product_details']['Commute']['IN']['flight_no'];
                            $details['product_details']['in&out']['in']['driv_lang'] = $meetinout['product_details']['Commute']['IN']['driv_lang'];
                            $details['product_details']['in&out']['in']['spl_comment'] =  $meetinout['product_details']['Commute']['IN']['spl_comment'];
                            $details['product_details']['in&out']['in']['passengerDetails'] = $meetinout['product_details']['Commute']['IN']['passengerDetails'];

                            $details['product_details']['in&out']['out']['ariport_origin'] = $meetinout['product_details']['Commute']['Out']['ariport_origin'];
                            $details['product_details']['in&out']['out']['serv_day'] = $meetinout['product_details']['Commute']['Out']['serv_day'];
                            $details['product_details']['in&out']['out']['arrivout_hr'] =  $meetinout['product_details']['Commute']['Out']['arrivout_hr'];
                            $details['product_details']['in&out']['out']['arrivout_mt'] =  $meetinout['product_details']['Commute']['Out']['arrivout_mt'];
                            $details['product_details']['in&out']['out']['arrivout_meridian'] = $meetinout['product_details']['Commute']['Out']['arrivout_meridian'];                         
                            $details['product_details']['in&out']['out']['airline_OthersTxt'] =  $meetinout['product_details']['Commute']['Out']['airline_OthersTxt'];
                            $details['product_details']['in&out']['out']['flight_no_out'] = $meetinout['product_details']['Commute']['Out']['flight_no_out'];                         
                            $details['product_details']['in&out']['out']['spl_comment'] =  $meetinout['product_details']['Commute']['Out']['spl_comment'];                         
                   }
                    if(($details['product_details']['serv_type'] == 'service_as_transfer') && (isset($details['product_details']['in&out']))) {
                    if(($details['product_details']['in&out']['status']!='complete') && (count($transferinout))) {
                         $details['product_details']['in&out']['in'] = $transferinout['product_details']['in&out']['in'];
                         $details['product_details']['in&out']['out'] = $transferinout['product_details']['in&out']['out'];
                         $details['person_details']['in&out'] = $transferinout['person_details']['in&out'];
                        
                    }
                    }
            }
          $newArry[$key] =$details;
        }
   
        $newArry = array_reverse($newArry, true);
       /******* prefill data one way to one way & one way to round trip *****************/
        foreach($newArry as $key => $details) {

             if(($details['product_details']['serv_type'] == 'service_as_transfer') && (isset($details['product_details']['in&out']))) {
                   if($details['product_details']['in&out']['status'] =='complete') {
                            $transinout = $details;
                   }
                }
                 if (($details['product_details']['serv_type'] == 'meet_greet') && (isset($details['product_details']['Commute']))) {
                       if ($details['product_details']['Commute']['status'] == "complete") {
                            $meetinout = $details; 
                        }
                }
               if (($details['product_details']['serv_type'] == 'meet_greet') && (isset($details['product_details']['IN']))) {
                        if($details['product_details']['IN']['status'] == 'complete'){                         
                           $completeInfo = $details;                    
                        }
                }          
               if (($details['product_details']['serv_type'] == 'meet_greet') && (isset($details['product_details']['Out']))) {
                        if($details['product_details']['Out']['status'] == 'complete'){                         
                           $completeInfoOut = $details;                     
                        }
                }
                if (($details['product_details']['serv_type'] == 'service_as_transfer') && (isset($details['product_details']['in']))) {
                    if($details['product_details']['in']['status'] == 'complete'){                      
                         $transferIn = $details;                     
                    }
                }
                
                if (($details['product_details']['serv_type'] == 'service_as_transfer') && (isset($details['product_details']['out']))) {
                        if($details['product_details']['out']['status'] == 'complete'){                         
                           $transferOut = $details;                     
                        }
                }
                if(($details['product_details']['serv_type'] == 'service_as_transfer') && (isset($details['product_details']['in&out']))) {
                if(($details['product_details']['in&out']['status']!='complete') && (count($transinout))) {
                         $details['product_details']['in&out']['in'] = $transinout['product_details']['in&out']['in'];
                         $details['product_details']['in&out']['out'] = $transinout['product_details']['in&out']['out'];
                         $details['person_details']['in&out'] = $transinout['person_details']['in&out'];
                        
                }
                }
                if(($details['product_details']['serv_type'] == 'meet_greet') && (isset($details['product_details']['Commute']))) {
                if (($details['product_details']['Commute']['status']!= "complete") && count($meetinout)) {
                                    $details['product_details']['Commute']['Out'] = $meetinout['product_details']['Commute']['Out'] ;
                                        $details['product_details']['Commute']['IN'] = $meetinout['product_details']['Commute']['IN'];
                                        $details['person_details']['Commute'] = $meetinout['person_details']['Commute'];
                            }
                     }
                 if (($details['product_details']['serv_type'] == 'service_as_transfer') && (isset($details['product_details']['in']))) {
                    if(($details['product_details']['in']['status'] != 'complete') && count($transferIn)){                      
                      // $transferIn = $details;
                        $details['person_details']['in']['arrival_tm'] = $transferIn['person_details']['in']['arrival_tm'];
                        $details['person_details']['in']['wheely_bag'] = $transferIn['person_details']['in']['wheely_bag'];
                        $details['person_details']['in']['regular_bag'] = $transferIn['person_details']['in']['regular_bag'];
                        $details['person_details']['in']['no_people'] = $transferIn['person_details']['in']['no_people'];
                        $details['person_details']['in']['no_people_OthersTxt'] = $transferIn['person_details']['in']['no_people_OthersTxt'];
                        $details['person_details']['in']['odd_bag'] = $transferIn['person_details']['in']['odd_bag'];
                        $details['person_details']['in']['odd_bag_OthersTxt'] = $transferIn['person_details']['in']['odd_bag_OthersTxt'];
                        $details['person_details']['in']['dsec_lugg'] = $transferIn['person_details']['in']['dsec_lugg'];
                        /*** Product details ***/
                        $details['product_details']['in']['ariport_arriv'] = $transferIn['product_details']['in']['ariport_arriv'];
                        $details['product_details']['in']['ariport_origin'] = $transferIn['product_details']['in']['ariport_origin'];
                        $details['product_details']['in']['arriv_day'] = $transferIn['product_details']['in']['arriv_day'];
                        $details['product_details']['in']['arriv_hr'] = $transferIn['product_details']['in']['arriv_hr'];
                        $details['product_details']['in']['arriv_mt'] = $transferIn['product_details']['in']['arriv_mt'];
                        $details['product_details']['in']['arriv_meridian'] = $transferIn['product_details']['in']['arriv_meridian'];
                        $details['product_details']['in']['airline'] = $transferIn['product_details']['in']['airline'];
                        $details['product_details']['in']['airline_OthersTxt'] = $transferIn['product_details']['in']['airline_OthersTxt'];
                        $details['product_details']['in']['flight_no'] = $transferIn['product_details']['in']['flight_no'];
                        $details['product_details']['in']['driv_lang'] = $transferIn['product_details']['in']['driv_lang'];
                        $details['product_details']['in']['spl_comment'] = $transferIn['product_details']['in']['spl_comment'];
                        $details['product_details']['in']['passengerDetails'] = $transferIn['product_details']['in']['passengerDetails'];
                    }
            }
            if (($details['product_details']['serv_type'] == 'service_as_transfer') && (isset($details['product_details']['out']))) {
                if(($details['product_details']['out']['status'] != 'complete') && count($transferOut)){                                               
                        $details['person_details']['out']['arrival_tm'] = $transferOut['person_details']['out']['arrival_tm'];
                        $details['person_details']['out']['wheely_bag'] = $transferOut['person_details']['out']['wheely_bag'];
                        $details['person_details']['out']['regular_bag'] = $transferOut['person_details']['out']['regular_bag'];
                        $details['person_details']['out']['no_people'] = $transferOut['person_details']['out']['no_people'];
                        $details['person_details']['out']['no_people_OthersTxt'] = $transferOut['person_details']['out']['no_people_OthersTxt'];
                        $details['person_details']['out']['odd_bag'] = $transferOut['person_details']['out']['odd_bag'];
                        $details['person_details']['out']['odd_bag_OthersTxt'] = $transferOut['person_details']['out']['odd_bag_OthersTxt'];
                        $details['person_details']['out']['dsec_lugg'] = $transferOut['person_details']['out']['dsec_lugg'];
                        /*** Product details ***/
                        $details['product_details']['out']['ariport_arriv'] = $transferOut['product_details']['out']['ariport_arriv'];
                        $details['product_details']['out']['ariport_origin'] = $transferOut['product_details']['out']['ariport_origin'];
                        $details['product_details']['out']['airport_dept']  = $transferOut['product_details']['out']['meet_dest'];
                        $details['product_details']['out']['serv_day'] = $transferOut['product_details']['out']['serv_day'];
                        $details['product_details']['out']['decol_hr_out'] = $transferOut['product_details']['out']['arrivout_hr'];
                        $details['product_details']['out']['decol_mt_out'] = $transferOut['product_details']['out']['arrivout_mt'];
                        $details['product_details']['out']['decol_meridian_out'] = $transferOut['product_details']['out']['arrivout_meridian'];
                        $details['product_details']['out']['airlineout'] = $transferOut['product_details']['out']['airlineout'];
                        $details['product_details']['out']['airline_OthersTxt'] = $transferOut['product_details']['out']['airline_OthersTxt'];
                        $details['product_details']['out']['flight_no_out'] = $transferOut['product_details']['out']['flight_no_out'];
                        $details['product_details']['out']['driv_lang_out'] = $transferOut['product_details']['out']['driv_lang_out'];
                        $details['product_details']['out']['spl_comment'] = $transferOut['product_details']['out']['spl_comment'];
                        $details['product_details']['out']['passengerDetails'] = $transferOut['product_details']['out']['passengerDetails'];       
                    }
            }    
                 if (($details['product_details']['serv_type'] == 'meet_greet') && (isset($details['product_details']['IN']))) {
                    if(($details['product_details']['IN']['status'] != 'complete') && count($completeInfo)){                         
                            $details['person_details']['IN']['arrival_tm'] = $completeInfo['person_details']['IN']['arrival_tm'];
                            $details['person_details']['IN']['wheely_bag'] = $completeInfo['person_details']['IN']['wheely_bag'];
                            $details['person_details']['IN']['regular_bag'] = $completeInfo['person_details']['IN']['regular_bag'];
                            $details['person_details']['IN']['no_people'] = $completeInfo['person_details']['IN']['no_people'];
                            $details['person_details']['IN']['no_people_OthersTxt'] = $completeInfo['person_details']['IN']['no_people_OthersTxt'];
                            $details['person_details']['IN']['odd_bag'] = $completeInfo['person_details']['IN']['odd_bag'];
                            $details['person_details']['IN']['odd_bag_OthersTxt'] = $completeInfo['person_details']['IN']['odd_bag_OthersTxt'];
                            $details['person_details']['IN']['dsec_lugg'] = $completeInfo['person_details']['IN']['dsec_lugg'];
                            /*** Product details ***/
                            $details['product_details']['IN']['ariport_arriv'] = $completeInfo['product_details']['IN']['ariport_arriv'];
                            $details['product_details']['IN']['ariport_origin'] = $completeInfo['product_details']['IN']['ariport_origin'];
                            $details['product_details']['IN']['arriv_day'] = $completeInfo['product_details']['IN']['arriv_day'];
                            $details['product_details']['IN']['arriv_hr'] = $completeInfo['product_details']['IN']['arriv_hr'];
                            $details['product_details']['IN']['arriv_mt'] = $completeInfo['product_details']['IN']['arriv_mt'];
                            $details['product_details']['IN']['arriv_meridian'] = $completeInfo['product_details']['IN']['arriv_meridian'];
                            $details['product_details']['IN']['airline'] = $completeInfo['product_details']['IN']['airline'];
                            $details['product_details']['IN']['airline_OthersTxt'] = $completeInfo['product_details']['IN']['airline_OthersTxt'];
                            $details['product_details']['IN']['flight_no'] = $completeInfo['product_details']['IN']['flight_no'];
                            $details['product_details']['IN']['driv_lang'] = $completeInfo['product_details']['IN']['driv_lang'];
                            $details['product_details']['IN']['spl_comment'] = $completeInfo['product_details']['IN']['spl_comment'];
                            $details['product_details']['IN']['passengerDetails'] = $completeInfo['product_details']['IN']['passengerDetails'];                       
                    }
                     if(($details['product_details']['IN']['status'] != 'complete') && count($transferIn)){
                      //  echo "dsdfsd";
                            $details['person_details']['IN']['arrival_tm'] = $transferIn['person_details']['in']['arrival_tm'];
                            $details['person_details']['IN']['wheely_bag'] = $transferIn['person_details']['in']['wheely_bag'];
                            $details['person_details']['IN']['regular_bag'] = $transferIn['person_details']['in']['regular_bag'];
                            $details['person_details']['IN']['no_people'] = $transferIn['person_details']['in']['no_people'];
                            $details['person_details']['IN']['no_people_OthersTxt'] = $transferIn['person_details']['in']['no_people_OthersTxt'];
                            $details['person_details']['IN']['odd_bag'] = $transferIn['person_details']['in']['odd_bag'];
                            $details['person_details']['IN']['odd_bag_OthersTxt'] = $transferIn['person_details']['in']['odd_bag_OthersTxt'];
                            $details['person_details']['IN']['dsec_lugg'] = $transferIn['person_details']['in']['dsec_lugg'];
                            /*** Product details ***/
                            $details['product_details']['IN']['ariport_arriv'] = $transferIn['product_details']['in']['ariport_arriv'];
                            $details['product_details']['IN']['ariport_origin'] = $transferIn['product_details']['in']['ariport_origin'];
                            $details['product_details']['IN']['arriv_day'] = $transferIn['product_details']['in']['arriv_day'];
                            $details['product_details']['IN']['arriv_hr'] = $transferIn['product_details']['in']['arriv_hr'];
                            $details['product_details']['IN']['arriv_mt'] = $transferIn['product_details']['in']['arriv_mt'];
                            $details['product_details']['IN']['arriv_meridian'] = $transferIn['product_details']['in']['arriv_meridian'];
                            $details['product_details']['IN']['airline'] = $transferIn['product_details']['in']['airline'];
                            $details['product_details']['IN']['airline_OthersTxt'] = $transferIn['product_details']['in']['airline_OthersTxt'];
                            $details['product_details']['IN']['flight_no'] = $transferIn['product_details']['in']['flight_no'];
                            $details['product_details']['IN']['driv_lang'] = $transferIn['product_details']['in']['driv_lang'];
                            $details['product_details']['IN']['spl_comment'] = $transferIn['product_details']['in']['spl_comment'];
                            $details['product_details']['IN']['passengerDetails'] = $transferIn['product_details']['in']['passengerDetails'];                       
                    }
            }

             if (($details['product_details']['serv_type'] == 'meet_greet') && (isset($details['product_details']['Out']))) {
                    if(($details['product_details']['Out']['status'] != 'complete') && count($completeInfoOut)) {
                         $details['person_details']['Out']['arrival_tm'] = $completeInfoOut['person_details']['Out']['arrival_tm'];
                        $details['person_details']['Out']['wheely_bag'] = $completeInfoOut['person_details']['Out']['wheely_bag'];
                        $details['person_details']['Out']['regular_bag'] = $completeInfoOut['person_details']['Out']['regular_bag'];
                        $details['person_details']['Out']['no_people'] = $completeInfoOut['person_details']['Out']['no_people'];
                        $details['person_details']['Out']['no_people_OthersTxt'] = $completeInfoOut['person_details']['Out']['no_people_OthersTxt'];
                        $details['person_details']['Out']['odd_bag'] = $completeInfoOut['person_details']['Out']['odd_bag'];
                        $details['person_details']['Out']['odd_bag_OthersTxt'] = $completeInfoOut['person_details']['Out']['odd_bag_OthersTxt'];
                        $details['person_details']['Out']['dsec_lugg'] = $completeInfoOut['person_details']['Out']['dsec_lugg'];
                        /*** Product details ***/
                        $details['product_details']['Out']['ariport_arriv'] = $completeInfoOut['product_details']['Out']['ariport_arriv'];
                        $details['product_details']['Out']['ariport_origin'] = $completeInfoOut['product_details']['Out']['ariport_origin'];
                        $details['product_details']['Out']['airport_dept']  = $completeInfoOut['product_details']['Out']['meet_dest'];
                        $details['product_details']['Out']['serv_day'] = $completeInfoOut['product_details']['Out']['serv_day'];
                        $details['product_details']['Out']['decol_hr_out'] = $completeInfoOut['product_details']['Out']['arrivout_hr'];
                        $details['product_details']['Out']['decol_mt_out'] = $completeInfoOut['product_details']['Out']['arrivout_mt'];
                        $details['product_details']['Out']['decol_meridian_out'] = $completeInfoOut['product_details']['Out']['arrivout_meridian'];
                        $details['product_details']['Out']['airlineout'] = $completeInfoOut['product_details']['Out']['airlineout'];
                        $details['product_details']['Out']['airline_OthersTxt'] = $completeInfoOut['product_details']['Out']['airline_OthersTxt'];
                        $details['product_details']['Out']['flight_no_out'] = $completeInfoOut['product_details']['Out']['flight_no_out'];
                        $details['product_details']['Out']['driv_lang_out'] = $completeInfoOut['product_details']['Out']['driv_lang_out'];
                        $details['product_details']['Out']['spl_comment'] = $completeInfoOut['product_details']['Out']['spl_comment'];
                        $details['product_details']['Out']['passengerDetails'] = $completeInfoOut['product_details']['Out']['passengerDetails'];                     
                    }
             }
                if(($details['product_details']['serv_type'] == 'meet_greet') && (isset($details['product_details']['Commute']))) {
                   if(($details['product_details']['Commute']['status']!='complete') && (count($transinout))) {
                            $details['person_details']['Commute']  = $transinout['person_details']['in&out'];
                            $details['product_details']['Commute']['IN']['ariport_origin'] = $transinout['product_details']['in&out']['in']['ariport_origin'];
                            $details['product_details']['Commute']['IN']['arriv_day'] = $transinout['product_details']['in&out']['in']['arriv_day'];
                            $details['product_details']['Commute']['IN']['arriv_hr'] =  $transinout['product_details']['in&out']['in']['arriv_hr'];
                            $details['product_details']['Commute']['IN']['arriv_mt'] =  $transinout['product_details']['in&out']['in']['arriv_mt'];
                            $details['product_details']['Commute']['IN']['arriv_meridian'] = $transinout['product_details']['in&out']['in']['arriv_meridian'];
                            $details['product_details']['Commute']['IN']['airline'] = $transinout['product_details']['in&out']['in']['airline'];
                            $details['product_details']['Commute']['IN']['airline_OthersTxt'] =  $transinout['product_details']['in&out']['in']['airline_OthersTxt'];
                            $details['product_details']['Commute']['IN']['flight_no'] = $transinout['product_details']['in&out']['in']['flight_no'];
                            $details['product_details']['Commute']['IN']['driv_lang'] = $transinout['product_details']['in&out']['in']['driv_lang'];
                            $details['product_details']['Commute']['IN']['spl_comment'] =  $transinout['product_details']['in&out']['in']['spl_comment'];
                            $details['product_details']['Commute']['IN']['passengerDetails'] = $transinout['product_details']['in&out']['in']['passengerDetails'];

                            $details['product_details']['Commute']['Out']['ariport_origin'] = $transinout['product_details']['in&out']['out']['ariport_origin'];
                            $details['product_details']['Commute']['Out']['serv_day'] = $transinout['product_details']['in&out']['out']['serv_day'];
                            $details['product_details']['Commute']['Out']['arrivout_hr'] =  $transinout['product_details']['in&out']['out']['arrivout_hr'];
                            $details['product_details']['Commute']['Out']['arrivout_mt'] =  $transinout['product_details']['in&out']['out']['arrivout_mt'];
                            $details['product_details']['Commute']['Out']['arrivout_meridian'] = $transinout['product_details']['in&out']['out']['arrivout_meridian'];                         
                            $details['product_details']['Commute']['Out']['airline_OthersTxt'] =  $transinout['product_details']['in&out']['out']['airline_OthersTxt'];
                            $details['product_details']['Commute']['Out']['flight_no_out'] = $transinout['product_details']['in&out']['out']['flight_no_out'];                         
                            $details['product_details']['Commute']['Out']['spl_comment'] =  $transinout['product_details']['in&out']['out']['spl_comment'];                         
                   }
                }
                if (($details['product_details']['serv_type'] == 'meet_greet') && (isset($details['product_details']['IN']))) {                    
                    if(($details['product_details']['IN']['status'] != 'complete') && (count($meetinout))){                       
                       $details['person_details']['IN']  = $meetinout['person_details']['Commute'];                       
                       $details['product_details']['IN']['ariport_origin'] = $meetinout['product_details']['Commute']['IN']['ariport_origin'];
                       $details['product_details']['IN']['arriv_day'] = $meetinout['product_details']['Commute']['IN']['arriv_day'];
                       $details['product_details']['IN']['arriv_hr'] =  $meetinout['product_details']['Commute']['IN']['arriv_hr'];
                       $details['product_details']['IN']['arriv_mt'] =  $meetinout['product_details']['Commute']['IN']['arriv_mt'];
                       $details['product_details']['IN']['arriv_meridian'] = $meetinout['product_details']['Commute']['IN']['arriv_meridian'];
                       $details['product_details']['IN']['airline'] = $meetinout['product_details']['Commute']['IN']['airline'];
                       $details['product_details']['IN']['airline_OthersTxt'] =  $meetinout['product_details']['Commute']['IN']['airline_OthersTxt'];
                       $details['product_details']['IN']['flight_no'] = $meetinout['product_details']['Commute']['IN']['flight_no'];
                       $details['product_details']['IN']['driv_lang'] = $meetinout['product_details']['Commute']['IN']['driv_lang'];
                       $details['product_details']['IN']['spl_comment'] =  $meetinout['product_details']['Commute']['IN']['spl_comment'];
                       $details['product_details']['IN']['passengerDetails'] = $meetinout['product_details']['Commute']['IN']['passengerDetails'];                        
                    }
                    if (($details['product_details']['IN']['status'] != 'complete') && (count($transinout))){
                            $details['person_details']['IN'] = $transinout['person_details']['in&out'];                       
                            $details['product_details']['IN']['ariport_origin'] = $transinout['product_details']['in&out']['in']['ariport_origin'];
                            $details['product_details']['IN']['arriv_day'] = $transinout['product_details']['in&out']['in']['arriv_day'];
                            $details['product_details']['IN']['arriv_hr'] =  $transinout['product_details']['in&out']['in']['arriv_hr'];
                            $details['person_details']['IN']['arriv_mt'] =  $transinout['product_details']['in&out']['in']['arriv_mt'];
                            $details['product_details']['IN']['arriv_meridian'] = $transinout['product_details']['in&out']['in']['arriv_meridian'];
                            $details['product_details']['IN']['airline'] = $transinout['product_details']['in&out']['in']['airline'];
                            $details['product_details']['IN']['airline_OthersTxt'] =  $transinout['product_details']['in&out']['in']['airline_OthersTxt'];
                            $details['product_details']['IN']['flight_no'] = $transinout['product_details']['in&out']['in']['flight_no'];
                            $details['product_details']['IN']['driv_lang'] = $transinout['product_details']['in&out']['in']['driv_lang'];
                            $details['product_details']['IN']['spl_comment'] =  $transinout['product_details']['in&out']['in']['spl_comment'];
                            $details['product_details']['IN']['passengerDetails'] = $transinout['product_details']['in&out']['in']['passengerDetails'];
                      }
                }          
               if (($details['product_details']['serv_type'] == 'meet_greet') && (isset($details['product_details']['Out']))) {
                        if (($details['product_details']['Out']['status'] != 'complete') && (count($meetinout))){                         
                            $details['person_details']['Out']  = $meetinout['person_details']['Commute'];                             
                            $details['product_details']['Out']['ariport_origin'] = $meetinout['product_details']['Commute']['Out']['ariport_origin'];
                            $details['product_details']['Out']['serv_day'] = $meetinout['product_details']['Commute']['Out']['serv_day'];
                            $details['product_details']['Out']['arrivout_hr'] =  $meetinout['product_details']['Commute']['Out']['arrivout_hr'];
                            $details['product_details']['Out']['arrivout_mt'] =  $meetinout['product_details']['Commute']['Out']['arrivout_mt'];
                            $details['product_details']['Out']['arrivout_meridian'] = $meetinout['product_details']['Commute']['Out']['arrivout_meridian'];
                            $details['product_details']['Out']['airlineout'] = $meetinout['product_details']['Commute']['Out']['airlineout'];
                            $details['product_details']['Out']['airline_OthersTxt'] =  $meetinout['product_details']['Commute']['IN']['airline_OthersTxt'];
                            $details['product_details']['Out']['flight_no_out'] = $meetinout['product_details']['Commute']['Out']['flight_no_out'];
                            $details['product_details']['Out']['driv_lang_out'] = $meetinout['product_details']['Commute']['Out']['driv_lang_out'];
                            $details['product_details']['Out']['spl_comment'] =  $meetinout['product_details']['Commute']['Out']['spl_comment'];
                            $details['product_details']['Out']['passengerDetails'] = $meetinout['product_details']['Commute']['Out']['passengerDetails']; 
                        }
                        if (($details['product_details']['Out']['status'] != 'complete') && (count($transinout))) {
                               $details['person_details']['Out']  = $transinout['person_details']['in&out'];                       
                               $details['product_details']['Out']['ariport_origin'] = $transinout['product_details']['in&out']['out']['ariport_origin'];
                               $details['product_details']['Out']['serv_day'] = $transinout['product_details']['in&out']['out']['serv_day'];
                               $details['product_details']['Out']['arrivout_hr'] =  $transinout['product_details']['in&out']['out']['arrivout_hr'];
                               $details['product_details']['Out']['arrivout_mt'] =  $transinout['product_details']['in&out']['out']['arrivout_mt'];
                               $details['product_details']['Out']['arrivout_meridian'] = $transinout['product_details']['in&out']['out']['arrivout_meridian'];
                               $details['product_details']['Out']['airlineout'] = $transinout['product_details']['in&out']['out']['airlineout'];
                               $details['product_details']['Out']['airline_OthersTxt'] =  $transinout['product_details']['in&out']['out']['airline_OthersTxt'];
                               $details['product_details']['Out']['flight_no_out'] = $transinout['product_details']['in&out']['out']['flight_no_out'];
                               $details['product_details']['Out']['driv_lang_out'] = $transinout['product_details']['in&out']['out']['driv_lang_out'];
                               $details['product_details']['Out']['spl_comment'] =  $transinout['product_details']['in&out']['out']['spl_comment'];
                               $details['product_details']['Out']['passengerDetails'] = $transinout['product_details']['in&out']['out']['passengerDetails'];
                      }


                }
                if(($details['product_details']['serv_type'] == 'service_as_transfer') && (isset($details['product_details']['in']))) {
                      if (($details['product_details']['in']['status'] != 'complete') && (count($transinout))) {
                               $details['person_details']['in']  = $transinout['person_details']['in&out'];                       
                               $details['product_details']['in']['ariport_origin'] = $transinout['product_details']['in&out']['IN']['ariport_origin'];
                               $details['product_details']['in']['arriv_day'] = $transinout['product_details']['in&out']['in']['arriv_day'];
                               $details['product_details']['in']['arriv_hr'] =  $transinout['product_details']['in&out']['in']['arriv_hr'];
                               $details['product_details']['in']['arriv_mt'] =  $transinout['product_details']['in&out']['in']['arriv_mt'];
                               $details['product_details']['in']['arriv_meridian'] = $transinout['product_details']['in&out']['in']['arriv_meridian'];
                               $details['product_details']['in']['airline'] = $transinout['product_details']['in&out']['in']['airline'];
                               $details['product_details']['in']['airline_OthersTxt'] =  $transinout['product_details']['in&out']['in']['airline_OthersTxt'];
                               $details['product_details']['in']['flight_no'] = $transinout['product_details']['in&out']['in']['flight_no'];
                               $details['product_details']['in']['driv_lang'] = $transinout['product_details']['in&out']['in']['driv_lang'];
                               $details['product_details']['in']['spl_comment'] =  $transinout['product_details']['in&out']['in']['spl_comment'];
                               $details['product_details']['in']['passengerDetails'] = $transinout['product_details']['in&out']['in']['passengerDetails'];
                      }                      
                        if(($details['product_details']['in']['status'] != 'complete') && (count($meetinout))){                       
                                $details['person_details']['in']  = $meetinout['person_details']['Commute'];                       
                                $details['product_details']['in']['ariport_origin'] = $meetinout['product_details']['Commute']['IN']['ariport_origin'];
                                $details['product_details']['in']['arriv_day'] = $meetinout['product_details']['Commute']['IN']['arriv_day'];
                                $details['product_details']['in']['arriv_hr'] =  $meetinout['product_details']['Commute']['IN']['arriv_hr'];
                                $details['product_details']['in']['arriv_mt'] =  $meetinout['product_details']['Commute']['IN']['arriv_mt'];
                                $details['product_details']['in']['arriv_meridian'] = $meetinout['product_details']['Commute']['IN']['arriv_meridian'];
                                $details['product_details']['in']['airline'] = $meetinout['product_details']['Commute']['IN']['airline'];
                                $details['product_details']['in']['airline_OthersTxt'] =  $meetinout['product_details']['Commute']['IN']['airline_OthersTxt'];
                                $details['product_details']['in']['flight_no'] = $meetinout['product_details']['Commute']['IN']['flight_no'];
                                $details['product_details']['in']['driv_lang'] = $meetinout['product_details']['Commute']['IN']['driv_lang'];
                                $details['product_details']['in']['spl_comment'] =  $meetinout['product_details']['Commute']['IN']['spl_comment'];
                                $details['product_details']['in']['passengerDetails'] = $meetinout['product_details']['Commute']['IN']['passengerDetails'];
                      }
                }                
                 if(($details['product_details']['serv_type'] == 'service_as_transfer') && (isset($details['product_details']['out']))) {
                      if (($details['product_details']['out']['status'] != 'complete') && (count($transinout))){
                               $details['person_details']['out']  = $transinout['person_details']['in&out'];                       
                               $details['product_details']['out']['ariport_origin'] = $transinout['product_details']['in&out']['out']['ariport_origin'];
                               $details['product_details']['out']['serv_day'] = $transinout['product_details']['in&out']['out']['serv_day'];
                               $details['product_details']['out']['arrivout_hr'] =  $transinout['product_details']['in&out']['out']['arrivout_hr'];
                               $details['product_details']['out']['arrivout_mt'] =  $transinout['product_details']['in&out']['out']['arrivout_mt'];
                               $details['product_details']['out']['arrivout_meridian'] = $transinout['product_details']['in&out']['out']['arrivout_meridian'];
                               $details['product_details']['out']['airlineout'] = $transinout['product_details']['in&out']['out']['airlineout'];
                               $details['product_details']['out']['airline_OthersTxt'] =  $transinout['product_details']['in&out']['out']['airline_OthersTxt'];
                               $details['product_details']['out']['flight_no_out'] = $transinout['product_details']['in&out']['out']['flight_no_out'];
                               $details['product_details']['out']['driv_lang_out'] = $transinout['product_details']['in&out']['out']['driv_lang_out'];
                               $details['product_details']['out']['spl_comment'] =  $transinout['product_details']['in&out']['out']['spl_comment'];
                               $details['product_details']['out']['passengerDetails'] = $transinout['product_details']['in&out']['out']['passengerDetails'];
                      }
                       if (($details['product_details']['out']['status'] != 'complete') && (count($meetinout))) {
                            $details['person_details']['out']  = $meetinout['person_details']['Commute'];                             
                            $details['product_details']['out']['ariport_origin'] = $meetinout['product_details']['Commute']['Out']['ariport_origin'];
                            $details['product_details']['out']['serv_day'] = $meetinout['product_details']['Commute']['Out']['serv_day'];
                            $details['product_details']['out']['arrivout_hr'] =  $meetinout['product_details']['Commute']['Out']['arrivout_hr'];
                            $details['product_details']['out']['arrivout_mt'] =  $meetinout['product_details']['Commute']['Out']['arrivout_mt'];
                            $details['product_details']['out']['arrivout_meridian'] = $meetinout['product_details']['Commute']['Out']['arrivout_meridian'];
                            $details['product_details']['out']['airlineout'] = $meetinout['product_details']['Commute']['Out']['airlineout'];
                            $details['product_details']['out']['airline_OthersTxt'] =  $meetinout['product_details']['Commute']['IN']['airline_OthersTxt'];
                            $details['product_details']['out']['flight_no_out'] = $meetinout['product_details']['Commute']['Out']['flight_no_out'];
                            $details['product_details']['out']['driv_lang_out'] = $meetinout['product_details']['Commute']['Out']['driv_lang_out'];
                            $details['product_details']['out']['spl_comment'] =  $meetinout['product_details']['Commute']['Out']['spl_comment'];
                            $details['product_details']['out']['passengerDetails'] = $meetinout['product_details']['Commute']['Out']['passengerDetails']; 
                      }
                }
              $newArry[$key] =$details;  
        }
     
        $newArry = array_reverse($newArry, true);
        $cart = $newArry;        
        $_SESSION['products'] = serialize($cart); 
    }
    
}
//Payment before enter all data in Database and go to Payment Gateway
if($_REQUEST['process'] == 'cartPayment'){
    global $user;
    $retval='';
    if($_SESSION['products'])
    {
        $cart=array();
        $cart=unserialize($_SESSION['products']);
        $cartqty=0;
        //Checkout Entry Starts
        //log_detailed_transfer_results_checkout
        $trav_agent_id=$user->uid;
        $user_id=$user->uid;
        $qty=$cartqty;
        $act_price=0;
        //$act_price=$subtot_price;
       
        /*echo "<pre>";
        print_r($cart);
        echo "</pre>";*/
        
        $comm_percent='';
        if(isset($_SESSION['comm_percent']) && trim($_SESSION['comm_percent'])!='')
        {
            $comm_percent=$_SESSION['comm_percent'];
        }else{
           $_SESSION['comm_percent']=0;
           $comm_percent=0;
        }
       
        $total_amt=0.00;
        $tot_price=0.00;
        $subtot_price=0.00;
        //$total_amt=$tot_price;
        $paybax_trans_id='xxx';
        $trans_status=0;
        $is_manual_invoice_req=0;
        $act_price=0.00;
        $client_email='';
        if(isset($_REQUEST['client_email']) && trim($_REQUEST['client_email'])!='')
        {
            $client_email=trim($_REQUEST['client_email']);
        }
        
        $checkout_id = db_insert('log_detailed_transfer_results_checkout')
        ->fields(array(
          'trav_agent_id' => $trav_agent_id,
          'qty' => $qty,
          'act_price' => $act_price,
          'comm_percent' => $comm_percent,
          'total_amt' => $total_amt,
          'client_email' => $client_email,  
          'paybax_trans_id' => $paybax_trans_id,
          'trans_status' => $trans_status,
          'is_manual_invoice_req' => $is_manual_invoice_req,
          'created_dt' => REQUEST_TIME,
          'updated_dt' => REQUEST_TIME, 
        ))->execute();
        
        
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
                 if(isset($row['product_details'][$type]))
                {
                    $cqty=$row['product_details'][$type]['qty'];
                    $price=$cqty*$row['product_details'][$type]['price'];
                    $totcomprice='';
                    //Check for travek agent Login
                    if(isset($user->roles[5]))
                    { 
                        if(trim($row['product_details']['serv_type'])=='meet_greet')
                        {
                           if($row['product_details'][$type]['srch']['applied']=='weekday')                   
                           $totcomprice=$cqty*$row['product_details'][$type]['srch']['custday_price']; 
                           else
                           $totcomprice=$cqty*$row['product_details'][$type]['srch']['custend_price']; 
                        }
                        else
                        {
                            $totcomprice=$cqty*$row['product_details'][$type]['srch']['cust_price'];
                        }
                        $totcomprice=$price;
                    }
                    else
                    {   
                        $totcomprice=$cqty*$row['product_details'][$type]['srch']['price'];  
                    }
                    if(isset($row['person_details'][$type]['arrival_tm']) && trim($row['person_details'][$type]['arrival_tm'])=='2')
                    {
                        $nigth_rate_comm=$row['product_details'][$type]['srch']['night_rate_comm'];
                        $night_comm_price=($totcomprice*$nigth_rate_comm)/100;
                        $totcomprice=$totcomprice+$night_comm_price;
                        $night_comm_price=($price*$nigth_rate_comm)/100;
                        $price=$price+$night_comm_price;
                    }
                    $subtot_price+=$price;
                    $tot_price+=$totcomprice;

                    $service_type=trim($row['product_details']['serv_type']);
                    $service_selector_id=$type;
                    $arrival_time=$row['person_details'][$type]['arrival_tm'];
                    $no_wheel_luggage=0;
                    if(isset($row['person_details'][$type]['wheely_bag']) && trim($row['person_details'][$type]['wheely_bag'])!='')
                    {
                        $no_wheel_luggage=$row['person_details'][$type]['wheely_bag'];
                    }
                    $no_regular_luggage=0;
                    if(isset($row['person_details'][$type]['regular_bag']) && trim($row['person_details'][$type]['regular_bag'])!='')
                    {
                        $no_regular_luggage=$row['person_details'][$type]['regular_bag'];
                    }
                    $no_people=$row['person_details'][$type]['no_people'];
                    if($no_people=='Others'){ $no_people= $row['person_details'][$type]['no_people_OthersTxt'];} 
                    $no_odd_luggage=$row['person_details'][$type]['odd_bag'];
                    if($no_odd_luggage=='Others'){ $no_odd_luggage= $row['person_details'][$type]['odd_bag_OthersTxt'];} 
                    $desc_odd_luggage=$row['person_details'][$type]['dsec_lugg'];


                    if($row['product_details'][$type]['id'])
                    {
                     $service_id=$row['product_details'][$type]['id'];
                     $applied='weekday';
                     if(isset($row['product_details'][$type]['srch']['applied']) && trim($row['product_details'][$type]['srch']['applied'])!='')
                     {
                        $applied=trim($row['product_details'][$type]['srch']['applied']);
                     }
                     $night_rate_percent=0;
                     if(isset($row['product_details'][$type]['srch']['night_rate_comm']) && trim($row['product_details'][$type]['srch']['night_rate_comm'])!='')
                     {
                        $night_rate_percent=trim($row['product_details'][$type]['srch']['night_rate_comm']);                        
                     }
                     $agt_price=0;
                     if($row['product_details']['serv_type']=='meet_greet')
                     {
                         if($applied=='weekday')
                         {
                             $agt_price=$row['product_details'][$type]['srch']['custday_price'];
                         }
                         else
                         {
                             $agt_price=$row['product_details'][$type]['srch']['custend_price'];
                         }
                     }
                     else{
                         $agt_price=$row['product_details'][$type]['srch']['agt_comm'];
                     }
                     
                     $region='';
                     
                     if(isset($row['product_details'][$type]['srch']['selectregion']) && trim($row['product_details'][$type]['srch']['selectregion'])!='')
                     {
                        $region=$row['product_details'][$type]['srch']['selectregion'];                        
                     }
                     $from='';
                     if(isset($row['product_details'][$type]['srch']['from']) && trim($row['product_details'][$type]['srch']['from'])!='')
                     {
                        $from=$row['product_details'][$type]['srch']['from'];                        
                     }
                     $to='';
                     
                     if(isset($row['product_details'][$type]['srch']['to']) && trim($row['product_details'][$type]['srch']['to'])!='')
                     {
                        $to=$row['product_details'][$type]['srch']['to'];                        
                     }
                     
                     $driv_details='';
                     
                     if($row['product_details']['serv_type']=='meet_greet')
                     {
                        $result=db_query("SELECT field_meet_greet_region_family as driv_name, field_meet_greet_region_generational as driv_num 
                         FROM `field_data_field_meet_greet_region` where field_meet_greet_region_given='".$region."' limit 1 ");
                        $driv_name='';
                        $driv_num='';
                        foreach ($result as $record) {   
                             $driv_name=$record->driv_name;
                             $driv_num=$record->driv_num;
                        }
                        $driv_details=$driv_name.' - Tel: '.$driv_num;
                     }
                     elseif($row['product_details']['serv_type']=='service_as_transfer')
                     {
                          $result=db_query("SELECT field_add_region_family as driv_name, field_add_region_generational as driv_num 
                        FROM `field_data_field_add_region` where field_add_region_given='".$from."' and field_add_region_middle='".$to."' limit 1 ");
                        $driv_name='';
                        $driv_num='';
                        foreach ($result as $record) {   
                             $driv_name=$record->driv_name;
                             $driv_num=$record->driv_num;
                        }
                        $driv_details=$driv_name.' - Tel: '.$driv_num;
                     }
                    
                     
                        
                   $ls_id=db_insert('log_detailed_service_Info')
                    ->fields(array(
                      'checkout_id' => $checkout_id,
                      'user_id' => $user_id,
                      'service_type' => $service_type,
                      'service_selector_id' => $service_selector_id,
                      'qty' => $row['product_details'][$type]['qty'],
                      'price' => $row['product_details'][$type]['price'],
                      'agt_price' => $agt_price,
                      'day_applied' => $applied,
                      'service_id' => $service_id,
                      'servtitle' => $row['product_details'][$type]['servtitle'],  
                      'delta' => $row['product_details'][$type]['srch']['delta'],
                      'arrival_time' => $arrival_time,
                      'night_rate_percent' => $night_rate_percent,
                      'region' => $region,  
                      'fromplace' => $from,
                      'toplace' => $to,
                      'driv_details' => $driv_details, 
                      'no_wheel_luggage' => $no_wheel_luggage,
                      'no_regular_luggage' => $no_regular_luggage,
                      'no_people' => $no_people,
                      'no_odd_luggage' => $no_odd_luggage,
                      'desc_odd_luggage' => $desc_odd_luggage,
                      'created_date' => REQUEST_TIME, 
                    ))->execute();

                    }

                switch (trim($row['product_details']['serv_type']))
                {
                case "service_as_transfer":
                  switch ($type)
                    {
                    case "in":

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
                        if($qty>1)
                        {
                            $price=$price* $qty;
                            $clientprice=$clientprice* $qty;
                        } 
                        if($comm_percent!='')
                        {
                            $clientprice=$clientprice+(($comm_percent*$clientprice)/100);
                        }
                      $airline=$row['product_details'][$type]['airline'];
                      $airport_arriv=$row['product_details'][$type]['ariport_origin'];
                      if($airline=='Others'){
                          $airline= $row['product_details'][$type]['airline_OthersTxt'];
                      } 

                       $trav_id=db_insert('log_detailed_in_travel_Info')
                        ->fields(array(
                          'checkout_id' => $checkout_id,
                          'ls_id' => $ls_id,
                          'user_id' => $user_id,
                          'service_type' => trim($row['product_details']['serv_type']), 
                          'arriv_dt' => trim($row['product_details'][$type]['arriv_day']),  
                          'arrival_airport' => $airport_arriv, 
                          'arriv_hr' => $row['product_details'][$type]['arriv_hr'],
                          'arriv_mt' => $row['product_details'][$type]['arriv_mt'],
                          'arriv_meridian' => $row['product_details'][$type]['arriv_meridian'],
                          'airline' => $airline,
                          'flight_no' => $row['product_details'][$type]['flight_no'],
                          'driver_hostess_lang' => $row['product_details'][$type]['driv_lang'],
                          'comments' => $row['product_details'][$type]['spl_comment'],
                          'dest_addr' => $dest_addr,
                          'created_dt' => REQUEST_TIME, 
                        ))->execute();

                      for($inc=0;$inc<count($row['product_details'][$type]['passengerDetails']);$inc++)
                        {
                            db_insert('login_trav_person_details')
                            ->fields(array(
                              'trav_id' => $trav_id,
                              'title' => $row['product_details'][$type]['passengerDetails'][$inc]['surtitle'],
                              'first_name' => $row['product_details'][$type]['passengerDetails'][$inc]['fname'],
                              'middle_name' => '',
                              'last_name' => $row['product_details'][$type]['passengerDetails'][$inc]['pasengername'],
                              'ph_no' => $row['product_details'][$type]['passengerDetails'][$inc]['tnum'],
                              'created_dt' => REQUEST_TIME, 
                            ))->execute();


                        }

                      break;
                    case "out":
                    $pickout_addr=$row['product_details'][$type]['pickout_addr'];
                    if($pickout_addr=='Others'){ $pickout_addr= $row['product_details'][$type]['pickout_addrTxt'];} 
                    else{$pickout_addr.=' '.$row['product_details'][$type]['pickout_addrTxt'];} 


                    $no_people=$row['person_details'][$type]['no_people'];
                    if($no_people=='Others'){ $no_people= $row['person_details'][$type]['no_people_OthersTxt'];} 
                    $dropoffout_addr=$row['product_details'][$type]['dropoffout_addr'];
                    if($dropoffout_addr=='Others'){ $dropoffout_addr= $row['product_details'][$type]['dropoffout_addrTxt'];} 
                    else{$dropoffout_addr.=' '.$row['product_details'][$type]['dropoffout_addrTxt'];}    

                    $airline=$row['product_details'][$type]['airlineout'];
                    if($airline=='Others'){
                        $airline= $row['product_details'][$type]['airlineout_OthersTxt'];
                    } 
                    
                    $airport_dept=$row['product_details'][$type]['airport_dept'];
                    if($airport_dept=='others'){
                        $airport_dept= $row['product_details'][$type]['airport_dept_OthersTxt'];
                    } 

                    $qty=$row['product_details'][$type]['qty'];
                    $price=$row['product_details'][$type]['price'];
                    $clientprice=0;
                    //Check for travek agent Login
                    if(isset($user->roles[5]))
                    { 
                        //$clientprice=$row['product_details'][$type]['srch']['cust_price'];
                        $clientprice=$price;
                    }
                    if($qty>1)
                    {
                        $price=$price* $qty;
                        $clientprice=$clientprice* $qty;
                    }  
                    if($comm_percent!='')
                    {
                        $clientprice=$clientprice+(($comm_percent*$clientprice)/100);
                    }   
                    $trav_id=db_insert('log_detailed_out_travel_Info')
                     ->fields(array(
                       'checkout_id' => $checkout_id,
                       'ls_id' => $ls_id,
                       'user_id' => $user_id,
                       'service_type' => trim($row['product_details']['serv_type']), 
                       'service_dt' => $row['product_details'][$type]['serv_day'],
                       'airport_dept' => $airport_dept,  
                       'airline' => $airline,
                       'flight_no' => $row['product_details'][$type]['flight_no_out'],
                       'decol_hr' => $row['product_details'][$type]['decol_hr_out'],
                       'decol_mt' => $row['product_details'][$type]['decol_mt_out'],
                       'decol_meridian' => $row['product_details'][$type]['decol_meridian_out'], 
                       'pickup_hr' => $row['product_details'][$type]['pickup_hr'],
                       'pickup_mt' => $row['product_details'][$type]['pickup_mt'],
                       'pickup_meridian' => $row['product_details'][$type]['pickup_meridian'],
                       'pickup_addr' => $pickout_addr, 
                       'drop_addr' => $dropoffout_addr, 
                       'lang_driv_hostess' => $row['product_details'][$type]['driv_lang_out'],
                       'comments' => $row['product_details'][$type]['spl_comment_out'],
                       'created_dt' => REQUEST_TIME, 
                     ))->execute();

                    for($inc=0;$inc<count($row['product_details'][$type]['passengerDetails']);$inc++)
                    {
                        db_insert('logout_trav_person_details')
                        ->fields(array(
                          'trav_id' => $trav_id,
                          'title' => $row['product_details'][$type]['passengerDetails'][$inc]['surtitle_out'],
                          'first_name' => $row['product_details'][$type]['passengerDetails'][$inc]['fname_out'],
                          'middle_name' => '',
                          'last_name' => $row['product_details'][$type]['passengerDetails'][$inc]['pasengername_out'],
                          'ph_no' => $row['product_details'][$type]['passengerDetails'][$inc]['tnum_out'],
                          'created_dt' => REQUEST_TIME, 
                        ))->execute();


                    }  
                      break;
                    case "in&out":
                    $airport_arrival=$row['product_details'][$type]['in']['ariport_origin'];
                    
                    $airline=$row['product_details'][$type]['in']['airline'];
                    if($airline=='Others'){ $airline= $row['product_details'][$type]['in']['airline_OthersTxt'];}     




                    $no_people=$row['person_details'][$type]['no_people'];
                    if($no_people=='Others'){ $no_people= $row['person_details'][$type]['no_people_OthersTxt'];} 
                    $dest_addr=$row['product_details'][$type]['in']['dest_addr'];
                    if($dest_addr=='Others'){ $dest_addr= $row['product_details'][$type]['in']['dest_addr_OthersTxt'];} 

                    $pickout_addr=$row['product_details'][$type]['out']['pickout_addr'];
                    if($pickout_addr=='Others'){ $pickout_addr= $row['product_details'][$type]['out']['pickout_addrTxt'];} 
                    else{$pickout_addr.=' '.$row['product_details'][$type]['out']['pickout_addrTxt'];} 

                    $dropoffout_addr=$row['product_details'][$type]['out']['dropoffout_addr'];
                    if($dropoffout_addr=='Others'){ $dropoffout_addr= $row['product_details'][$type]['out']['dropoffout_addrTxt'];} 
                    else{$dropoffout_addr.=' '.$row['product_details'][$type]['out']['dropoffout_addrTxt'];}    

                    $airlineout=$row['product_details'][$type]['out']['airlineout'];
                    if($airlineout=='Others'){ $airlineout= $row['product_details'][$type]['out']['airlineout_OthersTxt'];}     
                    
                    $airport_dept=$row['product_details'][$type]['out']['airport_dept'];
                    if($airport_dept=='others'){
                        $airport_dept= $row['product_details'][$type]['out']['airport_dept_OthersTxt'];
                    } 

                    $qty=$row['product_details'][$type]['qty'];
                    $price=$row['product_details'][$type]['price'];
                    $clientprice=0;
                    
                    //Check for travek agent Login
                    if(isset($user->roles[5]))
                    { 
                        //$clientprice=$row['product_details'][$type]['srch']['cust_price'];
                        $clientprice=$price;
                    }
                    if($comm_percent!='')
                    {
                        $clientprice=$clientprice+(($comm_percent*$clientprice)/100);
                    }
                    if($qty>1)
                    {
                        $price=$price* $qty;
                        $clientprice=$clientprice* $qty;
                    } 
                    


                      $trav_id=db_insert('log_detailed_in_travel_Info')
                        ->fields(array(
                          'checkout_id' => $checkout_id,
                          'ls_id' => $ls_id,
                          'user_id' => $user_id,
                          'service_type' => trim($row['product_details']['serv_type']),
                          'arriv_dt' => trim($row['product_details'][$type]['in']['arriv_day']),  
                          'arrival_airport' => $airport_arrival, 
                          'arriv_hr' => $row['product_details'][$type]['in']['arriv_hr'],
                          'arriv_mt' => $row['product_details'][$type]['in']['arriv_mt'],
                          'arriv_meridian' => $row['product_details'][$type]['in']['arriv_meridian'],
                          'airline' => $airline,
                          'flight_no' => $row['product_details'][$type]['in']['flight_no'],
                          'driver_hostess_lang' => $row['product_details'][$type]['in']['driv_lang'],
                          'comments' => $row['product_details'][$type]['in']['spl_comment'],
                          'dest_addr' => $dest_addr,
                          'created_dt' => REQUEST_TIME, 
                        ))->execute();

                    for($inc=0;$inc<count($row['product_details'][$type]['in']['passengerDetails']);$inc++)
                    {
                         db_insert('login_trav_person_details')
                        ->fields(array(
                          'trav_id' => $trav_id,
                          'title' => $row['product_details'][$type]['in']['passengerDetails'][$inc]['surtitle'],
                          'first_name' => $row['product_details'][$type]['in']['passengerDetails'][$inc]['fname'],
                          'middle_name' => '',
                          'last_name' => $row['product_details'][$type]['in']['passengerDetails'][$inc]['pasengername'],
                          'ph_no' => $row['product_details'][$type]['in']['passengerDetails'][$inc]['tnum'],
                          'created_dt' => REQUEST_TIME, 
                        ))->execute();


                    }

                      $trav_id=db_insert('log_detailed_out_travel_Info')
                     ->fields(array(
                       'checkout_id' => $checkout_id,
                       'ls_id' => $ls_id,
                       'user_id' => $user_id,
                       'service_type' => trim($row['product_details']['serv_type']), 
                       'service_dt' => $row['product_details'][$type]['out']['serv_day'], 
                       'airport_dept' => $airport_dept,  
                       'airline' => $airlineout,
                       'flight_no' => $row['product_details'][$type]['out']['flight_no_out'],
                       'decol_hr' => $row['product_details'][$type]['out']['decol_hr_out'],
                       'decol_mt' => $row['product_details'][$type]['out']['decol_mt_out'],
                       'decol_meridian' => $row['product_details'][$type]['out']['decol_meridian_out'], 
                       'pickup_hr' => $row['product_details'][$type]['out']['pickup_hr'],
                       'pickup_mt' => $row['product_details'][$type]['out']['pickup_mt'],
                       'pickup_meridian' => $row['product_details'][$type]['out']['pickup_meridian'],
                       'pickup_addr' => $pickout_addr, 
                       'drop_addr' => $dropoffout_addr, 
                       'lang_driv_hostess' => $row['product_details'][$type]['out']['driv_lang_out'],
                       'comments' => $row['product_details'][$type]['out']['spl_comment_out'],
                       'created_dt' => REQUEST_TIME, 
                     ))->execute();



                    for($inc=0;$inc<count($row['product_details'][$type]['out']['passengerDetails']);$inc++)
                    {
                        db_insert('logout_trav_person_details')
                        ->fields(array(
                          'trav_id' => $trav_id,
                          'title' => $row['product_details'][$type]['out']['passengerDetails'][$inc]['surtitle_out'],
                          'first_name' => $row['product_details'][$type]['out']['passengerDetails'][$inc]['fname_out'],
                          'middle_name' => '',
                          'last_name' => $row['product_details'][$type]['out']['passengerDetails'][$inc]['pasengername_out'],
                          'ph_no' => $row['product_details'][$type]['out']['passengerDetails'][$inc]['tnum_out'],
                          'created_dt' => REQUEST_TIME, 
                        ))->execute();


                    } 

                      break;            
                    }
                  break;
                case "meet_greet":               
                   switch (trim($row['product_details'][$type]['typeTransfer']))
                    {
                    case "IN":
                    $airport_arrival=$row['product_details'][$type]['airline'];
                    $airport_arriv=$row['product_details'][$type]['ariport_origin'];
                    if($airport_arrival=='Others'){ $airport_arrival= $row['product_details'][$type]['airline_OthersTxt'];}     

                    $qty=$row['product_details'][$type]['qty'];
                    $price=$row['product_details'][$type]['price'];
                    $clientprice=0;
                    //Check for travek agent Login
                    if(isset($user->roles[5]))
                    { 
                        /*if(trim($row['product_details']['serv_type'])=='meet_greet')
                        {
                           if($row['product_details'][$type]['srch']['applied']=='weekday')                   
                           $clientprice=$row['product_details'][$type]['srch']['custday_price']; 
                           else
                           $clientprice=$row['product_details'][$type]['srch']['custend_price']; 
                        }
                        else
                        {
                            $clientprice=$row['product_details'][$type]['srch']['cust_price'];
                        }*/
                        $clientprice=$price;
                    }
                    if($comm_percent!='')
                    {
                        $clientprice=$clientprice+(($comm_percent*$clientprice)/100);
                    }
                    if($qty>1)
                    {  
                        $price=$price* $qty;
                        $clientprice=$clientprice* $qty;
                    } 
                    
                    $resrow=$row['product_details'][$type];

                    /*$dest_addr=$resrow['dest_addr'];
                    if($dest_addr=='Others'){ $dest_addr= $resrow['dest_addr_OthersTxt'];} 
                    */

                    $no_people=$row['person_details'][$type]['no_people'];
                    if($no_people=='Others'){ $no_people= $row['person_details'][$type]['no_people_OthersTxt'];} 

                    $odd_bag=$row['person_details'][$type]['odd_bag'];
                    if($odd_bag=='Others'){ $odd_bag= $row['person_details'][$type]['odd_bag_OthersTxt'];} 
                    
                    $trav_id=db_insert('log_detailed_in_travel_Info')
                        ->fields(array(
                          'checkout_id' => $checkout_id,
                          'ls_id' => $ls_id,
                          'user_id' => $user_id,
                          'service_type' => trim($row['product_details']['serv_type']), 
                          'arriv_dt' => $resrow['arriv_day'],    
                          'arrival_airport' => $airport_arriv, 
                          'arriv_hr' => $resrow['arriv_hr'],
                          'arriv_mt' => $resrow['arriv_mt'],
                          'arriv_meridian' => $resrow['arriv_meridian'],
                          'airline' => $airport_arrival,
                          'flight_no' => $resrow['flight_no'],
                          'driver_hostess_lang' => $resrow['driv_lang'],
                          'comments' => $resrow['spl_comment'],
                          'dest_addr' => '',
                          'created_dt' => REQUEST_TIME, 
                        ))->execute();

                    for($inc=0;$inc<count($resrow['passengerDetails']);$inc++)
                    {
                         db_insert('login_trav_person_details')
                        ->fields(array(
                          'trav_id' => $trav_id,
                          'title' => $resrow['passengerDetails'][$inc]['surtitle'],
                          'first_name' => $resrow['passengerDetails'][$inc]['fname'],
                          'middle_name' => '',
                          'last_name' => $resrow['passengerDetails'][$inc]['pasengername'],
                          'ph_no' => $resrow['passengerDetails'][$inc]['tnum'],
                          'created_dt' => REQUEST_TIME, 
                        ))->execute();


                    } 
                      break;
                    case "Out":
                    $qty=$row['product_details'][$type]['qty'];
                    $price=$row['product_details'][$type]['price'];
                    $clientprice=0;
                    //Check for travek agent Login
                    if(isset($user->roles[5]))
                    { 
                        /*
                        if(trim($row['product_details']['serv_type'])=='meet_greet')
                        {
                           if($row['product_details'][$type]['srch']['applied']=='weekday')                   
                           $clientprice=$row['product_details'][$type]['srch']['custday_price']; 
                           else
                           $clientprice=$row['product_details'][$type]['srch']['custend_price']; 
                        }
                        else
                        {
                            $clientprice=$row['product_details'][$type]['srch']['cust_price'];
                        }*/
                        $clientprice=$price;
                    }
                    if($comm_percent!='')
                    {
                        $clientprice=$clientprice+(($comm_percent*$clientprice)/100);
                    }
                    if($qty>1)
                    {
                        $price=$price* $qty;
                        $clientprice=$clientprice* $qty;
                    } 
                    
                    $resrow=$row['product_details'][$type];

                    $airport_arrival=$resrow['airlineout'];
                    if($airport_arrival=='Others'){ $airport_arrival= $resrow['airlineout_OthersTxt'];}     


                    $no_people=$row['person_details'][$type]['no_people'];
                    if($no_people=='Others'){ $no_people= $row['person_details'][$type]['no_people_OthersTxt'];} 

                    /*$resrowout=$row['product_details'][$type];
                    $dropoffout_addr=$resrowout['meet_dest']; 
                    if($dropoffout_addr=='Others'){ $dropoffout_addr= $resrow['meet_dest_OthersTxt'];}     
                    */
                    $dropoffout_addr='';
                    
                    $airport_dept=$resrowout['airport_dept'];
                    if($airport_dept=='others'){ $airport_dept= $resrowout['airport_dept_OthersTxt'];}
                    
                    $airlineout=$resrowout['airlineout'];
                    if($airlineout=='Others'){ $airlineout= $resrowout['airlineout_OthersTxt'];}
                    
                    $pickup_hr='0';
                    $pickup_mt='0';
                    $pickup_meridian='0';
                    if(isset($resrowout['arriv_estim_tm']) && trim($resrowout['arriv_estim_tm'])!='')
                    {
                        $pickarr=explode(":", trim($resrowout['arriv_estim_tm']));
                        $pickup_hr=$pickarr[0];
                        if(isset($pickarr[1]) && trim($pickarr[1])!='')
                        {
                            $pickarrEx=explode(" ", trim($pickarr[1]));
                            $pickup_mt=$pickarrEx[0];
                            $pickup_meridian=$pickarrEx[1];
                        }
                    }
                    $trav_id=db_insert('log_detailed_out_travel_Info')
                     ->fields(array(
                       'checkout_id' => $checkout_id,
                       'ls_id' => $ls_id,
                       'user_id' => $user_id,
                       'service_type' => trim($row['product_details']['serv_type']), 
                       'service_dt' => $resrowout['serv_day'], 
                       'airport_dept' => $airport_dept, 
                       'airline' => $airline,
                       'flight_no' => $resrowout['flight_no_out'],
                       'decol_hr' => $resrowout['arrivout_hr'],
                       'decol_mt' => $resrowout['arrivout_mt'],
                       'decol_meridian' => $resrowout['arrivout_meridian'], 
                       'pickup_hr' => $pickup_hr,
                       'pickup_mt' => $pickup_mt,
                       'pickup_meridian' => $pickup_meridian,
                       'pickup_addr' => $resrowout['decol_shed'], 
                       'drop_addr' => $dropoffout_addr, 
                       'lang_driv_hostess' => $resrowout['driv_lang_out'],
                       'comments' => $resrowout['spl_comment_out'],
                       'created_dt' => REQUEST_TIME, 
                     ))->execute();
                    
                     for($inc=0;$inc<count($resrow['passengerDetails']);$inc++)
                    {
                        db_insert('logout_trav_person_details')
                        ->fields(array(
                          'trav_id' => $trav_id,
                          'title' => $resrow['passengerDetails'][$inc]['surtitle_out'],
                          'first_name' => $resrow['passengerDetails'][$inc]['fname_out'],
                          'middle_name' => '',
                          'last_name' => $resrow['passengerDetails'][$inc]['pasengername_out'],
                          'ph_no' => $resrow['passengerDetails'][$inc]['tnum_out'],
                          'created_dt' => REQUEST_TIME, 
                        ))->execute();

                    } 

                    break;
                    case "Commute":
                    $qty=$row['product_details'][$type]['qty'];
                    $price=$row['product_details'][$type]['price'];
                    $clientprice=0;                    
                    //Check for travek agent Login
                    if(isset($user->roles[5]))
                    { 
                        /*if(trim($row['product_details']['serv_type'])=='meet_greet')
                        {
                           if($row['product_details'][$type]['srch']['applied']=='weekday')                   
                           $clientprice=$row['product_details'][$type]['srch']['custday_price']; 
                           else
                           $clientprice=$row['product_details'][$type]['srch']['custend_price']; 
                        }
                        else
                        {
                            $clientprice=$row['product_details'][$type]['srch']['cust_price'];
                        }*/
                        $clientprice=$price;
                    }
                    if($comm_percent!='')
                    {
                        $clientprice=$clientprice+(($comm_percent*$clientprice)/100);
                    }
                    if($qty>1)
                    {   
                        $price=$price*$qty;
                        $clientprice=$clientprice*$qty;
                    }

                    $resrow=$row['product_details'][$type]['IN'];

                    /*$dest_addr=$resrow['dest_addr'];
                    if($dest_addr=='Others'){ $dest_addr= $resrow['dest_addr_OthersTxt'];} 
                    */

                    $no_people=$row['person_details'][$type]['no_people'];
                    if($no_people=='Others'){ $no_people= $row['person_details'][$type]['no_people_OthersTxt'];} 

                    $airport_arrival=$resrow['ariport_origin'];
                   
                    $airline=$resrow['airline'];
                    if($airline=='Others'){ $airline= $resrow['airline_OthersTxt'];}



                    $odd_bag=$row['person_details'][$type]['odd_bag'];
                    if($odd_bag=='Others'){ $odd_bag= $row['person_details'][$type]['odd_bag_OthersTxt'];} 

                    $resrowout=$row['product_details'][$type]['Out'];


                    $dropoffout_addr='';
                    //$resrowout['meet_dest'];                   

                   /* $airport_dept=$resrowout['airlineout'];
                    if($airport_dept=='others'){ $airport_dept= $resrowout['airlineout_OthersTxt'];} 
                        */
                      $trav_id=db_insert('log_detailed_in_travel_Info')
                        ->fields(array(
                          'checkout_id' => $checkout_id,
                          'ls_id' => $ls_id,
                          'user_id' => $user_id,
                          'service_type' => trim($row['product_details']['serv_type']),
                          'arriv_dt' => $resrow['arriv_day'], 
                          'arrival_airport' => $airport_arrival, 
                          'arriv_hr' => $resrow['arriv_hr'],
                          'arriv_mt' => $resrow['arriv_mt'],
                          'arriv_meridian' => $resrow['arriv_meridian'],
                          'airline' => $airline,
                          'flight_no' => $resrow['flight_no'],
                          'driver_hostess_lang' => $resrow['driv_lang'],
                          'comments' => $resrow['spl_comment'],
                          'dest_addr' => '',
                          'created_dt' => REQUEST_TIME, 
                        ))->execute();

                     for($inc=0;$inc<count($resrow['passengerDetails']);$inc++)
                    {
                        db_insert('login_trav_person_details')
                        ->fields(array(
                          'trav_id' => $trav_id,
                          'title' => $resrow['passengerDetails'][$inc]['surtitle'],
                          'first_name' => $resrow['passengerDetails'][$inc]['fname'],
                          'middle_name' => '',
                          'last_name' => $resrow['passengerDetails'][$inc]['pasengername'],
                          'ph_no' => $resrow['passengerDetails'][$inc]['tnum'],
                          'created_dt' => REQUEST_TIME, 
                        ))->execute();
                         db_insert('logout_trav_person_details')
                        ->fields(array(
                          'trav_id' => $trav_id,
                          'title' => $resrow['passengerDetails'][$inc]['surtitle'],
                          'first_name' => $resrow['passengerDetails'][$inc]['fname'],
                          'middle_name' => '',
                          'last_name' => $resrow['passengerDetails'][$inc]['pasengername'],
                          'ph_no' => $resrow['passengerDetails'][$inc]['tnum'],
                          'created_dt' => REQUEST_TIME, 
                        ))->execute();

                    } 
                    
                    $pickup_hr='0';
                    $pickup_mt='0';
                    $pickup_meridian='0';
                    if(isset($resrowout['arriv_estim_tm']) && trim($resrowout['arriv_estim_tm'])!='')
                    {
                        $pickarr=explode(":", trim($resrowout['arriv_estim_tm']));
                        $pickup_hr=$pickarr[0];
                        if(isset($pickarr[1]) && trim($pickarr[1])!='')
                        {
                            $pickarrEx=explode(" ", trim($pickarr[1]));
                            $pickup_mt=$pickarrEx[0];
                            $pickup_meridian=$pickarrEx[1];
                        }
                    }
                    $airport_dept=$resrowout['airport_dept'];
                    if($airport_dept=='others'){ $airport_dept= $resrowout['airport_dept_OthersTxt'];}
                    
                    $airlineout=$resrowout['airlineout'];
                    if($airlineout=='Others'){ $airlineout= $resrowout['airlineout_OthersTxt'];}

                     $trav_id=db_insert('log_detailed_out_travel_Info')
                     ->fields(array(
                       'checkout_id' => $checkout_id,
                       'ls_id' => $ls_id,
                       'user_id' => $user_id,
                       'service_type' => trim($row['product_details']['serv_type']), 
                       'service_dt' => $resrowout['serv_day'], 
                       'airport_dept' => $airport_dept, 
                       'airline' => $airlineout,
                       'flight_no' => $resrowout['flight_no_out'],
                       'decol_hr' => $resrowout['arrivout_hr'],
                       'decol_mt' => $resrowout['arrivout_mt'],
                       'decol_meridian' => $resrowout['arrivout_meridian'], 
                       'pickup_hr' => $pickup_hr,
                       'pickup_mt' => $pickup_mt,
                       'pickup_meridian' => $pickup_meridian,
                       'pickup_addr' => $resrowout['decol_shed'], 
                       'drop_addr' => $dropoffout_addr, 
                       'lang_driv_hostess' => $resrowout['driv_lang_out'],
                       'comments' => $resrowout['spl_comment_out'],
                       'created_dt' => REQUEST_TIME, 
                     ))->execute();

                      for($inc=0;$inc<count($resrowout['passengerDetails']);$inc++)
                    {
                        db_insert('logout_trav_person_details')
                        ->fields(array(
                          'trav_id' => $trav_id,
                          'title' => $resrowout['passengerDetails'][$inc]['surtitle_out'],
                          'first_name' => $resrowout['passengerDetails'][$inc]['fname_out'],
                          'middle_name' => '',
                          'last_name' => $resrowout['passengerDetails'][$inc]['pasengername_out'],
                          'ph_no' => $resrowout['passengerDetails'][$inc]['tnum_out'],
                          'created_dt' => REQUEST_TIME, 
                        ))->execute();
                    } 
                      }

                      break; 
                  break;
                case "driver_at_disposal":               
                  if(trim($row['product_details'][$type]['typeTransfer'])=='driv')
                  {
                    $qty=$row['product_details'][$type]['qty'];
                    $price=$row['product_details'][$type]['price'];
                    $clientprice=0;
                    //Check for travek agent Login
                    if(isset($user->roles[5]))
                    { 
                        //$clientprice=$row['product_details'][$type]['srch']['cust_price'];
                        $clientprice=$price;
                    }
                    
                    if($comm_percent!='')
                    {
                        $clientprice=$clientprice+(($comm_percent*$clientprice)/100);
                    }

                    if($qty>1)
                    {   
                        $price=$price* $qty;
                        $clientprice=$clientprice* $qty;
                    } 
                   

                    $resrow=$row['product_details'][$type];                


                    $pick_addr=$resrow['pick_addr'];
                    if($pick_addr=='Others'){ $pick_addr= $resrow['pick_addr_OthersTxt'];} 
                    else{$pick_addr.=' '.$resrow['pick_addr_OthersTxt'];} 

                    $dest_addr=$resrow['dest_addr'];
                    if($dest_addr=='Others'){ $dest_addr= $resrow['dest_addr_OthersTxt'];} 
                    else{$dest_addr.=' '.$resrow['dest_addr_OthersTxt'];} 

                    $endserv_addr=$resrow['endserv_addr'];
                    if($endserv_addr=='Others'){ $endserv_addr= $resrow['endserv_addr_OthersTxt'];} 
                    else{$endserv_addr.=' '.$resrow['endserv_addr_OthersTxt'];} 

                    $name_addr=$resrow['name_addr'];
                    if($name_addr=='Others'){ $name_addr= $resrow['name_addr_OthersTxt'];} 
                    else{$name_addr.=' '.$resrow['name_addr_OthersTxt'];} 


                  $trav_id=db_insert('log_driv_disposal_travel_Info')
                    ->fields(array(
                      'checkout_id' => $checkout_id,
                      'ls_id' => $ls_id,
                      'user_id' => $user_id,
                      'service_dt' => $resrow['service_day'],
                      'depart_hr' => $resrow['dept_hr'],
                      'depart_mt' => $resrow['dept_mt'],
                      'depart_meridian' => $resrow['dept_meridian'],
                      'arrival_hr' => $resrow['arriv_hr'],
                      'arrival_mt' => $resrow['arriv_mt'],
                      'arrival_meridian' => $resrow['arriv_meridian'],
                      'pickup_addr' => $pick_addr, 
                      'dest_addr' => $dest_addr,
                      'name_addr' => $name_addr,
                      'end_serv_addr' => $endserv_addr,                      
                      'lang_driv' => $row['product_details'][$type]['driv_lang'],
                      'comments' => $row['product_details'][$type]['spl_comment'],
                      'created_dt' => REQUEST_TIME, 
                    ))->execute();

                  for($inc=0;$inc<count($resrow['passengerDetails']);$inc++)
                    {

                        db_insert('log_trav_person_details')
                        ->fields(array(
                          'trav_id' => $trav_id,
                          'title' => $resrow['passengerDetails'][$inc]['surtitle'],
                          'first_name' => $resrow['passengerDetails'][$inc]['fname'],
                          'middle_name' => '',
                          'last_name' => $resrow['passengerDetails'][$inc]['pasengername'],
                          'ph_no' => $resrow['passengerDetails'][$inc]['tnum'],
                          'created_dt' => REQUEST_TIME, 
                        ))->execute();


                    }
                  break;  
                  }
                }
                    /*
                    if($value['product_details'][$type]['status']=='complete'){
                      $cartqty++;
                    }*/
                }
            }
        }
        
        if($comm_percent!='')
        {
            $tot_price=$tot_price+(($comm_percent*$tot_price)/100);
        }
       
        db_update('log_detailed_transfer_results_checkout')
        ->fields(array(
                  'qty' => $cartqty,
                  'act_price' => $subtot_price,
                  'total_amt' => $tot_price, 
                ))
        ->condition ('id', $checkout_id, '=')
        ->execute();
        
       
        $REFERENCE='PTX'.$checkout_id.' payment';
        $MONTANT=$tot_price;
        $PORTEUR=$user->mail;
       
        $retval['REFERENCE']=$REFERENCE;
        $retval['PORTEUR']=$PORTEUR;
        
        if(isset($user->roles[5]))
        $retval['MONTANT']=$tot_price; 
        else
        $retval['MONTANT']=$subtot_price; 
        
        
        //Future need to comment
        $retval['CHKOUTID']=$checkout_id; 
    }
    
    
    // Todo For sending emails
    
    
    //Send to customer email
    
    
    //Send for Travel agent email
    
    //Generate PDf files
    
    
    $cart=array();
    $_SESSION['products'] = serialize($cart); 
    unset($_SESSION['products']);
    unset($_SESSION['comm_percent']);
    echo json_encode($retval); 
    
   

}


if($_REQUEST['process'] == 'commissionUpdate'){
    $retval='';
    if(isset($_REQUEST['comm']))
    {
        $_SESSION['comm_percent'] =trim($_REQUEST['comm']); 
        $retval='Updated';
    }
    echo json_encode($retval); 
}





?>
