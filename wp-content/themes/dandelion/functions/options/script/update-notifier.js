/*
* Update notofier - contains the functionality for the update notifier page.
*/
jQuery(document).ready(function($) {
  
	function UpdateNotifier(){
		this.init();	
	}

	UpdateNotifier.prototype.init = function(){
		this.setInstructionsDialog();
		this.setUpdateDialog();
	};

	UpdateNotifier.prototype.setInstructionsDialog = function(){
		$('#manual-instructions-btn').on("click" , function(e){
			e.preventDefault();
			$('#manual-instructions').dialog({
				width:700,
				maxHeight:500,
				modal:true,
				dialogClass : 'pexeto-dialog'
			});
		});
	};

	UpdateNotifier.prototype.setUpdateDialog = function(){
		$('#update-btn').on("click" , function(e){
			e.preventDefault();
			if(pexetoUpdateData.envatoDetails){
				$('#confirm-update').dialog({
					modal:true,
					dialogClass : 'pexeto-dialog',
					buttons: {
						"Update Theme": function() {
							window.location = pexetoUpdateData.optionsLink;
						},
						Cancel: function() {
							$( this ).dialog( "close" );
						}
					}
				});
			}else{
				$('#no-details').dialog({
					modal:true
				});
			}
			
		});
	};

	var notifier = new UpdateNotifier();


});
