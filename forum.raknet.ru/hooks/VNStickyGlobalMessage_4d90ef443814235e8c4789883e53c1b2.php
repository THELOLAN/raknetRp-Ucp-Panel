<?php
// VAHID NAMENI
// 16-02-2012
class VNStickyGlobalMessage
{
	public function __construct()
	{
		$this->registry = ipsRegistry::instance();
		$this->settings =& $this->registry->fetchSettings();
		$this->memberData =& $this->registry->member()->fetchMemberData();
	}

	public function getOutput()
	{

	    if($this->settings['vn_sticky_message_system_on'] and
        in_array($this->memberData['member_group_id'], explode(",", $this->settings['vn_sticky_message_system_groups'])))
		{
		$data['message']  = IPSText::getTextClass('bbcode')->preDisplayParse( IPSText::getTextClass('bbcode')->preDbParse( $this->settings['vn_sticky_message_system_message'] ) );
        return $this->registry->getClass('output')->getTemplate('boards')->VNStickyGlobalMessage( $data );
        }
    }

}



?>