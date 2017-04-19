 $.ajaxSetup({
   headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
});

    $(document).ready(function () {
	
	if($( "#sortable" ).length) {

	$( "#sortable" ).sortable({

		update: function (event, ui) {
			var data = $(this).sortable('serialize');
 var baseUrl = $('#base_url').val();
 var url = baseUrl+'/admin/property/update_sort_properties';

       
			// POST to server using $.post or $.ajax
			$.ajax({
				data: data,
				type: 'POST',
				url: url,
				crossDomain:true, 
				success:function(data)
				{
					$('#success').html(data);
				}
			});
		}
	
	});
    $( "#sortable" ).disableSelection();
		 
	}

});

