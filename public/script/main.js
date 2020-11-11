const medias = document.querySelectorAll(".media");
if (medias)
    for (let media of medias) {
        let mediaCont  = media.querySelector(".media-cont");
        let mediaText  = media.querySelector(".media-text");

        let likeIcon  = media.querySelector(".like-icon");

        checkAction(
            likeIcon,
            () => likeIcon["src"] = LIKE_IMG["checked"],
            () => likeIcon["src"] = LIKE_IMG["unchecked"]
        );

        if (mediaText) {
            let mediaTextRegex = new RegExp(NEWLINER, "g");
            mediaText.innerText = mediaText.innerText.replace(mediaTextRegex, "\n");
        }
        if (mediaCont) seeMore("mousedown", mediaCont);
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

        let likeBtn   = post.querySelector(".like-btn");
        let likeIcon  = post.querySelector(".like-icon");

        likeBtn.addEventListener("click", () => {
            checkSwitch(
                likeIcon,
                () => likeAction(post, postLoveForm),
                () => likeAction(post, postLoveForm, false)
            );
        });

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

        let likeBtn   = comment.querySelector(".like-btn");
        let likeIcon  = comment.querySelector(".like-icon");

        likeBtn.addEventListener("click", () => {
            checkSwitch(
                likeIcon,
                () => likeAction(comment, commentLoveForm),
                () => likeAction(comment, commentLoveForm, false)
            );
        });

        if (commentDeleteBtn && commentEditBtn) {
            commentDeleteBtn.addEventListener("mousedown", () =>
                deleteAction(comment, commentDeleteForm));
            commentEditBtn.addEventListener("mousedown", () =>
                window.location.href = commentEditBtn.getAttribute("href"));
        }
    }
}

let dates = document.querySelectorAll(".date");
for (let date of dates) date.innerText = formatDate(new Date(date.innerText));

const searchForm = document.querySelector(".form-search");
if (searchForm)
    searchForm.addEventListener("submit", (evt) => {
        evt.preventDefault();
        let searchFormInput = searchForm.querySelector(".main-input");
        addUriParam("search", searchFormInput.value);
    });

const paginArrows = document.querySelectorAll(".pagin-arrow");
if (paginArrows)
    for (let paginArrow of paginArrows)
        addPagin("mousedown", paginArrow);

const dropdownFilters = document.querySelectorAll(".dropdown-filter");
if (dropdownFilters)
    for (let dropdownFilter of dropdownFilters)
        dropdownFilter.addEventListener("mousedown", (evt) => {
            if (!getClassPair(evt.target.className, "filter")) return;
            let filterPair = parseClassPair(getClassPair(evt.target.className, "filter"));
            addUriParam(filterPair[0], filterPair[1]);
        });

const uriErrorParam = getUriParam("error");
if (uriErrorParam) alert(parseUriMessage(uriErrorParam));
