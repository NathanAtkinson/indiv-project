/**
 * Application JS
 */
(function() {

	var form = new ReptileForm('form');

	// Do something before validation starts
	form.on('beforeValidation', function() {
		$('body').append('<p>Before Validation</p>');
	});

	// Do something when errors are detected.
	form.on('validationError', function(e, err) {
		$('body').append('<p>Errors: ' + JSON.stringify(err) + '</p>');
	});

	// Do something after validation is successful, but before the form submits.
	form.on('beforeSubmit', function() {
		$('body').append('<p>Sending Values: ' + JSON.stringify(this.getValues()) + '</p>');
	});

	// Do something when the AJAX request has returned in success
	form.on('xhrSuccess', function(e, data) {
		$('body').append('<p>Received Data: ' + JSON.stringify(data) + '</p>');
	});

	// Do something when the AJAX request has returned with an error
	form.on('xhrError', function(e, xhr, settings, thrownError) {
		$('body').append('<p>Submittion Error</p>');
	});


	$('div.toppings').on('click', 'a', function() {
		$(this).toggleClass('selected');
		
		if ($(this).hasClass('selected')) {
			var topping_id = $(this).parents('div.topping').attr('data-topping-id');
			console.log("topping_id: " + topping_id);
			var user_id = $('div.profile-info').attr('data-user_id');
			console.log("user_id: " + user_id);
			
			$array = $.ajax({
				url: '/toppings/add',
				type: 'POST',
				dataType: 'json',
				cache: false,
				data: {user_id: user_id, topping_id: topping_id},
				// async: false,
				success: function(data){
					var topping_id = data.topping_id;
					console.log(data);
					// location.href = "/profile";
				},
				error: function(){
					console.log('error');
					console.log('data: ' + data);
				}
			});
		} else {
			var topping_id = $(this).parents('div.topping').attr('data-topping-id');
			console.log("topping_id: " + topping_id);
			var user_id = $('div.profile-info').attr('data-user_id');
			console.log("user_id: " + user_id);

			$array = $.ajax({
				url: '/toppings/remove',
				type: 'POST',
				dataType: 'json',
				cache: false,
				data: {user_id: user_id, topping_id: topping_id},
				// async: false,
				success: function(data){
					var topping_id = data.topping_id;
					console.log(data);
					// location.href = "/profile";
				},
				error: function(){
					console.log('error');
					console.log('data: ' + data);
				}
			});
		}
	});

	// when users are added to/from recommednation
	$('div.friends').on('click', 'a', function() {
		$(this).toggleClass('selected');
		console.log(this);
		if ($(this).hasClass('selected')) {
			var user_id = $(this).attr('data-user-id');
			console.log("user_id: " + user_id);
			
			// $array = $.ajax({
			// 	url: '/toppings/add',
			// 	type: 'POST',
			// 	dataType: 'json',
			// 	cache: false,
			// 	data: {user_id: user_id, topping_id: topping_id},
			// 	// async: false,
			// 	success: function(data){
			// 		var topping_id = data.topping_id;
			// 		console.log(data);
			// 		// location.href = "/profile";
			// 	},
			// 	error: function(){
			// 		console.log('error');
			// 		console.log('data: ' + data);
			// 	}
			// });
		} else {
			var user_id = $(this).attr('data-user-id');
			console.log("user_id: " + user_id);

			/*$array = $.ajax({
				url: '/toppings/remove',
				type: 'POST',
				dataType: 'json',
				cache: false,
				data: {user_id: user_id, topping_id: topping_id},
				// async: false,
				success: function(data){
					var topping_id = data.topping_id;
					console.log(data);
					// location.href = "/profile";
				},
				error: function(){
					console.log('error');
					console.log('data: ' + data);
				}
			});*/
		}
	});
	

	/*
	* Gets from payload the list of user's dislikes.  It then finds those 
	* topping id's and reflects them as disliked
	*/
	// console.log(app.settings.dislikes);
	var dislikes = app.settings.dislikes;

	for (var dislike in dislikes){
		var topping_id = dislikes[dislike].topping_id;

		$("div[data-topping-id='" + topping_id + "']")
      	.find('a')
      	.addClass('selected');
  	}

  	



})();