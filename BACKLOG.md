## BACKLOG




# Design
 - Optimize CSS
 - Find better background
 	- fuzzy background?
 - Footer
 - Users are displayed differently than ingredients



# Features
 - When other user(s) selected, reflect their dislikes in the "other" toppings




# Algorithm
 - events table...track orders
 	-Can then use next step in recommendation by taking past orders of that user(s) and finding out what they're likely to pick
 - get list of recipes from remaining ingredients.
 	- remove any recipes with dislikes that begin with a non-dislike
 - keep track of number of dislikes to improve recs for current user(s)
 


# DRY
 - View fragments inherit common methods from parent instead


# Check on:
 - Split build rec into two pages?  Users, then other ingredients to avoid?