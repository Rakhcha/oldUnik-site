// Паралакс

document.addEventListener('mousemove', parallax);


function parallax(e){
	this.querySelectorAll('.can_move').forEach(element => {
		let sx = element.getAttribute('sx');
		let sy = element.getAttribute('sy');
		element.style.transform = `translate(${e.clientX*sx}px,${e.clientY*sy}px)`;
	});
}

function copyText(e){
	var range = new Range();
	range.selectNode(e);
	document.getSelection().removeAllRanges();
	document.getSelection().addRange(range)
	document.execCommand("copy");
	document.getSelection().removeAllRanges();
}

function queryToMap(){
	var querys = window.location.search.replace('?',"").split(',');
	let mapQuerys = new Map();

	for(let i = 0; i < querys.length; i++){

		let query = querys[i].split('=');
		if(mapQuerys.get(query[0]) == null)
			mapQuerys.set(query[0],query[1]);

	}
	return mapQuerys;
}

	

	$('.nav-btn').click(function(e){
		if($('.nav-btn').hasClass('close')){
			$('.nav-btn').attr('src', "img/menu-open.svg");
			$('nav').toggleClass('turner nav-menu');
		} else {
			$('.nav-btn').attr('src', "img/menu-close.svg");
			$('nav').toggleClass('turner nav-menu');
		}

		$('.nav-btn').toggleClass('close open');
		
	});

	$(window).resize(function(e){

		if(window.innerWidth > 970 && $('.nav-btn').hasClass('open')){
			$('.nav-btn').toggleClass('close open');
			$('.nav-btn').attr('src', "img/menu-close.svg");
			$('nav').toggleClass('turner nav-menu');
		}
	});

	$(window).scroll(function(e){

		if($('.nav-btn').hasClass('open')){
			$('.nav-btn').toggleClass('close open');
			$('.nav-btn').attr('src', "img/menu-close.svg");
			$('nav').toggleClass('turner nav-menu');;
		}
	});

	$(document).ready(function(e){
		let page = Number.parseInt(queryToMap().get('page'));

		if(page == 1) {
			$('.page-list > a').slice(0,1).addClass('page-list-hidden');
			$('.page-list > a').slice(1,2).attr('href','?page=' + page + 2);
			$('.page-list > img').slice(0,2).addClass('page-list-hidden');
		}
		if(page == 2) {
			$('.page-list > img').slice(0,1).addClass('page-list-hidden');
		}

		
	});




