<?php

Route::get('edit/(:any)', function($slug) {
  if(!$post = Post::slug($slug)){
    return Response::error(404);
  }
  $uid = Auth::uid();
  if($uid != $post->author){
    return Response::redirect($slug);
  }
  $vars["post"] = $post;
  return Template::create("edit",$vars);
});