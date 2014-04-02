<?php

/*
 * 添加评论
 */
Route::post('ajax/add/(:num)', function($id) {
  $json = array();
	$input = Input::get(array('data'));
  $uid = $input["data"]["author"];
  $user = User::search(array("id"=>$uid));
  $duoshuo = new Duoshuo();
  $duoshuo_client = $duoshuo->getClient();
  $url = "http://api.duoshuo.com/posts/create.json";
  $short_name = Config::app('duoshuo_short_name', '');
  /*$remoteAuth = $duoshuo_client->remoteAuth(array(
    "short_name" => $short_name,
    "user_key" => $uid, 
    "name" => $user->nickname
  ));
  $body = array(
    "thread_key" => $id,
    "message" => $input["data"]["note"],
    "remote_auth" => $remoteAuth,
    "secret" => Config::app('duoshuo_secret', ''),
    "short_name" => $short_name
  );*/
  $body = array(
    "thread_key" => $id,
    "secret" => Config::app('duoshuo_secret', ''),
    "short_name" => $short_name,
    "message" => $input["data"]["note"],
    "author_name" => $user->nickname,
    "author_email" => $user->email
  );
  $result = $duoshuo_client->http($url,$body,"POST");
  
  //var_dump($result);
  $result = Json::decode($result);
  Comment::create(array(
    "post" => $id,
    "x" => $input["data"]["x1"],
    "y" => $input["data"]["y1"],
    "width" => $input["data"]["width"],
    "height" => $input["data"]["height"],
    "duoshuo_id" => $result->response->post_id
  ));
  return Response::create('<a href="https://fireyy.prevue.it/reply/35800" class="newnote" style="left:240px; top:344px; width: 100px; height: 100px;"></a><div id="finished"><p>Your annotation was saved. <a href="https://fireyy.prevue.it/reply/35800">View/Add a reply</a></p></div>', 202, array('content-type' => 'text/html'));
});

/*
 * 删除
 */
Route::post('ajax/delete/(:num)', function($id) {
  if(!$post = Post::find($id)){
    return Response::error(404);
  }
  if(Post::where("id", "=", $id)->delete()){
    $path = PATH.DS."public".DS."content".DS.$post->images;
    $ext = pathinfo($post->images, PATHINFO_EXTENSION);
    $thumb_p = str_replace(".".$ext, "_thumb.".$ext, $path);
    unlink($path);
    unlink($thumb_p);
    return Response::create(Json::encode(array("error"=>0)), 200, array('content-type' => 'application/json'));
  }else{
    return Response::create(Json::encode(array("error"=>1, "message"=> "删除失败")), 200, array('content-type' => 'application/json'));
  }
});