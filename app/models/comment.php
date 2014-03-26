<?php

class Comment extends Base {

	public static $table = 'comments';

	public static function search($params = array()) {
		//$query = static::where('status', '=', 'active');
    $query = Query::table(static::table());

		foreach($params as $key => $value) {
			$query->where($key, '=', $value);
		}

		return $query->get();
	}

	public static function paginate($page = 1, $perpage = 10) {
		$query = Query::table(static::table());

		$count = $query->count();

		$results = $query->take($perpage)->skip(($page - 1) * $perpage)->sort('id', 'desc')->get();

		return new Paginator($results, $count, $page, $perpage, Uri::to('users'));
	}

}