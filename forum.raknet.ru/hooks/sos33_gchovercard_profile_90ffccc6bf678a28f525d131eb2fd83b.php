class sos33_gchovercard_profile extends skin_profile(~id~)
{
	public function tabFriends($friends=array(), $member=array(), $pagination='')
	{
		$member['members_display_name'] = IPSMember::makeNameFormatted( $member['members_display_name'], $member['member_group_id'] );
		
		if ( is_array( $friends ) AND count( $friends ) )
		{
			foreach( $friends as $fid => $fdata )
			{
				$friends[ $fid ]['members_display_name'] = IPSMember::makeNameFormatted( $fdata['members_display_name'], $fdata['member_group_id'] );
				$friends[ $fid ]['members_display_name_short'] = IPSMember::makeNameFormatted( $fdata['members_display_name_short'], $fdata['member_group_id'] );
			}
		}

		return parent::tabFriends( $friends, $member, $pagination );
	}
}