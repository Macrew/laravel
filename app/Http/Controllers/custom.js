 $.ajaxSetup({
   headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
});

    $(document).ready(function () {
	//$(".gal_img").responsiveImg();
$(window).scroll(function() {
if ($(this).scrollTop() > 200){  
    $('.compare-top').addClass("sticky");
    $('.comp-right').addClass("add_sticky_width");
  }
  else{
    $('.compare-top').removeClass("sticky");
    $('.comp-right').removeClass("add_sticky_width");
  }
});
 $('#compare_top_images').scroll(function () {
        $('#compare_items').scrollLeft($(this).scrollLeft());
        $('#compare_ajax_inclusion').scrollLeft($(this).scrollLeft());
        $('#compare_all_inclusion').scrollLeft($(this).scrollLeft());
    });
    $('#compare_items').scroll(function () {
		$('#stickey_compare').scrollLeft($(this).scrollLeft());
		$('#compare_top_images').scrollLeft($(this).scrollLeft());
        $('#compare_ajax_inclusion').scrollLeft($(this).scrollLeft());
        $('#compare_all_inclusion').scrollLeft($(this).scrollLeft());
    });
    $('#compare_ajax_inclusion').scroll(function () {
        $('#compare_items').scrollLeft($(this).scrollLeft());
		$('#compare_top_images').scrollLeft($(this).scrollLeft());
		$('#stickey_compare').scrollLeft($(this).scrollLeft());
        $('#compare_all_inclusion').scrollLeft($(this).scrollLeft());
    });	
	  $('#compare_all_inclusion').scroll(function () {
        $('#compare_items').scrollLeft($(this).scrollLeft());
		$('#compare_top_images').scrollLeft($(this).scrollLeft());
		$('#stickey_compare').scrollLeft($(this).scrollLeft());
        $('#compare_ajax_inclusion').scrollLeft($(this).scrollLeft());
    });	
	$('#stickey_compare').scroll(function () {
        $('#compare_items').scrollLeft($(this).scrollLeft());
		$('#compare_top_images').scrollLeft($(this).scrollLeft());
		$('#compare_all_inclusion').scrollLeft($(this).scrollLeft());
        $('#compare_ajax_inclusion').scrollLeft($(this).scrollLeft());
    });	
	//initialize();
$('#left-menu').sidr({
      name: 'sidr-left',
      side: 'left' // By default
});
	$('#mobile-div').on('click',function(){
	 $(window).scrollTop(0);
	var search_text = $(this).text();
	if(search_text == 'Refine Search')
	{
		$('#mobile-div').text('Show Results');
		$('.list_left').show();
		$('.list_mid').hide();
		$('.model_img').slick('setPosition');
	} else {
	
		$('#mobile-div').text('Refine Search');
		$('.list_left').hide();
		$('.list_mid').show();
		$('.model_img').slick('setPosition');
	
	}
	});
	
		$('#land-mobile-div').on('click',function(){
	 $(window).scrollTop(0);
	var search_text = $(this).text();
	if(search_text == 'View Map')
	{
		$('#land-mobile-div').text('View List');
		$('#land_view_map').show();
		google.maps.event.trigger(map, 'resize');
		$('#land_view_list').hide();
	} else {
	
		$('#land-mobile-div').text('View Map');
		$('#land_view_map').hide();
		$('#land_view_list').show();
	
	}
	});
	
	$("#home-t").on('click',function(){
		$(this).addClass('save_active_tab');
		$('#homeland-t').removeClass('save_active_tab');
		$('#home-tab').show();
		$('#home-land-tab').hide();
		$('#home-design-data').show();
		$('#house-land-design').hide();
		$('.model_img').slick('setPosition');
	});
	$("#homeland-t").on('click',function(){
		$(this).addClass('save_active_tab');
		$('#home-t').removeClass('save_active_tab');
		$('#home-tab').hide();
		$('#home-land-tab').show();
		$('#home-design-data').hide();
		$('#house-land-design').show();
		$('.model_img').slick('setPosition');
	});
	
	
	var get_current_url = window.location.href;
	console.log(get_current_url);
	var base_url = $('#base_url').val();
	console.log(base_url);
	if(get_current_url == base_url+'/')
	{
	 if(localStorage.getItem('popState') != 'shown') {
        localStorage.setItem('popState','shown')
    

	var url = base_url+'/get_user_current_location';
		$.ajax({
		type:'get',
		url:url,
		crossDomain:true, 
		success:function(data)
		{
	
			$.notify({
	// options
	title: 'Added to saved homes!',
	message: 'You can save up-to 3 designs without registration',
	other: 'Hayman 25 (Kingston)'
},{
	// settings
	element: 'body',
	position: null,
	type: "info",
	allow_dismiss: true,
	newest_on_top: false,
	showProgressbar: false,
	placement: {
		from: "top",
		align: "right"
	},
	offset: 20,
	spacing: 10,
	z_index: 9999999,
	 delay: 5000000,
	timer: 5000000, 
	url_target: '_blank',
	mouse_over: null,
	animate: {
		enter: 'animated fadeInDown',
		exit: 'animated fadeOutUp'
	},
	onShow: null,
	onShown: null,
	onClose: null,
	onClosed: null,
	icon_type: 'class',
	template: '<div data-notify="container" class="col-xs-11 col-sm-2 alert alert-{0} notify-div" style="top:56px !important;" role="alert"><button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button><div class="notification notification--location js-notification--location" id="locationNotification"><div class="notification__wrapper"><div class="notification-wrapper"><div class="notificationbody><div class="notificationbody-content"><p class="primary">We found you in VIC!</p><p class="primary hidden-xs"><a href="javascript:void(0);" class="btn btn-green js-notification_remove-link" data-notify="dismiss">Okay thanks</a></p><p class="secondary">Change your preferred state</p><ul class="list-unstyled list-inline"><li><a href="/change-state/VIC">VIC</a></li><li><a href="/change-state/NSW">NSW</a></li><li><a href="/change-state/QLD">QLD</a></li><li><a href="/change-state/WA">WA</a></li></ul></div></div></div></div></div>'
});

}
});

}

}
	
	$("input[name='email']").attr("autocomplete","off");

	$('.related_detail').on('click',function(){
		var rel = $(this).attr('rel');
		var vill = $(this).attr('data-vill');
		if(rel == 'more') {
			$('.read_less_'+vill).slideDown();
			$('.read_more_'+vill).slideUp();
			} else {
				$('.read_more_'+vill).slideDown();
				$('.read_less_'+vill).slideUp();
			
			}
	});
	
	$(document).on('click','.book_appointment',function() {
	//alert($(this).attr('rel'));
	var rel = $(this).attr('rel');
	var data_string ='display_village='+rel;
	var base_url = $('#base_url').val();

var url = base_url+'/property/book_appointment_html';
var url1 = base_url+'/property/get_time_dropdown';
    $.fancybox.open({
        href: url,
        type: "ajax",
        ajax: {
            type: "POST",
			crossDomain:true, 
            data: data_string
        },
		afterShow: function(){
		var date = new Date();
date.setDate(date.getDate()+1);

           $('#date').datepicker({
		   startDate: date,
		   autoclose:true,
		   useCurrent : { Default: false },
		   format: "dd-mm-yyyy"
		   }).on('change.dp', function (e) {
            var date1 = $('#date').val().split("-");
			var weekday = new Array(7);
weekday[0]=  "Sunday";
weekday[1] = "Monday";
weekday[2] = "Tuesday";
weekday[3] = "Wednesday";
weekday[4] = "Thursday";
weekday[5] = "Friday";
weekday[6] = "Saturday";
var myDate = new Date(date1[2], date1[1] - 1, date1[0]);
var selected_day = weekday[myDate.getDay()]; 
	$('#appoint-time').attr('disabled',false);
	var display_home_id = $('#display_home_id').val();
	var datastring1 = 'selected_day='+selected_day+'&display_home_id='+display_home_id;
	$.ajax({
	type:'post',
		url:url1,
		data:datastring1,
		crossDomain:true, 
		success:function(data)
		{
			/* alert(data); */
			$('#appoint-time').html(data);
		}
	});
	
    });
	
	$('input[name="display_village_check"]').change(function () {
	var save_check = $('input[name="display_village_check"]:checked').length;
	//alert(save_check);
	if(save_check == 0)
	{
		$('.appoint_home_next').prop('disabled', true);
	} else {
		$('.appoint_home_next').prop('disabled', false);
	}
	
	 var homeids = $('input[name=display_village_check]:checked').map(function()
            {
                return $(this).val();
            }).get();
	//console.log(homeids);
	$('#display_home_ids1').val(homeids);
	$('#display_home_ids').val(homeids);
	});
        }
    });
	$(document).on("click",'.appoint-home',function(){
		$('#select-home').show();
		$('.appoint-date-div').hide();
	$('.detail').hide();
	});
	$(document).on("click",'.appoint-date',function(){
		$('#select-home').hide();
		$('.appoint-date-div').show();
	$('.detail').hide();
	});
	
	$(document).on("click",'.appoint-details',function(){
		$('#select-home').hide();
		$('.appoint-date-div').hide();
	$('.detail').show();
	});
	
	
	$(document).on("click",'.appoint_home_next',function(){
		$('#select-home').hide();
		$('.appoint-date-div').show();
	});
	
	$(document).on("click",'.appoint_date_next',function(){
	var status = true;
	var date = $('#date').val();
	var time = $('#appoint-time').val();
	var homeid = $('#display_home_ids').val();
		if(date == 'Select Date')
		{
			alert('Please Select Appointment date');
			status = false;
		}
		if(time == 'Select Time')
		{
			alert('Please Select Appointment Time');
			status = false;
		}
		if(status == true) {
		
		$('#new_display_home').val(homeid);
		$('#new_date').val(date);
		$('#new_time').val(time);
		$('#select-home').hide();
		$('.appoint-date-div').hide();
		$('.detail').show();
		}
		
	});
	
	$(document).on("click",'.appoint_detail_next',function(){
	var status = true;
	var date = $('#date').val();
	var time = $('#appoint-time').val();
	var homeid = $('#display_home_ids').val();
	var firstname = $('#firstname_pro').val();
	var lastname = $('#lastname_pro').val();
	var email = $('#email_pro').val();
	var phn_no = $('#phn_no_pro').val();
		if(date == 'Select Date' || date == '')
		{
			alert('Please Select Appointment date');
			status = false;
		}
		else if(time == 'Select Time' ||  time == '')
		{
			alert('Please Select Appointment Time');
			status = false;
		}
		else if(firstname == 'First name' || firstname == '')
		{
			alert('Please enter FirstName');
			status = false;
		}
		else if(lastname == 'Last name' || lastname == '')
		{
			alert('Please enter Lastname');
			status = false;
		}
		else if(email == 'Email' || email == '')
		{
			alert('Please enter email');
			status = false;
		}
		else if(phn_no == 'Phone (include area code if not mobile)' || phn_no == '')
		{
			alert('Please enter Phone number');
			status = false;
		}
		else if($('#book_appoint_terms').is(':checked') == false)
		{
			alert('Please accept icompare terms & conditions');
			status = false;
		}
		if(status == true) {
		
		var url3 = base_url+'/property/send_appointment_detail';
		var datastring4 = 'date='+date+'&time='+time+'&firstname='+firstname+'&lastname='+lastname+'&email='+email+'&phn_no='+phn_no+'&homeid='+homeid;
		jQuery('.loading').show();
  jQuery('.loading').addClass('loaderimg');
	$.ajax({
	type:'post',
		url:url3,
		data:datastring4,
		crossDomain:true, 
		success:function(data)
		{
			 if(data ==  'success') {
			 	jQuery('.loading').hide();
    jQuery('.loading').removeClass('loaderimg');
			$('#select-home').hide();
			$('.appoint-date-div').hide();
			$('.detail').hide();
			 $('.complete').show();
			 }
			//$('#appoint-time').html(data);
		}
	});
		
		/* $('#new_display_home').val(homeid);
		$('#new_date').val(date);
		$('#new_time').val(time);
		$('#select-home').hide();
		$('.appoint-date-div').hide();
		$('.detail').show(); */
		}
		
	});
	
	
});


/* Book appointment for Display land */

	$(document).on('click','.book_land_appointment',function() {
	//alert($(this).attr('rel'));
	var rel = $(this).attr('rel');
	var data_string ='display_village='+rel;
	var base_url = $('#base_url').val();

var url = base_url+'/land/book_land_appointment_html';
var url1 = base_url+'/land/get_land_time_dropdown';
    $.fancybox.open({
        href: url,
        type: "ajax",
        ajax: {
            type: "POST",
			crossDomain:true, 
            data: data_string
        },
		afterShow: function(){
		var date = new Date();
date.setDate(date.getDate()+1);

           $('#date').datepicker({
		   startDate: date,
		   autoclose:true,
		   useCurrent : { Default: false },
		   format: "dd-mm-yyyy"
		   }).on('change.dp', function (e) {
            var date1 = $('#date').val().split("-");
			var weekday = new Array(7);
weekday[0]=  "Sunday";
weekday[1] = "Monday";
weekday[2] = "Tuesday";
weekday[3] = "Wednesday";
weekday[4] = "Thursday";
weekday[5] = "Friday";
weekday[6] = "Saturday";
var myDate = new Date(date1[2], date1[1] - 1, date1[0]);
var selected_day = weekday[myDate.getDay()]; 
	$('#appoint-time').attr('disabled',false);
	var display_home_id = $('#display_home_id').val();
	var datastring1 = 'selected_day='+selected_day+'&display_home_id='+display_home_id;
	$.ajax({
	type:'post',
		url:url1,
		data:datastring1,
		crossDomain:true, 
		success:function(data)
		{
			/* alert(data); */
			$('#appoint-time').html(data);
		}
	});
	
    });
	
	$('input[name="display_village_check"]').change(function () {
	var save_check = $('input[name="display_village_check"]:checked').length;
	//alert(save_check);
	if(save_check == 0)
	{
		$('.appoint_land_next').prop('disabled', true);
	} else {
		$('.appoint_land_next').prop('disabled', false);
	}
	
	 var homeids = $('input[name=display_village_check]:checked').map(function()
            {
                return $(this).val();
            }).get();
	//console.log(homeids);
	$('#display_home_ids1').val(homeids);
	$('#display_home_ids').val(homeids);
	});
        }
    });
	$(document).on("click",'.appoint-home',function(){
		$('#select-home').show();
		$('.appoint-date-div').hide();
	$('.detail').hide();
	});
	$(document).on("click",'.appoint-date',function(){
		$('#select-home').hide();
		$('.appoint-date-div').show();
	$('.detail').hide();
	});
	
	$(document).on("click",'.appoint-details',function(){
		$('#select-home').hide();
		$('.appoint-date-div').hide();
	$('.detail').show();
	});
	
	
	$(document).on("click",'.appoint_land_next',function(){
		$('#select-home').hide();
		$('.appoint-date-div').show();
	});
	
	$(document).on("click",'.appoint_landdate_next',function(){
	var status = true;
	var date = $('#date').val();
	var time = $('#appoint-time').val();
	var homeid = $('#display_home_ids').val();
		if(date == 'Select Date')
		{
			alert('Please Select Appointment date');
			status = false;
		}
		if(time == 'Select Time')
		{
			alert('Please Select Appointment Time');
			status = false;
		}
		if(status == true) {
		
		$('#new_display_home').val(homeid);
		$('#new_date').val(date);
		$('#new_time').val(time);
		$('#select-home').hide();
		$('.appoint-date-div').hide();
		$('.detail').show();
		}
		
	});
	
	$(document).on("click",'.appoint_landdetail_next',function(){
	var status = true;
	var date = $('#date').val();
	var time = $('#appoint-time').val();
	var homeid = $('#display_home_ids').val();
	var firstname = $('#firstname1').val();
	var lastname = $('#lastname1').val();
	var email = $('#email1').val();
	var phn_no = $('#phn_no1').val();
	
		if(date == 'Select Date' || date == '')
		{
			alert('Please Select Appointment date');
			status = false;
		}
		else if(time == 'Select Time' ||  time == '')
		{
			alert('Please Select Appointment Time');
			status = false;
		}
		else if(firstname == '')
		{
			alert('Please enter FirstName');
			status = false;
		}
		else if(lastname == 'Last name' || lastname == '')
		{
			alert('Please enter Lastname');
			status = false;
		}
		else if(email == 'Email' || email == '')
		{
			alert('Please enter email');
			status = false;
		}
		else if(phn_no == 'Phone (include area code if not mobile)' || phn_no == '')
		{
			alert('Please enter Phone number');
			status = false;
		}
		else if($('#book_appoint_terms1').is(':checked') == false)
		{
			alert('Please accept icompare terms & conditions');
			status = false;
		}
		if(status == true) {
		
		var url3 = base_url+'/land/send_land_appointment_detail';
		var datastring4 = 'date='+date+'&time='+time+'&firstname='+firstname+'&lastname='+lastname+'&email='+email+'&phn_no='+phn_no+'&homeid='+homeid;
		jQuery('.loading').show();
  jQuery('.loading').addClass('loaderimg');
	$.ajax({
	type:'post',
		url:url3,
		data:datastring4,
		crossDomain:true, 
		success:function(data)
		{
			 if(data ==  'success') {
			 	jQuery('.loading').hide();
    jQuery('.loading').removeClass('loaderimg');
			$('#select-home').hide();
			$('.appoint-date-div').hide();
			$('.detail').hide();
			 $('.complete').show();
			 }
			//$('#appoint-time').html(data);
		}
	});
		
		/* $('#new_display_home').val(homeid);
		$('#new_date').val(date);
		$('#new_time').val(time);
		$('#select-home').hide();
		$('.appoint-date-div').hide();
		$('.detail').show(); */
		}
		
	});
	
	
});





$(document).on('click','.land_enquire',function() {
var base_url = $('#base_url').val();
var landids = $('input[name=landlistcheck]:checked').map(function()
            {
                return $(this).val();
            }).get();
	//console.log(landids);
 var url = base_url+'/land/enquire_land';
var datastring = 'landids='+landids;
  $.fancybox.open({
        href: url,
        type: "ajax",
        ajax: {
            type: "POST",
			crossDomain:true, 
            data: datastring
        },
		afterShow: function(){
		$('#enquire_land_user').on('click',function(){
			/* alert('test'); */
			var fromName = $('#fromName').val();
			var fromAddress = $('#fromAddress').val();
			var fromPhone = $('#fromPhone').val();
			var lookingTo = $('#lookingTo').val();
			var message = $('#message').val();
			var status = true;
			if(fromName == "")
			{
				alert('Enter your Name');
				status = false;
			}
			if(fromAddress  == "")
			{
				alert('Enter your Email');
				status = false;
			}
			/* alert(status) */
			
			if(status == true) {
			/* alert('eee'); */
			var datastring1 = $("#emailPropertyAgentPopupForm").serializeArray();
			var url1 = base_url+'/land/send_email_land';
			jQuery('.loading').show();
  jQuery('.loading').addClass('loaderimg');
				$.ajax ({
			url:url1,
            type: "post",
			crossDomain:true, 
            data: {data:datastring1},
			success:function(data)
			{
				if(data=='success') {
				jQuery('.loading').hide();
				jQuery('.loading').removeClass('loaderimg');
					$('#message-popup').show();
					$('#enquire_form').hide();
				}
			}
			});
	
			
			}
			
			
		});
	
        }
    }); 
});


$(document).on('click','.lands_enquire',function() {
var base_url = $('#base_url').val();
var landids = $('#land_id').val();
	//console.log(landids);
 var url = base_url+'/land/enquire_land';
var datastring = 'landids='+landids;
  $.fancybox.open({
        href: url,
        type: "ajax",
        ajax: {
            type: "POST",
			crossDomain:true, 
            data: datastring
        },
		afterShow: function(){
		$('#enquire_land_user').on('click',function(){
			//alert('test');
			var fromName = $('#fromName').val();
			var fromAddress = $('#fromAddress').val();
			var fromPhone = $('#fromPhone').val();
			var lookingTo = $('#lookingTo').val();
			var message = $('#message').val();
			var status = true;
			if(fromName == "")
			{
				alert('Enter your Name');
				status = false;
			}
			if(fromAddress  == "")
			{
				alert('Enter your Email');
				status = false;
			}
			if($('#pland_agree').is(':checked')== false)
			{
				alert('Please Confirm terms & conditions.');
				status = false;
			}
			//alert(status)
			
			if(status == true) {
			//alert('eee');
			var datastring1 = $("#emailPropertyAgentPopupForm").serializeArray();
			var url1 = base_url+'/land/send_email_land';
				jQuery('.loading').show();
  jQuery('.loading').addClass('loaderimg');
				$.ajax ({
			url:url1,
            type: "post",
			crossDomain:true, 
            data: {data:datastring1},
			success:function(data)
			{
				if(data=='success') {
					jQuery('.loading').hide();
    jQuery('.loading').removeClass('loaderimg');
					$('#message-popup').show();
					$('#enquire_form').hide();
				}
			}
			});
	
			
			}
			
			
		});
	
        }
    }); 
});



$('.selectpicker').selectpicker({
 style: 'btn-info',
 size: 10
 });
 $('.menu').on('click', function(){
    //$('.sub_menu').toggle();
	 $(this).children('ul.sub_menu').toggle();
});
var base_url = $('#base_url').val();
$('.model_img').slick({               
prevArrow: '<div class="arrow_left1"><img src="'+base_url+'/assets/img/slide_lt.png" /></div>',
nextArrow: ' <div class="arrow_right1"><img src="'+base_url+'/assets/img/slide_rt.png" /></div>'
});
$('.propery_mainslider').slick({
	infinite: true,
	slidesToShow: 1,
	adaptiveHeight: false,
	arrows: false
});
$(".main_slider_next").click(function(e) { // Added a '.'
    $(".propery_mainslider").slick('slickNext'); // Switched to '.slick-slider'
});
$(".main_slider_prev").click(function(e) { // Added a '.'
    $(".propery_mainslider").slick('slickPrev'); // Switched to '.slick-slider'
});

$('.enq-slides').slick({
	infinite: true,
	slidesToShow: 1,
	adaptiveHeight: false,
	arrows: false
});
$(".main_slider_next1").click(function(e) { // Added a '.'
    $(".enq-slides").slick('slickNext'); // Switched to '.slick-slider'
});
$(".main_slider_prev1").click(function(e) { // Added a '.'
    $(".enq-slides").slick('slickPrev'); // Switched to '.slick-slider'
});


$('.register').on('click',function(){
$('.compare-pop').toggle();
});

 $('[data-toggle="tooltip"]').tooltip();   


$('.collaptable').aCollapTable({ 
    startCollapsed: true,
    addColumn: false, 
    plusButton: '<span class="i">+</span>', 
    minusButton: '<span class="i">-</span>' 
  });


 
 
 
 /* LandEstate Location  Search */

$('#display_land_search').on('click',function() {

	var land_estate_location = $("#search_region1 option:selected").val();
	
	var datastring1 = 'land_estate_location='+land_estate_location;
	var datastring = 'land_estate_location='+land_estate_location;
	init_ajax_lands(datastring,datastring1);
});

function check_null_val(json_val)
{
	var json = ""
	if(typeof json_val !== "undefined")
	{
		json = json_val
		return json;
	} else {
		return json;
	}
}
 
 function init_google_map(data)
{
	var base_url = $('#base_url').val();
	  var imageUrl = base_url+"/assets/img/map-pin.png";
		$('#display_count').html(data.total_display_lands);
        var markers = [];
	 var position = new google.maps.LatLng(-25.274398, 133.775136);
	map = new google.maps.Map(document.getElementById("map"));
	map.setZoom(5);
	map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
	map.setCenter(new google.maps.LatLng(-25.274398, 133.775136)); 
	var bounds = new google.maps.LatLngBounds();
		$.each(data, function(i, item) {
		if(typeof data[i] === "object") {		
	   	if(typeof data[i].geo_lat !== "undefined") {		
			var lat  = check_null_val(data[i].geo_lat);
			var html = '';
			var html1 = '';
			var title = data[i].display_village_title;
			var rtitle = title.replace(/[^A-Za-z0-9\. -]/, '');
			
			var display_location = data[i].display_location;
			var rdisplay_location = display_location.replace(/[^A-Za-z0-9\. -]/, '');
			 var longit  = check_null_val(data[i].geo_lng);
			 if(lat != 0 || longit != 0) {

			   var pt = new google.maps.LatLng(lat, longit);
				bounds.extend(pt);
			html+= '<div class="map_wrap"><a href="'+base_url+'/land/view/'+data[i].landestate_id+'"><img src='+base_url+'/uploads/landestate_logo/'+data[i].image+' class="map-logo" /></a><div class="dv-left-btm map-popup-data"><div class="dv-left-btm-inner"><div class="dv-left-btm-box"><h3>'+rtitle+'</h3><p>'+rdisplay_location+'</p></div><div class="dv-left-btm-box"><h4>Open hours</h4>';
			var open_hours =  data[i].open_hours;
				$.each(open_hours , function(k, item) { 
				
				html+= '<p>'+open_hours[k].day+" "+open_hours[k].start_time+" - "+open_hours[k].end_time+'</p>';
				
				});
				
				html+= '</div><a rel="'+data[i].id+'" class="see_all book_land_appointment map-button" href=javascript:void(0)>Book Appointment</a><br/><br/><a  class="open_landmasterplan" value="Enquire to Builders"  data-target="masterplan" data-id = '+data[i].landestate_id+'  href="javascript:void(0);" data-toggle="modal"><img src='+base_url+'/assets/img/floor.png>Master Plan</a></div></div></div>';
				//addMarker(lat,longit ,html);	
				var latLng = new google.maps.LatLng(lat,longit);
          var marker = new google.maps.Marker({
            position: latLng,
           icon: markerImage
          });		
		  
		    google.maps.event.addListener(marker, 'click', function() {
            var infowindow = new google.maps.InfoWindow({
              content: html,
			   maxWidth: 300
            });
            infowindow.open(map, this);
          });
		  html1+= '<div class="map_wrap"><img src='+base_url+'/uploads/landestate_logo/'+data[i].image+' class="map-logo" /><div>'; 
		  var infowindow1 = new google.maps.InfoWindow({maxWidth: 150})
		   google.maps.event.addListener(marker, 'mouseover', (function (marker, html1, infowindow1) {
            return function () {
                infowindow1.setContent(html1);
                infowindow1.open(map, marker);
            };
        })(marker, html1, infowindow1));
        google.maps.event.addListener(marker, 'mouseout', (function (marker, html1, infowindow1) {
            return function () {
                infowindow1.close();
            };
        })(marker, html1, infowindow1));

		  
          markers.push(marker);
		  
			 }
		}		
		}
	});

  var markerCluster = new MarkerClusterer(map, markers);
map.fitBounds(bounds);
}

 
 function init_ajax_lands(datastring,datastring1)
{
	var base_url = $('#base_url').val();
	var url = base_url+'/lands/ajax_filter_lands';
	jQuery('.loading').show();
  jQuery('.loading').addClass('loaderimg');
	//$('#ajaxloader').html('<img src="'+base_url+'/assets/img/loading-x.gif">');
	$.ajax({
		type:'post',
		url:url,
		data:datastring,
		crossDomain:true, 
		success:function(data)
		{
			$('#ajax_content').html(data);

		}
	
	});
	
	
	var count_url = base_url+'/lands/ajax_filter_count_lands';
	
	// count total properties
	$.ajax({
		type:'post',
		url:count_url,
		data:datastring1,
		crossDomain:true, 
		success:function(data)
		{
			$('.prop_count').html(data);
		}
	});
	
	var count_url = base_url+'/lands/ajax_filter_map_lands';
	
	// count total properties
	$.ajax({
		type:'post',
		url:count_url,
		data:datastring,
		crossDomain:true, 
		dataType:'json',
		success:function(data)
		{
			init_google_map(data);
			$('.landlistcheckbox').on('change',function(){
var save_check = $('input[name="landlistcheck"]:checked').length;
//alert(save_check);
if(save_check == 0)
	{
		$('.land_enquire').prop('disabled', true);
	} else {
		$('.land_enquire').prop('disabled', false);
	}
	 var propids = $('input[name=landlistcheck]:checked').map(function()
            {
                return $(this).val();
            }).get();
	//console.log(propids);
var propertyids = 'property_ids='+propids;
var base_url = $('#base_url').val();
var url2 = base_url+'/property/contact?'+propertyids;	
$('#save_enquire_url').val(url2);

});
			jQuery('.loading').hide();
    jQuery('.loading').removeClass('loaderimg');
			lands_ajax_pagination();
		}
	});
	
}
 
 
 
function lands_ajax_pagination()
{
$('.land_pagi').on('click',function(e) {
e.preventDefault();
var page = $(this).attr('rel');
/* alert(page); */

 var land_estate_location = $("#search_region1 option:selected").val();
	
	var datastring1 = 'land_estate_location='+land_estate_location;
	var datastring = 'land_estate_location='+land_estate_location+'&page='+page;
	
	init_ajax_lands(datastring,datastring1);
	
});
}
 


/* Builder Location  Search */

$('#build_location').on('change',function() {
	/* alert($(this).val()); */
	var bedroom = $("#bedrooms option:selected").val();
	var build_location = $("#build_location option:selected").val();
	var bathrooms = $("#bathrooms option:selected").val();
	var living_spaces = $("#living_spaces option:selected").val();
	var car_spaces = $("#car_spaces option:selected").val();
	var floor_count = $("#floor_count option:selected").val();
	var alfresco = $("#alfresco option:selected").val();
	var duplex = $("#duplex option:selected").val();
	var builder = $("#spe-builder option:selected").val();
	var min_price_val = $("#filter_min_price").val();
	var max_price_val = $("#filter_max_price").val();
	var mi_block_width = $("#filter_min_width").val();
	var ma_block_width = $("#filter_max_width").val();
	var mi_block_length = $("#filter_min_length").val();
	var ma_block_length = $("#filter_max_length").val();
	var min_house_size = $("#filter_min_hsize").val();
	var max_house_size = $("#filter_max_hsize").val();
	var min_hland_size = $("#filter_min_hlandsize").val();
	var max_hland_size = $("#filter_max_hlandsize").val();
	
	var sort_prop = $("#sort_prop option:selected").val();
	var incids = $('input[name=filter_inclusion]:checked').map(function()
            {
                return $(this).val();
            }).get();
	var datastring1 = 'build_location='+build_location+'&bedroom='+bedroom+'&bathrooms='+bathrooms+'&living_spaces='+living_spaces+'&car_spaces='+car_spaces+'&floor_count='+floor_count+'&alfresco='+alfresco+'&duplex='+duplex+'&builder='+builder+'&min_price_val='+min_price_val+'&max_price_val='+max_price_val+'&min_block_width='+mi_block_width+'&max_block_width='+ma_block_width+'&min_block_length='+mi_block_length+'&max_block_length='+ma_block_length+'&min_house_size='+min_house_size+'&max_house_size='+max_house_size+'&sort_prop='+sort_prop+'&incids='+incids;
	var datastring = 'build_location='+build_location+'&bedroom='+bedroom+'&bathrooms='+bathrooms+'&living_spaces='+living_spaces+'&car_spaces='+car_spaces+'&floor_count='+floor_count+'&alfresco='+alfresco+'&duplex='+duplex+'&builder='+builder+'&min_price_val='+min_price_val+'&max_price_val='+max_price_val+'&min_block_width='+mi_block_width+'&max_block_width='+ma_block_width+'&min_block_length='+mi_block_length+'&max_block_length='+ma_block_length+'&min_house_size='+min_house_size+'&max_house_size='+max_house_size+'&sort_prop='+sort_prop+'&incids='+incids;
	var house_lands = $('#house_lands').val();
	if(house_lands == 'house_lands_page') {
	datastring1+=  '&min_hland_size='+min_hland_size+'&max_hland_size='+max_hland_size;
	datastring+=  '&min_hland_size='+min_hland_size+'&max_hland_size='+max_hland_size;
	init_ajax_house_land_properties(datastring,datastring1);
	} else {
		init_ajax_properties(datastring,datastring1);
	}
	
});



/* Bedrooms Search */


$('#bedrooms').on('change',function() {
	var bedroom = $(this).val() ;
	var build_location = $("#build_location option:selected").val();
	var bathrooms = $("#bathrooms option:selected").val();
	var living_spaces = $("#living_spaces option:selected").val();
	var car_spaces = $("#car_spaces option:selected").val();
	var floor_count = $("#floor_count option:selected").val();
	var alfresco = $("#alfresco option:selected").val();
	var duplex = $("#duplex option:selected").val();
	var builder = $("#spe-builder option:selected").val();
	var min_price_val = $("#filter_min_price").val();
	var max_price_val = $("#filter_max_price").val();
	var mi_block_width = $("#filter_min_width").val();
	var ma_block_width = $("#filter_max_width").val();
	var mi_block_length = $("#filter_min_length").val();
	var ma_block_length = $("#filter_max_length").val();
	var min_house_size = $("#filter_min_hsize").val();
	var max_house_size = $("#filter_max_hsize").val();
	var sort_prop = $("#sort_prop option:selected").val();
	var incids = $('input[name=filter_inclusion]:checked').map(function()
            {
                return $(this).val();
            }).get();
	var min_hland_size = $("#filter_min_hlandsize").val();
	var max_hland_size = $("#filter_max_hlandsize").val();
	
	var datastring1 = 'build_location='+build_location+'&bedroom='+bedroom+'&bathrooms='+bathrooms+'&living_spaces='+living_spaces+'&car_spaces='+car_spaces+'&floor_count='+floor_count+'&alfresco='+alfresco+'&duplex='+duplex+'&builder='+builder+'&min_price_val='+min_price_val+'&max_price_val='+max_price_val+'&min_block_width='+mi_block_width+'&max_block_width='+ma_block_width+'&min_block_length='+mi_block_length+'&max_block_length='+ma_block_length+'&min_house_size='+min_house_size+'&max_house_size='+max_house_size+'&sort_prop='+sort_prop+'&incids='+incids;
	var datastring = 'build_location='+build_location+'&bedroom='+bedroom+'&bathrooms='+bathrooms+'&living_spaces='+living_spaces+'&car_spaces='+car_spaces+'&floor_count='+floor_count+'&alfresco='+alfresco+'&duplex='+duplex+'&builder='+builder+'&min_price_val='+min_price_val+'&max_price_val='+max_price_val+'&min_block_width='+mi_block_width+'&max_block_width='+ma_block_width+'&min_block_length='+mi_block_length+'&max_block_length='+ma_block_length+'&min_house_size='+min_house_size+'&max_house_size='+max_house_size+'&sort_prop='+sort_prop+'&incids='+incids;
	//console.log(datastring);
	var base_url = $('#base_url').val();
	var house_lands = $('#house_lands').val();
	if(house_lands == 'house_lands_page') {
	datastring1+=  '&min_hland_size='+min_hland_size+'&max_hland_size='+max_hland_size;
	datastring+=  '&min_hland_size='+min_hland_size+'&max_hland_size='+max_hland_size;
	init_ajax_house_land_properties(datastring,datastring1);
	} else {
		init_ajax_properties(datastring,datastring1);
	}
});


$('#bathrooms').on('change',function() {
	/* alert($(this).val()); */
	var bedroom = $("#bedrooms option:selected").val();
	var build_location = $("#build_location option:selected").val();
	var bathrooms = $("#bathrooms option:selected").val();
	var living_spaces = $("#living_spaces option:selected").val();
	var car_spaces = $("#car_spaces option:selected").val();
	var floor_count = $("#floor_count option:selected").val();
	var alfresco = $("#alfresco option:selected").val();
	var duplex = $("#duplex option:selected").val();
	var builder = $("#spe-builder option:selected").val();
	var min_price_val = $("#filter_min_price").val();
	var max_price_val = $("#filter_max_price").val();
	var mi_block_width = $("#filter_min_width").val();
	var ma_block_width = $("#filter_max_width").val();
	var mi_block_length = $("#filter_min_length").val();
	var ma_block_length = $("#filter_max_length").val();
	var min_house_size = $("#filter_min_hsize").val();
	var max_house_size = $("#filter_max_hsize").val();
	var sort_prop = $("#sort_prop option:selected").val();
	var incids = $('input[name=filter_inclusion]:checked').map(function()
            {
                return $(this).val();
            }).get();
	var min_hland_size = $("#filter_min_hlandsize").val();
	var max_hland_size = $("#filter_max_hlandsize").val();
	
	var datastring1 = 'build_location='+build_location+'&bedroom='+bedroom+'&bathrooms='+bathrooms+'&living_spaces='+living_spaces+'&car_spaces='+car_spaces+'&floor_count='+floor_count+'&alfresco='+alfresco+'&duplex='+duplex+'&builder='+builder+'&min_price_val='+min_price_val+'&max_price_val='+max_price_val+'&min_block_width='+mi_block_width+'&max_block_width='+ma_block_width+'&min_block_length='+mi_block_length+'&max_block_length='+ma_block_length+'&min_house_size='+min_house_size+'&max_house_size='+max_house_size+'&sort_prop='+sort_prop+'&incids='+incids;
	var datastring = 'build_location='+build_location+'&bedroom='+bedroom+'&bathrooms='+bathrooms+'&living_spaces='+living_spaces+'&car_spaces='+car_spaces+'&floor_count='+floor_count+'&alfresco='+alfresco+'&duplex='+duplex+'&builder='+builder+'&min_price_val='+min_price_val+'&max_price_val='+max_price_val+'&min_block_width='+mi_block_width+'&max_block_width='+ma_block_width+'&min_block_length='+mi_block_length+'&max_block_length='+ma_block_length+'&min_house_size='+min_house_size+'&max_house_size='+max_house_size+'&sort_prop='+sort_prop+'&incids='+incids;
	//console.log(datastring);
	var base_url = $('#base_url').val();
	var house_lands = $('#house_lands').val();
	if(house_lands == 'house_lands_page') {
	datastring1+=  '&min_hland_size='+min_hland_size+'&max_hland_size='+max_hland_size;
	datastring+=  '&min_hland_size='+min_hland_size+'&max_hland_size='+max_hland_size;
	init_ajax_house_land_properties(datastring,datastring1);
	} else {
		init_ajax_properties(datastring,datastring1);
	}
});

$('#living_spaces').on('change',function() {
	/* alert($(this).val()); */
	var bedroom = $("#bedrooms option:selected").val();
	var build_location = $("#build_location option:selected").val();
	var bathrooms = $("#bathrooms option:selected").val();
	var living_spaces = $("#living_spaces option:selected").val();
	var car_spaces = $("#car_spaces option:selected").val();
	var floor_count = $("#floor_count option:selected").val();
	var alfresco = $("#alfresco option:selected").val();
	var duplex = $("#duplex option:selected").val();
	var builder = $("#spe-builder option:selected").val();
	var min_price_val = $("#filter_min_price").val();
	var max_price_val = $("#filter_max_price").val();
	var mi_block_width = $("#filter_min_width").val();
	var ma_block_width = $("#filter_max_width").val();
	var mi_block_length = $("#filter_min_length").val();
	var ma_block_length = $("#filter_max_length").val();
	var min_house_size = $("#filter_min_hsize").val();
	var max_house_size = $("#filter_max_hsize").val();
	var sort_prop = $("#sort_prop option:selected").val();
	var incids = $('input[name=filter_inclusion]:checked').map(function()
            {
                return $(this).val();
            }).get();
	var min_hland_size = $("#filter_min_hlandsize").val();
	var max_hland_size = $("#filter_max_hlandsize").val();
	
	var datastring1 = 'build_location='+build_location+'&bedroom='+bedroom+'&bathrooms='+bathrooms+'&living_spaces='+living_spaces+'&car_spaces='+car_spaces+'&floor_count='+floor_count+'&alfresco='+alfresco+'&duplex='+duplex+'&builder='+builder+'&min_price_val='+min_price_val+'&max_price_val='+max_price_val+'&min_block_width='+mi_block_width+'&max_block_width='+ma_block_width+'&min_block_length='+mi_block_length+'&max_block_length='+ma_block_length+'&min_house_size='+min_house_size+'&max_house_size='+max_house_size+'&sort_prop='+sort_prop+'&incids='+incids;
	var datastring = 'build_location='+build_location+'&bedroom='+bedroom+'&bathrooms='+bathrooms+'&living_spaces='+living_spaces+'&car_spaces='+car_spaces+'&floor_count='+floor_count+'&alfresco='+alfresco+'&duplex='+duplex+'&builder='+builder+'&min_price_val='+min_price_val+'&max_price_val='+max_price_val+'&min_block_width='+mi_block_width+'&max_block_width='+ma_block_width+'&min_block_length='+mi_block_length+'&max_block_length='+ma_block_length+'&min_house_size='+min_house_size+'&max_house_size='+max_house_size+'&sort_prop='+sort_prop+'&incids='+incids;
	//console.log(datastring);
	var base_url = $('#base_url').val();
	var house_lands = $('#house_lands').val();
	if(house_lands == 'house_lands_page') {
	datastring1+=  '&min_hland_size='+min_hland_size+'&max_hland_size='+max_hland_size;
	datastring+=  '&min_hland_size='+min_hland_size+'&max_hland_size='+max_hland_size;
	init_ajax_house_land_properties(datastring,datastring1);
	} else {
		init_ajax_properties(datastring,datastring1);
	}
});

$('#car_spaces').on('change',function() {
	/* alert($(this).val()); */
	var bedroom = $("#bedrooms option:selected").val();
	var build_location = $("#build_location option:selected").val();
	var bathrooms = $("#bathrooms option:selected").val();
	var living_spaces = $("#living_spaces option:selected").val();
	var car_spaces = $("#car_spaces option:selected").val();
	var floor_count = $("#floor_count option:selected").val();
	var alfresco = $("#alfresco option:selected").val();
	var duplex = $("#duplex option:selected").val();
	var builder = $("#spe-builder option:selected").val();
	var min_price_val = $("#filter_min_price").val();
	var max_price_val = $("#filter_max_price").val();
	var mi_block_width = $("#filter_min_width").val();
	var ma_block_width = $("#filter_max_width").val();
	var mi_block_length = $("#filter_min_length").val();
	var ma_block_length = $("#filter_max_length").val();
	var min_house_size = $("#filter_min_hsize").val();
	var max_house_size = $("#filter_max_hsize").val();
	var sort_prop = $("#sort_prop option:selected").val();
	var incids = $('input[name=filter_inclusion]:checked').map(function()
            {
                return $(this).val();
            }).get();
	var min_hland_size = $("#filter_min_hlandsize").val();
	var max_hland_size = $("#filter_max_hlandsize").val();
	
	var datastring1 = 'build_location='+build_location+'&bedroom='+bedroom+'&bathrooms='+bathrooms+'&living_spaces='+living_spaces+'&car_spaces='+car_spaces+'&floor_count='+floor_count+'&alfresco='+alfresco+'&duplex='+duplex+'&builder='+builder+'&min_price_val='+min_price_val+'&max_price_val='+max_price_val+'&min_block_width='+mi_block_width+'&max_block_width='+ma_block_width+'&min_block_length='+mi_block_length+'&max_block_length='+ma_block_length+'&min_house_size='+min_house_size+'&max_house_size='+max_house_size+'&sort_prop='+sort_prop+'&incids='+incids;
	var datastring = 'build_location='+build_location+'&bedroom='+bedroom+'&bathrooms='+bathrooms+'&living_spaces='+living_spaces+'&car_spaces='+car_spaces+'&floor_count='+floor_count+'&alfresco='+alfresco+'&duplex='+duplex+'&builder='+builder+'&min_price_val='+min_price_val+'&max_price_val='+max_price_val+'&min_block_width='+mi_block_width+'&max_block_width='+ma_block_width+'&min_block_length='+mi_block_length+'&max_block_length='+ma_block_length+'&min_house_size='+min_house_size+'&max_house_size='+max_house_size+'&sort_prop='+sort_prop+'&incids='+incids;
	//console.log(datastring);
	var base_url = $('#base_url').val();
	var house_lands = $('#house_lands').val();
	if(house_lands == 'house_lands_page') {
	datastring1+=  '&min_hland_size='+min_hland_size+'&max_hland_size='+max_hland_size;
	datastring+=  '&min_hland_size='+min_hland_size+'&max_hland_size='+max_hland_size;
	init_ajax_house_land_properties(datastring,datastring1);
	} else {
		init_ajax_properties(datastring,datastring1);
	}
});

$('#car_spaces').on('change',function() {
	/* alert($(this).val()); */
	var bedroom = $("#bedrooms option:selected").val();
	var build_location = $("#build_location option:selected").val();
	var bathrooms = $("#bathrooms option:selected").val();
	var living_spaces = $("#living_spaces option:selected").val();
	var car_spaces = $("#car_spaces option:selected").val();
	var floor_count = $("#floor_count option:selected").val();
	var alfresco = $("#alfresco option:selected").val();
	var duplex = $("#duplex option:selected").val();
	var builder = $("#spe-builder option:selected").val();
	var min_price_val = $("#filter_min_price").val();
	var max_price_val = $("#filter_max_price").val();
	var mi_block_width = $("#filter_min_width").val();
	var ma_block_width = $("#filter_max_width").val();
	var mi_block_length = $("#filter_min_length").val();
	var ma_block_length = $("#filter_max_length").val();
	var min_house_size = $("#filter_min_hsize").val();
	var max_house_size = $("#filter_max_hsize").val();
	var sort_prop = $("#sort_prop option:selected").val();
	var incids = $('input[name=filter_inclusion]:checked').map(function()
            {
                return $(this).val();
            }).get();
	var min_hland_size = $("#filter_min_hlandsize").val();
	var max_hland_size = $("#filter_max_hlandsize").val();
	
	var datastring1 = 'build_location='+build_location+'&bedroom='+bedroom+'&bathrooms='+bathrooms+'&living_spaces='+living_spaces+'&car_spaces='+car_spaces+'&floor_count='+floor_count+'&alfresco='+alfresco+'&duplex='+duplex+'&builder='+builder+'&min_price_val='+min_price_val+'&max_price_val='+max_price_val+'&min_block_width='+mi_block_width+'&max_block_width='+ma_block_width+'&min_block_length='+mi_block_length+'&max_block_length='+ma_block_length+'&min_house_size='+min_house_size+'&max_house_size='+max_house_size+'&sort_prop='+sort_prop+'&incids='+incids;
	var datastring = 'build_location='+build_location+'&bedroom='+bedroom+'&bathrooms='+bathrooms+'&living_spaces='+living_spaces+'&car_spaces='+car_spaces+'&floor_count='+floor_count+'&alfresco='+alfresco+'&duplex='+duplex+'&builder='+builder+'&min_price_val='+min_price_val+'&max_price_val='+max_price_val+'&min_block_width='+mi_block_width+'&max_block_width='+ma_block_width+'&min_block_length='+mi_block_length+'&max_block_length='+ma_block_length+'&min_house_size='+min_house_size+'&max_house_size='+max_house_size+'&sort_prop='+sort_prop+'&incids='+incids;
	//console.log(datastring);
	var base_url = $('#base_url').val();
	var house_lands = $('#house_lands').val();
	if(house_lands == 'house_lands_page') {
	datastring1+=  '&min_hland_size='+min_hland_size+'&max_hland_size='+max_hland_size;
	datastring+=  '&min_hland_size='+min_hland_size+'&max_hland_size='+max_hland_size;
	init_ajax_house_land_properties(datastring,datastring1);
	} else {
		init_ajax_properties(datastring,datastring1);
	}
});

$('#floor_count').on('change',function() {
	/* alert($(this).val()); */
	var bedroom = $("#bedrooms option:selected").val();
	var build_location = $("#build_location option:selected").val();
	var bathrooms = $("#bathrooms option:selected").val();
	var living_spaces = $("#living_spaces option:selected").val();
	var car_spaces = $("#car_spaces option:selected").val();
	var floor_count = $("#floor_count option:selected").val();
	var alfresco = $("#alfresco option:selected").val();
	var duplex = $("#duplex option:selected").val();
	var builder = $("#spe-builder option:selected").val();
	var min_price_val = $("#filter_min_price").val();
	var max_price_val = $("#filter_max_price").val();
	var mi_block_width = $("#filter_min_width").val();
	var ma_block_width = $("#filter_max_width").val();
	var mi_block_length = $("#filter_min_length").val();
	var ma_block_length = $("#filter_max_length").val();
	var min_house_size = $("#filter_min_hsize").val();
	var max_house_size = $("#filter_max_hsize").val();
	var sort_prop = $("#sort_prop option:selected").val();
	var incids = $('input[name=filter_inclusion]:checked').map(function()
            {
                return $(this).val();
            }).get();
	var min_hland_size = $("#filter_min_hlandsize").val();
	var max_hland_size = $("#filter_max_hlandsize").val();
	
	var datastring1 = 'build_location='+build_location+'&bedroom='+bedroom+'&bathrooms='+bathrooms+'&living_spaces='+living_spaces+'&car_spaces='+car_spaces+'&floor_count='+floor_count+'&alfresco='+alfresco+'&duplex='+duplex+'&builder='+builder+'&min_price_val='+min_price_val+'&max_price_val='+max_price_val+'&min_block_width='+mi_block_width+'&max_block_width='+ma_block_width+'&min_block_length='+mi_block_length+'&max_block_length='+ma_block_length+'&min_house_size='+min_house_size+'&max_house_size='+max_house_size+'&sort_prop='+sort_prop+'&incids='+incids;
	var datastring = 'build_location='+build_location+'&bedroom='+bedroom+'&bathrooms='+bathrooms+'&living_spaces='+living_spaces+'&car_spaces='+car_spaces+'&floor_count='+floor_count+'&alfresco='+alfresco+'&duplex='+duplex+'&builder='+builder+'&min_price_val='+min_price_val+'&max_price_val='+max_price_val+'&min_block_width='+mi_block_width+'&max_block_width='+ma_block_width+'&min_block_length='+mi_block_length+'&max_block_length='+ma_block_length+'&min_house_size='+min_house_size+'&max_house_size='+max_house_size+'&sort_prop='+sort_prop+'&incids='+incids;
	//console.log(datastring);
	var base_url = $('#base_url').val();
	var house_lands = $('#house_lands').val();
	if(house_lands == 'house_lands_page') {
	datastring1+=  '&min_hland_size='+min_hland_size+'&max_hland_size='+max_hland_size;
	datastring+=  '&min_hland_size='+min_hland_size+'&max_hland_size='+max_hland_size;
	init_ajax_house_land_properties(datastring,datastring1);
	} else {
		init_ajax_properties(datastring,datastring1);
	}
});


$('#alfresco').on('change',function() {
	/* alert($(this).val()); */
	var bedroom = $("#bedrooms option:selected").val();
	var build_location = $("#build_location option:selected").val();
	var bathrooms = $("#bathrooms option:selected").val();
	var living_spaces = $("#living_spaces option:selected").val();
	var car_spaces = $("#car_spaces option:selected").val();
	var floor_count = $("#floor_count option:selected").val();
	var alfresco = $("#alfresco option:selected").val();
	var duplex = $("#duplex option:selected").val();
	var builder = $("#spe-builder option:selected").val();
	var min_price_val = $("#filter_min_price").val();
	var max_price_val = $("#filter_max_price").val();
	var mi_block_width = $("#filter_min_width").val();
	var ma_block_width = $("#filter_max_width").val();
	var mi_block_length = $("#filter_min_length").val();
	var ma_block_length = $("#filter_max_length").val();
	var min_house_size = $("#filter_min_hsize").val();
	var max_house_size = $("#filter_max_hsize").val();
	var sort_prop = $("#sort_prop option:selected").val();
	var incids = $('input[name=filter_inclusion]:checked').map(function()
            {
                return $(this).val();
            }).get();
	var min_hland_size = $("#filter_min_hlandsize").val();
	var max_hland_size = $("#filter_max_hlandsize").val();
	
	var datastring1 = 'build_location='+build_location+'&bedroom='+bedroom+'&bathrooms='+bathrooms+'&living_spaces='+living_spaces+'&car_spaces='+car_spaces+'&floor_count='+floor_count+'&alfresco='+alfresco+'&duplex='+duplex+'&builder='+builder+'&min_price_val='+min_price_val+'&max_price_val='+max_price_val+'&min_block_width='+mi_block_width+'&max_block_width='+ma_block_width+'&min_block_length='+mi_block_length+'&max_block_length='+ma_block_length+'&min_house_size='+min_house_size+'&max_house_size='+max_house_size+'&sort_prop='+sort_prop+'&incids='+incids;
	var datastring = 'build_location='+build_location+'&bedroom='+bedroom+'&bathrooms='+bathrooms+'&living_spaces='+living_spaces+'&car_spaces='+car_spaces+'&floor_count='+floor_count+'&alfresco='+alfresco+'&duplex='+duplex+'&builder='+builder+'&min_price_val='+min_price_val+'&max_price_val='+max_price_val+'&min_block_width='+mi_block_width+'&max_block_width='+ma_block_width+'&min_block_length='+mi_block_length+'&max_block_length='+ma_block_length+'&min_house_size='+min_house_size+'&max_house_size='+max_house_size+'&sort_prop='+sort_prop+'&incids='+incids;
	//console.log(datastring);
	var base_url = $('#base_url').val();
	var house_lands = $('#house_lands').val();
	if(house_lands == 'house_lands_page') {
	datastring1+=  '&min_hland_size='+min_hland_size+'&max_hland_size='+max_hland_size;
	datastring+=  '&min_hland_size='+min_hland_size+'&max_hland_size='+max_hland_size;
	init_ajax_house_land_properties(datastring,datastring1);
	} else {
		init_ajax_properties(datastring,datastring1);
	}
});

$('#duplex').on('change',function() {
	/* alert($(this).val()); */
	var bedroom = $("#bedrooms option:selected").val();
	var build_location = $("#build_location option:selected").val();
	var bathrooms = $("#bathrooms option:selected").val();
	var living_spaces = $("#living_spaces option:selected").val();
	var car_spaces = $("#car_spaces option:selected").val();
	var floor_count = $("#floor_count option:selected").val();
	var alfresco = $("#alfresco option:selected").val();
	var duplex = $("#duplex option:selected").val();
	var min_price_val = $("#filter_min_price").val();
	var max_price_val = $("#filter_max_price").val();
	var mi_block_width = $("#filter_min_width").val();
	var ma_block_width = $("#filter_max_width").val();
	var mi_block_length = $("#filter_min_length").val();
	var ma_block_length = $("#filter_max_length").val();
	var min_house_size = $("#filter_min_hsize").val();
	var max_house_size = $("#filter_max_hsize").val();
	var builder = $("#spe-builder option:selected").val();
	var sort_prop = $("#sort_prop option:selected").val();
	var incids = $('input[name=filter_inclusion]:checked').map(function()
            {
                return $(this).val();
            }).get();
	var min_hland_size = $("#filter_min_hlandsize").val();
	var max_hland_size = $("#filter_max_hlandsize").val();
	
	var datastring1 = 'build_location='+build_location+'&bedroom='+bedroom+'&bathrooms='+bathrooms+'&living_spaces='+living_spaces+'&car_spaces='+car_spaces+'&floor_count='+floor_count+'&alfresco='+alfresco+'&duplex='+duplex+'&builder='+builder+'&min_price_val='+min_price_val+'&max_price_val='+max_price_val+'&min_block_width='+mi_block_width+'&max_block_width='+ma_block_width+'&min_block_length='+mi_block_length+'&max_block_length='+ma_block_length+'&min_house_size='+min_house_size+'&max_house_size='+max_house_size+'&sort_prop='+sort_prop+'&incids='+incids;
	var datastring = 'build_location='+build_location+'&bedroom='+bedroom+'&bathrooms='+bathrooms+'&living_spaces='+living_spaces+'&car_spaces='+car_spaces+'&floor_count='+floor_count+'&alfresco='+alfresco+'&duplex='+duplex+'&builder='+builder+'&min_price_val='+min_price_val+'&max_price_val='+max_price_val+'&min_block_width='+mi_block_width+'&max_block_width='+ma_block_width+'&min_block_length='+mi_block_length+'&max_block_length='+ma_block_length+'&min_house_size='+min_house_size+'&max_house_size='+max_house_size+'&sort_prop='+sort_prop+'&incids='+incids;
	//console.log(datastring);
	var base_url = $('#base_url').val();
	var house_lands = $('#house_lands').val();
	if(house_lands == 'house_lands_page') {
	datastring1+=  '&min_hland_size='+min_hland_size+'&max_hland_size='+max_hland_size;
	datastring+=  '&min_hland_size='+min_hland_size+'&max_hland_size='+max_hland_size;
	init_ajax_house_land_properties(datastring,datastring1);
	} else {
		init_ajax_properties(datastring,datastring1);
	}
});

$('#spe-builder').on('change',function() {
	/* alert($(this).val()); */
	var bedroom = $("#bedrooms option:selected").val();
	var build_location = $("#build_location option:selected").val();
	var bathrooms = $("#bathrooms option:selected").val();
	var living_spaces = $("#living_spaces option:selected").val();
	var car_spaces = $("#car_spaces option:selected").val();
	var floor_count = $("#floor_count option:selected").val();
	var alfresco = $("#alfresco option:selected").val();
	var duplex = $("#duplex option:selected").val();
	var builder = $("#spe-builder option:selected").val();
	var min_price_val = $("#filter_min_price").val();
	var max_price_val = $("#filter_max_price").val();
	var mi_block_width = $("#filter_min_width").val();
	var ma_block_width = $("#filter_max_width").val();
	var mi_block_length = $("#filter_min_length").val();
	var ma_block_length = $("#filter_max_length").val();
	var min_house_size = $("#filter_min_hsize").val();
	var max_house_size = $("#filter_max_hsize").val();
	var sort_prop = $("#sort_prop option:selected").val();
	var incids = $('input[name=filter_inclusion]:checked').map(function()
            {
                return $(this).val();
            }).get();
			
	var min_hland_size = $("#filter_min_hlandsize").val();
	var max_hland_size = $("#filter_max_hlandsize").val();
	
	var datastring1 = 'build_location='+build_location+'&bedroom='+bedroom+'&bathrooms='+bathrooms+'&living_spaces='+living_spaces+'&car_spaces='+car_spaces+'&floor_count='+floor_count+'&alfresco='+alfresco+'&duplex='+duplex+'&builder='+builder+'&min_price_val='+min_price_val+'&max_price_val='+max_price_val+'&min_block_width='+mi_block_width+'&max_block_width='+ma_block_width+'&min_block_length='+mi_block_length+'&max_block_length='+ma_block_length+'&min_house_size='+min_house_size+'&max_house_size='+max_house_size+'&sort_prop='+sort_prop+'&incids='+incids;
	var datastring = 'build_location='+build_location+'&bedroom='+bedroom+'&bathrooms='+bathrooms+'&living_spaces='+living_spaces+'&car_spaces='+car_spaces+'&floor_count='+floor_count+'&alfresco='+alfresco+'&duplex='+duplex+'&builder='+builder+'&min_price_val='+min_price_val+'&max_price_val='+max_price_val+'&min_block_width='+mi_block_width+'&max_block_width='+ma_block_width+'&min_block_length='+mi_block_length+'&max_block_length='+ma_block_length+'&min_house_size='+min_house_size+'&max_house_size='+max_house_size+'&sort_prop='+sort_prop+'&incids='+incids;
	//console.log(datastring);
	var base_url = $('#base_url').val();
	var house_lands = $('#house_lands').val();
	if(house_lands == 'house_lands_page') {
	datastring1+=  '&min_hland_size='+min_hland_size+'&max_hland_size='+max_hland_size;
	datastring+=  '&min_hland_size='+min_hland_size+'&max_hland_size='+max_hland_size;
	init_ajax_house_land_properties(datastring,datastring1);
	} else {
		init_ajax_properties(datastring,datastring1);
	}
});


$('#sort_prop').on('change',function() {
/* 	alert($(this).val()); */
	var sort_prop = $(this).val();
	var bedroom = $("#bedrooms option:selected").val();
	var build_location = $("#build_location option:selected").val();
	var bathrooms = $("#bathrooms option:selected").val();
	var living_spaces = $("#living_spaces option:selected").val();
	var car_spaces = $("#car_spaces option:selected").val();
	var floor_count = $("#floor_count option:selected").val();
	var alfresco = $("#alfresco option:selected").val();
	var duplex = $("#duplex option:selected").val();
	var builder = $("#spe-builder option:selected").val();
	var min_price_val = $("#filter_min_price").val();
	var max_price_val = $("#filter_max_price").val();
	var mi_block_width = $("#filter_min_width").val();
	var ma_block_width = $("#filter_max_width").val();
	var mi_block_length = $("#filter_min_length").val();
	var ma_block_length = $("#filter_max_length").val();
	var min_house_size = $("#filter_min_hsize").val();
	var max_house_size = $("#filter_max_hsize").val();
	var min_hland_size = $("#filter_min_hlandsize").val();
	var max_hland_size = $("#filter_max_hlandsize").val();
	
	var incids = $('input[name=filter_inclusion]:checked').map(function()
            {
                return $(this).val();
            }).get();
	var datastring1 = 'build_location='+build_location+'&bedroom='+bedroom+'&bathrooms='+bathrooms+'&living_spaces='+living_spaces+'&car_spaces='+car_spaces+'&floor_count='+floor_count+'&alfresco='+alfresco+'&duplex='+duplex+'&builder='+builder+'&min_price_val='+min_price_val+'&max_price_val='+max_price_val+'&min_block_width='+mi_block_width+'&max_block_width='+ma_block_width+'&min_block_length='+mi_block_length+'&max_block_length='+ma_block_length+'&min_house_size='+min_house_size+'&max_house_size='+max_house_size+'&sort_prop='+sort_prop+'&incids='+incids;
	var datastring = 'build_location='+build_location+'&bedroom='+bedroom+'&bathrooms='+bathrooms+'&living_spaces='+living_spaces+'&car_spaces='+car_spaces+'&floor_count='+floor_count+'&alfresco='+alfresco+'&duplex='+duplex+'&builder='+builder+'&min_price_val='+min_price_val+'&max_price_val='+max_price_val+'&min_block_width='+mi_block_width+'&max_block_width='+ma_block_width+'&min_block_length='+mi_block_length+'&max_block_length='+ma_block_length+'&min_house_size='+min_house_size+'&max_house_size='+max_house_size+'&sort_prop='+sort_prop+'&incids='+incids;
	//console.log(datastring);
	var base_url = $('#base_url').val();
	var house_lands = $('#house_lands').val();
	if(house_lands == 'house_lands_page') {
	datastring1+=  '&min_hland_size='+min_hland_size+'&max_hland_size='+max_hland_size;
	datastring+=  '&min_hland_size='+min_hland_size+'&max_hland_size='+max_hland_size;
	init_ajax_house_land_properties(datastring,datastring1);
	} else {
		init_ajax_properties(datastring,datastring1);
	}
});


/* Property Inclusion Filter */

$('input[name="filter_inclusion"]').on('click',function() {
 /* var rel = $(this).attr('rel');
$('input:checkbox[name=filter_inclusion]').each(function() 
{    
    if($(this).is(':checked')) {
     var rel = $(this).attr('rel');
	 $('#inc_text_'+rel).css('color','#2fc9d4');
	  } 
}); 
$('input:checkbox[name=filter_inclusion]').each(function() 
{    
    if($(this).is(':checked') == false) {
     var rel = $(this).attr('rel');
	   $('#inc_text_'+rel).css('color','#7e7e7e');
	  } 
}); 
 */
  var incids = $('input[name=filter_inclusion]:checked').map(function()
            {
                return $(this).val();
            }).get();
	//console.log(incids);
	
	var sort_prop = $("#sort_prop option:selected").val();
	var bedroom = $("#bedrooms option:selected").val();
	var build_location = $("#build_location option:selected").val();
	var bathrooms = $("#bathrooms option:selected").val();
	var living_spaces = $("#living_spaces option:selected").val();
	var car_spaces = $("#car_spaces option:selected").val();
	var floor_count = $("#floor_count option:selected").val();
	var alfresco = $("#alfresco option:selected").val();
	var duplex = $("#duplex option:selected").val();
	var builder = $("#spe-builder option:selected").val();
	var min_price_val = $("#filter_min_price").val();
	var max_price_val = $("#filter_max_price").val();
	var mi_block_width = $("#filter_min_width").val();
	var ma_block_width = $("#filter_max_width").val();
	var mi_block_length = $("#filter_min_length").val();
	var ma_block_length = $("#filter_max_length").val();
	var min_house_size = $("#filter_min_hsize").val();
	var max_house_size = $("#filter_max_hsize").val();
	var min_hland_size = $("#filter_min_hlandsize").val();
	var max_hland_size = $("#filter_max_hlandsize").val();
	
	var datastring1 = 'build_location='+build_location+'&bedroom='+bedroom+'&bathrooms='+bathrooms+'&living_spaces='+living_spaces+'&car_spaces='+car_spaces+'&floor_count='+floor_count+'&alfresco='+alfresco+'&duplex='+duplex+'&builder='+builder+'&min_price_val='+min_price_val+'&max_price_val='+max_price_val+'&min_block_width='+mi_block_width+'&max_block_width='+ma_block_width+'&min_block_length='+mi_block_length+'&max_block_length='+ma_block_length+'&min_house_size='+min_house_size+'&max_house_size='+max_house_size+'&sort_prop='+sort_prop+'&incids='+incids;
	var datastring = 'build_location='+build_location+'&bedroom='+bedroom+'&bathrooms='+bathrooms+'&living_spaces='+living_spaces+'&car_spaces='+car_spaces+'&floor_count='+floor_count+'&alfresco='+alfresco+'&duplex='+duplex+'&builder='+builder+'&min_price_val='+min_price_val+'&max_price_val='+max_price_val+'&min_block_width='+mi_block_width+'&max_block_width='+ma_block_width+'&min_block_length='+mi_block_length+'&max_block_length='+ma_block_length+'&min_house_size='+min_house_size+'&max_house_size='+max_house_size+'&sort_prop='+sort_prop+'&incids='+incids;
	//console.log(datastring);
	var house_lands = $('#house_lands').val();
	if(house_lands == 'house_lands_page') {
	datastring1+=  '&min_hland_size='+min_hland_size+'&max_hland_size='+max_hland_size;
	datastring+=  '&min_hland_size='+min_hland_size+'&max_hland_size='+max_hland_size;
	init_ajax_house_land_properties(datastring,datastring1);
	} else {
		init_ajax_properties(datastring,datastring1);
	}
});




$('.inc').on('click',function(e) {
e.preventDefault();
    var $this = $(this).parent().find('.child_inc');
    $(".child_inc").not($this).hide();
    
    // here is what I want to do
    $this.toggle();

});

// saved homes page validation check


/* Home Design save check */

$("#saveallcheck").change(function () {
    $(".savelistcheckbox").prop('checked', $(this).prop("checked"));
	var save_check = $('input[name="savelistcheck"]:checked').length;
	//alert(save_check);
	if(save_check == 0)
	{
		$('.save_compare').prop('disabled', true);
		$('.save_enquire').prop('disabled', true);
	} else {
	
		$('.save_compare').prop('disabled', false);
		$('.save_enquire').prop('disabled', false);
	}
	
	 var propids = $('input[name=savelistcheck]:checked').map(function()
            {
                return $(this).val();
            }).get();
	//console.log(propids);
var propertyids = 'propertyids='+propids;
var property_ids = 'property_ids='+propids;
$('#enquire_ids').val(propids);
var base_url = $('#base_url').val();
var url1 = base_url+'/compare?'+propertyids;	
var url2 = base_url+'/property/contact?'+property_ids;	
$('#save_compare_url').val(url1);
$('#save_enquire_url').val(url2);
});

$('.savelistcheckbox').on('change',function(){
var save_check = $('input[name="savelistcheck"]:checked').length;
//alert(save_check);
if(save_check == 0)
	{
		$('.save_compare').prop('disabled', true);
		$('.save_enquire').prop('disabled', true);
	} else {
	
		$('.save_compare').prop('disabled', false);
		$('.save_enquire').prop('disabled', false);
	}
	 var propids = $('input[name=savelistcheck]:checked').map(function()
            {
                return $(this).val();
            }).get();
	//console.log(propids);
var propertyids = 'propertyids='+propids;
var property_ids = 'property_ids='+propids;
var base_url = $('#base_url').val();
$('#enquire_ids').val(propids);
var url1 = base_url+'/compare?'+propertyids;	
var url2 = base_url+'/property/contact?'+property_ids;	
$('#save_compare_url').val(url1);
$('#save_enquire_url').val(url2);

});


/* house & land Design save check */
$("#savehomeallcheck").change(function () {
    $(".savehomelistcheckbox").prop('checked', $(this).prop("checked"));
	var save_check = $('input[name="savehomelistcheck"]:checked').length;
	//alert(save_check);
	if(save_check == 0)
	{
		$('.save_compare_land').prop('disabled', true);
		$('.save_enquire_land').prop('disabled', true);
	} else {
	
		$('.save_compare_land').prop('disabled', false);
		$('.save_enquire_land').prop('disabled', false);
	}
	
	 var propids = $('input[name=savehomelistcheck]:checked').map(function()
            {
                return $(this).val();
            }).get();
	//console.log(propids);
var propertyids = 'propertyids='+propids;
var property_ids = 'property_ids='+propids;
$('#enquire_ids').val(propids);
var base_url = $('#base_url').val();
var url1 = base_url+'/compare?'+propertyids;	
var url2 = base_url+'/property/contact?'+property_ids;	
$('#save_home_compare_url').val(url1);
$('#save_home_enquire_url').val(url2);
});

$('.savehomelistcheckbox').on('change',function(){
var save_check = $('input[name="savehomelistcheck"]:checked').length;
//alert(save_check);
if(save_check == 0)
	{
		$('.save_compare_land').prop('disabled', true);
		$('.save_enquire_land').prop('disabled', true);
	} else {
	
		$('.save_compare_land').prop('disabled', false);
		$('.save_enquire_land').prop('disabled', false);
	}
	 var propids = $('input[name=savehomelistcheck]:checked').map(function()
            {
                return $(this).val();
            }).get();
	//console.log(propids);
var propertyids = 'propertyids='+propids;
var property_ids = 'property_ids='+propids;
var base_url = $('#base_url').val();
$('#enquire_ids').val(propids);
var url1 = base_url+'/compare?'+propertyids;	
var url2 = base_url+'/property/contact?'+property_ids;	
$('#save_home_compare_url').val(url1);
$('#save_home_enquire_url').val(url2);

});


 $('.save_compare').on('click',function(){
 	var save_check = $('input[name="savelistcheck"]:checked').length;
 	if(save_check > 4){
 		$('.save_compare').prop('disabled', true);
		$('.save_enquire').prop('disabled', true);
		$('.warning_compare').html('<span style = "color: #D62929;float: left;font-family: Raleway,sans-serif;font-size: 14px;font-weight: bold;line-height: 1.42857;margin: 4px 4% 1px;">Please select up to 4 homes</span>');
 	}else{
		var compare_url = $('#save_compare_url').val();
		window.location.href=compare_url;
	}

});

 $('.save_enquire').on('click',function(){
 	var save_check = $('input[name="savelistcheck"]:checked').length;
 	if(save_check > 4){
 		$('.save_compare').prop('disabled', true);
		$('.save_enquire').prop('disabled', true);
		$('.warning_compare').html('<span style = "color: #D62929;float: left;font-family: Raleway,sans-serif;font-size: 14px;font-weight: bold;line-height: 1.42857;margin: 4px 4% 1px;">Please select up to 4 homes</span>');
 	}else{
		var enquire_url = $('#save_enquire_url').val();
		var enquire_ids = $('#enquire_ids').val();
		  var base_url = $('#base_url').val();
  var url = $('#base_url').val()+'/property/load_enquire_form';
    //alert(url);=
    $('#enquire_forms').attr("action",url);
   // $('.bs-example-modal-lg').modal('show');
	  $.ajax({
            type: 'POST',
            data: {
                'property_ids' : enquire_ids,
            },
            url : url,
            success: function(response) {
                if(response) {
					$('#load_content').html(response);
                    $('.bs-example-modal-lg').modal('show');
					 $('[data-toggle="tooltip"]').tooltip();  
						submit_enquire_form();					 
                } 
            }
        });

	}

});


$(document).on('click','.remove',function(){
	var id = $(this).attr('data-id');
	var property_ids = $(this).attr('data-property_ids');
	var base_url = $('#base_url').val();
	var datastring = 'id='+id+'&property_ids='+property_ids;
var url = base_url+'/property/delete_ajax_property';
	$.ajax({
		type:'post',
		url:url,
		dataType: "json",
		data:datastring,
		crossDomain:true, 
		success:function(data)
		{
			var content = data.html;
			var reset_string = data.reset_string;
			var enquire_url = base_url+'/property/enquire_builder/'+reset_string;
			$('#selected-homes').html(content);
			$('#enquire_forms').attr('action',enquire_url);
			 $('[data-toggle="tooltip"]').tooltip();  

		}
	
	});

});


$("#landallcheck").change(function () {
    $(".landlistcheckbox").prop('checked', $(this).prop("checked"));
	var save_check = $('input[name="landlistcheck"]:checked').length;
	//alert(save_check);
	if(save_check == 0)
	{
		$('.land_enquire').prop('disabled', true);
	} else {
		$('.land_enquire').prop('disabled', false);
	}
	
	 var propids = $('input[name=landlistcheck]:checked').map(function()
            {
                return $(this).val();
            }).get();
	//console.log(propids);
var propertyids = 'property_ids='+propids;
var base_url = $('#base_url').val();
var url2 = base_url+'/property/contact?'+propertyids;	
$('#save_enquire_url').val(url2);
});

$('.landlistcheckbox').on('change',function(){
var save_check = $('input[name="landlistcheck"]:checked').length;
//alert(save_check);
if(save_check == 0)
	{
		$('.land_enquire').prop('disabled', true);
	} else {
		$('.land_enquire').prop('disabled', false);
	}
	 var propids = $('input[name=landlistcheck]:checked').map(function()
            {
                return $(this).val();
            }).get();
	//console.log(propids);
var propertyids = 'property_ids='+propids;
var base_url = $('#base_url').val();
var url2 = base_url+'/property/contact?'+propertyids;	
$('#save_enquire_url').val(url2);

});


//compare_inclusions();

$(document).on('click', '.compare_inc', function(e) {
var inc_id = $(this).attr('rel');
//alert(inc_id);
var text = $(this).attr('data-text-'+inc_id);
/* alert(text); */
if(text == 'checked') {
$(this).attr('data-text-'+inc_id,'unchecked');
$('#comp_check_'+inc_id).attr('data-text-'+inc_id,'unchecked');
$('#comp_check_'+inc_id).attr('checked',false);
}
if(text == 'unchecked') {
$(this).attr('data-text-'+inc_id,'checked');
$('#comp_check_'+inc_id).attr('data-text-'+inc_id,'checked');
$('#comp_check_'+inc_id).attr('checked',true);
}
var base_url = $('#base_url').val();
var compare_ids = $('#compare_ids').val();
var url = base_url+'/compare/ajax_save_inclusion';
var datastring = 'inc_id='+inc_id+'&text='+text+'&compare_ids='+compare_ids;
$.ajax({
		type:'post',
		url:url,
		data:datastring,
		crossDomain:true, 
		success:function(data)
		{
			$('#ajax_compared_inc').html(data);
			//alert(data);
			//compare_inclusions();
		
		}
	
	});

//$(this).attr('data-text','checked');
});

 $('.compare').on('click',function(){
var compare_url = $('#compare_url').val();
window.location.href=compare_url;
});

 $('.compare-house').on('click',function(){
var compare_house_url = $('#compare_house_url').val();
window.location.href=compare_house_url;
});
 
$(document).on('click','.delsaveprop',function(){
var save_prop  =  $(this).attr('rel');
var base_url = $('#base_url').val();
var compare_ids = $('#compare_ids').val();
var url = base_url+'/property/delete_save_property';
var datastring = 'save_prop='+save_prop;
$.ajax({
		type:'post',
		url:url,
		data:datastring,
		crossDomain:true, 
		success:function(data)
		{
			$('#save_ajax_content').html(data);
			compare_designs();
			 $('.compare').on('click',function(){
var compare_url = $('#compare_url').val();
window.location.href=compare_url;
});
			 $('.compare-house').on('click',function(){
var compare_house_url = $('#compare_house_url').val();
window.location.href=compare_house_url;
});
 show_compare_tab();
			count_save_property();
			//alert(data);
			//compare_inclusions();
		
		}
	
	});

}); 


save_property();
show_compare_tab();
ajax_pagination();
save_property_new();
compare_designs();

});


