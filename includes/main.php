<?php
/*
* This file is mainly for the common functions used in the plugin
*/
if(!defined('ABSPATH')) exit;

class Athletes_Manager_Main {

	public function checkPostMetaData () {

		if(key_exists('athlete-action', $_POST)){
			$keyword = 'athlete';
			$controller = new Athletes_Manager_Athletes_Controller;
			$controller->getInstance();
		}

		if(key_exists('event-action', $_POST)){
			$keyword = 'event';
			$controller = new Athletes_Manager_Events_Controller;
		}

		$action = $_POST["{$keyword}-action"];

		if($action and self::verifyNonce($action, $keyword)) {
			$result = $controller->{$action}();	
		}
		
		if($result)
			add_action('admin_notices', function() use ($result){
				 self::showNotice($result);
			});
			
	}

	public function verifyNonce($action, $keyword) {
		
		if(!in_array($keyword, array('add', 'edit')))
			return true;

		else
			if (isset($_POST['athlete-manager_nonce']) || wp_verify_nonce($_POST['athlete-manager_nonce'], "athlete-manager_{$action}-{$keyword}"))
				return true;
			else
				return false;
	}

	public function showNotice ($args, $is_dismissible = true) {
		$is_dismissible_setting = 'is-dismissible';

		if(!$is_dismissible) 
			$is_dismissible_setting = '';
		
		echo '<div class="notice notice-' . $args['type'] . ' ' . $is_dismissible_setting . ' ">';
		echo '<p>' . $args['message'] . '</p>';
		echo '</div>';
	}

}
add_action('admin_init', array('Athletes_Manager_Main', 'checkPostMetaData'));