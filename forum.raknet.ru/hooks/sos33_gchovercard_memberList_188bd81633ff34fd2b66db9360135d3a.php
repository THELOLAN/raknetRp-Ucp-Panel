class sos33_gchovercard_memberList extends skin_mlist(~id~)
{
	public function member_list_show( $members, $pages="", $dropdowns=array(), $defaults=array(), $custom_fields=null, $url='' )
	{
		$_replaceNames	= array();

		if ( is_array( $members ) and count( $members ) )
		{
			foreach( $members as $id => $member )
			{
				$members[ $id ]['members_display_name'] = IPSMember::makeNameFormatted( $member['members_display_name'], $member['member_group_id'] );
				
				$_replaceNames[ sprintf($this->lang->words['users_photo'], $member['members_display_name']) ] = sprintf($this->lang->words['users_photo'], $members[ $id ]['members_display_name']);
				$_replaceNames[ sprintf( $this->lang->words['member_has_x_rep'], $member['members_display_name'], $member['pp_reputation_points']) ] = sprintf( $this->lang->words['member_has_x_rep'], $members[ $id ]['members_display_name'], $member['pp_reputation_points']);
			}
		}

		$return = parent::member_list_show( $members, $pages, $dropdowns, $defaults, $custom_fields, $url );
		
		if ( is_array( $_replaceNames ) AND count( $_replaceNames ) )
		{
			foreach( $_replaceNames as $replace => $search )
			{
				$return = str_replace( $search, $replace, $return );
			}
		}
		
		return $return;
	}
}