/* end of ready function */


/* function compare_inclusions() {


} */


// Pop up validation
function compare_designs() {
$('input[name="savecheck"]').on('click',function() {
var save_check = $('input[name="savecheck"]:checked').length;
/* alert($('input[name="savecheck"]:checked').length); */
if(save_check > 4 || save_check < 1)
{
	$('.compare').prop('disabled', true);
} else {

	$('.compare').prop('disabled', false);
}
 var propids = $('input[name=savecheck]:checked').map(function()
            {
                return $(this).val();
            }).get();
	console.log(propids);
var propertyids = 'propertyids='+propids;
var base_url = $('#base_url').val();
var url = base_url+'/compare?'+propertyids;	
$('#compare_url').val(url);

});

$('input[name="savehousecheck"]').on('click',function() {
var savehousecheck = $('input[name="savehousecheck"]:checked').length;
/* alert($('input[name="savecheck"]:checked').length); */
if(savehousecheck > 4 || savehousecheck < 1)
{
	$('.compare-house').prop('disabled', true);
} else {

	$('.compare-house').prop('disabled', false);
}
 var propids = $('input[name=savehousecheck]:checked').map(function()
            {
                return $(this).val();
            }).get();
	console.log(propids);
var propertyids = 'propertyids='+propids;
var base_url = $('#base_url').val();
var compare_house_url = base_url+'/compare?'+propertyids;	
$('#compare_house_url').val(compare_house_url);

});

}

	

