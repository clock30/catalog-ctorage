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
            <p class="way ml-4 p-0 my-2"><a href="/">Главная</a> /  <a href="/partners">Контрагенты</a> /  <span>Добавление контрагента</span></p>
        </div>
        <div class="col-12 p-0 goods_type delivery">
            <h2 class="ml-4 mb-0">Контрагенты</h2>
            <p>Добавление нового контрагента. Поля, отмеченные звёздочками, обязательны для заполнения</p>
            <br>
            <form class="mx-4" method="POST" action="">
                <label>Наименование нового контрагента*:<br><input type="text" name="partner_name" value="" size="30"></label><br><br>
                <label>Адрес*:<br><input type="text" name="partner_address" value="" size="40"></label><br><br>
                <label>УНП*:<br><input type="text" name="partner_unp" value="" size="13"></label><br><br>
                <label>Расчетный счет:<br><input type="text" name="partner_payment_account" value="" size="20"></label><br><br>
                <input type="submit" name="add_partner" value="Добавить">&nbsp;&nbsp;&nbsp;<a style="color: black;" href="/partners/add-partner">Очистить форму</a>
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