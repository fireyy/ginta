<?php

/*
 * Home page
 */
Route::get('/', function() {
  $vars["guest"] = Auth::guest();
  if(!$vars["guest"]){ 
    $vars["user"] = Auth::user();
  }
  return Template::create("home",$vars);
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
    $ct = User::count();
    $uid = User::create(array(
      "role" => ($ct == 0) ? "admin" : "user",
      "status" => "inactive",
      "created" => Date::mysql("now"),
      "duoshuo_uid" => $result["user_id"],
      "duoshuo_token" => $result["access_token"]
    ));
    Auth::attempt($uid);
  }else{
    Auth::attempt($user->id);
  }
  return Response::redirect('/');
});

/*
 * logout
 */
Route::get('logout', function() {
  Auth::logout();
  return Response::redirect('/');
});

/*
 * image upload
 */
Route::post('upload', function() {
  //
  return Response::redirect('/');
});

/*
 * 404 not found
 */
Route::not_found(function() {
  return Response::error(404);
});