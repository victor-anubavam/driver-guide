function regionFrom(obj,id1,id2)
{
    jQuery('#'+id1+' option:gt(0)').remove();
    jQuery('#'+id2+' option:gt(0)').remove();
    if(obj.value!='')
    {
      jQuery.ajax({
        url: '../../../../../getRegion.php',
        type: "POST",
        data: {regionfr : escape(obj.value), process:'get-regionfrom'},
        dataType: "json",
                success: function(data) {
                        if(jQuery.trim(data)!='')
                        {
                               for(i=0;i<data.length;i++)
                               {
                                jQuery('#'+id1).append(new Option(data[i], data[i], false, false));
                               }
                               jQuery('#'+id1).append(new Option('Other','select_or_other', false, false));
                        }
                }
        });
    }
    return false;
}
function regionTo(obj,id1,id2)
{   
    jQuery('#'+id2+' option:gt(0)').remove();
    var id1val=jQuery('#'+id1).val();
    if(obj.value!='')
    {
      jQuery.ajax({
        url: '../../../../../getRegion.php',
        type: "POST",
        //data: {regionfr : escape(id1val), regionto : escape(obj.value), process:'get-regionto'},
        data: {regionfr : id1val, regionto : obj.value, process:'get-regionto'},
        dataType: "json",
                success: function(data) {
                        if(jQuery.trim(data)!='')
                        {
                               for(i=0;i<data.length;i++)
                               {
                                jQuery('#'+id2).append(new Option(data[i], data[i], false, false));
                               }
                               jQuery('#'+id2).append(new Option('Other','select_or_other', false, false));                            
                        }
                }
        });
    }
    return false;
}

function regionFromHome(obj,id1,id2)
{
    jQuery('#'+id1+' option:gt(0)').remove();
    jQuery('#'+id2+' option:gt(0)').remove();
    if(obj.value!='')
    {
      jQuery.ajax({
       
        url: '../../../../../getRegion.php',
        type: "POST",
       // async: false,
        data: {regionfr : escape(obj.value), process:'get-regionfrom'},
        dataType: "json",
        async:false,
                success: function(data) {
                        if(jQuery.trim(data)!='')
                        {
                               for(i=0;i<data.length;i++)
                               {
                                jQuery('#'+id1).append(new Option(data[i], data[i], false, false));
                               }
                        }                      
                }
                
        });
       
          jQuery("#block-block-6 .sbHolder").click(function(){       
            var curValue =  jQuery(".sbSelector",jQuery(this)).html();
            jQuery(".sbOptions li a:contains("+curValue+")",jQuery(this)).addClass("sbFocus"); 
          });

    }
 
}
function regionToHome(obj,id1,id2)
{   
    jQuery('#'+id2+' option:gt(0)').remove();
    
    var id1val=jQuery('#'+id1).val();
    var region = jQuery("#region").val();
    if(obj.value!='')
    {
      jQuery.ajax({
        async: false, 
        url: '../../../../../getRegion.php',
        type: "POST",
        async: false,
        //data: {regionfr : escape(id1val), region : escape(region), process:'get-homeregionto'},
        data: {regionfr : id1val, region : region, process:'get-homeregionto'},
        dataType: "json",
                success: function(data) {
                        if(jQuery.trim(data)!='')
                        {
                               for(i=0;i<data.length;i++)
                               {
                                jQuery('#'+id2).append(new Option(data[i], data[i], false, false));
                               }
                        }
                       jQuery("#reg_to").selectbox(  { speed: 50  });
                       jQuery(".to").selectbox("detach");
                       jQuery(".to").selectbox("attach");
                }
              
        });
         jQuery("#block-block-6 .sbHolder").click(function(){       
            var curValue =  jQuery(".sbSelector",jQuery(this)).html();
            jQuery(".sbOptions li a:contains("+curValue+")",jQuery(this)).addClass("sbFocus"); 
          });
 
    }
    return true;
}


