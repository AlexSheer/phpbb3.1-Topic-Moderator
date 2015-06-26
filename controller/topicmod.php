<?php
/**
*
* @package phpBB Extension - Topic Moderator
* @copyright (c) 2013 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace sheer\topicmod\controller;

use Symfony\Component\HttpFoundation\Response;

class topicmod
{
	/** @var \phpbb\db\driver\driver_interface $db */
	protected $db;

	/** @var \phpbb\auth\auth $auth */
	protected $auth;

	/** @var \phpbb\user */
	protected $user;

	//** @var string phpbb_root_path */
	protected $phpbb_root_path;

	//** @var string php_ext */
	protected $php_ext;

	public function __construct(
		\phpbb\request\request_interface $request,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\auth\auth $auth,
		\phpbb\user $user,
		$phpbb_root_path,
		$php_ext
	)
	{
		$this->request = $request;
		$this->db = $db;
		$this->auth = $auth;
		$this->user = $user;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
	}

	public function main()
	{
		$topic_id = $this->request->variable('tid', 0);
		$forum_id = $this->request->variable('fid', 0);
		$topic_status = $this->request->variable('topic_status', 0);
		$action = ($topic_status) ? 0 : 1;
		$url = append_sid("{$this->phpbb_root_path}viewtopic." . $this->php_ext . "", "f=$forum_id&amp;t=$topic_id");

		if ($this->auth->acl_gets('f_topicmod', $forum_id) || $this->auth->acl_gets('m_edit', $forum_id))
		{
			$sql = 'UPDATE '. TOPICS_TABLE . ' SET topic_status = ' . $action . '
				WHERE topic_id = ' . $topic_id . '';
			$this->db->sql_query($sql);
			$message = ($topic_status) ? $this->user->lang['OPEN_SUCCESS'] : $this->user->lang['CLOSE_SUCCESS'];
		}
		else
		{
			$message = $this->user->lang['CANNOT_MANAGE_TOPIC'];
		}
		$message .= '<br /><br />' . sprintf($this->user->lang['RETURN_PAGE'], '<a href="' . $url . '">', '</a> ');

		meta_refresh(3, $url);
		trigger_error($message);
		return new Response('', 200);
	}
}
