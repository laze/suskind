<?php
/**
 * License
 */

/**
 * This class handles the general exceptions in place of PHP's own Excpetion class.
 *
 * @author Balazs Ercsey <laze@laze.hu>
 */
class Suskind_Exception extends Exception {

	/**
	 * The exception message.
	 *
	 * @var string
	 */
	protected $message;

	/**
	 * Internal Exception name.
	 *
	 * @var string
	 */
	private $string;

	/**
	 * The Exception code.
	 *
	 * @var integer
	 */
	protected $code;

	/**
	 * The filename where the exception was thrown.
	 *
	 * @var stirng
	 */
	protected $file;

	/**
	 * The line where the exception was thrown.
	 *
	 * @var integer
	 */
	protected $line;

	/**
	 * The stack trace.
	 * 
	 * @var array
	 */
	private $trace;


}

?>
