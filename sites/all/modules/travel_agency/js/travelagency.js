
function memberfilter(obj)
{

        if(jQuery('#'+obj.id).val()!= '') {            

                var region = jQuery("#edit-name-1-network-name").val();
                var mail = jQuery("#edit-name-1-email").val();
                var membername = jQuery("#edit-name-1-member-name").val();
               
                
                if(membername == '00') {
                  //  jQuery(".form-item-name-1-network-name-others").css("display","block");
                 //  jQuery("#edit-name-1-member-name option").remove();
                  //  jQuery("#edit-name-1-member-name").append(new Option("others","00", true, true));
             
                    jQuery("#edit-name-1-memberotherdetails").css("display","block");
                    return true;
                }
                
                jQuery("#edit-name-1-networkotherdetails").css("display","none");
                jQuery("#edit-name-1-memberotherdetails").css("display","none");
                jQuery.ajax({
                url: '../../../../../getRegion.php',
                type: "POST",
                data: {network : region, email : mail, process:'members-head-quarters'},
                dataType: "json",
                success: function(data) {                    
                        if(jQuery.trim(data)!='')
                        {
                             if(jQuery.trim(data['snetwork'])!='') {
                                //alert(data['snetwork']);
                                jQuery("#edit-name-1-network-name").val(data['snetwork']);
                                jQuery("#edit-name-1-network-name").change();
                             }else {
                               jQuery("#edit-name-1-member-name option").remove();
                               jQuery("#edit-name-1-member-name").append(new Option("-Select-"," ", true, true));
                               for(i=0;i<data.length;i++)
                               {
                                    var dataArry  = data[i].split('||');
                                    jQuery("#edit-name-1-member-name").append(new Option(dataArry[0],dataArry[1], true, true));
                               }
                               jQuery("#edit-name-1-member-name option:first").attr("selected", true);
                             }
                         }
                }
               });
    }
}
function displayothermember(obj) {
      var valu = jQuery('#'+obj.id).val();
     // alert(valu);
                if(valu == '00') {                  
                    jQuery("#edit-name-1-memberotherdetails").css("display","block");
                /*    jQuery(".form-item-name-1-network-cfirst-name-others").css("display","block");
                    jQuery(".form-item-name-1-network-clast-name-others").css("display","block");*/

                }  else {
                    jQuery("#edit-name-1-memberotherdetails").css("display","none");
                    /*jQuery(".form-item-name-1-network-cfirst-name-others").css("display","none");
                    jQuery(".form-item-name-1-network-clast-name-others").css("display","none");*/
                }

}

function displayotherdetails(){
    //alert('sdfsdf');
    var membername1 = jQuery("#edit-name-1-member-name").val();
    //alert(membername1);
    if(membername1 == "00"){
       // alert(jQuery("#edit-name-1-memberotherdetails").html());
        jQuery("#edit-name-1-memberotherdetails").css("display","block");
        return false;
    }
}
