jQuery(document).ready(function($) {
	console.log('athlete-manager-ajax loaded...');
	
	var eventParticipantsPage_EventId = $('#show-event-participants-form select[id="event-id"]');
	var eventIdValue = eventParticipantsPage_EventId.val();
	var eventParticipantsPage_EventIdMissingModal = $('#event-id-missing-modal');
	
	var eventsParticipantsDataTable = $('#event-participants-datatable').DataTable({
				'columns': [
					{"data" : "action"},
					{"data" : "athlete_code"},
		    		{"data" : "lastname"},
		    		{"data" : "firstname"},
		    		{"data" : "middlename"},
		    		{"data" : "date_added"},
				  ],
				'columnDefs': [{ 'orderable': false, 'targets': 0}],
				'order': [[ 2, 'asc' ]]
				});

	var searchParticipantsDataTable = $('#search-participants-datatable').DataTable({
		'columns': [
			{"data" : "athlete_code"},
		    {"data" : "lastname"},
		    {"data" : "firstname"},
		    {"data" : "middlename"},
		    {"data" : "action"},
		  ],
		'columnDefs': [{ 'orderable': false, 'targets': 0}],
		'order': [[ 1, 'asc' ]],
		'pageLength': 5,
		'bLengthChange': false
	});

	eventParticipantsPage_EventId.change(function(){
		eventIdValue = $(this).val();
	});
	
	if(eventIdValue) {
		renderEventsParticipantsTable(eventIdValue);
	}

	$('#add-event-participants-modal').on('click', '.close, .cancel', function(){
		renderEventsParticipantsTable(eventIdValue);
	});

	$('#event-participants-search-athletes').on('keyup', 'input', function(e){
		if(e.keyCode == 13){
			console.log('enter key press...');

		}
	})

	$('#event-participants-show-participants-button').on('click', function(){
		console.log('eventIdValue: ' + eventIdValue);
		if(eventIdValue == ''){
			// console.log(eventParticipantsPage_EventIdMissingModal);
			eventParticipantsPage_EventIdMissingModal.show();
			return;
		}
		renderEventsParticipantsTable(eventIdValue);
	});

	$('#search-participants-datatable').on('click', '.add-event-participant-button', function(){
		var button  = $(this),
			data 	= {
						'action': 'addParticipant',
						'athlete_id': $(this).data().athlete_id,
						'event_id': $(this).data().event_id,
					};	
		console.log(data);
		$.post(ajax_object.ajax_url, data, function(response) {
			console.log(response);
			button.text("Added").addClass('added');
		});
	});

	$('#add-event-participants-modal').on('click', '#event-participants-search', function(){
		var data = {
			'action': 'searchParticipantsDataSet',
			'athlete_code': $('#search-event-participants-athlete-code').val(),
			'lastname': $('#search-event-participants-lastname').val(),
			'firstname': $('#search-event-participants-firstname').val(),
			'middlename': $('#search-event-participants-middlename').val(),
			'event_id': eventIdValue,
		};
		
		$.post(ajax_object.ajax_url, data, function(response) {
			searchParticipantsDataTable
				.clear()
				.rows.add(JSON.parse(response.replace(']0', ']')))
				.draw();
		});
	});

	$('#show-event-participants-form').on('click', '#add-participants-button', function(){
		var modal = $('#add-event-participants-modal'),
			modalLabel = $('#add-event-participants-modal h1'),
			eventLabel = $('#event-id option:selected');
		
		if(eventLabel.val() == ''){
			eventParticipantsPage_EventIdMissingModal.show();
		}else{
			modal.show({ 
				duration: 1,
				complete: function(){
					modalLabel.text("Add Participant for " + eventLabel.text());
					$('#event-participants-search-athletes input').each(function(){
						$(this).val('');
					});
					searchParticipantsDataTable.clear().draw();
				} 
			});
		}
	});

	$('#event-participants-datatable').on('click', '.delete-event-participant', function(){
		var data = {
				'action': 'deleteParticipant',
				'event_participant_id': $(this).data().event_participant_id
			},
			confirm = $('#delete-event-participant-modal'),
			row = $(this);

		confirm.show({
			duration: 1,
			complete: function(){
					confirm.on('click', '.answer', function() {
						if($(this).data().confirm_value == 'yes'){
							$.post(ajax_object.ajax_url, data, function(response) {
								if(response){
									eventsParticipantsDataTable
										.row( row.parents('tr') )
										.remove()
										.draw();	
								}
							});					
						}

						confirm.hide();
					});
			}		
		});
		
		
	});

	function renderEventsParticipantsTable(eventId) {
		var data = {
			'action': 'eventParticipantsDataSet',
			'event_id': eventId
		};
		console.log('renderEventsParticipantsTable', data);
		$.post(ajax_object.ajax_url, data, function(response) {
			console.log(response);
			eventsParticipantsDataTable
				.clear()
				.rows.add(JSON.parse(response.replace(']0', ']')))
				.draw();
		});
	}

});