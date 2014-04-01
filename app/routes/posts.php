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

Route::post('edit/(:num)', function($id) {
  $input = Input::get(array('title','description','status','slug'));
  $slug = $input["slug"];
	$validator = new Validator($input);

	$validator->check('title')
		->is_max(3, "请填写标题");

	if($errors = $validator->errors()) {
		Input::flash();

		Notify::error($errors);

		return Response::redirect('edit/' . $slug);
	}
  
	Post::update($id, $input);

	Notify::success("修改成功");

	return Response::redirect('edit/' . $slug);
});