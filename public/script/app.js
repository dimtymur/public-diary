const postWrap = document.querySelector(".post-wrap");
const postTexts = document.querySelectorAll(".text");
if (postTexts)
    for (let postText of postTexts) {
        let regex = new RegExp(NEWLINER, "g");
        postText.innerText = postText.innerText.replace(regex, "\n");
    }

const formSearch = document.querySelector(".form-search");
if (formSearch)
    formSearch.addEventListener("submit", (e) => {
        e.preventDefault();
        let headerSearch = formSearch.querySelector(".header-search");
        addUriParam("search", headerSearch.value);
    });

const dropDowns = document.querySelectorAll(".dropdown-cont");
if (dropDowns)
    for (let dropDown of dropDowns) {
        let dropDownName     = dropDown.getAttribute("name");
        let dropDownItems    = POST_FILTERS[dropDownName];
        for (let i = 0; i < dropDownItems.length; i++)
            CLICKS.forEach((e) =>
                document.querySelector(
                    "." + dropDownItems[i]
                ).addEventListener(e, () => addUriParam(dropDownName, dropDownItems[i])));
    }

const sortComms = document.querySelectorAll(".sort-comm");
if (sortComms)
    for (let sortComm of sortComms) {
        let sortCommName     = sortComm.getAttribute("name");
        let sortCommItems    = COMM_FILTERS[sortCommName];
        for (let i = 0; i < sortCommItems.length; i++)
            CLICKS.forEach((e) =>
                document.querySelector(
                    "." + sortCommItems[i]
                ).addEventListener(e, () => addUriParam(sortCommName, sortCommItems[i])));
    }

const posts           = document.querySelectorAll(".post");
const postLoveForm    = document.querySelector(".post-love-form");
const postDeleteForm  = document.querySelector(".post-delete-form");
if (posts && postDeleteForm && postLoveForm) {
    formPostReq(postLoveForm, "post/love_post.php");
    formPostReq(postDeleteForm, "post/delete_post.php");
    for (let post of posts) {
        let postDelBtn    = post.querySelector(".post-del-btn");
        let postEditBtn   = post.querySelector(".post-edit-btn");
        let postLoveBtn   = post.querySelector(".post-love-btn");
        let postDate      = post.querySelector(".date");
        let postCont      = post.querySelector(".post-cont");
        if (postDelBtn && postEditBtn)
            CLICKS.forEach((e) => {
                deleteMedia(e, post, postDelBtn, postDeleteForm);
                editMedia(e, postEditBtn);
            });
        if (postLoveBtn) {
            loveCheckMedia(post);
            CLICKS.forEach((e) => loveMedia(e, post, postLoveBtn, postLoveForm));
        }
        if (postDate) postDate.innerText = formatDate(new Date(postDate.innerText));
        if (postCont) CLICKS.forEach((e) => seeMore(e, postCont));
    }
}

const comms           = document.querySelectorAll(".comm");
const commLoveForm    = document.querySelector(".comm-love-form");
const commDeleteForm  = document.querySelector(".comm-delete-form");
if (comms && commDeleteForm && commLoveForm) {
    formPostReq(commLoveForm, "comm/love_comm.php");
    formPostReq(commDeleteForm, "comm/delete_comm.php");
    for (let comm of comms) {
        let commDelBtn   = comm.querySelector(".comm-del-btn");
        let commEditBtn  = comm.querySelector(".comm-edit-btn");
        let commLoveBtn  = comm.querySelector(".comm-love-btn");
        let commDate     = comm.querySelector(".date");
        let commCont     = comm.querySelector(".comm-cont");
        if (commDelBtn && commEditBtn)
            CLICKS.forEach((e) => {
                deleteMedia(e, comm, commDelBtn, commDeleteForm);
                editMedia(e, commEditBtn);
            });
        if (commLoveBtn) {
            loveCheckMedia(comm);
            CLICKS.forEach((e) => loveMedia(e, comm, commLoveBtn, commLoveForm));
        }
        if (commDate) commDate.innerText = formatDate(new Date(commDate.innerText));
        if (commCont) CLICKS.forEach((e) => seeMore(e, commCont));
    }
}

const paginArrows = document.querySelectorAll(".pagin-arrow");
if (paginArrows)
    for (let paginArrow of paginArrows)
        CLICKS.forEach((e) => addPagin(e, paginArrow));
