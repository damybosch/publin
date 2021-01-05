document.addEventListener("DOMContentLoaded", function(event) {
console.log('init js');
let activePage = 1;
let result = document.querySelector('#result')

// * Start Magazine
displayNewPage();

// * Display page doormiddel van HttpRequest
function displayNewPage() {
    const pagename = document.querySelector('#pages .page.count' + activePage).dataset.pagename;

    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4){
            let parser = new DOMParser();
            let doc = parser.parseFromString(xhr.responseText, "text/html");
            let content = doc.querySelector('.fl-page-content').innerHTML;
            result.innerHTML = content;
        }
    };

    xhr.open('GET', publin_php_vars.siteUrl +'/publin_magazinepages/'+pagename);

    xhr.send();
}



function displayNextPage() {
    activePage++;
    result.classList.add('fadePage');
    displayNewPage();
    setTimeout(function() {
        result.classList.remove('fadePage');
      }, 2000);
      setTimeout(function() {
        window.scrollTo(0, 0);
    }, 1000);
}

function displayPrevPage() {
    activePage--;
    result.classList.add('fadePage');
    displayNewPage();
    setTimeout(function() {
        result.classList.remove('fadePage');
      }, 2000);
    setTimeout(function() {
        window.scrollTo(0, 0);
    }, 1000);
      
}

const nextPageButton = document.querySelector('#nextPage');
const prevPageButton = document.querySelector('#prevPage');
nextPageButton.addEventListener('click', function() {
    displayNextPage();
});
prevPageButton.addEventListener('click', function() {
    displayPrevPage();
});

});