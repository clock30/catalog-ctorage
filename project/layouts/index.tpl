<!doctype html>
<html lang="ru">

<head>

    <!-- Обязательные метатеги -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  
    <!-- Your custom styles (optional) -->
    <link href="../../css/style.css" rel="stylesheet"/>
    
    <!--Подключение стилей первого слайдера-->
    <link rel="stylesheet" type="text/css" href="../../css/sim-slider-styles.css"/>
    
    <!--Favicon-->
    <link rel="shortcut icon" href="../../img/favicon.ico" type="image/x-icon"/>
    
    <!--Подключение второго слайдера-->
    <!--<link rel="stylesheet" href="https://bootstraptema.ru/plugins/bootstrap/v3/3-3-6/bootstrap.css" />-->
    <!--<link rel="stylesheet" href="https://bootstraptema.ru/plugins/font-awesome/4-4-0/font-awesome.min.css" />-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css"/>
    <script src="https://bootstraptema.ru/plugins/jquery/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../css/slyder2.css"/>
    
    <script>
     $(document).ready(function() {
     $("#news-slider").owlCarousel({
     items:4,
     itemsDesktop:[1182,3],
     itemsDesktopSmall:[974,2],
     itemsMobile:[750,1],
     pagination:false,
     navigationText:false,
     autoPlay:true
     
          });
     });
     
    </script>
  
    
    <title>Продажа лестниц - Полоцк, Новополоцк, Витебская область</title>
</head>

<body>

  <!-- Start your project here-->

  <div class="container px-0">
      {{header}}
  </div>
  
  <div class="container">
    <div class="row">
        <div class="col-12 p-0">
        
            <div class="sim-slider">
              <ul class="sim-slider-list">
                <li><img src="../../img/slyder/no-image.jpg" alt="screen"/></li> <!--Это экран, задает высоту слайдера. Размеры и пропорции изменять в Photoshop-->
                <li class="sim-slider-element"><img src="../../img/slyder/auto1.jpg" alt="0"/></li>
                <li class="sim-slider-element"><img src="../../img/slyder/auto2.jpg" alt="1"/></li>
                <li class="sim-slider-element"><img src="../../img/slyder/auto3.jpg" alt="2"/></li>
                <li class="sim-slider-element"><img src="../../img/slyder/auto4.jpg" alt="3"/></li>
                <li class="sim-slider-element"><img src="../../img/slyder/auto5.jpg" alt="4"/></li>
                <li class="sim-slider-element"><img src="../../img/slyder/auto6.jpg" alt="5"/></li>
              </ul>
              <div style="display: none;" class="sim-slider-arrow-left"></div>
              <div style="display: none;" class="sim-slider-arrow-right"></div>
              <div class="sim-slider-dots"></div>
            </div>
                    
        </div>        
    </div>

  </div>
  
  
  
<div class="container intro">
    <div class="row p-3">
        <div class="col-12 p-0">
            <h2 style="margin-left: 15px;">Новинки</h2>
            
            <div id="news-slider" class="owl-carousel">
             
             {{slyder}}
             
            </div><!-- ./owl-carousel-->    

        </div>
        
        <div class="col-12 p-2 main">            
            <p>«Всё своё ношу с собой». Эту фразу часто вспоминают, глядя на современные сумки. И пусть мудрец, сказавший это, вовсе не имел в виду, что в багаже должно быть много вещей – теперь мы зачастую воспринимаем её буквально. Мы стремимся иметь под рукой необходимое, и при этом умудряться выглядеть стильно и презентабельно. Сумка – не только приспособление, куда кладут личные вещи. Это ещё и модный аксессуар – и достаточно зайти в наш интернет магазин сумок, чтобы убедиться в этом!</p>
            <p>Кому может понадобиться купить сумки в интернет магазине? Да кому угодно! Среди наших клиентов – и юные модницы, и солидные офисные работники, и экстравагантные любители путешествий. И каждый сможет не просто найти подходящий для себя вариант, а ни много ни мало купить сумку своей мечты. Ведь наш ассортимент завидно широк, а цены при этом на удивление демократичны!</p>
            <p>На страницах нашего магазина отыщутся не только изящные женские сумочки. Да, мы всегда готовы помочь дамам, подбирающим вечерние туалеты, но отнюдь не являемся узкоспециализированным магазином. Женщины приобретают у нас сумки для повседневной носки, а мужчины – удобные дорожные изделия, вместительные и элегантные одновременно. Поклонники активного образа жизни покупают прочные и красивые спортивные сумки, а любительницы эксклюзивных вещей – сумочки из натуральной кожи. Качество любого из представленных товаров – из какого материала они бы ни были изготовлены – отвечает требованиям самого придирчивого покупателя и самого строгого стандарта.</p>
            


        </div>
    </div>
</div>

    
  <div class="container px-0">
      {{footer}}
  </div>
 
 
 
  <!-- /Start your project here-->

    <!-- подключение слайдера -->
    <script src="../../js/sim-slider.js"></script>
    <!-- вызов слайдера1 -->
    <script>new Sim()</script>
    
    <!-- вызов слайдера2 -->
    
  
  <!-- SCRIPTS -->
  <!-- JQuery -->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>

</html>
