<?php

//Home page: Create account or log in
class Controller extends AppController {
	protected function init() {
	}
}

$controller = new Controller();

extract($controller->view->vars);

?>

<div class="login-content">
    <main class="login-main">
        <div>
            <form action="/login" method="POST" class="login-form reptile-form">
                <input class="user_name" type="text" name="user_name" title="Username">
                <input class="password" type="password" name="password" data-exp-name="password" title="Password">
                <input class="email" type="email" name="email" data-exp-name="email" title="E-mail">
                <input class="location" type="location" name="location" title="Location" data-exp-name="location">
                <button class="submit">submit</button>
                <button class="sign-up">sign up</button>
            </form>
            <!-- <div class="errormsg"></div> -->
        </div>
    </main>
</div>

    
