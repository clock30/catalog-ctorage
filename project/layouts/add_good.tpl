<!doctype html>
<html lang="ru">

<head>

    <!-- Обязательные метатеги -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <!-- Your custom styles (optional) -->
    <link href="/css/style.css" rel="stylesheet"/>

    <!--Подключение стилей первого слайдера-->
    <link rel="stylesheet" type="text/css" href="/css/sim-slider-styles.css"/>

    <!--Favicon-->
    <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon"/>

    <title>Продажа лестниц - Полоцк, Новополоцк, Витебская область. Каталог товаров</title>
</head>

<body>

<!-- Start your project here-->

<div class="container px-0">
    {{header}}
</div>


<div class="container ">
    <div class="row p-0">
        <div class="col-12 p-0 way">
            <p class="way ml-4 p-0 my-2"><a href="/">Главная</a> / <a href="/admin">Товаровед</a> / <span>Добавление товара</span></p>
        </div>
        <div class="col-12 p-0 goods_type delivery">
            <h2 class="ml-4 mb-0">Товаровед</h2>
            <p>Добавление карточки товара. Если необходимо добавить новую категорию товаров, то перед тобавлением карточки товара сделайте это в разделе <a style="color: black;" href="/admin/add-cathegory">Добавление новой категории товаров</a>. Поля, отмеченные звездочками, обязательны для заполнения</p>
            <br>
            <form class="mx-4" method="POST"  action='/scripts/add_good.php' enctype='multipart/form-data'>
                <label>Наименование товара*:<br><input type="text" name="good_name" size="100" value="{{echoGoodName}}"></label><br><br>
                <label>Описание товара*:<br><textarea name="good_description" cols="100" rows="4">{{echoGoodDescription}}</textarea></label><br><br>
                <label>Материал:<br><input type="text" name="good_material" size="100" value="{{echoGoodMaterial}}"></label><br><br>
                <label>Цвет:<br><input type="text" name="good_color" size="50" value="{{echoGoodColor}}"></label><br><br>
                <label>Цена*:<br><input type="text" name="good_price" size="10" value="{{echoGoodPrice}}"></label><br><br>
                <label>Категория*:<br>{{cathegoryList}}</label><br><br>
                <label>Фотография:<br><input type="file" name="good_photo"></label><br><br>
                <label>Дополнительная информация:<br><input type="text" name="add_info" size="100" value="{{echoAddInfo}}"></label><br><br>
                <input type="submit" name="add_good" value="Добавить товар">&nbsp;&nbsp;&nbsp;<a style="color: black;" href="/admin/add-good">Очистить форму</a>
            </form>
            <br><br>
        </div>
    </div>
</div>

<div class="container px-0">
    {{footer}}
</div>


<!-- /Start your project here-->

<!-- SCRIPTS -->
<!-- JQuery -->
<script type="text/javascript" src="../../js/jquery-3.3.1.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="../../js/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="../../js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="../../js/mdb.js"></script>
</body>

</html>