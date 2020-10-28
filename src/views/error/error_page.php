<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title> Public Diary | <?= $title ?> </title>

    <link type="text/css" rel="stylesheet" href="/style/theme.css">
    <link type="text/css" rel="stylesheet" href="/style/error_page.css">
</head>
<body>
    <div class="error-page">
        <h1 class="error-page-title"> <?= $title ?> </h1>
        <img class="error-page-img" src="<?= $error_img ?>">
        <a href="/index.php?page=home/home_page.php">
            <p class="error-page-text"> Go back home? </p>
        </a>
    </div>
</body>
</html>
