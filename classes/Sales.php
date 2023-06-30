<?php
namespace classes;
class Sales extends Page
{
    public function retailForm(){
        $result = "";
        $message = "";
        if(isset($_POST['sale_selected_good_form'])){
            if(isset($_POST['good_to_delete'])){
                require 'project/config/connection.php';
                $query = "SELECT id, good_name, price, cathegory FROM catalog WHERE id='$_POST[good_to_delete]'";
                $obj_good = mysqli_query($link,$query) or die(mysqli_error($link));
                $good=mysqli_fetch_assoc($obj_good);
                if(!empty($good)){
                    $result .= "<p class='mx-0'>Оформить продажу товара:</p><table><tr><td style='text-align: center; width: 40%;'>Наименование товара</td>
                                <td style='text-align: center; width: 12%;'>Цена</td><td style='text-align: center; width: 5%;'>Кол-во</td><td style='text-align: center; width: 19%;'>Дата</td><td colspan='2' style='text-align: center; width: 24%;'>Действие</td></tr>";
                    $result .= "<tr><td style='width: 40%;'>&nbsp;$good[good_name]<input type='hidden' name='retail_good_id' value='$_POST[good_to_delete]'><input type='hidden' name='retail_good_cathegory' value='$good[cathegory]'>&nbsp;</td><td style='width: 12%;'><input style='width: 100%;' type='text' name='good_retail_price' value='".(floor($good['price']*$this->course())+0.99)."'></td>
                            <td style='width: 5%;'><input style='width: 100%;' type='text' name='good_retail_number' value='1'></td><td style='width: 19%; text-align: center;'><input type='date' name='retail_date' value='".date('Y-m-d',time())."'></td><td style='width: 12%; text-align: center;'><input type='submit' name='retail_good' value='Продажа'></td>
                            <td style='width: 12%; text-align: center;'>&nbsp;<a style='color: black;' href='/sales/retail'>Отмена</a>&nbsp;</td></tr></table>";
                    return $result;
                }
                else return "<p class='mx-0'>Такого товара нет в наличии</p>";
            }
            else $message .= "<p class='mx-0'>Выберите товар для продажи</p>";
            return $message;
        }
        else return "";
    }

    public function retail(){
        if(isset($_POST['retail_good'])){
            $message = "";
            if($_POST['retail_good_id']!=''&&$_POST['good_retail_price']!=''&&$_POST['good_retail_number']!=''&&$_POST['good_retail_price']>0&&$_POST['good_retail_number']>0) {
                if($_POST['retail_date']==date('Y-m-d',time())){
                    $date = date('Y-m-d H:i:s',time());
                }
                else $date = date('Y-m-d H:i:s',strtotime($_POST['retail_date']));
                require 'project/config/connection.php';
                $query = "INSERT INTO retail SET good_id='$_POST[retail_good_id]', good_cathegory='$_POST[retail_good_cathegory]', number='$_POST[good_retail_number]', price='$_POST[good_retail_price]', date='$date'";
                mysqli_query($link, $query) or die(mysqli_error($link));
                header("Location: /sales");
            }
            else{
                $message .= "<p class='mx-0'>Заполните поля ЦЕНА и КОЛИЧЕСТВО. Значения должны быть больше нуля</p>";
                return $message;
            }
        }
        else return "";
    }

