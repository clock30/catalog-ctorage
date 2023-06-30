<?php
namespace classes;
class Catalog extends Page
{
    public function goodCard(){
        $url = $_SERVER['REQUEST_URI'];
        $good_name_translit = str_replace('\\','/',$url);
        $search = '/catalog/';
        $good_name_translit = str_replace($search,'',$good_name_translit);
        require 'project/config/connection.php';
        $query = "SELECT * FROM catalog WHERE good_name_translit='$good_name_translit'";
        $goods = mysqli_query($link,$query) or die(mysqli_error($link));
        $data = mysqli_fetch_assoc($goods);
        return "<div class='row p-0'>
                        <div class='col-12 p-0 way'>
                            <p class='way ml-4 p-0 my-2'><a href='/'>Главная</a> / <a href='/catalog'>Каталог товаров</a> / <span>$data[good_name]</span></p>
                        </div>
                        <div class='col-12 p-0 goods_type'>
                            <h2 class='ml-4 mb-0'>$data[good_name]</h2>
                        </div>
                    </div>
                    <div class='row p-3 goods_description'>
                        <div class='col-12 col-md-6 p-0 goods_about_image'>
                            <img class='goods-photo img-fluid' src='../img/goods/$data[picture]'/>
                        </div>
                        <div class='col-12 col-md-6 py-2 goods_description_right'>
                            <div class='row'>
                                <div class='col-4 goods_about_left'>
                                    <p class='goods_about'>Описание:</p>
                                </div>
                                <div class='col-8'>
                                    <p class='goods_about_value'>$data[description]</p>
                                </div>
                            </div>
                            <div class='row goods_about'>
                                <div class='col-4 goods_about_left'>
                                    <p class='goods_about'>Материал:</p>
                                </div>
                                <div class='col-8'>
                                    <p class='goods_about_value'>$data[material]</p>
                                </div>
                            </div>
                            <div class='row goods_about'>
                                <div class='col-4 goods_about_left'>
                                    <p class='goods_about'>Цвет:</p>
                                </div>
                                <div class='col-8'>
                                    <p class='goods_about_value'>$data[color]</p>
                                </div>
                            </div>
                            <div class='row goods_about'>
                                <div class='col-4 goods_about_left'>
                                    <p class='goods_price'>Цена:</p>
                                </div>
                                <div class='col-8'>
                                    <p class='goods_price_value'><span class='goods_price_value2'>".floor($this->course()*$data['price'])+0.99."</span> руб.</p>
                                </div>
                            </div>
                            <div class='row goods_about'>
                                <div class='col-12'>
                                    <p class='phone_order'>Заказ можно оформить по телефону: &nbsp;&nbsp; <span><nobr>+375 (44) 654 98 74</nobr></span></p>
                                </div>
                            </div>
                        </div>
                    </div>";
    }

