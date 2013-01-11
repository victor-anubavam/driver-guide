
function memberfilter(obj)
{

        if(jQuery('#'+obj.id).val()!= '') {
            
                //var region = jQuery('#'+obj.id).val();
                var eml = jQuery("#edit-name-1-email").val();
                var region = jQuery("#edit-name-1-network-name").val();
                jQuery.ajax({
                url: '../../../../../getRegion.php',
                type: "POST",
                data: {network : region, mail :eml, process:'travel-agency-filter'},
                dataType: "json",
                success: function(data) {
                         if(jQuery.trim(data['snetwork'])!='') {                               
                                jQuery("#edit-name-1-network-name").val(data['snetwork']);
                                jQuery("#edit-name-1-network-name").change();
                             }
                        if(jQuery.trim(data['agency'])!='')
                        {
                            
                               jQuery("#edit-name-1-agency option").remove();
                               jQuery("#edit-name-1-agency").append(new Option("-Select-"," ", true, true));
                               for(i=0;i<data['agency'].length;i++)
                               {
                                    var dataArry  = data['agency'][i].split('||');
                                    jQuery("#edit-name-1-agency").append(new Option(dataArry[0],dataArry[1], true, true));
                               }
                               jQuery("#edit-name-1-agency option:first").attr('selected', true);                             
                         }
                         if(jQuery.trim(data['member'])!='')
                        {
                            
                               jQuery("#edit-name-1-member-name option").remove();
                               jQuery("#edit-name-1-member-name").append(new Option("-Select-"," ", true, true));
                               for(i=0;i<data['member'].length;i++)
                               {
                                    var dataArry  = data['member'][i].split('||');
                                    jQuery("#edit-name-1-member-name").append(new Option(dataArry[0],dataArry[1], true, true));
                               }
                               jQuery("#edit-name-1-member-name option:first").attr('selected', true);                             
                         }
                }
               });
}
}
function memberfilterstageone(obj)
{

        if(jQuery('#'+obj.id).val()!= '') {
            
                //var region = jQuery('#'+obj.id).val();
                var eml = jQuery("#edit-name-1-email").val();
                var region = jQuery("#edit-name-1-member-name").val();
                if(region == "00") {
                    jQuery("#edit-name-1-agentmemberotherdetails").css("display","block");                  
                    return false;
                }
                jQuery("#edit-name-1-agentmemberotherdetails").css("display","none");                  
                jQuery.ajax({
                url: '../../../../../getRegion.php',
                type: "POST",
                data: {network : region, mail :eml, process:'get-agency-filter-stage-one'},
                dataType: "json",
                success: function(data) {
                         if(jQuery.trim(data['snetwork'])!='') {                               
                                jQuery("#edit-name-1-network-name").val(data['snetwork']);
                                jQuery("#edit-name-1-network-name").change();
                             }
                        if(jQuery.trim(data['agency'])!='')
                        {
                            
                               jQuery("#edit-name-1-agency option").remove();
                               jQuery("#edit-name-1-agency").append(new Option("-Select-"," ", true, true));
                               for(i=0;i<data['agency'].length;i++)
                               {
                                    var dataArry  = data['agency'][i].split('||');
                                    jQuery("#edit-name-1-agency").append(new Option(dataArry[0],dataArry[1], true, true));
                               }
                               jQuery("#edit-name-1-agency option:first").attr('selected', true);                             
                         }
                         if(jQuery.trim(data['member'])!='')
                        {
                            
                               jQuery("#edit-name-1-member-name option").remove();
                               jQuery("#edit-name-1-member-name").append(new Option("-Select-"," ", true, true));
                               for(i=0;i<data['member'].length;i++)
                               {
                                    var dataArry  = data['member'][i].split('||');
                                    jQuery("#edit-name-1-member-name").append(new Option(dataArry[0],dataArry[1], true, true));
                               }
                               jQuery("#edit-name-1-member-name option:first").attr('selected', true);                             
                         }
                }
               });
}
}
function displayothermember(obj) {
      var agency = jQuery("#edit-name-1-agency").val();
      var member = jQuery("#edit-name-1-member-name").val();    
                if((agency == '00') && (member == '00')){                    
                        jQuery("#edit-name-1-agentmemberotherdetails").css("display","block");
                        jQuery("#edit-name-1-agencyotherdetails").css("display","block");
                }else if(member == "00") {
                    jQuery("#edit-name-1-agentmemberotherdetails").css("display","block");
                    jQuery("#edit-name-1-agencyotherdetails").css("display","block");
                }else if(agency == '00'){                      
                        jQuery("#edit-name-1-agencyotherdetails").css("display","block");
                        jQuery("#edit-name-1-agentmemberotherdetails").css("display","none");
                } else {
                    jQuery("#edit-name-1-agentmemberotherdetails").css("display","none");
                    jQuery("#edit-name-1-agencyotherdetails").css("display","none");
                    var valu = jQuery("#edit-name-1-agency").val();                  
                      if(valu!=''){
                            jQuery.ajax({
                            url: '../../../../../getRegion.php',
                            type: "POST",
                            data: {nid : valu, process:'get-agency-info'},
                            dataType: "json",
                            success: function(data) {                    
                                    if(jQuery.trim(data)!='')
                                    {                                        
                                        jQuery("#edit-agencyaddr-1-zipcode").val(data['zipcode']);
                                        jQuery("#edit-agencyaddr-1-streetaddress").val(data['street_address']);
                                        jQuery("#edit-agencyaddr-1-city").val(data['city']);
                                        jQuery("#edit-agencyaddr-1-state").val(data['state']);
                                        jQuery("#edit-agencyaddr-1-country").find("option[value='"+data['countrycode']+"']").attr("selected", "selected");
                                        jQuery("#edit-web-1-web-url").val(data['website']);                                        
                                     }
                            }
                                });
                            }

        }
}

