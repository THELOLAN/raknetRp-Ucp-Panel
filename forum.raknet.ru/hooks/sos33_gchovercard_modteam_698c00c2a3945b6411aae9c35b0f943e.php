class sos33_gchovercard_modteam extends skin_stats(~id~)
{
    function group_strip($group='', $members=array(), $pagination='')
	{
		foreach($members as $info)
		{
			$info['members_display_name'] = IPSMember::makeNameFormatted( $info['members_display_name'], $info['member_group_id'] );
		}

		return parent::group_strip($group, $members, $pagination);
	}
}