function init_ajax_properties(datastring,datastring1)
{
	var base_url = $('#base_url').val();
	var url = base_url+'/properties/ajax_filter_properties';
	jQuery('.loading').show();
  jQuery('.loading').addClass('loaderimg');
	//$('#ajaxloader').html('<img src="'+base_url+'/assets/img/loading-x.gif">');
	$.ajax({
		type:'post',
		url:url,
		data:datastring,
		crossDomain:true, 
		success:function(data)
		{
			$('#ajax_content').html(data);
			$('.model_img').slick({               
prevArrow: '<div class="arrow_left1"><img src="'+base_url+'/assets/img/slide_lt.png" /></div>',
nextArrow: ' <div class="arrow_right1"><img src="'+base_url+'/assets/img/slide_rt.png" /></div>'
});

		ajax_pagination();
	save_property();
	save_property_new();
	 $('[data-toggle="tooltip"]').tooltip();   
	jQuery('.loading').hide();
    jQuery('.loading').removeClass('loaderimg');
		}
	
	});
	
	
	var count_url = base_url+'/properties/ajax_filter_count_properties';
	
	// count total properties
	$.ajax({
		type:'post',
		url:count_url,
		data:datastring1,
		crossDomain:true, 
		success:function(data)
		{
			$('.prop_count').html(data);
		}
	});
	
}

