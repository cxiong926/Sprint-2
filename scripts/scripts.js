console.log("asd");
function goBack() {
	window.history.back();
}
	
$(document).ready(function() {
	

	
	// Prevents jQuery's onkeyup listener for personal preference
    /*$.validator.setDefaults({
        onkeyup: function(element) {
            if (element.name == '#survey') {
                return false;
            }
        },
		errorPlacement: function(error, element) {
			error.insertBefore(element);
		}
		
		/* errorPlacement: function(error, element) {
			if (element.hasClass('emError')) {
				$( "emErrorMessage" ).replaceWith( "<div class='emErrorMessage'>" + error +"</div>" );
            }
			if (element.hasClass('majError')) {
                  $( "majErrorMessage" ).replaceWith( "<div class='majErrorMessage'>" + error +"</div>" );
            }
			if (element.hasClass('graError')) {
                  $( "graErrorMessage" ).replaceWith( "<div class='graErrorMessage'>" + error +"</div>" );
            }
			if (element.hasClass('topError')) {
                  $( "topErrorMessage" ).replaceWith( "<div class='topErrorMessage'>" + error +"</div>" );
            }
		} 
    });*/



	/*	jQuery validation
    $("#survey").validate({

        // Validation rules
        rules: {
            'email': {
                required: true,
                email: true
            },
            'major[]': {
                required: true
            },
			'grade': {
                required: true
            },
			'topping': {
                required: true
            }
        },

        // Error messages for rules
        messages: {
            'email': {
                required: "Please enter an email address<br>",
				email: "Please enter a valid email address<br>"
            },
			'major[]': {
                required: "Please select a major<br>"
            },
			'grade': {
                required: "Please select a grade<br>"
            },
            'topping': {
                required: "Please select a topping<br>"
            }
        },
        
		//  Submit action when the form is valid and submitted.  Calls submitID()
        submitHandler: function(form) {
			action.php;
            //submitID();
        }
    })*/

    
});

