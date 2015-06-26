<?php
/**
*
* @package phpBB Extension - My Test
* @copyright (c) 2013 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'CLOSE_TOPIC'			=> 'Close topic',
	'OPEN_TOPIC'			=> 'Open topic',
	'OPEN_SUCCESS'			=> 'Topic was successfully opened',
	'CLOSE_SUCCESS'			=> 'Topic was successfully closed',
	'CANNOT_MANAGE_TOPIC'	=> 'You do not have access to this part of the board',
));