function init_ajax_house_land_properties(datastring,datastring1)
{
	var base_url = $('#base_url').val();
	var url = base_url+'/properties/ajax_filter_house_land';
	jQuery('.loading').show();
  jQuery('.loading').addClass('loaderimg');
	//$('#ajaxloader').html('<img src="'+base_url+'/assets/img/loading-x.gif">');
	$.ajax({
		type:'post',
		url:url,
		data:datastring,
		crossDomain:true, 
		success:function(data)
		{
			$('#ajax_content').html(data);
			$('.model_img').slick({               
prevArrow: '<div class="arrow_left1"><img src="'+base_url+'/assets/img/slide_lt.png" /></div>',
nextArrow: ' <div class="arrow_right1"><img src="'+base_url+'/assets/img/slide_rt.png" /></div>'
});

		ajax_pagination();
	save_property();
	save_property_new();
	 $('[data-toggle="tooltip"]').tooltip();   
	jQuery('.loading').hide();
    jQuery('.loading').removeClass('loaderimg');
		}
	
	});
	
	
	var count_url = base_url+'/properties/ajax_filter_count_house_land';
	
	// count total properties
	$.ajax({
		type:'post',
		url:count_url,
		data:datastring1,
		crossDomain:true, 
		success:function(data)
		{
			$('.prop_count').html(data);
		}
	});
	
}

