<?php namespace System\Error;


use Exception;
use System\Request;

class Report {

	/**
	 * Get a object to return the appropriate message format
	 *
	 * @param object
	 * @param bool
	 * @return object
	 */
	public static function handler(Exception $exception, $detailed) {
		// clear output buffer
		ob_get_level() and ob_end_clean();

		return new Html($exception, $detailed);
	}

}