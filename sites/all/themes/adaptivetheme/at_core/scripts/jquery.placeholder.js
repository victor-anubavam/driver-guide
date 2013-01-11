(function($) {

	$.fn.placeholder = function(o) {
		var s = jQuery.extend({
			onFocus: "focused",
			onChange: false,
			onBlur : false,
			placeholderSupport: (function(){ return 'placeholder' in document.createElement('input'); })()
		}, o);
		
		var hasChanged = function(){return !( $.trim($(this).val()) == "" || ($(this).val() == $(this).attr("placeholder")) );}
		
		// loop each element	
		this.each(function() {
			if (s.onBlur) $(this).addClass(s.onBlur);
			if(!s.placeholderSupport && !hasChanged.call(this)) { $(this).val($(this).attr('placeholder'));	}			
			if (s.onChange && hasChanged.call(this)) $(this).addClass(s.onChange);
			
			$(this).bind("focus", function(){
				if(!s.placeholderSupport && ($(this).val() == $(this).attr('placeholder'))) $(this).val('');		
				if(s.onFocus) $(this).addClass(s.onFocus);
				if(s.onBlur) $(this).removeClass(s.onBlur);
			}).bind("blur", function(){
				if(!s.placeholderSupport && !hasChanged.call(this)) $(this).val($(this).attr("placeholder"));				
				if(s.onFocus) $(this).removeClass(s.onFocus);
				if(s.onBlur) $(this).addClass(s.onBlur);
				(s.onChange && hasChanged.call(this)) ? $(this).addClass(s.onChange) : $(this).removeClass(s.onChange);
			});
		}); //end each loop
		return this; // return to jQuery
	};
})(jQuery);