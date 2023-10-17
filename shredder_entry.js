
function restrictDecimalPlaces(input, decimalPlaces) {
  var value = input.value;
  var regex = new RegExp('^\\d+(\\.\\d{0,' + decimalPlaces + '})?$');
  
  if (!regex.test(value)) {
    input.value = value.slice(0, -1); // Remove the last entered character
  }
}

function get_plant_name_display1(site_name) {
	jQuery.ajax({

		type: "GET",

		url: "shredder_entry_form/panel_plant_name_display.php",

		data: "site_name=" + site_name,

		success: function (msg) {
			jQuery("#panel_plant_name_div").html(msg);

		}

	});

}

function shredder_entry_sub_add(random_no, random_sc, shredder_no, entry_date, site_name, opening, closing, total_value, type, description, user_name, shredder_name) {

	var reading = $('#reading').val();
	if(reading!=''){
		var reading_valuess =	parseFloat(reading)
		var reading_result = reading_valuess.toFixed(2);
	}else{
		reading_result = '';
	}
	
	var spare_used = $('#spare_used').val();
	var service_description = $('#service_description').val();
	var serviced_by = $('#serviced_by').val();
	var service_km = $('#service_km').val();
	var reading1 = $('#reading1').val();
	var open = $('#openn').val();
	var plant_name = $('#plant_name').val();
	var search_previous_reading = $('#search_previous_reading').val();
	var type = $('#type').val();
	let previous_day_close = $('#previous_day_close').val();
	let open_validate = $('#open_validate').val();
	let opening_reading = $('#opening_reading').val();
	let shredder_replace;
	let service_status;

	let service_status_val = document.getElementById("service_status");
	if (service_status_val.checked == true) {
		service_status = 1;
	}
	else {
		service_status = 0;
	}
	let shredder_replace_val = document.getElementById("shredder_replace");
	if (shredder_replace_val.checked == true) {
		shredder_replace = 1;
	}
	else {
		shredder_replace = 0;
	}

	var sendInfo = {
		random_no: random_no,
		random_sc: random_sc,
		shredder_no: shredder_no,
		entry_date: entry_date,
		site_name: site_name,
		opening: opening,
		closing: closing,
		total_value: total_value,
		type: type,
		plant_name: plant_name,
		description: description,
		user_name: user_name,
		shredder_name: shredder_name,
		reading: reading_result,
		spare_used: spare_used,
		service_description: service_description,
		serviced_by: serviced_by,
		service_status: service_status,
		shredder_replace: shredder_replace,
		service_km: service_km,
	};

	if ((shredder_no) && (entry_date) && (site_name) && (plant_name) && (user_name) && (type) && (opening) && (closing) && (total_value)) {

		//if ( (search_previous_reading !='') && (service_status == 1)){
		if ((service_status == 1) && (shredder_replace == 0)) {
			if (parseFloat(opening) < parseFloat(closing)) {

				$("#opening").removeClass("errorClass").addClass("succesClass");
				$("#closing").removeClass("errorClass").addClass("succesClass");

				if (parseFloat(reading) <= parseFloat(closing) && parseFloat(reading) >= parseFloat(opening)) {

					// if (service_km >= 0) {

					$("#reading").removeClass("errorClass").addClass("succesClass");

					if (serviced_by) {
						$("#serviced_by").removeClass("errorClass").addClass("succesClass");
					}
					else {
						$("#serviced_by").removeClass("succesClass").addClass("errorClass");
						return;
					}
					if (spare_used) {
						$("#spare_used").removeClass("errorClass").addClass("succesClass");
					}
					else {
						$("#spare_used").removeClass("succesClass").addClass("errorClass");
						return;
					}
					if (service_description) {
						$("#service_description").removeClass("errorClass").addClass("succesClass");
					}
					else {
						$("#service_description").removeClass("succesClass").addClass("errorClass");
						return;
					}

					$.ajax({

						type: "POST",
						url: "model/shredder_entry_form.php?action=ADD",
						data: sendInfo,

						success: function (data) {

							// $('#shredder_name').attr('disabled', 'disabled');
							// $('#plant_name').attr('disabled', 'disabled');
							// $('#site_name').attr('disabled', 'disabled');
							// document.getElementById("entry_date").readOnly = true;
							// $("#shredder_entry_sublist_div").html(data);
							// $("#search_previous_reading").val(reading);
							// get_reading_value();
							// $('#spare_used').val('');
							// $('#service_description').val('');
							// $('#serviced_by').val('');
							var shredder = data.split("@@");
							if (shredder[0] == "Already Exit") {
								alert(shredder[1]);
								return false;
							} else {
								$('#shredder_name').attr('disabled', 'disabled');
								$('#plant_name').attr('disabled', 'disabled');
								$('#site_name').attr('disabled', 'disabled');
								document.getElementById("entry_date").readOnly = true;
								$("#shredder_entry_sublist_div").html(data);
								$("#search_previous_reading").val(reading);
								//get_reading();
								//service_status_nullable();
								get_reading_value();

								//get_yesterday_closing_km();
								$('#spare_used').val('');
								$('#service_description').val('');
								$('#serviced_by').val('');
							}

						},
						error: function () {
						}
					});
					// } else {
					// 	alert("You forgot to select either Shredder Replaced or Shredder Serviced field..!");
					// }
				} else {
					$("#reading").removeClass("succesClass").addClass("errorClass");

				}
			} else {
				$("#opening").removeClass("succesClass").addClass("errorClass");
				$("#closing").removeClass("succesClass").addClass("errorClass");
			}
		}

		//GENSET REPLACE
		//else if(( (search_previous_reading =='') && (service_status == 1)) || (shredder_replace==1)){ 
		else if ((service_status == 0) && (shredder_replace == 1)) {

			if (parseFloat(opening) < parseFloat(closing)) {
				$("#opening").removeClass("errorClass").addClass("succesClass");
				$("#closing").removeClass("errorClass").addClass("succesClass");

				if (parseFloat(opening) >= parseFloat(reading)) {

					//if (service_km >= 0) {

					$("#reading").removeClass("errorClass").addClass("succesClass");

					$.ajax({

						type: "POST",
						url: "model/shredder_entry_form.php?action=ADD",
						data: sendInfo,

						success: function (data) {

							var shredder = data.split("@@");
							if (shredder[0] == "Already Exit") {
								alert(shredder[1]);
								return false;
							} else {
								$('#shredder_name').attr('disabled', 'disabled');
								$('#plant_name').attr('disabled', 'disabled');
								$('#site_name').attr('disabled', 'disabled');
								document.getElementById("entry_date").readOnly = true;
								$("#shredder_entry_sublist_div").html(data);
								$("#search_previous_reading").val(reading);
								//get_reading();
								//service_status_nullable();
								get_reading_value();
								//get_yesterday_closing_km();
								$('#spare_used').val('');
								$('#service_description').val('');
								$('#serviced_by').val('');
							}
						},
						error: function () {
						}
					});
					// } else {
					// 	alert("You forgot to select either Shredder Replaced or Shredder Serviced field..!");
					// }
				} else {
					$("#reading").removeClass("succesClass").addClass("errorClass");

				}
			} else {
				$("#opening").removeClass("succesClass").addClass("errorClass");
				$("#closing").removeClass("succesClass").addClass("errorClass");
			}
		} else { //service_status == 0

			if (parseFloat(opening) < parseFloat(closing)) {

				$("#opening").removeClass("errorClass").addClass("succesClass");
				$("#closing").removeClass("errorClass").addClass("succesClass");

				//if (service_km >= 0) {
				$.ajax({

					type: "POST",
					url: "model/shredder_entry_form.php?action=ADD",
					data: sendInfo,

					success: function (data) {

						var shredder = data.split("@@");

						if (shredder[0] == "Already Exit") {
							//alert("Already Exit");
							//return false;
						} else {
							$('#shredder_name').attr('disabled', 'disabled');
							$('#plant_name').attr('disabled', 'disabled');
							$('#site_name').attr('disabled', 'disabled');
							document.getElementById("entry_date").readOnly = true;
							$("#shredder_entry_sublist_div").html(data);
							get_reading_value();
							//get_yesterday_closing_km();
							$('#spare_used').val('');
							$('#service_description').val('');
							$('#serviced_by').val('');
						}
					},
					error: function () {
					}
				});
				// } else {
				// 	alert("You forgot to select either Shredder Replaced or Shredder Serviced field..!");
				// }
			} else {
				$("#opening").removeClass("succesClass").addClass("errorClass");
				$("#closing").removeClass("succesClass").addClass("errorClass");
			}
		}
	} else {
		//validate_shredder_entry_sublist_add(shredder_no, entry_date, site_name, plant_name, user_name, type, total_value, shredder_name);

		validate_sublist_add_edit(shredder_no, entry_date, site_name, plant_name, user_name, type, opening, closing, total_value, shredder_name);

	}
}