    public function editRetailSelectForm(){
        $result = "";
        if(!isset($_GET['id'])){
            $result .= "<form class='mx-4' method='POST' action=''><p class='mx-0'>Выбор товара для проведения операции РОЗНИЦА КОРРЕКТИРОВКА/УДАЛЕНИЕ. Поля, отмеченные звёздочками, обязательны для заполнения</p><br>
                   <label>Введите дату продажи*:</label>&nbsp;<input type='date' name='retail_date_value' value='".$this->echoRetailDate('')."'>&nbsp;&nbsp;&nbsp;
                   <input type='submit' name='retail_date_submit' value='ОК'>".$this->checkRetailDate();
            if(isset($_POST['retail_date_submit'])||isset($_POST['show_on_cathegory_edit_retail_good_list'])||isset($_POST['show_on_good_edit_retail_good_list'])||isset($_POST['edit_retail_selected_good_form'])||isset($_POST['show_retail_selected_good_on_date'])){
                if(isset($_POST['retail_date_value'])&&$_POST['retail_date_value']!='') {
                    $result .= "<p class='mx-0'>Выберите товар, продажу которого необходимо скорректировать</p>
                        <div class='row'>
                            <div class='col-lg-6'>
                                <p class='mx-0' style='border-bottom: 1px solid black; width: 100%;'>Поиск по категории</p>
                                <label>Выберите категорию, к которой относится товар:<br>".$this->selectEditRetailCathegoryList()."</label><br><br>
                                <input type='submit' name='show_on_cathegory_edit_retail_good_list' value='Показать список товаров выбранной категории'><br><br>
                                ".$this->showOnCathegoryEditRetailGoodList()."
                            </div>
                            <div class='col-lg-6'>
                                <p class='mx-0' style='border-bottom: 1px solid black; width: 100%;'>Поиск по названию товара</p>
                                <label>Полностью или частично введите наименование товара:<br>
                                <input type='text' name='good_name' value='".$this->echoGoodName()."' size='45'></label><br><br>
                                <input type='submit' name='show_on_good_edit_retail_good_list' value='Показать список товаров соответсвующих запросу'><br><br>
                                ".$this->showOnGoodEditRetailGoodList()."
                            </div>
                        </div>";
                }
                else $result .= "<p class='mx-0'>Введите дату продажи</p>";
            }

            $result .= $this->retailForm().$this->showRetailSelectedGoodOnDate()."</form>";
        }
        return $result;
    }

    public function selectEditRetailCathegoryList(){
        require 'project/config/connection.php';
        $time_from = $_POST['retail_date_value'];
        $time_to = date('Y-m-d H:i:s',strtotime($_POST['retail_date_value'])+(3600*24));
        $query = "SELECT good_id, good_cathegory FROM retail WHERE date>='$time_from' AND date<'$time_to' ORDER BY good_id ASC";
        $obj_good = mysqli_query($link,$query) or die(mysqli_error($link));
        for($arr_good=[];$row=mysqli_fetch_assoc($obj_good);$arr_good[]=$row);
        $result = "<select name='select_edit_retail_cathegory_list'><option value=''>Выберите категорию...</option>";
        if(!empty($arr_good)){
            foreach($arr_good as $item){
                $all_good_caths_array[] = $item['good_cathegory'];
            }
            $good_caths_array = array_unique($all_good_caths_array);//Массив id категорий товаров, проданных за дату $_POST['retail_date_value']
            $query = "SELECT id, cathegory_name FROM cathegories WHERE id IN (".implode(',',$good_caths_array).")";
            $obj_caths = mysqli_query($link,$query) or die(mysqli_error($link));
            for($arr_caths=[];$row=mysqli_fetch_assoc($obj_caths);$arr_caths[]=$row);

            foreach($arr_caths as $item){
                if(isset($_POST['select_edit_retail_cathegory_list'])){
                    if($_POST['select_edit_retail_cathegory_list']==$item['id']){
                        $selected = ' selected';
                    }
                    else $selected = '';
                }
                else $selected = '';
                $result .= "<option value='$item[id]'$selected>$item[cathegory_name]</option>";
            }
        }
        $result .= "</select>";
        return $result;
    }

