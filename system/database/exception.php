<?php namespace System\Database;


use Exception as NativeException;

class Exception extends NativeException {

	public function __construct($sql, $exception) {
		parent::__construct($exception->getMessage() . '<br><code>' . $sql . '</code>', 0, $exception);
	}

}