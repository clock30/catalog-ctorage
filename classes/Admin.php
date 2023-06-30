<?php
namespace classes;
class Admin extends Page
{
    public function __get($property){
        return $property;
    }

    public function addCathegoryForm(){
        return "<form class='mx-4' method='POST'  action=''>
                    <label>Наименование новой категории*:<br><input type='text' name='cathegory_name' size='100' value='{{echoCathegoryName}}'></label><br><br>
                    <label>Выберите родительскую категорию для новой категории*:<br>".$this->selectParentCathegoryList()."</label><br><br>
                    <input type='submit' name='add_cathegory' value='Добавить категорию'>&nbsp;&nbsp;&nbsp;<a style='color: black;' href='/admin/add-cathegory'>Очистить форму</a>
                </form>";
    }

    public function editCathegoryForm(){
        $result = "<form class='mx-4' method='POST'  action=''>
                    <label>Наименование редактируемой категории*:<br>{{allCathegoryList}}</label><br><br>
                    <label><input type='checkbox' name='edit_cathegory_name' value='1' {{echoCheckedEditCathegoryName}}>&nbsp;&nbsp;Изменить наименование категории.</label><br><label>Новое наименование редактируемой категории:<br><input type='text' name='new_cathegory_name' size='100' value='{{echoNewCathegoryName}}'></label><br><br>";
        if(!isset($_POST['edit_cathegory_parent'])){
            $result .= "<input type='submit' name='edit_cathegory_parent' value='Изменить родительскую категорию...'><br><br>";;
        }
        if(isset($_POST['edit_cathegory_parent']) && !isset($_POST['cancel_edit_cathegory_parent']) && isset($_POST['all_cathegory_list'])){
            if($_POST['all_cathegory_list'] != ''){
                $result .= $this->selectEditParentCathegoryList($_POST['all_cathegory_list'])."&nbsp;&nbsp;&nbsp;<input type='submit' name='cancel_edit_cathegory_parent' value='Отмена'><br><br>";
            }
            else{$result .= "<input type='submit' name='edit_cathegory_parent' value='Изменить родительскую категорию...'><br>
                            <p class='mx-0'>Введите наименование редактируемой категории</p><br>";}
        }

        $result .= "<input type='submit' name='edit_cathegory' value='Редактировать категорию'>&nbsp;&nbsp;&nbsp;<a style='color: black;' href='/admin/edit-cathegory'>Очистить форму</a>
                </form>";
        return $result;
    }

    public function changeCathegoryForm(){
        $result = "<form method='POST' action='' class='mx-4'>
                        <label>Выберите категорию, <b>из которой</b> необходимо переместить всю группу товаров*:<br>".$this->selectChangeCathegoryList()."</label><br><br>
                        <label>Выберите категорию, <b>в которую</b> необходимо переместить всю группу товаров*:<br>".$this->cathegoryList()."</label><br><br>
                        <input name='change_cathegory' type='submit' value='Переместить'>&nbsp;&nbsp;&nbsp;<a style='color: black;' href='/admin/change-cathegory'>Очистить форму</a>
                    </form>";
        return $result;
    }

    public function deleteCathegoryForm(){
        $result = "<form method='POST' action='' class='mx-4'>
                        <label>Список доступных для удаления категорий. Выберите категорию, которую необходимо удалить*:<br>".$this->deleteCathegoryList()."</label><br><br>
                        <input name='delete_cathegory' type='submit' value='Удалить'>&nbsp;&nbsp;&nbsp;<a style='color: black;' href='/admin/delete-cathegory'>Очистить форму</a>
                    </form>";
        return $result;
    }

    public function goEditGoodForm(){
        if(isset($_POST['edit_selected_good'])){
            if(isset($_POST['good_to_delete'])) {
                if($this->checkGood($_POST['good_to_delete'])===true){
                    $good = $_POST['good_to_delete'];
                    $parametres = array('id'=>$good);
                    $url = '/admin/edit-good?'.http_build_query($parametres);
                    header("Location: $url");
                }
                else {
                    $_SESSION['edit_good'] = "<p>Выбранный товар был удален ранее</p>";
                    header("Location: /admin/edit-good");
                }
            }
            else {
                $_SESSION['edit_good'] = "<p>Выберите товар для редактирования</p>";
                header("Location: /admin/edit-good");
            }
        }
    }

    public function editGoodForm(){
        $id = $_GET['id'];
        require 'project/config/connection.php';
        $query = "SELECT * FROM catalog WHERE id='$id'";
        $object_edited_good = mysqli_query($link,$query) or die(mysqli_error($link));
        $edited_good = mysqli_fetch_assoc($object_edited_good);
        return "<form class='mx-4' method='POST'  action='/scripts/edit_good.php' enctype='multipart/form-data'>
                <label>Наименование товара*:<br><input type='text' name='edit_good_name' size='100' value='$edited_good[good_name]'><input type='hidden' name='edit_good_id' value='$edited_good[id]'>
                <input type='hidden' name='old_good_name' value='$edited_good[good_name]'></label><br><br>
                <label>Описание товара*:<br><textarea name='edit_good_description' cols='100' rows='4'>$edited_good[description]</textarea></label><br><br>
                <label>Материал:<br><input type='text' name='edit_good_material' size='100' value='$edited_good[material]'></label><br><br>
                <label>Цвет:<br><input type='text' name='edit_good_color' size='50' value='$edited_good[color]'></label><br><br>
                <label>Цена*:<br><input type='text' name='edit_good_price' size='10' value='$edited_good[price]'></label><br><br>
                <label>Категория*:<br>".$this->editGoodSelectCathegory($edited_good['cathegory'])."</label><br><br>
                <label>Фотография:<br><input type='file' name='edit_good_photo'></label><br><br>
                <input type='submit' name='edit_good' value='Внести изменения'>&nbsp;&nbsp;&nbsp;<a style='color: black;' href='/admin/edit-good'>Отмена</a>
            </form>";
    }

    public function editGoodSelectCathegory($edit_good_cathegory){
        require 'project/config/connection.php';
        $query = "SELECT * FROM cathegories";
        $object_cathegories = mysqli_query($link,$query) or die(mysqli_error($link));
        for($array_cathegories=[]; $row=mysqli_fetch_assoc($object_cathegories); $array_cathegories[]=$row);
        if(!empty($array_cathegories)){
            foreach($array_cathegories as $item){
                $all_cathegories[]=$item['id'];
            }
            foreach($array_cathegories as $item){
                $cathegories_is_parent[]=$item['parent'];
            }
            if(!empty($cathegories_is_parent)){
                $cathegories_is_parent = array_unique($cathegories_is_parent);
                foreach ($all_cathegories as $item){
                    if(in_array($item,$cathegories_is_parent)){
                        unset($all_cathegories[array_search($item,$all_cathegories)]);
                    }
                }
            }
            $cathegories = $all_cathegories;
            $result = "<select name='edit_good_select_cathegory'>";
            foreach($array_cathegories as $item){
                if(in_array($item['id'],$cathegories)){
                    if($item['id']==$edit_good_cathegory){
                        $result .= "<option value='$item[id]' selected>$item[cathegory_name]</option>";
                    }
                    else $result .= "<option value='$item[id]'>$item[cathegory_name]</option>";
                }
            }
            $result .= "</select>";
        }
        else $result = "";
        return $result;
    }

    public function editedGood(){
        $id = $_GET['id'];
        require 'project/config/connection.php';
        $query = "SELECT good_name FROM catalog WHERE id='$id'";
        $object_edited_good = mysqli_query($link,$query) or die(mysqli_error($link));
        $edited_good = mysqli_fetch_assoc($object_edited_good);
        return $edited_good['good_name'];
    }

    public function selectEditParentCathegoryList($cathegory){//Получение списка допустимых родительских категорий для $cathegory. Для editCathegoryForm() (для функции editCathegory())
        require 'project/config/connection.php';
        $query = "SELECT cathegory FROM catalog";
        $cathegories = mysqli_query($link,$query) or die(mysqli_error($link));
        for($data=[];$row=mysqli_fetch_assoc($cathegories);$data[]=$row);
        foreach($data as $item){
            $good_caths[] = $item['cathegory'];
        }
        $good_caths = array_unique($good_caths);//Категории, в которые добавлены товары
        $query = "SELECT * FROM cathegories";
        $cathegories = mysqli_query($link,$query) or die(mysqli_error($link));
        for($data=[];$row=mysqli_fetch_assoc($cathegories);$data[]=$row);
        foreach($data as $item){
            $all_caths[] = $item['id'];
        }
        $caths_nogoods=array_diff($all_caths,$good_caths);//Категории, в которые не добавлены товары

        $this->sonCathegoryList($ccccc,$cathegory);
        if(!empty($ccccc)){//Удаление категорий, для которых $cathegory является родителем, прародителем,...
            foreach($ccccc as $item){
                if(in_array($item,$caths_nogoods)){
                    unset($caths_nogoods[array_search($item,$caths_nogoods)]);
                }
            }
        }

        $caths = $caths_nogoods;
        unset($caths[array_search($cathegory,$caths)]);

        if(empty($caths)){
            $query = "SELECT cathegory_name FROM cathegories WHERE id='$cathegory'";
            $res = mysqli_query($link,$query) or die(mysqli_error($link));
            $data = mysqli_fetch_assoc($res);
            $result = "<p>Родительская категория для категории <b>$data[cathegory_name]</b> не может быть изменена</p>";
        }
        else{
            $query = "SELECT * FROM cathegories WHERE id IN (".implode(',',array_map('intval',$caths)).")";
            $caths_data = mysqli_query($link,$query) or die(mysqli_error($link));
            for($data=[];$row=mysqli_fetch_assoc($caths_data);$data[]=$row);
            $result = "<select name='select_cathegory_list'><option value='0' selected>Нет родительской категории</option>";
            foreach($data as $item){
                if(isset($_POST['select_cathegory_list'])){
                    if($_POST['select_cathegory_list']==$item['id']){
                        $selected = ' selected';
                    }
                    else $selected = '';
                }
                else $selected = '';
                $result .= "<option value='$item[id]'$selected>$item[cathegory_name]</option>";
            }
            $result .= "</select>";
        }
        return $result;
    }

    public function sonCathegoryList(&$array_cathegories,$cathegory){
        require "project/config/connection.php";
        $query = "SELECT id FROM cathegories WHERE parent='$cathegory'";
        $result = mysqli_query($link,$query) or die(mysqli_error($link));
        for($data=[];$row=mysqli_fetch_assoc($result);$data[]=$row);
        if(!empty($data)){
            foreach($data as $item){
                $array_cathegories[] = $item['id'];
                $this->sonCathegoryList($array_cathegories, $item['id']);
            }
        }
    }

    public function echoCathegoryName(){
        if(isset($_POST['cathegory_name'])){
            return $_POST['cathegory_name'];
        }
        else return '';
    }

    public function echoNewCathegoryName(){
        if(isset($_POST['new_cathegory_name'])){
            return $_POST['new_cathegory_name'];
        }
        else return '';
    }

    public function echoCheckedEditCathegoryName(){
        $result = '';
        if(isset($_POST['edit_cathegory_name'])){
            if($_POST['edit_cathegory_name']==1){
                $result .= 'checked';
            }
            else $result .= '';
        }
        return $result;
    }

    public function allCathegoryList(){//Выводит список всех категори товаров с атрибутом selected той категории, кот. была отправлена в POST-запросе
        $result = "<select name='all_cathegory_list'><option value=''>Выберите категорию...</option>";
        require 'project/config/connection.php';
        $query = "SELECT * FROM cathegories";
        $cathegories = mysqli_query($link,$query) or die(mysqli_error($link));
        for($data=[];$row=mysqli_fetch_assoc($cathegories);$data[]=$row);
        foreach($data as $item){
            if(isset($_POST['all_cathegory_list'])){
                if($_POST['all_cathegory_list']==$item['id']){
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

    public function cathegoryList(){//Выводит список категорий, кот. не яляются родительскими для других категорий с атрибутом selected той категории, кот. была отправлена в POST-запросе
        $result = "<select name='cathegory_list'><option value=''>Выберите категорию...</option>";
        require 'project/config/connection.php';
        $query = "SELECT * FROM cathegories";
        $cathegories = mysqli_query($link,$query) or die(mysqli_error($link));
        for($data=[];$row=mysqli_fetch_assoc($cathegories);$data[]=$row);
        foreach($data as $item){
            $query = "SELECT * FROM cathegories WHERE parent='$item[id]'";
            $caths = mysqli_query($link,$query) or die(mysqli_error($link));
            for($data2=[];$row=mysqli_fetch_assoc($caths);$data2[]=$row);
            if(empty($data2)){
                if(isset($_POST['cathegory_list'])){
                    if($_POST['cathegory_list']==$item['id']){
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

    public function selectParentCathegoryList(){//Выводит список категорий, в кот. не добавлены товары с атрибутом selected той категории, кот. была отправлена в POST-запросе
        $result = "<select name='select_cathegory_list'><option value='0' selected>Нет родительской категории</option>";
        require 'project/config/connection.php';
        $query = "SELECT cathegory FROM catalog";
        $cathegories = mysqli_query($link,$query) or die(mysqli_error($link));
        for($data=[];$row=mysqli_fetch_assoc($cathegories);$data[]=$row);
        foreach($data as $item){
            $good_caths[] = $item['cathegory'];
        }
        $good_caths = array_unique($good_caths);//Категории, в которые добавлены товары
        $query = "SELECT * FROM cathegories";
        $cathegories = mysqli_query($link,$query) or die(mysqli_error($link));
        for($data=[];$row=mysqli_fetch_assoc($cathegories);$data[]=$row);
        foreach($data as $item){
            $all_caths[] = $item['id'];
        }
        $caths=array_diff($all_caths,$good_caths);//Категории, в которые не добавлены товары
        $query = "SELECT * FROM cathegories WHERE id IN (".implode(',',array_map('intval',$caths)).")";
        $caths_data = mysqli_query($link,$query) or die(mysqli_error($link));
        for($data=[];$row=mysqli_fetch_assoc($caths_data);$data[]=$row);
        foreach($data as $item){
            if(isset($_POST['select_cathegory_list'])){
                if($_POST['select_cathegory_list']==$item['id']){
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

    public function deleteCathegoryList(){
        require 'project/config/connection.php';
        $query = "SELECT id, parent FROM cathegories";
        $array = mysqli_query($link,$query) or die(mysqli_error($link));
        for($data=[];$row=mysqli_fetch_assoc($array);$data[]=$row);
        $arr_all_cathegories=[];
        $arr_parent_cathegories=[];
        foreach($data as $item){
            $arr_all_cathegories[] = $item['id'];
            $arr_parent_cathegories[] = $item['parent'];
        }
        $arr_parent_cathegories = array_unique($arr_parent_cathegories);
        $not_parent_caths = [];
        foreach($arr_all_cathegories as $item){
            if(!in_array($item,$arr_parent_cathegories)){
                $not_parent_caths[] = $item;
            }
        }
        $not_parent_no_goods_caths = [];
        foreach($not_parent_caths as $item){
            $query = "SELECT id FROM catalog WHERE cathegory='$item'";
            $array2 = mysqli_query($link,$query) or die(mysqli_error($link));
            for($data2=[];$row=mysqli_fetch_assoc($array2);$data2[]=$row);
            if(empty($data2)){
                $not_parent_no_goods_caths[]=$item;
            }
        }
        $query ="SELECT * FROM cathegories WHERE id IN (".implode(',',array_map('intval',$not_parent_no_goods_caths)).")";
        $not_parent_no_goods_caths_list = mysqli_query($link,$query) or die(mysqli_error($link));
        for($data3=[];$row=mysqli_fetch_assoc($not_parent_no_goods_caths_list);$data3[]=$row);
        $result = '';
        if(!empty($data3)){
            $result .= "<select name='delete_cathegory_list'><option value=''>Выберите категорию...</option>";
            foreach($data3 as $item){
                $result .= "<option value='$item[id]'>$item[cathegory_name]</option>";
            }
            $result .= "</select>";
        }
        else{
            $result .= "<p>В данный момент нет категорий, которые можно удалять</p>";
        }
        return $result;
    }

    public function checkParentCathegory($cathegory, $parent_cathegory){//Проверяет, м.б. или нет $parent_cathegory родителем для $cathegory. Для ф-ии editCathegory()
        $bbbbb = [];
        require 'project/config/connection.php';
        $query = "SELECT id FROM cathegories WHERE id='$cathegory'";
        $result = mysqli_query($link,$query) or die(mysqli_error($link));
        $data = mysqli_fetch_assoc($result);
        $query = "SELECT id FROM cathegories WHERE id='$parent_cathegory'";
        $result2 = mysqli_query($link,$query) or die(mysqli_error($link));
        $data2 = mysqli_fetch_assoc($result2);
        if(!empty($data)&&!empty($data2)){
            $this->sonCathegoryList($bbbbb,$cathegory);
            if(in_array($parent_cathegory,$bbbbb)){
                return false;
            }
            else return true;
        }
        else return false;
    }

    public function checkGood($good){
        require "project/config/connection.php";
        $query = "SELECT id FROM catalog WHERE id='$good'";
        $object_good = mysqli_query($link,$query) or die(mysqli_error($link));
        $data = mysqli_fetch_assoc($object_good);
        if(!empty($data)){
            return true;
        }
        else return false;
    }

    public function addCathegory(){
        if(isset($_POST['add_cathegory'])){
            $message = '';
            if($_POST['cathegory_name']!=''){
                require 'project/config/connection.php';
                $cathegory_alias = $this->transLit($_POST['cathegory_name']);
                if($this->checkCathegory($_POST['cathegory_name'])===true){
                    $query = "SELECT id FROM catalog WHERE cathegory='$_POST[select_cathegory_list]'";
                    $res = mysqli_query($link,$query) or die(mysqli_error($link));
                    for($dat=[];$row=mysqli_fetch_assoc($res);$dat[]=$row);
                    if(empty($dat)){
                        $query = "SELECT id FROM cathegories WHERE id='$_POST[select_cathegory_list]'";
                        $result = mysqli_query($link,$query) or die(mysqli_error($link));
                        $data = mysqli_fetch_assoc($result);
                        if (!empty($data)||$_POST['select_cathegory_list']==0){
                            $query = "INSERT INTO cathegories SET cathegory_name='$_POST[cathegory_name]', cathegory_alias='$cathegory_alias',
                        parent='$_POST[select_cathegory_list]'";
                            mysqli_query($link,$query) or die(mysqli_error($link));
                            $message .= "<p>Добавлена новая категория <b>".$_POST['cathegory_name']."</b></p>";
                        }
                        else $message .= "<p>Родительская категория, выбранная для создаваемой категории товаров <b>$_POST[cathegory_name]</b> была удалена</p>";
                    }
                    else $message .= "<p>Категория, выбранная в качестве родительской для создаваемой категории товаров <b>$_POST[cathegory_name]</b>, уже содержит группу товаров
                                        и не может быть родительской для других категорий</p>";
                }
                else{
                    $message .= "<p>Категория <b>".$_POST['cathegory_name']."</b> не может быть добавлена, категория с таким именем уже существует</p>";
                }
            }
            else {$message .= "<p>Вы не ввели наименование новой категории</p>";}
            $_SESSION['add_cathegory'] = $message;
            header("Location: /admin/add-cathegory");
        }
    }

    public function editCathegory(){
        if(isset($_POST['edit_cathegory'])){
            $message = '';
            if(isset($_POST['all_cathegory_list']) && $_POST['all_cathegory_list']!=''){
                require 'project/config/connection.php';
                $query = "SELECT * FROM cathegories WHERE id='$_POST[all_cathegory_list]'";
                $result = mysqli_query($link,$query) or die(mysqli_error($link));
                $data = mysqli_fetch_assoc($result);
                if(!empty($data)){
                    $edit_cathegory = $data['cathegory_name'];
                    if (isset($_POST['new_cathegory_name']) && isset($_POST['edit_cathegory_name'])){
                        if($_POST['edit_cathegory_name']==1){
                            if($_POST['new_cathegory_name'] != '') {
                                if($this->checkCathegory($_POST['new_cathegory_name'])===true){
                                    $cathegory_alias = $this->transLit($_POST['new_cathegory_name']);
                                    $query = "UPDATE cathegories SET cathegory_name='$_POST[new_cathegory_name]', cathegory_alias='$cathegory_alias' WHERE id='$data[id]'";
                                    mysqli_query($link, $query) or die(mysqli_error($link));
                                    $message .= "<p>Название категории <b>$edit_cathegory</b> изменено на <b>$_POST[new_cathegory_name]</b>";
                                }
                                else $message = "<p>Название категории <b>$edit_cathegory</b> не может быть изменено на <b>".$_POST['new_cathegory_name']."</b>, категория с именем <b>".$_POST['new_cathegory_name']."</b> уже существует</p>";
                            }
                            else $message .= "<p>Введите новое название редактируемой категории";
                        }
                    }

                    if (isset($_POST['select_cathegory_list'])){
                        if($_POST['select_cathegory_list'] != ''){
                            $query = "SELECT * FROM cathegories WHERE id='$_POST[select_cathegory_list]'";
                            $result = mysqli_query($link,$query) or die(mysqli_error($link));
                            $data2 = mysqli_fetch_assoc($result);
                            if($this->checkParentCathegory($_POST['all_cathegory_list'],$_POST['select_cathegory_list'])===true){
                                $query = "UPDATE cathegories SET parent='$_POST[select_cathegory_list]' WHERE id='$data[id]'";
                                mysqli_query($link, $query) or die(mysqli_error($link));
                                if($message==''){
                                    $message .= "<p>Для категории <b>$edit_cathegory</b> установлена родительская категория <b>$data2[cathegory_name]</b>";
                                }
                                else{
                                    $message .= " и установлена родительская категория <b>$data2[cathegory_name]</b>";
                                }
                            }
                            else {
                                if($message == ''){
                                    $message .= "<p>Для категории <b>$edit_cathegory</b> не может быть установлена родительская категория <b>$data2[cathegory_name]</b>,
                                        т.к. категория <b>$edit_cathegory</b> сама является родительской для категории <b>$data2[cathegory_name]</b>";
                                }
                                else  $message .= ". Для категории <b>$edit_cathegory</b> не может быть установлена родительская категория <b>$data2[cathegory_name]</b>,
                                        т.к. категория <b>$edit_cathegory</b> сама является родительской для категории <b>$data2[cathegory_name]</b>";
                            }
                        }
                        else $message .= "<p>Выберите новую родительскую категорию для редактируемой категории или нажмите ОТМЕНА";

                    }
                    if(!isset($_POST['edit_cathegory_name']) && !isset($_POST['select_cathegory_list'])){
                        $message .= '<p>Вы не ввели новые данные для редактируемой категории';
                    }
                }
                else $message .= "<p>Редактируемая категория была удалена";
            }
            else {
                $message .= '<p>Выберите категорию для редактирования';
            }
            $message .= "</p>";
            $_SESSION['edit_cathegory'] = $message;
            header("Location: /admin/edit-cathegory");
        }
    }

    public function changeCathegory(){
        if(isset($_POST['change_cathegory'])){
            if($_POST['select_change_cathegory_list']!='' && $_POST['cathegory_list']!=''){
                require "project/config/connection.php";
                $query="SELECT id FROM cathegories WHERE id='$_POST[cathegory_list]'";
                $result = mysqli_query($link,$query) or die(mysqli_error($link));
                $data = mysqli_fetch_assoc($result);
                $query="SELECT id FROM cathegories WHERE id='$_POST[select_change_cathegory_list]'";
                $result2 = mysqli_query($link,$query) or die(mysqli_error($link));
                $data2 = mysqli_fetch_assoc($result2);
                if(!empty($data)&&!empty($data2)){
                    if($_POST['select_change_cathegory_list']!=$_POST['cathegory_list']){
                        $query = "UPDATE catalog SET cathegory='$_POST[cathegory_list]' WHERE cathegory='$_POST[select_change_cathegory_list]'";
                        mysqli_query($link,$query) or die(mysqli_error($link));
                        $query = "SELECT cathegory_name FROM cathegories WHERE id='$_POST[select_change_cathegory_list]'";
                        $result = mysqli_query($link,$query) or die(mysqli_error($link));
                        $cathegory_from = mysqli_fetch_assoc($result);
                        $query = "SELECT cathegory_name FROM cathegories WHERE id='$_POST[cathegory_list]'";
                        $result = mysqli_query($link,$query) or die(mysqli_error($link));
                        $cathegory_to = mysqli_fetch_assoc($result);
                        $message = "<p>Вся группа товаров перемещена из категории <b>$cathegory_from[cathegory_name]</b> в категорию <b>$cathegory_to[cathegory_name]</b></p>";
                    }
                    else $message = "<p>Категория, в которую Вы перемещаете группу товаров, не должна совпадать с исходний категорией</p>";
                }
                else $message = "<p>Одна или обе введенные категории были удалены</p>";
            }
            else {
                $message = "<p>Заполните все поля, отмеченные звёздочками</p>";
            }
            $_SESSION['change_cathegory'] = $message;
            header("Location: /admin/change-cathegory");
        }
    }

    public function deleteCathegory(){
        if(isset($_POST['delete_cathegory'])){
            if($_POST['delete_cathegory_list']!=''){
                require 'project/config/connection.php';
                $query = "SELECT cathegory_name FROM cathegories WHERE id='$_POST[delete_cathegory_list]'";
                $result = mysqli_query($link,$query) or die(mysqli_error($link));
                $data = mysqli_fetch_assoc($result);
                if(!empty($data)){
                    $deleted_cathegory = $data['cathegory_name'];
                    $query = "SELECT id FROM catalog WHERE cathegory='$_POST[delete_cathegory_list]'";
                    $result2 = mysqli_query($link,$query) or die(mysqli_error($link));
                    for($data2=[];$row=mysqli_fetch_assoc($result2);$data2[]=$row);
                    if(empty($data2)){
                        $query = "DELETE FROM cathegories WHERE id='$_POST[delete_cathegory_list]'";
                        mysqli_query($link,$query) or die(mysqli_error($link));
                        $message = "<p>Категория <b>$deleted_cathegory</b> удалена</p>";
                    }
                    else $message = "<p>Категория <b>$deleted_cathegory</b> содержит группу товаров и не может быть удалена</p>";
                }
                else $message = "<p>Выбранная категория уже была удалена ранее</p>";
            }
            else {
                $message = "<p>Введите наименование категории</p>";
            }
            $_SESSION['delete_cathegory'] = $message;
            header("Location: /admin/delete-cathegory");
        }
    }

    public function deleteGood(){
        if(isset($_POST['delete_selected_good'])){
            $message = "";
            if(isset($_POST['good_to_delete'])){
                if($this->checkGood($_POST['good_to_delete'])===true){
                    require 'project/config/connection.php';
                    $query = "SELECT good_name, picture FROM catalog WHERE id='$_POST[good_to_delete]'";
                    $object_good = mysqli_query($link,$query) or die(mysqli_error($link));
                    $data = mysqli_fetch_assoc($object_good);
                    $query = "DELETE FROM catalog WHERE id='$_POST[good_to_delete]'";
                    mysqli_query($link,$query) or die(mysqli_error($link));
                    if($data['picture']!='no_photo.jpg'&&$data['picture']!=''){
                        unlink('img/goods/'.$data['picture']);
                    }
                    $message = "<p>Товар <b>$data[good_name]</b> удален</p>";
                }
                else $message = "<p>Выбранный товар был удален ранее</p>";
            }
            else $message = "<p>Выберите товар для удаления</p>";
            $_SESSION['delete_good'] = $message;
            header("Location: /admin/delete-good");
        }
    }

    public function echoGoodDescription(){
        if(isset($_POST['good_description'])){
            return $_POST['good_description'];
        }
        return "";
    }

    public function echoGoodMaterial(){
        if(isset($_POST['good_material'])){
            return $_POST['good_material'];
        }
        return "";
    }

    public function echoGoodColor(){
        if(isset($_POST['good_color'])){
            return $_POST['good_color'];
        }
        return "";
    }

    public function echoGoodPrice(){
        if(isset($_POST['good_price'])){
            return $_POST['good_price'];
        }
        return "";
    }

    public function echoGoodPhoto(){
        if(isset($_POST['good_photo'])){
            return $_POST['good_photo'];
        }
        return "";
    }

    public function echoAddInfo(){
        if(isset($_POST['add_info'])){
            return $_POST['add_info'];
        }
        return "";
    }

}