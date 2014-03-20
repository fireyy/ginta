<?php

Route::get('/login/', function() {
	var_dump($_GET["code"]);

	//return View::home($vars);
});