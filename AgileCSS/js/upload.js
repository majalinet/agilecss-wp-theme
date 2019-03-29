jQuery(document).ready(function() {  
    jQuery('#signature-title').click(function(){
		jQuery(this).parent().find('.signature').toggleClass('hidden');
		var signature = jQuery('#signature').val();
		if( signature == 'N'){
			jQuery('#signature').val('Y');
		}else{
			jQuery('#signature').val('N');
		}
		
	});
	
    jQuery('#signature-image-button').click(function() {  
		formfield = jQuery('#signature-image-field').attr('name');  
		tb_show('', 'media-upload.php?type=image&TB_iframe=true&ETI_field=post_background');  
  
		window.send_to_editor = function(html) {  
		
		imgurl = jQuery(html).attr('src');  
		jQuery('input[name='+formfield+']').val(imgurl);
		if( imgurl ){
			jQuery('#signature-image').attr('src',imgurl); 
			jQuery('#signature-image').show();	
		}		
		 
		 tb_remove();  
		}  
		return false;  
    });
	
	jQuery('#slider-title').click(function(){
		jQuery(this).parent().find('.slider').toggleClass('hidden');
		jQuery(this).parent().toggleClass('close');
		var signature = jQuery('#slider').val();
		if( signature == 'N'){
			jQuery('#slider').val('Y');
		}else{
			jQuery('#slider').val('N');
		}
		
	});	
	jQuery('#gallery-title').click(function(){
		jQuery(this).parent().find('.gallery').toggleClass('hidden');
		jQuery(this).parent().toggleClass('close');
		var signature = jQuery('#gallery').val();
		if( signature == 'N'){
			jQuery('#gallery').val('Y');
		}else{
			jQuery('#gallery').val('N');
		}
		
	});
	jQuery('#results-title').click(function(){
		jQuery(this).parent().find('.results').toggleClass('hidden');
		jQuery(this).parent().toggleClass('close');
		var signature = jQuery('#results').val();
		if( signature == 'N'){
			jQuery('#results').val('Y');
		}else{
			jQuery('#results').val('N');
		}
		
	});
	jQuery('#requiremets-title').click(function(){
		jQuery(this).parent().find('.requiremets').toggleClass('hidden');
		jQuery(this).parent().toggleClass('close');
		var signature = jQuery('#requiremets').val();
		if( signature == 'N'){
			jQuery('#requiremets').val('Y');
		}else{
			jQuery('#requiremets').val('N');
		}
		
	});
	
    jQuery('#gallery-image-button').click(function() {  
		formfield = jQuery('#gallery-image-field').attr('name');  
		tb_show('', 'media-upload.php?type=image&TB_iframe=true&ETI_field=post_background');  
  
		window.send_to_editor = function(html) {  
		
			imgurl = jQuery(html).attr('src');  
			count = jQuery('#gallery_images').find('p').length;
			if( imgurl ){
				jQuery('#gallery_images').append('<p><img src="' + imgurl + '" class="gallery-img" ><input type="hidden" id="gallery-image-field" name="gallery-image[]" value="' + imgurl + '"><span class="dashicons dashicons-no" onclick="jQuery(this).parent().remove()"></span></p>');
			}	
			 
			tb_remove();  
		}  
		return false;  
    });	 
	jQuery('#slider-image-button').click(function() {  
		formfield = jQuery('#slider-image-field').attr('name');  
		tb_show('', 'media-upload.php?type=image&TB_iframe=true&ETI_field=post_background');  
  
		window.send_to_editor = function(html) {  
		
			imgurl = jQuery(html).attr('src');  
			count = jQuery('#slider_images').find('p').length;
			if( imgurl ){
				jQuery('#slider_images').append('<p><img src="' + imgurl + '" class="slider-img" ><input type="hidden" id="slider-image-field" name="slider-image[]" value="' + imgurl + '"><span class="dashicons dashicons-no" onclick="jQuery(this).parent().remove()"></span></p>');
			}	
			 
			tb_remove();  
		}  
		return false;  
    });	
	
	jQuery('.add_tags').on('click', function(e){
		e.preventDefault();
		var container = jQuery(this).data('target');
		var input = jQuery(this).data('field');
		var str = jQuery('#'+input).val();
		tags = str.split(',');
		for (var i = 0; i<tags.length; i++){
			jQuery('#'+container).append('<span class="custom-tags"><input type="hidden" name="'+input+'[]" value="'+jQuery.trim(tags[i])+'">' + jQuery.trim(tags[i]) + '<span class="dashicons dashicons-no" onclick="jQuery(this).parent().remove()"></span></span>');
		}
		jQuery('#'+input).val('');
	});
	
	jQuery('.add_custom_fileds').on('click', function(e){
		e.preventDefault();
		var container = jQuery(this).data('target');
		var input = jQuery(this).data('field');
		var str = jQuery('#'+input).val();
		var count=jQuery('#'+container).find('p').length;
		jQuery('#'+container).append('<p><input type="text" name="'+input+'['+count+'][name]" value="'+jQuery.trim(str)+'" style="width:20%"/><input type="text" name="'+input+'['+count+'][value]" placeholder="Value" value="" style="width:70%"/><span class="dashicons dashicons-no" onclick="jQuery(this).parent().remove()"></span></p>');
		
		jQuery('#'+input).val('');
	});
	

	
});  