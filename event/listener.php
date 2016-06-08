<?php
/**
*
* @package phpBB Extension - Topic Moderator
* @copyright (c) 2015 Sheer
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/
namespace sheer\topicmod\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
/**
* Assign functions defined in this class to event listeners in the core
*
* @return array
* @static
* @access public
*/
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'								=> 'load_language_on_setup',
			'core.viewtopic_modify_post_action_conditions'	=> 'action_conditions',
			'core.posting_modify_cannot_edit_conditions'	=> 'edit_conditions',
			'core.permissions'								=> 'add_permission',
		);
	}

	/** @var \phpbb	emplate	emplate */
	protected $template;

	//** @var string phpbb_root_path */
	protected $phpbb_root_path;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\db\driver\driver_interface $db */
	protected $db;

	/** @var \phpbb\auth\auth $auth */
	protected $auth;

	/**
	* Constructor
	*/
	public function __construct(
		$phpbb_root_path,
		\phpbb\template\template $template,
		\phpbb\user $user,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\auth\auth $auth
		)
	{
		$this->phpbb_root_path = $phpbb_root_path;
		$this->template = $template;
		$this->user = $user;
		$this->db = $db;
		$this->auth = $auth;
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'sheer/topicmod',
			'lang_set' => 'topicmod_lng',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function action_conditions($event)
	{
		$topic_data = $event['topic_data'];
		$topic_id = $topic_data['topic_id'];
		$forum_id = $topic_data['forum_id'];
		$topic_status = $topic_data['topic_status'];

		if (($this->user->data['user_id'] == $topic_data['topic_poster']) && $this->auth->acl_gets('f_topicmod', $topic_data['forum_id']) || $this->auth->acl_gets('m_edit', $topic_data['forum_id']))
		{
			$this->template->assign_vars(array(
				'S_TOPIC_CLOSED'	=> ($topic_data['topic_status'] == 1) ? true : false,
				'S_CAN_CLOSE'		=> true,
				'U_CLOSE_TOPIC'		=> append_sid("{$this->phpbb_root_path}topicmod", "fid=$forum_id&amp;tid=$topic_id&amp;topic_status=$topic_status"),
			));
			$event['force_edit_allowed'] = true;
		}
	}

	public function edit_conditions($event)
	{
		$post_data = $event['post_data'];
		if ($this->user->data['user_id'] == $post_data['topic_poster'])
		{
			$event['s_cannot_edit'] = $event['s_cannot_edit_time'] = $event['s_cannot_edit_locked'] = false;
		}
	}

	public function add_permission($event)
	{
		$permissions = $event['permissions'];
		$permissions['f_topicmod'] = array('lang' => 'ACL_F_TOPICMOD', 'cat' => 'misc');
		$event['permissions'] = $permissions;
	}
}
