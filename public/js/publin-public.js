document.addEventListener("DOMContentLoaded", function (event) {
let menuButton = document.querySelector('.menuButton');


 menuButton.addEventListener('click', function () {
	 if(this.classList.contains('menuOpen')) {
		this.classList.remove('menuOpen');
		document.querySelector('#pagemenu').classList.remove('open');
	 }else if(!this.classList.contains('menuOpen')) {
		this.classList.add('menuOpen');
		document.querySelector('#pagemenu').classList.add('open');
	 }
	
 });

});