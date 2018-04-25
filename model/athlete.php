<?php 

class Athletes_Manager_Athlete_Model {
	
	private $db;
	private $athletes;
	private $id;
	private $eventParticipants;
	
	public function __construct() {
		global $wpdb;
		$this->db = $wpdb;
		
		$this->athletes = new Athletes_Manager_Athletes_Model;
		$this->eventParticipants = new Athletes_Manager_Event_Participants_Model;
	}

	public function setId($athleteId) {
		$this->id = $athleteId;
	}

	public function getData() {
		$data = (array) $this->athletes->getAthleteById($this->id);
		$data['events'] = $this->eventParticipants->getEventsByAthleteId($this->id); 
		
		return (object) $data;
	}

}