    public function checkRetailDate(){
        if(isset($_POST['retail_date_value'])){
            require 'project/config/connection.php';
            $time_from = $_POST['retail_date_value'];
            $time_to = date('Y-m-d H:i:s',strtotime($_POST['retail_date_value'])+(3600*24));
            $query = "SELECT good_id, good_cathegory FROM retail WHERE date>='$time_from' AND date<'$time_to' ORDER BY good_id ASC";
            $obj_good = mysqli_query($link,$query) or die(mysqli_error($link));
            for($arr_good=[];$row=mysqli_fetch_assoc($obj_good);$arr_good[]=$row);
            if(strtotime($_POST['retail_date_value'])!=0&&empty($arr_good)){
                return "<p class='mx-0' style='color: #680425;'>Продаж за <b>".date('d.m.Y',strtotime($_POST['retail_date_value']))." г.</b> не было. Введите другую дату</p>";
            }
            else return "<br><br>";
        }
        else return "";
    }

    public function showOnCathegoryEditRetailGoodList(){
        $result = "";
        if(isset($_POST['show_on_cathegory_edit_retail_good_list'])/*||isset($_POST['edit_retail_selected_good_form'])*/){
            if(isset($_POST['select_edit_retail_cathegory_list'])&&$_POST['select_edit_retail_cathegory_list']!=''){
                if($this->checkCathegory($_POST['select_edit_retail_cathegory_list'])===true){
                    require 'project/config/connection.php';
                    $time_from = $_POST['retail_date_value'];
                    $time_to = date('Y-m-d H:i:s',strtotime($_POST['retail_date_value'])+(3600*24));
                    $query = "SELECT catalog.id, catalog.good_name, catalog.cathegory, retail.date, retail.good_id FROM catalog LEFT JOIN retail 
                                ON catalog.id=retail.good_id WHERE catalog.cathegory='$_POST[select_edit_retail_cathegory_list]' AND retail.date>='$time_from' AND date<'$time_to'";
                    $object_goods = mysqli_query($link,$query) or die(mysqli_error($link));
                    for($data=[];$row=mysqli_fetch_assoc($object_goods);$data[]=$row);
                    $result .= "<p class='mx-0'>Выберите товар для корректировки продажи*:</p>";
                    $arr_goods = [];
                    foreach($data as $item){
                        if(in_array($item['good_id'],$arr_goods)===false){
                            $result .= "<label><input type='radio' name='good_to_edit_retail' value='$item[id]'>&nbsp;$item[good_name]</label><br>";
                            $arr_goods[] = $item['good_id'];
                        }
                    }
                    $result .= "<br><input type='submit' name='show_retail_selected_good_on_date' value='Показать список продаж выбранного товара за ".date('d.m.Y',strtotime($_POST['retail_date_value']))."г.'><br><br>";
                }
                else $result .= "<p class='mx-0'>Выбранная категория удалена ранее</p>";
            }
            else $result .= "<p class='mx-0'>Выберите категорию</p>";
        }
        return $result;
    }

    public function showOnGoodEditRetailGoodList(){
        $result = "";
        if(isset($_POST['show_on_good_edit_retail_good_list'])){
            if(isset($_POST['good_name'])&&$_POST['good_name']!=''){
                /*$array_pattern = explode(' ',$_POST['good_name']);*/
                $pattern = $_POST['good_name'];
                /*$pattern = implode('|',$array_pattern);*/
                require 'project/config/connection.php';
                /*$query = "SELECT * FROM catalog WHERE good_name REGEXP '($pattern)'";*/
                $time_from = $_POST['retail_date_value'];
                $time_to = date('Y-m-d H:i:s',strtotime($_POST['retail_date_value'])+(3600*24));
                $query = "SELECT catalog.id, catalog.good_name, catalog.cathegory, retail.date, retail.good_id FROM catalog LEFT JOIN retail 
                                ON catalog.id=retail.good_id WHERE catalog.good_name LIKE '%$_POST[good_name]%' AND retail.date>='$time_from' AND date<'$time_to'";
                $object_goods = mysqli_query($link,$query) or die(mysqli_error($link));
                for($data=[];$row=mysqli_fetch_assoc($object_goods);$data[]=$row);
                if(!empty($data)){
                    $result .= "<p class='mx-0'>Выберите товар для корректировки продажи*:</p>";
                    $arr_goods = [];
                    foreach($data as $item){
                        if(in_array($item['good_id'],$arr_goods)===false){
                            $result .= "<label><input type='radio' name='good_to_edit_retail' value='$item[id]'>&nbsp;$item[good_name]</label><br>";
                            $arr_goods[] = $item['good_id'];
                        }
                    }
                    $result .= "<br><input type='submit' name='show_retail_selected_good_on_date' value='Показать список продаж выбранного товара за ".date('d.m.Y',strtotime($_POST['retail_date_value']))."г.'><br><br>";
                }
                else $result .= "<p class='mx-0'>Товаров, удовлетворяющих запросу, не обнаружено</p>";
            }
            else $result .= "<p class='mx-0'>Введите наименование товара для поиска</p>";
        }
        return $result;
    }

