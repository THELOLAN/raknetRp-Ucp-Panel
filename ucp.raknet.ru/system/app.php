<?php
class App
{
	public function __construct()
	{
		require("system/classes/class.smartutil.php");
		require("system/classes/class.smartui.php");
		require("system/classes/class.smartui-wizard.php");
		require("system/classes/class.smartui-carousel.php");
		require("system/models/OtherModels.php");
		require("system/models/UserModels.php");
		require("system/models/VKModels.php");
		require("system/models/BiographyModels.php");
		require("system/models/SettingModels.php");
		require("system/models/MapModels.php");
		require("system/models/AuctionModels.php");
	}
	
	public function __destruct()
	{

	}
}