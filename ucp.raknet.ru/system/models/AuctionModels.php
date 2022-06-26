<?php
class Auction
{
	static public function auto()
	{
		global $ipbMemberLoginApi, $db, $url;
		require('config/vehicle.php');
		$query = $db->rawQuery("SELECT * FROM `veh_auction` WHERE `ID` > ?", array(0));
		$table = "";
		$i = 0;
		foreach($query as $key => $value)
		{
			$load = IPSMember::load($value['Owned']);
			if($value['auc_member_id'] == 0)
			{
				$member = "Ставок небыло";
			}
			else
			{
				$members = IPSMember::load($value['auc_member_id']);
				$member = $members['name'] . " - " . number_format($value['auc_price']) . "<font color=\"green\">$</font> ";
			}
			$date = mktime( date("H" , $value['vDate'] ), date("i", $value['vDate']), 0, date("m" , $value['vDate'])  , date("d" , $value['vDate']), date("Y" , $value['vDate'] )-20 );
			$i++;
			$table .= "<tr>
							<td>
								{$i}
							</td>
							<td>
								{$vehiclename[$value['Model']]}
							</td>
							<td>
								{$vehicletype[$value['Model']]}
							</td>
							<td>
								" . floor($value['Probeg']) . " км.
							</td>
							<td>
								" . date("Y", $date) . " г.
							</td>
							<td>
								{$load['name']}
							</td>
							<td>
								" . number_format($value['auc_start']) . "<font color=\"green\">$</font> 
							</td>
							<td>
								{$member}
							</td>
							<td>
								<input name=\"radio\" type=\"radio\" value=\"{$value['ID']}\" id=\"radio\">
							</td>
						</tr>";
		}
		return $table;
	}
}