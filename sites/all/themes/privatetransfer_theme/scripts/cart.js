/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var addmoreoutArray=new Array();
var addmoreArray=new Array();
function addtoCart(cart_id,price,typeTransfer)
{
    if(cart_id!='')
    {
        
        var selectregion='';
        if(jQuery('#selectregion'))
        selectregion=jQuery('#selectregion').val();
        
        var from='';
        if(jQuery('#from'))
        from=jQuery('#from').val();
        
        var to='';
        if(jQuery('#to'))
        to=jQuery('#to').val();
    
        var region='';
        if(jQuery('#region'))
        region=jQuery('#region').val();
    
        var servtitle='';
        if(jQuery('#servtitle_'+cart_id))
        servtitle=jQuery('#servtitle_'+cart_id).val();
    
        var delta='';
        if(jQuery('#delta_'+cart_id))
        delta=jQuery('#delta_'+cart_id).val();
    
        var max_people='';
        if(jQuery('#max_people_'+cart_id))
        max_people=jQuery('#max_people_'+cart_id).val();
        
        var max_lugg='';
        if(jQuery('#max_lugg_'+cart_id))
        max_lugg=jQuery('#max_lugg_'+cart_id).val();
    
        var cust_price='';
        if(jQuery('#cust_price_'+cart_id))
        cust_price=jQuery('#cust_price_'+cart_id).val();
    
        var agt_comm='';
        if(jQuery('#agt_comm_'+cart_id))
        agt_comm=jQuery('#agt_comm_'+cart_id).val();
    
        var custday_price='';
        if(jQuery('#custday_price_'+cart_id))
        custday_price=jQuery('#custday_price_'+cart_id).val();
    
        var custend_price='';
        if(jQuery('#custend_price_'+cart_id))
        custend_price=jQuery('#custend_price_'+cart_id).val();

        var dtimehours='';
        if(jQuery('#dtimehours'))
        dtimehours=jQuery('#dtimehours').val();
        
        var dtimemins='';
        if(jQuery('#dtimemins'))
        dtimemins=jQuery('#dtimemins').val();
        
        var day_night_dep='';
        if(jQuery('#day-night-dep'))
        day_night_dep=jQuery('#day-night-dep').val();
    
        var arrtimehours='';
        if(jQuery('#arrtimehours'))
        arrtimehours=jQuery('#arrtimehours').val();
    
        var arrtimemins='';
        if(jQuery('#arrtimemins'))
        arrtimemins=jQuery('#arrtimemins').val();
    
        var day_night_arr='';
        if(jQuery('#day-night-arr'))
        day_night_arr=jQuery('#day-night-arr').val();
    
        var desgination='';
        if(jQuery('#desgination'))
        desgination=jQuery('#desgination').val();
    
        var driv_name='';
        if(jQuery('#driv_name'))
        driv_name=jQuery('#driv_name').val();
    
        var driv_num='';
        if(jQuery('#driv_num'))
        driv_num=jQuery('#driv_num').val();
    
        var night_rate_comm='';
        if(jQuery('#night_rate_comm'))
        night_rate_comm=jQuery('#night_rate_comm').val();
       

        jQuery.ajax({
        url: '../../../../../cart.php',
        type: "POST",
        data: {cart_id : cart_id, price : price,typeTrans:typeTransfer, 
               process:'addtocart',servtitle:servtitle,selectregion:selectregion,from:from,
               to:to,region:region,max_people:max_people,max_lugg:max_lugg,agt_comm:agt_comm,
               cust_price:cust_price,custday_price:custday_price,custend_price:custend_price,
               dtimehours:dtimehours,dtimemins:dtimemins,day_night_dep:day_night_dep,
               arrtimehours:arrtimehours,arrtimemins:arrtimemins,day_night_arr:day_night_arr,
               desgination:desgination,driv_name:driv_name,driv_num:driv_num,
               night_rate_comm:night_rate_comm,delta:delta },
        dataType: "json",
                success: function(data) {
                        if(jQuery.trim(data)!='')
                        {   
                        jQuery('#cart_'+cart_id).html('<div class="remove">REMOVE FROM CART</div>').attr('onClick','removefromCart("'+cart_id+'","'+price+'","'+typeTransfer+'")');                       
                        var currentCount = parseInt(jQuery("#cartcount").text());
                        var newValue = parseInt(currentCount) + 1;                        
                         if(newValue == 1) {
                          jQuery('.page-cartinfo-start').css('visibility','visible');
                          jQuery("#cartcount").html(newValue);
                         } else {
                         // jQuery('.page-cartinfo-start').css('visibility','hidden');
                          jQuery("#cartcount").html(newValue);
                        }
                        }
                }
        });
    }
}

