jQuery( document ).ready(function( $ ) {
	console.log('actionUrls', actionUrls)
	$('#athlete-manager-add-athlete-button').on("click", function(){
		window.location.href = "admin.php?page=add_athlete";
	});

	let AthletesTable = new $.AMDataTable();
	AthletesTable.table = {
		element: $('#athletes-manager-athletes-datatable'),
		config: {
			"columnDefs": [{ 
						"orderable": false, 
						"targets": 6
					}],
					"order": [[ 1, "asc" ]]
			},
		actions: {
			delete: {
				ajaxName: 'deleteAthlete',
				modal: $('#athletes-manager-delete-athlete-confirm')},
			view: {
				url: actionUrls.view
			}
		}
	};
	AthletesTable.Init();

});