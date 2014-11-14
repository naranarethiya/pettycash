var cus_form=0;
var form_type="";
var clone_div='';
$(document).ready(function() {
	
	// click on the overlay to remove it
	$('#overlay').click(function() {
		$(this).remove();
	});

	// hit escape to close the overlay
	$(document).keyup(function(e) {
		if (e.which === 27) {
			$('#overlay').remove();
		}
	});	
	
	$('#mobileUniq').change(function() {
		var mobile=$(this).val();
		check_mobile(mobile,this);
	});
	
    $('#allSelect').click(function(event) {
        if(this.checked) {
            $('.cusSelect').each(function() { 
                this.checked = true;          
            });
        }else{
            $('.cusSelect').each(function() {
                this.checked = false;
            });         
        }
    });

    $(".datepicker").datepicker();
});

function check_mobile(mobile,ele) {
	$.ajax({
			method:"POST",
			url:base_url+"dashboard/check_mobile",
			data:{mobile:mobile,form_type:form_type},
			dataType:'json',
		})
		.done(function(data) {
			add_error(data,ele);
		});
}

function check_email(email,ele) {
	$.ajax({
		method:"POST",
		url:base_url+"dashboard/check_email",
		data:{email:email,form_type:form_type},
		dataType:'json',
	})
	.done(function(data) {
		add_error(data,ele);
	});
}


function loading() {
	var over='<div id="overlay"><img src="'+base_url+'images/gif-load.gif" id="loading" /></div>'
	$(over).appendTo('body');
}