<?php
namespace classes;
class Page{
    public function header(){
        $result = file_get_contents('project/layouts/_header.tpl');
        return $result;
    }

    public function footer(){
        $result = file_get_contents('project/layouts/_footer.tpl');
        return $result;
    }

    public function course($currency='USD'){
        $course = file_get_contents('https://belarusbank.by/api/kursExchange?city=Полоцк');
        $course_arr = json_decode($course,true);
        return ($course_arr[0][$currency.'_out']);
    }

    public function slyder(){
        require 'project/config/connection.php';
        $query = "SELECT * FROM catalog ORDER BY add_date DESC";
        $goods = mysqli_query($link,$query) or die(mysqli_error($link));
        for($data=[];$row=mysqli_fetch_assoc($goods);$data[]=$row);
        $result='';
        $course=$this->course();
        for($i=0,$count=1;$count<=8;$i++,$count++){
            $result .= "<div class='post-slide'>
                                <a class='d-block' href='".$this->pathIndex($data[$i]['cathegory']).$data[$i]['good_name_translit']."'>
                                    <div class='post-img'>
                                        <img src='/img/goods/".$data[$i]['picture']."' alt='".$data[$i]['good_name']."'/>
                                    </div>
                                </a>
                                <div class='post-review'>
                                    <h3 class='post-title'><a href='/catalog/".$data[$i]['good_name_translit']."'>".$data[$i]['good_name']."</a></h3>
                                    <p class='post-description'>".floor($course*$data[$i]['price'])+0.99." руб.</p>
                                    <div class='post-bar'>
                                    </div>
                                </div>
                        </div>";
        }
        return $result;
    }

    public function path(){
        $url = $_SERVER['REQUEST_URI'];
        $path = explode('/',$url);
        unset($path[0]);
        $result = "<p class='way mx-4 p-0 my-2'><a href='/'>Главная</a> /";
        require 'project/config/connection.php';
        $count = count($path);
        if($count>=2){
            $result .= " <a href='/catalog'>Каталог товаров</a> ";
            for($i=2;$i<$count;$i++){
                $query = "SELECT * FROM cathegories WHERE cathegory_alias='$path[$i]'";
                $cathegory = mysqli_query($link,$query) or die(mysqli_error($link));
                $data = mysqli_fetch_assoc($cathegory);
                $sss = '';
                for($j=2;$j<=$i;$j++){
                    $sss .= "/".$path[$j];
                }
                $result .= "/ <a href='/catalog/$sss'>$data[cathegory_name]</a> ";
            }
            $query = "SELECT * FROM cathegories WHERE cathegory_alias='$path[$count]'";
            $cathegory = mysqli_query($link,$query) or die(mysqli_error($link));
            $data = mysqli_fetch_assoc($cathegory);
            if(!empty($data)){
                $result .= "/ <span>$data[cathegory_name]</span></p>";
            }
            else{
                $query = "SELECT * FROM catalog WHERE good_name_translit='$path[$count]'";
                $good = mysqli_query($link,$query) or die(mysqli_error($link));
                $data = mysqli_fetch_assoc($good);
                $result .= "/ <span>$data[good_name]</span></p>";
            }
        }
        else{
            $result .= " <span>Каталог товаров</span></p>";
        }
        return $result;
    }

    public function pathIndex($cathegory){
        require 'project/config/connection.php';
        $result = [];
        while($cathegory!=0){
            $query = "SELECT * FROM cathegories WHERE id='$cathegory'";
            $cath = mysqli_query($link,$query) or die(mysqli_error($link));
            $data = mysqli_fetch_assoc($cath);
            $result[] = $data['cathegory_alias'];
            $cathegory = $data['parent'];
        }
        $result = array_reverse($result);
        return DIRECTORY_SEPARATOR.'catalog'.DIRECTORY_SEPARATOR.implode(DIRECTORY_SEPARATOR,$result).DIRECTORY_SEPARATOR;
    }

