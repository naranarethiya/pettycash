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

    $(".datepicker").datepicker({
    	"autoclose": true
    }).datepicker('setValue', new Date());
	
	$(".datepicker2").datepicker({
    	"autoclose": true
    });

	var dates=jQuery.parseJSON($('#active_dates').val());
    $(".dailyDatepicker").datepicker({
    	"autoclose": true,
		onRender: function(date) {
			var y=date.getFullYear();
			var m=parseInt(date.getMonth())+parseInt(1);
			var d=date.getDate();
			if(d.toString().length < 2) {
				d='0'+d;
			}
			
			if(m.toString().length < 2) {
				m='0'+m;
			}
			var str=y+'-'+m+'-'+d;
			var rs=$.inArray(str, dates);
			var cmp=parseInt('-1');
			if (parseInt(rs) < parseInt('0')) {
				return 'disabled';
			}
			else {
				return '';
			}
		},
    });
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

$('a[title="delete"], a[title="Delete"]').click(function(e) {
	if(confirm("Are You Sure to Delete?")) {
		return true;
	}
	else {
		return false;
	}
});

function deleteTransation(trans_id) {
	if(confirm("Are sure to Delete this transaction..?")) {
		var url=base_url+"deleteExpense/"+trans_id;
		$.ajax({
			url:url
		})
		.done(function(data) {
			if(data[0]=='1') {
				alert(data[1]);
				$('#tr'+trans_id).remove();
			}
			else {
				alert(data[1]);
			}
		}).fail(function() {
			alert("Something went Wrong");
		});	
		return true;
	}
	return false;
}

function deleteBankTransation(trans_id) {
	if(confirm("Are sure to Delete this transaction..?")) {
		var url=base_url+"bank_book/delete/"+trans_id;
		$.ajax({
			url:url
		})
		.done(function(data) {
			if(data[0]=='1') {
				alert(data[1]);
				$('#tr'+trans_id).remove();
			}
			else {
				alert(data[1]);
			}
		}).fail(function() {
			alert("Something went Wrong");
		});	
		return true;
	}
	return false;
}
