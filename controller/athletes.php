<?php
add_action( 'plugins_loaded', array( 'Athletes_Manager_Athletes_Controller', 'getInstance' ) );

class Athletes_Manager_Athletes_Controller {

	public static $instance;
	public $model;

	public static function getInstance () {
		null === self::$instance AND self::$instance = new self;
		return self::$instance;
	}

	public function __construct () {
		$this->model = new Athletes_Manager_Athletes_Model;

		$this->setAjaxActions();

		add_action( 'admin_enqueue_scripts', array( $this, 'localizedJavaScript' ) );
	}

	public function setAjaxActions () {
		add_action( 'wp_ajax_deleteAthlete', array( $this, 'delete' ) );
	}

	public function localizedJavaScript () {
		$actionUrls = array(
			'view' => menu_page_url( 'athlete', false ) . '&athlete_id='
		);

		wp_localize_script( "athletes-manager-athletes-script", 'actionUrls', $actionUrls);
	}

	public function athletes () {
		$columns = array(
			'id',
			'athlete_code',
			'lastname',
			'firstname',
			'middlename',
			'date_added',
			'last_modified'
		);

		return $this->model->getAll( implode( $columns, "," ) );
	}

	public function add () {
		$data = array(
			'lastname' 		=> $_POST['athlete-lastname'],
			'firstname' 	=> $_POST['athlete-firstname'],
			'middlename' 	=> $_POST['athlete-middlename'],
			'category' 		=> $_POST['athlete-category'],
			'gender' 		=> $_POST['athlete-gender'],
			'birthdate' 	=> $this->renderDateValue( $_POST, 'athlete-birthdate' ),
			'email_address' => $_POST['athlete-email'],
			'mobile_number' => $_POST['athlete-mobile'],
			'date_added'	=> date("Y-m-d H:i:s"),
			'last_modified' => date("Y-m-d H:i:s"),
            'profile_picture' => $_POST['athlete-profile-picture-uri']
		);

		$filename = $this->createProfilePictureFilename(
			array(
				$data['lastname'], 
				$data['firstname'], 
				$data['middlename']
			) 
		);

        if( file_put_contents( $filename, base64_decode( $data['profile_picture'] ) ) ){
        	return $this->model->insert($data);
        }

        return array(
            'type' => 'error',
            'message' => "Error while saving the profile picture, Check file permission!!"
        );
	}

	public function edit () {
		$data = array(
			'lastname' 		=> $_POST['athlete-lastname'],
			'firstname' 	=> $_POST['athlete-firstname'],
			'middlename' 	=> $_POST['athlete-middlename'],
			'category' 		=> $_POST['athlete-category'],
			'gender' 		=> $_POST['athlete-gender'],
			'birthdate' 	=> $this->renderDateValue( $_POST, 'athlete-birthdate' ),
			'email_address' => $_POST['athlete-email'],
			'mobile_number' => $_POST['athlete-mobile'],
			'last_modified' => date("Y-m-d H:i:s"),
            'profile_picture' => $_POST['athlete-profile-picture-uri']  
		);

    	$where = array( 'id' => $_POST['athlete-id'] );
    	
		$filename = $this->createProfilePictureFilename(
			array(
				$data['lastname'], 
				$data['firstname'], 
				$data['middlename']
			)
		);

        if(file_put_contents( $filename, base64_decode( $data['profile_picture'] ) )){
    		return $this->model->update($data, $where);
        }

        return array(
            'type' => 'error',
            'message' => "Error while saving the profile picture, Check file permission!!"
        );
	}

	public function delete () {
		echo json_encode( $this->model->delete( array( "id" => $_POST['dataId'] ) ) );
    }

	private function renderDateValue ( $data, $keyword ) {
		return implode( array(
				$data[$keyword . '-year'],
				$data[$keyword . '-month'],
				$data[$keyword . '-day'] ), 
			"-" );
	}

	public function createProfilePictureFilename( $array ) {
        array_push( $array, date( "His" ) . '.jpg' );
        return implode( $array, "_" );
    }

    public static function createAthleteCode ( $birthdate, $mobileNumber, $athleteId ) {
    	$birthdateObj = new DateTime( $birthdate );
    	$dateAddedObj = new DateTime( date('Y-m-d') );
    	$mobileLastDigit1 = substr( $mobileNumber, -4, -2 );
    	$mobileLastDigit2 = substr( $mobileNumber, -2 );

    	$athleteCode = array(
    		$dateAddedObj->format('m'),
    		$mobileLastDigit1,
    		$dateAddedObj->format('d'),
    		$mobileLastDigit2,
    		$birthdateObj->format('y'),
    		$athleteId
    	);

    	foreach($athleteCode as $key => $element){
    		$athleteCode[$key] = self::strPadZero($element);
    	}
		
		return  implode($athleteCode, "");
    }

    public function strPadZero( $inputString, $direction = "left" ){
   		$directionString = STR_PAD_LEFT;
   		if( $direction == 'right' ){
   			$directionString = STR_PAD_RIGHT;
   		}
   		return str_pad( $inputString, 0, $padString, $directionString );
	}
	
}