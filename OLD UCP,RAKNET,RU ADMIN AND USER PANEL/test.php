<?php
error_reporting ( -1 );
ini_set( 'display_errors', -1 );
$number = isset ( $_POST['skin'] ) ? $_POST['skin'] : "";
$number = (int)$number;

$p_preview = "";
$p_name = "";
$p_type = "";
$p_skin = "";
$p_sex = "";
switch ( $number ) {

	case 0: $p_skin = "1"; $p_preview = "0"; $p_name = "0"; $p_type = ""; break;
	case 8: $p_skin = "8"; $p_preview = "210"; $p_name = "200"; $p_type = "Janitor"; $p_sex = "Мужской"; break;
	case 17: $p_skin = "17"; $p_preview = "219"; $p_name = "500"; $p_type = "Buisnessman"; $p_sex = "Мужской"; break;
	case 19: $p_skin = "19"; $p_preview = "221"; $p_name = "500"; $p_type = "DJ"; $p_sex = "Мужской";  break;
	case 20: $p_skin = "20"; $p_preview = "222"; $p_name = "400"; $p_type = "Rich Guy (Madd Dogg's Manager)"; $p_sex = "Мужской";  break;
	case 32: $p_skin = "32"; $p_preview = "234"; $p_name = "500"; $p_type = "Farm-Town inhabitant"; $p_sex = "Мужской";  break;
	case 34: $p_skin = "34"; $p_preview = "236"; $p_name = "250"; $p_type = "Farm-Town inhabitant"; $p_sex = "Мужской";  break;
	case 50: $p_skin = "50"; $p_preview = "252"; $p_name = "250"; $p_type = "Mechanic"; $p_sex = "Мужской";  break;
	case 68: $p_skin = "68"; $p_preview = "270"; $p_name = "300"; $p_type = "Priest/Preacher"; $p_sex = "Мужской";  break;
	case 80: $p_skin = "80"; $p_preview = "282"; $p_name = "400"; $p_type = "Boxer"; $p_sex = "Мужской";  break;
	case 81: $p_skin = "81"; $p_preview = "283"; $p_name = "400"; $p_type = "Boxer"; $p_sex = "Мужской";  break;
	case 86: $p_skin = "86"; $p_preview = "288"; $p_name = "500"; $p_type = "Ryder"; $p_sex = "Мужской";  break;
	case 96: $p_skin = "96"; $p_preview = "298"; $p_name = "300"; $p_type = "Jogger"; $p_sex = "Мужской";  break;
	case 133: $p_skin = "133"; $p_preview = "335"; $p_name = "500"; $p_type = "Farm Inhabitant"; $p_sex = "Мужской";  break;
	case 141: $p_skin = "141"; $p_preview = "343"; $p_name = "500"; $p_type = "Buisnesswoman"; $p_sex = "Женский";  break;
	case 153: $p_skin = "153"; $p_preview = "355"; $p_name = "50"; $p_type = "Construction Worker"; $p_sex = "Мужской";  break;
	case 155: $p_skin = "155"; $p_preview = "357"; $p_name = "600"; $p_type = "Well Stacked Pizza Worker"; $p_sex = "Мужской";  break;
	case 179: $p_skin = "179"; $p_preview = "381"; $p_name = "700"; $p_type = "Ammunation Salesman"; $p_sex = "Мужской";  break;
	case 187: $p_skin = "187"; $p_preview = "389"; $p_name = "700"; $p_type = "Buisnessman"; $p_sex = "Мужской";  break;
	case 188: $p_skin = "188"; $p_preview = "390"; $p_name = "300"; $p_type = "Normal Ped"; $p_sex = "Мужской";  break;
	case 189: $p_skin = "189"; $p_preview = "391"; $p_name = "800"; $p_type = "Valet"; $p_sex = "Мужской";  break;
	case 202: $p_skin = "202"; $p_preview = "404"; $p_name = "750"; $p_type = "Farmer"; $p_sex = "Мужской";  break;
	case 209: $p_skin = "209"; $p_preview = "411"; $p_name = "500"; $p_type = "Oriental Noodle stand vendor"; $p_sex = "Мужской";  break;
	case 223: $p_skin = "223"; $p_preview = "425"; $p_name = "750"; $p_type = "1"; $p_sex = "";  break;
	case 236: $p_skin = "236"; $p_preview = "438"; $p_name = "500"; $p_type = "1"; $p_sex = "";  break;
	case 241: $p_skin = "241"; $p_preview = "443"; $p_name = "500"; $p_type = "1"; $p_sex = "";  break;
	case 242: $p_skin = "242"; $p_preview = "444"; $p_name = "500"; $p_type = "1"; $p_sex = "";  break;
	case 253: $p_skin = "253"; $p_preview = "455"; $p_name = "300"; $p_type = "1"; $p_sex = "";  break;
	case 290: $p_skin = "290"; $p_preview = "492"; $p_name = "600"; $p_type = "1"; $p_sex = "";  break;
	case 293: $p_skin = "293"; $p_preview = "495"; $p_name = "700"; $p_type = "1"; $p_sex = "";  break;
	case 297: $p_skin = "297"; $p_preview = "499"; $p_name = "700"; $p_type = "1"; $p_sex = "";  break;
	case 298: $p_skin = "298"; $p_preview = "500"; $p_name = "200"; $p_type = "1"; $p_sex = "";  break;
	case 299: $p_skin = "299"; $p_preview = "501"; $p_name = "500"; $p_type = "1"; $p_sex = "";  break;
	default: $p_skin = "1"; $p_preview = "1"; $p_name = "1"; $p_type = "1";

}

echo "<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\">
		<img src=\"http://ucp.raknet.ru/templates/style/img/skin/{$p_skin}.png\" title=\"{$p_name}\">
	</div>
	<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\">
		Имя скина: {$p_type}<br />
		Пол: {$p_sex}<br />
		Цена: {$p_name} руб.
	</div>
	<br />
	<br />
	<input type=\"hidden\" name=\"skinnumber\" value=\"{$p_preview}\">
	<input type=\"hidden\" name=\"skincost\" value=\"{$p_name}\">";