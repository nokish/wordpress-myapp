jQuery( document ).ready(function( $ ) {
	console.log('modal.js loaded...');

	/* Modal */
	var modal = $('.athlete-manager-modal'),
		close = $(".athlete-manager-modal .close"),
		ok = $(".athlete-manager-modal .ok"),
		cancel = $(".athlete-manager-modal .cancel");

	close.on('click', function(){
		if(Webcam){
			Webcam.reset();
		}modal.hide();
	});

	ok.on('click', function(){
		if(Webcam){
			Webcam.reset();
		}
		modal.hide();
	});

	cancel.on('click', function(){
		if(Webcam){
			Webcam.reset();
		}
		modal.hide();
	});

	window.onclick = function(event) {
	    if (event.target == modal)
	        modal.hide();
	}
	/* Modal End*/

	/* Webcam Modal */
	var webcamModal = $('#athlete-manager-webcam-modal'),
		webcamLoading = $('#webcam-loading'),
		webcamPreFunctions = $('#webcam-pre-functions'),
		webcamPostFunctions = $('#webcam-post-functions');

	$('#athlete-manager-open-webcam').on('click', function(){
		webcamModal.show({
			duration: 1,
			complete: function(){
				Webcam.set({
					width: 323,
					height: 240,
					image_format: 'jpeg',
					jpeg_quality: 90
				});
				Webcam.attach( '#athlete-manager-webcam' );
				
				webcamLoading.show();
				webcamPreFunctions.hide();
				webcamPostFunctions.hide();

				Webcam.on('live', function(){
					webcamPreFunctions.show();
					webcamLoading.hide();
					webcamPostFunctions.hide();	
				});		
			}
		});
	});

	$('#athlete-manager-webcam-capture').on('click', function(){
		Webcam.freeze();

		webcamPostFunctions.show();
		webcamPreFunctions.hide();
	});

	$('#athlete-manager-webcam-capture-again').on('click', function(){
		Webcam.unfreeze();

		webcamPostFunctions.hide();
		webcamPreFunctions.show();
	});

	$('#athlete-manager-webcam-use-this').on('click', function(){
		Webcam.snap( function(data_uri) {
			$('#athlete-manager-profile-picture-image').attr({src: data_uri});
			$('#athlete-profile-picture-uri').val(data_uri);
			Webcam.reset()
		
			webcamModal.hide();
		} );
	});
	/* Webcam Modal End */	
});