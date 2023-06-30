<?php
namespace classes;
class Partners extends Page
{
    public function echoPartner(){
        if(isset($_POST['partner_name'])){
            return $_POST['partner_name'];
        }
        else return "";
    }
    public function addPartner(){
        if(isset($_POST['add_partner'])){
            $message = "";
            if($_POST['partner_name']!='' && $_POST['partner_address']!='' && $_POST['partner_unp']!=''){
                require 'project/config/connection.php';
                $query = "INSERT INTO partners SET partner_name='$_POST[partner_name]', address='$_POST[partner_address]', unp='$_POST[partner_unp]', payment_account='$_POST[partner_payment_account]'";
                mysqli_query($link,$query) or die(mysqli_error($link));
                $message .= "<p>Добавлен новый контрагент <b>$_POST[partner_name]</b></p>";
                header("Location: /partners");
            }
            else $message .= "<p>Поля, отмеченные звёздочками, обязательны для заполнения</p>";
            $_SESSION['add_partner'] = $message;
            header("Location: /partners/add-partner");
        }
        else return "";
    }

    public function findEditPartnerForm(){
        if(!isset($_GET['id'])){
            $result = "<form class='mx-4' method='POST' action=''>";
            if($_SERVER['REQUEST_URI']=='/partners/edit-partner'){
                $result .= "<p class='mx-0'>Поиск контрагента для редактирования</p>";
            }
            if($_SERVER['REQUEST_URI']=='/partners/delete-partner'){
                $result .= "<p class='mx-0'>Поиск контрагента для удаления</p>";
            }
            $result .= "<label>Полностью или частично введите наименование контрагента*:<br><input type='text' name='partner_name' value='".$this->echoPartner()."' size='30'></label><br><br>";
            if(!isset($_POST['show_edit_partners_list'])){
                $result .= "<input type='submit' name='show_edit_partners_list' value='Поиск'>&nbsp;&nbsp;&nbsp;<a style='color: black;' href='/partners/edit-partner'>Очистить форму</a>";
            }
            else {
                $result .= $this->editPartnersList();
            }
            $result .= "</form>";
        }
        else $result = "";
        return $result;
    }

    public function editPartnersList(){
        $result = "";
        if(isset($_POST['show_edit_partners_list'])){
            if($_POST['partner_name']!=''){
                require "project/config/connection.php";
                $query = "SELECT id, partner_name FROM partners WHERE partner_name LIKE '%$_POST[partner_name]%'";
                $object_partners_list = mysqli_query($link,$query) or die(mysqli_error($link));
                for($partners_list=[];$row = mysqli_fetch_assoc($object_partners_list);$partners_list[]=$row);
                if(!empty($partners_list)){
                    $result .= "<p class='mx-0'>Список контрагентов, соответствующих поисковому запросу:</p>";
                    foreach($partners_list as $item){
                        $result .= "<label><input type='radio' name='edit_partners_list' value='$item[id]'>&nbsp;$item[partner_name]</label><br>";
                    }
                    if($_SERVER['REQUEST_URI']=='/partners/edit-partner'){
                        $result .= "<br><input type='submit' name='show_edit_partner' value='Редактировать выбранного контрагента'>&nbsp;&nbsp;&nbsp;<a style='color: black;' href='/partners/edit-partner'>Отмена</a>";
                    }
                    if($_SERVER['REQUEST_URI']=='/partners/delete-partner'){
                        $result .= "<br><input type='submit' name='show_delete_partner' value='Удалить выбранного контрагента'>&nbsp;&nbsp;&nbsp;<a style='color: black;' href='/partners/delete-partner'>Отмена</a>";
                    }

                }
                else $result .= "<p class='mx-0'>Контрагентов, соответствующих введенному запросу, не найдено. Введите другой поисковый запрос и нажните ПОИСК</p>
                    <input type='submit' name='show_edit_partners_list' value='Поиск'>&nbsp;&nbsp;&nbsp;<a style='color: black;' href='/partners/edit-partner'>Отмена</a>";
            }
            else {
                $result .= "<p class='mx-0'>Введите наименование контрагента и нажмите ПОИСК</p><input type='submit' name='show_edit_partners_list' value='Поиск'>&nbsp;&nbsp;&nbsp;<a style='color: black;' href='/partners/edit-partner'>Отмена</a>";
            }
        }
        return $result;
    }

