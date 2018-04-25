<?php
class Athletes_Manager_Events_Model {

	public $db;
	public $tablename = 'athletes_manager_events';

	public function __construct () {
		global $wpdb;
		
		$this->db = $wpdb;
		$this->tablename = $wpdb->prefix . $this->tablename;
	}

	public function getAll() {
		$sql = $this->db->prepare("SELECT * FROM `{$this->tablename}` WHERE %s >= '0'", 'id');
		return $this->db->get_results($sql);
	}

    public function getDataById($id) {
        return $this->db->get_row($this->db->prepare("SELECT * FROM `{$this->tablename}` WHERE id = %d", $id));
    }

	public function insert($data) {
		$format = array('%s', '%s', '%s');
        
        if($this->db->insert($this->tablename, $data, $format))
            return array(
                'type' => 'success',
                'message' => "Event data successfully saved!"
            );
        return array(
            'type' => 'error',
            'message' => "Error while saving the data!!"
        );
    }

    public function edit($data, $where) {
		$format = array('%s', '%s', '%s');
		
        if($this->db->update($this->tablename, $data, $where, $format))
            return array(
                'type' => 'success',
                'message' => "Event data successfully updated!"
            );
        return array(
            'type' => 'error',
            'message' => "Error while updating the data!!"
        );
    }

	public function delete($where) {
        error_log($where);
		if($this->db->delete($this->tablename, $where))
    		return array(
    			'type' => 'success',
    			'message' => "Event successfully deleted!"
    		);	
    	
    	return array(
			'type' => 'error',
			'message' => "Error while deleting the data!!"
		);
	}
	
}