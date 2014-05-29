<?php
/**
 * Plugin Name: xGen Plugin Date Information
 * Plugin URI: http://xgensolutions.in/xgen-plugin-date-information
 * Description: It shows the plugin's Install Date, Last Activated Date, Last Deactivated Date and Plugin Last Update Date. Plus we have given a provision where the user can select which information they want to see and which they don't want to. We have also provided an option to change the column name i.e. user can change the default 'Last Activated Date' to something they want. This plugin helps user to track each and every plugin activation, deactivation, install and if they know fom what date and time they are facing the problem then with this provided information they will have ideas as which plugin is facing the problem.
 * Version: 1.0
 * Author: xGen Solutions
 * Author URI: http://xgensolutions.in
 * License: GPL2
 */
class xGenPluginDateInfo {

	public function __construct() {	
		//error_reporting(0);
		//ini_set('display_errors', 0);	

		add_filter('admin_init',							array($this,'xgenpc_add_option'));
		add_action('activate_plugin', 						array($this,'xgenpc_activate_plugin_status'));
		add_action('deactivate_plugin',						array($this,'xgenpc_deactive_plugin_status'));
		add_filter('manage_plugins_columns', 				array($this,'xgenpc_date_columns'));
        add_action('manage_plugins_custom_column',			array($this,'xgenpc_show_date_column'),10,3);
		add_filter('plugin_row_meta', 						array($this,'xgenpc_plugin_meta'), 10, 2 );
		add_action('admin_menu', 							array($this,'register_xgen_plugin_date_info_menu'));
	}

	function register_xgen_plugin_date_info_menu(){
		$page_value = add_menu_page('xGen Plugin Date Information | Shows Install,Active,Deactive and Plugin Update Date', 'xGen Plugin Date Information', 'edit_private_pages', 'xgen_plugin_date_information', array($this,'set_xgen_plugin_date_info_setting'));
		add_action('admin_print_styles-' . $page_value, array($this,'xgen_pdi_load_stylesheet'));
	}

	function xgen_pdi_load_stylesheet(){
		 wp_enqueue_style('xgen_plugin_data_stylesheet');
	}

	public function set_xgen_plugin_date_info_setting(){
		if(isset($_POST) && !empty($_POST)){
			$install_date_value			=	strip_tags(esc_sql($_POST['install_date_value']));
		    $activated_date_value		=	strip_tags(esc_sql($_POST['activated_date_value']));
		    $deactivated_date_value 	=   strip_tags(esc_sql($_POST['deactivated_date_value']));
		    $updated_date_value			=	strip_tags(esc_sql($_POST['updated_date_value']));
		    $install_column_text		=	strip_tags(esc_sql($_POST['install_column_text']));
		    $activated_column_text		=	strip_tags(esc_sql($_POST['activated_column_text']));
		    $deactivated_column_text	=	strip_tags(esc_sql($_POST['deactivated_column_text']));
		    $update_column_text			=   strip_tags(esc_sql($_POST['update_column_text']));

		    update_option('install_date_value',$install_date_value);
		    update_option('activated_date_value',$activated_date_value);
		    update_option('deactivated_date_value',$deactivated_date_value);
		    update_option('updated_date_value',$updated_date_value);
		    update_option('install_column_text',$install_column_text);
		    update_option('activated_column_text',$activated_column_text);
		    update_option('deactivated_column_text',$deactivated_column_text);
		    update_option('update_column_text',$update_column_text);
		    $message = 'Settings have been successfully saved';
		}

		include('xgen_set_plugin_setting_form.php');
	}

	public function xgenpc_activate_plugin_status($plugin_name){
		$plugin_info 			= unserialize(get_option('xgenpc_plugin_activate_date'));
		$plugin_info[$plugin_name] 	= array(
							'status' 	=>'activated',
							'timestamp' 	=> current_time('timestamp')
						);
		
		update_option('xgenpc_plugin_activate_date',serialize($plugin_info));
	}

	public function xgenpc_deactive_plugin_status($plugin_name){
		$plugin_info 			= unserialize(get_option('xgenpc_plugin_deactivate_date'));
		$plugin_info[$plugin_name] 	= array(
							'status' 	=> 'deactivated',
							'timestamp' 	=> current_time('timestamp')
						);
		update_option('xgenpc_plugin_deactivate_date',serialize($plugin_info));
	}


	public function xgenpc_add_option(){
		add_option('xgenpc_plugin_activate_date');
		add_option('xgenpc_plugin_deactivate_date');
		add_option('install_date_value');
	    add_option('activated_date_value');
	    add_option('deactivated_date_value');
	    add_option('updated_date_value');
	    add_option('install_column_text');
	    add_option('activated_column_text');
	    add_option('deactivated_column_text');
	    add_option('update_column_text');
		wp_register_style('xgen_plugin_data_stylesheet', plugins_url('xgen_plugin_date_info/css/style.css'));
	}

