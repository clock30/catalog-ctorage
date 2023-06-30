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
            <p class="way ml-4 p-0 my-2"><a href="/">Главная</a> / <a href="/storage">Склад</a> / <span>Редактирование поступления товара</span></p>
        </div>
        <div class="col-12 p-0 goods_type delivery">
            <h2 class="ml-4 mb-0">Склад</h2>
            <p>Редактирование поступления товара. Для выбора ТТН для редактирования воспользуйтель формой поиска. Заполните минимум один из трёх разделов формы</p>
            <br>
            <form class='mx-4' method='POST' action=''>
                <div class="row">
                    <div class='col-lg-6'>
                        <div class='my-2 p-2' style='border: 1px solid black; border-radius: 3px;'>
                            <p class='mx-0' style='border-bottom: 1px solid black;'>Поиск ТТН по номеру</p>
                            <label>Частично или полностью введите номер ТТН (с серией без пробелов):<br><input type='text' name='find_ttn_number' value='{{echoFindTtnNumber}}'></label><br><br>
                        </div>
                    </div>
                    <br>
                    <div class='col-lg-6'>
                        <div class='my-2 p-2' style='border: 1px solid black; border-radius: 3px;'>
                            <p class='mx-0' style='border-bottom: 1px solid black;'>Поиск ТТН по дате</p>
                            <p class='mx-0'>Введите интервал дат, в который попадает ТТН:</p>
                            <div class='row'>
                                <div class='col-6'>
                                    <label>Начало интервала:<br><input type='date' name='find_ttn_date_from' value='{{echoFindTtnDateFrom}}'></label>
                                </div>
                                <div class='col-6'>
                                    <label>Конец интервала:<br><input type='date' name='find_ttn_date_to' value='{{echoFindTtnDateTo}}'></label>
                                </div>
                            </div>
                            <br>
                        </div>
                    </div>
                    <br>
                    <div class='col-12'>
                        <div class='my-2 p-2' style='border: 1px solid black; border-radius: 3px;'>
                            <p class='mx-0' style='border-bottom: 1px solid black;'>Поиск ТТН по поставщику</p>
                            <label>Полностью или частично введите наименование поставщика:&nbsp;<input type='text' name='find_supplier_find_receipt_good' value='{{echoFindSupplierFindReceiptGood}}' size='40'>&nbsp;&nbsp;&nbsp;</label>
                            <input type='submit' name='find_supplier_list' value='Поиск'><br><br>
                            {{findSupplierResult}}
                        </div>
                    </div>
                </div>
                <br><input type='submit' name='edit_ttn_list' value='Поиск ТТН'>&nbsp;&nbsp;&nbsp;<a style='color:black;' href='/storage/edit-receipt-good'>Очистить форму</a>
                {{editTtnListResult}}
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