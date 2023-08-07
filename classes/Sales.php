<?php
namespace classes;
class Sales extends Storage
{
    public function retailForm(){
        $result = "";
        $message = "";
        if(isset($_POST['sale_selected_good_form'])){
            if(isset($_POST['good_to_delete'])){
                require 'project/config/connection.php';
                $query = "SELECT id, good_name, price FROM catalog WHERE id='$_POST[good_to_delete]'";
                $obj_good = mysqli_query($link,$query) or die(mysqli_error($link));
                $good=mysqli_fetch_assoc($obj_good);
                if(!empty($good)){
                    $result .= "<p class='mx-0'>Оформить продажу товара:</p><table><tr><td style='text-align: center; width: 40%;'>Наименование товара</td>
                                <td style='text-align: center; width: 12%;'>Цена</td><td style='text-align: center; width: 5%;'>Кол-во</td><td style='text-align: center; width: 19%;'>Дата</td><td colspan='2' style='text-align: center; width: 24%;'>Действие</td></tr>";
                    $result .= "<tr><td style='width: 40%;'>&nbsp;$good[good_name]<input type='hidden' name='retail_good_id' value='$_POST[good_to_delete]'>&nbsp;</td><td style='width: 12%;'><input style='width: 100%;' type='text' name='good_retail_price' value='".(floor($good['price']*$this->course())+0.99)."'></td>
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
                $query = "INSERT INTO retail SET good_id='$_POST[retail_good_id]', number='$_POST[good_retail_number]', price='$_POST[good_retail_price]', date='$date'";
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
            $result .= "<form class='mx-4' method='POST' action=''>";
            if($_SERVER['REQUEST_URI']=='/sales/edit-retail'){
                $result .= "<p class='mx-0'>Выбор товара для проведения операции РОЗНИЦА КОРРЕКТИРОВКА/УДАЛЕНИЕ. Поля, отмеченные звёздочками, обязательны для заполнения</p><br>";
            }
            if($_SERVER['REQUEST_URI']=='/sales/refund'){
                $result .= "<p class='mx-0'>Выбор товара для проведения операции РОЗНИЦА ВОЗВРАТ. Поля, отмеченные звёздочками, обязательны для заполнения</p><br>";
            }
            $result .= "
                   <label>Введите дату продажи*:</label>&nbsp;<input type='date' name='retail_date_value' value='".$this->echoRetailDate('')."'>&nbsp;&nbsp;&nbsp;
                   <input type='submit' name='retail_date_submit' value='ОК'>".$this->checkRetailDate();
            if(isset($_POST['retail_date_submit'])||isset($_POST['show_on_cathegory_edit_retail_good_list'])||isset($_POST['show_on_good_edit_retail_good_list'])||isset($_POST['edit_retail_selected_good_form'])||isset($_POST['show_retail_selected_good_on_date'])||isset($_POST['go_edit_retail_form'])||isset($_POST['go_refund_form'])){
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
                    if(isset($_POST['go_edit_retail_form'])){
                        if(!isset($_POST['sale'])){
                            $result .= "<p class='mx-0' style='color:#680425;'>Вы не выбрали продажу для корректировки/удаления</p>";
                        }
                    }
                    if(isset($_POST['go_refund_form'])){
                        if(!isset($_POST['sale'])){
                            $result .= "<p class='mx-0' style='color:#680425;'>Вы не выбрали продажу для для оформления возврата</p>";
                        }
                    }
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
        $query = "SELECT retail.good_id, retail.date, catalog.id as catalog_id, catalog.cathegory, cathegories.id as cathegories_id, cathegories.cathegory_name FROM retail LEFT JOIN catalog ON retail.good_id=catalog.id 
                    LEFT JOIN cathegories ON catalog.cathegory=cathegories.id WHERE retail.date>='$time_from' AND retail.date<'$time_to' ORDER BY retail.good_id ASC";
        $obj_good = mysqli_query($link,$query) or die(mysqli_error($link));
        for($arr_good=[];$row=mysqli_fetch_assoc($obj_good);$arr_good[]=$row);
        $result = "<select name='select_edit_retail_cathegory_list'><option value=''>Выберите категорию...</option>";
        if(!empty($arr_good)){
            $arr_cathegories = [];
            $arr_cathegories_name = [];
            foreach($arr_good as $item){
                if(!in_array($item['cathegories_id'],$arr_cathegories)){
                    $arr_cathegories[] = $item['cathegories_id'];
                    $arr_cathegories_name[] = $item['cathegory_name'];
                }
            }
            for($i=0;$i<count($arr_cathegories);$i++){
                if(isset($_POST['select_edit_retail_cathegory_list'])){
                    if($_POST['select_edit_retail_cathegory_list']==$arr_cathegories[$i]){
                        $selected = ' selected';
                    }
                    else $selected = '';
                }
                else $selected = '';
                $result .= "<option value='$arr_cathegories[$i]'$selected>$arr_cathegories_name[$i]</option>";
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
            $query = "SELECT good_id FROM retail WHERE date>='$time_from' AND date<'$time_to' ORDER BY good_id ASC";
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
                    if($_SERVER['REQUEST_URI']=='/sales/edit-retail'){
                        $result .= "<br><input type='submit' name='go_edit_retail_form' value='Редактировать выбранную продажу'>";
                    }
                    if($_SERVER['REQUEST_URI']=='/sales/refund'){
                        $result .= "<br><input type='submit' name='go_refund_form' value='Оформить возврат на основе выбранной продажи'>";
                    }
                }
            }
            else $result .= "<p class='mx-0' style='color: #680425;'>Вы не выбрали товар для редактирования розничной продажи</pcla>";
        }
        return $result;
    }

    public function goEditRetailForm(){
        if(isset($_POST['go_edit_retail_form'])){
            if(isset($_POST['sale'])){
                header("Location: /sales/edit-retail?id=$_POST[sale]");
            }
            else return "";
        }
        else return "";
    }

    public function goRefundForm(){
        if(isset($_POST['go_refund_form'])){
            if(isset($_POST['sale'])){
                header("Location: /sales/refund?id=$_POST[sale]");
            }
            else return "";
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

    public function refundForm(){
        $result = "";
        if(isset($_GET['id'])){
            require 'project/config/connection.php';
            $query = "SELECT retail.id as retail_id, retail.good_id, retail.price, retail.number, retail.date, catalog.id as catalog_id, catalog.good_name FROM retail LEFT JOIN catalog ON retail.good_id=catalog.id WHERE retail.id='$_GET[id]'";
            $obj_refund = mysqli_query($link,$query) or die(mysqli_error($link));
            $refund = mysqli_fetch_assoc($obj_refund);
            $date = date('Y-m-d H:i:s',time());
            $result .= "<form method='POST' action='' class='mx-4'><p class='mx-0'>Оформление возврата товара <b>$refund[good_name]</b> / <b><a style='color: #680425;' href='/sales/refund'>Отмена</a></b></p><table><tr><td style='text-align: center; width: 40%;'>Наименование товара</td>
                                <td style='text-align: center; width: 12%;'>Цена</td><td style='text-align: center; width: 5%;'>Кол-во</td><td style='text-align: center; width: 19%;'>Дата</td><td colspan='2' style='text-align: center; width: 24%;'>Действие</td></tr>";
            $result .= "<tr><td style='width: 40%;'><input type='hidden' name='refund_good_id' value='$refund[catalog_id]'>&nbsp;$refund[good_name]&nbsp;</td><td style='width: 12%;'><input type='hidden' name='good_refund_price' value='$refund[price]'>&nbsp;$refund[price]&nbsp;</td>
                            <td style='width: 5%;'><input style='width: 100%;' type='text' name='good_refund_number' value='$refund[number]'></td><td style='width: 19%; text-align: center;'><input type='hidden' name='current_time' value='$date'><input type='date' name='refund_date' value='".date('Y-m-d',time())."'></td><td style='width: 24%; text-align: center;'><input type='submit' name='refund' value='Оформить возврат'></td>
                            </tr></table><br>".$this->refund()."</form>";
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

    public function refund(){
        if(isset($_POST['refund'])){
            if($_POST['good_refund_number']!=''&&$_POST['good_refund_number']>0){
                require 'project/config/connection.php';
                if(!isset($_POST['refund_date'])||strtotime($_POST['refund_date'])==0){
                    $date = $_POST['current_time'];
                }
                else{
                    if(date('Y-m-d',strtotime($_POST['current_time']))==$_POST['refund_date']){
                        $date = $_POST['current_time'];
                    }
                    else $date = $_POST['refund_date'];
                }
                $query = "INSERT INTO refund SET good_id='$_POST[refund_good_id]', price='$_POST[good_refund_price]', number='$_POST[good_refund_number]', date='$date'";
                mysqli_query($link,$query) or die(mysqli_error($link));
                header('Location: /sales');
            }
            else return "<p class='mx-0' style='color: #680425;'>Введите количество товара для возврата, оно должно быть больше нуля</p>";
        }
        else return "";
    }

    public function selectEditRefundForm(){
        $result = "<form class='mx-4' method='POST' action=''><p class='mx-0'>Выбор товара для проведения операции РОЗНИЦА ВОЗВРАТ - КОРРЕКТИРОВКА/УДАЛЕНИЕ. Поля, отмеченные звёздочками, обязательны для заполнения</p><br>";
        $result .= "<label>Введите дату возврата*:</label>&nbsp;<input type='date' name='retail_date_value' value='".$this->echoRetailDate('')."'>&nbsp;&nbsp;&nbsp;
                   <input type='submit' name='refund_date_submit' value='ОК'>".$this->checkRefundDate();
        if(isset($_POST['refund_date_submit'])||isset($_POST['edit_refund_list'])||isset($_POST['edit_refund'])||isset($_POST['delete_refund'])) {
            if (isset($_POST['retail_date_value']) && $_POST['retail_date_value'] != '') {
                require 'project/config/connection.php';
                $time_from = date('Y-m-d H:i:s',strtotime($_POST['retail_date_value']));
                $time_to = date('Y-m-d H:i:s',strtotime($time_from)+(3600*24));
                $query = "SELECT refund.id as refund_id, refund.good_id, refund.number, refund.price, refund.date, catalog.id as catalog_id, catalog.good_name FROM refund LEFT JOIN catalog ON refund.good_id=catalog.id 
                            WHERE refund.date>='$time_from' AND refund.date<'$time_to' ORDER BY refund.date ASC";
                $obj_refund = mysqli_query($link,$query) or die(mysqli_error($link));
                for($arr_refund=[];$row=mysqli_fetch_assoc($obj_refund);$arr_refund[]=$row);
                if(!empty($arr_refund)){
                    $date = date('d.m.Y',strtotime($_POST['retail_date_value']));
                    $result .= "<br><br><p class='mx-0'>Выберите один из возвратов за <b>$date</b> г., который необходимо скорректировать*:</p>";
                    foreach($arr_refund as $item){
                        $checked = "";
                        if (isset($_POST['edit_refund_list'])){
                            if($_POST['edit_refund_list']==$item['refund_id']){
                                $checked .= " checked";
                            }
                        }
                        $result .= "<label><input type='radio' name='edit_refund_list' value='$item[refund_id]'$checked>&nbsp;<b>$item[good_name]</b>, цена: <b>$item[price]</b>, кол-во: <b>$item[number]</b></label><br>";
                    }
                    $result .= "<br><input type='submit' name='go_edit_refund_form' value='Выбрать'>";
                }
            }
            else $result .= "<p class='mx-0' style='color: #680425;'>Введите дату продажи</p>";
            $result .= $this->editRefundForm() . "</form>";
        }
        return $result;
    }

    public function checkRefundDate(){
        if(isset($_POST['refund_date_submit'])){
            if($_POST['retail_date_value']!=''&&strtotime($_POST['retail_date_value'])!=0){
                require 'project/config/connection.php';
                $time_from = date('Y-m-d H:i:s',strtotime($_POST['retail_date_value']));
                $time_to = date('Y-m-d H:i:s',strtotime($time_from)+(3600*24));
                $query = "SELECT id FROM refund WHERE date>='$time_from' AND date<'$time_to' ORDER BY date ASC";
                $obj_refund = mysqli_query($link,$query) or die(mysqli_error($link));
                for($arr_refund=[];$row=mysqli_fetch_assoc($obj_refund);$arr_refund[]=$row);
                if(empty($arr_refund)){
                    $date = date('d.m.Y', strtotime($_POST['retail_date_value']));
                    return "<p class='mx-0' style='color: #680425;'>Ошибка. Возвратов за $date г. не было. Введите другую дату</p>";
                }
                else return "";
            }
            else return "<p style='color: #680425;' class='mx-0'>Введите дату возврата</p>";
        }
        else return "";
    }

    public function editRefundForm(){
        $result = "";
        if(isset($_POST['go_edit_refund_form'])||isset($_POST['edit_refund'])||isset($_POST['delete_refund'])){
            if(isset($_POST['edit_refund_list'])){
                require 'project/config/connection.php';
                $query = "SELECT refund.id as refund_id, refund.date, refund.price, refund.number, refund.good_id, catalog.id as catalog_id, catalog.good_name FROM refund LEFT JOIN catalog on refund.good_id=catalog.id WHERE refund.id='$_POST[edit_refund_list]'";
                $obj_refund = mysqli_query($link,$query) or die(mysqli_error($link));
                $refund = mysqli_fetch_assoc($obj_refund);

                $date = date('Y-m-d',strtotime($refund['date']));
                $result .= "<br><br><p class='mx-0'>Корректировка возврата товара <b>$refund[good_name]<input type='hidden' name='refund_id' value='$refund[refund_id]'></b> от <b>".date('d.m.Y',strtotime($refund['date']))."</b> г. Кол-во: <b>$refund[number]</b></p><table style='width: 100%;'><tr style='width: 100%;'><td style='text-align: center; width: 45%;'>Наименование товара</td><td style='text-align: center; width: 12%;'>Дата возврата</td><td style='text-align: center; width: 10%;'>Цена</td><td style='text-align: center; width: 5%;'>Кол-во</td><td colspan='2' style='text-align: center; width: 28%;'>Действие</td></tr>
                            <tr><td style='width: 45%;'>&nbsp;$refund[good_name]&nbsp;</td><td style='width: 12%;'><input type='hidden' name='hidden_refund_date' value='$refund[date]'><input type='date' name='refund_date' value='$date'></td>
                            <td style='width: 10%;'><input type='hidden' name='hidden_refund_price' value='$refund[price]'>&nbsp;$refund[price]&nbsp;</td><td style='width: 5%;'><input style='width: 100%;' type='text' name='refund_number' value='$refund[number]'></td>
                            <td style='width: 14%; text-align: center;'><input type='submit' name='edit_refund' value='Изменить'></td><td style='width: 14%; text-align: center;'><input type='submit' name='delete_refund' value='Удалить'></td></tr></table>".$this->editRefund().$this->deleteRefund();
            }
            else $result .= "<p class='mx-0' style='color: #680425;'>Вы не выбрали ни одного из предложенных вариантов возврата. Попробуйте снова</p>";
        }
        return $result;
    }

    /*public function editRefundGoodList($var){
        require 'project/config/connection.php';
        $query = "SELECT id, good_name FROM catalog ORDER BY good_name ASC";
        $obj_good = mysqli_query($link,$query) or die(mysqli_error($link));
        for($arr_good=[];$row=mysqli_fetch_assoc($obj_good);$arr_good[]=$row);
        $good_list = "<select style='width: 100%;' name='edit_refund_good'>";
        foreach($arr_good as $item){
            $selected = "";
            if($item['id']==$var){
                $selected .= " selected";
            }
            $good_list .= "<option value='$item[id]'$selected>$item[good_name]</option>";
        }
        $good_list .= "<select>";
        return $good_list;
    }*/

    public function deleteRetail(){
        if(isset($_POST['delete_retail'])&&$_POST['delete_retail']=='Удалить'){
            require 'project/config/connection.php';
            $query = "DELETE FROM retail WHERE id='$_GET[id]'";
            mysqli_query($link,$query) or die(mysqli_error($link));
            header("Location: /sales");
        }
        else return "";
    }

    public function editRefund(){
        if(isset($_POST['edit_refund'])){
            if($_POST['refund_number']!=''&&$_POST['refund_number']>0){
                if($_POST['refund_date']!=''&&strtotime($_POST['refund_date'])!=0){
                    require 'project/config/connection.php';
                    if(date('Y-m-d',strtotime($_POST['hidden_refund_date']))==$_POST['refund_date']){
                        $date = $_POST['hidden_refund_date'];
                    }
                    else $date = $_POST['refund_date'];
                    $query = "UPDATE refund SET number='$_POST[refund_number]', date='$date' WHERE id='$_POST[refund_id]'";
                    mysqli_query($link,$query) or die(mysqli_error($link));
                    header("Location: /sales");
                }
                else return "<p class='mx-0' style='color: #680425;'>Введите дату возврата</p>";
            }
            else return "<p class='mx-0' style='color: #680425;'>Введите количество товара для возврата, его значение должно быть больше нуля</p>";
        }
        else return "";
    }

    public function deleteRefund(){
        if(isset($_POST['delete_refund'])){
            require 'project/config/connection.php';
            $query = "DELETE FROM refund WHERE id='$_POST[refund_id]'";
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

    public  function addOutcomingInvoices(){
        if(isset($_POST['add_outcoming_invoices'])){
            $message = "";
            if($_POST['doc_number']!=''&&$_POST['doc_date']!=''&&$_POST['find_supplier']!=''&&$_POST['sale_basis']!=''&&$_POST['loading_point']!=''&&$_POST['unloading_point']!=''
                &&$_POST['passed']!=''&&$_POST['accepted']!=''){
                if(isset($_POST['partner'])&&$_POST['partner']!=''){
                    require 'project/config/connection.php';
                    $query = "INSERT INTO outcoming_invoices SET 
                            doc_number='$_POST[doc_number]',
                               doc_date='$_POST[doc_date]',
                               partner='$_POST[partner]',
                               car='$_POST[car]',
                               trailer='$_POST[trailer]',
                               waybill='$_POST[waybill]',
                               driver='$_POST[driver]',
                               transportation_customer='$_POST[transportation_customer]',
                               sale_basis='$_POST[sale_basis]',
                               loading_point='$_POST[loading_point]',
                               unloading_point='$_POST[unloading_point]',
                               readdressing='$_POST[readdressing]',
                               cargo_weight='$_POST[cargo_weight]',
                               cargo_spaces_number='$_POST[cargo_spaces_number]',
                               sale_allowed='$_POST[sale_allowed]',
                               passed='$_POST[passed]',
                               passed_seal_number='$_POST[passed_seal_number]',
                               accepted_to_transport='$_POST[accepted_to_transport]',
                               attorney_number='$_POST[attorney_number]',
                               attorney_date='$_POST[attorney_date]',
                               attorney_organization='$_POST[attorney_organization]',
                               accepted='$_POST[accepted]',
                               accepted_seal_number='$_POST[accepted_seal_number]'";
                    mysqli_query($link,$query) or die(mysqli_error($link));
                    $last_id = mysqli_insert_id($link);
                    header("Location: /sales/wholesale?id=$last_id");
                }
                else $message = "<p>Выполните поиск покупателя и выберите его</p>";
            }
            else $message = "<p>Заполните все поля, отмеченные звёздочками</p>";
            echo $message;
        }
        else return "";
    }

    public function wholesaleForm(){
        if(isset($_GET['id'])){
            require 'project/config/connection.php';
            $query="SELECT doc_number, doc_date FROM outcoming_invoices WHERE id='$_GET[id]'";
            $obj_ttn = mysqli_query($link,$query) or die(mysqli_error($link));
            $ttn = mysqli_fetch_assoc($obj_ttn);
            $date = date('d.m.Y',strtotime($ttn['doc_date']));
            $query = "SELECT partners.partner_name FROM partners LEFT JOIN outcoming_invoices ON partners.id=outcoming_invoices.partner WHERE outcoming_invoices.id='$_GET[id]'";
            $obj_partner = mysqli_query($link,$query) or die(mysqli_error($link));
            $arr_partner = mysqli_fetch_assoc($obj_partner);
            $result = "<p>Заполнение товара по ТТН № <b>$ttn[doc_number]</b> от <b>$date</b> г. Поставщик: <b>$arr_partner[partner_name]</b></p>";
            $query = "SELECT wholesale.id as wholesale_id, wholesale.ttn_id, wholesale.good_id, wholesale.measure_unit, wholesale.number, wholesale.price, wholesale.vat_rate, wholesale.cargo_spaces_number, wholesale.cargo_weight, wholesale.note, catalog.id as catalog_id, catalog.good_name FROM wholesale LEFT JOIN catalog ON catalog.id=wholesale.good_id WHERE wholesale.ttn_id='$_GET[id]'";
            $obj_goods = mysqli_query($link,$query) or die(mysqli_error($link));
            for($goods=[];$row=mysqli_fetch_assoc($obj_goods);$goods[]=$row);
            $result .= "<form class='mx-4' method='POST' action=''><table class='ttn_goods_list'>";
            $result .= "<tr><td class='first'>Наименование товара</td><td class='second'>Ед. изм.</td><td class='third'>Кол-во</td><td class='fourth'>Цена, руб.</td><td class='fifth'>Стоимость, руб.</td><td class='sixth'>Ставка НДС, %</td><td class='seventh'>Сумма НДС, руб.</td><td class='eighth'>Стоимость с НДС, руб.</td><td class='ninth'>Кол-во грузовых мест</td><td class='tenth'>Масса груза</td><td class='eleventh'>Примечание</td><td class='twelfth'>Действие</td></tr>
                            <tr><td class='first'>1*</td><td class='second'>2*</td><td class='third'>3*</td><td class='fourth'>4*</td><td class='fifth'>5</td><td class='sixth'>6*</td><td class='seventh'>7</td><td class='eighth'>8</td><td class='ninth'>9</td><td class='tenth'>10</td><td class='eleventh'>11</td><td class='twelfth'>12</td></tr>";
            if(!empty($goods)){
                foreach($goods as $item){
                    $result .= "<tr><td class='first' style='text-align: left;'>$item[good_name]</td><td class='second'>$item[measure_unit]</td><td class='third'>$item[number]</td><td class='fourth'>$item[price]</td><td class='fifth'>".$item['number']*$item['price']."</td><td class='sixth'>$item[vat_rate]</td><td class='seventh'>".round((($item['vat_rate']*$item['number']*$item['price'])/100),2)."</td>
                                <td class='eighth'>".round(($item['number']*$item['price'])+(($item['vat_rate']*$item['number']*$item['price'])/100),2)."</td><td class='ninth'>$item[cargo_spaces_number]</td><td class='tenth'>$item[cargo_weight]</td><td class='eleventh'>$item[note]</td><td class='twelfth'><input type='submit' name='delete_good_from_wholesale$item[wholesale_id]' value='Удалить'><input type='hidden' name='wholesale_ttn_id' value='$_GET[id]'></td></tr>";
                }
            }
            $result .= "<tr><td class='first' style='text-align: left;'>".$this->goodList()."<input type='hidden' name='ttn_id' value='$_GET[id]'></td><td class='second'><input type='text' name='measure_unit' value=''></td><td class='third'><input type='text' name='number' value=''></td><td class='fourth'><input type='text' name='price' value=''></td>
                        <td class='fifth'></td><td class='sixth'><select name='vat_rate'><option value='20'>20</option><option value='10'>10</option><option value='25'>25</option></select></td><td class='seventh'></td><td class='eighth'></td><td class='ninth'><input type='text' name='cargo_spaces_number' value=''></td><td class='tenth'><input type='text' name='cargo_weight' value=''></td><td class='eleventh'><input type='text' name='note' value=''></td><td class='twelfth'><input type='submit' name='add_wholesale_good' value='Сохранить'></td></tr>";
            $result .= "</table><br><input type='submit' name='add_receipt_good' value='Сохранить последнюю строку'>&nbsp;&nbsp;&nbsp;<a style='color: black;' href='/sales'>Выход</a></form>";
        }
        else $result = "";
        return $result;
    }

    public function deleteGoodFromWholesale(){
        if(isset($_POST['wholesale_ttn_id'])){
            require 'project/config/connection.php';
            $query = "SELECT id FROM good_wholesale WHERE ttn_id='$_POST[ttn_id]'";
            $obj_goods = mysqli_query($link,$query) or die(mysqli_error($link));
            for($arr_goods=[];$row=mysqli_fetch_assoc($obj_goods);$arr_goods[]=$row);
            if(!empty($arr_goods)){
                foreach ($arr_goods as $item){
                    if(isset($_POST['delete_good_from_wholesale'.$item['id']])){
                        $query = "DELETE FROM good_wholesale WHERE id='$item[id]'";
                        mysqli_query($link,$query) or die(mysqli_error($link));
                        header("Location: /storage/wholesale?id=$_POST[ttn_id]");
                    }
                }
            }
        }
        else return "";
    }

    public function wholesale(){
        if(isset($_POST['add_wholesale_good'])){
            $message = "";
            if($_POST['good_id']!=0&&$_POST['measure_unit']!=''&&$_POST['number']!=''&&$_POST['price']!=''&&$_POST['vat_rate']!=''){
                if(preg_match('#,#',$_POST['price'])!=1){
                    require 'project/config/connection.php';
                    $query = "INSERT INTO wholesale SET ttn_id='$_POST[ttn_id]', good_id='$_POST[good_id]', measure_unit='$_POST[measure_unit]', number='$_POST[number]', price='$_POST[price]', 
                vat_rate='$_POST[vat_rate]', cargo_spaces_number='$_POST[cargo_spaces_number]', cargo_weight='$_POST[cargo_weight]', note='$_POST[note]'";
                    mysqli_query($link,$query) or die(mysqli_error($link));
                    header("Location: /sales/wholesale?id=$_GET[id]");
                }
                else $message = "<p>Используйте символ 'точка' в качестве разделителя целой и дробной части в поле 'ЦЕНА'</p>";
            }
            else $message .= "<p>Заполните все поля, отмеченные звёздочками</p>";
            echo $message;
        }
        else return "";
    }
}