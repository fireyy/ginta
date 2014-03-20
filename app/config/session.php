<?php

return array(
	/*
	 * Session driver
	 *
	 * Available options are: cookie, runtime
	 */
	'driver' => 'runtime',

	/*
	 * Session cookie name
	 */
	'cookie' => 'ginta',

	/*
	 * Session lifespan in seconds
	 */
	'lifetime' => 14400,

	/*
	 * Session cookie expires at the end of the browser session
	 */
	'expire_on_close' => false,

	/*
	 * Session cookie path
	 */
	'path' => '/',

	/*
	 * Session cookie domain
	 */
	'domain' => '',

	/*
	 * Session cookie secure (only available via https)
	 */
	'secure' => false
);