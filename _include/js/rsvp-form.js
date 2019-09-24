jQuery(document).ready(function($) {
      $('#rvsp-confirm, #rvsp-regret').on('click',function(e) {
          e.preventDefault(); // stop the normal submit
          

          // Validation ------------------------------------------

		 	var input = $('.validate-input .input100');
	        var check = true;

	        for(var i=0; i<input.length; i++) {
	            if(validate(input[i]) == false){
	                showValidate(input[i]);
	                check=false;
	            }
	        }

		    $('.validate-form .input100').each(function(){
		        $(this).focus(function(){
		           hideValidate(this);
		        });
		    });

		    function validate (input) {
		        if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
		            if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
		                return false;
		            }
		        }
		        else {
		            if($(input).val().trim() == ''){
		                return false;
		            }
		        }
		    }

		    function showValidate(input) {
		        var thisAlert = $(input).parent();

		        $(thisAlert).addClass('alert-validate');
		    }

		    function hideValidate(input) {
		        var thisAlert = $(input).parent();

		        $(thisAlert).removeClass('alert-validate');
		    }
		    
          // Form Submisstion ------------------------------------

          if (check == true){
	          $form = "#hs-rvsp-form"
	          var _data = $($form).serialize()+'&attendance=' + $(this).val();
	         
	          $.ajax({
	              type: 'POST',
	              url: admin_url.ajax_url,
	              data: _data,
	              success: function(response) {
	           		console.log(response)

	           		var success1 = "Thanks! See you on our wedding!"
	              	var success2 = "We regret that you won't be able to attend."
	              	var error = "Please check your spelling or directly contact us."
	              	
	              	if (response.error == false){
	              	
	              		$($form)[0].reset();	              		
		         		console.log(response.attendance)

	              		if (response.attendance == 1){        		
	              			$("#rvsp-success").html(success1);
		              		$("#rvsp-msg-error").hide();
		              		$("#rvsp-msg-success").fadeIn("fast");
	              		}
	              		else {	              				              					
	              			$("#rvsp-error").html(success2);
	              			$("#rvsp-msg-success").hide()
		              		$("#rvsp-msg-error").fadeIn("slow");	
	              		}
	              	}
	              	else{	              		 	              				
	              			$("#rvsp-error").html(error);
	              			$("#rvsp-msg-success").hide()
		              		$("#rvsp-msg-error").fadeIn("slow");	
		              }
	              }
	          });
	      }
          return false;
      });
  });