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
  
});  