    public function catalogCathegories(){
        $url = $_SERVER['REQUEST_URI'];
        $cathegory_name_translit = str_replace('\\','/',$url);
        preg_match('#/(?<cath>[a-z0-9-_]+)$#',$cathegory_name_translit,$matches);
        require 'project/config/connection.php';
        $result = "";
        if($matches['cath']=='catalog'){
            $query = "SELECT * FROM cathegories WHERE parent='0'";
            $cathegories = mysqli_query($link,$query) or die(mysqli_error($link));
            for($data=[];$row=mysqli_fetch_assoc($cathegories);$data[]=$row);
            $result .= "<div class='col-12 p-0 goods_type delivery'>
                       <h2 class='ml-4 mb-0'>Каталог товаров</h2><br>";
            foreach($data as $item){
                $result .= "<p><a class='cathegories' href='$_SERVER[REQUEST_URI]/$item[cathegory_alias]'>$item[cathegory_name]</a></p>";
            }
            $result .= "<br></div>";
        }
        else{
            $query = "SELECT * FROM cathegories WHERE cathegory_alias='$matches[cath]'";
            $data = mysqli_query($link,$query) or die(mysqli_error($link));
            $cathegory = mysqli_fetch_assoc($data);
            if(!empty($cathegory)) {
                $result .= "<div class='col-12 p-0 goods_type delivery'>
                       <h2 class='ml-4 mb-0'>Каталог товаров</h2>
                       <p>$cathegory[cathegory_name]</p><br>";
                $parent = $cathegory['id'];
                $query = "SELECT * FROM cathegories WHERE parent='$parent'";
                $cathegories = mysqli_query($link, $query) or die(mysqli_error($link));
                for ($data = []; $row = mysqli_fetch_assoc($cathegories); $data[] = $row) ;
                if (!empty($data)) {
                    foreach ($data as $item) {
                        $result .= "<p><a class='cathegories' href='$_SERVER[REQUEST_URI]/$item[cathegory_alias]'>$item[cathegory_name]</a></p>";
                    }
                    $result .= "<br></div>";
                } else {
                    $query = "SELECT * FROM catalog WHERE cathegory='$cathegory[id]'";
                    $goods = mysqli_query($link, $query) or die(mysqli_error($link));
                    for ($data = []; $row = mysqli_fetch_assoc($goods); $data[] = $row) ;
                    $course = $this->course();
                    $result .= "<section class='text-center mb-4'><div class='row wow fadeIn'>";
                    foreach ($data as $item) {
                        $result .= "<div class='col-lg-3 col-md-6 mb-4 card_ext'>
                                        <div class='card'>
                                            <div class='view overlay view_img'>
                                                <a href='$_SERVER[REQUEST_URI]/$item[good_name_translit]'>
                                                    <img class='card-img-top' alt='$item[good_name]' src='/img/goods/$item[picture]'/>
                                                </a>
                                            </div>
                                            <div class='card-body text-center'>
                                                <a href='$_SERVER[REQUEST_URI]/$item[good_name_translit]' class='card_goods_type'>
                                                    <h4>$item[good_name]</h4>
                                                </a>
                                                <div class='space'></div>
                                                <h5 class='font-weight-bold'>
                                                    <strong>" . floor($course * $item['price']) + 0.99 . " руб.</strong>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>";
                    }
                    $result .= "</section></div>";
                }
            }
            else{
                $query = "SELECT * FROM catalog WHERE good_name_translit='$matches[cath]'";
                $good = mysqli_query($link,$query) or die(mysqli_error($link));
                $data = mysqli_fetch_assoc($good);
                return "<div class='col-12 p-0 goods_type'>
                                    <p class='mx-4 my-1'>Каталог товаров</p>
                                    <h2 class='ml-4 mb-0'>$data[good_name]</h2>
                                </div>
                                <div class='col-12 p-0'>
                                    <div class='row p-3 goods_description mx-auto'>
                                        <div class='col-12 col-md-6 p-0 goods_about_image'>
                                            <img class='goods-photo img-fluid' src='/img/goods/$data[picture]'/>
                                        </div>
                                        
                                        <div class='col-12 col-md-6 py-2 goods_description_right'>
                                            <div class='row'>
                                                <div class='col-4 goods_about_left'>
                                                    <p class='goods_about'>Описание:</p>
                                                </div>
                                                <div class='col-8'>
                                                    <p class='goods_about_value'>$data[description]</p>
                                                </div>
                                            </div>
                                            <div class='row goods_about'>
                                                <div class='col-4 goods_about_left'>
                                                    <p class='goods_about'>Материал:</p>
                                                </div>
                                                <div class='col-8'>
                                                    <p class='goods_about_value'>$data[material]</p>
                                                </div>
                                            </div>
                                            <div class='row goods_about'>
                                                <div class='col-4 goods_about_left'>
                                                    <p class='goods_about'>Цвет:</p>
                                                </div>
                                                <div class='col-8'>
                                                    <p class='goods_about_value'>$data[color]</p>
                                                </div>
                                            </div>
                                            <div class='row goods_about'>
                                                <div class='col-4 goods_about_left'>
                                                    <p class='goods_price'>Цена:</p>
                                                </div>
                                                <div class='col-8'>
                                                    <p class='goods_price_value'><span class='goods_price_value2'>".floor($this->course()*$data['price'])+0.99."</span> руб.</p>
                                                </div>
                                            </div>
                                            <div class='row goods_about'>
                                                <div class='col-12'>
                                                    <p class='phone_order'>Заказ можно оформить по телефону: &nbsp;&nbsp; <span><nobr>+375 (44) 654 98 74</nobr></span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>";
            }
        }
        return $result;
    }
}