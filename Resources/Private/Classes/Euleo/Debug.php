<?php
class Debug
{
	public static function _($what)
	{
		echo '<pre>';
		echo htmlspecialchars(print_r($what, true));
		echo '</pre>';
	}
}