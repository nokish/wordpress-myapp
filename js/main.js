jQuery( document ).ready(function( $ ) {
	console.log('main.js loaded...');

});

class Helper {

	constructor () {
		console.log( 'helper class loaded...' );
	}

	showAdminNotice ( messageContent, type ){
		jQuery( document ).ready( function( $ ) {

			var notice = $('<div />'),
			message = $('<p />'),
			closeBtn = $('<button />'),
			screenReaderText = $('<span />');

			message.text(messageContent);
			screenReaderText
				.text('Dismiss this notice.')
				.addClass('screen-reader-text');

			closeBtn
				.attr({
					type: "button"
				})
				.addClass('notice-dismiss')
				.append(screenReaderText)
				.on('click', function(){
					notice.remove();
				});
			
			if(type == null){
				type = 'success';
			}

			notice
				.addClass('notice')
				.addClass('notice-' + type)
				.addClass('is-dismissible');

			notice.append(message).append(closeBtn);
			console.log('showAdminNotice', Date.now());
			$('#wpbody-content').prepend(notice);



		} );
		
	}
}