jQuery(document).ready(function() {
    
 jQuery(".page-mycart #cartCont .ctools-use-modal").click(function() {   
    jQuery.ajax({
      url: '../../../../../cart.php',
      type: "POST",
      data: { process:'sessioncart'},
      dataType: "json",
              success: function(data) { 
              }
      });
 }); 
    
    

 jQuery(".compInfo").click(function() {    
  window.scrollTo(0,0);
 });

 
if(jQuery('.front #transger-section'))
{
    jQuery(".front #transger-section").each(function(index) {
      var id1val='';
      id1val=jQuery('#edit-field-transfer-price-und-'+index+'-field-region-und-select').val();
       if(id1val!='')
       {
        var region_fromval=jQuery('#reg_from').val();
        var region_toval=jQuery('#reg_to').val();
        jQuery('#reg_from option:gt(0)').remove();
        jQuery('#reg_to option:gt(0)').remove();
        jQuery.ajax({
        url: '../../../../../getRegion.php',
        type: "POST",
        data: {regionfr : id1val, process:'get-regionfrom'},
        dataType: "json",
                success: function(data) {                   
                        if(jQuery.trim(data)!='')
                        {
                               for(i=0;i<data.length;i++)
                               {
                                if(region_fromval==data[i])
                                jQuery('#reg_from').append(new Option(data[i], data[i], true, true));
                                else
                                jQuery('#reg_from').append(new Option(data[i], data[i], false, false));
                               }
                              
                        }
                }
        });       
       if(region_fromval!='')
       {
        jQuery.ajax({
        url: '../../../../../getRegion.php',
        type: "POST",
         data: {regionfr : id1val, regionto : region_fromval, process:'get-regionto'},
        dataType: "json",
                success: function(data) {                   
                        if(jQuery.trim(data)!='')
                        {
                               for(i=0;i<data.length;i++)
                               {
                                if(region_toval==data[i])
                                jQuery('#reg_to').append(new Option(data[i], data[i], true, true));
                                else
                                jQuery('#reg_to').append(new Option(data[i], data[i], false, false));
                               }
                        }
                }
        });
       }        
       }
       else{       
        jQuery('#reg_from option:gt(0)').remove();
        jQuery('#reg_to option:gt(0)').remove();
       }
     
    });

}



if(jQuery('.page-field-collection-field-transfer-price-edit #service-as-transfer-node-form #edit-field-region'))
{
    jQuery(".page-field-collection-field-transfer-price-edit #service-as-transfer-node-form").each(function(index) {
      var id1val='';
      id1val=jQuery('#edit-field-region-und-select').val();
       if(id1val!='')
       {
        var region_fromval=jQuery('#edit-field-region-from-und-select').val();
        var region_toval=jQuery('#edit-field-region-to-und-select').val();
        jQuery('#edit-field-region-from-und-select option:gt(0)').remove();
        jQuery('#edit-field-region-to-und-select option:gt(0)').remove();
        jQuery.ajax({
        url: '../../../../../getRegion.php',
        type: "POST",
        data: {regionfr : id1val, process:'get-regionfrom'},
        dataType: "json",
                success: function(data) {                   
                        if(jQuery.trim(data)!='')
                        {
                               for(i=0;i<data.length;i++)
                               {
                                if(region_fromval==data[i])
                                jQuery('#edit-field-region-from-und-select').append(new Option(data[i], data[i], true, true));
                                else
                                jQuery('#edit-field-region-from-und-select').append(new Option(data[i], data[i], false, false));
                               }
                               jQuery('#edit-field-region-from-und-select').append(new Option('Other','select_or_other', false, false));                            
                        }
                }
        });       
       if(region_fromval!='')
       {
        jQuery.ajax({
        url: '../../../../../getRegion.php',
        type: "POST",
         data: {regionfr : id1val, regionto : region_fromval, process:'get-regionto'},
        dataType: "json",
                success: function(data) {                   
                        if(jQuery.trim(data)!='')
                        {
                               for(i=0;i<data.length;i++)
                               {
                                if(region_toval==data[i])
                                jQuery('#edit-field-region-to-und-select').append(new Option(data[i], data[i], true, true));
                                else
                                jQuery('#edit-field-region-to-und-select').append(new Option(data[i], data[i], false, false));
                               }
                               jQuery('#edit-field-region-to-und-select').append(new Option('Other','select_or_other', false, false));                            
                        }
                }
        });
       }        
       }
       else{       
        jQuery('#edit-field-region-from-und-select option:gt(0)').remove();
        jQuery('#edit-field-region-to-und-select option:gt(0)').remove();
       }
     
    });
}
    
if(jQuery('.page-field-collection-field-transfer-price-add #service-as-transfer-node-form #edit-field-region'))
{   
    jQuery(".page-field-collection-field-transfer-price-add #service-as-transfer-node-form").each(function(index) {
      var id1val='';
      id1val=jQuery('#edit-field-region-und-select').val();
       if(id1val!='')
       {
        var region_fromval=jQuery('#edit-field-region-from-und-select').val();
        var region_toval=jQuery('#edit-field-region-to-und-select').val();
        jQuery('#edit-field-region-from-und-select option:gt(0)').remove();
        jQuery('#edit-field-region-to-und-select option:gt(0)').remove();
        jQuery.ajax({
        url: '../../../../../getRegion.php',
        type: "POST",
        data: {regionfr : id1val, process:'get-regionfrom'},
        dataType: "json",
                success: function(data) {                   
                        if(jQuery.trim(data)!='')
                        {
                               for(i=0;i<data.length;i++)
                               {
                                if(region_fromval==data[i])
                                jQuery('#edit-field-region-from-und-select').append(new Option(data[i], data[i], true, true));
                                else
                                jQuery('#edit-field-region-from-und-select').append(new Option(data[i], data[i], false, false));
                               }
                               jQuery('#edit-field-region-from-und-select').append(new Option('Other','select_or_other', false, false));                            
                        }
                }
        });       
       if(region_fromval!='')
       {
        jQuery.ajax({
        url: '../../../../../getRegion.php',
        type: "POST",
         data: {regionfr : id1val, regionto : region_fromval, process:'get-regionto'},
        dataType: "json",
                success: function(data) {                   
                        if(jQuery.trim(data)!='')
                        {
                               for(i=0;i<data.length;i++)
                               {
                                if(region_toval==data[i])
                                jQuery('#edit-field-region-to-und-select').append(new Option(data[i], data[i], true, true));
                                else
                                jQuery('#edit-field-region-to-und-select').append(new Option(data[i], data[i], false, false));
                               }
                               jQuery('#edit-field-region-to-und-select').append(new Option('Other','select_or_other', false, false));                            
                        }
                }
        });
       }        
       }
       else{       
        jQuery('#edit-field-region-from-und-select option:gt(0)').remove();
        jQuery('#edit-field-region-to-und-select option:gt(0)').remove();
       }
     
    });
}
    
 
    
if(jQuery('.node-type-service-as-transfer #service-as-transfer-node-form #field-transfer-price-values'))
{
    jQuery(".node-type-service-as-transfer #service-as-transfer-node-form #field-transfer-price-values .draggable").each(function(index) {
      var id1val='';
      id1val=jQuery('#edit-field-transfer-price-und-'+index+'-field-region-und-select').val();
       if(id1val!='')
       {
        var region_fromval=jQuery('#edit-field-transfer-price-und-'+index+'-field-region-from-und-select').val();
        var region_toval=jQuery('#edit-field-transfer-price-und-'+index+'-field-region-to-und-select').val();
        jQuery('#edit-field-transfer-price-und-'+index+'-field-region-from-und-select option:gt(0)').remove();
        jQuery('#edit-field-transfer-price-und-'+index+'-field-region-to-und-select option:gt(0)').remove();
        jQuery.ajax({
        url: '../../../../../getRegion.php',
        type: "POST",
        data: {regionfr : id1val, process:'get-regionfrom'},
        dataType: "json",
                success: function(data) {                   
                        if(jQuery.trim(data)!='')
                        {
                               for(i=0;i<data.length;i++)
                               {
                                if(region_fromval==data[i])
                                jQuery('#edit-field-transfer-price-und-'+index+'-field-region-from-und-select').append(new Option(data[i], data[i], true, true));
                                else
                                jQuery('#edit-field-transfer-price-und-'+index+'-field-region-from-und-select').append(new Option(data[i], data[i], false, false));
                               }
                               jQuery('#edit-field-transfer-price-und-'+index+'-field-region-from-und-select').append(new Option('Other','select_or_other', false, false));                            
                        }
                }
        });       
       if(region_fromval!='')
       {
        jQuery.ajax({
        url: '../../../../../getRegion.php',
        type: "POST",
         data: {regionfr : id1val, regionto : region_fromval, process:'get-regionto'},
         dataType: "json",
                success: function(data) {                   
                        if(jQuery.trim(data)!='')
                        {
                               for(i=0;i<data.length;i++)
                               {
                                if(region_toval==data[i])
                                jQuery('#edit-field-transfer-price-und-'+index+'-field-region-to-und-select').append(new Option(data[i], data[i], true, true));
                                else
                                jQuery('#edit-field-transfer-price-und-'+index+'-field-region-to-und-select').append(new Option(data[i], data[i], false, false));
                               }
                               jQuery('#edit-field-transfer-price-und-'+index+'-field-region-to-und-select').append(new Option('Other','select_or_other', false, false));                            
                        }
                }
        });
       }        
       }
       else{       
        jQuery('#edit-field-transfer-price-und-'+index+'-field-region-from-und-select option:gt(0)').remove();
        jQuery('#edit-field-transfer-price-und-'+index+'-field-region-to-und-select option:gt(0)').remove();
       }
     
    });

}

if(jQuery('.group-context-node #Ogaddpeople'))
{
    var node_hid=jQuery('#node_hid').val();
    jQuery('#Ogaddpeople').attr('href',"/node/"+node_hid+"/group");
}
 });

	

