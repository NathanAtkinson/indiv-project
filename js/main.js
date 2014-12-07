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



	$('a').on('click', function() {
		$(this).toggleClass('selected');
		//TODO logic to determine if new dislike or removing dislike. Then AJAX call
		//to complete this.  Currently, "changes" are reflected without actually occuring
		if ($(this).hasClass('selected')) {
			var topping_id = $(this).parents('div.topping').attr('data-topping-id');
			console.log("topping_id: " + topping_id);
			var user_id = $('div.profile-info').attr('data-user_id');
			console.log("user_id: " + user_id);
		} else {
			var topping_id = $(this).parents('div.topping').attr('data-topping-id');
			console.log("topping_id: " + topping_id);
			var user_id = $('div.profile-info').attr('data-user_id');
			console.log("user_id: " + user_id);
		}
	});




	/*
	* Gets from payload the list of user's dislikes.  It then finds those 
	* topping id's and reflects them as disliked
	*/
	// console.log(app.settings.dislikes);
	var dislikes = app.settings.dislikes;

	for (var dislike in dislikes){
		// console.log(dislike);
		// console.log(dislikes[dislike]);
		var topping_id = dislikes[dislike].topping_id;
		// console.log('topping id: ' + topping_id);
		// var points = dislikes[dislike].points;
		// console.log('points: ' + points);

		$("div[data-topping-id='" + topping_id + "']")
      	.find('a')
      	.addClass('selected');
  	}





})();