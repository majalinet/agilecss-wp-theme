(function( $ ) {
    $(function() {
		function escapeHtml(text) {
		  var map = {
			'&': '&amp;',
			'<': '&lt;',
			'>': '&gt;',
			'"': '&quot;',
			"'": '&#039;'
		  };

		  return text.replace(/[&<>"']/g, function(m) { return map[m]; });
		}
        function set_field(select, id, num){
			var str = '';
			var num = $(select).parent().attr('data-row');
			str += '<input type="hidden" name="agile_footer_option_name[footer_col_'+id+'_contacts]['+num+'][type]" value="'+$(select).val()+'">';
			switch( $(select).val() ){
				case 'text':
					str += '<input class="single-input" placeholder="Input text" type="text" name="agile_footer_option_name[footer_col_'+id+'_contacts]['+num+'][value]">';
					break;
				case 'label_text':
					str += '<input type="text" class="double-input" placeholder="Input label" name="agile_footer_option_name[footer_col_'+id+'_contacts]['+num+'][label]"><input placeholder="Input text" type="text" class="double-input" name="agile_footer_option_name[footer_col_'+id+'_contacts]['+num+'][value]">';
					break;
				case 'social_bar':
					str += '<input type="hidden" name="agile_footer_option_name[footer_col_'+id+'_contacts]['+num+'][value]" value="social_bar"> <span class="box">Social Bar</span>';
					break;
				case 'subscribe':
					str += '<input type="hidden" name="agile_footer_option_name[footer_col_'+id+'_contacts]['+num+'][value]" value="subscribe"> <span class="box">Subscribe</span>';
					break;
				default:
					return false;
			};
			$(select).replaceWith( str );
		}
		
		function nav_arrows(){
			$('.contacts_fields').find('.dashicons-before').off('click');
			$('.contacts_fields').find('.dashicons-before').on('click',function(){
				
				if( $(this).hasClass('dashicons-arrow-down-alt2') ){
					var row = $(this).parent();
					var container = $(row).parent();
					if( $(row)[0] != $(container).find('p').last()[0]){
						var next = $(container).find(row).next();
						$(row).attr( 'data-row', $(next).attr('data-row') );
						$(next).attr( 'data-row', $(next).attr('data-row')-1 );
						$(row).before($(next));
					}
				}else{
					var row = $(this).parent();
					var container = $(row).parent();
					if( $(row)[0] != $(container).find('p').first()[0]){
						var prev = $(container).find(row).prev();
						$(prev).attr( 'data-row', $(row).attr('data-row') );
						$(row).attr( 'data-row', $(row).attr('data-row')-1 );						
						$(prev).before($(row));
					}
				}
				$('.contacts_fields').find('input').each(function(){
					var row = $(this).parent();
					var name = $(this).attr('name');
					var new_name = name.replace(/(.*)\[(.*)\]\[(.*)\]\[(.*)\]/i, '$1[$2]['+$(row).attr( 'data-row')+'][$4]');
					$(this).attr('name', new_name);
				});
			});
			$('.social-container').find('.dashicons-before').off('click');
			$('.social-container').find('.dashicons-before').on('click',function(){
				if( $(this).hasClass('dashicons-arrow-down-alt2') ){
					var row = $(this).parents('p');
					var container = $(row).parent();
					if( $(row)[0] != $(container).find('p').last()[0]){
						var next = $(container).find(row).next();
						$(row).attr( 'data-row', $(next).attr('data-row') );
						$(next).attr( 'data-row', $(next).attr('data-row')-1 );
						$(row).before($(next));
					}
				}else{
					var row = $(this).parents('p');
					var container = $(row).parent();
					if( $(row)[0] != $(container).find('p').first()[0]){
						var prev = $(container).find(row).prev();
						$(prev).attr( 'data-row', $(row).attr('data-row') );
						$(row).attr( 'data-row', $(row).attr('data-row')-1 );						
						$(prev).before($(row));
					}
				}
				$('.social-container').find('input, radio').each(function(){
					var row = $(this).parents('p');
					var name = $(this).attr('name');
					var new_name = name.replace(/(.*)\[(.*)\]\[(.*)\]\[(.*)\]/i, '$1[$2]['+$(row).attr( 'data-row')+'][$4]');
					$(this).attr('name', new_name);
				});
			})
		}
		nav_arrows();
		
        // Add Color Picker to all inputs that have 'color-field' class
        $( '.color' ).wpColorPicker();
		
		function add_prop(){
			$('.add_prop').off('click');
			$('.add_prop').on('click', function(e){
				e.preventDefault();
				var container = $(this).parents('.colum_fields').find('.contacts_fields');
				var num = $(container).find('p').length;
				$(container).append('<p data-row="'+num+'"><select class="new_field" data-id="'+$(this).data('id')+'"><option value="" disabled selected>Select field type</option><option value="text">Text</option><option value="label_text">Text with label</option><option value="social_bar">Social Bar</option><option value="subscribe">Subscribe</option></select><span class="dashicons-before dashicons-arrow-up-alt2"></span><span class="dashicons-before dashicons-arrow-down-alt2"></span></p>');
				nav_arrows();
				$(container).find('select').on('change', function(){
					set_field(this, $(this).data('id'), num);
				})
			});
		};
		add_prop();
		
		$('#count_colums').on('change', function(){
			for(var i = 4; i > $(this).val(); i--){
				$( '#colum_'+i ).parents('table').hide();
				$( '#colum_'+i ).parents('table').prev('h2').hide();
			}
			for(var i = 1; i <= $(this).val(); i++){
				$( '#colum_'+i ).parents('table').show();
				$( '#colum_'+i ).parents('table').prev('h2').show();
			}
		}).change();
			
		$('.colum_type_select').on('change', function(){
			var container = $(this).parent().parent().find('div.colum_fields');
			switch( $(this).val() ){
				case 'menu':
					$(container).html('<input name="agile_footer_option_name[footer_col_' + $(this).data('id') + '_menu_name]" placeholder="Input Menu Name">');
					break;
				case 'map':
					$(container).html('<textarea rows="10" name="agile_footer_option_name[footer_col_' + $(this).data('id') + '_map_script]" placeholder="Input Map Script"></textarea>');
					break;
				case 'contacts':
					$(container).html('<div class="contacts_fields"></div><p><button class="add_prop" data-id="1">Add Field</button></p>');
					add_prop();
					break;
				case 'empty':
					$(container).html('');
					break;
				default:
					$(container).html('<textarea rows="10" name="agile_footer_option_name[footer_col_' + $(this).data('id') + '_text]" placeholder="Input Text to display"></textarea>');
					break;
   
			}
		});
		function social_init(){
			$('.social-container').find('p').each(function(){
				var row = $(this);
				$(this).find('.img_type').each(function(){
					$(this).off('change');
					$(this).on('change', function(){
						if( $(this).is(':checked') ){
							if( $(this).val() == 'IMG' ){
								$(row).find('.social_img').css('display', 'inline-block');
								$(row).find('.social_svg').hide();
							}else{
								$(row).find('.social_img').hide();
								$(row).find('.social_svg').css('display', 'inline-block');
							}
						}
					});
					$(this).trigger('change');
				});
				
				$(this).find('.add_social_img, .social_img .dashicons-edit').off('click');
				$(this).find('.add_social_img, .social_img .dashicons-edit').on('click', function() {
					var button=$(this);
					var row = $(this).parents('p').attr('data-row');
					var name = $(this).parents('p').attr('data-name');
					if( !name ){
						name = "agile_social_option_name[social_services]";
					}
					tb_show('', 'media-upload.php?type=image&TB_iframe=true&ETI_field=post_background');  
			  
					window.send_to_editor = function(html) { 
						imgurl = $(html).attr('src');  
						if( imgurl ){
							var field = '<img src="'+imgurl+'"><input type="hidden" value="'+imgurl+'" name="'+name+'['+row+'][img]"><i class="dashicons dashicons-edit"></i>';
							if( $(button).hasClass('add_social_img') ){
								$(button).replaceWith(field);
							}else{
								$(button).parent().html(field);
							}							
						}
					tb_remove();  
					}  
					return false;  
				});
				
				$(this).find('.add_social_svg, .social_svg .dashicons-edit').off('click');
				$(this).find('.add_social_svg, .social_svg .dashicons-edit').on('click', function(){
					if( $(this).hasClass('add_social_svg') ){
						var edit = "<button class='add_social_svg'>Add Social SVG Icon</button>";
					}else{
						var edit = "<i class='dashicons dashicons-edit'></i>";
					}
					$(this).replaceWith('<textarea name="svg_input" placeholder="Input code of our SVG icon"></textarea><button class="svg_input_btn">Add</button>');
					$('.svg_input_btn').off('click');
					$('.svg_input_btn').on('click', function(e){
						e.preventDefault();
						var icon = $(this).parent().find('textarea').val();
						if( icon.length > 0 ){
							console.log(icon.length );
							var row = $(this).parents('p').attr('data-row');
							var name = $(this).parents('p').attr('data-name');
							if( !name ){
								name = "agile_social_option_name[social_services]";
							}
							$(this).parent().html('<span class="icon">'+icon+'</span><input type="hidden" value="'+escapeHtml(icon)+'" name="'+name+'['+row+'][svg]"><i class="dashicons dashicons-edit"></i>');
						}else{
							$(this).parent().find('textarea').remove();
							$(this).parent().find('.svg_input_btn').remove();
							$(this).parent().append(edit);
						}
					});
					
				});
			});
		}
		
		$('.add_social').on('click', function(e){
			e.preventDefault();
			var str = '<p class="social-row box" data-row="'+$('.social-container').find('p').length+'">';
			str += "<span class='social_col social_col_1'>";
				str += "<span class='img_container'><span class='social_img'><button class='add_social_img'>Add Social IMG Icon</button></span>";
				str += "<span class='social_svg'><button class='add_social_svg'>Add Social SVG Icon</button></span>";
				str += "<span class='social_types'>Select Image Type: <label>SVG <input type='radio' name='agile_social_option_name[social_services]["+$('.social-container').find('p').length+"][img_type]' class='img_type' checked value='SVG'></label><label>IMG <input class='img_type' type='radio' name='agile_social_option_name[social_services]["+$('.social-container').find('p').length+"][img_type]' value='IMG'></label></span></span>";	
			str += '</span>';
			str += "<span class='social_col social_col_2'>";
				str += '<span><label>Name: <input type="text" name="agile_social_option_name[social_services][' +$('.social-container').find('p').length+ '][name]" placeholder="Social Service Name"></label></span>';
				str += '<span><label>Link: <input type="text" name="agile_social_option_name[social_services][' +$('.social-container').find('p').length+ '][link]" placeholder="Social Service Link"></label></span>';
			str += "</span>";
			str += "<span class='social_col social_col_3'>";
				str += '<span class="dashicons-before dashicons-arrow-up-alt2"></span><span class="dashicons-before dashicons-arrow-down-alt2"></span><span class="dashicons dashicons-no" onclick="jQuery(this).parents("p").remove()"></span>';
			str += "</span>";
			str += '</p>';
			$('.social-container').append(str);
			social_init();
		})
		social_init();
    });
})( jQuery );