DROP DATABASE IF EXISTS public_diary;
CREATE DATABASE public_diary;
USE public_diary;

CREATE TABLE pd_user (
    username VARCHAR(30) NOT NULL,
    password VARCHAR(2000) NOT NULL,
    email VARCHAR(100) NOT NULL,
    user_dt DATETIME NOT NULL,
    user_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY
);

CREATE TABLE post (
    title VARCHAR(110) NOT NULL,
    text VARCHAR(10010) NOT NULL,
    post_dt DATETIME NOT NULL,
    post_ts TIMESTAMP NOT NULL,
    post_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    FOREIGN KEY(user_id) REFERENCES pd_user(user_id) ON DELETE CASCADE
);

CREATE TABLE comment (
    text VARCHAR(8010) NOT NULL,
    comment_dt DATETIME NOT NULL,
    comment_ts TIMESTAMP NOT NULL,
    comment_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    post_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    FOREIGN KEY(post_id) REFERENCES post(post_id) ON DELETE CASCADE,
    FOREIGN KEY(user_id) REFERENCES pd_user(user_id) ON DELETE CASCADE
);

CREATE TABLE post_like (
    post_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    FOREIGN KEY(post_id) REFERENCES post(post_id) ON DELETE CASCADE,
    FOREIGN KEY(user_id) REFERENCES pd_user(user_id) ON DELETE CASCADE
);

CREATE TABLE comment_like (
    comment_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    FOREIGN KEY(comment_id) REFERENCES comment(comment_id) ON DELETE CASCADE,
    FOREIGN KEY(user_id) REFERENCES pd_user(user_id) ON DELETE CASCADE
);

CREATE TABLE email_verify (
    user_id INT UNSIGNED NOT NULL,
    FOREIGN KEY(user_id) REFERENCES pd_user(user_id) ON DELETE CASCADE,
    email_token VARCHAR(1000) NOT NULL,
    email_token_dt DATETIME NOT NULL
);