    public function deleteEditGoodSelectForm(){
        $result = "<form class='mx-4' method='POST' action=''>";
        if($_SERVER['REQUEST_URI']=='/admin/delete-good'){
            $result .= "<p class='mx-0'><b>Поиск товара, который необходимо удалить</b></p>";
        }
        if($_SERVER['REQUEST_URI']=='/admin/edit-good'){
            $result .= "<p class='mx-0'><b>Поиск товара, который необходимо редактировать</b></p>";
        }
        if($_SERVER['REQUEST_URI']=='/sales/retail'){
            $result .= "<p class='mx-0'>Выбор товара для проведения операции РОЗНИЧНАЯ ПРОДАЖА. Воспользуйтесь формой поиска</p><br>";
        }
        $result .=     "<div class='row'>
                            <div class='col-lg-6'>
                                <p class='mx-0' style='border-bottom: 1px solid black; width: 100%;'>Поиск по категории</p>
                                <label>Выберите категорию, к которой относится товар:<br>".$this->selectChangeCathegoryList()."</label><br><br>
                                <input type='submit' name='show_on_cathegory_delete_good_list' value='Показать список товаров выбранной категории'><br><br>
                                ".$this->showOnCathegoryDeleteGoodList()."
                            </div>
                            <div class='col-lg-6'>
                                <p class='mx-0' style='border-bottom: 1px solid black; width: 100%;'>Поиск по названию товара</p>";
        if($_SERVER['REQUEST_URI']=='/admin/delete-good'){
            $result .= "<label>Полностью или частично введите наименование товара, который необходимо удалить:<br>";
        }
        if($_SERVER['REQUEST_URI']=='/admin/edit-good'){
            $result .= "<label>Полностью или частично введите наименование товара, который необходимо редактировать:<br>";
        }
        if($_SERVER['REQUEST_URI']=='/sales/retail'){
            $result .= "<label>Полностью или частично введите наименование товара:<br>";
        }
        $result .=      "<input type='text' name='good_name' value='".$this->echoGoodName()."' size='45'></label><br><br>
                                <input type='submit' name='show_on_good_delete_good_list' value='Показать список товаров соответсвующих запросу'><br><br>
                                ".$this->showOnGoodDeleteGoodList()."
                            </div>
                        </div>";
        if($_SERVER['REQUEST_URI']=='/sales/retail'){
            $result .= $this->retailForm();
            $result .= $this->retail();
        }
        $result .= "</form>";
        return $result;
    }

    public function selectChangeCathegoryList(){//Выводит список категорий, в которые добавлены товары с атрибутом selected той категории, кот. была отправлена в POST-запросе
        require 'project/config/connection.php';
        $query = "SELECT cathegory FROM catalog";
        $cathegories = mysqli_query($link,$query) or die(mysqli_error($link));
        for($data=[];$row=mysqli_fetch_assoc($cathegories);$data[]=$row);
        if(!empty($data)){
            foreach($data as $item){
                $all_good_caths_array[] = $item['cathegory'];
            }
        }
        $good_caths_array = array_unique($all_good_caths_array);//Категории, в которые добавлены товары
        $query = "SELECT id, cathegory_name FROM cathegories WHERE id IN (".implode(',',$good_caths_array).")";
        $good_caths = mysqli_query($link,$query) or die(mysqli_error($link));
        for($data2=[];$row=mysqli_fetch_assoc($good_caths);$data2[]=$row);
        $result ="<select name='select_change_cathegory_list'><option value=''>Выберите категорию...</option>";
        foreach($data2 as $item){
            if(isset($_POST['select_change_cathegory_list'])){
                if($_POST['select_change_cathegory_list']==$item['id']){
                    $selected = ' selected';
                }
                else $selected = '';
            }
            else $selected = '';
            $result .= "<option value='$item[id]'$selected>$item[cathegory_name]</option>";
        }
        $result .= "</select>";
        return $result;
    }

