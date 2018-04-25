<?php
// Model
class Athletes_Manager_Event_Participants_Model {

	public $db;
	public $tablename = 'athletes_manager_event_participants';
	public $eventsModel;
	public $athletesModel;

	public function __construct () {
		global $wpdb;
		
		$this->db = $wpdb;
		$this->tablename = $wpdb->prefix . $this->tablename;

		$this->eventsModel = new Athletes_Manager_Events_Model;
		$this->athletesModel = new Athletes_Manager_Athletes_Model;
	}

	public function getParticipantsDataByEventId ($eventId) {
		$sql = $this->db->prepare("SELECT athletes.athlete_code, athletes.lastname, athletes.firstname, athletes.middlename, event_participants.date_added, event_participants.id participant_id FROM `{$this->tablename}` event_participants LEFT JOIN `{$this->athletesModel->tablename}` athletes ON event_participants.athlete_id = athletes.id WHERE event_participants.event_id = '%d'", $eventId);

		return $this->db->get_results($sql);
	}

	public function getEventsByAthleteId ($athleteId) {
		$query = $this->db->prepare("SELECT events.id, events.title FROM `{$this->tablename}` event_participants LEFT JOIN `{$this->eventsModel->tablename}` events ON event_participants.event_id = events.id WHERE event_participants.athlete_id = '%d'", $athleteId);

		return $this->db->get_results($query);
	}

	public function searchParticipantsByKeywords ($keywords) {
		$searchKey = array();
		$searchInput = array();

		if($keywords['athlete_code']){
			array_push($searchKey, "athlete_code = %s");
			array_push($searchInput, $keywords['athlete_code']);
		}

		if($keywords['lastname']){
			array_push($searchKey, "lastname LIKE(%s)");
			array_push($searchInput, "%" . $keywords['lastname'] . "%");
		}

		if($keywords['firstname']){
			array_push($searchKey, "firstname LIKE(%s)");
			array_push($searchInput, "%" . $keywords['firstname'] . "%");
		}

		if($keywords['middlename']){
			array_push($searchKey, "middlename LIKE(%s)");
			array_push($searchInput, $keywords['middlename'] . "%");
		}

		$sql = $this->db->prepare("SELECT athlete.id, GROUP_CONCAT(participants.event_id) event_ids, athlete.athlete_code, athlete.lastname, athlete.firstname, athlete.middlename FROM `{$this->athletesModel->tablename}` athlete LEFT JOIN `{$this->tablename}` participants ON athlete.id = participants.athlete_id WHERE " . implode(" AND ", $searchKey) . " GROUP BY athlete.id", $searchInput);

		return $this->db->get_results($sql);
	}

	public function add ($eventId, $athleteId) {
		$data = array(
			'event_id' 		=> $eventId,
			'athlete_id' 	=> $athleteId,
			'date_added'	=> date("Y-m-d H:i:s")
		);

	    if($this->db->insert($this->tablename, $data)){
        	$return = array(
    			'type' => 'success',
    			'message' => "Athlete successfully added to this event!"
    		);
        }else{
        	$return = array(
				'type' => 'error',
				'message' => "Error while adding athlete to this event!"
			);
        }

        return $return;
	}

	public function delete ($eventParticipantId){
		if($this->db->delete($this->tablename, array("id" => $eventParticipantId))){
			$return = array(
    			'type' => 'success',
    			'message' => "Athlete data successfully remove from this event!"
    		);
        }else{
        	$return = array(
				'type' => 'error',
				'message' => "Error while removing athlete from this event!"
			);
        }

        return $return;
	}

	// public function get_AllEvents(){
	// 	return $this->eventsModel->get_AllEvents();
	// }

}