    public function showRetailSelectedGoodOnDate(){
        $result = "";
        if(isset($_POST['show_retail_selected_good_on_date'])){
            if(isset($_POST['good_to_edit_retail'])){
                require 'project/config/connection.php';
                $time_from = date('Y-m-d H:i:s', strtotime($_POST['retail_date_value']));
                $time_to = date('Y-m-d H:i:s',strtotime($_POST['retail_date_value']) + (3600*24) - 1);
                $query = "SELECT retail.id as retail_id, retail.good_id, retail.price, retail.number, retail.date, catalog.id as catalog_id, catalog.good_name FROM retail LEFT JOIN catalog ON retail.good_id=catalog.id WHERE good_id='$_POST[good_to_edit_retail]' AND date>='$time_from' AND date <='$time_to' ORDER BY date ASC";
                $obj_retails = mysqli_query($link,$query) or die(mysqli_error($link));
                for($arr_retails=[]; $row=mysqli_fetch_assoc($obj_retails);$arr_retails[]=$row);
                if(!empty($arr_retails)){
                    $query = "SELECT good_name FROM catalog WHERE id='$_POST[good_to_edit_retail]'";
                    $obj_good = mysqli_query($link,$query) or die(mysqli_error($link));
                    $good_name = mysqli_fetch_assoc($obj_good);
                    $result .= "<p class='mx-0'>Список продаж товара <b>$good_name[good_name]</b> за ".date('d.m.Y',strtotime($_POST['retail_date_value']))." г.</p>";
                    foreach($arr_retails as $item){
                        $result .= "<label><input type='radio' name='sale' value='$item[retail_id]'>&nbsp;Время: <b>".date('H:i:s',strtotime($item['date']))."</b>; Цена: <b>$item[price]</b>; Кол-во: <b>$item[number]</b></label><br>";
                    }
                    $result .= "<br><input type='submit' name='go_edit_retail_form' value='Редактировать выбранную продажу'>";
                }
            }
            else $result .= "<p class='mx-0'>Выберите товар для редактирования розничной продажи</pcla>";
        }
        return $result;
    }

    public function goEditRetailForm(){
        if(isset($_POST['sale'])){
            header("Location: /sales/edit-retail?id=$_POST[sale]");
        }
        else return "";
    }

