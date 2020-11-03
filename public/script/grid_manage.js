window.addEventListener("load", function() {
    const postPageCont = document.querySelector(".post-page-cont");
    const postGrid = new Colcade(postPageCont, {
        columns: '.post-col',
        items: '.post'
    });
});