jQuery(document).ready(function(){
    if(jQuery(".front").size()){
        
         jQuery("#block-block-6 .sbHolder").live("click",function(){        
            var curValue =  jQuery(".sbSelector",jQuery(this)).html();          
            curValue = curValue.replace("&amp;","&");
            jQuery(".sbOptions li a:contains("+curValue+")",jQuery(this)).addClass("sbFocus"); 
        });
         jQuery(".ctools-use-modal").live("click",function(){        
            var curValue =  jQuery(".sbSelector",jQuery(this)).html();          
            curValue = curValue.replace("&amp;","&");
            jQuery(".sbOptions li a:contains("+curValue+")",jQuery(this)).addClass("sbFocus"); 
        });
         
       jQuery(".type-service,.to,#ngregion,#ddesg").selectbox({speed: 50});//,#region,,#reg_to,#ddesg;
       
       jQuery(".front #region").selectbox({	
                   onChange: function (val, inst) {                    
                      regionFromHome(this,'reg_from','reg_to');
                      jQuery("#reg_from").selectbox("detach");
                      jQuery("#reg_from").selectbox("attach");
                      if(jQuery(this).val()!=''){
                        jQuery(this).next().css("border","none");
                     }
                     
                   },                 
                   speed: 50  
                   
        }); 
            jQuery(".typeoftransfer").selectbox({	
                   onChange: function (val, inst) {                   
                      if ((jQuery(this).val()!='') && (jQuery(this).val() =="in&out")){
                                 var cont="<span class='req'>*</span> Round trip IN & OUT PRICE will be the combination of In & OUT Prices";
                                jQuery('.Transfer #msgDivtrans').html(cont);
                                jQuery('.Transfer #msgDivtrans').show(500);
                         }else{
                                jQuery('.Transfer #msgDivtrans').hide();
                                jQuery('.Transfer #msgDivtrans').html('');
                        }
                   },
                   speed: 50  
             });
             jQuery(".from").selectbox({	
                   onChange: function (val, inst) {                   
                      regionToHome(this,'reg_from','reg_to');                     
                      jQuery(".to").selectbox("detach");
                      jQuery(".to").selectbox("attach");                    
                   },
                  speed: 50  
             });
             
    }
   

    jQuery("#transger-section").submit(function(){       
       if((jQuery(".type-service").val()) == '') {        
          jQuery(".type-service").next().css("border","1px solid red");
          return false;
        }
        else if((jQuery(".tregion").val()) == '') {            
          jQuery(".tregion").next().css("border","1px solid red");
          return false;
        }        
         else if((jQuery(".typeoftransfer").val()) == '') {
            jQuery(".typeoftransfer").next().css("border","1px solid red");
            return false;
         }
         else if((jQuery(".from").val()) == '') {            
           jQuery(".from").next().css("border","1px solid red");
          return false;
        }
        else if((jQuery(".to").val()) == '') {            
           jQuery(".to").next().css("border","1px solid red");
           return false;
          
        }else {
            return true;
        }       
    });
    
     jQuery("#meet-greet-section").submit(function(){       
       if((jQuery(".type-service").val()) == '') {        
          jQuery(".type-service").next().css("border","1px solid red");
          return false;
        }
        else if((jQuery("#ngregion").val()) == '') {            
          jQuery("#ngregion").next().css("border","1px solid red");
          return false;
        } else {
            return true;
        }       
    });
     
    jQuery(".driverd").submit(function() {        
        if((jQuery(".type-service").val()) == '') {        
          jQuery(".type-service").next().css("border","1px solid red");
          return false;
        }
        if(jQuery(".meetandgreetregion").val() == ''){
            jQuery(".meetandgreetregion").next().css("border","1px solid red");
            return false;
        }
        else if(jQuery("#depart_hr_mt_pickuph").val() == '') {
            jQuery("#depart_hr_mt_pickuph").attr("readonly", false);
             jQuery("#depart_hr_mt_pickuph").css("border","1px solid red");
            return false;
        }
        else if(jQuery("#depart_hr_mt_droph").val() == '') {
             jQuery("#depart_hr_mt_droph").css("border","1px solid red");
            return false;
        }else if(jQuery(".ddesg").val() == '') {
             jQuery(".ddesg").next().css("border","1px solid red");
            return false;
        }else {
            return true;
        }
    });
    
     jQuery(".noofpass").change(function(){
       if(jQuery(this).val()!=''){
        jQuery(".epass").html('');
       }
     });
     
    jQuery(".departmins").change(function(){
       if(jQuery(this).val()!=''){
        jQuery(this).css("border","none");
       }
     });
    
    jQuery(".departhours").change(function(){
       if(jQuery(this).val()!=''){
        jQuery(this).css("border","none");
       }
     });
    jQuery(".arr-day-night").change(function(){
       if(jQuery(this).val()!=''){
        jQuery(this).css("border","none");
       }
     });
    
    jQuery(".arrparthours").change(function(){
       if(jQuery(this).val()!=''){
        jQuery(this).css("border","none");
       }
     });
    jQuery(".arrmins").change(function(){
       if(jQuery(this).val()!=''){
        jQuery(this).css("border","none");
       }
     });
    
    jQuery(".drop-day-night").change(function(){
       if(jQuery(this).val()!=''){
        jQuery(this).css("border","none");
       }
     });
    
    jQuery(".ddesg").change(function(){
       if(jQuery(this).val()!=''){
        jQuery(this).next().css("border","none");
       }
     });
    
     jQuery(".meetandgreetregion").change(function(){
       if(jQuery(this).val()!=''){
        jQuery(this).next().css("border","none");
       }
     });
    jQuery(".tregion").change(function(){
       // alert('sdf');
       if(jQuery(this).val()!=''){
        jQuery(this).next().css("border","none");
       }
     });
      jQuery(".typeoftransfer").change(function(){
       if(jQuery(this).val()!=''){
        jQuery(this).next().css("border","none");
       }
    });
      
    jQuery(".from").change(function(){
       if(jQuery(this).val()!=''){
        jQuery(this).next().css("border","none");
       }
    });
    jQuery(".to").change(function(){
       if(jQuery(this).val()!=''){
        jQuery(this).next().css("border","none");
       }
    });
      jQuery("#ngregion").change(function(){
       if(jQuery(this).val()!=''){
        jQuery(this).next().css("border","none");
       }
    });
    
     // Search form toggle   
     jQuery(".type-service").change(function(){        
       if(jQuery(this).val()!=''){
        jQuery(this).next().css("border","none");
        }
        if(jQuery(this).val() == 'Transfer'){        
        jQuery("#block-block-6 #transger-section").css("display","block");
        jQuery("#block-block-6 #meet-greet-section").css("display","none");
        jQuery("#block-block-6 #driveratd").css("display","none");       
        }        
        if(jQuery(this).val() == 'Meet & Greet'){        
        jQuery("#block-block-6 #transger-section").css("display","none");
        jQuery("#block-block-6 #meet-greet-section").css("display","block");
        jQuery("#block-block-6 #driveratd").css("display","none");
        }
        if(jQuery(this).val() == 'Driver at disposal'){        
        jQuery("#block-block-6 #transger-section").css("display","none");
        jQuery("#block-block-6 #meet-greet-section").css("display","none");
        jQuery("#block-block-6 #driveratd").css("display","block");
        }
       
    });
   
    jQuery(".meetandgreetregion").change(function() {
        if(jQuery(".meetandgreetregion").val()) {            
            var region = jQuery(".meetandgreetregion").val();            
                jQuery.ajax({
                url: '../../../../../getRegion.php',
                type: "POST",
                data: {region : region, process:'get-regiondriveratdisposal'},
                dataType: "json",
                beforeSend: function() {
                jQuery('#loader').show();  },
                complete: function(){
                jQuery('#loader').hide(); },
                success: function(data) {                    
                        if(jQuery.trim(data)!='')
                        {
                               jQuery(".ddesg option").remove();
                               jQuery(".ddesg").append(new Option('Select destination',"", true, true));
                               for(i=0;i<data.length;i++)
                               {                                      
                                    jQuery('.ddesg').append(new Option(data[i], data[i], true, true));
                               }
                               jQuery(".ddesg option:first").attr('selected', true);                               
                        }                     
                       jQuery(".ddesg").selectbox("detach");                       
                      jQuery(".ddesg").selectbox("attach");
                      
                }
                
        });
          

                 
        }
      
    });
    
     /*  jQuery(".departhours,.ddesg,.departmins").change(function() {
                if(jQuery(".ddesg").val()!='') {
                      var depart = jQuery(".departhours").val();
                      var jduration = jQuery(".ddesg").val();
                      var departmin = jQuery(".departmins").val();                     
                      jQuery.ajax({
                      url: '../../../../../getRegion.php',
                      type: "POST",
                      data: { dtime : depart, dur:jduration , durmin : departmin, process:'get-arrivaltime'},                      
                      dataType: "json",    
                      success: function(data) {                    
                              if(jQuery.trim(data)!='')
                              {
                                    
                                          var arritime= data.split('||'); 
                                           jQuery('.arrparthours option[value='+arritime[0]+']').attr('selected', true);
                                           jQuery('.arrparthours').attr("disabled",true);
                                           if(arritime[1] == 0) {
                                           jQuery('.arrmins option[value="00"]').attr('selected', true);
                                           }else {
                                           jQuery('.arrmins option[value='+arritime[1]+']').attr('selected', true);
                                           }
                                           jQuery('.arrmins').attr("disabled",true);

                              }
                      }
              });                 
               }
       });*/
       
       
       jQuery(".arrparthours,.arrmins,.drop-day-night,.ddesg,#depart_hr_mt_droph,#depart_hr_mt_pickuph").change(function() {
                if(jQuery(".ddesg").val()!='') {
                      var jduration = jQuery(".ddesg").val();
                      
                      var depart = '';
                      var departmin = '';
                      var arrpart = '';
                      var arrmins = '';
                      var drop_day_night = '';
                      var arr_day_night = '';
                      
                    var pickuph=jQuery("#depart_hr_mt_pickuph").val();
                    var droph=jQuery("#depart_hr_mt_droph").val();                   
                    pickuphrfullarr=pickuph.split(' ');
                    drophrfullarr=droph.split(' ');
                    if(pickuphrfullarr[0]!='')
                    {
                        pickuphrarr=pickuphrfullarr[0].split(':');
                        depart=pickuphrarr[0];
                        departmin=pickuphrarr[1];
                        if(depart=='08'){
                        depart=8;
                        }
                        else if(depart=='09'){
                            depart=9;
                        }
                        else
                        {
                            depart=parseInt(depart);
                        } 
                        
                    }                    
                    drop_day_night=pickuphrfullarr[1];
                    
                    if(drophrfullarr[0]!='')
                    {
                        drophrarr=drophrfullarr[0].split(':');
                        arrpart=drophrarr[0];
                        arrmins=drophrarr[1];
                        if(arrpart=='08'){
                        arrpart=8;
                        }
                        else if(arrpart=='09'){
                            arrpart=9;
                        }
                        else
                        {
                            arrpart=parseInt(arrpart);
                        } 
                        
                    }
                    arr_day_night=drophrfullarr[1];
                      
                      
                      jQuery.ajax({
                      url: '../../../../../getRegion.php',
                      type: "POST",
                      data: { dtime : depart, dur:jduration , durmin : departmin, arrpart:arrpart, arrmins:arrmins,
                      drop_day_night:drop_day_night,arr_day_night:arr_day_night,process:'get-arrivaldifftime'},
                      dataType: "json",    
                      success: function(data) {                    
                              if(jQuery.trim(data)!='')
                              {
                             //  alert(data); 
                                var cont="<span class='req'>*</span> Drop hour excess of "+data+" hour over the picked service. This will be charged. ";
                                jQuery('#msgDiv').html(cont);
                                jQuery('#msgDiv').show(500);
                              }else
                              {
                                jQuery('#msgDiv').hide();
                                jQuery('#msgDiv').html('');
                              }
                      }
              });                 
               }
       });
    
    jQuery(".select-or-other-select").change(function() {
        var idcheck = jQuery(this).attr('id');        
        var idDesg = idcheck.replace("-disposal-region","-disp-destination"); 
        if(idcheck.indexOf('field-driver-disposal-region-und-select') > -1) {
                var region = jQuery(this).val()          
                jQuery.ajax({
                url: '../../../../../getRegion.php',
                type: "POST",
                data: {region : region, process:'get-regiondriveratdisposal'},
                dataType: "json",    
                success: function(data) {                    
                        if(jQuery.trim(data)!='')
                        {
                               jQuery("#"+idDesg+" option").remove();
                               jQuery("#"+idDesg).append(new Option('Select destination'," ", true, true));
                               for(i=0;i<data.length;i++)
                               {                                      
                                    jQuery("#"+idDesg).append(new Option(data[i], data[i], true, true));
                               }
                              jQuery("#"+idDesg+" option:first").attr('selected', true);                               

                        }
                        if(jQuery.trim(data) == ''){
                               jQuery("#"+idDesg+" option").remove();
                               jQuery("#"+idDesg).append(new Option('Select destination'," ", true, true));                               
                              jQuery("#"+idDesg+" option:first").attr('selected', true);                   
                            
                        }
                }
        });                 
        }
    });


    jQuery(document).ajaxStart(function(){
        jQuery('#loader').show();
        jQuery('#initialContainerMask').show();
    });
    
    jQuery(document).ajaxStop(function(){
        jQuery('#loader').hide();
        jQuery('#initialContainerMask').hide();
    });
    
    jQuery('.onlyNum').keydown(function(event) {
    // Allow: backspace, delete, tab, escape, and enter
    if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
         // Allow: Ctrl+A
        (event.keyCode == 65 && event.ctrlKey === true) || 
         // Allow: home, end, left, right
        (event.keyCode >= 35 && event.keyCode <= 39)) {
             // let it happen, don't do anything
             return;
    }
    else {
        // Ensure that it is a number and stop the keypress
        if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
            event.preventDefault(); 
            return false;
        } 
    }
    
});

