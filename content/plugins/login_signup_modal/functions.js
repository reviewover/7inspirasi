var loginSignupModal = $('<div class="modal fade" id="loginSignupModal" tabindex="-1" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><div class="modal-body"></div></div></div></div>');

$(document).ready(function(){
	
	// Load the Modal Window for login signup when they are clicked
	$('a#login-button-desktop, a#signup-button-desktop').click(function(e){
		e.preventDefault();
		$('body').prepend(loginSignupModal);
		$('#loginSignupModal .modal-title').text($(this).text());
		$('#loginSignupModal .modal-body').load($(this).attr('href') + ' .form-signin', function(){
			$('#loginSignupModal').show();
			$('#loginSignupModal').modal();
		});

		// $('#loginSignupModal .close').click(function(){
		// 	$('#loginSignupModal').modal('close');
		// });

		// Be sure to remove the modal from the DOM after it is closed
		$('#loginSignupModal').on('hidden.bs.modal', function (e) {
	    	$('#loginSignupModal').remove();
		});

	});

	
	

});