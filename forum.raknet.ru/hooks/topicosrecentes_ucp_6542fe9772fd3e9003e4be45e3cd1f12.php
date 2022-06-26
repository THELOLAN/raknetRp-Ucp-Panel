<?php

class topicosrecentes_ucp extends usercpForms_core
{
	public function _customEvent_dorecenttopics()
	{
		/*if ( $this->request['authKey'] != $this->member->form_hash )
 		{
 			$this->registry->output->showError( 'warn_bad_key' );
 		}*/

		if( !in_array( $this->memberData['member_group_id'] , explode(',', $this->settings['topicosrecentes_grupos'] ) ) )
		{
			$this->registry->output->showError( 'no_permission' );
		}

		if ( $this->settings['topicosrecentes_posts'] AND $this->memberData['posts'] < $this->settings['topicosrecentes_posts'] )
		{
			$this->registry->output->showError( 'no_permission' );
		}

		$show 	= $this->request['showtr'] 	  ? 1 : 0;
		$def	= $this->request['showdqtd']  ? 1 : 0;
		$qtd  	= intval( $this->request['qtd_topicos'] );
		$forums = "";
		
		if ( is_array( $_POST['exclude_forum'] ) and count( $_POST['exclude_forum'] ) )
		{
			$_POST['exclude_forum'] = IPSLib::cleanIntArray( $_POST['exclude_forum'] );
			$forums = implode( ",", $_POST['exclude_forum'] );
			$forums = IPSText::cleanPermString( $forums );
		}

		$this->DB->update( 'members', array( 'recenttopics_onoff' => $show, 'topicosrecentes_showdqtd' => $def, 'recenttopics_qtd' => $qtd, 'recenttopics_forums' => $forums ), 'member_id='.$this->memberData['member_id'] );
		
		return TRUE;
	}

	public function _customEvent_recenttopics()
	{
		if( in_array( $this->memberData['member_group_id'] , explode(',', $this->settings['topicosrecentes_grupos'] ) ) )
		{
			$lista		= "";
			$blocked	= array();
			$forum_html = $this->registry->getClass('class_forums')->buildForumJump(0,1,1);
			$numbers	= explode( ",", $this->memberData['recenttopics_forums'] );
			
			if ( is_array( $numbers ) and count( $numbers ) )
			{
				foreach( $numbers as $f )
				{
					$forum_html = preg_replace( "#option\s+value=[\"'](".preg_quote($f,'#').")[\"']#i", "option value='\\1' selected=\"selected\"", $forum_html );
				}
			}
					
			$lista .= '<select  class="input_select" multiple="multiple" size="10" id="exclude_forum" name="exclude_forum[]">';
			$lista .= $forum_html;
			$lista .= '</select>';
		
			if ( $this->memberData['recenttopics_forums'] )
			{
				$forums = explode( ",", $this->memberData['recenttopics_forums'] );
			}
			
			if ( is_array( $forums ) and count( $forums ) )
			{
				foreach( $forums as $fid )
				{
					$blocked[] = $this->registry->getClass( 'class_forums' )->forumsBreadcrumbNav( $fid );
				}
			}
									
			return $this->registry->output->getTemplate('ucp')->recent_topics( $lista, $blocked );
		}
		else
		{
			$this->registry->output->showError( 'no_permission' );
		}
	}

	/**
	 * Return links for this tab
	 * You may return an empty array or FALSE to not have
	 * any links show in the tab.
	 *
	 * The links must have 'area=xxxxx'. The rest of the URL
	 * is added automatically.
	 * 'area' can only be a-z A-Z 0-9 - _
	 *
	 * @author	Matt Mecham
	 * @return   array 		array of links
	 */
	public function getLinks()
	{
		$updatedLinks = parent::getLinks();
		
		if ( $this->settings['topicosrecentes_posts'] AND $this->memberData['posts'] < $this->settings['topicosrecentes_posts'] )
		{
			return $updatedLinks;
		}

		ipsRegistry::instance()->getClass('class_localization')->loadLanguageFile( array( 'public_usercp' ), 'core' );
		ipsRegistry::instance()->getClass('class_localization')->loadLanguageFile( array( 'public_boards' ), 'forums' );

		if( in_array( $this->memberData['member_group_id'] , explode(',', $this->settings['topicosrecentes_grupos'] ) ) )
		{
			$updatedLinks[] = array( 'url'    => 'area=recenttopics',
									 'title'  => $this->settings['topicosrecentes_title'], //ipsRegistry::instance()->getClass('class_localization')->words['topicos_recentes'],
									 'active' => $this->request['tab'] == 'core' && $this->request['area'] == 'recenttopics' ? 1 : 0,
									 'area'   => 'recenttopics'
			);
		}

		return $updatedLinks;
	}

	/**
	 * Run custom event
	 *
	 * If you pass a 'do' in the URL / post form that is not either:
	 * save / save_form or show / show_form then this function is loaded
	 * instead. You can return a HTML chunk to be used in the UserCP (the
	 * tabs and footer are auto loaded) or redirect to a link.
	 *
	 * If you are returning HTML, you can use $this->hide_form_and_save_button = 1;
	 * to remove the form and save button that is automatically placed there.
	 *
	 * @author	Matt Mecham
	 * @param	string				Current 'area' variable (area=xxxx from the URL)
	 * @return   mixed 				html or void
	 */
	public function saveForm( $currentArea )
	{
		switch( $currentArea )
		{
			case 'recenttopics':
					return $this->_customEvent_dorecenttopics();
			break;
		}
		
		return parent::saveForm( $currentArea );
	}

	/**
	 * UserCP Form Show
	 *
	 * @author	Matt Mecham
	 * @param	string	Current area as defined by 'get_links'
	 * @param	array   Array of member / core_sys_login information (if we're editing)
	 * @return   string  Processed HTML
	 */
	public function showForm( $current_area, $errors=array() )
	{
		//-----------------------------------------
		// Where to go, what to see?
		//-----------------------------------------
	
		switch( $current_area )
		{
			case 'recenttopics':
				return $this->_customEvent_recenttopics();
			break;
		}
		
		return parent::showForm( $current_area, $errors );
	}
}