jQuery('.page-payment-complete .invoiceTab').click(function() {
    jQuery('.invoiceTab').removeClass('act').removeClass('disact');
    jQuery('.invoiceTab').addClass('disact');
    jQuery(this).addClass('act').removeClass('disact');
    jQuery('.invoiceContent').hide();
    var divId=jQuery(this).attr('id');
    jQuery('#cont_'+divId).show();

}); 
jQuery('.page-payment .invoiceTab').click(function() {   
    jQuery('.cartErrMsg').fadeIn();
    setTimeout(function(){jQuery('.cartErrMsg').fadeOut()},4000);
}); 

if(jQuery(".page-payment-complete #paybox #payCont"))
{
    try{
    jQuery("#payCont > div").scrollable({interval: 2000}).autoscroll(); 
    jQuery('a.print-preview').printPreview(); 
    }catch(e){}
}
           


});

function addService()
{
    //var qs = window.GetQueryString(query);
    var loc=window.location;
     jQuery.confirm({
                'title'		: 'How to get Private-Transfer Service(s)?',
                'message'	: 'Click here to <a href="user?destination='+loc+'">Sign in</a> or<br/><br/><a href="client-registration?destination='+loc+'">Register as client</a><br/><br/><a href="create-travel-agent?destination='+loc+'">Register as Travel Agent</a><br/><br/><a href="create-travel-agency">Register as Travel Agency</a>',
                'buttons'	: {				
                        'OK'	: {
                        'class'	: 'gray',
                        'action': function(){}	// Nothing to do in this case. You can as well omit the action property.
                        }
                }
        });
}