/* Save Property */

function save_property_new()
{
	$('.closeBottomSlide').on('click',function(){
		$('#saved_alert').slideUp();
	});
	$('.save_property_new').on('click',function(e){
e.preventDefault();
var base_url = $('#base_url').val();

var url = base_url+'/property/save_property_new';
	var prop_id =  $(this).attr('rel');
	var save_text = $('#save_src_'+prop_id).attr('data-save_'+prop_id);
var datastring = 'prop_id='+prop_id+'&save_text='+save_text;
		$.ajax({
		type:'post',
		url:url,
		data:datastring,
		dataType:'json',
		crossDomain:true, 
		success:function(data)
		{
			var i = 0;
			//console.log(data.LoginSavedStatus);
			if(data.LoginSavedStatus != 'No') {
			if(save_text == 'Saved')
			{
				//console.log(data);
				//console.log(data[i].id);
				$('#save_src_'+prop_id).attr('data-save_'+prop_id,'Save');
				$('#pop_save_src_'+prop_id).attr('data-pop-save_'+prop_id,'Save');
				$('#save_text2_'+prop_id).text('Save');
				$('#pop_save_text2_'+prop_id).text('Save');
				$('#save_src_'+prop_id).attr('src',base_url+'/assets/img/star.png');
				$('#pop_save_src_'+prop_id).attr('src',base_url+'/assets/img/star.png');
			} else {
			if(typeof data[i].property_gallery[i] != 'undefined') {
			if(typeof data[i].property_gallery[i].image != 'undefined' || data[i].property_gallery[i].image != '') {
				var image = base_url+'/uploads/property_gallery/'+data[i].property_gallery[i].image;
			} else {
				var image = base_url+'/assets/img/no-image.jpg';
			}
			} else {
			var image = base_url+'/assets/img/no-image.jpg';
			}
			
			$.notify({
	// options
	title: 'Added to saved homes!',
	message: 'You can save up-to 3 designs without registration',
	other: 'Hayman 25 (Kingston)'
},{
	// settings
	element: 'body',
	position: null,
	type: "info",
	allow_dismiss: true,
	newest_on_top: false,
	showProgressbar: false,
	placement: {
		from: "top",
		align: "right"
	},
	offset: 20,
	spacing: 10,
	z_index: 9999999,
	 delay: 5000,
	timer: 1000, 
	url_target: '_blank',
	mouse_over: null,
	animate: {
		enter: 'animated fadeInDown',
		exit: 'animated fadeOutUp'
	},
	onShow: null,
	onShown: null,
	onClose: null,
	onClosed: null,
	icon_type: 'class',
	template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0} notify-div" role="alert">' +
		'<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
		'<h5 style="color:#000;font-size:15px">Added to saved homes! <br/> <br/> You can save <span style="color:#2bb673">up-to 3 designs</span> without registration</h5>'+
		'<div class="cp-box" style="margin-top:10px;"> '+
            '<div class="cp-right">' +
                '<div class="cp-r-top">' +
				'<a href="'+base_url+'/propertydetail/'+data[i].id+'">'+
				'<img alt="" src="'+image+'"></a>'+
				 '<h3><a href="'+base_url+'/propertydetail/'+data[i].id+'">'+data[i].property_title+'</h3></a>'+
                 '<p>From $'+data[i].price+'</p>'+
               '</div>'+
                '<div class="cp-r-btm">'+
                    '<span><img alt="bed" src="'+base_url+'/assets/img/bed.png">'+data[i].bedrooms+'</span>'+
                    '<span><img alt="bathroom" src="'+base_url+'/assets/img/bath.png"> '+data[i].bathrooms+'</span>'+
                    '<span><img alt="sofa" src="'+base_url+'/assets/img/sofa.png"> '+data[i].living+'</span>'+
                    '<span><img alt="size" src="'+base_url+'/assets/img/size.png"> '+data[i].housesize+'</span>'+
                '</div>'+
            '</div>'+
            '<div class="clr"></div>'+
        '</div>'+
		'<div class="progress" data-notify="progressbar">' +
			'<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
		'</div>' +
	'</div>' 
});
			$('#save_src_'+prop_id).attr('data-save_'+prop_id,'Saved');
			$('#save_text2_'+prop_id).text('Saved');
			$('#save_src_'+prop_id).attr('src',base_url+'/assets/img/star_hover.png');
			$('#pop_save_src_'+prop_id).attr('data-save_'+prop_id,'Saved');
			$('#pop_save_text2_'+prop_id).text('Saved');
			$('#pop_save_src_'+prop_id).attr('src',base_url+'/assets/img/star_hover.png');
			
			}	
			} else {
			$('#saved_alert').slideDown();
				//alert('Please Login to save more homes');
			}
		}
	
	});
});
}

