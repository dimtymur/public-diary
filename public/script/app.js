const NEWLINER = "~_";
const POST_FILTERS = {
  "sort": [
    "love-post",
    "comments",
    "new-post"
  ],
  "date": [
    "today-post",
    "week-post",
    "month-post",
    "year-post",
    "all-post"
  ]
};
const COMM_FILTERS = {
  "sort": [
    "love-comm",
    "new-comm"
  ]
};
const CLICKS = ['mousedown', 'ontouchstart'];
const LOVE_IMG = {
  "unloved": "/img/icons/heart-icon.png",
  "loved": "/img/icons/heart-checked-icon.png"
};


const deleteMediaConsent = function(mediaForm, mediaId) {
  let delConsent = confirm("Do you really want to delete it?");
  if (delConsent) {
    mediaForm.querySelector("input[name='media-id']").value = mediaId;
    mediaForm.querySelector("button[name='submit']").click();
    return true;
  } return false;
};
const deleteMedia = function(evt, media, delBtn, delForm) {
  delBtn.addEventListener(evt, function() {
    if (deleteMediaConsent(delForm, media["id"]))
      media.style.display = "none";
  });
};

const editMedia = function(evt, editBtn) {
  editBtn.addEventListener(evt, function() {
    window.location.href = this.getAttribute("href");
  });
};

