<?php
class searchParam{    
    //var $from;
    var $_type;
    var $_region;
    var $_typeTransfer;
    var $_from;
    var $_to;
    
    function searchParam(){
        if ((isset($_POST['from'])) && (isset($_POST['to']))){
        $this->_type = $_POST['type'];
        $this->_region = $_POST['selectregion'];
        $this->_typeTransfer = $_POST['typeoftransfer'];    
        $this->_from = $_POST['from'];    
        $this->_to = $_POST['to'];        
        }
        $this->_selectregion = $_POST['selectregion'];
        if ((isset($_POST['selectregion'])) && (isset($_POST['desgination']))){
                    $this->_selectregion = $_POST['selectregion'];                    
                    $this->_desg = $_POST['desgination'];

        }
      
    }    
    function getSearchParams(){        
        $searchParams = array();
        $searchParams['type']   = $_POST['type'];
        $searchParams['region'] = $_POST['selectregion'];
        $searchParams['typetransfer'] = $_POST['typeoftransfer'];    
        $searchParams['from'] = $_POST['from'];    
        $searchParams['to'] = $_POST['to'];
        if ((isset($_POST['selectregion'])) && (isset($_POST['desgination']))){
                     $searchParams['selectregion'] = $_POST['selectregion'];
                   $searchParams['dest'] = $_POST['desgination'];

        }
        return $searchParams;   
    }    
    function getSearchResult(){
        if ((isset($_POST['from'])) && (isset($_POST['to']))){           
         $region = str_replace("'","\'",$this->_region);
         $to = str_replace("'","\'",$this->_to);
         $from = str_replace("'","\'",$this->_from);
         $resultArry = db_query("select field_data_field_transfer_price.entity_id as Nid,field_data_field_transfer_price.delta as rorder,field_transfer_price_value,field_region_to_value,field_agent_price_value,
        field_region_from_value,field_price_value,field_region_value from field_data_field_transfer_price
        join field_data_field_region_from on field_data_field_transfer_price.field_transfer_price_value = field_data_field_region_from.entity_id
        join field_data_field_region_to on field_data_field_transfer_price.field_transfer_price_value =field_data_field_region_to.entity_id
        join field_data_field_price on field_data_field_transfer_price.field_transfer_price_value =field_data_field_price.entity_id
        join field_data_field_region on field_data_field_transfer_price.field_transfer_price_value =field_data_field_region.entity_id
        join field_data_field_agent_price on field_data_field_transfer_price.field_transfer_price_value =field_data_field_agent_price.entity_id
        where field_data_field_region.field_region_value ='".$region."' and field_data_field_region_from.field_region_from_value = '".$from."'
        and field_data_field_region_to.field_region_to_value='".$to."'");
        
            foreach ($resultArry as $row) {             
               $avilCar[] = $row->Nid;
               $avilCar['price'][$row->Nid] = $row->field_price_value;
               $avilCar['delta'][$row->Nid] = $row->rorder;               
               $avilCar['agentprice'][$row->Nid] = $row->field_agent_price_value;               
            }
            if(empty($avilCar)){
                $avilCar['NR'] = 'No Records';
                return $avilCar;
            }
            return $avilCar;
       }
    }
    
    function getSearchResultMeetGreet(){        
         if ((isset($_POST['type'])) && ($_POST['type'] == 'Meet and Greet')) {            
        $resultArry = "select field_data_field_meet_greet_prices.entity_id as Nid,field_data_field_meet_greet_prices.delta as rorder,
          field_meet_greet_prices_value as refnumber,field_price_additional_value as extrafee,
        field_price_luggage_handling_value as lunggagefee,field_price_weekdays_value as weekdayprice,
        field_price_weekend_value as weekendprice,
        field_agent_meetg_price_value as agentprice,
        field_data_field__meet_region.field__meet_region_value as region from  field_data_field_meet_greet_prices
        join field_data_field_price_additional on field_data_field_meet_greet_prices.field_meet_greet_prices_value = field_data_field_price_additional.entity_id
        join field_data_field_price_luggage_handling on field_data_field_meet_greet_prices.field_meet_greet_prices_value = field_data_field_price_luggage_handling.entity_id
        join  field_data_field_agent_meetg_price on field_data_field_meet_greet_prices.field_meet_greet_prices_value = field_data_field_agent_meetg_price.entity_id
        join field_data_field_price_weekdays on field_data_field_meet_greet_prices.field_meet_greet_prices_value =  field_data_field_price_weekdays.entity_id
        join field_data_field_price_weekend on field_data_field_meet_greet_prices.field_meet_greet_prices_value =  field_data_field_price_weekend.entity_id
        join field_data_field__meet_region on field_data_field_meet_greet_prices.field_meet_greet_prices_value =  field_data_field__meet_region.entity_id
        where field_data_field__meet_region.field__meet_region_value = '".$this->_selectregion."'";
            
            $resultSet = db_query($resultArry);
              foreach ($resultSet as $row) {               
               $avilGreets[] = $row->Nid;
               $avilGreets['extraprice'][$row->Nid] = $row->extrafee;
               $avilGreets['lunggagefee'][$row->Nid] = $row->lunggagefee;
               $avilGreets['weekdayprice'][$row->Nid] = $row->weekdayprice;
               $avilGreets['weekendprice'][$row->Nid] = $row->weekendprice;
               $avilGreets['agentprice'][$row->Nid] = $row->agentprice;
               $avilGreets['delta'][$row->Nid] = $row->rorder;               
             }
             if(empty($avilGreets)){
                $avilGreets['NR'] = 'No Records';
                return $avilGreets;
            }
            return $avilGreets;
         }
    }
    
       
    function getSearchResultDriver(){
         if ((isset($_POST['desgination'])) && (isset($_POST['selectregion']))) {            
        $resultArry = "select        
        field_data_field_driverdisposal_region.entity_id as Nid,
        field_data_field_driverdisposal_region.delta as rorder,
        field_data_field_driver_disposal_region.field_driver_disposal_region_value as region,
        field_driver_disp_price_value as price,
        field__driver_disp_destination_value as destination,
        field_extra_charge_for_1_hour_value as latefee,
        field_extra_charge_between_8_pm__value as chargefornighttime,
        field_agent_price_driverd_value as agentprice,
        field_extra_charge_drop_off_in_p_value as chargedropoff  from field_data_field_driverdisposal_region
        join field_data_field_driver_disp_price on field_data_field_driverdisposal_region.field_driverdisposal_region_value = field_data_field_driver_disp_price.entity_id
        join field_data_field_driver_disposal_region on field_data_field_driverdisposal_region.field_driverdisposal_region_value = field_data_field_driver_disposal_region.entity_id
              join field_data_field__driver_disp_destination on field_data_field_driverdisposal_region.field_driverdisposal_region_value = field_data_field__driver_disp_destination.entity_id           
        join field_data_field_extra_charge_for_1_hour on field_data_field_driverdisposal_region.field_driverdisposal_region_value =  field_data_field_extra_charge_for_1_hour.entity_id
        join field_data_field_extra_charge_drop_off_in_p on field_data_field_driverdisposal_region.field_driverdisposal_region_value =  field_data_field_extra_charge_drop_off_in_p .entity_id
        join  field_data_field_extra_charge_between_8_pm_ on field_data_field_driverdisposal_region.field_driverdisposal_region_value =  field_data_field_extra_charge_between_8_pm_.entity_id
        join field_data_field_agent_price_driverd on field_data_field_driverdisposal_region.field_driverdisposal_region_value =   field_data_field_agent_price_driverd.entity_id
        where field_data_field_driver_disposal_region.field_driver_disposal_region_value = '".trim($this->_selectregion)."' and field_data_field__driver_disp_destination.field__driver_disp_destination_value = '".trim($this->_desg)."'";   
            
            $resultSet = db_query($resultArry);
              foreach ($resultSet as $row) {               
               $avilDrivers[] = $row->Nid;
               $avilDrivers['price'][$row->Nid] = $row->price;
               $avilDrivers['latefee'][$row->Nid] = $row->latefee;
               $avilDrivers['nightfee'][$row->Nid] = $row->chargefornighttime;
               $avilDrivers['agentprice'][$row->Nid] = $row->agentprice;
               $avilDrivers['delta'][$row->Nid] = $row->rorder;               
               $avilDrivers['extradropoff'][$row->Nid] = $row->chargedropoff;
               $avilDrivers['sdestination'][$row->Nid] = $row->destination;
             }
             if(empty($avilDrivers)){
                $avilDrivers['NR'] = 'No Records';
                return $avilDrivers;
            }
            return $avilDrivers;
         }
    }
    
    
}


?>