function removefromCart(cart_id,price,typeTransfer)
{
    if(cart_id!='')
    {
        jQuery.ajax({
        url: '../../../../../cart.php',
        type: "POST",
        data: {cart_id : cart_id,typeTrans:typeTransfer, process:'removefromcart'},
        dataType: "json",
            success: function(data) {
                    if(jQuery.trim(data)!='')
                    {   
                         jQuery('#cart_'+cart_id).html('<div class="add">ADD TO CART</div>').attr('onClick','addtoCart("'+cart_id+'","'+price+'","'+typeTransfer+'")');
                         var currentCount = parseInt(jQuery("#cartcount").html());
                        var currentCount = parseInt(jQuery("#cartcount").text());
                        var newValue = parseInt(currentCount) - 1;
                       // alert(newValue);
                       // if(newValue == 0) {
                      //  jQuery('.page-cartinfo').css('visibility','hidden');
                       // } else {
                         jQuery("#cartcount").html(newValue);
                       // }
                       
                    }
            }
        });
    }
}

function removefromCartCheckout(cart_id,price,typeTransfer)
{
    if(cart_id!='')
    {
        jQuery.ajax({
        url: '../../../../../cart.php',
        type: "POST",
        data: {cart_id : cart_id,typeTrans:typeTransfer, process:'removefromcart'},
        dataType: "json",
            success: function(data) {
                    if(jQuery.trim(data)!='')
                    {   
                         var compId=typeTransfer.replace(/&/g,"_");
                         jQuery('#cart_'+cart_id+compId).remove();
                         
                         var tot_price=parseInt(jQuery('#tot_price').html());
                         tot_price=tot_price-parseInt(price);
                         jQuery('#tot_price').html(tot_price);
                         jQuery('.commMsg').html('Removed from cart successfully.').fadeIn();
                         setTimeout(function(){jQuery('.commMsg').fadeOut()},4000);  
                    }
            }
        });
    }
}

function removefromCartPayment(cart_id,typeTransfer)
{
    var r=confirm("Are you sure you wish to remove this service(s)?");
    if (r==true)
    {
      if(cart_id!='')
      {
        jQuery.ajax({
        url: '../../../../../cart.php',
        type: "POST",
        data: {cart_id : cart_id,typeTrans:typeTransfer, process:'removefromcart'},
        dataType: "json",
            success: function(data) {
                    if(jQuery.trim(data)!='')
                    {   
                         document.location.reload(true);
                    }
            }
        });
      }
    }

     
 
}


function removeallCart()
{
    jQuery.ajax({
    url: '../../../../../cart.php',
    type: "POST",
    data: {process:'removeall'},
    dataType: "json",
        success: function(data) {
            if(jQuery.trim(data)!='')
            {   
                for(i=0;i<data.length;i++)
                {
                    if(jQuery('#cart_'+data[i]))
                     {
                        jQuery('#cart_'+data[i]).html('ADD TO CART').attr('onClick','addtoCart("'+cart_id+'")');
                     }
                }
                // 
            }
        }
    });
}

