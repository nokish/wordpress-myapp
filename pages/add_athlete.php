<?php

class Athletes_Manager_Add_Athlete {

	private static $helper;

	public function __construct (){
		$this->helper = (object) array( 'page' => new Athletes_Manager_Page );
	}

	public function render (){

		echo $this->helper->page->header( 'Add New Athlete' ) . '<hr />';
		
		echo '<form method="POST">';
		wp_nonce_field( 'athlete-manager_add-athlete', 'athlete-manager_nonce', basename( __FILE__ ));

		$this->helper->page->inputFields( null, 'hidden', 'athlete-action', 'athlete-action', 'add' );
		
		echo '<div class="am-row">';
		echo '<div class="am-col-9">';

		echo '<div class="am-row">';
			echo '<div class="am-col-1">Profile Picture</div>';
			echo '<div class="am-col-3">';
				echo '<div id="athlete-manager-profile-picture"><img id="athlete-manager-profile-picture-image" src="' . plugins_url( '../images/default-profile-image.jpg', __FILE__ ) . '" />';
				$this->helper->page->inputFields( null, 'hidden', 'athlete-profile-picture-uri', 'athlete-profile-picture-uri' ); 
				echo '</div>';
			echo '<span class="athlete-manager-buttons" id="athlete-manager-open-webcam">Open Camera</span>';
			echo '</div>'; 
		echo '</div>';
		
		$this->helper->page->inputFields( 'Last Name', 'text', 'athlete-lastname', 'athlete-lastname' );
		$this->helper->page->inputFields( 'First Name', 'text', 'athlete-firstname', 'athlete-firstname' );
		$this->helper->page->inputFields( 'Middle Name', 'text', 'athlete-middlename', 'athlete-middlename' );

		$this->helper->page->selectFields( 'Category', 'athlete-category', 'athlete-category', $this->helper->page->getAthleteOptions('category') );
		$this->helper->page->radioCheckFields( 'Gender', 'radio', 'athlete-gender', 'athlete-gender', $this->helper->page->getAthleteOptions('gender') );
		$this->helper->page->dateFields( 'Birthdate', 'athlete-birthdate' );
		$this->helper->page->inputFields( 'Email Address', 'text', 'athlete-email', 'athlete-email' );
		$this->helper->page->inputFields( 'Mobile Number', 'text', 'athlete-mobile', 'athlete-mobile' );

		echo '<div class="am-row">';
		echo '<div class="am-col-1">&nbsp;</div>';
		echo '<div class="am-col-3"><input class="am-input" type="submit" value="Save" /></div>'; 
		echo '</div>';

		echo '</div>';
		echo '</div>';
		echo '</form>';
		
		$this->helper->page->renderWebcamModal();
	}
}