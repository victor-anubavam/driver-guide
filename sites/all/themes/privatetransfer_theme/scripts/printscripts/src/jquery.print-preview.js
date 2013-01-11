/*!
 * jQuery Print Previw Plugin v1.0.1
 *
 * Copyright 2011, Tim Connell
 * Licensed under the GPL Version 2 license
 * http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Date: Wed Jan 25 00:00:00 2012 -000
 */
 
(function($) { 
    
	// Initialization
	$.fn.printPreview = function() {
		this.each(function() {
			$(this).bind('click', function(e) {
                            e.preventDefault();
			    if (!$('#print-modal').length) {
			        $.printPreview.loadPrintPreview();
			    }
			});
		});
		return this;
	};
    
    // Private functions
    var mask, size, print_modal, print_controls;
    $.printPreview = {
        loadPrintPreview: function() {
            $('#loader').hide();
            // Declare DOM objects
            print_modal = $('<div id="print-modal"></div>');
            print_controls = $('<div id="print-modal-controls">' + 
                                    '<a href="#" class="print" title="Print page">Print page</a>' +
                                    '<a href="#" class="close" title="Close print preview">Close</a>').hide();
            var print_frame = $('<iframe id="print-modal-content" scrolling="no" border="0" frameborder="0" name="print-frame" />');

            // Raise print preview window from the dead, zooooooombies
            print_modal
                .hide()
                .append(print_controls)
                .append(print_frame)
                .appendTo('body');

            // The frame lives
            for (var i=0; i < window.frames.length; i++) {
                if (window.frames[i].name == "print-frame") {    
                    var print_frame_ref = window.frames[i].document;
                    break;
                }
            }
            print_frame_ref.open();
            print_frame_ref.write('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' +
                '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">' + 
                '<head><title>'+ document.title +'</title></head>' +
                '<body class="page-payment-complete"></body></html>');
            print_frame_ref.close();
            
            // Grab contents and apply stylesheet
            var $iframe_head = $('head link').clone(),
                $iframe_body = $('body > *:not(#print-modal):not(script)').clone();
                
            $iframe_head.each(function() {
                $(this).attr('media', 'all');
            });
	  //  alert($.browser.version);
            if (!$.browser.msie && !($.browser.version < 7) ) {
           
		$('head', print_frame_ref).append($iframe_head);
		
                var tabclass='';
                if($('#tab1link').hasClass("act"))
                {tabclass='tab1link';}
                else if($('#tab2link').hasClass("act"))
                {tabclass='tab2link';}
                else if($('#tab3link').hasClass("act"))
                {tabclass='tab3link';}
                else if($('#tab4link').hasClass("act"))
                {tabclass='tab4link';}
                 
                $iframe_body='<table class="header-print"><tr class="top-bar"><td>'+
		'<div class="header-content"><a class="cm-webversion" href="http://www.private-transfer.fr">www.private-transfer.fr</a>'+
                '<span class="hide">&nbsp;&nbsp;|&nbsp; Toll free from US: <strong>1 866 813 7381</strong> <br/>reservation@private-transfer.fr</span></div></td></tr>'+
                    '<tr class="top-bar-logo"><td width="580" class="w580"><div align="left" id="headline">'+
                                       '<p><img src="/sites/all/themes/privatetransfer_theme/logo.png"/></p></div></td></tr></table>'+
				       $('#cont_'+tabclass).html()+'<table><tr class="footer-pay"><td><div class="div-left">'+
                                '<span class="hide"><p align="left" class="footer-content-left" id="permission-reminder"></p></span>'+
                                '<p align="left" class="footer-content-left">'+
                                    '<strong>Découvertes SARL</strong><br/>'+
                                    '2012 Découvertes SARL, 8 bis avenue du Cegares, <br/>13840 Rognes, France'+
                    'Decouvertes Inc., 256 Carlton Avenue, Brooklyn, NY 11205-4002- Licence n. L1.013.00.0004'+
                                   '</p></div><div  class="rightside"><p align="right" class="footer-content-right" id="street-address">'+
                                    'Private-transfer.fr / Contact us<br/>Toll free from US:1 866 813 7381<br/>'+
                    'reservation@private-transfer.fr<br/> Tel: +33 442 50 14<br/> Fax:+33 442 50 30 63</p></div></td>'+
                '</tr></table>';
                $('body', print_frame_ref).append($iframe_body);		
		
            }
            else {
		
                $('body > *:not(#print-modal):not(script)').clone().each(function() {
                    $('body', print_frame_ref).append(this.outerHTML);
                });
                $('head link[media*=print], head link[media=all]').each(function() {			
                    $('head', print_frame_ref).append($(this).clone().attr('media', 'all')[0].outerHTML);
                });
            }
	    
	    
            $('a', print_frame_ref).bind('click.printPreview', function(e) {
                e.preventDefault();
            });
            
            // Introduce print styles
            $('head').append('<style type="text/css">' +
                '@media print {' +
                    '/* -- Print Preview --*/' +
                    '#print-modal-mask,' +
                    '#print-modal {' +
                        'display: none !important;' +
                    '}' +
                '}' +
                '</style>'
            );
	
            // Load mask
            $.printPreview.loadMask();

            // Disable scrolling
            $('body').css({overflowY: 'hidden', height: '100%'});
            $('img', print_frame_ref).load(function() {
                print_frame.height($('body', print_frame.contents())[0].scrollHeight);
            });
            
            // Position modal            
            starting_position = $(window).height() + $(window).scrollTop();
            var css = {
                    top:         starting_position,
                    height:      '100%',
                    overflowY:   'auto',
                    zIndex:      10000,
                    display:     'block'
                }
            print_modal
                .css(css)
                .animate({ top: $(window).scrollTop()}, 400, 'linear', function() {
                    print_controls.fadeIn('slow').focus();
                });
            print_frame.height($('body', print_frame.contents())[0].scrollHeight);
            
            // Bind closure
            $('a', print_controls).bind('click', function(e) {
                e.preventDefault();
                if ($(this).hasClass('print')) {
                   printContent();
                    //alert("going for print");
                    //window.print();
                }
                else { $.printPreview.distroyPrintPreview(); }
            });
    	},
    	
    	distroyPrintPreview: function() {
    	    print_controls.fadeOut(100);
    	    print_modal.animate({ top: $(window).scrollTop() - $(window).height(), opacity: 1}, 400, 'linear', function(){
    	        print_modal.remove();
    	        $('body').css({overflowY: 'auto', height: 'auto'});
    	    });
    	    mask.fadeOut('slow', function()  {
    			mask.remove();
    		});				

    		$(document).unbind("keydown.printPreview.mask");
    		mask.unbind("click.printPreview.mask");
    		$(window).unbind("resize.printPreview.mask");
	    },
	    
    	/* -- Mask Functions --*/
	    loadMask: function() {
	        size = $.printPreview.sizeUpMask();
            mask = $('<div id="print-modal-mask" />').appendTo($('body'));
    	    mask.css({				
    			position:           'absolute', 
    			top:                0, 
    			left:               0,
    			width:              size[0],
    			height:             size[1],
    			display:            'none',
    			opacity:            0,					 		
    			zIndex:             9999,
    			backgroundColor:    '#000'
    		});
	
    		mask.css({display: 'block'}).fadeTo('400', 0.75);
    		
            $(window).bind("resize..printPreview.mask", function() {
				$.printPreview.updateMaskSize();
			});
			
			mask.bind("click.printPreview.mask", function(e)  {                           
				$.printPreview.distroyPrintPreview();
			});
			
			$(document).bind("keydown.printPreview.mask", function(e) {
			    if (e.keyCode == 27) {  $.printPreview.distroyPrintPreview(); }
			});
        },
    
        sizeUpMask: function() {
            if ($.browser.msie) {
            	// if there are no scrollbars then use window.height
            	var d = $(document).height(), w = $(window).height();
            	return [
            		window.innerWidth || 						// ie7+
            		document.documentElement.clientWidth || 	// ie6  
            		document.body.clientWidth, 					// ie6 quirks mode
            		d - w < 20 ? w : d
            	];
            } else { return [$(document).width(), $(document).height()]; }
        },
    
        updateMaskSize: function() {
    		var size = $.printPreview.sizeUpMask();
    		mask.css({width: size[0], height: size[1]});
        }
    }
})(jQuery);

