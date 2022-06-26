<?php

class sos33_gchovercard_fmoderators extends admin_forums_forums_moderator
{
	public function rebuildModeratorCache()
	{
		$return = parent::rebuildModeratorCache();
		
		$mods = $this->cache->getCache('moderators');
		
		if ( is_array( $mods ) AND count( $mods ) )
		{
			$membersToLoad	= array();
			$groupsLoaded	= array();
			
			foreach( $mods as $mdata )
			{
				if ( empty($mdata['is_group']) )
				{
					$membersToLoad[] = $mdata['member_id'];
				}
			}

			if ( is_array( $membersToLoad ) AND count( $membersToLoad ) )
			{
				$this->DB->build( array( 'select' => 'member_id, member_group_id', 'from' => 'members', 'where' => 'member_id IN(' . implode( ',', $membersToLoad ) . ')' ) );
				$gr = $this->DB->execute();
				
				while( $r = $this->DB->fetch($gr) )
				{
					$groupsLoaded[ $r['member_id'] ] = $r['member_group_id'];
				}
			}
			
			foreach( $mods as $id => $data )
			{
				if ( empty($data['is_group']) )
				{
					if ( isset($groupsLoaded[ $data['member_id'] ]) )
					{
						$mods[ $id ]['members_display_name'] = IPSMember::makeNameFormatted( $data['members_display_name'], $groupsLoaded[ $data['member_id'] ] );
					}
				}
				else
				{
					$mods[ $id ]['group_name'] = IPSMember::makeNameFormatted( $data['group_name'], $data['group_id'] );
				}
			}
		}
		
		$this->cache->setCache( 'moderators', $mods, array( 'array' => 1, 'donow' => 0 ) );
		
		return $return;
	}
}