/* Compare property */

function save_property()
{
	$('.save_property').on('click',function(e){
e.preventDefault();
var base_url = $('#base_url').val();

var url = base_url+'/property/save_property';
	var prop_id =  $(this).attr('rel');
	var save_text = $('#save_text_'+prop_id).text();
var datastring = 'prop_id='+prop_id+'&save_text='+save_text;
		$.ajax({
		type:'post',
		url:url,
		data:datastring,
		crossDomain:true, 
		success:function(data)
		{
			count_save_property();
			if(save_text == 'Compared')
			{
				$('#save_text_'+prop_id).text('Compare');
				$('#pop_save_text_'+prop_id).text('Compare');
				$('#save_text1_'+prop_id).text('Compare');
				$('#compare_src_'+prop_id).attr('src',base_url+'/assets/img/comapre.png');
				$('#pop_compare_src_'+prop_id).attr('src',base_url+'/assets/img/comapre.png');
			} else {
			$('#save_text_'+prop_id).text('Compared');
			$('#pop_save_text_'+prop_id).text('Compared');
				$('#save_text1_'+prop_id).text('Compared');
				$('#compare_src_'+prop_id).attr('src',base_url+'/assets/img/comapre_hover.png');
				$('#pop_compare_src_'+prop_id).attr('src',base_url+'/assets/img/comapre_hover.png');
			}
			$('#save_ajax_content').html(data);
			compare_designs();
				
			$('.compare').on('click',function(){
var compare_url = $('#compare_url').val();
window.location.href=compare_url;
});
$('.compare-house').on('click',function(){
var compare_house_url = $('#compare_house_url').val();
window.location.href=compare_house_url;
});
show_compare_tab();

		}
	
	});
});
}

function show_compare_tab()
{
	$('#house-div').on('click',function(){
	$('#house-div').addClass('comp-active');
	$('#house-land-div').removeClass('comp-active');
	$('#house-head').show();
	$('#inner-house').show();
	$('#house_footer').show();
	$('#house-land-head').hide();
	$('#inner-house-land').hide();
	$('#house_land_footer').hide();
	});

	$('#house-land-div').on('click',function(){
	$('#house-land-div').addClass('comp-active');
	$('#house-div').removeClass('comp-active');
	$('#house-head').hide();
	$('#inner-house').hide();
	$('#house_footer').hide();
	$('#house-land-head').show();
	$('#inner-house-land').show();
	$('#house_land_footer').show();
	});
	
}

function count_save_property()
{
	var base_url = $('#base_url').val();

var url = base_url+'/property/count_save_property';
		$.ajax({
		type:'post',
		url:url,
		crossDomain:true, 
		success:function(data)
		{
			$('#saved_homes').html(data);
		}
	
	});
}

function ajax_pagination()
{
$('.pagi').on('click',function(e) {
e.preventDefault();
var page = $(this).attr('rel');
/* alert(page); */

  var incids = $('input[name=filter_inclusion]:checked').map(function()
            {
                return $(this).val();
            }).get();
	//console.log(incids);
	
	var sort_prop = $("#sort_prop option:selected").val();
	var bedroom = $("#bedrooms option:selected").val();
	var build_location = $("#build_location option:selected").val();
	var bathrooms = $("#bathrooms option:selected").val();
	var living_spaces = $("#living_spaces option:selected").val();
	var car_spaces = $("#car_spaces option:selected").val();
	var floor_count = $("#floor_count option:selected").val();
	var alfresco = $("#alfresco option:selected").val();
	var duplex = $("#duplex option:selected").val();
	var builder = $("#spe-builder option:selected").val();
	var min_price_val = $("#filter_min_price").val();
	var max_price_val = $("#filter_max_price").val();
	var mi_block_width = $("#filter_min_width").val();
	var ma_block_width = $("#filter_max_width").val();
	var mi_block_length = $("#filter_min_length").val();
	var ma_block_length = $("#filter_max_length").val();
	var min_house_size = $("#filter_min_hsize").val();
	var max_house_size = $("#filter_max_hsize").val();
	var min_hland_size = $("#filter_min_hlandsize").val();
	var max_hland_size = $("#filter_max_hlandsize").val();
	
	var datastring1 = 'build_location='+build_location+'&bedroom='+bedroom+'&bathrooms='+bathrooms+'&living_spaces='+living_spaces+'&car_spaces='+car_spaces+'&floor_count='+floor_count+'&alfresco='+alfresco+'&duplex='+duplex+'&builder='+builder+'&min_price_val='+min_price_val+'&max_price_val='+max_price_val+'&min_block_width='+mi_block_width+'&max_block_width='+ma_block_width+'&min_block_length='+mi_block_length+'&max_block_length='+ma_block_length+'&min_house_size='+min_house_size+'&max_house_size='+max_house_size+'&sort_prop='+sort_prop+'&incids='+incids;
	var datastring = 'build_location='+build_location+'&bedroom='+bedroom+'&bathrooms='+bathrooms+'&living_spaces='+living_spaces+'&car_spaces='+car_spaces+'&floor_count='+floor_count+'&alfresco='+alfresco+'&duplex='+duplex+'&builder='+builder+'&min_price_val='+min_price_val+'&max_price_val='+max_price_val+'&min_block_width='+mi_block_width+'&max_block_width='+ma_block_width+'&min_block_length='+mi_block_length+'&max_block_length='+ma_block_length+'&min_house_size='+min_house_size+'&max_house_size='+max_house_size+'&sort_prop='+sort_prop+'&incids='+incids+'&page='+page;
	//console.log(datastring);
	var house_lands = $('#house_lands').val();
	if(house_lands == 'house_lands_page') {
	datastring1+=  '&min_hland_size='+min_hland_size+'&max_hland_size='+max_hland_size;
	datastring+=  '&min_hland_size='+min_hland_size+'&max_hland_size='+max_hland_size;
	init_ajax_house_land_properties(datastring,datastring1);
	} else {
		init_ajax_properties(datastring,datastring1);
	}
	
});
}

/* Filter Price range  */

 if( $('#price_range').length ) {
var html5Slider = document.getElementById('price_range');
var min_price = parseInt(document.getElementById('min_price').value);
/* alert(min_price); */
var max_price = parseInt(document.getElementById('max_price').value);
noUiSlider.create(html5Slider, {
	start: [ min_price, max_price ],
	step: 50,
	connect: true,
	range: {
		'min': min_price,
		'max': max_price
	},
	format: wNumb({
		decimals: 0,
		thousand: ','
		
	})
});



// Write the CSS 'left' value to a span.
function leftValue ( handle ) {
	return handle.parentElement.style.left;
}

var pricelowerValue = document.getElementById('price-lower-value'),
	pricelowerOffset = document.getElementById('price-lower-offset'),
	priceupperValue = document.getElementById('price-upper-value'),
	priceupperOffset = document.getElementById('price-upper-offset'),
	handles = html5Slider.getElementsByClassName('noUi-handle');

// Display the slider value and how far the handle moved
// from the left edge of the slider.
html5Slider.noUiSlider.on('update', function ( values, handle ) {
	if ( !handle ) {
		pricelowerValue.innerHTML = values[handle] + ' Min.' ;
		
	} else {
		priceupperValue.innerHTML = values[handle] + ' Max. ' ;
		
	}
	
	

});

html5Slider.noUiSlider.on('change', function(values,handle){
if ( !handle ) {
		document.getElementById('filter_min_price').value = values[handle];
	} else {
		document.getElementById('filter_max_price').value = values[handle];
	}
	var bedroom = $("#bedrooms option:selected").val();
	var build_location = $("#build_location option:selected").val();
	var bathrooms = $("#bathrooms option:selected").val();
	var living_spaces = $("#living_spaces option:selected").val();
	var car_spaces = $("#car_spaces option:selected").val();
	var floor_count = $("#floor_count option:selected").val();
	var alfresco = $("#alfresco option:selected").val();
	var duplex = $("#duplex option:selected").val();
	var builder = $("#spe-builder option:selected").val();
	var min_price_val = $("#filter_min_price").val();
	var max_price_val = $("#filter_max_price").val();
	var mi_block_width = $("#filter_min_width").val();
	var ma_block_width = $("#filter_max_width").val();
	var mi_block_length = $("#filter_min_length").val();
	var ma_block_length = $("#filter_max_length").val();
	var min_house_size = $("#filter_min_hsize").val();
	var max_house_size = $("#filter_max_hsize").val();
	var sort_prop = $("#sort_prop option:selected").val();
	var incids = $('input[name=filter_inclusion]:checked').map(function()
            {
                return $(this).val();
            }).get();
	if(min_price_val == "")
	{
		var dbminval = $("#min_price").val();
		$("#filter_min_price").val(dbminval);
		 min_price_val = $("#filter_min_price").val();
	}
	if(max_price_val == "")
	{
		var dbmaxval = $("#max_price").val();
		$("#filter_max_price").val(dbmaxval);
		max_price_val = $("#filter_max_price").val();
	}
	var mi_block_width = $("#filter_min_width").val();
	var ma_block_width = $("#filter_max_width").val();
	var min_hland_size = $("#filter_min_hlandsize").val();
	var max_hland_size = $("#filter_max_hlandsize").val();
	

	var datastring1 = 'build_location='+build_location+'&bedroom='+bedroom+'&bathrooms='+bathrooms+'&living_spaces='+living_spaces+'&car_spaces='+car_spaces+'&floor_count='+floor_count+'&alfresco='+alfresco+'&duplex='+duplex+'&builder='+builder+'&min_price_val='+min_price_val+'&max_price_val='+max_price_val+'&min_block_width='+mi_block_width+'&max_block_width='+ma_block_width+'&min_block_length='+mi_block_length+'&max_block_length='+ma_block_length+'&min_house_size='+min_house_size+'&max_house_size='+max_house_size+'&sort_prop='+sort_prop+'&incids='+incids;;
	var datastring = 'build_location='+build_location+'&bedroom='+bedroom+'&bathrooms='+bathrooms+'&living_spaces='+living_spaces+'&car_spaces='+car_spaces+'&floor_count='+floor_count+'&alfresco='+alfresco+'&duplex='+duplex+'&builder='+builder+'&min_price_val='+min_price_val+'&max_price_val='+max_price_val+'&min_block_width='+mi_block_width+'&max_block_width='+ma_block_width+'&min_block_length='+mi_block_length+'&max_block_length='+ma_block_length+'&min_house_size='+min_house_size+'&max_house_size='+max_house_size+'&sort_prop='+sort_prop+'&incids='+incids;;
	//console.log(datastring);
	var base_url = $('#base_url').val();
	var house_lands = $('#house_lands').val();
	if(house_lands == 'house_lands_page') {
	datastring1+=  '&min_hland_size='+min_hland_size+'&max_hland_size='+max_hland_size;
	datastring+=  '&min_hland_size='+min_hland_size+'&max_hland_size='+max_hland_size;
	init_ajax_house_land_properties(datastring,datastring1);
	} else {
		init_ajax_properties(datastring,datastring1);
	}
});

}

/* End Price range  */

/* Filter Minimum Block width */
 if( $('#min-block-width').length ) {

var min_block_width = document.getElementById('min-block-width');
var mini_block_width = parseInt(document.getElementById('min_block_width').value);
/* alert(min_price); */
var max_block_width = parseInt(document.getElementById('max_block_width').value);
noUiSlider.create(min_block_width, {
	start: [ mini_block_width, max_block_width ],
	connect: true,
	range: {
		'min': mini_block_width,
		'max': max_block_width
	}
});



// Write the CSS 'left' value to a span.
function leftValue ( handle ) {
	return handle.parentElement.style.left;
}

var widthlowerValue = document.getElementById('width-lower-value'),
	widthlowerOffset = document.getElementById('width-lower-offset'),
	widthupperValue = document.getElementById('width-upper-value'),
	widthupperOffset = document.getElementById('width-upper-offset'),
	handles = min_block_width.getElementsByClassName('noUi-handle');

// Display the slider value and how far the handle moved
// from the left edge of the slider.
min_block_width.noUiSlider.on('update', function ( values, handle ) {
	if ( !handle ) {
		widthlowerValue.innerHTML = values[handle] + ' M to.' ;		
	} else {
		widthupperValue.innerHTML = values[handle] + ' M+. ' ;
		
	}
});


min_block_width.noUiSlider.on('change', function(values,handle){
if ( !handle ) {
		document.getElementById('filter_min_width').value = values[handle];
	} else {
		document.getElementById('filter_max_width').value = values[handle];
	}
	var bedroom = $("#bedrooms option:selected").val();
	var build_location = $("#build_location option:selected").val();
	var bathrooms = $("#bathrooms option:selected").val();
	var living_spaces = $("#living_spaces option:selected").val();
	var car_spaces = $("#car_spaces option:selected").val();
	var floor_count = $("#floor_count option:selected").val();
	var alfresco = $("#alfresco option:selected").val();
	var duplex = $("#duplex option:selected").val();
	var builder = $("#spe-builder option:selected").val();
	var min_price_val = $("#filter_min_price").val();
	var max_price_val = $("#filter_max_price").val();
	var mi_block_width = $("#filter_min_width").val();
	var ma_block_width = $("#filter_max_width").val();
	var mi_block_length = $("#filter_min_length").val();
	var ma_block_length = $("#filter_max_length").val();
	var min_house_size = $("#filter_min_hsize").val();
	var max_house_size = $("#filter_max_hsize").val();
	var min_hland_size = $("#filter_min_hlandsize").val();
	var max_hland_size = $("#filter_max_hlandsize").val();
	var sort_prop = $("#sort_prop option:selected").val();
	var incids = $('input[name=filter_inclusion]:checked').map(function()
            {
                return $(this).val();
            }).get();
	if(mi_block_width == "")
	{
		var dbminwval = $("#min_block_width").val();
		$("#filter_min_width").val(dbminwval);
		mi_block_width  = $("#filter_min_width").val();
	}
	if(ma_block_width == "")
	{
		var dbmaxval = $("#max_block_width").val();
		$("#filter_max_width").val(dbmaxval);
		ma_block_width = $("#filter_max_width").val();
	}
	
	var datastring1 = 'build_location='+build_location+'&bedroom='+bedroom+'&bathrooms='+bathrooms+'&living_spaces='+living_spaces+'&car_spaces='+car_spaces+'&floor_count='+floor_count+'&alfresco='+alfresco+'&duplex='+duplex+'&builder='+builder+'&min_price_val='+min_price_val+'&max_price_val='+max_price_val+'&min_block_width='+mi_block_width+'&max_block_width='+ma_block_width+'&min_block_length='+mi_block_length+'&max_block_length='+ma_block_length+'&min_house_size='+min_house_size+'&max_house_size='+max_house_size+'&sort_prop='+sort_prop+'&incids='+incids;;
	var datastring = 'build_location='+build_location+'&bedroom='+bedroom+'&bathrooms='+bathrooms+'&living_spaces='+living_spaces+'&car_spaces='+car_spaces+'&floor_count='+floor_count+'&alfresco='+alfresco+'&duplex='+duplex+'&builder='+builder+'&min_price_val='+min_price_val+'&max_price_val='+max_price_val+'&min_block_width='+mi_block_width+'&max_block_width='+ma_block_width+'&min_block_length='+mi_block_length+'&max_block_length='+ma_block_length+'&min_house_size='+min_house_size+'&max_house_size='+max_house_size+'&sort_prop='+sort_prop+'&incids='+incids;;
	//console.log(datastring);
	var base_url = $('#base_url').val();
	var house_lands = $('#house_lands').val();
	if(house_lands == 'house_lands_page') {
	datastring1+=  '&min_hland_size='+min_hland_size+'&max_hland_size='+max_hland_size;
	datastring+=  '&min_hland_size='+min_hland_size+'&max_hland_size='+max_hland_size;
	init_ajax_house_land_properties(datastring,datastring1);
	} else {
		init_ajax_properties(datastring,datastring1);
	}
});

}
/* End Minimum Block width */



