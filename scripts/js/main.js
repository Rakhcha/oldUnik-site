

var toUpBtn = document.querySelector('.to-up');
let hash = window.location.hash == "" ? null : window.location.hash.substr(1);


toUpBtn.addEventListener('click', backToTop);

window.addEventListener('scroll', function(){
	var scrolled = window.pageYOffset;
    var coords = document.documentElement.clientHeight / 1.5;

    if (scrolled < coords) {
		toUpBtn.classList.add('disable');
    }
	if (scrolled > coords) {
		toUpBtn.classList.remove('disable');
    };
});

window.onhashchange = function(){
	hash = window.location.hash == "" ? null : window.location.hash.substr(1);
	if (window.location.pathname.substring(window.location.pathname.lastIndexOf('/') + 1) == "join.html") switchJoin();
	if (window.location.pathname.substring(window.location.pathname.lastIndexOf('/') + 1) == "profile.html") switchProfile();
}


// ============== URL EDIT ==============

function changeHash(changeOn){
	window.location.hash = changeOn;
}

function goTo(page,hash) {
	if(hash){
		document.location.href = page + ".html#" + hash;
		return;
	}
	document.location.href = page + ".html";
}

// ============== DOCUMENT INTERACTION ==============

function backToTop() {
	if (window.pageYOffset > 0) {
		window.scrollBy(0, -40);
		setTimeout(backToTop, 0);
	}
};

function copyText(e){
	var range = new Range();
	range.selectNode(e);
	document.getSelection().removeAllRanges();
	document.getSelection().addRange(range)
	navigator.clipboard.writeText(range);
	document.getSelection().removeAllRanges();
}

function likeClick(e){
	var like = e.querySelector('[id=like]').innerHTML;
	var icolike = e.querySelector('img');

	if(!e.classList.contains('liked')){
		e.querySelector('[id=like]').innerHTML = Number(like) + 1;
		e.classList.add('liked');
		icolike.setAttribute('src','img/icons/liked.png')
	} else {
		e.querySelector('[id=like]').innerHTML = Number(like) - 1;
		e.classList.remove('liked');
		icolike.setAttribute('src','img/icons/like.png')
	}
	
}


// ============== JOIN DOC ==============

function switchJoin() {
	var reg = document.querySelector('.register-box');
	var rec = document.querySelector('.recover-box');
	var login = document.querySelector('.login-box');

	switch(hash){
		case "register":
			reg.classList.remove('disable'); 
			rec.classList.add('disable');
			login.classList.add('disable');
			return;
		case "recover":
			reg.classList.add('disable'); 
			rec.classList.remove('disable');
			login.classList.add('disable'); 
			return;
		case "login":
		default:
			reg.classList.add('disable'); 
			rec.classList.add('disable');
			login.classList.remove('disable');
			return;	
	}
}


// ============== PROFILE DOC ==============

var lkmenu = document.querySelectorAll('.lkmenu div');
var lk_element = document.querySelectorAll('.lk_element');

function switchProfile() {
	switch(hash){
		case "settings":
			setOnProfile("settings-btn");
			setOnProfileElement('settings');
			return;
		case "skin":
			setOnProfile("skin-btn");
			setOnProfileElement('skin');
			return;
		case "requests":
			setOnProfile("requests-btn");
			setOnProfileElement('requests');
			return;
		case "moderation":
			setOnProfile("moderation-btn");
			setOnProfileElement('moderation');
			return;
		case "cabinet":
			setOnProfile("cabinet-btn");
			setOnProfileElement('info-card');
			return;
		default:
			changeHash('cabinet');
			return;
	}
}

function setOnProfile(setOn){
	lkmenu.forEach(e => {
		e.removeAttribute('style');
		if(e.id == setOn) e.setAttribute('style','color:black')
	})
}

function setOnProfileElement(element_name){
	lk_element.forEach(e => {
		e.classList.add('disable');
		if(e.classList.contains(element_name)) e.classList.remove('disable');
	})
}



