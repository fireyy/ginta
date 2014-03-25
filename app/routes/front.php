<?php

/*
 * Home page
 */
Route::get('/', function() {
  //var_dump(convertIntToShortCode(1));exit();
  $vars["guest"] = Auth::guest();
  if(!$vars["guest"]){ 
    $vars["user"] = Auth::user();
    list($vars["total"], $vars["posts"]) = Post::listing();
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
  $result = Iupload::process_image($_FILES["file"]);
  $json = array();
  if($result){
    $author = Auth::user();
    if($author) $author = $author->id;
    $post = Post::create(array(
      "status" => "active",
      "author" => $author,
      "images" => $result["filename"],
      "title" => $result["name"]
    ));
    $id = $post->id;
    $slug = convertIntToShortCode($id);
    Post::update($id, array(
      "slug" => $slug
    ));
    $json = array(
      "id" => $post->id,
      "html" => $post->id,
      "edit" => $post->id,
      "thumb" => $result["thumb_name"],
      "title" => $result["name"],
      "percent" => $post->id,
      "menu" => $post->id
    );
  }else{
    echo "fuck";
  }
  return Response::create(Json::encode($json), 200, array('content-type' => 'application/json'));
});

/*
 * 404 not found
 */
Route::not_found(function() {
  return Response::error(404);
});