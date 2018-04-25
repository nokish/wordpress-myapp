jQuery( document ).ready(function( $ ) {
	console.log('AMDataTable loaded...');

	$.AMDataTable = function(){
		this.table = {
			element: '',
			config: {},
			actions: {
				delete: {
					ajaxName: '',
					modal: ''},
				edit: {},
				view: {}
			}
		};

		this.loaderImg = {
				element: $('<span class="ajax-loader-gif"/>')};
		this.helper = new Helper();
	}

	$.AMDataTable.prototype = {
		Init: function () {
			var that = this;

			this.tableObject = that.table.element
									 .DataTable(that.table.config);

			if('actions' in that.table){

				if('delete' in that.table.actions){
					this.tableObject
						.on('click', '.delete', function(){
							console.log('.delete', this);
							that.DeleteData($(this));
						});
				}

				if('edit' in that.table.actions){
					this.tableObject
						.on('click', '.edit', function(){
							that.EditData($(this));
						});
				}

				if('view' in that.table.actions){
					this.tableObject
						.on('click', '.view', function(){
							that.ViewData($(this));
						});
				}	

			}
			
		},
		AlertMessage: function (msg) {
			alert(msg);
		},
		Render: function (data) {
			console.log('RenderTable called...');
			var that = this;

			try {
				if(!data) throw 'Missing data settings for ajax call';
				if(!data.action) throw 'Missing action method for ajax call!'; 	
			} catch (err) {
				that.AlertMessage(err);
				return;
			}
			
			console.log('data', data);
			that.ShowLoader();
			$.post(ajax_object.ajax_url, data, function(response) {
				console.log('response', response);	
				var cleanData = JSON.parse(response.replace(']0', ']'));

				that.tableObject
					.clear()
					.rows.add(cleanData)
					.draw();
				that.HideLoader();
			});
		},
		EditData: function (row) {
			window.location = this.table.actions.edit.url + row.data().id;
		},
		DeleteData: function (row) {
			var data = {
					'action': this.table.actions.delete.ajaxName,
					'dataId': row.data().id
				};
			
			this.ConfirmDataDeletion(data, row);
		},
		ViewData: function (row) {
			window.location = this.table.actions.view.url + row.data().id;
		},
		ShowLoader: function () {
			var loaderContainer = $( this.tableObject.table().container() ).children('.dataTables_filter');
			this.loaderImg.element.prependTo(loaderContainer);
		},
		HideLoader: function () {
			this.loaderImg.element.remove();
		},
		ConfirmDataDeletion: function (data, row) {
			var modal = this.table.actions.delete.modal
						.off('click', '.answer'),
				that = this;
			console.log('row', row, 'data', data, 'modal', modal);

			modal.show({duration: 1})
				 .on('click', '.answer', function(e){
				 		console.log('this.data', $(this).data(), 'data', data);
				 		if($(this).data().value == 'yes'){
					 		that.ShowLoader();

							$.post(ajax_object.ajax_url, data, function(response) {
								var result =  JSON.parse( response.replace( '}0', '}' ) );
								console.log(result);

								if( result.type == "success" ){
									that.tableObject
										.row( row.parents('tr') )
										.remove()
										.draw();

									modal.hide();
									that.HideLoader();
								}
								that.helper.showAdminNotice( result.message, result.type );
							});
						}else{
							modal.hide();
						}
				 });
		}
	}	
});