<?php
$conn = mysqli_connect("localhost", "root", "", "local.vpd912.com");
if (!$conn) {
    die("Ошибка: " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Змінити</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>
<body>
<?php
include "navbar.php";
// если запрос GET


if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"])) {
    $newsid = mysqli_real_escape_string($conn, $_GET["id"]);
    $sql = "SELECT * FROM news WHERE id = '$newsid'";
    if ($result = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            foreach ($result as $row) {
                $newsname = $row["name"];
                $newsdescription = $row["description"];
                $newsimage = $row["image"];
            }
            echo "
<div class='container'>
    <h1>Редагувати новину</h1>
    <form method='post' enctype='multipart / form - data'>
        <input type='hidden' name='id' value='$newsid' />
        <div class='mb - 3'>
            <label for='name' class='form - label'>Назва</label>
            <input type='text' class='form - control' id='name' name='name' placeholder='Enter name' value='$newsname'>
        </div>
        <div class='mb - 3' class='form - label'>
            <label for='description'>Опис</label>
            <textarea class='form - control' rows='10' cols='35' id='description' name='description'>$newsdescription</textarea>
        </div>
        <div class='mb - 3'>
            <label for='image' class='form - label'>
                Фото
            </label>
            <input type='file' name='image' id='image' class='form - control' value='$newsimage'/>
        </div>
        <button type='submit' class='btn btn - dark'>Зберегти</button>
    </form>

</div>";


        }  else{
            echo "<div>Пользователь не найден</div>";
        }
        mysqli_free_result($result);
    } else{
        echo "Ошибка: " . mysqli_error($conn);
    }
} elseif (isset($_POST["id"]) && isset($_POST["name"]) && isset($_POST["description"]) && isset($_POST["image"])) {
    $newsid = mysqli_real_escape_string($conn, $_POST["id"]);
    $newsname = mysqli_real_escape_string($conn, $_POST["name"]);
    $newsdescription = mysqli_real_escape_string($conn, $_POST["description"]);
    //$newsimage = mysqli_real_escape_string($conn, $_POST["image"]);
    $filename = uniqid() . '.jpg';
    $filesavepath = $_SERVER['DOCUMENT_ROOT'] . '/images/' . $filename;
    move_uploaded_file($_FILES['image']['tmp_name'], $filesavepath);

    $sql = "UPDATE news SET name = '$newsname', description = '$newsdescription', image = '$filename' WHERE id = '$newsid'";
    if($result = mysqli_query($conn, $sql)){

        header("Location: index.php");
    } else{
        echo "Ошибка: " . mysqli_error($conn);
    }
} else{
    echo "Некорректные данные";
}
mysqli_close($conn);
?>
<script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>