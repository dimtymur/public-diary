window.addEventListener("load", function() {
    const postWrap  = document.querySelector(".post-wrap");
    const postGrid  = new Colcade(postWrap, {
        columns: '.post-col',
        items: '.post'
    });
});
