const mediaFormAction = (media, mediaForm) => {
    mediaForm.querySelector("input[name='media-id']").value = media.id;
    mediaForm.querySelector("button[name='submit']").click();
};

const deleteAction = (media, deleteForm) => {
    if (!confirm("Do you really want to delete it?")) return;
    media.style.display = "none";
    mediaFormAction(media, deleteForm);
};

const likeAction = (media, loveForm, state=true) => {
    let likeIcon  = media.querySelector(".like-icon");
    let likeAmt   = media.querySelector(".like-amt");
    if (state) {
        likeIcon["src"] = LIKE_IMG["checked"];
        likeAmt.innerText = parseInt(likeAmt.innerText) + 1;
    } else {
        likeIcon["src"] = LIKE_IMG["unchecked"];
        likeAmt.innerText = parseInt(likeAmt.innerText) - 1;
    }
    mediaFormAction(media, loveForm);
};

const sendPostFormRequest = (form, actionPage) => {
    form.addEventListener("submit", (evt) => {
        evt.preventDefault();
        sendFormRequest(
            "http://localhost/index.php?page=" + actionPage,
            form,
            "POST"
        );
    });
};

const sendFormRequest = (url, data, method) => {
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
    return (uri.indexOf(key + "=") == -1) ? "" : uri.split(key + "=")[1].split("&")[0];
};

const formatDate = (date) => {
    const months = [
        "January", "February", "March",
        "April", "May", "June", "July",
        "August", "September", "October",
        "November", "December"
    ];
    let day         = date.getDate();
    let monthIndex  = date.getMonth();
    let year        = date.getFullYear();

    return months[monthIndex] + " " + day + ", " + year;
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
    let contText        = cont.querySelector(".see-more-text");
    let contHeight      = parseInt(getComputedStyle(cont)["height"]);
    let contTextHeight  = parseInt(getComputedStyle(contText)["height"]);
    let seeMore         = cont.parentElement.querySelector(".see-more");
    if (contHeight < contTextHeight) seeMore.style.display = "block";
    seeMore.addEventListener(evt, () => {
        seeMore.style.display = "none";
        cont.style.maxHeight = "10000px";
    });
}

const getClassPair = (className, classPairName) => {
    let pattern = classPairName + "{[a-zA-Z0-9-_]+:[a-zA-Z0-9-_]+}";
    let regex = new RegExp(pattern, "g");
    let result = className.match(regex);
    return result ? result[0] : "";
};

const parseClassPair = (classPair) => {
    let regex = /[a-zA-Z0-9-_]+:[a-zA-Z0-9-_]+/;
    return classPair.match(regex)[0].split(":");
};

const setClassPairValue = (className, classPairName, newValue) => {
    let classPair = getClassPair(className, classPairName);
    let regex = /:[a-zA-Z0-9-_]+/;
    let newClassPair = classPair.replace(regex, ":" + newValue);
    return className.replace(classPair, newClassPair);
};

const isChecked = (element) => {
    let checkPair = getClassPair(element.className, "check");
    return parseClassPair(checkPair)[1] == 1 ? true : false;
};

const checkAction = (element, func_checked, func_unchecked) => {
    if (isChecked(element)) func_checked();
    else func_unchecked();
};

const checkSwitch = (element, func_checked=()=>{}, func_unchecked=()=>{}) => {
    if (isChecked(element)) {
        func_unchecked();
        element.className = setClassPairValue(element.className, "check", 0);
    } else {
        func_checked();
        element.className = setClassPairValue(element.className, "check", 1);
    }
};
