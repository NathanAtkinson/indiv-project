/**
 * Application JS
 */
(function() {

	//changed to .reptile-form selector instead of form tag
	var form = new ReptileForm('.reptile-form');

	// Do something before validation starts
	form.on('beforeValidation', function() {
		// $('body').append('<p>Before Validation</p>');
	});

	// Do something when errors are detected.
	form.on('validationError', function(e, err) {
		response = JSON.stringify(err);
		response = JSON.parse(response);
		alert(response[0].msg);
	});

	// Do something after validation is successful, but before the form submits.
	form.on('beforeSubmit', function() {
		// $('body').append('<p>Sending Values: ' + JSON.stringify(this.getValues()) + '</p>');

	});

	// Do something when the AJAX request has returned in success
	form.on('xhrSuccess', function(e, data) {
		if(data.redirect){
			location.href=data.redirect;
		} else if (data.errormsg) {
			var message = data.errormsg;
			alert(message);
		}
	});

	// Do something when the AJAX request has returned with an error
	form.on('xhrError', function(e, xhr, settings, thrownError) {
		alert('<p>Submission Error: ' + thrownError + '</p>');
	});


	//on landing at the home page, hides the e-mail field
	$('.login-form .email').attr('hidden', '');

	//adds e-mail field for signup when signup is pressed on home page.
	$('.login-form').on('click', 'button.sign-up', function(e) {
		e.preventDefault();
		console.log('Sign-up pressed');
		$(this).hide();
        $('.login-form .email').toggle(); 
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

  	$('.suggestion').on('click', 'a', function() {
  		var pizza_recipe_id = $(this).parents('.feedback').attr('data-pizza-recipe-id');
  		console.log(pizza_recipe_id);
  		var user_ids = $(this).parents('.suggestions').attr('data-user-ids');
  		console.log(user_ids);
  		// var array_user_ids = user_ids.split(",");
  		// console.log(array_user_ids);
		if($(this).attr('data-vote') == "yes"){
			$.ajax({
			url: '/orders/add',
			type: 'POST',
			dataType: 'json',
			cache: false,
			data: {user_ids: user_ids, pizza_recipe_id: pizza_recipe_id},
			success: function(data){
				// var topping_id = data.topping_id;
				// console.log(data);
				var pizza_recipe_id = data.pizza_recipe_id;
				// console.log("recipeid" + pizza_recipe_id);
				// console.log('this:' + $(this));
				// console.log($('a[data-pizza-recipe-id="' + pizza_recipe_id + '"]'));
				($('div[data-pizza-recipe-id="' + pizza_recipe_id + '"]')).remove();
			},
			error: function(){
				console.log('error');
				console.log('data: ' + data);
			}
	  		});
		} else {
			console.log('no');
			$.ajax({
			url: '/orders/down',
			type: 'POST',
			dataType: 'json',
			cache: false,
			data: {user_ids: user_ids, pizza_recipe_id: pizza_recipe_id},

			//on success, remove suggestion from the page
			success: function(data){
				// var topping_id = data.topping_id;
				// console.log(data);
				var pizza_recipe_id = data.pizza_recipe_id;
				// console.log("recipeid" + pizza_recipe_id);
				// console.log('this:' + $(this));
				// console.log($('a[data-pizza-recipe-id="' + pizza_recipe_id + '"]'));
				($('div[data-pizza-recipe-id="' + pizza_recipe_id + '"]')).parents('div.suggestion').remove();
				var sugg = $('div.suggestions').find('div.other-option').first().attr('data-pizza-recipe-id');
				$('div.suggestions').find('div.other-option').first().toggleClass('other-option');
				/*.find('div.feedback').attr('data-pizza-recipe-id')*/
				console.log(sugg);
			},
			error: function(){
				console.log('error');
				console.log('data: ' + data);
			}
	  		});
		}
		
	});
  	



})();