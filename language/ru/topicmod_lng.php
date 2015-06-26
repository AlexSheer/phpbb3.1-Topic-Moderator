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
	'CLOSE_TOPIC'			=> 'Закрыть тему',
	'OPEN_TOPIC'			=> 'Открыть тему',
	'OPEN_SUCCESS'			=> 'Тема была успешно открыта',
	'CLOSE_SUCCESS'			=> 'Тема была успешно закрыта',
	'CANNOT_MANAGE_TOPIC'	=> 'У вас нет прав доступа в эту часть форума',
));