function downloadReprt()
{
    var loc=window.location;
     jQuery.confirm({
                'title'		: 'Reports format?',
                'message'	: '<input type="radio" name="preferred_report" id="downrep1" value="normal" /> <span class="radioLabel">Download summary report</span><br /><input type="radio" name="preferred_report" value="detail" id="downrep2"/> <span class="radioLabel">Download memberwise detail report</span><br />',
                'buttons'	: {				
                        'OK'	: {
                        'class'	: 'gray downBtn',
                        'action': function(){
                            if (jQuery("#downrep1").is(":checked")) {
                               generatePdf('network');
                            }
                            if (jQuery("#downrep2").is(":checked")) {
                                generatePdfDetail('network');
                            }
                            }	// Nothing to do in this case. You can as well omit the action property.
                        },
                        'CANCEL':{ 
                         'class': 'gray',
                         'action':   function () {
                            jQuery(this).remove();
                            }
                        }
                }
        });
}



function netwokothers(obj)
{
    jQuery('#network_name_others').val('');
    if(obj.value=='00')
    jQuery('#network_name_others_td').show()
    else
    jQuery('#network_name_others_td').hide()
}

function addHeadQuarMembers(gid,memid)
{
    
    jQuery.ajax({
        url: '../../../../../ogmemberOperation.php',
        type: "POST",
        data: {gid : gid, memid : memid, process:'add-member'},
        dataType: "json",
                success: function(data) {                   
                        if(jQuery.trim(data)!='')
                        {
                            jQuery('#mem_'+memid).html('<a class="btnLink" onclick="removeHeadQuarMembers(\''+gid+'\',\''+memid+'\');" href="javascript:void(0);"><div class="btn">REMOVE</div></a>');
                            jQuery('.commMsg').html(data).fadeIn();
                            setTimeout(function(){jQuery('.commMsg').fadeOut()},4000);  
                        }
                }
        }); 
    
}