const loveCheckMedia = function(media, change=false) {
  let loveBtn  = media.querySelector(".love-btn");
  let likeAmt  = media.querySelector("#like-amt");
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
const loveMedia = function(evt, media, loveBtn, loveForm) {
  loveBtn.addEventListener(evt, function(evt) {
    loveCheckMedia(media, true);
    loveForm.querySelector("input[name='media-id']").value = media["id"];
    loveForm.querySelector("button[name='submit']").click();
  });
};

const formPostReq = function(form, actionPage) {
  form.addEventListener("submit", function(evt) {
    evt.preventDefault();
    sendReqOnly(
      "http://localhost/index.php?page=" + actionPage,
      this,
      "POST"
    );
  });
};

const sendReqOnly = function(url, data, method) {
  fd = new FormData(data);
  options = {
    method: method,
    body: fd
  };
  fetch(url, options).catch(error => console.log(error))
};

const addUriParam = function(key, valueArg) {
  let value  = valueArg.toString();
  let uri    = window.location.href;
  let delim  = uri.indexOf("?") == -1 ? "?" : "&";
  let pair   = key + "=" + value.trim().replace(/\s+/g, "+");
  if (uri.indexOf(key + "=") == -1)
    window.location.href = uri + delim + pair;
  else {
    let regex = new RegExp(key + "=([^&]*)?");
    window.location.href = uri.replace(regex, pair);
  }
};

const getUriParam = function(key) {
  let uri = window.location.href;
  if (uri.indexOf(key + "=") == -1) return "";
  return uri.split(key + "=")[1].split("&")[0];
};

const formatDate = function(date) {
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

const addPagin = function(evt, paginElem) {
  let step = parseInt(getUriParam("step"));
  if (paginElem.id == "pagin-next") {
    if (!step || step < 0) step = 0;
    paginElem.addEventListener(evt, function() {
      addUriParam("step", ++step);
    });
  } else {
    if (!step || step < 0) step = 1;
    paginElem.addEventListener(evt, function() {
      addUriParam("step", --step);
    });
  }
}

const seeMore = function(evt, cont) {
  let contText        = cont.querySelector(".text");
  let contHeight      = parseInt(getComputedStyle(cont)["height"]);
  let contTextHeight  = parseInt(getComputedStyle(contText)["height"]);
  if (contHeight < contTextHeight) {
    let mainWrap = cont.parentElement;
    let seeMore = mainWrap.querySelector(".see-more");
    seeMore.style.display = "block";
    seeMore.addEventListener(evt, function() {
      if (postWrap)
        window.location.href = "/index.php?page=post/post_page.php&post-id=" + mainWrap.id;
      else {
        this.style.display = "none";
        cont.style.maxHeight = "10000px";
      }
    });
  }
}


const postWrap = document.querySelector(".post-wrap");

const postTexts = document.querySelectorAll(".text");
if (postTexts)
  for (postText of postTexts) {
    let regex = new RegExp(NEWLINER, "g");
    postText.innerText = postText.innerText.replace(regex, "\n");
  }

const formSearch = document.querySelector("#form-search");
if (formSearch)
  formSearch.addEventListener("submit", function(e) {
    e.preventDefault();
    let headerSearch = this.querySelector("#header-search");
    addUriParam("search", headerSearch.value);
  });

const dropDowns = document.querySelectorAll(".dropdown-cont");
if (dropDowns)
  for (dropDown of dropDowns) {
    let dropDownName     = dropDown.getAttribute("name");
    let dropDownItemIds  = POST_FILTERS[dropDownName];
    for (let i = 0; i < dropDownItemIds.length; i++)
      CLICKS.forEach(function(evt) {
        document.getElementById(
          dropDownItemIds[i]
        ).addEventListener(evt, function() {
          addUriParam(dropDownName, dropDownItemIds[i]);
        });
      });
  }

const sortComms = document.querySelectorAll(".sort-comm");
if (sortComms)
  for (sortComm of sortComms) {
    let sortCommName     = sortComm.getAttribute("name");
    let sortCommItemIds  = COMM_FILTERS[sortCommName];
    for (let i = 0; i < sortCommItemIds.length; i++)
      CLICKS.forEach(function(evt) {
        document.getElementById(
          sortCommItemIds[i]
        ).addEventListener(evt, function() {
          addUriParam(sortCommName, sortCommItemIds[i]);
        });
      });
  }

const posts           = document.querySelectorAll(".post");
const postDeleteForm  = document.querySelector("#post-delete-form");
const postLoveForm    = document.querySelector("#post-love-form");
if (posts && postDeleteForm && postLoveForm) {
  formPostReq(postLoveForm, "post/love_post.php");
  formPostReq(postDeleteForm, "post/delete_post.php");
  for (let post of posts) {
    let postDelBtn    = post.querySelector("#post-del-btn");
    let postEditBtn   = post.querySelector("#post-edit-btn");
    let postLoveBtn   = post.querySelector("#post-love-btn");
    let postDate      = post.querySelector(".date");
    let postCont      = post.querySelector("#post-cont");
    if (postDelBtn && postEditBtn)
      CLICKS.forEach(function(evt) {
        deleteMedia(evt, post, postDelBtn, postDeleteForm);
        editMedia(evt, postEditBtn);
      });
    if (postLoveBtn) {
      loveCheckMedia(post);
      CLICKS.forEach(function(evt) {
        loveMedia(evt, post, postLoveBtn, postLoveForm);
      });
    }
    if (postDate)
      postDate.innerText = formatDate(new Date(postDate.innerText));
    if (postCont)
      CLICKS.forEach(function(evt) {
        seeMore(evt, postCont);
      });
  }
}

const comms           = document.querySelectorAll(".comm");
const commDeleteForm  = document.querySelector("#comm-delete-form");
const commLoveForm    = document.querySelector("#comm-love-form");
if (comms && commDeleteForm && commLoveForm) {
  formPostReq(commLoveForm, "comm/love_comm.php");
  formPostReq(commDeleteForm, "comm/delete_comm.php");
  for (let comm of comms) {
    let commDelBtn   = comm.querySelector("#comm-del-btn");
    let commEditBtn  = comm.querySelector("#comm-edit-btn");
    let commLoveBtn  = comm.querySelector("#comm-love-btn");
    let commDate     = comm.querySelector(".date");
    let commCont     = comm.querySelector("#comm-cont");
    if (commDelBtn && commEditBtn)
      CLICKS.forEach(function(evt) {
        deleteMedia(evt, comm, commDelBtn, commDeleteForm);
        editMedia(evt, commEditBtn);
      });
    if (commLoveBtn) {
      loveCheckMedia(comm);
      CLICKS.forEach(function(evt) {
        loveMedia(evt, comm, commLoveBtn, commLoveForm);
      });
    }
    if (commDate)
      commDate.innerText = formatDate(new Date(commDate.innerText));
    if (commCont)
      CLICKS.forEach(function(evt) {
        seeMore(evt, commCont);
      });
  }
}

const paginArrows = document.querySelectorAll(".pagin-arrow");
if (paginArrows)
  for (paginArrow of paginArrows) {
    CLICKS.forEach(function(evt) {
      addPagin(evt, paginArrow);
    });
  }
