<?php 

/*
* Logs out user and redirects to home.
*/

UserLogin::logOut();

header('Location: /');
die();