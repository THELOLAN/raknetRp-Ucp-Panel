<?php
$directory = realpath ( dirname ( __FILE__ ) );
$document_root =  $_SERVER['DOCUMENT_ROOT'];
$base_url = ( isset ( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http' ) . '://' . $_SERVER['HTTP_HOST'];
if( strpos ( $directory , $document_root ) === 0 ) $base_url .= str_replace ( DIRECTORY_SEPARATOR , '/' , substr ( $directory , strlen ( $document_root ) ) );
defined ( "APP_URL" ) ? null : define ( "APP_URL" , str_replace ( "/map" , "" , $base_url ) );
$url = APP_URL;
defined("template") ? null : define("template", "template/raknet/");

define("bjson", "/home/webuser/fillbiz.json");
$namebiz = "";
$biz = json_decode(file_get_contents(bjson), true);
$biz = (array)$biz;

$paramaaa = 0;

for($i = 0; $i < count($biz); $i++)
{
	switch($biz[$i]['Gorod'])
	{
		case 0:	$city = "Los Santos"; break;
		case 1:	$city = "San Fierro"; break;
		case 2:	$city = "Las Venturas"; break;
	}
	$message = str_replace('"',"'",$biz[$i]['Message']);
	if($paramaaa == 0)
	{
		if($biz[$i]['name'] == "")
		{
			$namebiz .= "AddLocation('{$url}/" . template . "img/icons/47.png',{$biz[$i]['Fill_X']},{$biz[$i]['Fill_Y']},\"<h3>Бизнес - АЗС - № {$biz[$i]['id']}</h3><br><b>Название:</b> {$message}<br><b>Цена:</b>{$biz[$i]['Cena']}<font color='green'>$</font><br><b>Город:</b>{$city}\");";
		}
		else
		{
			$namebiz .= "AddLocation('{$url}/" . template . "img/icons/47.png',{$biz[$i]['Fill_X']},{$biz[$i]['Fill_Y']},\"<h3>Бизнес - АЗС - № {$biz[$i]['id']}</h3><br><b>Название:</b> {$message}<br><b>Цена за литр:</b> {$biz[$i]['Cena_Fuell_1']}<font color='green'>$</font><br><b>Цена за ввоз бензина:</b> {$biz[$i]['Cenapokupki']}<font color='green'>$</font><br><b>Кол-во топлива на АЗС:</b> {$biz[$i]['b2ObKolicestvo']}<br><b>Город:</b> {$city}\");";
		}
	}
}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>RAKNET ROLE PLAY :: ONLINE MAP</title>
		<!-- Disallow users to scale this page -->
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
		<style type="text/css">html,body,#map-canvas{height:100%;margin:0;padding:0;}h3{width:150px;text-align:center}.btn{display:inline-block;padding:6px 12px;margin-bottom:0;font-size:14px;font-weight:normal;line-height:1.428571429;text-align:center;white-space:nowrap;vertical-align:middle;cursor:pointer;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;-o-user-select:none;user-select:none;background-image:none;border:1px solid transparent;border-radius:4px}.btn:hover,.btn:focus{color:#333;text-decoration:none!important}.btn:active,.btn.active{background-image:none;outline:none!important}.btn.disabled,.btn[disabled],fieldset[disabled] .btn{pointer-events:none;cursor:not-allowed;filter: alpha(opacity=65);-webkit-box-shadow:none;box-shadow:none;opacity:.65}.btn-info{color:#fff;background-color:#5bc0de;border-color:#46b8da}.btn-info:hover,.btn-info:focus,.btn-info:active,.btn-info.active,.open .dropdown-toggle.btn-info{color:#fff;background-color:#39b3d7;border-color:#269abc}.btn-info:active,.btn-info.active,.open .dropdown-toggle.btn-info{background-image:none}.btn-info.disabled,.btn-info[disabled],fieldset[disabled] .btn-info,.btn-info.disabled:hover,.btn-info[disabled]:hover,fieldset[disabled] .btn-info:hover,.btn-info.disabled:focus,.btn-info[disabled]:focus,fieldset[disabled] .btn-info:focus,.btn-info.disabled:active,.btn-info[disabled]:active,fieldset[disabled] .btn-info:active,.btn-info.disabled.active,.btn-info[disabled].active,fieldset[disabled] .btn-info.active{background-color:#5bc0de;border-color:#46b8da}.btn-info .badge{color:#5bc0de;background-color:#fff}.btn-danger{color:#fff;background-color:#d9534f;border-color:#d43f3a}.btn-danger:hover,.btn-danger:focus,.btn-danger:active,.btn-danger.active,.open .dropdown-toggle.btn-danger{color:#fff;background-color:#d2322d;border-color:#ac2925}.btn-danger:active,.btn-danger.active,.open .dropdown-toggle.btn-danger{background-image:none}.btn-danger.disabled,.btn-danger[disabled],fieldset[disabled] .btn-danger,.btn-danger.disabled:hover,.btn-danger[disabled]:hover,fieldset[disabled] .btn-danger:hover,.btn-danger.disabled:focus,.btn-danger[disabled]:focus,fieldset[disabled] .btn-danger:focus,.btn-danger.disabled:active,.btn-danger[disabled]:active,fieldset[disabled] .btn-danger:active,.btn-danger.disabled.active,.btn-danger[disabled].active,fieldset[disabled] .btn-danger.active{background-color:#d9534f;border-color:#d43f3a}.btn-danger .badge{color:#d9534f;background-color:#fff}</style>
	</head>
	<body>
		<!-- The container the map is rendered in -->
		<div id="map-canvas"></div>

		<!-- Load all javascript -->
		<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
		<script src="<?php echo $url . "/" . template;?>js/SanMap.min.js"></script>
		<script>
			var mapType = new SanMapType(1, 3, function (zoom, x, y) {
				return x == -1 && y== -1 ? "<?php echo $url . "/" . template;?>map.outer.png" : "http://sanmap.ikkentim.com/tiles/sat."+zoom+"."+x+"."+y+".png";
			});
			var mapType2 = new SanMapType(0,1,function(zoom,x,y) {
				return x == -1 && y == -1 ? "http://sanmap.ikkentim.com/tiles/map.outer.png" : "http://sanmap.ikkentim.com/tiles/map." + zoom + "." + x + "." + y + ".png";
			});
			var mapType3 = new SanMapType(0, 4, function (zoom, x, y) {
				return x == -1 && y == -1 
				? "http://sanmap.ikkentim.com/tiles/sanandreas.blank.png" 
				: "http://sanmap.ikkentim.com/tiles/sanandreas." + zoom + "." + x + "." + y + ".png";
			});
			var sm = new SanMap('map-canvas',{'map2': mapType3, 'HQ Карта':mapType,'Обычная карта':mapType2},2);
			var licznik = 0;
			var homeMarker = [];
			function AddLocation(icon,pox_x,pos_y,description) 
			{
				licznik += 0;
				setTimeout(function()
				{
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
						homeInfoWindow.open(sm.map,homeMarker[liczba]);
					});
				},licznik);
			};
			<?php echo $namebiz; ?>
		</script>
	</body>
</html>