document.addEventListener("DOMContentLoaded", function (event) {
    console.log('init js');
    let activePage = 1;
    let result = document.querySelector('#result');
    let totalPages = document.querySelectorAll('.page').length;

    // * Start Magazine
    displayNewPage();

    // * Display page doormiddel van HttpRequest
    function displayNewPage() {
        const pagename = document.querySelector('#pages .page.count' + activePage).dataset.pagename;
        result.classList.add('fadePage');
        var xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                let parser = new DOMParser();
                let doc = parser.parseFromString(xhr.responseText, "text/html");
                let content = doc.querySelector('.fl-page-content').innerHTML;
                result.innerHTML = content;
            }
        };

        xhr.open('GET', publin_php_vars.siteUrl + '/publin_magazinepages/' + pagename);

        xhr.send();

        setTimeout(function () {
            result.classList.remove('fadePage');
        }, 2000);
        setTimeout(function () {
            window.scrollTo(0, 0);
        }, 1000);
    }

    function displayFirstPage() {
        if(activePage != 1) {
            activePage = 1;
            displayNewPage();
        }
    }

    function displayNextPage() {
        if (activePage < totalPages) {
            activePage++;
            displayNewPage();
        }
    }

    function displayPrevPage() {
        if (activePage <= 1) {
            return false;
        } else {
            activePage--;
            displayNewPage();
            
        }

    }

    const nextPageButton = document.querySelector('#nextPage');
    const prevPageButton = document.querySelector('#prevPage');
    const startButton = document.querySelector('.homeButton');
    nextPageButton.addEventListener('click', function () {
        displayNextPage();
    });
    prevPageButton.addEventListener('click', function () {
        displayPrevPage();
    });
    startButton.addEventListener('click', function () {
        displayFirstPage();
    });



});