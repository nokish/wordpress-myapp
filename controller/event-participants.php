<?php
add_action( 'plugins_loaded', array( 'Athletes_Manager_Event_Participants_Controller', 'getInstance' ) );

class Athletes_Manager_Event_Participants_Controller {

	public static $instance = null;
	public $model;

	public static function getInstance () {
		error_log("sdasdasdasd");
		null === self::$instance AND self::$instance = new self;
		return self::$instance;
	}

	public function __construct(){
		$this->model = new Athletes_Manager_Event_Participants_Model;

		$this->setAjaxActions();
	}

	public function setAjaxActions () {
		add_action( 'wp_ajax_eventParticipantsDataSet', 		array($this, 'eventParticipantsDataSet') );
		add_action( 'wp_ajax_nopriv_eventParticipantsDataSet', 	array($this, 'eventParticipantsDataSet') );

		add_action( 'wp_ajax_searchParticipantsDataSet', 		array($this, 'searchParticipantsDataSet') );
		add_action( 'wp_ajax_addParticipant', 					array($this, 'addParticipant') );
		add_action( 'wp_ajax_deleteParticipant', 				array($this, 'deleteParticipant') );	
	}

	public function eventParticipantsDataSet() {
		$results = $this->model->getParticipantsDataByEventId($_POST['event_id']);
		// $results = $this->model->getParticipantsDataByEventId($_POST['dataId']);

		$eventParticipants = array();
		foreach($results as $key => $result){
			$athlete = array();
			$athlete['athlete_code'] = $result->athlete_code;
			$athlete['lastname'] = ucwords($result->lastname);
			$athlete['firstname'] = ucwords($result->firstname);
			$athlete['middlename'] = ucwords($result->middlename);
			$athlete['date_added'] = $result->date_added;
			$athlete['action'] = '<span class="athlete-manager-buttons small delete" data-id="' . $result->participant_id . '">Remove</span>';

			array_push($eventParticipants, $athlete);
		}

		echo json_encode($eventParticipants);
		wp_die();
	}

	public function searchParticipantsDataSet() {
		$results = $this->model->searchParticipantsByKeywords($_POST);
		
		$searchResult = array();
		foreach($results as $result){
			$element = array();
			$element['athlete_code'] = $result->athlete_code;
			$element['lastname'] = ucwords($result->lastname);
			$element['firstname'] = ucwords($result->firstname);
			$element['middlename'] = ucwords($result->middlename);
			$element['action'] = '<span class="athlete-manager-buttons small add" data-event_id="'.$_POST['event_id'].'" data-athlete_id="'. $result->id .'">Add</span>';

			if(in_array($_POST['event_id'], explode(",", $result->event_ids))){
				$element['action'] = '<span class="athlete-manager-buttons small added">Added</span>';
			}
			array_push($searchResult, $element);
		}
		
		echo json_encode($searchResult);
		wp_die();
	}

	public function addParticipant() {
		echo json_encode($this->model->add($_POST['event_id'], $_POST['athlete_id']));
		wp_die();
	}

	public function deleteParticipant() {
		echo json_encode($this->model->delete($_POST['dataId']));
		wp_die();
	}

	public function selectOptionsAllEvents () {
		$options = array();
		foreach($this->model->eventsModel->getAll() as $event){
			$options[$event->id] = $event->title;
		}
		return $options;
	}
}