function shredder_entry_sub_edit(random_no, random_sc, shredder_no, user_name, entry_date, site_name, opening, closing, total_value1, type, sub_id) {



	var plant_name = $('#plant_name').val();
	let description = $('#description').val();
	let total_value = $('#total_value').val();
	var type = $('#type').val();
	var reading = $('#reading').val();
	if(reading!=''){
		var reading_valuess =	parseFloat(reading)
		var reading_result = reading_valuess.toFixed(2);
	}else{
		reading_result = '';
	}
	let open = $('#openn').val();
	let current_day_opening = $('#current_day_opening').val();
	let reading1 = $('#reading1').val();
	let reading2 = $('#reading2').val();
	var spare_used = $('#spare_used').val();
	var service_km = $('#service_km ').val();
	var service_description = $('#service_description').val();
	var serviced_by = $('#serviced_by').val();
	var search_previous_reading = $('#search_previous_reading').val();
	let previous_day_close = $('#previous_day_close').val();
	let edit_validates = $('#edit_validates').val();
	let open_validate = $('#open_validate').val();
	let frt_entry = $('#frt_entry').val();

	let shredder_replace;
	let service_status;

	let service_status_val = document.getElementById("service_status");
	if (service_status_val.checked == true) {
		service_status = 1;
	}
	else {
		service_status = 0;
	}
	let shredder_replace_val = document.getElementById("shredder_replace");
	if (shredder_replace_val.checked == true) {
		shredder_replace = 1;
	}
	else {
		shredder_replace = 0;
	}


	var sendInfo = {

		random_no: random_no,

		random_sc: random_sc,

		shredder_no: shredder_no,

		user_name: user_name,

		entry_date: entry_date,

		site_name: site_name,

		plant_name: plant_name,

		opening: opening,

		closing: closing,

		total_value: total_value,

		type: type,

		// ecls: ecls,

		description: description,

		reading: reading_result,

		spare_used: spare_used,

		service_description: service_description,

		serviced_by: serviced_by,

		service_status: service_status,

		shredder_replace: shredder_replace,

		service_km: service_km,
	};

	if ((shredder_no) && (entry_date) && (site_name) && (plant_name) && (user_name) && (type) && (opening) && (closing) && (total_value)) {

		if (parseInt(opening) < parseInt(closing)) {

			$("#opening").addClass('successClass').removeClass('errorClass');
			$("#closing").addClass('successClass').removeClass('errorClass');

			if ((shredder_replace == 1) && (service_status == 0)) {

				if (parseFloat(reading) <= parseFloat(opening)) {
					$("#reading").removeClass("errorClass").addClass("succesClass");

					$.ajax({
						type: "POST",
						url: "model/shredder_entry_form.php?action=EDIT&sub_id=" + sub_id,
						data: sendInfo,
						success: function (data) {
							$("#shredder_entry_sublist_div").html(data);

							document.getElementById('type').value = '';
							document.getElementById('opening').value = '';
							document.getElementById('closing').value = '';
							document.getElementById('total_value').value = '';
							//document.getElementById('edit').value = 'ADD';
							$("#search_previous_reading").val(reading);
							get_reading_value();
							//get_yesterday_closing_km();
							$('#spare_used').val('');
							$('#service_description').val('');
							$('#serviced_by').val('');

						},
						error: function () {
							alert('error handing here');
						}
					});

				} else {
					$("#reading").removeClass("succesClass").addClass("errorClass");
				}
			} else if (service_status == 1 && shredder_replace == 0) {

				if (parseFloat(reading) <= parseFloat(closing) && parseFloat(reading) >= parseFloat(opening)) {

					$("#reading").removeClass("errorClass").addClass("succesClass");

					if (serviced_by) {
						$("#serviced_by").removeClass("errorClass").addClass("succesClass");
					}
					else {
						$("#serviced_by").removeClass("succesClass").addClass("errorClass");
						return;
					}
					if (spare_used) {
						$("#spare_used").removeClass("errorClass").addClass("succesClass");
					}
					else {
						$("#spare_used").removeClass("succesClass").addClass("errorClass");
						return;
					}
					if (service_description) {
						$("#service_description").removeClass("errorClass").addClass("succesClass");
					}
					else {
						$("#service_description").removeClass("succesClass").addClass("errorClass");
						return;
					}

					$.ajax({
						type: "POST",
						url: "model/shredder_entry_form.php?action=EDIT&sub_id=" + sub_id,
						data: sendInfo,
						success: function (data) {
							$("#shredder_entry_sublist_div").html(data);

							document.getElementById('type').value = '';
							document.getElementById('opening').value = '';
							document.getElementById('closing').value = '';
							document.getElementById('total_value').value = '';
							//document.getElementById('edit').value = 'ADD';
							$("#search_previous_reading").val(reading);
							get_reading_value();
							//get_yesterday_closing_km();
							$('#spare_used').val('');
							$('#service_description').val('');
							$('#serviced_by').val('');

						},
						error: function () {
							alert('error handing here');
						}
					});

				} else {
					$("#reading").removeClass("succesClass").addClass("errorClass");
				}
			} else { //service_status = 0 

				$.ajax({
					type: "POST",
					url: "model/shredder_entry_form.php?action=EDIT&sub_id=" + sub_id,
					data: sendInfo,
					success: function (data) {
						$("#shredder_entry_sublist_div").html(data);

						document.getElementById('type').value = '';
						document.getElementById('opening').value = '';
						document.getElementById('closing').value = '';
						document.getElementById('total_value').value = '';
						//document.getElementById('edit').value = 'ADD';
						$("#search_previous_reading").val(reading);
						get_reading_value();
						//get_yesterday_closing_km();
						$('#spare_used').val('');
						$('#service_description').val('');
						$('#serviced_by').val('');

					},
					error: function () {
						alert('error handing here');
					}
				});
			}
		} else {
			$("#opening").addClass('errorClass').removeClass('successClass');
			$("#closing").addClass('errorClass').removeClass('successClass');
		}
	} else {

		//validate_shredder_entry_sublist(shredder_no, entry_date, site_name, plant_name, user_name, type, opening, closing, total_value, shredder_name, spare_used, service_description, serviced_by, reading);

		validate_sublist_add_edit(shredder_no, entry_date, site_name, plant_name, user_name, type, opening, closing, total_value, shredder_name);
	}

}

