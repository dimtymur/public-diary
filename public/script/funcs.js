const deleteMediaConsent = (mediaForm, mediaId) => {
    let delConsent = confirm("Do you really want to delete it?");
    if (delConsent) {
        mediaForm.querySelector("input[name='media-id']").value = mediaId;
        mediaForm.querySelector("button[name='submit']").click();
        return true;
    } return false;
};
const deleteMedia = (evt, media, delBtn, delForm) =>
    delBtn.addEventListener(evt, () => {
        if (deleteMediaConsent(delForm, media["id"])) media.style.display = "none";
    });

const editMedia = (evt, editBtn) =>
    editBtn.addEventListener(evt, () =>
        window.location.href = editBtn.getAttribute("href"));

const loveCheckMedia = (media, change=false) => {
    let loveBtn  = media.querySelector(".love-btn");
    let likeAmt  = media.querySelector(".like-amt");
    let liked    = likeAmt.title;
    if (liked == 0) {
        if (change) {
            likeAmt.innerText = parseInt(likeAmt.innerText) + 1;
            likeAmt.title = 1;
            loveBtn.src = LOVE_IMG["loved"];
        } else loveBtn.src = LOVE_IMG["unloved"];
    } else {
        if (change) {
            likeAmt.innerText = parseInt(likeAmt.innerText) - 1;
            likeAmt.title = 0;
            loveBtn.src = LOVE_IMG["unloved"];
        } else loveBtn.src = LOVE_IMG["loved"];
    }
};
const loveMedia = (evt, media, loveBtn, loveForm) => {
    loveBtn.addEventListener(evt, (evt) => {
        loveCheckMedia(media, true);
        loveForm.querySelector("input[name='media-id']").value = media["id"];
        loveForm.querySelector("button[name='submit']").click();
    });
};

const formPostReq = (form, actionPage) => {
    form.addEventListener("submit", (e) => {
        e.preventDefault();
        sendReqOnly(
            "http://localhost/index.php?page=" + actionPage,
            form,
            "POST"
        );
    });
};

const sendReqOnly = (url, data, method) => {
    let fd = new FormData(data);
    let options = {
        method: method,
        body: fd
    };
    fetch(url, options).catch(error => console.log(error))
};

const addUriParam = (key, valueArg) => {
    let value  = valueArg.toString();
    let uri    = window.location.href;
    let delim  = uri.indexOf("?") == -1 ? "?" : "&";
    let pair   = key + "=" + value.trim().replace(/\s+/g, "+");
    if (uri.indexOf(key + "=") == -1) window.location.href = uri + delim + pair;
    else {
        let regex = new RegExp(key + "=([^&]*)?");
        window.location.href = uri.replace(regex, pair);
    }
};

const getUriParam = (key) => {
    let uri = window.location.href;
    if (uri.indexOf(key + "=") == -1) return "";
    return uri.split(key + "=")[1].split("&")[0];
};

const formatDate = (date) => {
    const monthNames = [
        "January", "February", "March",
        "April", "May", "June", "July",
        "August", "September", "October",
        "November", "December"
    ];
    let day       = date.getDate();
    let monthInd  = date.getMonth();
    let year      = date.getFullYear();

    return monthNames[monthInd] + " " + day + ", " + year;
};

const addPagin = (evt, paginElem) => {
    let step = parseInt(getUriParam("step"));
    if (paginElem.className.indexOf("pagin-next") != -1) {
        if (!step || step < 0) step = 0;
        paginElem.addEventListener(evt, () => addUriParam("step", ++step));
    } else {
        if (!step || step < 0) step = 1;
        paginElem.addEventListener(evt, () => addUriParam("step", --step));
    }
}

const seeMore = (evt, cont) => {
    let contText        = cont.querySelector(".media-text");
    let contHeight      = parseInt(getComputedStyle(cont)["height"]);
    let contTextHeight  = parseInt(getComputedStyle(contText)["height"]);
    let seeMore = cont.parentElement.querySelector(".see-more");
    if (contHeight < contTextHeight) seeMore.style.display = "block";
    seeMore.addEventListener(evt, () => {
        seeMore.style.display = "none";
        cont.style.maxHeight = "10000px";
    });
}
