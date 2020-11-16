const medias = document.querySelectorAll(".media");
if (medias)
    for (let media of medias) {
        let mediaCont      = media.querySelector(".media-cont");
        let mediaContText  = media.querySelector(".see-more-text");
        let seeMoreBar     = media.querySelector(".see-more");
        let mediaText      = media.querySelector(".media-text");
        let likeIcon       = media.querySelector(".like-icon");

        useCheck(
            getPair(likeIcon.className, "check"),
            () => likeIcon["src"] = LIKE_IMG["checked"],
            () => likeIcon["src"] = LIKE_IMG["unchecked"]
        );

        if (mediaText)
            mediaText.innerText = mediaText.innerText.replace(new RegExp(NEWLINER, "g"), "\n");

        if (mediaCont) seeMore("mousedown", seeMoreBar, mediaCont, mediaContText);
    }

const posts           = document.querySelectorAll(".post");
const postLoveForm    = document.querySelector(".post-like-form");
const postDeleteForm  = document.querySelector(".post-delete-form");
if (posts && postDeleteForm && postLoveForm) {
    sendPostFormRequest(postLoveForm, "post/like_post.php");
    sendPostFormRequest(postDeleteForm, "post/delete_post.php");
    for (let post of posts) {
        let postEditBtn    = post.querySelector(".post-edit-btn");
        let postDeleteBtn  = post.querySelector(".post-del-btn");
        let likeBtn        = post.querySelector(".like-btn");
        let likeIcon       = post.querySelector(".like-icon");
        let likeAmt        = post.querySelector(".like-amt");

        likeBtn.addEventListener("click", () =>
            likeIcon.className = switchCheck(
                likeIcon.className,
                getPair(likeIcon.className, "check"),
                () => likeAction(post, likeIcon, likeAmt, postLoveForm),
                () => likeAction(post, likeIcon, likeAmt, postLoveForm, false)
            )
        );

        if (postDeleteBtn && postEditBtn) {
            postDeleteBtn.addEventListener("mousedown", () =>
                deleteAction(post, postDeleteForm));
            postEditBtn.addEventListener("mousedown", () =>
                window.location.href = postEditBtn.getAttribute("href"));
        }
    }
}

const comments           = document.querySelectorAll(".comment");
const commentLoveForm    = document.querySelector(".comment-like-form");
const commentDeleteForm  = document.querySelector(".comment-delete-form");
if (comments && commentLoveForm && commentDeleteForm) {
    sendPostFormRequest(commentLoveForm, "comment/like_comment.php");
    sendPostFormRequest(commentDeleteForm, "comment/delete_comment.php");
    for (let comment of comments) {
        let commentEditBtn    = comment.querySelector(".comment-edit-btn");
        let commentDeleteBtn  = comment.querySelector(".comment-del-btn");
        let likeBtn           = comment.querySelector(".like-btn");
        let likeIcon          = comment.querySelector(".like-icon");
        let likeAmt           = comment.querySelector(".like-amt");

        likeBtn.addEventListener("click", () =>
            likeIcon.className = switchCheck(
                likeIcon.className,
                getPair(likeIcon.className, "check"),
                () => likeAction(comment, likeIcon, likeAmt, commentLoveForm),
                () => likeAction(comment, likeIcon, likeAmt, commentLoveForm, false)
            )
        );

        if (commentDeleteBtn && commentEditBtn) {
            commentDeleteBtn.addEventListener("mousedown", () =>
                deleteAction(comment, commentDeleteForm));
            commentEditBtn.addEventListener("mousedown", () =>
                window.location.href = commentEditBtn.getAttribute("href"));
        }
    }
}

const dates = document.querySelectorAll(".date");
for (let date of dates) date.innerText = formatDate(new Date(date.innerText));

const searchForm = document.querySelector(".form-search");
if (searchForm)
    searchForm.addEventListener("submit", (evt) => {
        evt.preventDefault();
        addUriParam("search", searchForm.querySelector(".main-input").value);
    });

const paginArrows = document.querySelectorAll(".pagin-arrow");
if (paginArrows)
    for (let paginArrow of paginArrows) addPagin("mousedown", paginArrow);

const dropdownFilters = document.querySelectorAll(".dropdown-filter");
if (dropdownFilters)
    for (let dropdownFilter of dropdownFilters)
        dropdownFilter.addEventListener("mousedown", (evt) => {
            if (!getPair(evt.target.className, "filter")) return;

            let filterPair = parsePair(getPair(evt.target.className, "filter"));
            addUriParam(filterPair[0], filterPair[1]);
        });

const uriErrorParam = getUriParam("error");
if (uriErrorParam) alert(parseUriMessage(uriErrorParam));
