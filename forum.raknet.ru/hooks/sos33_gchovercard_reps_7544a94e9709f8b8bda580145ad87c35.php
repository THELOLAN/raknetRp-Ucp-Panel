class sos33_gchovercard_reps extends skin_global_other(~id~)
{
	public function reputationPopup( $reps )
	{
		if ( is_array( $reps ) AND count( $reps ) )
		{
			foreach( $reps as $_rid => $_rdata )
			{
				$reps[ $_rid ]['member']['members_display_name'] = IPSMember::makeNameFormatted( $_rdata['member']['members_display_name'], $_rdata['member']['member_group_id'] );
			}
		}

		return parent::reputationPopup( $reps );
	}
}