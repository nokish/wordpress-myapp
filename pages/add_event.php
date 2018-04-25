<?php

class Athletes_Manager_Add_Event extends Athletes_Manager_Page {

	private $db;
	protected $tablename = "athletes_manager_events";

	public function __construct(){
		global $wpdb;

		$this->db = $wpdb;
	}

	public function render() {
		echo self::header('Add Event') . '<hr />';

		echo '<form method="POST">';
		wp_nonce_field( 'athlete-manager_add-event', 'athlete-manager_nonce', basename( __FILE__ ));

		echo '<div class="am-row">';
		echo '<div class="am-col-9">';

		self::inputFields(null, 'hidden', 'event-action', 'event-action', 'add');
		self::inputFields('Event Title', 'text', 'event-title', 'event-title');
		self::dateFields('Event Date', 'event-date');
		
		$options = array(
			'in-progress' => 'In Progress',
			'done' => 'Done',
			'on-hold' => 'On Hold'
		);
		self::selectFields('Status', 'event-status', 'event-status', $options);

		echo '<div class="am-row">';
		echo '<div class="am-col-1">&nbsp;</div>';
		echo '<div class="am-col-3"><input class="am-input" type="submit" value="Save" /></div>'; 
		echo '</div>';

		echo '</div>';
		echo '</div>';
		echo '</form>';

	}

	
}