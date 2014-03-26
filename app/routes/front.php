<?php

/*
 * Home page
 */
Route::get('/', function() {
  $vars = array();
  if(!Auth::guest()){ 
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
    $duoshuo = new Duoshuo();
    $duoshuo_client = $duoshuo->getClient();
    $url = "http://api.duoshuo.com/threads/import.json";
    $threads = array();
    $threads[] = array(
      "thread_key" => $id,
      "title" => $result["name"],
      "url" => uri_to($slug)
    );
    $body = array(
      "threads" => $threads,
      "secret" => Config::app('duoshuo_secret', ''),
      "short_name" => Config::app('duoshuo_short_name', '')
    );
    $body = http_build_query($body, '', '&');
    $result = $duoshuo_client->http($url,$body,"POST");
    $result = Json::decode($result);
    if($result->code == 0){
      /*$dt = get_object_vars($result->response);
      Post::update($id, array(
        "ds_thread_id" => $dt[$id]
      ));*/
    }
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
 * view
 */
Route::get('(:any)', function($slug) {
  if(!$post = Post::slug($slug)){
    return Response::error(404);
  }
  $comments = Comment::search(array(
    "post" => $post->id
  ));
  $url = "http://ginta.duoshuo.com/api/threads/listPosts.json?thread_key=".$post->id;
  $result = Http::request($url,"","GET");
  $result = Json::decode($result);
  $parentPosts = get_object_vars($result->parentPosts);
  $note = array();
  foreach($comments as $comment){
    $note[] = array(
      "x1" => $comment->x,
      "edit" => "a id='view-".$comment->id."' title='Reply' href='/reply/".$comment->id."'",
      "y1" => $comment->y,
      "height" => $comment->height,
      "width" => $comment->width,
      "note" => "<div class='outer'><div class='inner'><p>".$parentPosts[$comment->duoshuo_id]->message."\r\n <span class='meta'>&mdash; ".$parentPosts[$comment->duoshuo_id]->author->name."</span></p></div></div><span class='tip'>&uarr;</span>"
    );
  }
  $vars["post"] = $post;
  $vars["note"] = $note;
  return Template::create("view",$vars);
});

/*
 * 404 not found
 */
Route::not_found(function() {
  return Response::error(404);
});