DROP DATABASE IF EXISTS public_diary;
CREATE DATABASE public_diary;
USE public_diary;

CREATE TABLE mpd_user (
    username VARCHAR(30) NOT NULL,
    passwd VARCHAR(2000) NOT NULL,
    email VARCHAR(100) NOT NULL,
    user_dt DATETIME NOT NULL,
    user_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY
);

CREATE TABLE mpd_post (
    title VARCHAR(110) NOT NULL,
    text VARCHAR(10010) NOT NULL,
    post_dt DATETIME NOT NULL,
    post_ts TIMESTAMP NOT NULL,
    post_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    FOREIGN KEY(user_id) REFERENCES mpd_user(user_id) ON DELETE CASCADE
);

CREATE TABLE mpd_comm (
    comm VARCHAR(8010) NOT NULL,
    comm_dt DATETIME NOT NULL,
    comm_ts TIMESTAMP NOT NULL,
    comm_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    post_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    FOREIGN KEY(post_id) REFERENCES mpd_post(post_id) ON DELETE CASCADE,
    FOREIGN KEY(user_id) REFERENCES mpd_user(user_id) ON DELETE CASCADE
);

CREATE TABLE mpd_post_like (
    post_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    FOREIGN KEY(post_id) REFERENCES mpd_post(post_id) ON DELETE CASCADE,
    FOREIGN KEY(user_id) REFERENCES mpd_user(user_id) ON DELETE CASCADE
);

CREATE TABLE mpd_comm_like (
    comm_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    FOREIGN KEY(comm_id) REFERENCES mpd_comm(comm_id) ON DELETE CASCADE,
    FOREIGN KEY(user_id) REFERENCES mpd_user(user_id) ON DELETE CASCADE
);

CREATE TABLE mpd_email_ver (
    user_id INT UNSIGNED NOT NULL,
    FOREIGN KEY(user_id) REFERENCES mpd_user(user_id) ON DELETE CASCADE,
    email_token VARCHAR(1000) NOT NULL,
    email_token_dt DATETIME NOT NULL
);
