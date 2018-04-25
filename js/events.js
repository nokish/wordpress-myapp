jQuery(document).ready(function($) {

	let EventsTable = new $.AMDataTable();
	EventsTable.table = {
		element: $('#athletes-manager-events-datatable'),
		config: {
			"columnDefs": [{ 
						"orderable": false, 
						"targets": 6 
					}],
					"order": [[ 1, "asc" ]]},
		actions: {
			delete: {
				ajaxName: 'deleteEvent',
				modal: $('#athletes-manager-delete-event-confirm') },
			view: {
				url: actionUrls.view },
			edit: {
				url: actionUrls.edit },
		}
	};
	EventsTable.Init();

	$('#athlete-manager-add-event-button').on("click", function(){
		window.location.href = "admin.php?page=add_event";
	});

});