function printContent()
{
    
    if($('#tab1link').hasClass("act"))
    {tabclass='tab1link';}
    else if($('#tab2link').hasClass("act"))
    {tabclass='tab2link';}
    else if($('#tab3link').hasClass("act"))
    {tabclass='tab3link';}
    else if($('#tab4link').hasClass("act"))
    {tabclass='tab4link';}

    var DocumentContainer_innerHTML='<table class="header-print"><tr class="top-bar"><td>'+
    '<div class="header-content"><a class="cm-webversion" href="http://www.private-transfer.fr">www.private-transfer.fr</a>'+
    '<span class="hide">&nbsp;&nbsp;|&nbsp; Toll free from US: <strong>1 866 813 7381</strong> <br/>reservation@private-transfer.fr</span></div></td></tr>'+
        '<tr class="top-bar-logo"><td width="580" class="w580"><div align="left" id="headline">'+
                           '<p><img src="/sites/all/themes/privatetransfer_theme/logo.png"/></p></div></td></tr></table>'+
                           $('#cont_'+tabclass).html()+'<table><tr class="footer-pay"><td><div class="div-left">'+
                    '<span class="hide"><p align="left" class="footer-content-left" id="permission-reminder"></p></span>'+
                    '<p align="left" class="footer-content-left">'+
                        '<strong>Découvertes SARL</strong><br/>'+
                        '2012 Découvertes SARL, 8 bis avenue du Cegares, <br/>13840 Rognes, France'+
        'Decouvertes Inc., 256 Carlton Avenue, Brooklyn, NY 11205-4002- Licence n. L1.013.00.0004'+
                       '</p></div><div  class="rightside"><p align="right" class="footer-content-right" id="street-address">'+
                        'Private-transfer.fr / Contact us<br/>Toll free from US:1 866 813 7381<br/>'+
        'reservation@private-transfer.fr<br/> Tel: +33 442 50 14<br/> Fax:+33 442 50 30 63</p></div></td>'+
    '</tr></table>';
var html = '<html><head>'+
               '<link href="/sites/all/themes/privatetransfer_theme/scripts/printscripts/css/print.css" rel="stylesheet" type="text/css" />'+
               '</head><body>'+
               DocumentContainer_innerHTML+
               '</body></html>';

    var WindowObject = window.open("", "PrintWindow",
    "width=750,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
    WindowObject.document.writeln(html);
    WindowObject.document.close();
    WindowObject.focus();
    WindowObject.print();
    WindowObject.close();
}