function validate_sublist_add_edit(shredder_no, entry_date, site_name, plant_name, user_name, type, opening, closing, total_value, shredder_name) {


	if (shredder_no) {
		$("#shredder_no").removeClass("errorClass").addClass("succesClass");
	}
	else {
		$("#shredder_no").removeClass("succesClass").addClass("errorClass");
		return;
	}
	if (entry_date) {
		$("#entry_date").removeClass("errorClass").addClass("succesClass");
	}
	else {
		$("#entry_date").removeClass("succesClass").addClass("errorClass");
		return;
	}
	if (site_name) {
		$("#site_name").removeClass("errorClass").addClass("succesClass");
	}
	else {
		$("#site_name").removeClass("succesClass").addClass("errorClass");
		return;
	}
	if (plant_name) {
		$("#plant_name").removeClass("errorClass").addClass("succesClass");
	}
	else {
		$("#plant_name").removeClass("succesClass").addClass("errorClass");
		return;
	}
	if (shredder_name) {
		$("#shredder_name").removeClass("errorClass").addClass("succesClass");
	}
	else {
		$("#shredder_name").removeClass("succesClass").addClass("errorClass");
		return;
	}

	if (user_name) {
		$("#user_name").removeClass("errorClass").addClass("succesClass");
	}
	else {
		$("#user_name").removeClass("succesClass").addClass("errorClass");
		return;
	}
	if (type) {
		$("#type").removeClass("errorClass").addClass("succesClass");
	}
	else {
		$("#type").removeClass("succesClass").addClass("errorClass");
		return;
	}

	if (opening) {
		$("#opening").removeClass("errorClass").addClass("succesClass");
	}
	else {
		$("#opening").removeClass("succesClass").addClass("errorClass");
		return;
	}

	if (closing) {
		$("#closing").removeClass("errorClass").addClass("succesClass");
	}
	else {
		$("#closing").removeClass("succesClass").addClass("errorClass");
		return;
	}

	if (total_value) {
		$("#total_value").removeClass("errorClass").addClass("succesClass");
	}
	else {
		$("#total_value").removeClass("succesClass").addClass("errorClass");
		return;
	}

}
function get_site_shredder_no(site_name) {
	jQuery.ajax({

		type: "GET",

		url: "shredder_entry_form/invoice_no.php",

		data: "site_name=" + site_name,

		success: function (msg) {
			jQuery("#shredder_no_div").html(msg);

		}

	});

}
function get_total_shredder_entry(opening, closing) {
	if(opening && closing ){
	var total_read = (closing - opening);
	var total_read_result =	parseFloat(total_read);
	const roundedNumber = total_read_result.toFixed(2);
	//console.log("total_read - ", total_read, " - ", roundedNumber);
	document.getElementById('total_value').value = (roundedNumber);
	}else{
		document.getElementById('total_value').value = "0";
	}
}

