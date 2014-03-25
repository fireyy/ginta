<?php

class Auth {

	private static $session = 'auth';

	public static function guest() {
		return Session::get(static::$session) === null;
	}

	public static function user() {
		if($id = Session::get(static::$session)) {
			return User::find($id);
		}else{
		  return "0";
		}
	}
  
	public static function uid() {
		if($id = Session::get(static::$session)) {
			return $id;
		}else{
		  return 0;
		}
	}

	public static function attempt($uid) {
		// store user ID in the session
		Session::put(static::$session, $uid);

		return true;
	}

	public static function logout() {
		Session::erase(static::$session);
	}

}