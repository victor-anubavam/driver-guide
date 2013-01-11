<?php

/**
 * @file
 * PHP page for handling incoming XML-RPC requests from clients.
 */

/**
 * Root directory of Drupal installation.
 */
//define('DRUPAL_ROOT', getcwd());

include_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
?>
<span class="etype-error errmes"></span>
<div class="typeicon">
<select class="type-service">
<option value="" selected>Select type of service</option>
<option value="Transfer">Transfer</option>
<option value="Meet & Greet">Meet & Greet</option>
<option value="Driver at disposal">Driver at disposal</option>
</select>
</div>

<form action="/service-as-transfer-results" class="Transfer" id="transger-section" method="post" enctype="multipart/form-data">
    <span class="ereg-error errmes"></span>
    <div class="regionicon">
    <select class="region tregion" name="selectregion" id="region" onchange="regionFromHome(this,'reg_from','reg_to')">
        <option selected value="">Select Region</option>
        <?php  $query = db_query("select distinct(title) from node where type='transfer_region'");
         foreach ($query as $row) {   ?>
         <option value="<?php echo $row->title;?>"><?php echo $row->title; ?></option>
         <?php }     ?>
    </select></div>
    <span class="etypetrans-error errmes"></span>
    <div class="transfericon">
      <select class="typeoftransfer" name="typeoftransfer">
        <option selected value="">Select Type of Transfer</option>
        <option value="in">One way only IN</option>
        <option value="out">One way only OUT</option>
        <option value="in&out">Round trip IN & OUT</option>
    </select>
    </div>
      <span class="efrom-error errmes"></span>
      <div class="fromicon">
      <select class="from" name="from" id="reg_from" onchange="regionToHome(this,'reg_from','reg_to')"> 
        <option selected value="">Select From</option>
      <?php
         $query = db_query("select distinct(field_region_from_value) from field_data_field_region_from");
         foreach ($query as $row) {   ?>
         <option value="<?php echo $row->field_region_from_value;?>"><?php echo $row->field_region_from_value; ?></option>
         <?php }     ?>
    </select>
      </div>
       <span class="etype-to errmes"></span>
      <div class="toicon">
      <select class="to" name="to" id="reg_to">
        <option selected value="">Select To</option>
         <?php
         $query = db_query("select distinct(field_region_to_value) from field_data_field_region_to");
         foreach ($query as $row) {   ?>
         <option value="<?php echo $row->field_region_to_value;?>"><?php echo $row->field_region_to_value; ?></option>
         <?php }     ?>
    </select>
      </div>
          <div id="msgDivOuttrans"><div id="msgDivtrans"></div></div>
      <br/>
       <div id="searchDiv">
      <input type="hidden" value="transfer" name="type"/>
    <input type="submit" value="SEARCH" class="searchsub">
       </div>
</form>

<form method="post" enctype="multipart/form-data" action="/meet-and-greet-results" class="Meet" id="meet-greet-section" style="display:  none;">
    <span class="ereg-error errmes"></span>
    <div class="regionicon">
    <select class="driveratdispoal mgregion" name="selectregion" id="ngregion">
        <option selected value="">Select Region</option>
        <?php  $query = db_query("select distinct(title) from node where type='meet_greet_region'");
         foreach ($query as $row) {   ?>
         <option value="<?php echo $row->title;?>"><?php echo $row->title; ?></option>
         <?php }     ?>
    </select></div>
     <div id="searchDiv">
      <input type="hidden" value="Meet and Greet" name="type"/>
    <input type="submit" value="SEARCH" class="searchsub">
     </div>
</form>


<form method="post" enctype="multipart/form-data" action="/driver-at-disposal-result" class="driverd" id="driveratd" style="display:  none;">
    <span class="ereg-error errmes"></span>
    <div class="regionicon">
    <select class="meetandgreetregion" name="selectregion" id="ngregion">
        <option selected value="">Select Region</option>
        <?php  $query = db_query("select distinct(title) from node where type='car_at_disposal_region'");
         foreach ($query as $row) {   ?>
         <option value="<?php echo $row->title;?>"><?php echo $row->title; ?></option>
         <?php }     ?>
    </select></div>   
    <div class="departtime">
        <label >Pickup hour</label>
        <span class="edeahour errmes"></span>
        <span class="emins errmes"></span>
        <input readonly="true" type="text" name="depart_hr_mt_pickuph" id="depart_hr_mt_pickuph" class="departhours"/>&nbsp;
        <img src="<?php echo drupal_get_path('theme', 'privatetransfer_theme')."/images/clock_home.png"; ?>" class="calimg" id="depart_hrimg"  />
        
        <!--
        <select class="departhours" name="dtimehours">
            <option value="" selected>Hours</option>
              <?php for($i=1; $i<=12;$i++) { ?>
             <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
              <?php } ?>
        </select>
        <select class="departmins" name="dtimemins">
            <option value="" selected>Min</option>
             <option value="00">00</option>
            <option value="15">15</option>
            <option value="30">30</option>
            <option value="45">45</option>
        </select>
         <select class="arr-day-night" name="day-night-dep">
            <option value="" selected>Select</option>
             <option value="AM">AM</option>
            <option value="PM">PM</option>            
        </select>-->
    </div>
    
    <div class="departtime arrivetime">
        <label >Drop off hour</label>
        <input readonly="true" type="text" name="depart_hr_mt_droph" id="depart_hr_mt_droph" class="departhours"/>&nbsp;
        <img src="<?php echo drupal_get_path('theme', 'privatetransfer_theme')."/images/clock_home.png"; ?>" class="calimg" id="departdrop_hrimg"  />
        <!--<select class="arrparthours" name="arrtimehours">
            <option value="" selected>Hours</option>
             <?php for($i=1; $i<=12;$i++) { ?>
             <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
              <?php } ?>  
        </select>
        <select class="arrmins" name="arrtimemins">
            <option value="" selected>Min</option>
            <option value="00">00</option>
            <option value="15">15</option>
            <option value="30">30</option>
            <option value="45">45</option>
        </select>
           <select class="drop-day-night" name="day-night-arr">
            <option value="" selected>Select</option>
             <option value="AM">AM</option>
            <option value="PM">PM</option>            
        </select>-->
    </div>
         <div class="des">
        <span class="edest-error errmes"></span>
        
        <select class="ddesg" id="ddesg" name="desgination">
            <option value="" selected>Select destination</option>
        <?php 
        $query = db_query("SELECT field_regions_given,field_regions_middle,field_regions_family from field_data_field_regions");         
         foreach ($query as $rows) {
         $regName = $rows->field_regions_given;
         $regDuration = $rows->field_regions_middle;
         $frmet = $regName." - ".$regDuration;
        ?>
    
         <?php }   ?>
        </select>
    </div>
   <!-- <div class="noofpass-wrapper">
         <span class="epass errmes"></span>
        <select class="noofpass" id="noofpass-dis">
            <option value="" selected>-- Select --</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>            
        </select>
    </div> -->

    
    <br>
    <div id="dispSearch">
    <div id="msgDivOut"><div id="msgDiv"></div></div>
    <div id="searchDiv">
      <input type="hidden" value="Driver at disposal" name="type"/>
      <input type="hidden" value="0" name="extraHour"/>
       <input type="hidden" value="0" name="extramins"/> 
    <input type="submit" value="SEARCH" class="searchsub" style="margin-top: 10px;">  
    </div>
    </div>
</form>
