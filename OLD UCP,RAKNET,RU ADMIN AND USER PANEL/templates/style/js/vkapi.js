/*VK.init({
    apiId: 3805816  // ID вашего приложения VK
});

wallGet('raknet_official', 3);

var message = [];
var modal = [];
var attachment = [];
			
function wallGet(groupid, counts) {
	
	VK.Api.call('groups.getById', {group_id: groupid, fields: 'description', v: '5.27'}, function(s) {
		
		VK.Api.call('wall.get', {domain: groupid, count: counts, v: '5.27'}, function(r) {
			
			var api = r.response.items;
			var images = s.response;
			
			for ( var i = 0; i < count ( api ); i++ ) {
				 
				message += "<li class='message'><hr><img src='" + images[0]['photo_50'] + "'><span class='message-text'><a href='http://vk.com/raknet_official' class='username'>" + images[0]['name'] + "</a><font color='#4E4747'>" + api[i]['text'] + "</font></span><hr><div align='left'><a href='javascript:void(0);' data-toggle='modal' data-target='#news"+i+"' class='btn btn-primary'>Подробнее</a><span class='pull-right'><a href='javascript:void(0);' class='btn btn-success'>" + api[i]["reposts"]["count"] + " <i class='fa fa-mail-reply'></i></a> <a href='javascript:void(0);' class='btn btn-success'>" + api[i]["likes"]["count"] + " <i class='fa fa-thumbs-up'></i></a> <a href='javascript:void(0);' class='btn btn-success'>" + api[i]["comments"]["count"] + " <i class='fa fa-comments'></i></a></span></div></li><div class='modal fade' id='news"+i+"' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'><div class='modal-dialog' style='width: 40%;'><div class='modal-content'><div class='modal-header' style='background: #fff; border-color: #fff;'><button type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button></div><div class='modal-body' style='background: #fff; border-color: #fff; width: 100%'><h4 class='modal-title' id='myModalLabel' style='background: #fff; border-color: #fff;' align='center'><a href='http://vk.com/raknet_official' class='username'>" + images[0]['name'] + "</a></h4><table class='table table-responsive'><thead><tr style='background: #fff; border-color: #fff; width: 100%'><td><img src='" + images[0]['photo_50'] + "'></td><td>"+api[i]['text']+"</td></tr></thead></table></div></div></div></div>";
				
			}
			return document.getElementById("wallget").innerHTML = message;

		});
	});
	
}
*/
function usersvk(param, param1) {

	var users = [];
	if ( device.desktop() === true ) 
	{
		$.ajax({  
			url: 'http://api.vk.com/method/groups.getMembers?group_id=raknet_official&sort='+ param +'&offset=' + param1 + '&count=72&fields=photo_50&v=5.26',  
			dataType: 'jsonp',  
			success: function(data) {
				var datas = data.response.items;
				for ( var vk = 0; vk < 72; vk++ ) {
					users += "<div class='superbox-list'><a href='http://vk.com/id"+ datas[vk]["id"] +"' target='_blank'><img src='"+ datas[vk]["photo_50"] +"' alt='"+ datas[vk]["first_name"] +" "+ datas[vk]["last_name"] +"' title='"+ datas[vk]["first_name"] +" "+ datas[vk]["last_name"] +"' class='superbox-img'></a></div>";
				}
				document.getElementById('vkphoto').innerHTML = users;
			}
		});
	} 
	else 
	{ 
		document.getElementById("vkphoto").innerHTML = ""; 
	}

}

function count(array) {
	
	var cnt=0;
	for (var i in array) {
		if (i) {
			cnt++
		}
	}
	return cnt
	
}
/*

var membersGroups = []; // массив участников группы
getMembers(50017713);

// получаем информацию о группе и её участников
function getMembers(group_id) {
	VK.Api.call('groups.getById', {group_id: group_id, fields: 'photo_50,members_count', v: '5.27'}, function(r) {
			if(r.response) {
				$('.group_info')
				.html('<img src="' + r.response[0].photo_50 + '"/><br/>' 
					+ r.response[0].name
					+ '<br/>Участников: ' + r.response[0].members_count);
				getMembers20k(group_id, r.response[0].members_count); // получем участников группы и пишем в массив membersGroups
			}
	});
}

// получаем участников группы, members_count - количество участников
function getMembers20k(group_id, members_count) {
	var code =  'var members = API.groups.getMembers({"group_id": ' + group_id + ', "v": "5.27", "sort": "id_asc", "count": "1000", "offset": ' + membersGroups.length + '}).items;' // делаем первый запрос и создаем массив
			+	'var offset = 1000;' // это сдвиг по участникам группы
			+	'while (offset < 25000 && (offset + ' + membersGroups.length + ') < ' + members_count + ')' // пока не получили 20000 и не прошлись по всем участникам
			+	'{'
				+	'members = members + "," + API.groups.getMembers({"group_id": ' + group_id + ', "v": "5.27", "sort": "id_asc", "count": "1000", "offset": (' + membersGroups.length + ' + offset)}).items;' // сдвиг участников на offset + мощность массива
				+	'offset = offset + 1000;' // увеличиваем сдвиг на 1000
			+	'};'
			+	'return members;'; // вернуть массив members
	
	VK.Api.call("execute", {code: code}, function(data) {
		if (data.response) {
			membersGroups = membersGroups.concat(JSON.parse("[" + data.response + "]")); // запишем это в массив
			$('.member_ids').html('Загрузка: ' + membersGroups.length + '/' + members_count);
			if (members_count >  membersGroups.length) // если еще не всех участников получили
				setTimeout(function() { getMembers20k(group_id, members_count); }, 333); // задержка 0.333 с. после чего запустим еще раз
			else // если конец то
				alert('Ура тест закончен! В массиве membersGroups теперь ' + membersGroups.length + ' элементов.');
		} else {
			alert(data.error.error_msg); // в случае ошибки выведем её
		}
	});
}*/