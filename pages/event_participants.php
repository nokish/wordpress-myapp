<?php 

class Athletes_Manager_Event_Participants extends Athletes_Manager_Event_Participants_Controller {

	private static $helper;

	public function __construct () {
		parent::__construct();

		$this->helper = (object) array('page' => new Athletes_Manager_Page);
	}

	public function render () {
		
		$eventId = $this->helper->page->getRequestParameter("event_id");
		
		echo $this->helper->page->header('Event Participants') . '<hr />';

		echo '<form method="POST" id="show-event-participants-form">';
		wp_nonce_field( 'athlete-manager_event-participants', 'athlete-manager_nonce', basename( __FILE__ ));
		echo '<div class="am-row">';
			echo '<div class="am-col-9">';
				
				$this->helper->page->selectFields('Event', 'event-id', 'event-id', $this->selectOptionsAllEvents(), $eventId);

				echo '<div class="am-row">';
					echo '<div class="am-col-1">&nbsp;</div>';
					echo '<div class="am-col-3">';
						echo '<span class="athlete-manager-buttons" id="event-participants-show-participants-button" >Show Participants</span>';
						echo '<span class="athlete-manager-buttons " id="add-participants-button">Add Participant</span>';
					echo '</div>';  
				echo '</div>';
			echo '</div>';
		echo '</div>';
		echo '</form>';

		echo '<hr />';

		echo '<div class="am-row">';
			echo '<div class="am-col-11">';
			// DataTable - Event Participants
				echo '<table id="event-participants-datatable" class="display" cellspacing="0" width="100%">';
				echo '<thead>';
				$headers = array('Athlete Code', 'Lastname', 'Firstname', 'Middlename', 'Date Added', 'Action');
				$this->helper->page->dataTableHeader($headers);
				echo '</thead>';
				echo '<tfoot>';
				$this->helper->page->dataTableHeader($headers);
				echo '</tfoot>';
				echo '</table>';
				// DataTable - Events Participants - End
			echo '</div>';
		echo '</div>';

		// Modals 
		// Add Event Participants
		echo '<div id="add-event-participants-modal" class="athlete-manager-modal">';
			
			echo '<div class="modal-content add-event-participants">';
				echo '<span class="close" >&times;</span>';
				
				// Modals Content
				echo '<div class="am-row">';
					echo '<form id="event-participants-search-athletes">';
					echo '<h1></h1><hr />';
					echo '<div class="answers am-col-3">';
						$this->helper->page->inputFields('Athlete Code', 'text', 'search-event-participants-athlete-code', 'search-event-participants-athlete-code', "", 4, 7);

						echo '<div class="am-row">';
							echo '<div class="am-col-4"></div>';
							echo '<div class="am-col-7">OR</div>';
						echo '</div>';

						$this->helper->page->inputFields('Lastname', 'text', 'search-event-participants-lastname', 'search-event-participants-lastname', "", 4, 7);
						$this->helper->page->inputFields('Firstname', 'text', 'search-event-participants-firstname', 'search-event-participants-firstname', "", 4, 7);
						$this->helper->page->inputFields('Middlename', 'text', 'search-event-participants-middlename', 'search-event-participants-middlename', "", 4, 7);

						echo '<div class="am-row">';
							echo '<div class="am-col-4"></div>';
							echo '<div class="am-col-7">';
								echo '<span class="athlete-manager-buttons search">Search</span>';
								echo '<span class="athlete-manager-buttons cancel">Cancel</span>';
							echo '</div>'; 
						echo '</div>';
					echo '</div>';
					echo '</form>';

					// Search Result DataTable
					echo '<div class="am-col-8">';
						echo '<table id="search-participants-datatable" class="display" cellspacing="0" width="100%">';
							echo '<thead>';
								$headers = array('Athlete Code', 'Lastname', 'Firstname', 'Middlename', 'Status');
								$this->helper->page->dataTableHeader($headers);
							echo '</thead>';
							echo '<tfoot>';
								$this->helper->page->dataTableHeader($headers);
							echo '</tfoot>';
						echo '</table>';
					echo '</div>';
					// Search Result DataTable - End

				echo '</div>';
				// Model Content End

			echo '</div>';			 
		echo '</div>';
		// Add Event Participant End

		// Event Missing Modal
		echo '<div id="event-id-missing-modal" class="athlete-manager-modal">';
			echo '<div class="modal-content">';
				echo '<span class="close">&times;</span>';
				echo '<div class="am-row">';
					echo '<h1>Error</h1>';
					echo '<div class="question am-col-12">';
						echo 'Event missing, Please choose event first.';
					echo '</div>';
					echo '<div class="answers am-col-12">';
						echo '<span class="ok athlete-manager-buttons">OK</span>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
		// Event Missing Modal End

		// Remove Participants Confirm Modal
		echo '<div id="remove-participant-modal" class="athlete-manager-modal">';
			echo '<div class="modal-content">';
				echo '<span class="close">&times;</span>';
				echo '<div class="am-row">';
					echo '<h1>Confirm</h1>';
					echo '<div class="question am-col-12">';
						echo 'Are you sure you want to remove this participant in this event?';
					echo '</div>';
					echo '<div class="answers am-col-12">';
						echo '<span class="athlete-manager-buttons answer" data-value="yes">Yes</span>';
						echo '<span class="athlete-manager-buttons answer cancel" data-value="cancel">Cancel</span>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
		// Event Missing Modal End
	}
}