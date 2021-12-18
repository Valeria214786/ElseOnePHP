<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "connection_database.php";
    $name = $_POST["name"];
    $description = $_POST["description"];

    $filename = uniqid() . '.jpg';
    $filesavepath = $_SERVER['DOCUMENT_ROOT'] . '/images/' . $filename;
    move_uploaded_file($_FILES['image']['tmp_name'], $filesavepath);

    $sql = "INSERT INTO `news` (`name`, `description`,`image`) VALUES (?, ?, ?);";
    if (isset($dbh)) {
        $dbh->prepare($sql)->execute([$name, $description, $filename]);
        header("Location: /");
        exit();
    }
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">

</head>
<body>
<?php include "navbar.php"; ?>
<div class="container">
    <h1>Додати новину</h1>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Назва</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
        </div>
        <div class="mb-3" class="form-label">
            <label for="description">Опис</label>
            <textarea class="form-control" rows="10" cols="35" id="description" name="description"></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">
                Фото
            </label>
            <input type="file" name="image" id="image" class="form-control"/>
        </div>
        <button type="submit" class="btn btn-dark">Зберегти</button>
    </form>

</div>
<script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>
