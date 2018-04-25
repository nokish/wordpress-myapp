<?php
if(!defined('ABSPATH')) exit;

class Athletes_Manager_Page {

	public static function header($title) {
		return '<h1 class="athlete-manager-header">' . $title . '</h1>';
	}

	public function inputFields ($label, $type, $name, $id, $default = "", $labelCol = 1, $inputCol = 3) {
		if($label){
			echo '<div class="am-row">';
			echo '<div class="am-col-'.$labelCol.'"><label class="am-label" for="' . $id . '" class="am-input">' . $label . '</label></div>';
			echo '<div class="am-col-'.$inputCol.'"><input class="am-input" type="' . $type . '" name="' . $name . '" id="' . $id . '" value="' . ucwords($default, "-") . '" /></div>';
			echo '</div>';
		}else{
			echo '<input type="' . $type . '" name="' . $name . '" id="' . $id . '" class="am-input" value="' . $default. '" />';
		}
	}

	public function selectFields($label, $name, $id, $options, $default = "", $labelCol = 1, $inputCol = 3){
		$optionsString = "";
		foreach($options as $key => $value){
			$selected = ($key == $default)? 'selected' : '';
			$options_str .= '<option value="' . $key . '" ' . $selected . '>' . ucwords($value,"-") . '</option>';
		}

		echo '<div class="am-row">';
		echo '<div class="am-col-'.$labelCol.'"><label class="am-label" for="' . $id . '">' . $label . '</label></div>';
		echo '<div class="am-col-'.$inputCol.'">
				<select class="am-input" name="' . $name . '" id="' . $id . '">
					<option value="">Choose here...</option>
					' . $options_str . '
				</select></div>';
		echo '</div>';
	}

	public function radioCheckFields($label, $type, $name, $id, $options, $default = "", $labelCol = 1, $inputCol = 3){
		$options_str = "";
		foreach($options as $key => $value){
			$checked = "";
			if($value == $default){
				$checked = 'checked';			
			}
			$options_str .= '<input type="' . $type . '" name="' . $name . '" id="' . $id . '-' . $key . '" value="' . $value . '" '. $checked .'/><label class="am-label" for="' . $id . '-' . $key . '">' . ucwords($value, "-") . '</label>';
		}

		echo '<div class="am-row">';
		echo '<div class="am-col-'.$labelCol.'"><label for="athlete-gender-male">'.$label.'</label></div>';
		echo '<div class="am-col-'.$inputCol.'">' . $options_str . '</div>';
		echo '</div>';
	}

	public function dateFields($label, $id, $default = "", $labelCol = 1, $inputCol = 3){
		$yearEnd = new DateTime( date('Y-m-d') );
		$yearStart = new DateTime( date('Y-m-d') );
		$yearStart = $yearStart->modify( '-70 years' );		
		$interval = new DateInterval('P1Y');

		$months = range(1,12);
		$days = range(1, 31);
		$years = new DatePeriod($yearStart, $interval ,$yearEnd);

		if($default){
			$defaultDate = new DateTime($default);
			$defaultMonth = $defaultDate->format("m");
			$defaultDay = $defaultDate->format("d");
			$defaultYear = $defaultDate->format("Y");
		}
		
		$monthOptionsStr = '';
		foreach ($months as $key => $value) {
			$selected = ($defaultMonth == $value)? 'selected' : '';
			$monthOptionsStr .= '<option value="'.$value.'" '.$selected.'>'.$value.'</option>';
		}

		$dayOptionsStr = '';
		foreach ($days as $key => $value) {
			$selected = ($defaultDay == $value)? 'selected' : '';
			$dayOptionsStr .= '<option value="'.$value.'" '.$selected.'>'.$value.'</option>';
		}

		$yearOptionsStr = '';
		foreach ($years as $value) {
			$year = $value->format('Y');
			$selected = ($defaultYear == $year)? 'selected' : '';
			$yearOptionsStr .= '<option value="'.$year.'" '.$selected.'>'.$year.'</option>';
		}		

		echo '<div class="am-row">';
		echo '<div class="am-col-'.$labelCol.'"><label class="am-label" for="'.$id.'-month">' . $label . '</label></div>';
		echo '<div class="am-col-'.$inputCol.'">
				<select class="am-input-date" name="'.$id.'-month" id="'.$id.'-month">
					<option value="">MM</option>
					' . $monthOptionsStr . '
				</select>
				<select class="am-input-date" name="'.$id.'-day" id="'.$id.'-day">
					<option value="">DD</option>
					' . $dayOptionsStr . '
				</select>
				<select class="am-input-date" name="'.$id.'-year" id="'.$id.'-year">
					<option value="">YYYY</option>
					' . $yearOptionsStr . '
				</select>
	 		  </div>';
		echo '</div>';
	}

	public function getRequestParameter( $key, $default = '' ) {
	    if ( ! isset( $_REQUEST[ $key ] ) || empty( $_REQUEST[ $key ] ) ) {
	        return $default;
	    }
	    return strip_tags( (string) wp_unslash( $_REQUEST[ $key ] ) );
	}

	public static function echoVar($var) {			
		highlight_string(var_export(print_r($var, true), true));
	}

	public function renderWebcamModal() {
		// Webcam modal 
		echo '<div id="athlete-manager-webcam-modal" class="athlete-manager-modal">';
			echo '<div class="modal-content">';
				echo '<span class="close">&times;</span>';
			echo '<div class="am-row">';
				echo '<h1>Camera</h1>';
				echo '<div id="athlete-manager-webcam" class="am-col-11"></div>';
				echo '<div id="webcam-loading" class="am-col-11">';
				echo '<span class="dashicons dashicons-camera"></span>Camera loading...';
				echo '</div>';
				echo '<div id="webcam-pre-functions" class="am-col-11">';
					echo '<span class="athlete-manager-buttons" id="athlete-manager-webcam-capture">Capture</span>';
				echo '</div>';
				echo '<div id="webcam-post-functions" class="am-col-11">';
				echo '<span class="athlete-manager-buttons" id="athlete-manager-webcam-capture-again">Reset</span>';
				echo '<span class="athlete-manager-buttons" id="athlete-manager-webcam-use-this">Use</span>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
		// End
	}

	public function isProfilePictureExists($uri){
		return (!$uri)? plugins_url( '../images/default-profile-image.jpg', __FILE__ ) : $uri;
	}

	public static function dataTableHeader(array $headers){
		echo '<tr>';
		foreach($headers as $header){
			echo '<th>'.$header.'</th>';
		}
		echo '</tr>';
	}

	public function getAthleteOptions( $keyword ){
		$options = array(
			'category' => array(
				'professional' => 'professional',
				'non-professional' => 'non-professional'
				),
			'gender' => array(
				'male' => 'male',
				'female' => 'female'
			)
		);
		return $options[ $keyword ];
	}

}