    public function editRetailForm(){
        $result = "";
        if(isset($_GET['id'])){
                require 'project/config/connection.php';
                $query = "SELECT retail.id as retail_id, retail.good_id, retail.price, retail.number, retail.date, catalog.id as catalog_id, catalog.good_name FROM retail LEFT JOIN catalog ON retail.good_id=catalog.id WHERE retail.id='$_GET[id]'";
                $obj_edit_retail = mysqli_query($link,$query) or die(mysqli_error($link));
                $edit_retail = mysqli_fetch_assoc($obj_edit_retail);
                $date = date('Y-m-d',strtotime($edit_retail['date']));
                $result .= "<form method='POST' action='' class='mx-4'><p class='mx-0'>Редактировать продажу товара <b>$edit_retail[good_name]</b> / <b><a style='color: #680425;' href='/sales/edit-retail'>Отмена</a></b></p><table><tr><td style='text-align: center; width: 40%;'>Наименование товара</td>
                                <td style='text-align: center; width: 12%;'>Цена</td><td style='text-align: center; width: 5%;'>Кол-во</td><td style='text-align: center; width: 19%;'>Дата</td><td colspan='2' style='text-align: center; width: 24%;'>Действие</td></tr>";
                $result .= "<tr><td style='width: 40%;'>&nbsp;".$this->selectEditRetailGoodList($edit_retail['good_id'])."&nbsp;</td><td style='width: 12%;'><input style='width: 100%;' type='text' name='good_retail_price' value='$edit_retail[price]'></td>
                            <td style='width: 5%;'><input style='width: 100%;' type='text' name='good_retail_number' value='$edit_retail[number]'></td><td style='width: 19%; text-align: center;'><input type='hidden' name='old_date' value='$edit_retail[date]'><input type='date' name='retail_date' value='$date'></td><td style='width: 12%; text-align: center;'><input type='submit' name='edit_retail' value='Изменить'></td>
                            <td style='width: 12%; text-align: center;'>&nbsp;<input type='submit' name='delete_retail' value='Удалить'>&nbsp;</td></tr></table><br>".$this->editRetail().$this->deleteRetail()."
                            </form>";
        }
        return $result;
    }

    public function selectEditRetailGoodList($var){
        require 'project/config/connection.php';
        $query = "SELECT id, good_name FROM catalog ORDER BY good_name ASC";
        $obj_good_list = mysqli_query($link,$query) or die(mysqli_error($link));
        for($arr_good_list=[];$row=mysqli_fetch_assoc($obj_good_list);$arr_good_list[]=$row);
        $result = "<select name='select_edit_retail_good_list'>";
        foreach($arr_good_list as $item){
            $selected = '';
            if($item['id']==$var){
                $selected .= " selected";
            }
            $result .= "<option value='$item[id]'$selected>$item[good_name]</option>";
        }
        $result .= "</select>";
        return $result;
    }

    public function editRetail(){
        if(isset($_POST['edit_retail'])&&$_POST['edit_retail']=='Изменить'){
            if($_POST['good_retail_price']!=''&&$_POST['good_retail_number']!=''){
                require 'project/config/connection.php';
                $query = "SELECT cathegory FROM catalog WHERE id='$_POST[select_edit_retail_good_list]'";
                $obj_cathegory = mysqli_query($link,$query) or die(mysqli_error($link));
                $arr_cathegory = mysqli_fetch_assoc($obj_cathegory);
                if(date('Y-m-d',strtotime($_POST['old_date']))==date('Y-m-d',strtotime($_POST['retail_date']))){
                    $date = $_POST['old_date'];
                }
                else $date = $_POST['retail_date'];
                $query = "UPDATE retail SET good_id='$_POST[select_edit_retail_good_list]', number='$_POST[good_retail_number]', price='$_POST[good_retail_price]', date='$date', good_cathegory='$arr_cathegory[cathegory]' WHERE id='$_GET[id]'";
                mysqli_query($link,$query) or die(mysqli_error($link));
                header("Location: /sales");
            }
            else return "<p style='color: #680425;' class='mx-0'>Заполните поля ЦЕНА и КОЛИЧЕСТВО</p>";
        }
        else return "";
    }

    public function deleteRetail(){
        if(isset($_POST['delete_retail'])&&$_POST['delete_retail']=='Удалить'){
            require 'project/config/connection.php';
            $query = "DELETE FROM retail WHERE id='$_GET[id]'";
            mysqli_query($link,$query) or die(mysqli_error($link));
            header("Location: /sales");
        }
        else return "";
    }

    public function echoRetailDate($var){
        if(isset($_POST['retail_date_value'])){
            return $_POST['retail_date_value'];
        }
        else return $var;
    }
}