function updateQtyCheckout(obj, field, cart_id,typeTransfer)
{
    if(obj.value!='')
    {
        if(obj.value=='0')
        {
            alert("Please enter the valid quatity.");
            
        }
        else
        {
            jQuery.ajax({
            url: '../../../../../cart.php',
            type: "POST",
            data: {cart_id : cart_id, field : field, fieldVal : obj.value,typeTrans:typeTransfer, process:'setCheckoutProductValue'},
            dataType: "json",
                success: function(data) {
                    if(jQuery.trim(data)!='')
                    {   
                        jQuery('.onlyNum').removeClass('compDivHlt');
                        var datarr=data.split(',');
                        if(datarr[0] && datarr[0]=='failed')
                        {
                            if(jQuery('#qty_'+cart_id))
                            {
                               jQuery('#qty_'+cart_id).addClass('compDivHlt');
                            }
                            if(datarr[1] && datarr[1]!='')
                            {
                            jQuery('.cartErrMsg').html('Number of people more than '+datarr[1]+'. Quantity must be more than 2.').fadeIn();
                            setTimeout(function(){jQuery('.cartErrMsg').fadeOut()},4000);
                            }
                            return false;
                        }
                        else
                        {
                            document.location.reload(true);
                        }
                    }
                }
            });
        }
          
    }
}

jQuery(document).ready(function() {
      jQuery(".compInfo").live("click",function(){        
            var curValue =  jQuery(".sbSelector",jQuery(this)).html();          
            curValue = curValue.replace("&amp;","&");
            jQuery(".sbOptions li a:contains("+curValue+")",jQuery(this)).addClass("sbFocus"); 
        });
try{    
    jQuery('.departhours').timepicker({
       hourGrid: 4,
       minuteGrid: 10,
       timeFormat: 'hh:mm TT'
   });

   jQuery('#depart_hrimg').click(function() {
   jQuery('#depart_hr_mt_pickuph').trigger('focus');
   });

   jQuery('#departdrop_hrimg').click(function() {
   jQuery('#depart_hr_mt_droph').trigger('focus');
   });
}catch(e){}
/*
    if(jQuery('.breadcrumb .active').html()=='Welcome')
    {   
        jQuery('.page-node .breadcrumb').append('<div class="fRight"><a class="compInfo" onclick="document.location.href=\'mycart\'" href="javascript:void(0);"><div class="remove">VIEW CART</div></a></div>');
    } 
  */
 });


function complete_info(id,typeTransfer)
{
    document.location.href='travelinformation/'+id+'/'+encodeURIComponent(typeTransfer);
    //document.location.href='travelinformation?nid='+id+'&typetrans='+encodeURIComponent(typeTransfer);
}

parseField = function( jQueryobject ){
  result = new Array();
  jQueryobject.find('select, input, textarea').each(function(){
    var obj = {};
    obj.key = jQuery(this).attr('name');
    if(obj.val!=''){obj.val = encodeURIComponent(jQuery(this).val());}
    else{obj.val=jQuery(this).val();}
    result.push( obj );
  });
  return result;
}