    public function showOnGoodDeleteGoodList(){
        $result = "";
        if(isset($_POST['show_on_good_delete_good_list'])){
            if(isset($_POST['good_name'])&&$_POST['good_name']!=''){
                /*$array_pattern = explode(' ',$_POST['good_name']);*/
                $pattern = $_POST['good_name'];
                /*$pattern = implode('|',$array_pattern);*/
                require 'project/config/connection.php';
                /*$query = "SELECT * FROM catalog WHERE good_name REGEXP '($pattern)'";*/
                $query = "SELECT * FROM catalog WHERE good_name LIKE '%$pattern%'";
                $object_goods = mysqli_query($link,$query) or die(mysqli_error($link));
                for($data=[];$row=mysqli_fetch_assoc($object_goods);$data[]=$row);
                if(!empty($data)){
                    if($_SERVER['REQUEST_URI']=='/admin/delete-good'){
                        $result .= "<p class='mx-0'>Выберите товар для удаления</p>";
                    }
                    if($_SERVER['REQUEST_URI']=='/admin/edit-good'){
                        $result .= "<p class='mx-0'>Выберите товар для редактирования</p>";
                    }
                    if($_SERVER['REQUEST_URI']=='/sales/retail'){
                        $result .= "<p class='mx-0'>Выберите товар для продажи</p>";
                    }
                    if($_SERVER['REQUEST_URI']=='/sales/edit-retail'){
                        $result .= "<p class='mx-0'>Выберите товар для корректировки продажи</p>";
                    }
                    foreach($data as $item){
                        $result .= "<label><input type='radio' name='good_to_delete' value='$item[id]'>&nbsp;$item[good_name]</label><br>";
                    }
                    if($_SERVER['REQUEST_URI']=='/admin/delete-good'){
                        $result .= "<br><input type='submit' name='delete_selected_good' value='Удалить выбранный товар'><br><br>";
                    }
                    if($_SERVER['REQUEST_URI']=='/admin/edit-good'){
                        $result .= "<br><input type='submit' name='edit_selected_good' value='Редактировать выбранный товар'><br><br>";
                    }
                    if($_SERVER['REQUEST_URI']=='/sales/retail'){
                        $result .= "<br><input type='submit' name='sale_selected_good_form' value='Перейти к оформлению продажи'><br><br>";
                    }
                    if($_SERVER['REQUEST_URI']=='/sales/edit-retail'){
                        $result .= "<br><input type='submit' name='edit_retail_selected_good_form' value='Перейти к корректировке продажи'><br><br>";
                    }
                }
                else $result .= "<p class='mx-0'>Товаров, удовлетворяющих запросу, не обнаружено</p>";
            }
            else $result .= "<p class='mx-0'>Введите наименование товара для поиска</p>";
        }
        return $result;
    }

    public function showOnCathegoryDeleteGoodList(){
        $result = "";
        if(isset($_POST['show_on_cathegory_delete_good_list'])){
            if(isset($_POST['select_change_cathegory_list'])&&$_POST['select_change_cathegory_list']!=''){
                if($this->checkCathegory($_POST['select_change_cathegory_list'])===true){
                    require 'project/config/connection.php';
                    $query = "SELECT * FROM catalog WHERE cathegory='$_POST[select_change_cathegory_list]'";
                    $object_goods = mysqli_query($link,$query) or die(mysqli_error($link));
                    for($data=[];$row=mysqli_fetch_assoc($object_goods);$data[]=$row);
                    if($_SERVER['REQUEST_URI']=='/admin/delete-good'){
                        $result .= "<p class='mx-0'>Выберите товар для удаления</p>";
                    }
                    if($_SERVER['REQUEST_URI']=='/admin/edit-good'){
                        $result .= "<p class='mx-0'>Выберите товар для редактирования</p>";
                    }
                    if($_SERVER['REQUEST_URI']=='/sales/retail'){
                        $result .= "<p class='mx-0'>Выберите товар для продажи</p>";
                    }
                    if($_SERVER['REQUEST_URI']=='/sales/edit-retail'){
                        $result .= "<p class='mx-0'>Выберите товар для корректировки продажи</p>";
                    }
                    foreach($data as $item){
                        $result .= "<label><input type='radio' name='good_to_delete' value='$item[id]'>&nbsp;$item[good_name]</label><br>";
                    }
                    if($_SERVER['REQUEST_URI']=='/admin/delete-good'){
                        $result .= "<br><input type='submit' name='delete_selected_good' value='Удалить выбранный товар'><br><br>";
                    }
                    if($_SERVER['REQUEST_URI']=='/admin/edit-good'){
                        $result .= "<br><input type='submit' name='edit_selected_good' value='Редактировать выбранный товар'><br><br>";
                    }
                    if($_SERVER['REQUEST_URI']=='/sales/retail'){
                        $result .= "<br><input type='submit' name='sale_selected_good_form' value='Перейти к оформлению продажи'><br><br>";
                    }
                    if($_SERVER['REQUEST_URI']=='/sales/edit-retail'){
                        $result .= "<br><input type='submit' name='edit_retail_selected_good_form' value='Перейти к корректировке продажи'><br><br>";
                    }
                }
                else $result .= "<p class='mx-0'>Выбранная категория удалена ранее</p>";
            }
            else $result .= "<p class='mx-0'>Выберите категорию</p>";
        }
        return $result;
    }

