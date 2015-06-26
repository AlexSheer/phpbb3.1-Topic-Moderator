<?php
/**
*
* @package phpBB Extension - Topic Moderator
* @copyright (c) 2015 Sheer
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/
namespace sheer\topicmod\migrations;

class topicmod_1_0_0 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return;
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\dev');
	}

	public function update_schema()
	{
		return array(
		);
	}

	public function revert_schema()
	{
		return array(
		);
	}

	public function update_data()
	{
		return array(
			// Current version
			array('config.add', array('topicmod_version', '1.0.0')),
			// Add permissions
			array('permission.add', array('f_topicmod', false)),
			// Add permissions sets
			array('permission.permission_set', array('ROLE_FORUM_FULL', 'f_topicmod', 'role', true)),
			array('permission.permission_set', array('REGISTERED', 'f_topicmod', 'group', false)),
		);
	}
}
