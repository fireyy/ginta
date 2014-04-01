<?php

Route::get('settings', function() {
  $vars["user"] = Auth::user();
  return Template::create("settings",$vars);
});

Route::post('settings', function() {
  $input = Input::get(array('nickname','email','bio'));
  $id = Auth::uid();
	$validator = new Validator($input);

	$validator->check('nickname')
		->is_max(3, "请填写昵称");

	if($errors = $validator->errors()) {
		Input::flash();

		Notify::error($errors);

		return Response::redirect('settings');
	}
  
	User::update($id, $input);

	Notify::success("修改成功");

	return Response::redirect('settings');
});