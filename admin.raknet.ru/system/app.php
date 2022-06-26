<?php
class App
{
	public function __construct()
	{
		require("system/api.php");
		require("system/models/OtherModels.php");
		require("system/models/MapModels.php");
		require("system/models/UserModels.php");
	}
	
	public function __destruct()
	{

	}
}