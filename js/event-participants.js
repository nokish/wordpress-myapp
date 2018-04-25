jQuery(document).ready(function($) {
	console.log('event-participants.js...loaded');

	var eventIdObj = $('#show-event-participants-form select[id="event-id"]');
	var eventIdValue = eventIdObj.val();

	var searchAthleteForm = $('#event-participants-search-athletes');

	var showParticipantsButton = $('#event-participants-show-participants-button');
	var addParticipantsButton = $('#add-participants-button');
	
	var eventIdMissingModal = $('#event-id-missing-modal');
	var addEventParticipantsModal = $('#add-event-participants-modal');
	
	let EventParticipantsTable = new $.AMDataTable();
	EventParticipantsTable.table = {
		element: $('#event-participants-datatable'),
		config: {
				'columns': [
					{"data" : "athlete_code"},
		    		{"data" : "lastname"},
		    		{"data" : "firstname"},
		    		{"data" : "middlename"},
		    		{"data" : "date_added"},
		    		{"data" : "action"},
				  ],
				'columnDefs': [{ 'orderable': false, 'targets': 5}],
				'order': [[ 1, 'asc' ]]},
		actions: {
			delete: {
				ajaxName: 'deleteParticipant',
				modal: $('#remove-participant-modal') },
		}
	};
	EventParticipantsTable.Init();

	let SearchParticipantsTable = new $.AMDataTable();
	SearchParticipantsTable.table = {
		element: $('#search-participants-datatable'),
		config: {
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
		}
	};
	SearchParticipantsTable.Init();

	if(eventIdValue){
		EventParticipantsTable.Render({
			action: 'eventParticipantsDataSet',
			event_id: eventIdValue
		});
	}

	eventIdObj.change(function(){
		eventIdValue = $(this).val();
	});

	showParticipantsButton.on('click', function(){
		console.log('eventIdValue', eventIdValue);

		if(eventIdValue == ''){
			eventIdMissingModal.show();
			return;
		}

		EventParticipantsTable.Render({
			action: 'eventParticipantsDataSet',
			event_id: eventIdValue
		});
	});

	addParticipantsButton.off('click').on('click', function(){
		var modalLabel = addEventParticipantsModal.find('h1'),
			eventLabel = $('#event-id option:selected'),
			inputFields = $('#event-participants-search-athletes input');

		if(eventIdValue == ''){
			eventIdMissingModal.show();
		}else{
			addEventParticipantsModal.show({ 
				duration: 1,
				complete: function(){
					modalLabel.text("Add Participant for " + eventLabel.text());

					inputFields.each(function(){
						$(this).val('');
					});
					SearchParticipantsTable.tableObject.clear().draw();
				} 
			});
		}
	});

	addEventParticipantsModal.on('click', '.close, .cancel', function () {
		EventParticipantsTable.Render({
			action: 'eventParticipantsDataSet',
			event_id: eventIdValue
		});
	});
	
	searchAthleteForm.on('keyup', 'input', function(e){
		if(e.keyCode == 13){
			SearchParticipantsTable.Render({
				action: 'searchParticipantsDataSet',
				athlete_code: $('#search-event-participants-athlete-code').val(),
				lastname: $('#search-event-participants-lastname').val(),
				firstname: $('#search-event-participants-firstname').val(),
				middlename: $('#search-event-participants-middlename').val(),
				event_id: eventIdValue,
			});
		}
	});

	SearchParticipantsTable.tableObject.on('click', '.add', function () {
		var button = $(this),
			data = {
				action: 'addParticipant',
				athlete_id: $(this).data().athlete_id,
				event_id: $(this).data().event_id,
			};

		SearchParticipantsTable.ShowLoader();
		$.post(ajax_object.ajax_url, data, function(response) {
			button.text("Added").addClass('added');
			SearchParticipantsTable.HideLoader();
		});
	});

	addEventParticipantsModal.on('click', '.search', function () {
		SearchParticipantsTable.Render({
				action: 'searchParticipantsDataSet',
				athlete_code: $('#search-event-participants-athlete-code').val(),
				lastname: $('#search-event-participants-lastname').val(),
				firstname: $('#search-event-participants-firstname').val(),
				middlename: $('#search-event-participants-middlename').val(),
				event_id: eventIdValue,
		});
	});

});