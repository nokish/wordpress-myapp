<?php

class Athletes_Manager_Athletes_Model {
	
	public $db;
	public $tablename = "athletes_manager_athletes";
	public $eventParticipants;

	public function __construct() {
		global $wpdb;

		$this->db = $wpdb;
		$this->tablename = $wpdb->prefix . "athletes_manager_athletes";
	}

	public function getAll($columns) {
		$query = $this->db->prepare("SELECT {$columns} FROM `{$this->tablename}` WHERE %d >= '0'", 'id');
	    return $this->db->get_results($query);
	}

	public function getAthleteById($id) {		
		$query = $this->db->prepare("SELECT * FROM `{$this->tablename}` WHERE id = '%d'", $id);
		return $this->db->get_row($query);
	}

	public function insert ($data) {
		if( $this->db->insert( $this->tablename, $data ) ){
			$dataUpdate = array(
				'athlete_code' => Athletes_Manager_Athletes_Controller::createAthleteCode( 
					$data['birthdate'], 
					$data['mobile_number'], 
					$this->db->insert_id 
				)
			);

			$this->db->update( 
				$this->tablename, 
				$dataUpdate , 
				array( 'id' => $this->db->insert_id ) 
			);
				
			return array(
		        'type' => 'success',
		        'message' => "Athlete data successfully saved!"
		    );
		}

		return array(
		    'type' => 'error',
		    'message' => "Error while saving the data!!"
		);

    }

    public function update ($data, $where) {
        if( $this->db->update( $this->tablename, $data, $where ) ){
        	return array(
                'type' => 'success',
                'message' => "Athlete data successfully updated!"
            );
        }

        return array(
            'type' => 'error',
            'message' => "Error while updating the data!!"
        );    
    }

    public function delete ( $where ) {
        if( $this->db->delete( $this->tablename, $where ) ){
        	return array(
    			'type' => 'success',
    			'message' => "Athlete data successfully deleted!"
    		);
        }

    	return array(
			'type' => 'error',
			'message' => "Error while deleting the data!!"
		);
    }
}