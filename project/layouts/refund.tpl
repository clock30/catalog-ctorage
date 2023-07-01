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
            <p class="way ml-4 p-0 my-2"><a href="/">Главная</a> /  <a href="/sales">Продажи</a> / <span>Розница возврат</span></p>
        </div>
        <div class="col-12 p-0 goods_type delivery">
            <h2 class="ml-4 mb-0">Розница возврат</h2>
            {{editRetailSelectForm}}
            {{refundForm}}
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