function save_details(section)
{
    
    var serv_type=jQuery('#serv_type').val();
    var cart_id=jQuery('#nid').val();
    var typetrans=jQuery('#typetrans').val();
   // var genParam = 'section='+section+'&serv_type='+jQuery('#serv_type').val();
    //genParam+='&cart_id='+jQuery('#nid').val();   
    //url: '../../../../../getRegion.php?process=sessioncart&'+genParam+'&'+querystring,
    
    var querystring ='';
    var values = parseField( jQuery('#step_'+section) );
    jQuery.each(values, function(i,obj){
        if(querystring!=''){ querystring+='&';}
        querystring+=obj.key+'='+obj.val;
    });

    
    //var querystring = jQuery('#step_'+section).serialize();
     //alert(querystring1);
    //alert(querystring);
    var extrParam='';
     if(section>0)
    {
       var appTxt='';
       if(jQuery('#addmoreDiv').attr("totalfieldsadded"))
       {
        appTxt='';
       }
       else if(jQuery('#addmoreoutDiv').attr("totalfieldsadded"))
       {
           appTxt='out';
       }
       extrParam+='&totalfieldsadded='+jQuery('#addmore'+appTxt+'Div').attr("totalfieldsadded");
       extrParam+='&fieldcount='+jQuery('#addmore'+appTxt+'Div').attr("fieldcount");        
    }
    querystring +=extrParam;
    jQuery.ajax({
        url: '../../../../../cart.php?'+querystring,
        type: "POST",
         data: {process:'sessioncart',cart_id:cart_id, typetrans:typetrans,section:section, serv_type:serv_type },
         dataType: "json",
                success: function(data) {                   
                       //alert('ssss');
                }
        });
}
function cartComplete()
{
    if(jQuery('#cartCont').html()!='')
    {
        jQuery.ajax({
        url: '../../../../../cart.php',
        type: "POST",
        data: {process:'chktripcompletion'},
        dataType: "json",
            success: function(data) {
                if(jQuery.trim(data)!='')
                {   
                    jQuery('.compDiv').removeClass('compDivHlt'); 
                    if(data.length==0)
                    {
                         document.location.href='payment';   
                    }
                    for(i=0;i<data.length;i++)
                    {
                       var compId=data[i].replace(/&/g,"_");
                        if(jQuery('#comp_'+compId))
                         {
                            jQuery('#comp_'+compId).addClass('compDivHlt');
                         }
                    }
                    jQuery('.cartErrMsg').html('Please fill the highlighted Complete details on that service').fadeIn();
                    setTimeout(function(){jQuery('.cartErrMsg').fadeOut()},4000);
                }
                else
                {
                   document.location.href='payment'; 
                }
            }
        });
    }
    else
    {
        jQuery('.commMsg').html('Your cart is empty now! To add products click "Adding other products"').fadeIn();
        setTimeout(function(){jQuery('.commMsg').fadeOut()},4000);
    }

    
}

function cartPayment()
{
    var client_email='';
    if(jQuery("#client_email").val()!='')
    {
        client_email=jQuery("#client_email").val();
    }
    
    if(jQuery('#commission')) {
        jQuery('#commission').removeClass();
        if(jQuery('#commission').val()=='')
        {  
            jQuery('#commission').addClass('redvalid');
            jQuery('#payReqMsg').html('Please select the commission percentage!').fadeIn();
            setTimeout(function(){jQuery('#payReqMsg').fadeOut()},4000); 
            return false;
        }
    }
    
    if(jQuery('#paybox').is(':checked')) {
    jQuery.ajax({
    url: '../../../../../cart.php',
    type: "POST",
    data: {client_email:client_email, process:'cartPayment'},
    dataType: "json",
        success: function(data) {
            //alert(JSON.stringify(data));
            if(jQuery.trim(data)!='')
            { 
               document.location.href='payment-complete?chkoutId='+data['CHKOUTID'];               
              //document.location.href='appel_hmac.php?PBX_CMD='+data['REFERENCE']+'&PBX_TOTAL='+data['MONTANT']+'&PBX_PORTEUR='+data['PORTEUR'];
            }
            
        }
    });
   }
   else
    {
        jQuery('#payReqMsg').html('Please select the "payment method" to pay now!').fadeIn();
        setTimeout(function(){jQuery('#payReqMsg').fadeOut()},4000);
    }
    
}
function commissionUpdate(obj)
{
    /*var comm=0;
    if(obj.value!=''){
    comm=obj.value;
    }*/
    var comm=obj.value;
    jQuery.ajax({
    url: '../../../../../cart.php',
    type: "POST",
    data: {process:'commissionUpdate',comm:comm},
    dataType: "json",
        success: function(data) {
            if(jQuery.trim(data)!='')
            {   
              document.location.href='payment';              
            }

        }
    });
   
}