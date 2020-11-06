window.addEventListener("load", function() {
    const postPageCont = document.querySelector(".post-page-cont");
    const postGrid = new Colcade(postPageCont, {
        columns: '.main-cont-col',
        items: '.main-cont-item'
    });
});
