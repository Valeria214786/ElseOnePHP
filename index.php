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

<div class="album py-5 bg-light">
    <div class="container">
        <h1>Список новин</h1>
        <br>
        <?php
        include "connection_database.php";
        $sql = "SELECT * FROM news";
        if (isset($dbh)) {
            $reader = $dbh->query($sql);
        }
        ?>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <?php
            foreach ($reader as $item) {
                if (strlen($item['description']) > 40){
                    $smaldesription = mb_substr($item['description'], 0, 40);
                }
                else
                    $smaldesription = $item['description'];
                echo "
            <div class='col'>
                <div class='card shadow-sm'>
                <img src='/images/{$item['image']}' alt='salo' height='225'/>
                    <div class='card-body'>
                    <h4>{$item['name']}</h4>
                    <p class='card-text'>$smaldesription ...</p>
                        <div class='d-flex justify-content-between align-items-center'>
                            <div class='btn-group'>
                                <a href='#' class='btn btn-sm btn-outline-secondary btnDelete' data-id='{$item['id']}' >Delete</a>
                                <a href='#' class='btn btn-sm btn-outline-secondary' data-id='{$item['id']}' >Detail</a>
                                <a href='edit.php?id=".$item["id"]."' class='btn btn-sm btn-outline-secondary'>Edit</a>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            ";
            }
            ?>
        </div>
    </div>
</div>




    <!--<div class="container">
        <h1>Список новин</h1>
        <?php
/*        include "connection_database.php";
        $sql = "SELECT * FROM news";
        $reader = $dbh->query($sql);
        */?>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Назва</th>
                <th scope="col">Опис</th>
                <th scope="col">Фото</th>
                <th scope="col"> </th>
            </tr>
            </thead>
            <tbody>
            <?php
/*            foreach ($reader as $row) {
                echo "
        <tr>
            <th>{$row['id']}</th>
            <td>{$row['name']}</td>
            <td>{$row['description']}</td>
            <td>
                <img src='/images/{$row['image']}' alt='salo' width='100'/>
            </td>
            
             <td>
                <a href='#' class='btn btn-sm btn-outline-secondary btnDelete' data-id='{$row['id']}' >Delete</a>
                <a href='#' class='btn btn-sm btn-outline-secondary btnEdit' data-id='{$row['id']}' >Edit</a>
            </td>
        </tr>";
            }
            */?>
            </tbody>
        </table>
    </div>-->
<script src="/js/bootstrap.bundle.min.js"></script>
<script src="/js/axios.min.js"></script>
<script>
    window.addEventListener("load",function() {
        var list=document.querySelectorAll(".btnDelete");
        for (let i=0; i<list.length; i++)
        {
            list[i].addEventListener("click", function(e) {
                e.preventDefault();
                const id = e.currentTarget.dataset.id;
                const data = new FormData();
                data.append("id", id);
                axios.post("/delete.php", data)
                    .then(resp => {
                        window.location.reload();
                    });
            });
        }
    });
</script>
</body>
</html>
