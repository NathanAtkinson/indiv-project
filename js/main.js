
(function() {

	//settings for ajax calls
	$.ajaxSetup({
		type: 'POST',
		dataType: 'json',
		cache: false
	});


	//changed to .reptile-form selector instead of form
	var form = new ReptileForm('.reptile-form');

	// Do something before validation starts
	/*form.on('beforeValidation', function() {
		// $('body').append('<p>Before Validation</p>');
	});*/

	// When there's an error, presents to user as an alert with just the message
	form.on('validationError', function(e, err) {
		var response = JSON.stringify(err);
		response = JSON.parse(response);
		alert(response[0].msg);
	});

	// Do something after validation is successful, but before the form submits.
	/*form.on('beforeSubmit', function() {
		// $('body').append('<p>Sending Values: ' + JSON.stringify(this.getValues()) + '</p>');

	});*/

	// Do something when the AJAX request has returned in success
	form.on('xhrSuccess', function(e, data) {
		//if there's a redirect in response, do so
		if(data.redirect){
			location.href=data.redirect;
		//if there's an error, present to user the message only as alert
		} else if (data.errormsg) {
			var message = data.errormsg;
			alert(message);
		}
	});

	// If there's a thrown error, present to user the message via alert.
	form.on('xhrError', function(e, xhr, settings, thrownError) {
		alert('<p>Submission Error: ' + thrownError + '</p>');
	});

	//on landing at the home page, hides the e-mail field
	$('.login-form .email').attr('hidden', '');

	//adds e-mail field for signup when signup is pressed on home page and hides sign-up button
	$('.login-form').on('click', 'button.sign-up', function(e) {
		e.preventDefault();
		$(this).hide();
        $('.login-form .email').toggle(); 
	});

	//on the profile page, if an ingredient is clicked, add/removes the dislike
	//This hits the DB and also changes the look on the page
	$('div.toppings.user').on('click', 'a', function() {
		$(this).toggleClass('selected');
		
		if ($(this).hasClass('selected')) {
			var topping_id = $(this).attr('data-topping-id');
			var user_id = $('div.profile-info').attr('data-user_id');
			
			$array = $.ajax({
				url: '/toppings/add',
				data: {user_id: user_id, topping_id: topping_id},
				success: function(data){
					var topping_id = data.topping_id;
				},
				error: function(){
					console.log('error');
					console.log('data: ' + data);
				}
			});
		} else {
			var topping_id = $(this).attr('data-topping-id');
			var user_id = $('div.profile-info').attr('data-user_id');

			$array = $.ajax({
				url: '/toppings/remove',
				data: {user_id: user_id, topping_id: topping_id},
				success: function(data){
					var topping_id = data.topping_id;
				},
				error: function(){
					console.log('error');
					console.log('data: ' + data);
				}
			});
		}
	});


	//on build page, reflects selections made regarding toppings
	//this does not hit the DB and is only used on the suggestions page
	$('div.toppings.build').on('click', 'a', function() {
		$(this).toggleClass('selected');
	});

	// when users are added to/from recommendation this is reflected on the current page.
	// used on the next page to build recommendation by taking all profiles involved
	$('div.friends').on('click', 'a', function() {
		$(this).toggleClass('selected');
		if ($(this).hasClass('selected')) {
			var user_id = $(this).attr('data-user-id');
		} else {
			var user_id = $(this).attr('data-user-id');
		}
	});

	//When the suggestion link is clicked, grabs values of toppings and users
	//sets them to hidden inputs so they can be passed to the next page
	$('body').on('click', '#suggestions', function() {
		var friends = [];
		//in div.friends, gets each friend selected and adds to array
		$('div.friends').find('a.selected').each(function () {
			friends.push($(this).attr('data-user-id'));
			console.log(friends);
		});
		// make the array a string that's passed
		var ids = friends.join(',');
		//set a hidden value field in form with a value of the string'
		$('#user-ids').val(ids);

		var toppings = [];
		//in div.build.toppings, gets each topping selected and adds to array
		$('div.build.toppings').find('a.selected').each(function () {
			toppings.push($(this).attr('data-topping-id'));
			console.log(toppings);
		});
		// make the array a string that's passed
		var tops = toppings.join(',');
		//set a hidden value field in form with a value of the string'
		$('#topping-ids').val(tops);
	});


	// Gets from payload the list of user's dislikes.  It then finds those 
	// topping id's and reflects them as disliked on the user's profile (and build page)
	var dislikes = app.settings.dislikes;
	for (var dislike in dislikes){
		var topping_id = dislikes[dislike].topping_id;
		$("a[data-topping-id='" + topping_id + "']").addClass('selected');
  	}

  	//when the a.suggestion is clicked, gets users involved and the id of the recipe_id
  	$('.suggestion').on('click', 'a', function() {
  		var pizza_recipe_id = $(this).parents('.feedback').attr('data-pizza-recipe-id');
  		var user_ids = $(this).parents('.suggestions').attr('data-user-ids');

  		//if it's an upvote, then adds to DB and remove yes/no from page (prevents double clicking)
		if($(this).attr('data-vote') == "yes"){
			$.ajax({
				url: '/orders/add',
				data: {user_ids: user_ids, pizza_recipe_id: pizza_recipe_id},

				//on success, hide this div from page so can't vote again.  Also add selected class
				//to parent so can fetch this later.
				success: function(data){
					var pizza_recipe_id = data.pizza_recipe_id;
					$('div[data-pizza-recipe-id="' + pizza_recipe_id + '"]').parents('div.suggestion').toggleClass('selected');
					$('div[data-pizza-recipe-id="' + pizza_recipe_id + '"]').hide();
				},
				error: function(){
					console.log('error');
					console.log('data: ' + data);
				}
	  		});
	  	//if it's a downvote, then adds to DB and removes option from page
		} else {
			console.log('no');
			$.ajax({
				url: '/orders/down',
				data: {user_ids: user_ids, pizza_recipe_id: pizza_recipe_id},

				//on success, remove suggestion from the page
				success: function(data){
					var pizza_recipe_id = data.pizza_recipe_id;
					$('div[data-pizza-recipe-id="' + pizza_recipe_id + '"]').parents('div.suggestion').remove();
					$('div.suggestions').find('div.other-option').first().toggleClass('other-option');
				},
				error: function(){
					console.log('error');
					console.log('data: ' + data);
				}
	  		});
		}
	});

	//When the nearby link is clicked, grabs names of selected recipes
	//sets them to hidden input so they can be passed to the next page
	$('body').on('click', '#nearby', function() {
		var pizza_recipe_names = [];
		//in div.friends, gets each friend selected and adds to array
		$('div.suggestions').find('div.suggestion.selected').find('h3').each(function () {
			pizza_recipe_names.push($(this).html());
		});
		// make the array a string that's passed
		var pizza_names = pizza_recipe_names.join(';');
		//set a hidden value field in form with a value of the string'
		$('#pizza-recipe-names').val(pizza_names);
	});
})();