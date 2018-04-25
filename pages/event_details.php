<?php

class Athletes_Manager_Event_Details extends Athletes_Manager_Page {

	public function render () {

		$eventId = self::getRequestParameter("event_id");
		$event = self::getEventDetailsById($eventId);
		
		echo self::header('Event Details') . '<hr />';
		echo '<form method="POST">';
		wp_nonce_field( 'athlete-manager_edit-event', 'athlete-manager_nonce', basename( __FILE__ ));

		self::inputFields(null, 'hidden', 'event-action', 'event-action', "edit");
		self::inputFields(null, 'hidden', 'event-id', 'event-id', $event->id);

		echo '<div class="am-row">';
		echo '<div class="am-col-9">';

		self::inputFields('Title', 'text', 'event-title', 'event-title', $event->title);
		self::dateFields('Event Date', 'event-date', $event->date);

		$options = array(
			'in-progress' => 'In Progress',
			'done' => 'Done',
			'on-hold' => 'On Hold'
		);
		self::selectFields('Status', 'event-status', 'event-status', $options, $event->status);

		echo '<div class="am-row">';
		echo '<div class="am-col-1">&nbsp;</div>';
		echo '<div class="am-col-3"><input class="am-input" type="submit" value="Update" /></div>'; 
		echo '</div>';

		echo '</div>'; //  main col
		echo '</div>'; // main row
		echo '</form>';
	}

	public function getEventDetailsById ($id) {
		$events = new Athletes_Manager_Events_Model;
		return $events->getDataById($id);
	}
}