<?php
if(!defined('ABSPATH')) exit;

class Athletes_Manager_Menu {

	public function __construct () {
		add_action( 'admin_menu', array( &$this, 'render' ) );
		add_filter( 'submenu_file', array( &$this, 'filterSubmenu' ) );
	}

	public function render () {
		// Athletes Manager Athletes
		add_menu_page( 
			"Athletes Manager", 
			"Athletes Manager",
			"manage_options", 
			"athletes",
			array($this, 'athletes'),
			"dashicons-businessman", 
			6
		);

		add_submenu_page( 
			"athletes", 
			"Add Athlete", 
			"Add Athlete", 
			"manage_options", 
			"add_athlete", 
			array($this, "add_athlete")
		);

		// Athletes Manager Events
		add_menu_page( 
			"Events Manager", 
			"Events Manager",
			"manage_options", 
			"events",
			array($this, "events"),
			"dashicons-businessman", 
			7
		);

		add_submenu_page( 
			"events", 
			"Add Event", 
			"Add Event", 
			"manage_options", 
			"add_event", 
			array("Athletes_Manager_Add_Event", "render")
		);

		add_submenu_page(
			"events",
			"Event Participants",
			"Event Participants",
			"manage_options",
			"event_participants",
			array($this, 'event_participants')
		);

		add_submenu_page( 
			"events", 
			"Add Bike Check", 
			"Add Bike Check", 
			"manage_options", 
			"add_bike_check", 
			array("Athletes_Manager_Add_Bike_Check", "render")
		);

		// Hidden from the menus 
		add_submenu_page( 
			"athletes", 
			"Athlete Profile", 
			"Athlete Profile", 
			"manage_options", 
			"athlete", 
			array($this, "athlete")
		);

		add_submenu_page(
			"events",
			"Event Details",
			"Event Details",
			"manage_options",
			"event_details",
			array("Athletes_Manager_Event_Details", "render")
		);
	}

	public function filterSubmenu($submenuFile) {
	    global $plugin_page;

	    $hiddenSubmenus = array(
	    	'athlete' => array('hidden' => true, 'parent' => 'athletes'),
	    	'event_details' => array('hidden' => true, 'parent' => 'events'),
	    );

	    if ( $plugin_page && isset( $hiddenSubmenus[ $plugin_page ] ) ) {
	        $submenuFile = $hiddenSubmenus[ $plugin_page ][ 'parent' ];
	    }

	    foreach ( $hiddenSubmenus as $submenu => $unused ) {
	        remove_submenu_page( $unused[ 'parent' ], $submenu );
	    }

		return $submenuFile;
	}

	public function athletes() {
		$page = new Athletes_Manager_Athletes;
		$page->render();
	}

	public function athlete() {
		$page = new Athletes_Manager_Athlete;
		$page->render();
	}

	public function add_athlete() {
		$page = new Athletes_Manager_Add_Athlete;
		$page->render();
	}

	public function events(){
		$page = new Athletes_Manager_Events;
		$page->render();
	}

	public function event_participants () {
		$page = new Athletes_Manager_Event_Participants();
		$page->render();
	}

}
new Athletes_Manager_Menu;