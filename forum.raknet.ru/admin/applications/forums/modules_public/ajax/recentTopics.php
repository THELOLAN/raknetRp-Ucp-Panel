<?php

/**
 * Product Title:		(SOS34) Recent Topics
 * Product Version:		3.3.0
 * Author:				Adriano Faria
 * Website:				SOS Invision
 * Website URL:			http://forum.sosinvision.com.br/
 * Email:				administracao@sosinvision.com.br
 */

if ( ! defined( 'IN_IPB' ) )
{
	print "<h1>Incorrect access</h1>You cannot access this file directly. If you have recently upgraded, make sure you upgraded all the relevant files.";
	exit();
}

class public_forums_ajax_recentTopics extends ipsAjaxCommand 
{
	public function doExecute( ipsRegistry $registry )
	{
		switch( $this->request['do'] )
		{
/* 			default:
				return $this->recentTopics();
			break; */
		}
	}
	
	public function recentTopics()
	{
		if ( $this->memberData['member_id'] AND !$this->memberData['recenttopics_onoff'] )
		{
			$this->returnJsonError( 'No permissions' );
		}
		
		if ( $this->settings['topicosrecentes_posts'] AND $this->memberData['posts'] < $this->settings['topicosrecentes_posts'] )
		{
			$this->returnJsonError( 'No permissions' );
		}

		$this->registry->class_localization->loadLanguageFile( array( 'public_forums', 'forums' ) );
		$this->registry->class_localization->loadLanguageFile( array( 'public_boards', 'forums' ) );

		$topicos = array();

		$forumIDs = $this->registry->class_forums->forum_by_id;

		foreach( $forumIDs as $id => $data )
		{
			if ( $this->registry->permissions->check( 'read', $data ) === TRUE )
			{
				$forums[] = $data['id'];
			}
		}

		if ( is_array( $forums ) AND count( $forums ) )
		{
			$ids = implode( ',', $forums );
		}
		
		if ( !$ids )
		{
			$this->returnJsonError( 'No readable forums' );
		}

		/* Exclude forums (by Admin) */
		$exclude = $this->settings['topicosrecentes_forums'];
		$excludeforums       = "";

		if ( $exclude )
		{
			$excludeforums = " and t.forum_id NOT in({$exclude})";
		}

		/* Exclude forums (by user) */
		$excludeforumsuser	 = "";
		
		if ( $this->memberData['member_id'] AND $this->memberData['recenttopics_forums'] )
		{
			$excludeforumsuser = " and t.forum_id NOT in({$this->memberData['recenttopics_forums']})";
		}

		/* Exclude CLOSED topics */
		if ( $this->settings['topicosrecentes_fechados'] )
		{
			$closed = 'and t.state != "closed"';
		}

		if ( $this->memberData['member_id'] )
		{
			$qtd = $this->memberData['topicosrecentes_showdqtd'] ? $this->settings['topicosrecentes_nr'] : $this->memberData['recenttopics_qtd'];
		}
		else
		{
			$qtd = $this->settings['topicosrecentes_nr'];
		}
		
		$this->request['last_post_time'] = intval( $this->request['last_post_time'] );
		if ( ! $this->request['last_post_time'] )
		{
			$this->returnJsonError( 'Invalid timestamp' );
		}
		
		/* Ignore topics we already have in our list */
		$excludeTopics 	= "";
		$ourTids		= array();
		if ( $this->request['our_tids'] )
		{
			foreach( json_decode( $_POST['our_tids'], true ) as $tid )
			{
				$ourTids[ intval( $tid[0] ) ] = array( 'tid' => intval( $tid[0] ), 'timestamp' => intval( $tid[1] ) );
			}
		}
		
		/* Load tagging stuff */
		if ( ! $this->registry->isClassLoaded('tags') )
		{
			require_once( IPS_ROOT_PATH . 'sources/classes/tags/bootstrap.php' );/*noLibHook*/
			$this->registry->setClass( 'tags', classes_tags_bootstrap::run( 'forums', 'topics' )  );
		}
		
		$this->DB->build( array( 
							'select'   => 't.*',
							'from'     => array( 'topics' => 't' ),
							'add_join' => array(
												array(
														'select' => 'm1.members_display_name as nome1, m1.members_seo_name, m1.member_group_id as grupo1',
														'from' 	 => array( 'members' => 'm1' ),
														'where'  => 'm1.member_id=t.starter_id',
														'type'   => 'left',
												),
												$this->registry->tags->getCacheJoin( array( 'meta_id_field' => 't.tid' ) ),
										),
							'where'	   => "t.last_post > {$this->request['last_post_time']} AND t.approved = 1 AND t.forum_id in({$ids})".$excludeforums.$excludeforumsuser.$closed.$excludeTopics,
							'order'    => 't.last_post desc',
							'limit'	   => array( 0, $qtd ),
		) );

		$this->DB->execute();
			
		while( $r = $this->DB->fetch() )
		{
			$topic_array[ $r['tid'] ] = $r;
			$topic_ids[ $r['tid'] ]   = $r['tid'];

			if( $r['last_poster_id'] )
			{
				$member_ids[ $r['last_poster_id'] ]	= $r['last_poster_id'];
			}
		}
		
		$_members	= IPSMember::load( $member_ids );
					
		$topic_array = $this->checkUserPosted( $topic_ids, 1, $topic_array );
		
		if ( !is_array( $topic_array ) AND !count( $topic_array ) )
		{
			$this->returnJsonError( 'Nothing new' );
		}
		
		$classToLoad = IPSLib::loadActionOverloader( IPSLib::getAppDir( 'forums', 'forums' ) . '/forums.php' , 'public_forums_forums_forums' );
		$forumsClass = new $classToLoad;
		$forumsClass->makeRegistryShortcuts( $this->registry );
		
		foreach ( $topic_array as $r )
		{
			/* Topic title colored? */
			$r['style'] = "";
			
			if( isset( $r['ttc_fontcolor'] ) OR isset( $r['ttc_backgroundcolor'] ) OR isset( $r['ttc_bold'] ) OR isset( $r['ttc_italic'] ) )
			{
				$r['style'] .= " style='";
				$r['style'] .= "-moz-border-radius:3px;-webkit-border-radius:3px;border-radius:3px;padding-left:5px;padding-right:5px;padding-top:2px;padding-bottom:2px;";
				$r['style'] .= ( $r['ttc_fontcolor'] ) ? "color: {$r['ttc_fontcolor']}; " : '';
				$r['style'] .= ( $r['ttc_backgroundcolor'] ) ? "background-color: {$r['ttc_backgroundcolor']}; " : '';
				$r['style'] .= ( $r['ttc_italic'] ) ? "font-style: italic; " : '';
				$r['style'] .= ( $r['ttc_bold'] ) ? "font-weight: bold; " : '';
				$r['style'] .= "'";
			}

			/* Add member */
			if( $r['last_poster_id'] )
			{
				$r	= array_merge( IPSMember::buildDisplayData( $_members[ $r['last_poster_id'] ] ), $r );
			}
			else
			{
				$r	= array_merge( IPSMember::buildProfilePhoto( array() ), $r );
			}
			
			$r = $forumsClass->renderEntry( $r );
			
			
			$r['forumBreadcrumb'] = $this->registry->getClass('class_forums')->forumsBreadcrumbNav( $r['forum_id'] );
			
			if ( isset( $ourTids[ $r['tid'] ] ) )
			{
				$toBeUpdated[ $r['tid'] ] = array( 	'topic_data' 	=> $r, 
													'forum_data' 	=> $this->registry->class_forums->forum_by_id[ $r['forum_id'] ]
											);
			}
			else
			{
				$topicos[ $r['tid'] ] = array( 	'topic_data' 	=> $r, 
												'forum_data' 	=> $this->registry->class_forums->forum_by_id[ $r['forum_id'] ]
											);
			}
			
			$allTopics[] = $r;
		}
		
		$html = $this->registry->getClass('output')->getTemplate( 'boards' )->hooksos_topicosrecentesAjax_tema1( $topicos );


		$html = preg_replace( "#<!--hook\.([^\>]+?)-->#", '', $html );
		$html = $this->registry->getClass( 'output' )->replaceMacros( $html );
		
		if ( is_array( $toBeUpdated ) AND count( $toBeUpdated ) )
		{
			foreach( $toBeUpdated as $tid => $t )
			{
				$updatedTopics[] = array( 
					'tid' => $tid,
					'html' => $this->registry->getClass( 'output' )->replaceMacros( $this->registry->output->getTemplate( 'boards' )->hooksos_topicosrecentes_parseTopic( $t ) )
				);
			}
		}

		$lastTopic = reset( $allTopics );

		$this->returnJsonArray( array( 'html' => $html, 'updated' => $updatedTopics, 'last_tid' => $lastTopic['tid'], 'last_tid_timestamp' => $lastTopic['last_post'] ) );
	}

    function checkUserPosted( $topic_ids=array(), $parse_dots=1, $topic_array=array() )
    {
       	if ( ( $this->memberData['member_id'] ) and ( count( $topic_ids ) ) and ( $parse_dots ) )
       	{
           		$this->DB->build(
               		array(
	               	    'select' => 'author_id, pid, topic_id',
	       	            'from'   => 'posts',
       	        	    'where'  => "author_id=".$this->memberData['member_id']." AND topic_id IN(".implode( ",", $topic_ids ).")",
               		)
           		);
            
			$this->DB->execute();

	        while ( $p = $this->DB->fetch() )
			{
        		if ( is_array( $topic_array[ $p['topic_id'] ] ) )
                {
	            	$topic_array[ $p['topic_id'] ]['author_id'] = $p['author_id'];
        	    }
            }
        }

        return $topic_array;
    }
}