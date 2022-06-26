<?php 
class VKAPI
{
	static public function vkwidget($group, $color1, $color2, $color3)
	{
		return "<script src=\"http://vk.com/js/api/openapi.js\" type=\"text/javascript\"></script>
				<div id=\"vk_groups\"></div>
				<script type=\"text/javascript\">
					VK.Widgets.Group(\"vk_groups\", {mode: 1, width: \"auto\", height: \"400\", color1: '{$color1}', color2: '{$color2}', color3: '{$color3}'}, {$group});
				</script>";
	}
	
	static public function wallget($group, $count = 3)
	{
		$message = "";
		$button = "";
		$video = "";
		
		$post = json_decode(file_get_contents("http://api.vk.com/method/wall.get?domain={$group}&count={$count}&v=5.34"), true);
		$post = (array)$post;
		$wallget = $post['response']['items'];
		
		$get = json_decode(file_get_contents("http://api.vk.com/method/groups.getById?group_id={$group}&fields=description&v=5.29"), true);
		$get = (array)$get;
		$getById = $get['response'];
		
		for($i = 0; $i < count($wallget); $i++)
		{
			$url = preg_replace("#(https?|ftp)://\S+[^\s.,> )\];'\"!?]#",'<a href="\\0" target="_blank">\\0</a>', $wallget[$i]['text']);
			$url = str_replace ( "\n","<br />" , $url );
			
    		if(isset($wallget[$i]['attachments']))
			{
				foreach($wallget[$i]['attachments'] as $attacment)
				{
					switch($attacment['type'])
					{
						case 'video': 
						{
							$video = preg_replace("#(https?|ftp)://\S+[^\s.,> )\];'\"!?]#",'<a href="\\0" target="_blank">\\0</a>', $attacment['video']['description']);
							$video = str_replace ( "\n","<br />" , $video );
							$url .= "{$attacment['video']['title']}
										<p class=\"chat-file row\" style=\"width: 320px; height: 240px;\">
											<b class=\"col-lg-6\" style=\"width: 320px; height: 240px;\"> 
												<img src=\"{$attacment['video']['photo_320']}\">
											</b>
										</p>
										<br />
										{$video}";
						}
						break;
						case 'page': $button = "<a class=\"btn btn-primary\" href=\"{$attacment['page']['view_url']}\">Подробнее</a>"; break;
						default: $button = "<a class=\"btn btn-primary\" href=\"http://vk.com/raknet_official?w=wall{$wallget[$i]['owner_id']}_{$wallget[$i]['id']}\">Подробнее</a>";
					}
				}
			}
			$message .= "<li class=\"message\">
							<hr>
							<img src=\"{$getById[0]['photo_50']}\">
							<span class=\"message-text\"> 
								<a href=\"http://vk.com/raknet_official\" class=\"username\">{$getById[0]['name']}</a>
								<font color=\"#4E4747\">{$url}</font>
							</span>
							<hr>
							<div align=\"left\">
								<a href=\"#\" style=\"display: inline-block;\"></a> 
								{$button}
								<span class=\"pull-right\">
									<a href=\"javascript:void(0);\" class=\"btn btn-success\">{$wallget[$i]['reposts']['count']} <i class=\"fa fa-mail-reply\"></i></a> 
									<a href=\"javascript:void(0);\" class=\"btn btn-success\">{$wallget[$i]['likes']['count']} <i class=\"fa fa-thumbs-up\"></i></a> 
									<a href=\"javascript:void(0);\" class=\"btn btn-success\">{$wallget[$i]['comments']['count']} <i class=\"fa fa-comments\"></i></a>
								</span>
							</div>
						</li>
						";
		}
		return $message;
	}
	
	static public function getuser($group)
	{
		$rand_array = array('id_asc', 'id_desc');
		$sizeof = count($rand_array);
		$id = (rand()%$sizeof);
		
		$random = mt_rand(0, 100);
		
		$img = "";
		
		$user = json_decode(file_get_contents("http://api.vk.com/method/groups.getMembers?group_id={$group}&sort={$rand_array[$id]}&offset={$random}&count=72&fields=photo_50&v=5.29") , true );
		$user = (array)$user;
		
		$user = $user['response']['items'];
		
		for($i = 0; $i < 72; $i++)
		{
			$img .= "<div class=\"superbox-list\">
						<a href=\"http://vk.com/id{$user[$i]['id']}\" target=\"_blank\">
							<img src=\"{$user[$i]['photo_50']}\" alt=\"{$user[$i]['first_name']} {$user[$i]['last_name']}\" title=\"{$user[$i]['first_name']} {$user[$i]['last_name']}\" class=\"superbox-img\">
						</a>
					</div>";
		}
		return $img;
	}
}