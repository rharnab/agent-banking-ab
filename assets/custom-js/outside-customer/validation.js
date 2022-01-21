// ammendment data form validation
$(function () {

	$.validator.setDefaults({
		errorClass: 'help-block',
		highlight: function (element) {
			$(element)
				.closest('.form-group')
				.addClass('has-error');
		},
		unhighlight: function (element) {
			$(element)
				.closest('.form-group')
				.removeClass('has-error');
		}
	});


	$("#ammendment-data").validate({
		rules: {
			english_name: {
				required: true,
			},
			date_of_birth: {
				required: true,
			},
			nid_number: {
				required: true,
			}
		},
		messages: {
			english_name: {
				required: "please write your english name",
			},
			date_of_birth: {
				required: "please select your date of birth",
			},
			nid_number: {
				required: "please write your upload nid number",
			}
		}
	});

});



// review data form validation
$(function () {

	$.validator.setDefaults({
		errorClass: 'help-block',
		highlight: function (element) {
			$(element)
				.closest('.form-group')
				.addClass('has-error');
		},
		unhighlight: function (element) {
			$(element)
				.closest('.form-group')
				.removeClass('has-error');
		}
	});


	$("#review-data-submit").validate({
		rules: {
			review_english_name: {
				required: true,
			},
			review_bangla_name: {
				required: true,
			},
			review_blood_group: {
				required: true,
            },
            review_date_of_birth: {
				required: true,
			},
			review_father_name: {
				required: true,
			},
			review_mother_name: {
				required: true,
            },
            review_address: {
				required: true,
			}
		},
		messages: {
			review_english_name: {
				required: "please enter your nid english name",
			},
			review_bangla_name: {
				required: "please enter your nid bangla name",
			},
			review_blood_group: {
				required: "please enter your blood group",
            },
            review_date_of_birth: {
				required: "please select your date of birth",
			},
			review_father_name: {
				required: "please enter your father name",
			},
			review_mother_name: {
				required: "please enter your mother name",
            },
            review_address: {
				required: "please enter your address",
			}
		}
	});
});



// Account Opening Form
$(function () {

	$.validator.setDefaults({
		errorClass: 'help-block',
		highlight: function (element) {
			$(element)
				.closest('.form-group')
				.addClass('has-error');
		},
		unhighlight: function (element) {
			$(element)
				.closest('.form-group')
				.removeClass('has-error');
		}
	});


	$("#account_opening_information").validate({
		rules: {
			branch_id: {
				required: true,
			},
			probably_monthly_income: {
				required: true,
			},
			probably_monthly_deposite: {
				required: true,
            },
            probably_monthly_withdraw: {
				required: true,
			}
		},
		messages: {
			branch_id: {
				required: "please select a branch",
			},
			probably_monthly_income: {
				required: "please enter your monthly income",
			},
			probably_monthly_deposite: {
				required: "please enter your probably monthly deposite",
            },
            probably_monthly_withdraw: {
				required: "please enter your probably monthly withdraw",
			}
		}
	});

});