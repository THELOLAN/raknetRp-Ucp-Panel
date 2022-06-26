<?php
session_start();
/* $ts = time();
$s_time = ( empty ( $_SESSION["f5"] ) ) ? 0 : $_SESSION["f5"];
$proverka = 	isset ( $_SESSION['proverka'] ) ? $_SESSION['proverka'] : 0;
$_SESSION["f5"] = $ts;
if ( $ts - $s_time >= 1 && $proverka == 0 ) 
{ */
error_reporting ( -1 );
ini_set( 'display_errors', -1 );
define ( 'CRAZY_STR' , true );

require_once ( "../lib/init.php" );
require_once ( "../lib/classes/mysql.class.php" );
require_once ( "../lib/classes/func.global.php" );
$db->connect ( DBUSER , DBPASS , DBNAME , DBHOST );
$db->query ( "SET NAMES UTF8" );

if ( $admins == 1 ) $params = 1;
else $params = 0;

if(isset($_COOKIE["admins"])) $params = 1;	
else $params = 0;

function house( $param = 0 ) {

	$db = new db;
	$house = "";
	$name = "";
	$query = $db->query("SELECT `ID`, `Owned`, `member_id`, `name`, `Entrancex`, `Entrancey`, `Value`, `Klass`, `Comnat`, `Itajey`, `Gorod`, `Garaj` FROM `house` as A LEFT JOIN `members` as B ON ( B.member_id = A.Owned ) WHERE A.ID > '0'");
	while ( $val = $db->get_row( $query ) ) {

		switch ( $val["Klass"] ) {

			case 0: $klass = "Эконом"; break;
			case 1: $klass = "Эконом +"; break;
			case 2: $klass = "Средний"; break;
			case 3: $klass = "Люкс"; break;
			case 4: $klass = "Де люкс"; break;

		}
		switch ( $val["Garaj"] ) {

			case 0: $garage = "<font style='color: #ff2400;'>Отсутствует</font>"; break;
			case 1: $garage = "<font style='color: #3caa3c;'>Есть</font>"; break;

		}

		switch ( $val["Gorod"] ) {

			case 1:	$gorods = "Los Santos"; break;
			case 2:	$gorods = "San Fierro"; break;
			case 3:	$gorods = "Las Venturas"; break;

		}

		if ( $param == 0 ) {
		
			if ( $val["name"] == "" ) $name = "AddLocation('http://ucp.raknet.ru/newmap/icons/31.png',{$val['Entrancex']},{$val['Entrancey']},\"<h3><b>Дом продаётся.</b></h3><b>Цена:</b> {$val["Value"]}<font color='green'> $</font><br><b>Класс:</b> {$klass}<br><b>Комнат:</b> {$val['Comnat']}<br><b>Гараж:</b> {$garage}<br><b>Этажей:</b> {$val['Itajey']}<br><b>Номер дома:</b> {$val['ID']}<br><b>Город:</b> {$gorods}\");\n";
			else $name = "AddLocation('http://ucp.raknet.ru/newmap/icons/32.png',{$val['Entrancex']},{$val['Entrancey']},\"<h3><b>Дом занят.</b></h3><b>Класс:</b> {$klass}<br><b>Комнат:</b> {$val['Comnat']}<br><b>Гараж:</b> {$garage}<br><b>Этажей:</b> {$val['Itajey']}<br><b>Номер дома:</b> {$val['ID']}<br><b>Город:</b> {$gorods}\");\n";
		
		} else {
		
			if ( $val["name"] == "" ) $name = "AddLocation('http://ucp.raknet.ru/newmap/icons/31.png',{$val['Entrancex']},{$val['Entrancey']},\"<h3><b>Дом продаётся.</b></h3><b>Цена:</b> {$val["Value"]}<font color='green'> $</font><br><b>Класс:</b> {$klass}<br><b>Комнат:</b> {$val['Comnat']}<br><b>Гараж:</b> {$garage}<br><b>Этажей:</b> {$val['Itajey']}<br><b>Номер дома:</b> {$val['ID']}<br><b>Город:</b> {$gorods}\");\n";
			else $name = "AddLocation('http://ucp.raknet.ru/newmap/icons/32.png',{$val['Entrancex']},{$val['Entrancey']},\"<h3><b>Дом занят.</b></h3><b>Владелец:</b> {$val['name']}<br><b>Класс:</b> {$klass}<br><b>Комнат:</b> {$val['Comnat']}<br><b>Гараж:</b> {$garage}<br><b>Этажей:</b> {$val['Itajey']}<br><b>Номер дома:</b> {$val['ID']}<br><b>Город:</b> {$gorods}\");\n";
		
		}
		$house .= $name;

	}

	return $house;

}
$db->close();
/* } else {

	$_SESSION['proverka'] = 1;
	echo "<form action=\"http://{$_SERVER['HTTP_HOST']}/proverka.php\" method=\"POST\"><a href=\"#\" onclick=\"document.getElementById('security').src='http://{$_SERVER['HTTP_HOST']}/security.php?'+Math.random(); return false;\"><img id=\"security\" src=\"http://{$_SERVER['HTTP_HOST']}/security.php\"></a><br /><label>Введите код с картинки</label><br /><input type=\"text\" value=\"\" name=\"proverka\"><br /><input type=\"submit\" name=\"submit\" value=\"Я не бот\"></form>";
		
} */
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>RAKNET ROLE PLAY :: ONLINE MAP</title>
		<!-- Disallow users to scale this page -->
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
		<style type="text/css">html,body,#map-canvas{height:100%;margin:0}h3{width:150px;text-align:center}.btn{display:inline-block;padding:6px 12px;margin-bottom:0;font-size:14px;font-weight:normal;line-height:1.428571429;text-align:center;white-space:nowrap;vertical-align:middle;cursor:pointer;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;-o-user-select:none;user-select:none;background-image:none;border:1px solid transparent;border-radius:4px}.btn:hover,.btn:focus{color:#333;text-decoration:none!important}.btn:active,.btn.active{background-image:none;outline:none!important}.btn.disabled,.btn[disabled],fieldset[disabled] .btn{pointer-events:none;cursor:not-allowed;filter: alpha(opacity=65);-webkit-box-shadow:none;box-shadow:none;opacity:.65}.btn-info{color:#fff;background-color:#5bc0de;border-color:#46b8da}.btn-info:hover,.btn-info:focus,.btn-info:active,.btn-info.active,.open .dropdown-toggle.btn-info{color:#fff;background-color:#39b3d7;border-color:#269abc}.btn-info:active,.btn-info.active,.open .dropdown-toggle.btn-info{background-image:none}.btn-info.disabled,.btn-info[disabled],fieldset[disabled] .btn-info,.btn-info.disabled:hover,.btn-info[disabled]:hover,fieldset[disabled] .btn-info:hover,.btn-info.disabled:focus,.btn-info[disabled]:focus,fieldset[disabled] .btn-info:focus,.btn-info.disabled:active,.btn-info[disabled]:active,fieldset[disabled] .btn-info:active,.btn-info.disabled.active,.btn-info[disabled].active,fieldset[disabled] .btn-info.active{background-color:#5bc0de;border-color:#46b8da}.btn-info .badge{color:#5bc0de;background-color:#fff}.btn-danger{color:#fff;background-color:#d9534f;border-color:#d43f3a}.btn-danger:hover,.btn-danger:focus,.btn-danger:active,.btn-danger.active,.open .dropdown-toggle.btn-danger{color:#fff;background-color:#d2322d;border-color:#ac2925}.btn-danger:active,.btn-danger.active,.open .dropdown-toggle.btn-danger{background-image:none}.btn-danger.disabled,.btn-danger[disabled],fieldset[disabled] .btn-danger,.btn-danger.disabled:hover,.btn-danger[disabled]:hover,fieldset[disabled] .btn-danger:hover,.btn-danger.disabled:focus,.btn-danger[disabled]:focus,fieldset[disabled] .btn-danger:focus,.btn-danger.disabled:active,.btn-danger[disabled]:active,fieldset[disabled] .btn-danger:active,.btn-danger.disabled.active,.btn-danger[disabled].active,fieldset[disabled] .btn-danger.active{background-color:#d9534f;border-color:#d43f3a}.btn-danger .badge{color:#d9534f;background-color:#fff}</style>
	</head>
	<body>
		<!-- The container the map is rendered in -->
		<div id="map-canvas"></div>

		<!-- Load all javascript -->
		<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
		<script src="js/SanMap.min.js"></script>
		<script>
			var mapType = new SanMapType(1, 3, function (zoom, x, y) {
				return x == -1 && y== -1 ? "http://ucp.raknet.ru/newmap/map.outer.png" : "http://sanmap.ikkentim.com/tiles/sat."+zoom+"."+x+"."+y+".png";
			});
			var mapType2 = new SanMapType(0,1,function(zoom,x,y) {
				return x == -1 && y == -1 ? "http://sanmap.ikkentim.com/tiles/map.outer.png" : "http://sanmap.ikkentim.com/tiles/map." + zoom + "." + x + "." + y + ".png";
			});
			var mapType3 = new SanMapType(0, 4, function (zoom, x, y) {
				return x == -1 && y == -1 
				? "http://sanmap.ikkentim.com/tiles/sanandreas.blank.png" 
				: "http://sanmap.ikkentim.com/tiles/sanandreas." + zoom + "." + x + "." + y + ".png";
			});
			var sm = new SanMap('map-canvas',{'HQ Карта':mapType,'Обычная карта':mapType2, 'map2': mapType3},2);
			var licznik = 0;
			var homeMarker = [];
			function AddLocation(icon,pox_x,pos_y,description) {
				licznik += 0;
				setTimeout(function(){
					
					var homeInfoWindow = new google.maps.InfoWindow({
						content:description
					});
					var a = new google.maps.Marker({
						position: SanMap.getLatLngFromPos(pox_x,pos_y),
						map: sm.map,
						icon: icon
					});
					homeMarker.push(a);
					var liczba = homeMarker.indexOf(a);
					google.maps.event.addListener(homeMarker[liczba],'click',function() 
					{
						//homeMarker[liczba].setAnimation(google.maps.Animation.BOUNCE);
						homeInfoWindow.open(sm.map,homeMarker[liczba]);
					});
				},licznik);
			};
			<?php echo house($params); ?>
		</script>
	</body>
</html>