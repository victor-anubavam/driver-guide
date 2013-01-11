/*jQuery Form to Form Wizard (Initial: Oct 1st, 2010)
* This notice must stay intact for usage 
* Author: Dynamic Drive at http://www.dynamicdrive.com/
* Visit http://www.dynamicdrive.com/ for full source code
*/

//Oct 21st, 2010: Script updated to v1.1, which adds basic form validation functionality, triggered each time the user goes from one page to the next, or tries to submit the form.

jQuery.noConflict()
/*
Array.prototype.in_array = function(p_val) {
    alert(p_val);
    for(var i = 0, l = this.length; i < l; i++) {
            if(this[i] == p_val) {
                return true;
            }
        }
    return false;
}
*/
function in_array( what, where ){
    var a=false;
    for(var i=0;i<where.length;i++){ 
    if(what == where[i]){
    a=true;
    break;
    }
    }    
    return a;
}


function formtowizard(options){
	this.setting=jQuery.extend({persistsection:false, revealfx:['slide', 500], oninit:function(){}, onpagechangestart:function(){}}, options)
	this.currentsection=-1
	this.init(this.setting)
}

formtowizard.prototype={

	createfieldsets:function($theform, arr){ //reserved function for future version (dynamically wraps form elements with a fieldset element)
		$theform.find('fieldset.sectionwrap').removeClass('sectionwrap') //make sure no fieldsets carry 'sectionwrap' before proceeding
		var $startelement=$theform.find(':first-child') //reference first element inside form
		for (var i=0; i<arr.length; i++){ //loop thru "break" elements
			var $fieldsetelements=$startelement.nextUntil('#'+arr[i].breakafter+', *[name='+arr[i].breakafter+']').andSelf() //reference all elements from start element to break element (nextUntil() is jQuery 1.4 function)
			$fieldsetelements.add($fieldsetelements.next()).wrapAll('<fieldset class="sectionwrap" />') //wrap these elements with fieldset element
			$startelement=$theform.find('fieldset.sectionwrap').eq(i).prepend('<legend>'+arr[i].legend+'</legend>').next() //increment startelement to begin at the end of the just inserted fieldset element
		}
	},

	loadsection:function(rawi, bypasshooks){
		var thiswizard=this
  	//doload Boolean checks to see whether to load next section (true if bypasshooks param is true or onpagechangestart() event handler doesn't return false)
		var doload=bypasshooks || this.setting.onpagechangestart(jQuery, this.currentsection, this.sections.$sections.eq(this.currentsection))
		doload=(doload===false)? false : true //unless doload is explicitly false, set to true
                if(rawi!="prev")
                {
                    if(rawi=="submitTrav1")
                    {
                        if (!bypasshooks && this.setting.validate){                    
                        var outcome=this.validate(this.currentsection);                       
                            if(outcome)
                            {
                              Drupal.CTools.Modal.dismiss();  
                            }
                            else
                            {
                                jQuery('#hid_reload').val('N');
                            }
                        }	
                    } 
                    else if (!bypasshooks && this.setting.validate){
                        var outcome=this.validate(this.currentsection)
                        if (outcome===false)
                                doload=false
                    }	
                } 
                
                
		
		var i=(rawi=="prev")? this.currentsection-1 : (rawi=="next")? this.currentsection+1 : parseInt(rawi) //get index of next section to show
		i=(i<0)? this.sections.count-1 : (i>this.sections.count-1)? 0 : i //make sure i doesn't exceed min/max limit
		if (this.currentsection!=i && i<this.sections.count && doload){ //if next section to show isn't the same as the current section shown
			this.$thesteps.eq(this.currentsection).addClass('disabledstep').end().eq(i).removeClass('disabledstep') //dull current "step" text then highlight next "step" text
			if (this.setting.revealfx[0]=="slide"){
				this.sections.$sections.css("visibility", "visible")
				this.sections.$outerwrapper.stop().animate({height: this.sections.$sections.eq(i).outerHeight()}, this.setting.revealfx[1]) //animate fieldset wrapper's height to accomodate next section's height
				this.sections.$innerwrapper.stop().animate({left:-i*this.maxfieldsetwidth}, this.setting.revealfx[1], function(){ //slide next section into view
					thiswizard.sections.$sections.each(function(thissec){
						if (thissec!=i) //hide fieldset sections currently not in veiw, so tabbing doesn't go to elements within them (and mess up layout)
							thiswizard.sections.$sections.eq(thissec).css("visibility", "hidden")
					})
				})
			}
			else if (this.setting.revealfx[0]=="fade"){ //if fx is "fade"
				this.sections.$sections.eq(this.currentsection).hide().end().eq(i).fadeIn(this.setting.revealfx[1], function(){
					if (document.all && this.style && this.style.removeAttribute)
						this.style.removeAttribute('filter') //fix IE clearType problem
				})
			}
			else{
				this.sections.$sections.eq(this.currentsection).hide().end().eq(i).show()
			}
			this.paginatediv.$status.text("Page "+(i+1)+" of "+this.sections.count) //update current page status text
			this.paginatediv.$navlinks.css('visibility', 'visible')
			if (i==0) //hide "prev" link
				this.paginatediv.$navlinks.eq(0).css('visibility', 'hidden')
			else if (i==this.sections.count-1) //hide "next" link
				this.paginatediv.$navlinks.eq(1).css('visibility', 'hidden')
			if (this.setting.persistsection) //enable persistence?
				formtowizard.routines.setCookie(this.setting.formid+"_persist", i)
			this.currentsection=i
		}
	},

	addvalidatefields:function(){
		var $=jQuery, setting=this.setting, theform=this.$theform.get(0), validatefields=[]
		var validatefields=setting.validate //array of form element ids to validate
		for (var i=0; i<validatefields.length; i++){
                   	var el=theform.elements[validatefields[i]] //reference form element
                        if (el){ //if element is defined
				var $section=$(el).parents('fieldset.sectionwrap:eq(0)') //find fieldset.sectionwrap this form element belongs to
				if ($section.length==1){ //if element is within a fieldset.sectionwrap element
					$section.data('elements').push(el) //cache this element inside corresponding section
				}
			}
		}
	},

	validate:function(section){
            //if (/(prev)|(next)/.test(this.target.className))
            //alert(this.target.className);            
            	var elements=this.sections.$sections.eq(section).data('elements') //reference elements within this section that should be validated
		var validated=true, invalidtext=["Please fill out the following fields:\n"]
		function invalidate(el){
			validated=false
                        // mahalingam custom code
                         if(el) {
                            el.className += el.className ? ' redvalid' : 'redvalid';
                          }
			//invalidtext.push("- "+ (el.id || el.name))
                }
		for (var i=0; i<elements.length; i++){
                   
                   //Mahalingam Custom Code
                    removeClass(elements[i],'redvalid');
                    // code ends
			if (/(text)/.test(elements[i].type) && elements[i].value==""){ //text and textarea elements
			        if(in_array(elements[i].id,addmoreArray) || in_array(elements[i].id,addmoreoutArray) ){}
                                else
                                invalidate(elements[i]);
			}
			else if (/(select)/.test(elements[i].type) && (elements[i].selectedIndex==-1 || elements[i].options[elements[i].selectedIndex].text=="" ||  elements[i].options[elements[i].selectedIndex].value=="" )){ //select elements
				if(in_array(elements[i].id,addmoreArray) || in_array(elements[i].id,addmoreoutArray) ){}
                                else
                                invalidate(elements[i]);
			}
			else if (elements[i].type==undefined && elements[i].length>0){ //radio and checkbox elements
				var onechecked=false
				for (var r=0; r<elements[i].length; r++){
					if (elements[i][r].checked==true){
						onechecked=true
						break
					}
				}
				if (!onechecked){
					invalidate(elements[i][0])
				}
			}
		}
		if (!validated)
                {
                    //Mahalingam Custom code
                   // alert(invalidtext.join('\n'))
                }
                else
                {
                 save_details(section);
                }
               
		return validated
	},


	init:function(setting){
		var thiswizard=this
		jQuery(function($){ //on document.ready
			var $theform=$('#'+setting.formid)
			if ($theform.length==0) //if form with specified ID doesn't exist, try name attribute instead
				$theform=$('form[name='+setting.formid+']')
			if (setting.manualfieldsets && setting.manualfieldsets.length>0)
				thiswizard.createfieldsets($theform, setting.manualfieldsets)
			var $stepsguide=$('<div class="stepsguide" />') //create Steps Container to house the "steps" text
			var $sections=$theform.find('fieldset.sectionwrap').hide() //find all fieldset elements within form and hide them initially
			if (setting.revealfx[0]=="slide"){ //create outer DIV that will house all the fieldset.sectionwrap elements
				$sectionswrapper=$('<div style="position:relative;overflow:hidden;"></div>').insertBefore($sections.eq(0)) //add DIV above the first fieldset.sectionwrap element
				$sectionswrapper_inner=$('<div style="position:absolute;left:0;top:0;"></div>') //create inner DIV of $sectionswrapper that will scroll to reveal a fieldset element
			}
			var maxfieldsetwidth=$sections.eq(0).outerWidth() //variable to get width of widest fieldset.sectionwrap
			$sections.slice(1).each(function(i){ //loop through $sections (starting from 2nd one)
				maxfieldsetwidth=Math.max($(this).outerWidth(), maxfieldsetwidth)
			})
			maxfieldsetwidth+=2 //add 2px to final width to reveal fieldset border (if not removed via CSS)
			thiswizard.maxfieldsetwidth=maxfieldsetwidth
			$sections.each(function(i){ //loop through $sections again
				var $section=$(this)
				if (setting.revealfx[0]=="slide"){
					$section.data('page', i).css({position:'absolute', top:0, left:maxfieldsetwidth*i}).appendTo($sectionswrapper_inner) //set fieldset position to "absolute" and move it to inside sectionswrapper_inner DIV
				}
				$section.data('elements', []) //empty array to contain elements within this section that should be validated for data (applicable only if validate option is defined)
				//create each "step" DIV and add it to main Steps Container:
				var $thestep=$('<div class="step disabledstep" />').data('section', i).html('Step '+(i+1)+'<div class="smalltext">'+$section.find('legend:eq(0)').text()+'</div>').appendTo($stepsguide)
				$thestep.click(function(){ //assign behavior to each step div
					thiswizard.loadsection($(this).data('section'))
				})
			})
			if (setting.revealfx[0]=="slide"){
				$sectionswrapper.width(maxfieldsetwidth) //set fieldset wrapper to width of widest fieldset
				$sectionswrapper.append($sectionswrapper_inner) //add $sectionswrapper_inner as a child of $sectionswrapper
			}
			$theform.prepend($stepsguide) //add $thesteps div to the beginning of the form
			//$stepsguide.insertBefore($sectionswrapper) //add Steps Container before sectionswrapper container
			var $thesteps=$stepsguide.find('div.step')
			//create pagination DIV and add it to end of form:
			var $paginatediv=$('<div class="formpaginate" style="overflow:hidden;"><span class="prev" style="float:left">Back</span> <span class="status">Step 1 of </span> <span class="next" style="float:right">Next</span></div>')
			$theform.append($paginatediv)
			thiswizard.$theform=$theform
			if (setting.revealfx[0]=="slide"){
				thiswizard.sections={$outerwrapper:$sectionswrapper, $innerwrapper:$sectionswrapper_inner, $sections:$sections, count:$sections.length} //remember various parts of section container
				thiswizard.sections.$sections.show()
			}
			else{
				thiswizard.sections={$sections:$sections, count:$sections.length} //remember various parts of section container
			}
			thiswizard.$thesteps=$thesteps //remember this ref
			thiswizard.paginatediv={$main:$paginatediv, $navlinks:$paginatediv.find('span.prev, span.next'), $status:$paginatediv.find('span.status')} //remember various parts of pagination DIV
			thiswizard.paginatediv.$main.click(function(e){ //assign behavior to pagination buttons
                            if (/(next)/.test(e.target.className)  && thiswizard.currentsection=='0')
                            {
                                if(jQuery('#arrival_tm').val()=='1')
                                {   
                                    if(jQuery('#normalTime'))
                                    {
                                        jQuery('#normalTime').hide();
                                        jQuery('#splTime').show();
                                    }
                                    if(jQuery('#normalTimeOut'))
                                    {
                                        jQuery('#normalTimeOut').hide();
                                        jQuery('#splTimeOut').show();
                                    }
                                   
                                }
                                else if(jQuery('#arrival_tm').val()=='2')
                                {   
                                    if(jQuery('#normalTime'))
                                    {
                                        jQuery('#normalTime').show();
                                        jQuery('#splTime').hide();
                                    }
                                     
                                   if(jQuery('#normalTimeOut'))
                                    {
                                        jQuery('#normalTimeOut').show();
                                        jQuery('#splTimeOut').hide();
                                    }
                                }
                                
                            }                            
                            if(/(next)/.test(e.target.className) && thiswizard.currentsection=='1')
                            {
                                jQuery('#arriv_hr_mt').removeClass('redvalid');
                                if(jQuery('#arrival_tm').val()=='1')
                                {  
                                   if(jQuery('#arriv_hr_mt'))
                                    {
                                        jQuery('#arriv_hr_mt').val(jQuery('#arriv_hr_mt_day').val());
                                    }
                                }
                                else if(jQuery('#arrival_tm').val()=='2')
                                {   
                                    if(jQuery('#arriv_hr_mt'))
                                    {
                                        var arriv=jQuery('#arriv_hr_mt').val();
                                        arrivarr=arriv.split(' ');
                                        var meridian='';
                                        var hr='';
                                        if(arrivarr[0] && arrivarr[0]!='')
                                        {
                                            arrivhrarr=arriv.split(':');
                                            hr=arrivhrarr[0];

                                            if(hr=='08'){
                                                hr=8;
                                            }
                                            else if(hr=='09'){
                                                hr=9;
                                            }
                                            else
                                            {
                                                hr=parseInt(hr);
                                            }
                                            meridian=arrivarr[1];
                                            if(meridian=='AM')
                                            {
                                               if(hr>6)
                                               {
                                                    jQuery('#step_1 .cartErrMsg').fadeIn();
                                                    setTimeout(function(){jQuery('#step_1 .cartErrMsg').fadeOut()},4000);
                                                    jQuery('#arriv_hr_mt').addClass('redvalid');
                                                    return false;     
                                               }
                                            }
                                            else if(meridian=='PM')
                                            {
                                               if(hr<8)
                                               {
                                                   jQuery('#step_1 .cartErrMsg').fadeIn();
                                                   setTimeout(function(){jQuery('#step_1 .cartErrMsg').fadeOut()},4000);
                                                   jQuery('#arriv_hr_mt').addClass('redvalid');
                                                   return false;     
                                               }
                                            }

                                        }
                                    }
                                }
                            }
                            if (/(next)/.test(e.target.className) && thiswizard.sections.count>2 && thiswizard.currentsection=='1')
                            {
                                
                                if(jQuery('#airline').val()!='')
                                {
                                    if(jQuery('#airlineout').val()=='')
                                    {
                                        var airlineVal= jQuery('#airline').val();
                                        jQuery('#airlineout').val(airlineVal);
                                        if(airlineVal=='Others')
                                        {
                                            jQuery('#airlineout_OthersTxt').val(jQuery('#airline_OthersTxt').val());
                                            jQuery('#airlineout_Others').show();
                                        }
                                        else
                                        {
                                            jQuery('#airlineout_OthersTxt').val('');
                                            jQuery('#airlineout_Others').hide();
                                        }
                                    }
                                }
                                if(jQuery('#dest_addr').val()!='')
                                {
                                    if(jQuery('#pickout_addr').val()=='')
                                    {
                                        var dest_addr= jQuery('#dest_addr').val();
                                        jQuery('#pickout_addr').val(dest_addr);
                                        if(dest_addr!='')
                                        {
                                            jQuery('#pickout_addrTxt').val(jQuery('#dest_addr_OthersTxt').val());
                                            jQuery('#pickout_addr_Others').show();
                                        }
                                        else
                                        {
                                            jQuery('#pickout_addrTxt').val('');
                                            jQuery('#pickout_addr_Others').hide();
                                        }
                                    }
                                }
                                
                                
                                if(jQuery('#driv_lang').val()!='')
                                {
                                    if(jQuery('#driv_lang_out').val()=='')
                                    {
                                        var driv_lang= jQuery('#driv_lang').val();
                                        jQuery('#driv_lang_out').val(driv_lang);
                                    }
                                }
                                
                                if(jQuery('#surtitle').val()!='')
                                {
                                    if(jQuery('#surtitle_out').val()=='')
                                    {
                                        var surtitle= jQuery('#surtitle').val();
                                        jQuery('#surtitle_out').val(surtitle);
                                    }
                                }
                                if(jQuery('#fname').val()!='')
                                {
                                    if(jQuery('#fname_out').val()=='')
                                    {
                                        var fname= jQuery('#fname').val();
                                        jQuery('#fname_out').val(fname);
                                    }
                                }
                                if(jQuery('#pasengername').val()!='')
                                {
                                    if(jQuery('#pasengername_out').val()=='')
                                    {
                                        var pasengername= jQuery('#pasengername').val();
                                        jQuery('#pasengername_out').val(pasengername);
                                    }  
                                }
                                if(jQuery('#tnum').val()!='')
                                {
                                    if(jQuery('#tnum_out').val()=='')
                                    {
                                        var tnum= jQuery('#tnum').val();
                                        jQuery('#tnum_out').val(tnum);
                                    }
                                }
                                //alert(jQuery('#step_1 #addmoreDiv:first').attr('fieldcount'));
                                //if(jQuery('#step_1 .addmoreDiv:first').attr(''))
                                
                            }
                            if (/(prev)|(next)|(submitTrav1)/.test(e.target.className))
                                    thiswizard.loadsection(e.target.className)
			})
			var i=(setting.persistsection)? formtowizard.routines.getCookie(setting.formid+"_persist") : 0
			thiswizard.loadsection(i||0, true) //show the first section
                        thiswizard.setting.oninit($, i, $sections.eq(i)) //call oninit event handler
			if (setting.validate){ //if validate array defined
				thiswizard.addvalidatefields() //seek out and cache form elements that should be validated
                               thiswizard.$theform.submit(function(){
                                   	var returnval=true;
                                        for (var i=0; i<thiswizard.sections.count; i++){
                                           	if (!thiswizard.validate(i)){
                                                   	thiswizard.loadsection(i, true)
                                                        returnval=false
							break
						}
					}
                                         
                                        if(returnval)
                                        {   
                                           return false;
                                        }
                                        else
					return returnval //allow or disallow form submission
				})
			}
		})
	}
}

formtowizard.routines={

	getCookie:function(Name){ 
		var re=new RegExp(Name+"=[^;]+", "i"); //construct RE to search for target name/value pair
		if (document.cookie.match(re)) //if cookie found
			return document.cookie.match(re)[0].split("=")[1] //return its value
		return null
	},

	setCookie:function(name, value){
		document.cookie = name+"=" + value + ";path=/"
	}
}
function removeClass(ele,cls) {
    if (hasClass(ele,cls)) {
        var reg = new RegExp('(\\s|^)'+cls+'(\\s|$)');
        ele.className=ele.className.replace(reg,' ');
    }
}
function hasClass(ele,cls) {
    return ele.className.match(new RegExp('(\\s|^)'+cls+'(\\s|$)'));
}

