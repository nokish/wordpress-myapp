<?php

// class Athletes_Manager_Ajax_Request {

// 	public function __construct() {
// 		add_action( 'wp_ajax_eventParticipantsShowParticipants', 	array($this, 'eventParticipantsShowParticipants') );
// 		add_action( 'wp_ajax_eventParticipantsSearchParticipants', 	array($this, 'eventParticipantsSearchParticipants') );
// 		add_action( 'wp_ajax_eventParticipantsAddParticipant', 		array($this, 'eventParticipantsAddParticipant') );
// 		add_action( 'wp_ajax_eventParticipantsDeleteParticipant', 	array($this, 'eventParticipantsDeleteParticipant') );
// 	}

// 	public function eventParticipantsShowParticipants() {
// 		global $wpdb;

// 		$sql = $wpdb->prepare("SELECT athletes.athlete_code, athletes.lastname, athletes.firstname, athletes.middlename, event_participants.date_added, event_participants.id participant_id FROM `wp_athletes_manager_event_participants` event_participants LEFT JOIN `wp_athletes_manager_athletes` athletes ON event_participants.athlete_id = athletes.id WHERE event_participants.event_id = %s", $_POST['eventId']);
// 		$results = $wpdb->get_results($sql);

// 		$athletes = array();
// 		foreach($results as $key => $result){
// 			$athlete = array();
// 			$athlete['action'] = '<span title="Delete" data-event_participant_id="' . $result->participant_id . '" class="dashicons dashicons-trash delete-event-participant"></span>';
// 			$athlete['athlete_code'] = $result->athlete_code;
// 			$athlete['lastname'] = ucwords($result->lastname);
// 			$athlete['firstname'] = ucwords($result->firstname);
// 			$athlete['middlename'] = ucwords($result->middlename);
// 			$athlete['date_added'] = $result->date_added;
// 			array_push($athletes, $athlete);
// 		}
// 		echo json_encode($athletes);
// 	}

// 	public function eventParticipantsSearchParticipants() {
// 		global $wpdb;
		
// 		$sqlString = array();
// 		if($_POST['athleteCode']){
// 			array_push($sqlString, "athlete_code = '" . trim($_POST['athleteCode']) . "'");
// 		}

// 		if($_POST['lastname']){
// 		array_push($sqlString, "lastname LIKE('" . trim($_POST['lastname']) . "%')");
// 		}

// 		if($_POST['firstname']){
// 			array_push($sqlString, "firstname LIKE('" . trim($_POST['firstname']) . "%')");
// 		}	

// 		if($_POST['middlename']){
// 			array_push($sqlString, "middlename LIKE('" . trim($_POST['middlename']) . "%')");
// 		}
	
// 		$sql = "SELECT athlete.id, GROUP_CONCAT(participants.event_id) event_ids, athlete.athlete_code, athlete.lastname, athlete.firstname, athlete.middlename FROM wp_athletes_manager_athletes athlete LEFT JOIN wp_athletes_manager_event_participants participants ON athlete.id = participants.athlete_id WHERE " . implode(" AND ", $sqlString) . " GROUP BY athlete.id";
// 		$results = $wpdb->get_results($wpdb->prepare($sql, ""));
		
// 		$objArray = array();
// 		foreach($results as $result){
// 			$insert = array();
// 			$insert['athlete_code'] = $result->athlete_code;
// 			$insert['lastname'] = ucwords($result->lastname);
// 			$insert['firstname'] = ucwords($result->firstname);
// 			$insert['middlename'] = ucwords($result->middlename);

// 			$insert['action'] = '<span class="athlete-manager-buttons-small add-event-participant-button" data-event_id="'.$_POST['eventId'].'" data-athlete_id="'. $result->id .'">Add</span>';
// 			if(in_array($_POST['eventId'], explode(",", $result->event_ids))){
// 				$insert['action'] = '<span class="athlete-manager-buttons-small added">Added</span>';
// 			}
// 			array_push($objArray, $insert);
// 		}
		
// 		echo json_encode($objArray);
// 	}

// 	public function eventParticipantsAddParticipant() {
// 		global $wpdb;

// 		$data = array(
// 			'event_id' 		=> $_POST['eventId'],
// 			'athlete_id' 	=> $_POST['athleteId'],
// 			'date_added'	=> date("Y-m-d H:i:s")
// 		);

// 	    if($wpdb->insert('wp_athletes_manager_event_participants', $data)){
//         	return true;		
//         }
//         return false;
// 	}

// 	public function eventParticipantsDeleteParticipant() {
// 		global $wpdb;

// 		if($wpdb->delete('wp_athletes_manager_event_participants', array("id" => $_POST['eventParticipantId']))){
// 			return true;
// 		}
// 	    return false;	
// 	}

	
// }
// new Athletes_Manager_Ajax_Request;