    public function goEditPartnerForm(){
        $result = "";
        if(isset($_POST['show_edit_partner'])){
            $value = $_POST['edit_partners_list'];
            $parameters = array(
                'id' => $value,
            );
            $url = "/partners/edit-partner?" . http_build_query($parameters);
            header("Location: $url");
        }
        else return $result;
    }

    public function editPartnerForm(){
        $result = "";
        if(isset($_GET['id'])){
            require 'project/config/connection.php';
            $query = "SELECT * FROM partners WHERE id='$_GET[id]'";
            $object_partner = mysqli_query($link,$query) or die(mysqli_error($link));
            $partner = mysqli_fetch_assoc($object_partner);
            $result .= "<form class='mx-4' method='POST' action=''>
                <label>Наименование редактируемого контрагента:<br><input type='text' name='new_partner_name' value='$partner[partner_name]' size='40'></label><br><br>
                <label>Адрес:<br><input type='text' name='new_partner_address' value='$partner[address]' size='40'></label><br><br>
                <label>УНП:<br><input type='text' name='new_partner_unp' value='$partner[unp]' size='13'></label><br><br>
                <label>Расчетный счет:<br><input type='text' name='new_partner_payment_account' value='$partner[payment_account]' size='20'></label><br><br>
                <input type='submit' name='edit_partner' value='Редактировать'>&nbsp;&nbsp;&nbsp;<a style='color: black;' href='/partners/edit-partner'>Отмена</a>
            </form>";
        }
        return $result;
    }

    public function editPartner(){
        if(isset($_POST['edit_partner'])){
            if($this->checkPartner($_POST['new_partner_name']) === true){
                require 'project/config/connection.php';
                $query = "UPDATE partners SET partner_name='$_POST[new_partner_name]', address='$_POST[new_partner_address]', unp='$_POST[new_partner_unp]', payment_account='$_POST[new_partner_payment_account]' WHERE id='$_GET[id]'";
                mysqli_query($link,$query) or die(mysqli_error($link));
                $message = "<p>Контрагент <b>$_POST[new_partner_name]</b> отредактирован</p>";
            }
            else $message = "<p>Контрагент с именем <b>$_POST[new_partner_name]</b> уже существует</p>";
            $_SESSION['edit_partner'] = $message;
            header("Location: /partners/edit-partner");
        }
        else return "";
    }

    public function checkPartner($partner){
        if(isset($_POST['edit_partner'])){
            require 'project/config/connection.php';
            $query = "SELECT partner_name FROM partners WHERE id='$_GET[id]'";
            $obj_partner = mysqli_query($link,$query) or die(mysqli_error($link));
            $arr_partner = mysqli_fetch_assoc($obj_partner);
            if($arr_partner['partner_name']!=$partner){
                $query = "SELECT partner_name FROM partners WHERE partner_name='$partner'";
                $object_partner = mysqli_query($link,$query) or die(mysqli_error($link));
                $array_partner = mysqli_fetch_assoc($object_partner);
                if(empty($array_partner)){
                    return true;
                }
                else return false;
            }
            else return true;
        }
    }

    public function deletePartner(){
        if(isset($_POST['show_delete_partner'])){
            $message = "";
            require 'project/config/connection.php';
            $query = "SELECT partner_name FROM partners WHERE id='$_POST[edit_partners_list]'";
            $obj_partner = mysqli_query($link,$query) or die(mysqli_error($link));
            $partner = mysqli_fetch_assoc($obj_partner);
            if($this->checkDeletePartner($_POST['edit_partners_list'])===true){
                $query = "DELETE FROM partners WHERE id='$_POST[edit_partners_list]'";
                mysqli_query($link,$query) or die(mysqli_error($link));
                $message .= "<p>Контрагент <b>$partner[partner_name]</b> удален</p>";
            }
            else $message .= "<p>Контрагент <b>$partner[partner_name]</b> не может быть удалён, так как с ним имеются трансакции</p>";
            $_SESSION['delete_partner'] = $message;
            header("Location: /partners/delete-partner");
        }
        else return "";
    }

    public function checkDeletePartner($partner){
        require 'project/config/connection.php';
        $query = "SELECT partner FROM incoming_invoices WHERE partner='$partner'";
        $obj_partner = mysqli_query($link,$query) or die(mysqli_error($link));
        for($arr_partner=[]; $row=mysqli_fetch_assoc($obj_partner);$arr_partner[]=$row);
        if(empty($arr_partner)){
            return true;
        }
        else return false;
    }
}