function edit_panel_reading_sublist(id, reading_no, random_no, random_sc) {

	$.ajax({

		type: "POST",

		url: "panel_reading_form/panel_reading_sublist.php?id=" + id + "&reading_no=" + reading_no + "&random_no=" + random_no + "&random_sc=" + random_sc,

		success: function (data) {

			$("#panel_reading_sublist_div").html(data);

		},

		error: function () {

			alert('error handing here');

		}

	});

}

function shreddre_entry_sub_add1(random_no, random_sc, reading_no, entry_date, site_name, plant_name, opening, closing, mf_value, total_value, type, sub_id) {


	var type = $('#type').val();
	if ((site_name) && (plant_name) && (opening) && (closing) && (mf_value) && (total_reading) && (type)) {

		var sendInfo = {

			random_no: random_no,

			random_sc: random_sc,

			reading_no: reading_no,

			entry_date: entry_date,

			site_name: site_name,

			plant_name: plant_name,

			opening: opening,

			closing: closing,

			mf_value: mf_value,

			total_value: total_value,
			plant_name: plant_name,
			type: type,

		};

		$.ajax({

			type: "POST",

			url: "model/panel_reading_form.php?action=EDIT&sub_id=" + sub_id,

			data: sendInfo,

			success: function (data) {

				$("#panel_reading_sublist_div").html(data);

				//document.getElementById('reading_date').value='';

				document.getElementById('opening').value = '';

				document.getElementById('closing').value = '';

				document.getElementById('mf_value').value = '';

				document.getElementById('total_reading').value = '';

				document.getElementById('edit').value = 'ADD';



			},

			error: function () {

				alert('error handing here');

			}

		});

	}

	else { validate_panel_reading_sublist(site_name, plant_name, opening, closing, mf_value, total_reading, type); }



}