/* Filter Minimum Block Length */
 if( $('#min-block-length').length ) {
var min_block_length = document.getElementById('min-block-length');
var mini_block_length = parseInt(document.getElementById('min_block_length').value);
var max_block_length = parseInt(document.getElementById('max_block_length').value);
noUiSlider.create(min_block_length, {
	start: [ mini_block_length, max_block_length ],
	connect: true,
	range: {
		'min':mini_block_length,
		'max': max_block_length
	}
});



// Write the CSS 'left' value to a span.
function leftValue ( handle ) {
	return handle.parentElement.style.left;
}

var lengthlowerValue = document.getElementById('length-lower-value'),
	lengthlowerOffset = document.getElementById('length-lower-offset'),
	lengthupperValue = document.getElementById('length-upper-value'),
	lengthupperOffset = document.getElementById('length-upper-offset'),
	handles = min_block_length.getElementsByClassName('noUi-handle');

// Display the slider value and how far the handle moved
// from the left edge of the slider.
min_block_length.noUiSlider.on('update', function ( values, handle ) {
	if ( !handle ) {
		lengthlowerValue.innerHTML = values[handle] + ' M to' ;
	} else {
		lengthupperValue.innerHTML = values[handle] + ' M+ ' ;
	}
});


min_block_length.noUiSlider.on('change', function(values,handle){
if ( !handle ) {
		document.getElementById('filter_min_length').value = values[handle];
	} else {
		document.getElementById('filter_max_length').value = values[handle];
	}
	var bedroom = $("#bedrooms option:selected").val();
	var build_location = $("#build_location option:selected").val();
	var bathrooms = $("#bathrooms option:selected").val();
	var living_spaces = $("#living_spaces option:selected").val();
	var car_spaces = $("#car_spaces option:selected").val();
	var floor_count = $("#floor_count option:selected").val();
	var alfresco = $("#alfresco option:selected").val();
	var duplex = $("#duplex option:selected").val();
	var builder = $("#spe-builder option:selected").val();
	var min_price_val = $("#filter_min_price").val();
	var max_price_val = $("#filter_max_price").val();
	var mi_block_width = $("#filter_min_width").val();
	var ma_block_width = $("#filter_max_width").val();
	var mi_block_length = $("#filter_min_length").val();
	var ma_block_length = $("#filter_max_length").val();
	var min_house_size = $("#filter_min_hsize").val();
	var max_house_size = $("#filter_max_hsize").val();
	var min_hland_size = $("#filter_min_hlandsize").val();
	var max_hland_size = $("#filter_max_hlandsize").val();
	
	var sort_prop = $("#sort_prop option:selected").val();
	var incids = $('input[name=filter_inclusion]:checked').map(function()
            {
                return $(this).val();
            }).get();
	if(mi_block_length == "")
	{
		var dbminwval = $("#min_block_length").val();
		$("#filter_min_length").val(dbminwval);
		mi_block_length  = $("#filter_min_length").val();
	}
	if(ma_block_length == "")
	{
		var dbmaxval = $("#max_block_length").val();
		$("#filter_max_length").val(dbmaxval);
		ma_block_length = $("#filter_max_length").val();
	}
	
	var datastring1 = 'build_location='+build_location+'&bedroom='+bedroom+'&bathrooms='+bathrooms+'&living_spaces='+living_spaces+'&car_spaces='+car_spaces+'&floor_count='+floor_count+'&alfresco='+alfresco+'&duplex='+duplex+'&builder='+builder+'&min_price_val='+min_price_val+'&max_price_val='+max_price_val+'&min_block_width='+mi_block_width+'&max_block_width='+ma_block_width+'&min_block_length='+mi_block_length+'&max_block_length='+ma_block_length+'&min_house_size='+min_house_size+'&max_house_size='+max_house_size+'&sort_prop='+sort_prop+'&incids='+incids;;
	var datastring = 'build_location='+build_location+'&bedroom='+bedroom+'&bathrooms='+bathrooms+'&living_spaces='+living_spaces+'&car_spaces='+car_spaces+'&floor_count='+floor_count+'&alfresco='+alfresco+'&duplex='+duplex+'&builder='+builder+'&min_price_val='+min_price_val+'&max_price_val='+max_price_val+'&min_block_width='+mi_block_width+'&max_block_width='+ma_block_width+'&min_block_length='+mi_block_length+'&max_block_length='+ma_block_length+'&min_house_size='+min_house_size+'&max_house_size='+max_house_size+'&sort_prop='+sort_prop+'&incids='+incids;;
	//console.log(datastring);
	var base_url = $('#base_url').val();
	var house_lands = $('#house_lands').val();
	if(house_lands == 'house_lands_page') {
	datastring1+=  '&min_hland_size='+min_hland_size+'&max_hland_size='+max_hland_size;
	datastring+=  '&min_hland_size='+min_hland_size+'&max_hland_size='+max_hland_size;
	init_ajax_house_land_properties(datastring,datastring1);
	} else {
		init_ajax_properties(datastring,datastring1);
	}
});

}
/* End  Minimum Block Length */
 if( $('#house-size').length ) {
var house_size = document.getElementById('house-size');
var min_house_size = parseInt(document.getElementById('min_house_size').value);
var max_house_size = parseInt(document.getElementById('max_house_size').value);
noUiSlider.create(house_size, {
	start: [ min_house_size, max_house_size ],
	connect: true,
	range: {
		'min': min_house_size,
		'max': max_house_size
	}
});



// Write the CSS 'left' value to a span.
function leftValue ( handle ) {
	return handle.parentElement.style.left;
}

var sizelowerValue = document.getElementById('size-lower-value'),
	sizelowerOffset = document.getElementById('size-lower-offset'),
	sizeupperValue = document.getElementById('size-upper-value'),
	sizeupperOffset = document.getElementById('size-upper-offset'),
	handles = house_size.getElementsByClassName('noUi-handle');

// Display the slider value and how far the handle moved
// from the left edge of the slider.
house_size.noUiSlider.on('update', function ( values, handle ) {
	if ( !handle ) {
		sizelowerValue.innerHTML = values[handle] + 'sq to' ;
	} else {
		sizeupperValue.innerHTML = values[handle] + ' sq+. ' ;
	}
});


house_size.noUiSlider.on('change', function(values,handle){
if ( !handle ) {
		document.getElementById('filter_min_hsize').value = values[handle];
	} else {
		document.getElementById('filter_max_hsize').value = values[handle];
	}
	var bedroom = $("#bedrooms option:selected").val();
	var build_location = $("#build_location option:selected").val();
	var bathrooms = $("#bathrooms option:selected").val();
	var living_spaces = $("#living_spaces option:selected").val();
	var car_spaces = $("#car_spaces option:selected").val();
	var floor_count = $("#floor_count option:selected").val();
	var alfresco = $("#alfresco option:selected").val();
	var duplex = $("#duplex option:selected").val();
	var builder = $("#spe-builder option:selected").val();
	var min_price_val = $("#filter_min_price").val();
	var max_price_val = $("#filter_max_price").val();
	var mi_block_width = $("#filter_min_width").val();
	var ma_block_width = $("#filter_max_width").val();
	var mi_block_length = $("#filter_min_length").val();
	var ma_block_length = $("#filter_max_length").val();
	var min_house_size = $("#filter_min_hsize").val();
	var max_house_size = $("#filter_max_hsize").val();
	var min_hland_size = $("#filter_min_hlandsize").val();
	var max_hland_size = $("#filter_max_hlandsize").val();
	var sort_prop = $("#sort_prop option:selected").val();
	var incids = $('input[name=filter_inclusion]:checked').map(function()
            {
                return $(this).val();
            }).get();
	if(min_house_size == "")
	{
		var dbminwval = $("#min_house_size").val();
		$("#filter_min_hsize").val(dbminwval);
		min_house_size  = $("#filter_min_hsize").val();
	}
	if(max_house_size == "")
	{
		var dbmaxval = $("#max_house_size").val();
		$("#filter_max_hsize").val(dbmaxval);
		max_house_size = $("#filter_max_hsize").val();
	}
	
	var datastring1 = 'build_location='+build_location+'&bedroom='+bedroom+'&bathrooms='+bathrooms+'&living_spaces='+living_spaces+'&car_spaces='+car_spaces+'&floor_count='+floor_count+'&alfresco='+alfresco+'&duplex='+duplex+'&builder='+builder+'&min_price_val='+min_price_val+'&max_price_val='+max_price_val+'&min_block_width='+mi_block_width+'&max_block_width='+ma_block_width+'&min_block_length='+mi_block_length+'&max_block_length='+ma_block_length+'&min_house_size='+min_house_size+'&max_house_size='+max_house_size+'&sort_prop='+sort_prop+'&incids='+incids;;
	var datastring = 'build_location='+build_location+'&bedroom='+bedroom+'&bathrooms='+bathrooms+'&living_spaces='+living_spaces+'&car_spaces='+car_spaces+'&floor_count='+floor_count+'&alfresco='+alfresco+'&duplex='+duplex+'&builder='+builder+'&min_price_val='+min_price_val+'&max_price_val='+max_price_val+'&min_block_width='+mi_block_width+'&max_block_width='+ma_block_width+'&min_block_length='+mi_block_length+'&max_block_length='+ma_block_length+'&min_house_size='+min_house_size+'&max_house_size='+max_house_size+'&sort_prop='+sort_prop+'&incids='+incids;;
	//console.log(datastring);
	var base_url = $('#base_url').val();
	var house_lands = $('#house_lands').val();
	if(house_lands == 'house_lands_page') {
	datastring1+=  '&min_hland_size='+min_hland_size+'&max_hland_size='+max_hland_size;
	datastring+=  '&min_hland_size='+min_hland_size+'&max_hland_size='+max_hland_size;
	init_ajax_house_land_properties(datastring,datastring1);
	} else {
		init_ajax_properties(datastring,datastring1);
	}
});
}

 if( $('#house-land-size').length ) {
var house_land_size = document.getElementById('house-land-size');
var min_house_land_size = parseInt(document.getElementById('min_house_land_size').value);
var max_house_land_size = parseInt(document.getElementById('max_house_land_size').value);
noUiSlider.create(house_land_size, {
	start: [ min_house_land_size, max_house_land_size ],
	connect: true,
	range: {
		'min': min_house_land_size,
		'max': max_house_land_size
	}
});



// Write the CSS 'left' value to a span.
function leftValue ( handle ) {
	return handle.parentElement.style.left;
}

var lsizelowerValue = document.getElementById('landsize-lower-value'),
	lsizelowerOffset = document.getElementById('landsize-lower-offset'),
	lsizeupperValue = document.getElementById('landsize-upper-value'),
	lsizeupperOffset = document.getElementById('landsize-upper-offset'),
	handles = house_land_size.getElementsByClassName('noUi-handle');

// Display the slider value and how far the handle moved
// from the left edge of the slider.
house_land_size.noUiSlider.on('update', function ( values, handle ) {
	if ( !handle ) {
		lsizelowerValue.innerHTML = values[handle] + 'sq to' ;
	} else {
		lsizeupperValue.innerHTML = values[handle] + ' sq+. ' ;
	}
});


house_land_size.noUiSlider.on('change', function(values,handle){
if ( !handle ) {
		document.getElementById('filter_min_hlandsize').value = values[handle];
	} else {
		document.getElementById('filter_max_hlandsize').value = values[handle];
	}
	var bedroom = $("#bedrooms option:selected").val();
	var build_location = $("#build_location option:selected").val();
	var bathrooms = $("#bathrooms option:selected").val();
	var living_spaces = $("#living_spaces option:selected").val();
	var car_spaces = $("#car_spaces option:selected").val();
	var floor_count = $("#floor_count option:selected").val();
	var alfresco = $("#alfresco option:selected").val();
	var duplex = $("#duplex option:selected").val();
	var builder = $("#spe-builder option:selected").val();
	var min_price_val = $("#filter_min_price").val();
	var max_price_val = $("#filter_max_price").val();
	var mi_block_width = $("#filter_min_width").val();
	var ma_block_width = $("#filter_max_width").val();
	var mi_block_length = $("#filter_min_length").val();
	var ma_block_length = $("#filter_max_length").val();
	var min_house_size = $("#filter_min_hsize").val();
	var max_house_size = $("#filter_max_hsize").val();
	var min_hland_size = $("#filter_min_hlandsize").val();
	var max_hland_size = $("#filter_max_hlandsize").val();
	var sort_prop = $("#sort_prop option:selected").val();
	var incids = $('input[name=filter_inclusion]:checked').map(function()
            {
                return $(this).val();
            }).get();
	if(min_hland_size == "")
	{
		var dbminwval = $("#min_house_land_size").val();
		$("#filter_min_hlandsize").val(dbminwval);
		min_hland_size  = $("#filter_min_hlandsize").val();
	}
	if(max_hland_size == "")
	{
		var dbmaxval = $("#max_house_land_size").val();
		$("#filter_max_hlandsize").val(dbmaxval);
		max_hland_size = $("#filter_max_hlandsize").val();
	}
	
	var datastring1 = 'build_location='+build_location+'&bedroom='+bedroom+'&bathrooms='+bathrooms+'&living_spaces='+living_spaces+'&car_spaces='+car_spaces+'&floor_count='+floor_count+'&alfresco='+alfresco+'&duplex='+duplex+'&builder='+builder+'&min_price_val='+min_price_val+'&max_price_val='+max_price_val+'&min_block_width='+mi_block_width+'&max_block_width='+ma_block_width+'&min_block_length='+mi_block_length+'&max_block_length='+ma_block_length+'&min_house_size='+min_house_size+'&max_house_size='+max_house_size+'&sort_prop='+sort_prop+'&incids='+incids;;
	var datastring = 'build_location='+build_location+'&bedroom='+bedroom+'&bathrooms='+bathrooms+'&living_spaces='+living_spaces+'&car_spaces='+car_spaces+'&floor_count='+floor_count+'&alfresco='+alfresco+'&duplex='+duplex+'&builder='+builder+'&min_price_val='+min_price_val+'&max_price_val='+max_price_val+'&min_block_width='+mi_block_width+'&max_block_width='+ma_block_width+'&min_block_length='+mi_block_length+'&max_block_length='+ma_block_length+'&min_house_size='+min_house_size+'&max_house_size='+max_house_size+'&sort_prop='+sort_prop+'&incids='+incids;;
	//console.log(datastring);
	var base_url = $('#base_url').val();
	var house_lands = $('#house_lands').val();
	if(house_lands == 'house_lands_page') {
	datastring1+=  '&min_hland_size='+min_hland_size+'&max_hland_size='+max_hland_size;
	datastring+=  '&min_hland_size='+min_hland_size+'&max_hland_size='+max_hland_size;
	init_ajax_house_land_properties(datastring,datastring1);
	} else {
		init_ajax_properties(datastring,datastring1);
	}
});
}