	public function xgenpc_date_columns( $columns ) {
		if(get_option('install_date_value')=='yes'){
			if(get_option('install_column_text')=='')
			{
				$display_text = 'Install Date';
			}else{
				$display_text = get_option('install_column_text');
			}
			$columns['first_activated_date'] 	= $display_text;	
		}

	    if(get_option('activated_date_value')=='yes'){
	    	if(get_option('activated_column_text')=='')
			{
				$display_text = 'Last Activated';
			}else{
				$display_text = get_option('activated_column_text');
			}
			$columns['last_activated_date'] 	= $display_text;	
		}
		
		if(get_option('deactivated_date_value')=='yes'){
			if(get_option('deactivated_column_text')=='')
			{
				$display_text = 'Last Deactivated';
			}else{
				$display_text = get_option('deactivated_column_text');
			}
			$columns['last_deactivated_date'] 	= $display_text;
		}
		return $columns;
	}

	public function xgenpc_show_date_column( $column_name, $plugin_file, $plugin_data ) {
		switch ( $column_name ) {
			case 'last_activated_date':
				$plugin_date_column = unserialize(get_option('xgenpc_plugin_activate_date'));
				$current_plugin = $plugin_date_column[$plugin_file];
				if (! empty($current_plugin['timestamp']))
					echo $this->xgenpc_format_date_value($current_plugin['timestamp']);
				else
					echo "---";
				break;
			case 'last_deactivated_date':
				$plugin_date_column = unserialize(get_option('xgenpc_plugin_deactivate_date'));
				$current_plugin = $plugin_date_column[$plugin_file];
				if ( ! empty($current_plugin['timestamp']) && $current_plugin['status'] == 'deactivated' )
					echo  $this->xgenpc_format_date_value($current_plugin['timestamp']);
				else
					echo "---";
				break;
			case 'first_activated_date':					
				$plugin_path 		= plugins_url( '' ,$plugin_file );
				$plugin_folder_array	= explode('/plugins/',$plugin_path);	
				if(isset($plugin_folder_array[1])){
					$stat = stat(ABSPATH . 'wp-content/plugins/'.$plugin_folder_array[1]);	
					if(isset($stat['ctime'])){
						echo $this->xgenpc_format_date_value($stat['ctime']);								
					}else{
						echo "---";
					}
				}else{
					echo "---";		
				}
				break;
				
		}
	}

	public function xgenpc_plugin_last_update($plugin_file){
		list($plugin_slug) 	= explode( '/', $plugin_file);
		$slug_hash 		= md5($plugin_slug);
		$last_updated_date 	= get_transient( "xgenpc_{$slug_hash}" );
		if ( false === $last_updated_date ) {
			$last_updated_date = $this->xgenpc_fetch_last_update($plugin_slug);
			if(empty($last_updated_date)){
				$plugin_slug_array 	= explode('/',$plugin_data['PluginURI']);
				$plugin_slug		= $plugin_slug_array[count($plugin_slug_array)-2];
				$last_updated_date	= $this->xgenpc_fetch_last_update($plugin_slug);
			}
			set_transient( "xgenpc_{$slug_hash}", $last_updated_date, 86400 );
		}
		return $last_updated_date;
	}

	public function xgenpc_plugin_meta($plugin_meta, $plugin_file)
	{
		if(get_option('updated_date_value')=='yes'){
			if(get_option('update_column_text')==''){
				$display_text = 'Last upadated on:';
			}else{
				$display_text = get_option('update_column_text');
			}
			$plugin_meta['last_updated'] = "<b>$display_text</b> ".$this->xgenpc_format_date_value(strtotime($this->xgenpc_plugin_last_update($plugin_file)),'yes');
			return $plugin_meta;
		}
	}
	public function xgenpc_format_date_value($unix_time_stamp,$is_last_updated=''){
		if($is_last_updated=='')	
			return date_i18n(sprintf( '%s   %s', get_option('date_format'), get_option('time_format') ), $unix_time_stamp);
		else
			return date_i18n(sprintf( '%s ', get_option('date_format')), $unix_time_stamp);
	}

	function xgenpc_fetch_last_update( $plugin_name ) {
		$request = wp_remote_post(
			'http://api.wordpress.org/plugins/info/1.0/',
			array(
				'body' => array(
					'action' => 'plugin_information',
					'request' => serialize(
						(object) array(
							'slug' => $plugin_name,
							'fields' => array( 'last_updated' => true )
						)
					)
				)
			)
		);
		if (200 != wp_remote_retrieve_response_code($request))
			return false;

		$response = unserialize(wp_remote_retrieve_body($request));

		// Return an empty but cachable response if the plugin isn't in the .org repo
		if (empty($response))
			return '';
		if (isset($response->last_updated))
			return sanitize_text_field($response->last_updated);

		return false;
	}
}

$obj = new xGenPluginDateInfo();

