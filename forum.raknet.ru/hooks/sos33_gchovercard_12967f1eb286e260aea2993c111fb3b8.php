class sos33_gchovercard extends skin_global(~id~)
{
	function userHoverCard($member=array())
	{
		$groupCache = ipsRegistry::cache()->getCache('group_cache');
		
		/* Already got the formatting? => taken from "(TB) Group Format 4.1.1" */
		if ( ( $groupCache[ $member['member_group_id'] ]['prefix'] && stripos( $member['members_display_name'], $groupCache[ $member['member_group_id'] ]['prefix'] ) !== FALSE ) || ( $groupCache[ $member['member_group_id'] ]['suffix'] && stripos( $member['members_display_name'], $groupCache[ $member['member_group_id'] ]['suffix'] ) !== FALSE ) )
		{
			return $member['members_display_name'];
		}

		$member['members_display_name'] = IPSMember::makeNameFormatted( $member['members_display_name'], $member['member_group_id'] );

		return parent::userHoverCard($member);
	}
}