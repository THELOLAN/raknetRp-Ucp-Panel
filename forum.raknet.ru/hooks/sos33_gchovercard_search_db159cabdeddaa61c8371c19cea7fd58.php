class sos33_gchovercard_search extends skin_search(~id~)
{
    function asForumTopics($data)
	{
		$topicc = IPSMember::load( $data['starter_id'] );
 		$lastp  = IPSMember::load( $data['last_poster_id'] );

		$starter 	= IPSMember::makeNameFormatted( $data['starter_name'], $topicc['member_group_id'] );
		$lastposter = IPSMember::makeNameFormatted( $data['last_poster_name'], $lastp['member_group_id'] );

		$data['starter'] 	 	= IPSMember::makeProfileLink($starter   , $data['starter_id']    , $topicc['members_seo_name']);
		$data['last_poster_id'] = IPSMember::makeProfileLink($lastposter, $data['last_poster_id'], $lastp['members_seo_name']);

		return parent::asForumTopics($data);
	}
}