var toUpBtn = document.querySelector('.to-up');
var header = document.querySelector('.header');

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

function backToTop() {
	if (window.pageYOffset > 0) {
		window.scrollBy(0, -40);
		setTimeout(backToTop, 0);
	}
};

window.addEventListener('scroll', function(){
	if(window.scrollY == 0){
		header.classList.add('upheader');
	} else {
		header.classList.remove('upheader');
	}
})

function copyText(e){
	var range = new Range();
	range.selectNode(e);
	document.getSelection().removeAllRanges();
	document.getSelection().addRange(range)
	navigator.clipboard.writeText(range);
	document.getSelection().removeAllRanges();
}
