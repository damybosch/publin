document.addEventListener("DOMContentLoaded", function (event) {
    console.log('init js');
    let activePage = 1;
    let result = document.querySelector('#result');
    let totalPages = document.querySelectorAll('.page').length;
    let menuItems = document.querySelectorAll('.menuItem');

    // * Start Magazine
    displayNewPage();

    // * Display page doormiddel van HttpRequest
    function displayNewPage() {
        const pagename = document.querySelector('#pages .page.count' + activePage).dataset.pagename;

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
        result.classList.add('fadePage');

        xhr.onload = function () {
            window.scrollTo(0, 0);
            setTimeout(function () {
                result.classList.remove('fadePage');
            }, 100);
            
            
        };
        xhr.send();

        // * als menu is geopend sluit menu!
        if (document.querySelector('.menuButton').classList.contains('menuOpen')) {
            document.querySelector('.menuButton').classList.remove('menuOpen');
            document.querySelector('#pagemenu').classList.remove('open');
        }

        // * Doe Fade effect als nieuwe pagina word geladen
        setTimeout(function () {
            
        }, 500);
    }
    // * Laad eerste pagina
    function displayFirstPage() {
        if (activePage != 1) {
            activePage = 1;
            displayNewPage();
        }
    }
    // * Laad volgende pagina
    function displayNextPage() {
        if (activePage < totalPages) {
            activePage++;
            displayNewPage();
        }
    }
    // * Laad vorige pagina
    function displayPrevPage() {
        if (activePage <= 1) {
            return false;
        } else {
            activePage--;
            displayNewPage();

        }

    }

    // * Loop door menu items en voeg eventlistener.
    for (let i = 0; i < menuItems.length; i++) {
        menuItems[i].addEventListener('click', function () {
            activePage = this.dataset.pagecount;
            displayNewPage();
        });
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