<?php

class Athletes_Manager_Athlete_Controller {
	
	public $model;

	public function __construct($athleteId) {
		$this->model = new Athletes_Manager_Athlete_Model();
		$this->model->setId($athleteId);
	}

	public function athlete() {
		return $this->model->getData();
	}

}