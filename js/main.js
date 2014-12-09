/**
 * Application JS
 */
(function() {

	//changed to .reptile-form selector instead of form tag
	var form = new ReptileForm('.reptile-form');

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
		if(data.redirect){
			location.href=data.redirect;
		} else if (data.errormsg) {
			var message = data.errormsg;
			$("form.login-form").append('<br><BR>' + message);
		}
	});

	// Do something when the AJAX request has returned with an error
	form.on('xhrError', function(e, xhr, settings, thrownError) {
		$('body').append('<p>Submittion Error: ' + thrownError + '</p>');
	});


	$('div.toppings.user').on('click', 'a', function() {
		$(this).toggleClass('selected');
		
		if ($(this).hasClass('selected')) {
			var topping_id = $(this)./*parents('div.topping').*/attr('data-topping-id');
			// console.log("topping_id: " + topping_id);
			var user_id = $('div.profile-info').attr('data-user_id');
			// console.log("user_id: " + user_id);
			
			$array = $.ajax({
				url: '/toppings/add',
				type: 'POST',
				dataType: 'json',
				cache: false,
				data: {user_id: user_id, topping_id: topping_id},
				success: function(data){
					var topping_id = data.topping_id;
					// console.log(data);
				},
				error: function(){
					console.log('error');
					console.log('data: ' + data);
				}
			});
		} else {
			var topping_id = $(this)./*parents('div.topping').*/attr('data-topping-id');
			// console.log("topping_id: " + topping_id);
			var user_id = $('div.profile-info').attr('data-user_id');
			// console.log("user_id: " + user_id);

			$array = $.ajax({
				url: '/toppings/remove',
				type: 'POST',
				dataType: 'json',
				cache: false,
				data: {user_id: user_id, topping_id: topping_id},
				success: function(data){
					var topping_id = data.topping_id;
					// console.log(data);
				},
				error: function(){
					console.log('error');
					console.log('data: ' + data);
				}
			});
		}
	});


	//on build page, reflects selections made regarding toppings
	$('div.toppings.build').on('click', 'a', function() {
		$(this).toggleClass('selected');
		
		if ($(this).hasClass('selected')) {
			var topping_id = $(this)./*parents('div.topping').*/attr('data-topping-id');
			console.log("topping_id: " + topping_id);
			/*var user_id = $('div.profile-info').attr('data-user_id');
			console.log("user_id: " + user_id);*/
			
			/*$array = $.ajax({
				url: '/toppings/add',
				type: 'POST',
				dataType: 'json',
				cache: false,
				data: {user_id: user_id, topping_id: topping_id},
				success: function(data){
					var topping_id = data.topping_id;
					// console.log(data);
				},
				error: function(){
					console.log('error');
					console.log('data: ' + data);
				}
			});*/
		} else {
			var topping_id = $(this)./*parents('div.topping').*/attr('data-topping-id');
			console.log("topping_id: " + topping_id);
			// var user_id = $('div.profile-info').attr('data-user_id');
			// console.log("user_id: " + user_id);

			/*$array = $.ajax({
				url: '/toppings/remove',
				type: 'POST',
				dataType: 'json',
				cache: false,
				data: {user_id: user_id, topping_id: topping_id},
				success: function(data){
					var topping_id = data.topping_id;
					// console.log(data);
				},
				error: function(){
					console.log('error');
					console.log('data: ' + data);
				}
			});*/
		}
	});

	// when users are added to/from recommendation
	$('div.friends').on('click', 'a', function() {
		$(this).toggleClass('selected');
		if ($(this).hasClass('selected')) {
			var user_id = $(this).attr('data-user-id');
			console.log("user_id: " + user_id);
			
		} else {
			var user_id = $(this).attr('data-user-id');
			console.log("user_id: " + user_id);

		}
	});
	
	

	//TODO need to grab values of toppings and users...pass to next page
	$('body').on('click', '#suggestions', function() {
		// e.preventDefault();
		var friends = [];
		// $('div.friends').find('a.selected').attr('data-user-id');
		$('div.friends').find('a.selected').each(function () {
			friends.push($(this).attr('data-user-id'));
			console.log(friends);
		});
		// make the array a string
		var ids = friends.join(',');
		//set a hidden value field in form with a value of the string'
		$('#user-ids').val(ids);
		// submits to next page
		// $('#theform').submit();


		var toppings = [];
		// $('div.friends').find('a.selected').attr('data-user-id');
		$('div.build.toppings').find('a.selected').each(function () {
			toppings.push($(this).attr('data-topping-id'));
			console.log(toppings);
		});
		// make the array a string
		var tops = toppings.join(',');
		//set a hidden value field in form with a value of the string'
		$('#topping-ids').val(tops);

	});


	/*
	* Gets from payload the list of user's dislikes.  It then finds those 
	* topping id's and reflects them as disliked
	*/
	// console.log(app.settings.dislikes);
	var dislikes = app.settings.dislikes;

	for (var dislike in dislikes){
		var topping_id = dislikes[dislike].topping_id;

		$("a[data-topping-id='" + topping_id + "']")
      	// .find('a')
      	.addClass('selected');
  	}

  	



})();