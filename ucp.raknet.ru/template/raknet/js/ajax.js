var default_content = "";
$(document).ready(function(){
	checkURL();
	$('nav ul li a').click(function (e){
		checkURL(this.hash);
	});
	default_content = $('#content').html();
	setInterval("checkURL()",250);
});

var lasturl = "";

function checkURL(hash)
{
	if(!hash) hash = window.location.hash;
	if(hash != lasturl)
	{
		lasturl = hash;
		
		if(hash == "") 
		{
			$('#content').html(default_content);
		}
		else
		{
			loadPage(hash);
		}
	}
}


function loadPage(url)
{
	url = url.replace('#url','');
	$('#loading').css('visibility','visible');
	$.ajax({
		type: "POST",
		url: "index.php",
		data: 'page='+url,
		dataType: "html",
		success: function(msg){
			if(parseInt(msg) != 0)
			{
				$('#content').html(msg);
				$('#loading').css('visibility','hidden');
			}
		}
	});
}