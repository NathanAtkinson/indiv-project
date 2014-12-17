## BACKLOG


need to talk with Jon about using a string with "," via cleanedInput

camel case or underscore?  Need to be consistent!

clean up comments out of code

# Design
 - [ ] Optimize CSS
 - [x] Find better background
 	-  [x] fuzzy background? NO
 - [x] Footer
 - [x] Users are displayed differently than ingredients



# Features
 - [ ] When other user(s) selected, reflect their dislikes in the "other" toppings
 - [ ] Add friends (instead of all users)
 	- [ ] ability to scroll through friends
 	- [ ] ability to search friends
 - [ ] Favorite ingredients indicated...  actual profile info: location, fav topping, misc
 - [ ] Consider ability to order 1/2 pizzas
 - [ ] Users on creation- check for already existing username and prohibit duplicate usernames



# Algorithm
 -  [x] past_orders table...track orders
 	-Can then use next step in recommendation by taking past orders of that user(s) and finding out what they're likely to pick
 -  [x] get list of recipes from remaining ingredients.
 	-  [x] remove any recipes with dislikes
 -  [x] keep track of number of dislikes to improve recs for current user(s)
 - [x] keep track up up/down votes for recs.  Downvoted will be removed from page, show next rec.
 - [ ] add events table...  track location, users, pizzas, time ordered, etc. Also allows to plan in advance (increases recruitment/acct making).
 - [ ] Rating for toppings.  Give rec based on topping "totals" based on users present ratings.
 - [ ] Only exempt ingredients based on Build page. (thumbs down on profile = -5 for topping?)


# Other
- [ ] Abstract more