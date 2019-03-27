<?php
class AgileSettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
		
		// Css rules for Color Picker
		wp_enqueue_style( 'wp-color-picker' );
		// Register javascript
		wp_enqueue_script( 'agile_settings_js', get_bloginfo('template_url') . '/js/agile_settings.js', array( 'jquery', 'wp-color-picker' ), '', true  );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_menu_page(
            'Agile Settings', 
            'Agile Settings', 
            'manage_options', 
            'agile-setting-admin', 
            array( $this, 'create_admin_page' ),
			'',
			100
        ); 
		
		add_submenu_page(
            'agile-setting-admin', 
            'Agile Header', 
            'Agile Header', 
			'manage_options', 
            'agile-header-setting-admin', 
            array( $this, 'create_header_admin_page' ),
			'',
			100
        );
		
		add_submenu_page(
            'agile-setting-admin', 
            'Agile Footer', 
            'Agile Footer', 
			'manage_options', 
            'agile-footer-setting-admin', 
            array( $this, 'create_footer_admin_page' ),
			'',
			100
        );
		
		add_submenu_page(
            'agile-setting-admin', 
            'Agile Social', 
            'Agile Social', 
			'manage_options', 
            'agile-social-setting-admin', 
            array( $this, 'create_social_admin_page' ),
			'',
			100
        );
		
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'agile_option_name' );
        ?>
        <div class="wrap">
            <h1>Agile Settings</h1>
            <form method="post" action="options.php">
			<div class="agile_settings" style="border-bottom:1px solid #e2e4e7">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'agile_option_group' );
                do_settings_sections( 'agile-setting-admin' );
                submit_button();
            ?>
			</div>
			
            </form>
        </div>
        <?php
    }
	
	/**
     * Options Footer page callback
    */
    public function create_header_admin_page()
    {
        // Set class property
        $this->options = get_option( 'agile_header_option_name' );
        ?>
        <div class="wrap">
	
            <h1>Agile Settings</h1>
            <form method="post" action="options.php">
			<div class="agile_settings" style="border-bottom:1px solid #e2e4e7">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'agile_header_option_group' );
                do_settings_sections( 'agile-header-setting-admin' );?>
				<p>Be careful to change the data on this page, you can not return the changes.</p>
            <?php
				submit_button();
            ?>
			</div>
				
            </form>
        </div>
        <?php
    }
	/**
     * Options Footer page callback
    */
    public function create_footer_admin_page()
    {
        // Set class property
        $this->options = get_option( 'agile_footer_option_name' );
        ?>
        <div class="wrap">
	
            <h1>Agile Settings</h1>
            <form method="post" action="options.php">
			<div class="agile_settings" style="border-bottom:1px solid #e2e4e7">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'agile_footer_option_group' );
                do_settings_sections( 'agile-footer-setting-admin' );?>
				<p>Be careful to change the data on this page, you can not return the changes.</p>
            <?php
				submit_button();
            ?>
			</div>
				
            </form>
        </div>
        <?php
    }
	/**
     * Options Footer page callback
    */
    public function create_social_admin_page()
    {
        // Set class property
        $this->options = get_option( 'agile_social_option_name' );
        ?>
        <div class="wrap">
	
            <h1>Agile Social Settings</h1>
            <form method="post" action="options.php">
			<div class="agile_settings" style="border-bottom:1px solid #e2e4e7">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'agile_social_option_group' );
                do_settings_sections( 'agile-social-setting-admin' );?>
				<p>Be careful to change the data on this page, you can not return the changes.</p>
            <?php
				submit_button();
            ?>
			</div>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {   	
        register_setting(
            'agile_option_group', // Option group
            'agile_option_name', // Option name
            array( $this, 'sanitize' ) // Sanitize
        ); 
		
		register_setting(
            'agile_header_option_group', // Option group
            'agile_header_option_name', // Option name
            array( $this, 'sanitize_header' ) // Sanitize
        ); 
		
		register_setting(
            'agile_footer_option_group', // Option group
            'agile_footer_option_name', // Option name
            array( $this, 'sanitize_footer' ) // Sanitize
        ); 
		
		register_setting(
            'agile_social_option_group', // Option group
            'agile_social_option_name', // Option name
            array( $this, 'sanitize_social' ) // Sanitize
        ); 
		
// Agile Settings Page
        add_settings_section(
            'agile_colors', // ID
            'Agile Site Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'agile-setting-admin' // Page
        );  

        add_settings_field(
            'first_color', // ID
            'Colors', // Title 
            array( $this, 'first_color_callback' ), // Callback
            'agile-setting-admin', // Page
            'agile_colors' // Section           
        );  
		
		add_settings_section(
            'agile_header', // ID
            'Agile Header Settings', // Title
            '',
            'agile-setting-admin' // Page
        );  
		add_settings_field(
            'header_border', // ID
            'Header Border', // Title 
            array( $this, 'header_border_callback' ), // Callback
            'agile-setting-admin', // Page
            'agile_header' // Section           
        );  
		
		add_settings_field(
            'main_menu_style', // ID
            'Main Menu Style', // Title 
            array( $this, 'main_menu_style_callback' ), // Callback
            'agile-setting-admin', // Page
            'agile_header' // Section           
        );  
		add_settings_field(
            'search', // ID
            'Display Search', // Title 
            array( $this, 'search_callback' ), // Callback
            'agile-setting-admin', // Page
            'agile_header' // Section           
        );  
		
		add_settings_field(
            'site_logo', 
            'Site Logos', 
            array( $this, 'header_logo_callback' ), 
            'agile-setting-admin', 
            'agile_header'
        );
		
		add_settings_field(
            'site_layout', 
            'Site Layout', 
            array( $this, 'site_layout_type_callback' ), 
            'agile-setting-admin', 
            'agile_colors'
        );
		
		add_settings_field(
            'footer_scripts', // ID
            'Custom Footer Scripts', // Title 
            array( $this, 'footer_scripts_callback' ), // Callback
            'agile-setting-admin', // Page
            'agile_colors' // Section           
        );  
		
		
// Agile Header Page		
		add_settings_section(
            'agile_header', // ID
            'Agile Header Settings', // Title
            '',
            'agile-header-setting-admin' // Page
        ); 
		
		add_settings_field(
            'show_header_row', // ID
            'Show Header Row', // Title 
            array( $this, 'header_row_callback' ), // Callback
            'agile-header-setting-admin', // Page
            'agile_header' // Section           
        );
		
		add_settings_field(
            'settings_header_row', // ID
            'Header Row Content', // Title 
            array( $this, 'header_row_settings_callback' ), // Callback
            'agile-header-setting-admin', // Page
            'agile_header' // Section           
        );
		
//	Agile Footer Page	
		add_settings_section(
            'agile_footer', // ID
            'Agile Footer Settings', // Title
            '',
            'agile-footer-setting-admin' // Page
        );  
		
		add_settings_field(
            'footer_type', // ID
            'Footer type', // Title 
            array( $this, 'footer_type_callback' ), // Callback
            'agile-footer-setting-admin', // Page
            'agile_footer' // Section           
        );
		
		add_settings_field(
            'footer_col_count', // ID
            'Footer Colum Count', // Title 
            array( $this, 'footer_col_count_callback' ), // Callback
            'agile-footer-setting-admin', // Page
            'agile_footer' // Section           
        ); 

		for( $i = 1; $i <= 4; $i++ ){
			add_settings_section(
				'footer_col_'.$i, // ID
				'Footer Colum '.$i, // Title
				'',
				'agile-footer-setting-admin' // Page
			); 
			
			add_settings_field(
				'footer_col_'.$i, // ID
				'Select Colum Type', // Title 
				array( $this, 'footer_col_' . $i . '_callback' ), // Callback
				'agile-footer-setting-admin', // Page
				'footer_col_'.$i // Section           
			);
		}
//Agile Social Page
		add_settings_section(
            'agile_social', // ID
            'Agile Social Settings', // Title
            '',
            'agile-social-setting-admin' // Page
        );
		add_settings_field(
            'social_list', // ID
            'Social list', // Title 
            array( $this, 'social_list_callback' ), // Callback
            'agile-social-setting-admin', // Page
            'agile_social' // Section           
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['first_color'] ) ){
            $color = trim( $input['first_color'] );
			$color = strip_tags( stripslashes( $color ) );
			if( FALSE === $this->check_color( $color ) ) {
				
				add_settings_error( 'first_color', 'first_color_error', 'Insert a valid color', 'error' ); // $setting, $code, $message, $type.
				
				$new_input['first_color'] = $this->options['first_color'];
				
			}else{
				$new_input['first_color'] = $color;
			}
		}
		if( isset( $input['second_color'] ) ){
            $color = trim( $input['second_color'] );
			$color = strip_tags( stripslashes( $color ) );
			if( FALSE === $this->check_color( $color ) ) {
				
				add_settings_error( 'second_color', 'first_color_error', 'Insert a valid color', 'error' ); // $setting, $code, $message, $type.
				
				$new_input['second_color'] = $this->options['second_color'];
				
			}else{
				$new_input['second_color'] = $color;
			}
		}
		if( !empty($input) ){
			foreach( $input as $key => $field ){
				if( $key != 'first_color' && $key != 'second_color' ){
					$add = false;
					if( is_array($field) ){
						foreach($field as $i => $val){
							if( !is_array($val) ){
								if( $i != "img_type"){
									if( !empty($val) && $val != '' ){
										$add = true;
									}				
								}
							}else{
								$add = false;
								foreach( $val as $k => $value){
									if( $k != "img_type"){
										if( !empty($value) && $value != '' ){
											$add = true;
										}				
									}
								}
							}
							if( $add == true ){
								$new_input[$key][$i] = $val;
							}
						}
					}else{
						$val = trim( $field );
						$val = strip_tags( stripslashes( $val ) );
						$new_input[$key] = $val;
					}
				
				
				}
			}
		}
		save_styles($new_input);

        return $new_input;
    }
	
	public function sanitize_header( $input ){
		return $input;
	}
	
	public function sanitize_footer( $input )
    {
		$new_input = array();
		foreach( $input as $key => $field ){
			if( !is_array($field) ){
				$val = trim( $field );
				$val = strip_tags( stripslashes( $val ) );
				if( !empty($val) ){
					$new_input[$key] = $val;
				}
			}else{
				foreach($field as $i => $val){
					$val['value'] = trim( $val['value'] );
					$val['value'] = strip_tags( stripslashes( $val['value'] ) );
					if( ( !empty($val['value']) && $val['value']!='' ) || ( !empty($val['label']) && $val['label']!='' ) ){
						$new_input[$key][$i] = $val;
					}
				}
			}
		}
		return $new_input;
	}	
	
	public function sanitize_social( $input )
    {
		$new_input = array();
		if( !empty($input) ){
			foreach( $input as $key => $field ){
				$add = false;
				foreach($field as $i => $val){
					if( !is_array($val) ){
						if( $i != "img_type"){
							if( !empty($val) && $val != '' ){
								$add = true;
							}				
						}
					}else{
						$add = false;
						foreach( $val as $k => $value){
							if( $k != "img_type"){
								if( !empty($value) && $value != '' ){
									$add = true;
								}				
							}
						}
					}
					if( $add == true ){
						$new_input[$key][$i] = $val;
					}
				}
				
				
			}
		}
		return $new_input;
	}
	
	public function check_color( $value ) { 
      
		if ( preg_match( '/^#[a-f0-9]{6}$/i', $value ) ) { // if user insert a HEX color with #     
			return true;
		}
		  
		return false;
	}

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print '<span>Enter your settings below:</span>';
    }   
	
	/** 
     * Get the settings option array and print one of its values
     */
    public function first_color_callback()
    {
        $str = "";
		$str .= '<label><span>First Color</span><span><input type="text" id="first_color" name="agile_option_name[first_color]" value="' . $this->options['first_color'] . '" class="color" /></span></label><br>';
		$str .= '<label><span>Second Color</span><span><input type="text" id="second_color" name="agile_option_name[second_color]" value="' . $this->options['second_color'] . '" class="color"/></span></label><br>';
		$str .= '<label><span>Background Color</span><span><input type="text" id="background_color" name="agile_option_name[background_color]" value="' . $this->options['background_color'] . '" class="color"/></span></label><br>';
		$str .= '<label><span>Header Background Color</span><span><input type="text" id="header_background_color" name="agile_option_name[header_background_color]" value="' . $this->options['header_background_color'] . '" class="color"/></span></label><br>';
		$str .= '<label><span>Footer Background Color</span><span><input type="text" id="footer_background_color" name="agile_option_name[footer_background_color]" value="' . $this->options['footer_background_color'] . '" class="color"/></span></label><br>';
		$str .= '<label><span>Copyrights Background Color</span><span><input type="text" id="copyrights_background_color" name="agile_option_name[copyrights_background_color]" value="' . $this->options['copyrights_background_color'] . '" class="color"/></span></label><br>';
		printf($str);
    }
	
	/** 
     * Get the settings option array and print one of its values
     */
    public function search_callback()
    {
		if( $this->options['display_search'] == 'Y' ){
			$checked = 'checked';
		}
        printf('<input type="hidden" name="agile_option_name[display_search]" value="N" /><input type="checkbox" name="agile_option_name[display_search]" ' . $checked . ' value="Y" />');
    } 
	
	public function header_border_callback()
    {
		if( $this->options['header_border'] ){
			$checked[$this->options['header_border']] = 'selected';
		}
		$str  = '<select name="agile_option_name[header_border]">';
			$str .= '<option value="none" ' . $checked["none"] . '>None</option>';
			$str .= '<option value="top" ' . $checked["top"] . '>Top</option>';
			$str .= '<option value="bottom" ' . $checked["bottom"] . '>Bottom</option>';
			$str .= '<option value="both" ' . $checked["both"] . '>Both</option>';

		$str .= '</select>';
        printf($str);
    } 
	
	public function main_menu_style_callback()
    {
		if( $this->options['main_menu_style'] ){
			$checked[$this->options['main_menu_style']] = 'selected';
		}
		if( $this->options['main_menu_border_style'] ){
			$checked[$this->options['main_menu_border_style']] = 'selected';
		}
		$str  = '<label><span>Hover Options</span> <select name="agile_option_name[main_menu_style]">';
			$str .= '<option value="default" ' . $checked["default"] . '>Default</option>';
			$str .= '<option value="nav-bg-hover" ' . $checked["nav-bg-hover"] . '>Hover BG</option>';
			$str .= '<option value="nav-top-border-hover" ' . $checked["nav-top-border-hover"] . '>Top Border Hover</option>';
			$str .= '<option value="nav-bottom-border-hover" ' . $checked["nav-bottom-border-hover"] . '>Bottom Border Hover</option>';

		$str .= '</select></label><br>';
		$str .= '<label><span>Border Options</span> <select name="agile_option_name[main_menu_border_style]">';
			$str .= '<option value="no-border" ' . $checked["no-border"] . '>No Border</option>';
			$str .= '<option value="menu-borderd" ' . $checked["menu-borderd"] . '>Border</option>';
			$str .= '<option value="rounded" ' . $checked["rounded"] . '>Rounder Border</option>';
		$str .= '</select></label>';
		
        printf($str);
    }
	
	public function footer_scripts_callback()
    {
		
        printf('<textarea name="agile_option_name[footer_scripts]"  cols="80" rows="10" value="Y" >' . $this->options['footer_scripts'] . '</textarea>');
    }
	
	public function site_layout_type_callback(){
		
		if( isset( $this->options['layout_type'] ) ){
			$selected[$this->options['layout_type']] = 'selected';
		}else{
			$selected['wide'] = 'selected';
		} 
		$output .= '<select name="agile_option_name[layout_type]">';
			$output .= '<option value="wide" ' . $selected['wide'] . '>Wide</option>';
			$output .= '<option value="booked" ' . $selected['booked'] . '>Booked</option>';
		$output .= '</select>';
		
		printf($output);
	}
	

	
	public function header_row_callback()
    {
		if( !isset($this->options['show_header_row']) || empty($this->options['show_header_row']) ) {
			$show = 'N';
		}else{
			$show = $this->options['show_header_row'];
		}
		$input = '<input type="checkbox" value="Y" name="agile_header_option_name[show_header_row]" ' . ( $show == "Y" ? "checked" : "" ) . '>';
        printf($input);
    }
	
	public function header_row_settings_callback()
	{
		$output = "<div class='header-container'>";
			
			$output .= "<textarea name='agile_header_option_name[header_row_content]' class='header_row_content' placeholder='Input text or html to display'>" . ($this->options['header_row_content']) . "</textarea>";
		
		$output .= "</div>";
		printf($output);
	}
	
	
	public function header_logo_callback(){
		
		if( isset( $this->options['logos'] ) ){
			$logos = $this->options['logos'];
		}
		if( empty($logos) ){
			$logos=array(
				'header' => array('img_type' => 'SVG'),
				'footer' => array('img_type' => 'SVG'),
			);
		}elseif( !$logos['header'] ){
			$logos['header'] = array('img_type' => 'SVG');
		}elseif( !$logos['footer'] ){
			$logos['footer'] = array('img_type' => 'SVG');
		}
        $str = "<div class='social-container'>";		
		if( !empty($logos) ){
			foreach($logos as $i => $row){
				$str .= "<p class='social-row box' data-row='" . $i . "' data-name='agile_option_name[logos]'>";
					$str .= "<span class='social_img'>";
						if($row['img']){
							$str .= "<img src='" . $row['img'] . "'><input type='hidden' value='" . $row['img'] . "' name='agile_option_name[logos][".$i."][img]'><i class='dashicons dashicons-edit'></i>";
						}else{
							$str .= "<button class='add_social_img'>Add Header IMG Logo</button>";
						}
					$str .= "</span>";
					$str .= "<span class='social_svg'>";
						if($row['svg']){
							$str .= "<span class='icon'>". $row['svg'] . "</span><input type='hidden' value='" . $row['svg'] . "' name='agile_option_name[logos][".$i."][svg]'><i class='dashicons dashicons-edit'></i>";
						}else{
							$str .="<button class='add_social_svg'>Add Header SVG Logo</button>";
						}
					$str .="</span>";
					$str .= "<span class='social_types'>Select Image Type: <label>SVG <input type='radio' name='agile_option_name[logos][" . $i . "][img_type]' class='img_type' " . ($row['img_type']=='SVG'?'checked':'') . " value='SVG'></label><label>IMG <input class='img_type' type='radio' name='agile_option_name[logos][" . $i . "][img_type]' " . ($row['img_type']=='IMG'?'checked':'') . " value='IMG'></label></span></span>";	
				$str .= "</p>";		
			}
		}
		$str .= "</div>";
		// $str .= "<button class='add_social'>Add Social Service</button>";
		printf($str);
		
	}
	/** 
     * Get the settings option array and print one of its values
     */
    public function social_list_callback()
    {
		if( isset( $this->options['social_services'] ) ){
			$social = $this->options['social_services'];
		}
        $str = "<div class='social-container'>";		
		if( !empty($social) ){
			foreach($social as $i => $row){
				$str .= "<p class='social-row box' data-row='" . $i . "'>";	
				$str .= "<span class='social_col social_col_1'>";
					$str .= "<span class='social_img'>";
						if($row['img']){
							$str .= "<img src='" . $row['img'] . "'><input type='hidden' value='" . $row['img'] . "' name='agile_social_option_name[social_services][".$i."][img]'><i class='dashicons dashicons-edit'></i>";
						}else{
							$str .= "<button class='add_social_img'>Add Social IMG Icon</button>";
						}
					$str .= "</span>";
					$str .= "<span class='social_svg'>";
						if($row['svg']){
							$str .= "<span class='icon'>". $row['svg'] . "</span><input type='hidden' value='" . $row['svg'] . "' name='agile_social_option_name[social_services][".$i."][svg]'><i class='dashicons dashicons-edit'></i>";
						}else{
							$str .="<button class='add_social_svg'>Add Social SVG Icon</button>";
						}
					$str .="</span>";
					$str .= "<span class='social_types'>Select Image Type: <label>SVG <input type='radio' name='agile_social_option_name[social_services][" . $i . "][img_type]' class='img_type' " . ($row['img_type']=='SVG'?'checked':'') . " value='SVG'></label><label>IMG <input class='img_type' type='radio' name='agile_social_option_name[social_services][" . $i . "][img_type]' " . ($row['img_type']=='IMG'?'checked':'') . " value='IMG'></label></span></span>";	
				$str .="</span>";
				$str .= "<span class='social_col social_col_2'>";
					$str .= '<span><label>Name: <input type="text" name="agile_social_option_name[social_services][' . $i . '][name]" value="' .$row['name']. '" placeholder="Social Service Name"></label></span>';
					$str .= '<span><label>Link: <input type="text" name="agile_social_option_name[social_services][' . $i . '][link]" value="' .$row['link']. '" placeholder="Social Service Link"></label></span>';
				$str .="</span>";
				$str .= "<span class='social_col social_col_3'>";
					$str .='<span class="dashicons-before dashicons-arrow-up-alt2"></span><span class="dashicons-before dashicons-arrow-down-alt2"></span><span class="dashicons dashicons-no" onclick="jQuery(this).parents(\'p\').remove()"></span>';
				$str .="</span>";				
				$str .= "</p>";		
			}
		}
		
		$str .= "</div>";
		$str .= "<button class='add_social'>Add Social Service</button>";
		printf($str);
    } 
	
	/** 
     * Get the settings option array and print one of its values
     */
    public function footer_type_callback()
    {
		if( isset( $this->options['footer_type'] ) ){
			$selected[$this->options['footer_type']] = 'selected';
		}else{
			$selected['bg-lite-grey'] = 'selected';
		} 
		
		$select  = '<select name="agile_footer_option_name[footer_type]">';
		$select .= '<option value="bg-lite-grey" ' . $selected['bg-lite-grey'] . '>Default</option>';
		$select .= '<option value="bg-dark" ' . $selected['bg-dark'] . '>Dark</option>';
		$select .= '<option value="bg-light-grey" ' . $selected['bg-light-grey'] . '>Light + Dark</option>';
		$select .= '</select>';
		
        printf( $select );
    }
	
	/** 
     * Get the settings option array and print one of its values
     */
    public function footer_col_count_callback()
    {
		if( isset( $this->options['footer_col_count'] ) ){
			$selected[$this->options['footer_col_count']] = 'selected';
		}else{
			$selected['4'] = 'selected';
		} 
		
		$select  = '<select name="agile_footer_option_name[footer_col_count]" id="count_colums">';
		$select .= '<option value="1" ' . $selected['1'] . '>1</option>';
		$select .= '<option value="2" ' . $selected['2'] . '>2</option>';
		$select .= '<option value="3" ' . $selected['3'] . '>3</option>';
		$select .= '<option value="4" ' . $selected['4'] . '>4</option>';
		$select .= '</select>';
		
        printf( $select );
    }
	
	/** 
     * Get the settings option array and print one of its values
     */
    public function footer_col_1_callback()
    {
		if( isset( $this->options['footer_col_1_type'] ) ){
			$selected[$this->options['footer_col_1_type']] = 'selected';
		}else{
			$selected['text'] = 'selected';
		} 
		
		$select  = '<div class="colum_fields_title"><select name="agile_footer_option_name[footer_col_1_type]" class="colum_type_select" data-id="1">';
		$select .= '<option value="text" ' . $selected['text'] . '>Text/HTML</option>';
		$select .= '<option value="menu" ' . $selected['menu'] . '>Menu</option>';
		$select .= '<option value="map" ' . $selected['map'] . '>Map</option>';
		$select .= '<option value="contacts" ' . $selected['contacts'] . '>Contacts</option>';
		$select .= '<option value="empty" ' . $selected['empty'] . '>Empty</option>';
		$select .= '</select><br>';
		
		$select .= '<input name="agile_footer_option_name[footer_col_1_title]" value="' . $this->options['footer_col_1_title'] . '" placeholder="Input Title of First Colum"></div>';
		
		$select .= '<div class="colum_fields" id="colum_1"> ';
		
		switch($this->options['footer_col_1_type']){
			case 'menu':
				$select .= '<input name="agile_footer_option_name[footer_col_1_menu_name]" value="' . $this->options['footer_col_1_menu_name'] . '" placeholder="Input Menu Name">';
				break;
			case 'map':
				$select .= '<textarea rows="10" name="agile_footer_option_name[footer_col_1_map_script]" placeholder="Input Map Script">' . $this->options['footer_col_1_map_script'] . '</textarea>';
				break;
			case 'contacts':
				$select .= '<div class="contacts_fields">';
				if( isset($this->options['footer_col_1_contacts']) ){
					foreach( $this->options['footer_col_1_contacts'] as $key => $field ){
						$select .= '<p data-row="' . $key . '">';
						$select .= '<input type="hidden" name="agile_footer_option_name[footer_col_1_contacts]['.$key.'][type]" value="'.$field['type'].'">';
						switch( $field['type'] ){
							case 'text':
								$select .= '<input class="single-input" placeholder="Input text" type="text" name="agile_footer_option_name[footer_col_1_contacts]['.$key.'][value]" value="'.$field['value'].'">';
								break;
							case 'label_text':
								$select .= '<input type="text" class="double-input" placeholder="Input label" name="agile_footer_option_name[footer_col_1_contacts]['.$key.'][label]" value="'.$field['label'].'"><input placeholder="Input text" type="text" class="double-input" name="agile_footer_option_name[footer_col_1_contacts]['.$key.'][value]" value="'.$field['value'].'">';
								break;
							case 'social_bar':
								$select .= '<input type="hidden" name="agile_footer_option_name[footer_col_1_contacts]['.$key.'][value]" value="social_bar"> <span class="box">Social Bar</span>';
								break;
							case 'subscribe':
								$select .= '<input type="hidden" name="agile_footer_option_name[footer_col_1_contacts]['.$key.'][value]" value="subscribe"> <span class="box">Subscribe</span>';
								break;
							
						}
						$select .= '<span class="dashicons-before dashicons-arrow-up-alt2"></span><span class="dashicons-before dashicons-arrow-down-alt2"></span>';
						$select .= '</p>';
					}
				}
				$select .= '</div>';
				$select .= '<p><button class="add_prop" data-id="1">Add Field</button></p>';				
				break;
			case 'empty':
				break;
			default:
				$select .= '<textarea rows="10" name="agile_footer_option_name[footer_col_1_text]" placeholder="Input Text to display">' . $this->options['footer_col_1_text'] . '</textarea>';
				break;
		}		
		$select .= '</div>';
        printf( $select );
    }	

    public function footer_col_2_callback()
    {
		if( isset( $this->options['footer_col_2_type'] ) ){
			$selected[$this->options['footer_col_2_type']] = 'selected';
		}else{
			$selected['text'] = 'selected';
		} 
		
		$select  = '<div class="colum_fields_title"><select name="agile_footer_option_name[footer_col_2_type]" class="colum_type_select" data-id="2">';
		$select .= '<option value="text" ' . $selected['text'] . '>Text/HTML</option>';
		$select .= '<option value="menu" ' . $selected['menu'] . '>Menu</option>';
		$select .= '<option value="map" ' . $selected['map'] . '>Map</option>';
		$select .= '<option value="contacts" ' . $selected['contacts'] . '>Contacts</option>';
		$select .= '<option value="empty" ' . $selected['empty'] . '>Empty</option>';
		$select .= '</select><br>';
		
		$select .= '<input name="agile_footer_option_name[footer_col_2_title]" value="' . $this->options['footer_col_2_title'] . '" placeholder="Input Title of Second Colum"></div>';
		
		$select .= '<div class="colum_fields" id="colum_2">';	
		
		switch($this->options['footer_col_2_type']){
			case 'menu':
				$select .= '<input name="agile_footer_option_name[footer_col_2_menu_name]" value="' . $this->options['footer_col_2_menu_name'] . '" placeholder="Input Menu Name">';
				break;
			case 'map':
				$select .= '<textarea rows="10" name="agile_footer_option_name[footer_col_2_map_script]" placeholder="Input Map Script">' . $this->options['footer_col_2_map_script'] . '</textarea>';
				break;
			case 'contacts':
				$select .= '<div class="contacts_fields">';
				if( isset($this->options['footer_col_2_contacts']) ){
					foreach( $this->options['footer_col_2_contacts'] as $key => $field ){
						$select .= '<p data-row="' . $key . '">';
						$select .= '<input type="hidden" name="agile_footer_option_name[footer_col_2_contacts]['.$key.'][type]" value="'.$field['type'].'">';
						switch( $field['type'] ){
							case 'text':
								$select .= '<input class="single-input" placeholder="Input text" type="text" name="agile_footer_option_name[footer_col_2_contacts]['.$key.'][value]" value="'.$field['value'].'">';
								break;
							case 'label_text':
								$select .= '<input type="text" class="double-input" placeholder="Input label" name="agile_footer_option_name[footer_col_2_contacts]['.$key.'][label]" value="'.$field['label'].'"><input placeholder="Input text" type="text" class="double-input" name="agile_footer_option_name[footer_col_2_contacts]['.$key.'][value]" value="'.$field['value'].'">';
								break;
							case 'social_bar':
								$select .= '<input type="hidden" name="agile_footer_option_name[footer_col_2_contacts]['.$key.'][value]" value="social_bar"> <span class="box">Social Bar</span>';
								break;
							case 'subscribe':
								$select .= '<input type="hidden" name="agile_footer_option_name[footer_col_2_contacts]['.$key.'][value]" value="subscribe"> <span class="box">Subscribe</span>';
								break;
							
						}
						$select .= '<span class="dashicons-before dashicons-arrow-up-alt2"></span><span class="dashicons-before dashicons-arrow-down-alt2"></span>';
						$select .= '</p>';
					}
				}
				$select .= '</div>';
				$select .= '<p><button class="add_prop" data-id="2">Add Field</button></p>';
				break;
			case 'empty':
				break;
			default:
				$select .= '<textarea rows="10" name="agile_footer_option_name[footer_col_2_text]" placeholder="Input Text to display">' . $this->options['footer_col_2_text'] . '</textarea>';
				break;
		}		
		$select .= '</div>';
        printf( $select );
    }	
	
	/** 
     * Get the settings option array and print one of its values
     */
    public function footer_col_3_callback()
    {
		if( isset( $this->options['footer_col_3_type'] ) ){
			$selected[$this->options['footer_col_3_type']] = 'selected';
		}else{
			$selected['text'] = 'selected';
		} 
		
		$select  = '<div class="colum_fields_title"><select name="agile_footer_option_name[footer_col_3_type]" class="colum_type_select" data-id="3">';
		$select .= '<option value="text" ' . $selected['text'] . '>Text/HTML</option>';
		$select .= '<option value="menu" ' . $selected['menu'] . '>Menu</option>';
		$select .= '<option value="map" ' . $selected['map'] . '>Map</option>';
		$select .= '<option value="contacts" ' . $selected['contacts'] . '>Contacts</option>';
		$select .= '<option value="empty" ' . $selected['empty'] . '>Empty</option>';
		$select .= '</select><br>';
		
		$select .= '<input name="agile_footer_option_name[footer_col_3_title]" value="' . $this->options['footer_col_3_title'] . '" placeholder="Input Title of Third Colum"></div>';
		
		$select .= '<div class="colum_fields" id="colum_3">';
		
		switch($this->options['footer_col_3_type']){
			case 'menu':
				$select .= '<input name="agile_footer_option_name[footer_col_3_menu_name]" value="' . $this->options['footer_col_3_menu_name'] . '" placeholder="Input Menu Name">';
				break;
			case 'map':
				$select .= '<textarea rows="10" name="agile_footer_option_name[footer_col_3_map_script]" placeholder="Input Map Script">' . $this->options['footer_col_3_map_script'] . '</textarea>';
				break;
			case 'contacts':
				$select .= '<div class="contacts_fields">';
				if( isset($this->options['footer_col_3_contacts']) ){
					foreach( $this->options['footer_col_3_contacts'] as $key => $field ){
						$select .= '<p data-row="' . $key . '">';
						$select .= '<input type="hidden" name="agile_footer_option_name[footer_col_3_contacts]['.$key.'][type]" value="'.$field['type'].'">';
						switch( $field['type'] ){
							case 'text':
								$select .= '<input class="single-input" placeholder="Input text" type="text" name="agile_footer_option_name[footer_col_3_contacts]['.$key.'][value]" value="'.$field['value'].'">';
								break;
							case 'label_text':
								$select .= '<input type="text" class="double-input" placeholder="Input label" name="agile_footer_option_name[footer_col_3_contacts]['.$key.'][label]" value="'.$field['label'].'"><input placeholder="Input text" type="text" class="double-input" name="agile_footer_option_name[footer_col_3_contacts]['.$key.'][value]" value="'.$field['value'].'">';
								break;
							case 'social_bar':
								$select .= '<input type="hidden" name="agile_footer_option_name[footer_col_3_contacts]['.$key.'][value]" value="social_bar"> <span class="box">Social Bar</span>';
								break;
							case 'subscribe':
								$select .= '<input type="hidden" name="agile_footer_option_name[footer_col_3_contacts]['.$key.'][value]" value="subscribe"> <span class="box">Subscribe</span>';
								break;
							
						}
						$select .= '<span class="dashicons-before dashicons-arrow-up-alt2"></span><span class="dashicons-before dashicons-arrow-down-alt2"></span>';
						$select .= '</p>';
					}
				}
				$select .= '</div>';
				$select .= '<p><button class="add_prop" data-id="3">Add Field</button></p>';
				break;
			case 'empty':
				$select .= '';
				break;
			default:
				$select .= '<textarea rows="10" name="agile_footer_option_name[footer_col_3_text]" placeholder="Input Text to display">' . $this->options['footer_col_3_text'] . '</textarea>';
				break;
		}		
		$select .= '</div>';
        printf( $select );
    }	
	
	/** 
     * Get the settings option array and print one of its values
     */
    public function footer_col_4_callback()
    {
		if( isset( $this->options['footer_col_4_type'] ) ){
			$selected[$this->options['footer_col_4_type']] = 'selected';
		}else{
			$selected['text'] = 'selected';
		} 
		
		$select  = '<div class="colum_fields_title"><select name="agile_footer_option_name[footer_col_4_type]" class="colum_type_select" data-id="4">';
		$select .= '<option value="text" ' . $selected['text'] . '>Text/HTML</option>';
		$select .= '<option value="menu" ' . $selected['menu'] . '>Menu</option>';
		$select .= '<option value="map" ' . $selected['map'] . '>Map</option>';
		$select .= '<option value="contacts" ' . $selected['contacts'] . '>Contacts</option>';
		$select .= '<option value="empty" ' . $selected['empty'] . '>Empty</option>';
		$select .= '</select><br>';
		
		$select .= '<input name="agile_footer_option_name[footer_col_4_title]" value="' . $this->options['footer_col_4_title'] . '" placeholder="Input Title of Fours Colum"></div>';
		
		$select .= '<div class="colum_fields" id="colum_4">';	
		
		switch($this->options['footer_col_4_type']){
			case 'menu':
				$select .= '<input name="agile_footer_option_name[footer_col_4_menu_name]" value="' . $this->options['footer_col_4_menu_name'] . '" placeholder="Input Menu Name">';
				break;
			case 'map':
				$select .= '<textarea rows="10" name="agile_footer_option_name[footer_col_4_map_script]" placeholder="Input Map Script">' . $this->options['footer_col_4_map_script'] . '</textarea>';
				break;
			case 'contacts':
				$select .= '<div class="contacts_fields">';
				if( isset($this->options['footer_col_4_contacts']) ){
					foreach( $this->options['footer_col_4_contacts'] as $key => $field ){
						$select .= '<p data-row="' . $key . '">';
						$select .= '<input type="hidden" name="agile_footer_option_name[footer_col_4_contacts]['.$key.'][type]" value="'.$field['type'].'">';
						switch( $field['type'] ){
							case 'text':
								$select .= '<input class="single-input" placeholder="Input text" type="text" name="agile_footer_option_name[footer_col_4_contacts]['.$key.'][value]" value="'.$field['value'].'">';
								break;
							case 'label_text':
								$select .= '<input type="text" class="double-input" placeholder="Input label" name="agile_footer_option_name[footer_col_4_contacts]['.$key.'][label]" value="'.$field['label'].'"><input placeholder="Input text" type="text" class="double-input" name="agile_footer_option_name[footer_col_4_contacts]['.$key.'][value]" value="'.$field['value'].'">';
								break;
							case 'social_bar':
								$select .= '<input type="hidden" name="agile_footer_option_name[footer_col_4_contacts]['.$key.'][value]" value="social_bar"> <span class="box">Social Bar</span>';
								break;
							case 'subscribe':
								$select .= '<input type="hidden" name="agile_footer_option_name[footer_col_4_contacts]['.$key.'][value]" value="subscribe"> <span class="box">Subscribe</span>';
								break;
							
						}
						$select .= '<span class="dashicons-before dashicons-arrow-up-alt2"></span><span class="dashicons-before dashicons-arrow-down-alt2"></span>';
						$select .= '</p>';
					}
				}
				$select .= '</div>';
				$select .= '<p><button class="add_prop" data-id="4">Add Field</button></p>';
				break;
			case 'empty':
				break;
			default:
				$select .= '<textarea rows="10" name="agile_footer_option_name[footer_col_4_text]" placeholder="Input Text to display">' . $this->options['footer_col_4_text'] . '</textarea>';
				break;
		}		
		$select .= '</div>';
        printf( $select );
    }
}

if( is_admin() )
    $my_settings_page = new AgileSettingsPage();