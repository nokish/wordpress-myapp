<?php

class Athletes_Manager_Events extends Athletes_Manager_Events_Controller {

	private $helper;

	public function __construct() {
		parent::__construct();

		$this->helper = (object) array('page' => new Athletes_Manager_Page);
	}

	public function render() {
	
		echo $this->helper->page->header('Events') . '<span id="athlete-manager-add-event-button" class="athlete-manager-buttons">Add New</span>';
	 	
	 	echo '<div class="am-row">';
		echo '<div class="am-col-8">';

		echo '<hr />';
		echo '<table id="athletes-manager-events-datatable" class="display" cellspacing="0" width="100%">';
		echo '<thead>';

		$headers = array('ID', 'Title', 'Date', 'Status', 'Date Added', 'Last Modified', 'Action(s)');
		$this->helper->page->dataTableHeader($headers);
		echo '</thead>';
		echo '<tbody>';
	    echo $this->renderEvents();
		echo '</tbody>';
		echo '<tfoot>';
		$this->helper->page->dataTableHeader($headers);
		echo '</tfoot>';
		echo '</table>';

		echo '</div>';
	    echo '</div>';

	    echo '<div id="athletes-manager-delete-event-confirm" class="athlete-manager-modal">';
		echo '<div class="modal-content">';
		echo '<span class="close">&times;</span>';
		echo '<div class="am-row">';
		echo '<h1>Confirm</h1>';
		echo '<div class="question am-col-11">';
		echo 'Are you sure you want to delete this event?<hr />';
		echo '</div>';
		echo '<div class="answers am-col-11">';
		echo '<span data-value="yes" class="answer athlete-manager-buttons">Yes</span><span data-value="cancel" class="answer athlete-manager-buttons delete">Cancel</span>';
		echo '</div>';
		echo '</div>';
		echo '</div>';
	}

	public function renderEvents() {
		$output = '';
		$events = $this->getAllEvents();
		foreach ( $events as $event ) {
	    	$output .= '
	    	<tr>
	    	<td class="textAlign-center">' . $event->id . '</td>
	        <td><strong>' . $event->title . '</strong></td>
	        <td>' . $event->date . '</td>
	        <td>' . $event->status . '</td>
	        <td class="textAlign-center">' . $event->date_added . '</td>
	        <td class="textAlign-center">' . $event->last_modified . '</td>
	        <td>
	        	<span class="athlete-manager-buttons small delete" data-id="' . $event->id . '">Delete</span>
	        	<span class="athlete-manager-buttons small view" data-id="'. $event->id .'">View Participants</span>
	        	<span class="athlete-manager-buttons small edit" data-id="' . $event->id . '">Edit</span>
	        	</td>
	        </tr>';
	    }
	    return $output;
	}
}