function add_shedder_entry_main(random_no, random_sc, shredder_no, entry_date, site_name, description, shredder_name, user_name) {


	//alert(user_name);

	var plant_name = $('#plant_name').val();


	var over_total = $('#over_total').val();

	if ((shredder_no) && (entry_date) && (site_name) && (plant_name) && (user_name) && (over_total != '0') && (shredder_name)) {

		var sendInfo = {

			random_no: random_no,

			random_sc: random_sc,

			shredder_no: shredder_no,

			entry_date: entry_date,

			site_name: site_name,

			shredder_name: shredder_name,

			plant_name: plant_name,

			description: description,

			user_name: user_name,

		};

		$.ajax({

			type: "POST",

			url: "model/shredder_entry_form.php?action=SUBMIT",

			data: sendInfo,

			success: function (data) {
				//alert(data);


				$("#curd_message").html(data);

				$("#curd_message").delay(5000).fadeOut();

				$("#shredder_entry_list_div").load("index1.php?hopen=shredder_entry_form/admin #example");

				window.location.reload(true);

				hide_dialog();

			},

			error: function () {

				alert('error handing here');

			}

		});

	} else {
		validate_shredder_entry_main(shredder_no, entry_date, site_name, plant_name, user_name, over_total, shredder_name);

	}

}



function update_shredder_main_entry(random_no, random_sc, shredder_no, entry_date, site_name, plant_name, shredder_name, description, user_name, update_id) {
	var over_total = $('#over_total').val();

	if ((shredder_no) && (entry_date) && (site_name) && (plant_name) && (user_name) && (user_name != '0') && (shredder_name)) {
		var sendInfo = {

			random_no: random_no,

			random_sc: random_sc,

			shredder_no: shredder_no,

			entry_date: entry_date,

			site_name: site_name,
			plant_name: plant_name,
			shredder_name: shredder_name,



			description: description,

			user_name: user_name,

		};

		$.ajax({

			type: "POST",

			url: "model/shredder_entry_form.php?action=UPDATE&update_id=" + update_id,

			data: sendInfo,

			success: function (data) {

				$("#curd_message").html(data);

				$("#curd_message").delay(5000).fadeOut();

				//$( "#panel_reading_list_div" ).load( "index1.php?hopen=panel_reading_form/admin&from_date="+from_date+"&to_date="+to_date+"&site_name="+site_name+"&plant_name="+plant_name );

				//alert(data);
				window.location.href = "index1.php?hopen=shredder_entry_form/admin&from_date=" + from_date + "&to_date=" + to_date + "&site_name=" + site_name + "&plant_name=" + plant_name;

				window.location.reload(true);

				hide_dialog();

			},

			error: function () {

				alert('error handing here');

			}

		});

	}

	else {

		validate_shredder_entry_main(shredder_no, entry_date, site_name, plant_name, user_name, over_total, shredder_name);

	}

}