    public function checkCathegory($cathegory){//Проверяет уже наличие категории в базе данных для функции addCathegory()
        require 'project/config/connection.php';
        $result = true;
        $query = "SELECT * FROM cathegories WHERE cathegory_name='$cathegory'";
        $cath = mysqli_query($link,$query) or die(mysqli_error($link));
        $data = mysqli_fetch_assoc($cath);
        if(!empty($data)){
            $result = false;
        }
        $cathegory_alias = $this->transLit($cathegory);
        $query = "SELECT * FROM cathegories WHERE cathegory_alias='$cathegory_alias'";
        $cath_alias = mysqli_query($link,$query) or die(mysqli_error($link));
        $data2 = mysqli_fetch_assoc($cath_alias);
        if(!empty($data2)){
            $result = false;
        }
        return $result;
    }

    public function transLit($str)
    {
        return strtolower(strtr($str,[
            'а' => 'a',
            'б' => 'b',
            'в' => 'v',
            'г' => 'g',
            'д' => 'd',
            'е' => 'e',
            'ё' => 'yo',
            'ж' => 'zh',
            'з' => 'z',
            'и' => 'i',
            'й' => 'y',
            'к' => 'k',
            'л' => 'l',
            'м' => 'm',
            'н' => 'n',
            'о' => 'o',
            'п' => 'p',
            'р' => 'r',
            'с' => 's',
            'т' => 't',
            'у' => 'u',
            'ф' => 'f',
            'х' => 'h',
            'ц' => 'ts',
            'ч' => 'ch',
            'ш' => 'sh',
            'щ' => 'sch',
            'ъ' => '',
            'ы' => 'y',
            'ь' => '',
            'э' => 'e',
            'ю' => 'yu',
            'я' => 'ya',
            'А' => 'a',
            'Б' => 'b',
            'В' => 'v',
            'Г' => 'g',
            'Д' => 'd',
            'Е' => 'e',
            'Ё' => 'yo',
            'Ж' => 'zh',
            'З' => 'z',
            'И' => 'i',
            'Й' => 'y',
            'К' => 'k',
            'Л' => 'l',
            'М' => 'm',
            'Н' => 'n',
            'О' => 'o',
            'П' => 'p',
            'Р' => 'r',
            'С' => 's',
            'Т' => 't',
            'У' => 'u',
            'Ф' => 'f',
            'Х' => 'h',
            'Ц' => 'ts',
            'Ч' => 'ch',
            'Ш' => 'sh',
            'Щ' => 'sch',
            'Ъ' => '',
            'Ы' => 'y',
            'Ь' => '',
            'Э' => 'e',
            'Ю' => 'yu',
            'Я' => 'ya',
            ' ' => '-',
            ',' => '',
            '.' => '',
            ':' => '',
            '!' => '',
            '&' => '',
            '?' => '',
            '\\\\' => '',
            '/' => '',
            '"' => '',
            "'" => '',
            '|' => '',
            '<' => '',
            '>' => '',
            '(' => '',
            ')' => '',
            '#' => '',
            '~' => '',
            '`' => '',
            "@" => '',
            '№' => '',
            '$' => '',
            '%' => '',
            '^' => '',
            '*' => '',
            '+' => '',
            '=' => '',
        ]));
    }

    public function echoGoodName(){
        if(isset($_POST['good_name'])){
            return $_POST['good_name'];
        }
        return "";
    }

}