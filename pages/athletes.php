<?php

class Athletes_Manager_Athletes extends Athletes_Manager_Athletes_Controller {

	private static $helper;

	public function __construct () {
		parent::__construct();
		
		$this->helper = (object) array( 'page' => new Athletes_Manager_Page );
	}

	public function render () {
		echo $this->helper->page->header( 'All Athlete\'s' ); 
		echo '<span id="athlete-manager-add-athlete-button" class="athlete-manager-buttons">Add New</span>';
	 	
	 	echo '<div class="am-row">';
		echo '<div class="am-col-8">';
		echo '<hr />';

		echo '<table id="athletes-manager-athletes-datatable" class="display" cellspacing="0" width="100%">';
		echo '<thead>';

		$headers = array( 'Code', 'Lastname', 'Firstname', 'Middlename', 'Date Added', 'Last Modified', 'Action(s)' );
		$this->helper->page->dataTableHeader( $headers );
		echo '</thead>';
		echo '<tbody>';
	    echo $this->renderAthletes();
		echo '</tbody>';
		echo '<tfoot>';
		$this->helper->page->dataTableHeader( $headers );
		echo '</tfoot>';
		echo '</table>';

	    echo '</div>';
	    echo '</div>';

		// Delete Athlete Confirm Modal
	    echo '<div id="athletes-manager-delete-athlete-confirm" class="athlete-manager-modal">';
			echo '<div class="modal-content">';
				echo '<span class="close">&times;</span>';
			echo '<div class="am-row">';
				echo '<h1>Confirm</h1>';
				echo '<div class="question am-col-11">';
				echo 'Are you sure you want to delete this data?<hr />';
				echo '</div>';
				echo '<div class="answers am-col-11">';
				echo '<span data-value="yes" class="answer athlete-manager-buttons">Yes</span><span data-value="cancel" class="answer athlete-manager-buttons cancel">Cancel</span>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	}

	public function renderAthletes () {
		$outputStr = '';
		foreach ( $this->athletes() as $athlete ) {
	    	$outputStr .= 
	    		'<tr>
		    	 	<td>' . $athlete->athlete_code . '</td>
		    	 	<td>' . ucwords($athlete->lastname, "-") . '</td>
		         	<td>' . ucwords($athlete->firstname) . '</td>
		         	<td>' . ucwords($athlete->middlename) . '</td>
		         	<td>' . $athlete->date_added . '</td>
		         	<td>' . $athlete->last_modified . '</td>
		            <td class="athlete-action">
		            	<span class="athlete-manager-buttons small delete" data-id="' . $athlete->id . '">Delete</span>
		            	<span class="athlete-manager-buttons small view" data-id="' . $athlete->id . '">View Profile</span>
	            	</td>
		         </tr>';
	    }
	    return $outputStr;
	}

}