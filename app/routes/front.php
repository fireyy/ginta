<?php

/*
 * Home page
 */
Route::get(array('/', 'home'), function() {
  $vars["guest"] = Session::get("auth");
  /*$vars["guest"] = Auth::guest();
  if(!$vars["guest"]){ 
    $vars["user"] = Auth::user();
  }*/
	return View::home($vars);
});

/*
 * Login
 */
Route::get('login', function() {
  $code = $_GET["code"];
  $duoshuo = new Duoshuo();
  $duoshuo_client = $duoshuo->getClient();
  $parm = array(
    "code" => $code,
    "redirect_uri" => "/"
  );
  $result = $duoshuo_client->getAccessToken("code", $parm);
  //var_dump($result);exit();
  $user = User::search(array("duoshuo_uid"=>$result["user_id"]));
  if(!$user){
    $uid = User::create(array(
      "role" => "admin",
      "status" => "inactive",
      "created" => Date::mysql("now"),
      "duoshuo_uid" => $result["user_id"],
      "duoshuo_token" => $result["access_token"]
    ));
    Auth::attempt($uid);
  }else{
    Session::put("auth",$user->id);
    //Auth::attempt($user->id);
  }
  return Response::redirect('/');
});

/*
 * 404 not found
 */
Route::not_found(function() {
	return Response::error(404);
});