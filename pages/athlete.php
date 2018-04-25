<?php

class Athletes_Manager_Athlete extends Athletes_Manager_Athlete_Controller {

	private static $helper;
	
	public function __construct () {
		$this->helper = (object) array( 'page' => new Athletes_Manager_Page);
		$athleteId = $this->helper->page->getRequestParameter("athlete_id");
		
		parent::__construct($athleteId);
	}

	public function render () {
		$athlete = parent::athlete();

		echo $this->helper->page->header('Athlete Profile') . '<hr />';
		echo '<form method="POST">';
		wp_nonce_field( 'athlete-manager_edit-athlete', 'athlete-manager_nonce', basename( __FILE__ ));

		$this->helper->page->inputFields(null, 'hidden', 'athlete-action', 'athlete-action', "edit");
		$this->helper->page->inputFields(null, 'hidden', 'athlete-id', 'athlete-id', $athlete->id);

		echo '<div class="am-row">';
		echo '<div class="am-col-3">';

		echo '<div class="am-row">';
		echo '<div class="am-col-3">Athlete Code</div>';
		echo '<div class="am-col-8 athlete-code">'. $athlete->athlete_code .'</div>';
		echo '</div>';

		echo '<div class="am-row">';
			echo '<div class="am-col-3">Profile Picture</div>';
			echo '<div class="am-col-8">';
			echo '<div id="athlete-manager-profile-picture">';
				echo '<img id="athlete-manager-profile-picture-image" src="' . $this->helper->page->isProfilePictureExists($athlete->profile_picture) . '" />';
				$this->helper->page->inputFields(null, 'hidden', 'athlete-profile-picture-uri', 'athlete-profile-picture-uri', $athlete->profile_picture, 3, 8);
			echo '</div>';
			echo '<span class="athlete-manager-buttons" id="athlete-manager-open-webcam">Replace</span>'; 
			echo '</div>';
		echo '</div>'; 
		
		$this->helper->page->inputFields('Last Name', 'text', 'athlete-lastname', 'athlete-lastname', $athlete->lastname, 3, 8);
		$this->helper->page->inputFields('First Name', 'text', 'athlete-firstname', 'athlete-firstname', $athlete->firstname, 3, 8);
		$this->helper->page->inputFields('Middle Name', 'text', 'athlete-middlename', 'athlete-middlename', $athlete->middlename, 3, 8);

		$this->helper->page->selectFields('Category', 'athlete-category', 'athlete-category', $this->helper->page->getAthleteOptions('category'), $athlete->category, 3, 8);
		$this->helper->page->radioCheckFields('Gender', 'radio', 'athlete-gender', 'athlete-gender', $this->helper->page->getAthleteOptions('gender'), $athlete->gender, 3, 8);
		
		$this->helper->page->dateFields('Birthdate', 'athlete-birthdate', $athlete->birthdate, 3, 8);
		$this->helper->page->inputFields('Email Address', 'text', 'athlete-email', 'athlete-email', $athlete->email_address, 3, 8);
		$this->helper->page->inputFields('Mobile Number', 'text', 'athlete-mobile', 'athlete-mobile', $athlete->mobile_number, 3, 8);

		echo '<div class="am-row">';
		echo '<div class="am-col-3">&nbsp;</div>';
		echo '<div class="am-col-8"><input class="am-input" type="submit" value="Update" /></div>'; 
		echo '</div>';

		echo '</div>'; //  main col

		echo '<div class="am-col-3">';
		echo 'Events';
		self::renderAthleteEvents($athlete->events);
		echo '</div>';		

		echo '</div>'; // main row
		echo '</form>';

		$this->helper->page->renderWebcamModal();
	}

	public function renderAthleteEvents ($events) {
		$eventsString = '<br />';
		foreach($events as $event){
			$eventsString .= '<span class="athlete-manager-buttons athlete-profile-event-title" data-event-id="'. $event->id .'">' . $event->title . '</span>';
		}
		echo $eventsString;
	}
}