function delete_shredder_entry_main(delete_id, shredder_no, random_no, random_sec, from_date, to_date, site_name, plant_name) {

	if (confirm("Are you sure?")) {

		$.ajax({

			type: "POST",

			url: "model/shredder_entry_form.php?action=delete&delete_id=" + delete_id + "&shredder_no=" + shredder_no + "&random_no=" + random_no + "&random_sec=" + random_sec,

			success: function (data) {




				$("#curd_message").html(data);

				$("#curd_message").delay(5000).fadeOut();

				//$( "#shredder_entry_list_div" ).load( "index1.php?hopen=shredder_entry_form/admin #example" );
				window.location.href = "index1.php?hopen=shredder_entry_form/admin&from_date=" + from_date + "&to_date=" + to_date + "&site_name=" + site_name + "&plant_name=" + plant_name;

				//window.location.reload(true);

				hide_dialog();

			},

			error: function () {

				alert('error handing here');

			}

		});

	}

}





function validate_shredder_entry_sublist(shredder_no, entry_date, site_name, plant_name, user_name, type, opening, closing, total_value, shredder_name) {
	if (shredder_no === '') { $("#shredder_no").addClass('errorClass'); return false; } else { $("#shredder_no").addClass('successClass'); }
	if (entry_date === '') { $("#entry_date").addClass('errorClass'); return false; } else { $("#entry_date").addClass('successClass'); }

	if (site_name === '') { $("#site_name").addClass('errorClass'); return false; } else { $("#site_name").addClass('successClass'); }

	if (plant_name === '') { $("#plant_name").addClass('errorClass'); return false; } else { $("#plant_name").addClass('successClass'); }
	if (shredder_name === '') { $("#shredder_name").addClass('errorClass'); return false; } else { $("#shredder_name").addClass('successClass'); }

	if (user_name === '') { $("#user_name").addClass('errorClass'); return false; } else { $("#user_name").addClass('successClass'); }

	if (type === '') { $("#type").addClass('errorClass'); return false; } else { $("#type").addClass('successClass'); }

	if (opening === '') { $("#opening").addClass('errorClass'); return false; } else { $("#opening").addClass('successClass'); }

	if (closing === '') { $("#closing").addClass('errorClass'); return false; } else { $("#closing").addClass('successClass'); }


	if (total_value === '') { $("#total_value").addClass('errorClass'); return false; } else { $("#total_value").addClass('successClass'); }

}

function validate_shredder_entry_main(shredder_no, entry_date, site_name, plant_name, user_name, over_total, shredder_name) {
	if (shredder_no === '') { $("#shredder_no").addClass('errorClass'); return false; } else { $("#shredder_no").addClass('successClass'); }
	if (entry_date === '') { $("#entry_date").addClass('errorClass'); return false; } else { $("#entry_date").addClass('successClass'); }

	if (site_name === '') { $("#site_name").addClass('errorClass'); return false; } else { $("#site_name").addClass('successClass'); }

	if (plant_name === '') { $("#plant_name").addClass('errorClass'); return false; } else { $("#plant_name").addClass('successClass'); }

	if (shredder_name === '') { $("#shredder_name").addClass('errorClass'); return false; } else { $("#shredder_name").addClass('successClass'); }

	if (user_name === '') { $("#user_name").addClass('errorClass'); return false; } else { $("#user_name").addClass('successClass'); }
	if (over_total === '0') { $("#sublist_validation").show(); return false; } else { $("#sublist_validation").hide(); $("#sublist_validation").addClass('successClass'); }
}

