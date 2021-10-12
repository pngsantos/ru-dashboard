require('./bootstrap');

$( document ).ready(function() {
	$("*[data-modal]").click(function(){
		let modal = $(this).data('modal');
		let view = $(this).data('view');
		let route = $(this).data('route');

		if(!route)
		{
			route = BASE_URL + "/api/modal/load/";
		}

		data = {};
		if(view)
		{
			data = {
                'view' : view
			};
		}

		$(modal).find(".modal-content").html('<div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>');

		$.ajax({
            type: 'get',
            url: route,
            data: data,
            success: function (response) {
                console.log(response);

                $(modal).find(".modal-content").html(response.html);
                $(modal).find(".modal-content *[name='_token']").val($("#csrf-token").attr('content'));
                $(modal).modal('show');
            },
            error: function (data, text, error) {
                console.log(data);
            }
        });
	});
});

function pullDailySLP(ronin, cb)
{
    let ronin_address = ronin.replace("ronin:", "0x");

	$.ajax({
	    type: 'get',
	    url: 'https://game-api.skymavis.com/game-api/clients/' + ronin_address + '/items/1',
	    success: function (response) {
	        console.log(response);

	        if(cb)
	        {
	        	cb(response);
	        }
	    },
	    error: function (data, text, error) {
	        console.log(data);
	    }
	});
}