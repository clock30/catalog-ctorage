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
            <p>Magna dolore pariatur laboris ullamco aute pariatur. Reprehenderit commodo aute proident do anim cillum mollit aute aliqua occaecat enim eiusmod. Nulla exercitation in dolor fugiat esse anim do nulla esse. Ex consectetur dolore minim amet nulla minim et anim Lorem aliquip. Enim Lorem non enim fugiat incididunt cillum eiusmod ea tempor labore fugiat culpa dolor. Voluptate aliquip eu pariatur velit enim incididunt.</p>
            <p>Mollit eu esse pariatur veniam dolor laborum est labore nulla duis ea. Dolore ea irure fugiat irure occaecat elit sunt enim. Elit culpa do incididunt cillum enim non irure enim elit Lorem enim dolor dolor dolore. Irure ex ipsum aliquip laborum exercitation ex officia qui. Ea amet eu sint Lorem esse fugiat aliquip ut veniam id. Duis duis qui Lorem commodo est cupidatat minim ut amet mollit dolore.</p>
            <p>Ullamco ex incididunt ad dolor veniam officia. Anim elit dolore ad quis labore veniam dolore. Quis amet qui aute minim est officia exercitation est commodo commodo. Anim officia est cillum ut velit magna excepteur irure fugiat ad velit.</p>
            


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