/* Load Quick Look Pop up */
$(document).on("click", ".open_quicklook", function () {
  //  var url = '/laravel/property/enquire_builder/'+$(this).data('id');
  var base_url = $('#base_url').val();
  var url = $('#base_url').val()+'/property/load_property_quick_look';
	var property_ids = $(this).data('id');
    //alert(url);=
    $('#enquire_forms').attr("action",url);
	
	  $.fancybox.open({
        href: url,
        type: "ajax",
        ajax: {
            type: "POST",
			crossDomain:true, 
            data:  {
                'property_ids' : property_ids,
            }
			
        },
		afterShow: function(){
		  $('.ql-slide-img').slick({
							slidesToShow: 1,
							slidesToScroll: 1,
							 prevArrow:"<a href='javascript:void(0)' class='ql-arrow ql-arrow-left'><i class='fa fa-angle-left' aria-hidden='true'></i></a>",
      nextArrow:" <a href='javascript:void(0)' class='ql-arrow ql-arrow-right'><i class='fa fa-angle-right' aria-hidden='true'></i></a>",
							fade: false,
							asNavFor: '.ql-thumb',

						});

					 $('.ql-thumb').slick({
						slidesToShow: 5,
						slidesToScroll: 1,
						asNavFor: '.ql-slide-img',
						dots: false,
						arrows: false,
						//	centerMode: true,
						focusOnSelect: true
					 });
					 
					
					 
					 			  //remove active class from all thumbnail slides
				$('.ql-slide-img .slick-slide').removeClass('slick-active');

				 //set active class to first thumbnail slides
				 $('.ql-slide-img .slick-slide').eq(0).addClass('slick-active');
					 
				 $('.ql-slide-img').slick('setPosition');
				 $('.ql-thumb').slick('setPosition');
				  $('[data-toggle="tooltip"]').tooltip();
				save_property_new();	
				save_property();	

				$('#submit_call_back').on('click',function(){
					var status = true;
					var name = $('#name').val();
					var phone_number = $('#phone_number').val();
					var email = $('#email').val();
					var contact_time = $('#contact_time').val();

					else if(name == '')
					{
						alert('Please enter FirstName');
						status = false;
					}
					else if(phone_number == '')
					{
						alert('Please enter Lastname');
						status = false;
					}
					else if(email == '')
					{
						alert('Please enter email');
						status = false;
					}
					else if(contact_time == '')
					{
						alert('Please enter Phone number');
						status = false;
					}
		if(status == true) {
		val property_id = $('#pop_prop_id').val();
		var url3 = base_url+'/property/send_request_call_back';
		var datastring4 = 'name='+name+'&phone_number='+phone_number+'&email='+email+'&contact_time='+contact_time+'&property_id='+property_id;
		jQuery('.loading').show();
  jQuery('.loading').addClass('loaderimg');
	$.ajax({
	type:'post',
		url:url3,
		data:datastring4,
		crossDomain:true, 
		success:function(data)
		{
			 if(data ==  'success') {
			 	jQuery('.loading').hide();
			jQuery('.loading').removeClass('loaderimg');
			alert('Your request has been submitted.You will be contacted soon.');
			 }
			//$('#appoint-time').html(data);
		}
		
		});
		
		}

    }); 
	 }
	
	});
	
  }); 
  


/* Load Enquire Form */
$(document).on("click", ".open_enquirybox", function () {
  //  var url = '/laravel/property/enquire_builder/'+$(this).data('id');
  var base_url = $('#base_url').val();
  var url = $('#base_url').val()+'/property/load_enquire_form';
	var property_ids = $(this).data('id');
    //alert(url);=
    $('#enquire_forms').attr("action",url);
   // $('.bs-example-modal-lg').modal('show');
	  $.ajax({
            type: 'POST',
            data: {
                'property_ids' : property_ids,
            },
            url : url,
            success: function(response) {
                if(response) {
					$('#load_content').html(response);
                    $('.bs-example-modal-lg').modal('show');
					 $('[data-toggle="tooltip"]').tooltip();  
						submit_enquire_form();		
						show_secure_div();
							
                } 
            }
        });
	
	
  });
  
  /* Load Floor Plan Pop up */
  
  $(document).on("click", ".open_landmasterplan", function () {
  //  var url = '/laravel/property/enquire_builder/'+$(this).data('id');
  var base_url = $('#base_url').val();
  var url = $('#base_url').val()+'/land/load_master_plan';
	var property_ids = $(this).data('id');
    //alert(url);=
   // $('#enquire_forms').attr("action",url);
   // $('.bs-example-modal-lg').modal('show');
	  $.ajax({
            type: 'POST',
            data: {
                'property_ids' : property_ids,
            },
            url : url,
            success: function(response) {
                if(response) {
					$('#load_masterplan_content').html(response);
                    $('.masterplan').modal('show');		
                } 
            }
        });
	
	
  });
  
   $(document).on("click", ".open_floorplan", function () {
  //  var url = '/laravel/property/enquire_builder/'+$(this).data('id');
  var base_url = $('#base_url').val();
  var url = $('#base_url').val()+'/property/load_floor_plan';
	var property_ids = $(this).data('id');
    //alert(url);=
   // $('#enquire_forms').attr("action",url);
   // $('.bs-example-modal-lg').modal('show');
	  $.ajax({
            type: 'POST',
            data: {
                'property_ids' : property_ids,
            },
            url : url,
            success: function(response) {
                if(response) {
					$('#load_floor_content').html(response);
                    $('.floorplan').modal('show');		
                } 
            }
        });
	
	
  });
  
  $(document).on("click", ".rate", function () {
  //  var url = '/laravel/property/enquire_builder/'+$(this).data('id');
 var rel =  $(this).attr('rel');
  var base_url = $('#base_url').val();
  var url = $('#base_url').val()+'/property/load_rating_form';
	  $.ajax({
            type: 'POST',
            data: {
                'rate_status' : rel,
            },
            url : url,
            success: function(response) {
                if(response) {
					$('#rate_content').html(response);
                    $('.rate_product').modal('show');
					$('.thnku').click(function() {
						 $('.rate_product').modal('hide')
					});
					// $('[data-toggle="tooltip"]').tooltip();  
						submit_feedback_form();		
						//show_secure_div();
							
                } 
            }
        });
	
	
  });
  
  function show_secure_div()
  {
	$('#secured_finance').on('change',function(){
	var finance_val = $(this).val();
	if(finance_val == 'yes') {
		$('#yes-secured').show();
		$('#no-secured').hide();
		$('#await-secured').hide();
	}
	if(finance_val == 'no') {
		$('#yes-secured').hide();
		$('#no-secured').show();
		$('#await-secured').hide();
	}
	if(finance_val == 'awaiting-approval') {
		$('#yes-secured').hide();
		$('#no-secured').hide();
		$('#await-secured').show();
	}
	if(finance_val == '') {
		$('#yes-secured').hide();
		$('#no-secured').hide();
		$('#await-secured').hide();
	}
	
	});
  }
  
 function submit_enquire_form() { 
$( "#enquire_forms" ).submit(function( event ) {
	formdata = $( this ).serialize();
	url = $(this).attr('action');
	 //$('#loading-indicator').show();
	 jQuery('.loading').show();
  jQuery('.loading').addClass('loaderimg');
 	$.ajax({
		type:'post',
		url:url,
		data:formdata,
		crossDomain:true, 
		success:function(data)
		{ 
			//$('#loading-indicator').hide();
			jQuery('.loading').hide();
    jQuery('.loading').removeClass('loaderimg');
			if(data == 'success'){
			document.getElementById("enquire_forms").reset();
				$('#message_success').html('<p>Your query sent to builder. You will be contacted soon.</p>');
				$('#message_success').show();
				$('#message_error').hide();
				setTimeout(function() {$('.bs-example-modal-lg').modal('hide');}, 5000);
			}else if(data == 'failed_savesomehomes'){
				$('#message_error').html('<p>Please save some homes.</p>');
				$('#message_error').show();
				$('#message_success').hide();
			}else if(data == 'validation_error'){
				$('#message_error').html('<p>Please Fill all fields</p>');
				$('#message_error').show();
				$('#message_success').hide();
			}
			
			return false;
		}
	});
  event.preventDefault();
});
}

function submit_feedback_form() { 
 $( "#enquire_forms1" ).submit(function( event ) {
 var st = false;
 if($('#biggest_impact').val() == 'select impact')
	{
		alert("Select a relevant issue");
		st = true;
	}
	if(st == false) {
	formdata = $( this ).serialize();
	url = $(this).attr('action');
	 //$('#loading-indicator').show();
	 jQuery('.loading').show();
  jQuery('.loading').addClass('loaderimg');
 	$.ajax({
		type:'post',
		url:url,
		data:formdata,
		crossDomain:true, 
		success:function(data)
		{ 
			//$('#loading-indicator').hide();
			jQuery('.loading').hide();
    jQuery('.loading').removeClass('loaderimg');
			if(data == 'success'){
				$('#message_success').text('Your feedback hasbeen sent successfully');
				$('#message_success').show();
				$('#message_error').hide();
				setTimeout(function() {$('.rate_product').modal('hide');}, 5000);
			}else if(data == 'failed_savesomehomes'){
				$('#message_error').text('Please save some homes');
				$('#message_error').show();
				$('#message_success').hide();
			}else if(data == 'validation_error'){
				$('#message_error').text('Please Fill all fields');
				$('#message_error').show();
				$('#message_success').hide();
			}
			
			return false;
		}
	});
	}
  event.preventDefault();
});
}

$( ".form-login" ).submit(function( event ) {
	formdata = $( this ).serialize();
	url = $(this).attr('action');
	//console.log(url);
	 //$('#loading-indicator').show();
 	$.ajax({
		type:'post',
		url:url,
		data:formdata,
		crossDomain:true, 
		success:function(data)
		{ 
			   if(data.fail) {
		$('.reg_error').text('');
		$('#message_error1').html('');
          $.each(data.errors, function( index, value ) {
            var errorDiv = '#'+index+'_error1';
            $(errorDiv).addClass('required');
            $(errorDiv).empty().append(value);
          });
          $('#successMessage').empty();          
        } 
        if(data.success) {
		$('#message_error1').html('');
		$('.reg_error').text('');
           location.reload();
		  
        }
				   if(data.regfail) {
				   $('#message_error1').html('Invalid username/password');
		$('.reg_error').text('');
          $('#successMessage').empty();          
        } 
			
			
		}
	});
  event.preventDefault();
});

$( ".builder-login" ).submit(function( event ) {
	formdata = $( this ).serialize();
	url = $(this).attr('action');
	 //$('#loading-indicator').show();
 	$.ajax({
		type:'post',
		url:url,
		data:formdata,
		crossDomain:true, 
		success:function(data)
		{ 
			//$('#loading-indicator').hide();
			if(data == 'validation_error'){
				$('#message_error2').text('Please fill all fields');
				$('#message_error2').show();
				$('#message_success2').hide();
			}else if(data == 'error_usernamepass'){
				$('#message_error2').text('Invalid UserName and Password');
				$('#message_error2').show();
				$('#message_success2').hide();
			}else if(data == 'success'){
				location.reload();
			}
			//setTimeout(function() {$('.login-modal-lg').modal('hide');}, 5000);
			return false;
		}
	});
  event.preventDefault();
});

$( "#subscription_form" ).submit(function( event ) {
	var pattern = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
    var email = $('#subsc_email').val();
    if( !pattern.test( email ) ) {
    	$('#message_er').text('Please enter valid email');
    	$('#message_suc').hide();
		$('#message_er').show();
    	return false; 
    } else {
    
		formdata = $( this ).serialize();
		url = $(this).attr('action');
		 //$('#loading-indicator').show();
	 	$.ajax({
			type:'get',
			url:url,
			data:formdata,
			crossDomain:true, 
			success:function(data)
			{
				 if(data == 'Thank you for subscribing'){
					$('#message_suc').text(data);
					$('#message_er').hide();
					$('#message_suc').show();
				}else{
					$('#message_er').text(data);
					$('#message_suc').hide();
					$('#message_er').show();
				}
			}
		});
	}
	event.preventDefault();
 });

$('#main_regionchange').change(function(){
	var url = $('#ajax_searchstate').val();
	var stat = $(this).val();
	 //$('#loading-indicator').show();
 	$.ajax({
		type:'get',
		url:url,
		data:'state='+stat,
		crossDomain:true, 
		success:function(data)
		{ 
			var main_states = [];
			main_states.push({'QLD':'Queensland'});
			main_states.push({'VIC' :'Victoria'});
			main_states.push({'NSW' :'New South Wales'});
			main_states.push({'WA' :'Western Australia'});
			main_states.push({'TAS' :'Tasmania'});
			main_states.push({'NT' :'Northern Territory'});
			main_states.push({'ACT' :'Australian Capital Territory'});
			main_states.push({'SA' :'South Australia'});
			var option = '<option value="build-region">Select build region</option>';
			//var optionlabel = '<optgroup label="">';
			$.each(main_states, function(index,value){
				if(value[stat] != undefined){
					optionlabel = '<optgroup label="'+value[stat]+'">';
				}
			});
			
			var option_val = '';
			for (var i=0; i<data.length; i++) {
		      option_val += '<option value="' + data[i].id + '">' + data[i].loc_name + '</option>';
		    }
			optionlabell = '</optgroup>';
			$('#search_region').empty();
			$('#search_region').html(option+optionlabel+option_val+optionlabell);
		}
	});
});

$('#filter-region').change(function(){
	  var base_url = $('#base_url').val();
	  var url = base_url+'/land/change-land-state-search';
	var stat = $(this).val();
	 //$('#loading-indicator').show();
 	$.ajax({
		type:'post',
		url:url,
		data:'state='+stat,
		crossDomain:true, 
		success:function(data)
		{ 
			var main_states = [];
			main_states.push({'QLD':'Queensland'});
			main_states.push({'VIC' :'Victoria'});
			main_states.push({'NSW' :'New South Wales'});
			main_states.push({'WA' :'Western Australia'});
			var option = '<option value="build-region">Select build region</option>';
			//var optionlabel = '<optgroup label="">';
			$.each(main_states, function(index,value){
				if(value[stat] != undefined){
					optionlabel = '<optgroup label="'+value[stat]+'">';
				}
			});
			
			var option_val = '';
			for (var i=0; i<data.length; i++) {
		      option_val += '<option value="' + data[i].id + '">' + data[i].loc_name + '</option>';
		    }
			optionlabell = '</optgroup>';
			$('#search_region1').empty();
			$('#search_region1').html(option+optionlabel+option_val+optionlabell);
		}
	});
});

    $( "#regForm" ).submit(function( event ) {    
      event.preventDefault();
      var $form = $( this ),
        data = $form.serialize(),
        url = $form.attr( "action" );
		//jQuery('.loading').show();
  //jQuery('.loading').addClass('loaderimg');
      var posting = $.post( url, { formData: data } );
      posting.done(function( data ) {
	  //console.log(data);
        if(data.fail) {
			//jQuery('.loading').hide();
    //jQuery('.loading').removeClass('loaderimg');
		$('.reg_error').text('');
          $.each(data.errors, function( index, value ) {
            var errorDiv = '#'+index+'_error';
            $(errorDiv).addClass('required');
            $(errorDiv).empty().append(value);
          });
          $('#successMessage').empty();          
        } 
        if(data.success) {
		$('.reg_error').text('');
			jQuery('.loading').hide();
   // jQuery('.loading').removeClass('loaderimg');
	//	$('.reg_error').text('');
            //$('.register').fadeOut(); //hiding Reg form
            var successContent = '<h5>Registration Completed Successfully</h5>';
			$('#firstname').val('');
			$('#lastname').val('');
			$('#email').val('');
			$('#phone').val('');
			$('#user_location').val('');
			$('#password').val('');
          $('#successMessage').html(successContent);
		   $('#successMessage').show();
		  
        } //success
		
      }); //done
    });
	
	$('.discovers').on('click',function(){
	var rel = $(this).attr('rel');
	var datastring = 'state='+rel;
	var base_url = $('#base_url').val();
	  var url = base_url+'/builder/change-builder-state';
		$.ajax({
		type:'post',
		url:url,
		data:datastring,
		crossDomain:true, 
		success:function(data)
		{ 
			
		}
	});
	});

