<?php
add_action( 'plugins_loaded', array( 'Athletes_Manager_Events_Controller', 'getInstance' ) );

class Athletes_Manager_Events_Controller {

	public static $instance;
	public $model;

	public static function getInstance () {
		null === self::$instance AND self::$instance = new self;
		return self::$instance;
	}

	public function __construct () {
		$this->model = new Athletes_Manager_Events_Model;

		$this->setAjaxActions();

		add_action( 'admin_enqueue_scripts', array( $this, 'localizedJavaScript' ) );
	}

	public function setAjaxActions () {
		add_action( 'wp_ajax_deleteEvent', array( $this, 'delete' ) );
	}

	public function localizedJavaScript () {
		$actionUrls = array(
			'view' => menu_page_url('event_participants', false) . '&event_id=',
			'edit' => menu_page_url('event_details', false) . '&action=edit&event_id=' 
		);

		wp_localize_script( "athletes-manager-events-script", 'actionUrls', $actionUrls);
	}

	public function add() {
		$data = array(
			'title' 		=> $_POST['event-title'],
			'date'			=> implode(array(
				$_POST['event-date-year'],
				$_POST['event-date-month'],
				$_POST['event-date-day']), "-"),
			'status' 		=> $_POST['event-status'],
			'date_added'	=> date("Y-m-d H:i:s"),
			'last_modified' => date("Y-m-d H:i:s")
		);

		return $this->model->insert($data);
	}

	public function edit() {
		$data = array(
			'title' 		=> $_POST['event-title'],
			'date'			=> implode(array(
				$_POST['event-date-year'],
				$_POST['event-date-month'],
				$_POST['event-date-day']), "-"),
			'status' 		=> $_POST['event-status'],
			'last_modified' => date("Y-m-d H:i:s")  
		);
		$where = array( 'id' => $_POST['event-id'] );

		return $this->model->edit($data, $where);
	}

	public function delete() {
		echo json_encode( $this->model->delete(array("id" => $_POST['dataId'])));
	}

	public function getAllEvents() {
		return $this->model->getAll();
	}
		
}