function get_shredder_service_details() {
	let site_name = $('#site_name').val();
	let plant_name = $('#plant_name').val();
	let shredder_name = $('#shredder_name').val();
	let entry_date = $('#entry_date').val();
	let opening = $('#opening').val();
	let service_status;
	let service_status_val = document.getElementById("service_status");
	let shredder_replace_val = document.getElementById("shredder_replace");
	if (site_name && plant_name && shredder_name && entry_date) {
		if (service_status_val.checked == true) {

			service_status = 1;
			$('#shredder_service_details').show();
			$('#shredder_replace').attr('disabled', 'true');
			$('#shredder_replace').removeAttr('checked');
			$('#reading').removeAttr('disabled');
			$('#service_km').val('0.00');
		}
		else if (service_status_val.checked == false && shredder_replace_val.checked == false) {

			service_status = 0;
			$('#shredder_service_details').hide();
			$('#service_status').removeAttr('checked');
			$('#service_status').removeAttr('disabled');
			$('#shredder_replace').removeAttr('disabled');
			$('#reading').attr('disabled', 'true');

			$('#reading').val('');
			$('#spare_used').val('');
			$('#serviced_by').val('');
			$('#service_description').val('');

			get_yesterday_closing_km();
			$('#service_km').val('0.00');


		} else if (shredder_replace_val.checked == true && service_status_val.checked == false) {

			shredder_replace = 1;
			$('#service_status').attr('disabled', 'true');
			$('#service_status').removeAttr('checked');
			$('#reading').removeAttr('disabled');

			//get_reading_dependsOn_shredder_replace();
			document.getElementById('reading').value = opening;
			//$('#service_km').val('0');
		}
		else {

			shredder_replace = 0;
			$('#service_status').removeAttr('disabled');
			$('#reading').attr('disabled', 'true');
			//get_yesterday_closing_km();

		}
	} else {

		service_status = 0;
		$('#shredder_service_details').hide();

		$('#service_status').removeAttr('checked');
		$('#shredder_replace').removeAttr('checked');

		$('#service_status').attr('disabled', 'true');
		$('#shredder_replace').attr('disabled', 'true');

		$('#reading').attr('disabled', 'true');

		$('#reading').val('');
		$('#spare_used').val('');
		$('#serviced_by').val('');
		$('#service_description').val('');
	}

	$("#reading").removeClass("errorClass").addClass("succesClass");
	$("#serviced_by").removeClass("errorClass").addClass("succesClass");
	$("#spare_used").removeClass("errorClass").addClass("succesClass");
	$("#service_description").removeClass("errorClass").addClass("succesClass");

	get_service_km_calc();

}
function get_service_km_calc() {

	var site_name = $('#site_name').val();
	var plant_name = $('#plant_name').val();
	var shredder_name = $('#shredder_name').val();
	var opening = $('#opening').val();
	var current_opening = $('#last_closing_value').val();
	var entry_date = $('#entry_date').val();
	var service_history_count = $('#service_history_count').val();
	var current_closing = $('#closing').val();
	var current_reading = $('#reading').val();
	var const_km_limit = $('#const_km_limit').val();
	var service_status_val = document.getElementById("service_status");
	let result;
	if (service_status_val.checked == true) {
		var service_status = 1;
	}
	else {
		var service_status = 0;
	}

	var shredder_replace_val = document.getElementById("shredder_replace");
	if (shredder_replace_val.checked == true) {
		var shredder_replace = 1;
	}
	else {
		var shredder_replace = 0;
	}

	if ((site_name) && (plant_name) && (shredder_name) && (entry_date)) {
		if (current_closing != '') {

			if (service_status == 1 || shredder_replace == 1) {
				if (current_reading != '') {
					result = current_closing - current_reading;
					//$('#service_km').val(result);

				} else {
					result = "0";
					//$('#service_km').val('0');
				}
			} else {
				if (service_history_count != 'null') {
					result = current_closing - service_history_count;
					//$('#service_km').val(result1);

				} else {
					result = "0";
					//$('#service_km').val('0');
				}

			}

		} else {
			if (service_history_count != 'null') {
				result = current_opening - service_history_count;
				//$('#service_km').val(result2);
			} else {
				result = "0";
				//$('#service_km').val('0');
			}
		}
	} else {
		result = "0";
		//$('#service_km').val('0');
	}

	//alert("1"+const_km_limit+" - "+"result"+result);
	if (const_km_limit <= result) {
		let error = document.getElementById("check_service_km");
		$('#check_service_km').show();
		error.textContent = "Service Hours is Exceeded";
	}
	else {
		$('#check_service_km').hide();
	}

	var service_km_result =	parseFloat(result);
	const roundedNumber_result = service_km_result.toFixed(2);

	//console.log(result, " - ", roundedNumber_result);

	document.getElementById('service_km').value = (roundedNumber_result);

	//$('#service_km').val(result);
}
function get_reading_value() {
	var site_name = $('#site_name').val();
	var plant_name = $('#plant_name').val();
	var shredder_name = $('#shredder_name').val();
	var entry_date = $('#entry_date').val();
	var closing = $('#closing').val();


	if ((site_name) && (plant_name) && (shredder_name) && (entry_date)) {
		jQuery.ajax({

			type: "GET",

			url: "shredder_entry_form/reading_value.php",

			data: "site_name=" + site_name + "&plant_name=" + plant_name + "&shredder_name=" + shredder_name + "&entry_date=" + entry_date,

			success: function (data) {
				let splited_data_genset = data.split("@@@@");


				document.getElementById('service_history_count').value = splited_data_genset[0];
				document.getElementById('last_closing_value').value = splited_data_genset[1];

				if (splited_data_genset[0] == 'null') {
					$('#service_km').val('0.00');
					$('#service_history_details').hide();
				} else {

					get_service_km_calc();
					$('#service_history_details').show();
				}


			},
			error: function () {
				alert('error handing here');
			}
		});
	} else {
		document.getElementById('service_history_count').value = '';
		document.getElementById('last_closing_value').value = '';
		$('#service_history_details').hide();
	}
}
function freeze_fields() {
	var site_name = $('#site_name').val();
	var plant_name = $('#plant_name').val();
	var shredder_name = $('#shredder_name').val();
	var entry_date = $('#entry_date').val();
	var type = $('#type').val();

	// if ((site_name) && (plant_name) && (shredder_name) && (entry_date)) {
	// 	if(type!=''){
	// 		$('#site_name').attr('disabled', 'true');
	// 		$('#plant_name').attr('disabled', 'true');
	// 		$('#shredder_name').attr('disabled', 'true');
	// 		$('#entry_date').attr('disabled', 'true');

	// 	}else{

	// 		$('#site_name').removeAttr('disabled');
	// 		$('#plant_name').removeAttr('disabled');
	// 		$('#shredder_name').removeAttr('disabled');
	// 		$('#entry_date').removeAttr('disabled');
	// 	}
	// }else{
	// 	$('#site_name').removeAttr('disabled');
	// 	$('#plant_name').removeAttr('disabled');
	// 	$('#shredder_name').removeAttr('disabled');
	// 	$('#entry_date').removeAttr('disabled');
	// }
}
function check_entry_date() {

	var site_name = $('#site_name').val();
	var plant_name = $('#plant_name').val();
	var shredder_name = $('#shredder_name').val();
	var random_no = $('#random_no').val();
	var random_sc = $('#random_sc').val();
	var entry_date = $('#entry_date').val();
	var currentDate = new Date(entry_date);
	var day = String(currentDate.getDate()).padStart(2, '0');
	var month = String(currentDate.getMonth() + 1).padStart(2, '0'); // January is 0
	var year = currentDate.getFullYear();

	// Format the date string
	var formattedDate = day + '-' + month + '-' + year;

	// Display the date
	if (site_name && plant_name && shredder_name && entry_date) {
		$.ajax({
			type: "POST",
			url: "shredder_entry_form/check_entry_date.php",
			data: "site_name=" + site_name + "&plant_name=" + plant_name + "&shredder_name=" + shredder_name + "&random_no=" + random_no + "&random_sc=" + random_sc + "&entry_date=" + entry_date,
			success: function (data) {
				// alert("data"+data);
				if (data == 1) {
					let error = document.getElementById("check_entry_date");
					$('#check_entry_date').show();
					error.textContent = "Already Had Data for Successive Dates,So Not Allowed To Add";
				}
				else {
					$('#check_entry_date').hide();
				}
			},

			error: function () {
				alert('error handing here');
			}
		});
	}
}
function get_yesterday_closing_km() {
	var over_total;
	var site_name = $('#site_name').val();
	var plant_name = $('#plant_name').val();
	var shredder_name = $('#shredder_name').val();
	var random_no = $('#random_no').val();
	var random_sc = $('#random_sc').val();
	var entry_date = $('#entry_date').val();
	var service_status = $('#service_status').val();
	var closing = $('#closing').val();
	var opening = $('#opening').val();
	var shredder_no = $('#shredder_no').val();
	if (site_name && plant_name && shredder_name && entry_date) {
		jQuery.ajax({

			type: "GET",

			url: "shredder_entry_form/closing.php",

			data: "site_name=" + site_name + "&plant_name=" + plant_name + "&entry_date=" + entry_date + "&shredder_name=" + shredder_name,

			success: function (msg) {
				//jQuery("#close_div").html(msg);
				$("#opening").val(msg);
				$("#closing").val('');
				//$("#service_km").val(0);
				// $("#setval").val(msg);
				// shift = msg;
			}

		});
	} else {
		$("#opening").val('');
		$("#closing").val('');
	}
}
function get_service_history_details() {

	let site_name = $('#site_name').val();
	let plant_name = $('#plant_name').val();
	let shredder_name = $('#shredder_name').val();
	let entry_date = $('#entry_date').val();

	onmouseover19 = window.open("shredder_entry_form/shredder_service_history.php?site_id=" + site_name + "&plant_id=" + plant_name + "&shredder_id=" + shredder_name + "&entry_date=" + entry_date, 'onmouseover19', 'height=500,width=900,scrollbars=yes,resizable=no,left=350,top=170,toolbar=no,location=no,directories=no,status=no,menubar=no');
}