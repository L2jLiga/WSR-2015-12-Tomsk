// генератор случайных чисел
function GetRandom (min,max) {
	return  Math.floor((Math.random() * (max - min +1)) + min);
}

$(document).ready(function(){
	// Сцена 1
	$('#toscene2').click(function(){
		$("#scene1").fadeOut(150, function(){scene2();});
	});

	var mice = $("#mice");
	function miceanim() {
		mice.attr("src","res/mouse.png").animate({'left': "-=260"}, 5000,function(){miceanim2()});
	};
	function miceanim2() {
		mice.attr("src","res/mouse2.png").animate({'left':"+=260"}, 5000,function(){miceanim()});
	};
	miceanim();
	mice.click(function(){
		$(this).stop().fadeOut(250, function(){$(this).remove()});
		$("mousealert").remove();
		$("#toshop").fadeIn(450);
	});



	// Сцена 2
	function scene2 () {
		var cnt = 0;
		var counters = 0;
		var Timer;
		$("#scene2").fadeIn(500, function() {
			Timer = setInterval(GetCheese, 900);
		});
		var width = $("#scene2").offset().left;
		var height = $("#scene2").offset().top;
		$("#scene2").on("click", ".cheese", function(){
			$("#backgr").css({"display":"block","top":height,"left":width});
			cnt++;
			$(this).attr({"style":"position:absolute;top:"+height+37+"px;left:"+width+65+"px;z-index:1001","class":""}).fadeOut(1300,function(){
				$(this).remove();
			});
			$('fb').html(cnt);
			if(cnt == 15) {
				$('#scene2').fadeOut(300, function() {
					$("#scene2").off("click", ".cheese")
					$('#scene3').fadeIn(1500);
				});
			}
		});
		function GetCheese() {
			$('<img class="cheese"\
			style="\
			top: '+GetRandom(90,190)+'px;\
			left: '+GetRandom(10,270)+'px;\
			width:'+GetRandom(35,50)+'px" \
			src="res/cheese/'+GetRandom(1,5)+'.png"\
			alt="Собери меня"/>').appendTo($("#scene2")).fadeIn(1300);
			counters++;

			if(counters == 15) {
				clearInterval(Timer);
			}
		}
	}



	// Сцена 3
	$('#again').click(function(){
		$("#scene3").fadeOut(150, function(){scene2();});
	});
});
