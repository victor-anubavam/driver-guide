<?php

/**
 * @file
 * Template to display a view as a table.
 *
 * - $title : The title of this group of rows.  May be empty.
 * - $header: An array of header labels keyed by field id.
 * - $header_classes: An array of header classes keyed by field id.
 * - $fields: An array of CSS IDs to use for each field id.
 * - $classes: A class or classes to apply to the table, based on settings.
 * - $row_classes: An array of classes to apply to each row, indexed by row
 *   number. This matches the index in $rows.
 * - $rows: An array of row items. Each row is an array of content.
 *   $rows are keyed by row number, fields within rows are keyed by field ID.
 * - $field_classes: An array of classes to apply to each field, indexed by
 *   field id, then row number. This matches the index in $rows.
 * @ingroup views_templates
 */
?>

<?php
include DRUPAL_ROOT."/sites/all/libraries/searchParam.php";
set_time_limit(900);
$searchFields = new searchParam();
$searchFieldsArry= $searchFields->getSearchResultMeetGreet();
$i = 0;
global $base_url;
$driv_name='';
$driv_num='';

if(isset($searchFields->_selectregion) && trim($searchFields->_selectregion)!='')
{
    $result=db_query("SELECT field_meet_greet_region_family as driv_name, field_meet_greet_region_generational as driv_num 
        FROM `field_data_field_meet_greet_region` where field_meet_greet_region_given='".$searchFields->_selectregion."' limit 1 ");
    foreach ($result as $record) {   
        $driv_name=$record->driv_name;
        $driv_num=$record->driv_num;
     }
     $night_rate_comm=db_query("SELECT fp.field_night_rate_percentage_value FROM 
         field_collection_item as fc LEFT JOIN field_data_field_night_rate_region as fr ON fc.item_id=fr.entity_id 
         LEFT JOIN  field_data_field_night_rate_percentage as fp ON fc.item_id=fp.entity_id  
         where fc.field_name ='field_percentage' AND  fr.field_night_rate_region_value='".trim($searchFields->_selectregion)."' limit 1 ")->fetchField();
    
}
?>
<table <?php if ($classes) { print 'class="'. $classes . '" '; } ?><?php print $attributes; ?>>
  <?php if (!empty($title)) : ?>
    <caption><?php print $title; ?></caption>
  <?php endif; ?>
  <?php if (!empty($header)) : ?>
    <thead>
      <tr>
       <td class="history-lt" colspan="3">        
           Region : <?php echo $searchFields->_selectregion;?>
       </td>
       <td class="history-rt">&nbsp;
       </td>
      </tr>
    </thead>
  <?php endif; ?>
  <tbody>
      <input type="hidden" name="selectregion" id="selectregion" value="<?php echo $searchFields->_selectregion; ?>" />
      <input type="hidden" name="driv_name" id="driv_name" value="<?php echo $driv_name; ?>" />
      <input type="hidden" name="driv_num" id="driv_num" value="<?php echo $driv_num; ?>" />
      <input type="hidden" name="night_rate_comm" id="night_rate_comm" value="<?php echo $night_rate_comm; ?>" />
<?php
$record = 0;
if(isset($_SESSION['products']))
$cart=unserialize($_SESSION['products']);
else
$cart=array();

$filterArry = array();
$record = 0;
foreach ($rows as $row) {    
if ((in_array(($row['nid']),$searchFieldsArry)) && (empty($searchFieldsArry['NR'])) && ($row['delta'] == $searchFieldsArry['delta'][$row['nid']])){    
        $record ++;                 
        $filterArry[$record] = $row;
        $filterArry[$record]['price'] = $searchFieldsArry['weekdayprice'][$row['nid']];
         
 }
}

aasort($filterArry,"price");

foreach ($filterArry as $row) {
 if ((in_array(($row['nid']),$searchFieldsArry)) && (empty($searchFieldsArry['NR'])) && ($row['delta'] == $searchFieldsArry['delta'][$row['nid']])){    
        $record ++;       
        $custday_price=$searchFieldsArry['weekdayprice'][$row['nid']];
        $dayprice=$custday_price;
        $custend_price=$searchFieldsArry['weekendprice'][$row['nid']];
        $endprice=$custend_price;
        $agt_comm= $searchFieldsArry['agentprice'][$row['nid']];
        //Check for travek agent Login
        if(isset($user->roles[5]))
        {   
            /*$agtday_price=$custday_price-(($custday_price*$agt_comm)/100);
            $dayprice=$agtday_price;
            $agtend_price=$custend_price-(($custend_price*$agt_comm)/100);
            $endprice=$agtend_price;*/
            $dayprice=$custday_price;
            $endprice=$custend_price;
        } 
        ?>
        <tr>       
          <td class="car-image">
            <div class="ImgCenter">
            <div class="shadow">
               <?php print $row['field_meet_image']; ?>
            </div>
            </div>
          </td>
          <td class="title-desc">
              <input type="hidden" name="servtitle_<?php echo $row['nid'];?>"  id="servtitle_<?php echo $row['nid'];?>" value="<?php echo strip_tags($row['title']); ?>" />
               <?php print $row['title']."<br>".$row['body']; ?>
          </td>
          <td class="check-out">
             <div class="info">
               <span class="pass-info"><div class="value"><?php  echo $row['field_maximum_number_of_passenge']; ?></div></span>
               <span class="bags-info"><div class="value"><?php echo $row['field_maximum_luggage']; ?></div></span>
            </div>
           <div class="price">
           <span class="week">Weekday :</span><?php echo $dayprice."&nbsp;<b>&euro;</b>"; ?><br/>
           <span class="week">Weekend :</span><?php echo $endprice."&nbsp;<b>&euro;</b>"; ?>   
           </div>
           
            <div class="cart">
            <?php
            if ($user->uid && $user->uid!=0)
            {  
                if(isset($cart[$row['nid']]['product_details'][$row['field_type']]['srch']['selectregion']) && trim($cart[$row['nid']]['product_details'][$row['field_type']]['srch']['selectregion'])==trim($searchFields->_selectregion)){?>
                <a href="javascript:void(0);" id="cart_<?php echo $row['nid'];?>" onclick="removefromCart('<?php echo $row['nid'];?>','<?php echo $dayprice; ?>','<?php echo $row['field_type'];?>')"><div class="remove">REMOVE FROM CART</div></a>
                <?php }else{ ?>
               <a href="javascript:void(0);" id="cart_<?php echo $row['nid'];?>" onclick="addtoCart('<?php echo $row['nid'];?>','<?php echo $dayprice; ?>','<?php echo $row['field_type']?>')"> <div class="add">ADD TO CART</div></a>
                <?php }?>
               <a href="javascript:void(0);" onClick="document.location.href='<?php echo $base_url.'/mycart'; ?>'"><div  class="remove">VIEW CART</div></a>
           <?php
            }
            else
            {
              ?>
               <a href="javascript:void(0);" id="cart_<?php echo $row['nid'];?>" onclick="addService()"> <div class="add">ADD TO CART</div></a>
               <?php
            }
            ?>
           <input type="hidden" name="delta_<?php echo $row['nid'];?>" id="delta_<?php echo $row['nid'];?>" value="<?php echo $row['delta']; ?>" />    
           <input type="hidden" name="max_people_<?php echo $row['nid'];?>" id="max_people_<?php echo $row['nid'];?>" value="<?php echo $row['field_maximum_number_of_passenge']; ?>" />
           <input type="hidden" name="max_lugg_<?php echo $row['nid'];?>" id="max_lugg_<?php echo $row['nid'];?>" value="<?php echo $row['field_maximum_luggage']; ?>" />
           <input type="hidden" name="custday_price_<?php echo $row['nid'];?>" id="custday_price_<?php echo $row['nid'];?>" value="<?php echo $custday_price; ?>" />
           <input type="hidden" name="custend_price_<?php echo $row['nid'];?>" id="custend_price_<?php echo $row['nid'];?>" value="<?php echo $custend_price; ?>" />
           <input type="hidden" name="agt_comm_<?php echo $row['nid'];?>" id="agt_comm_<?php echo $row['nid'];?>" value="<?php echo $agt_comm; ?>" />
            </div>
          </td>
      </tr>
 <?php } } if($record == 0){ ?>
    <tr style="border: none;"><td><b>No Records Found</b></td></tr>
 <?php } ?>
 
  </tbody>
</table>
