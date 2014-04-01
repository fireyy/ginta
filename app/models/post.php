<?php

class Post extends Base {

	public static $table = 'posts';

	public static function id($id) {
		return static::get('id', $id);
	}

	public static function slug($slug) {
		return static::get('slug', $slug);
	}

	private static function get($row, $val) {
		return static::left_join(Base::table('users'), Base::table('users.id'), '=', Base::table('posts.author'))
			->where(Base::table('posts.'.$row), '=', $val)
			->fetch(array(Base::table('posts.*'),
				Base::table('users.id as author_id'),
				Base::table('users.nickname as author_name')));
	}

	public static function listing($page = 1, $per_page = 10) {
		// get total
    $uid = Auth::uid();
    $query = Query::table(static::table());
		$query = static::where('author', '=', $uid)->where('status', '=', 'active');

		$total = $query->count();

		// get posts
		$posts = $query->sort('id', 'asc')
			->take($per_page)
			->skip(--$page * $per_page)
			->get();

		return array($total, $posts);
	}

	public static function search($term, $page = 1, $per_page = 10) {
		$query = static::left_join(Base::table('users'), Base::table('users.id'), '=', Base::table('posts.author'))
			->where(Base::table('posts.status'), '=', 'published')
			->where(Base::table('posts.title'), 'like', '%' . $term . '%');

		$total = $query->count();

		$posts = $query->take($per_page)
			->skip(--$page * $per_page)
			->get(array(Base::table('posts.*'),
				Base::table('users.id as author_id'),
				Base::table('users.bio as author_bio'),
				Base::table('users.real_name as author_name')));

		return array($total, $posts);
	}

}