function removeHeadQuarMembers(gid,memid)
{
    
    jQuery.ajax({
        url: '../../../../../ogmemberOperation.php',
        type: "POST",
        data: {gid : gid, memid : memid, process:'remove-member'},
        dataType: "json",
                success: function(data) {                   
                        if(jQuery.trim(data)!='')
                        {
                            jQuery('#mem_'+memid).html('<a class="btnLink" onclick="addHeadQuarMembers(\''+gid+'\',\''+memid+'\');" href="javascript:void(0);"><div class="btn">ADD</div></a>');
                            jQuery('.commMsg').html(data).fadeIn();
                            setTimeout(function(){jQuery('.commMsg').fadeOut()},4000);  
                        }
                }
        }); 
    
}

function addAgentMembers(gid,memid)
{
    
    jQuery.ajax({
        url: '../../../../../ogmemberOperation.php',
        type: "POST",
        data: {gid : gid, memid : memid, process:'add-agent-member'},
        dataType: "json",
                success: function(data) {                   
                        if(jQuery.trim(data)!='')
                        {
                            jQuery('#mem_'+memid).html('<a class="btnLink" onclick="removeAgentMembers(\''+gid+'\',\''+memid+'\');" href="javascript:void(0);"><div class="btn">REMOVE</div></a>');
                            jQuery('.commMsg').html(data).fadeIn();
                            setTimeout(function(){jQuery('.commMsg').fadeOut()},4000);  
                        }
                }
        }); 
    
}

function removeAgentMembers(gid,memid)
{
    
    jQuery.ajax({
        url: '../../../../../ogmemberOperation.php',
        type: "POST",
        data: {gid : gid, memid : memid, process:'remove-agent-member'},
        dataType: "json",
                success: function(data) {                   
                        if(jQuery.trim(data)!='')
                        {
                            jQuery('#mem_'+memid).html('<a class="btnLink" onclick="addAgentMembers(\''+gid+'\',\''+memid+'\');" href="javascript:void(0);"><div class="btn">ADD</div></a>');
                            jQuery('.commMsg').html(data).fadeIn();
                            setTimeout(function(){jQuery('.commMsg').fadeOut()},4000);  
                        }
                }
        }); 
    
}
function removeClient(gid,memid)
{
    
    jQuery.ajax({
        url: '../../../../../ogmemberOperation.php',
        type: "POST",
        data: {gid : gid, memid : memid, process:'remove-client'},
        dataType: "json",
                success: function(data) {                   
                        if(jQuery.trim(data)!='')
                        {
                            window.location.reload();                           
                        }
                }
        }); 
    
}
