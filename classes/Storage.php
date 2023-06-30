<?php
namespace classes;
class Storage extends Page
{
    public function ttnRequisites(){
        $result = "";
        if(!isset($_POST['add_incoming_voices'])){
            $result .= "<form class='mx-4' method='POST'  action=''>
                        <p class='mx-0'>Реквизиты товарно-транспортной накладной</p>
                        <div class='row my-3 mx-1 p-2' style='border: 1px solid #363434; border-radius: 3px;'>
                            <div class='col-lg-6'>
                                <label>№ ТТН*:&nbsp;<input type='text' name='doc_number' size='15' value='".$this->echoDocNumber('')."'></label><br><br>
                                <label>Дата ТТН*:&nbsp;<input type='date' name='doc_date' size='15' value='".$this->echoDocDate('')."'></label><br><br>
                                ".$this->findSupplier()."<br><br>
                                <label>Автомобиль (марка, государственный номер):<br><input type='text' name='car' size='50' value='".$this->echoCar('')."'></label><br><br>
                                <label>Прицеп (марка, государственный номер):<br><input type='text' name='trailer' size='50' value='".$this->echoTrailer('')."'></label><br><br>
                                <label>Путевой лист №:&nbsp;<input type='text' name='waybill' size='30' value='".$this->echoWaybill('')."'></label><br><br>
                                <label>Водитель:<br><input type='text' name='driver' size='50' value='".$this->echoDriver('')."'></label><br><br>
                                <label>Заказчик перевозки:<br><input type='text' name='transportation_customer' size='50' value='".$this->echoTransportationCustomer('')."'></label><br><br>
                                <label>Основание отпуска*:<br><input type='text' name='sale_basis' size='50' value='".$this->echoSaleBasis('')."'></label><br><br>
                                <label>Пункт погрузки*:<br><input type='text' name='loading_point' size='50' value='".$this->echoLoadingPoint('')."'></label><br><br>
                                <label>Пункт разгрузки*:<br><input type='text' name='unloading_point' size='50' value='".$this->echoUnloadingPoint('')."'></label><br><br>
                            </div>
                            <div class='col-lg-6'>
                                <label>Переадресовка:<br><input type='text' name='readdressing' size='50' value='".$this->echoReaddressing('')."'></label><br><br>
                                <label>Масса груза (прописью):<br><input type='text' name='cargo_weight' size='50' value='".$this->echoCargoWeight('','')."'></label><br><br>
                                <label>Количество грузовых мест (прописью):<br><input type='text' name='cargo_spaces_number' size='50' value='".$this->echoCargoSpacesNumber('','')."'></label><br><br>
                                <label>Отпуск разрешил (должность, ФИО, подпись):<br><input type='text' name='sale_allowed' size='50' value='".$this->echoSaleAllowed('')."'></label><br><br>
                                <label>Сдал грузоотправитель (должность, ФИО, подпись)*:<br><input type='text' name='passed' size='50' value='".$this->echoPassed('')."'></label><br><br>
                                <label>Номер пломбы:&nbsp;<input type='text' name='passed_seal_number' size='30' value='".$this->echoPassedSealNumber('')."'></label><br><br>
                                <label>Товар к перевозке принял (должность, ФИО, подпись):<br><input type='text' name='accepted_to_transport' size='50' value='".$this->echoAcceptedToTransport('')."'></label><br><br>
                                <label>По доверенности (номер):<br><input type='text' name='attorney_number' size='50' value='".$this->echoAttorneyNumber('')."'></label><br><br>
                                <label>По доверенности (дата):<br><input type='text' name='attorney_date' size='50' value='".$this->echoAttorneyDate('')."'></label><br><br>
                                <label>Выданной (наименование организации):<br><input type='text' name='attorney_organization' size='50' value='".$this->echoAttorneyOrganization('')."'></label><br><br>
                                <label>Принял грузополучатель  (должность, ФИО, подпись)*:<br><input type='text' name='accepted' size='50' value='".$this->echoAccepted('')."'></label><br><br>
                                <label>Номер пломбы:&nbsp;<input type='text' name='accepted_seal_number' size='30' value='".$this->echoAcceptedSealNumber('')."'></label><br><br>
                            </div>
                        </div>
                        <input type='submit' name='add_incoming_invoices' value='Перейти к заполнению товара'>&nbsp;&nbsp;&nbsp;<a style='color: black;' href=''/storage'>Очистить форму</a>
                    </form>";
        }
        return $result;
    }

    public  function addIncomingInvoices(){
        if(isset($_POST['add_incoming_invoices'])){
            $message = "";
            if($_POST['doc_number']!=''&&$_POST['doc_date']!=''&&$_POST['find_supplier']!=''&&$_POST['sale_basis']!=''&&$_POST['loading_point']!=''&&$_POST['unloading_point']!=''
            &&$_POST['passed']!=''&&$_POST['accepted']!=''){
                if(isset($_POST['partner'])&&$_POST['partner']!=''){
                    require 'project/config/connection.php';
                    $query = "INSERT INTO incoming_invoices SET 
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
                    header("Location: /storage/receipt-good?id=$last_id");
                }
                else $message = "<p>Выполните поиск поставщика и выберите его</p>";
            }
            else $message = "<p>Заполните все поля, отмеченные звёздочками</p>";
            echo $message;
            $_SESSION['add_incoming_invoices']=$message;
        }
        else return "";
    }

    public function receiptGoodForm(){
        if(isset($_GET['id'])){
            require 'project/config/connection.php';
            $query="SELECT doc_number, doc_date FROM incoming_invoices WHERE id='$_GET[id]'";
            $obj_ttn = mysqli_query($link,$query) or die(mysqli_error($link));
            $ttn = mysqli_fetch_assoc($obj_ttn);
            $date = date('d.m.Y',strtotime($ttn['doc_date']));
            $query = "SELECT partners.partner_name FROM partners LEFT JOIN incoming_invoices ON partners.id=incoming_invoices.partner WHERE incoming_invoices.id='$_GET[id]'";
            $obj_partner = mysqli_query($link,$query) or die(mysqli_error($link));
            $arr_partner = mysqli_fetch_assoc($obj_partner);
            $result = "<p>Заполнение товара по ТТН № <b>$ttn[doc_number]</b> от <b>$date</b> г. Поставщик: <b>$arr_partner[partner_name]</b></p>";
            $query = "SELECT good_receipt.id as good_receipt_id, good_receipt.ttn_id, good_receipt.good_id, good_receipt.measure_unit, good_receipt.number, good_receipt.price, good_receipt.vat_rate, good_receipt.cargo_spaces_number, good_receipt.cargo_weight, good_receipt.note, catalog.id as catalog_id, catalog.good_name FROM good_receipt LEFT JOIN catalog ON catalog.id=good_receipt.good_id WHERE good_receipt.ttn_id='$_GET[id]'";
            $obj_goods = mysqli_query($link,$query) or die(mysqli_error($link));
            for($goods=[];$row=mysqli_fetch_assoc($obj_goods);$goods[]=$row);
            $result .= "<form class='mx-4' method='POST' action=''><table class='ttn_goods_list'>";
            $result .= "<tr><td class='first'>Наименование товара</td><td class='second'>Ед. изм.</td><td class='third'>Кол-во</td><td class='fourth'>Цена, руб.</td><td class='fifth'>Стоимость, руб.</td><td class='sixth'>Ставка НДС, %</td><td class='seventh'>Сумма НДС, руб.</td><td class='eighth'>Стоимость с НДС, руб.</td><td class='ninth'>Кол-во грузовых мест</td><td class='tenth'>Масса груза</td><td class='eleventh'>Примечание</td><td class='twelfth'>Действие</td></tr>
                            <tr><td class='first'>1*</td><td class='second'>2*</td><td class='third'>3*</td><td class='fourth'>4*</td><td class='fifth'>5</td><td class='sixth'>6*</td><td class='seventh'>7</td><td class='eighth'>8</td><td class='ninth'>9</td><td class='tenth'>10</td><td class='eleventh'>11</td><td class='twelfth'>12</td></tr>";
            if(!empty($goods)){
                foreach($goods as $item){
                    $result .= "<tr><td class='first' style='text-align: left;'>$item[good_name]</td><td class='second'>$item[measure_unit]</td><td class='third'>$item[number]</td><td class='fourth'>$item[price]</td><td class='fifth'>".$item['number']*$item['price']."</td><td class='sixth'>$item[vat_rate]</td><td class='seventh'>".round((($item['vat_rate']*$item['number']*$item['price'])/100),2)."</td>
                                <td class='eighth'>".round(($item['number']*$item['price'])+(($item['vat_rate']*$item['number']*$item['price'])/100),2)."</td><td class='ninth'>$item[cargo_spaces_number]</td><td class='tenth'>$item[cargo_weight]</td><td class='eleventh'>$item[note]</td><td class='twelfth'><input type='submit' name='delete_good_from_receipt$item[good_receipt_id]' value='Удалить'><input type='hidden' name='ttn_id' value='$_GET[id]'></td></tr>";
                }
            }
            $result .= "<tr><td class='first' style='text-align: left;'>".$this->goodList()."<input type='hidden' name='ttn_id' value='$_GET[id]'></td><td class='second'><input type='text' name='measure_unit' value=''></td><td class='third'><input type='text' name='number' value=''></td><td class='fourth'><input type='text' name='price' value=''></td>
                        <td class='fifth'></td><td class='sixth'><select name='vat_rate'><option value='20'>20</option><option value='10'>10</option><option value='25'>25</option></select></td><td class='seventh'></td><td class='eighth'></td><td class='ninth'><input type='text' name='cargo_spaces_number' value=''></td><td class='tenth'><input type='text' name='cargo_weight' value=''></td><td class='eleventh'><input type='text' name='note' value=''></td><td class='twelfth'><input type='submit' name='add_receipt_good' value='Сохранить'></td></tr>";
            $result .= "</table><br><input type='submit' name='add_receipt_good' value='Сохранить последнюю строку'>&nbsp;&nbsp;&nbsp;<a style='color: black;' href='/storage'>Выход</a></form>";
        }
        else $result = "";
        return $result;
    }

    public function receiptGood(){
        if(isset($_POST['add_receipt_good'])){
            $message = "";
            if($_POST['good_id']!=0&&$_POST['measure_unit']!=''&&$_POST['number']!=''&&$_POST['price']!=''&&$_POST['vat_rate']!=''){
                if(preg_match('#,#',$_POST['price'])!=1){
                    require 'project/config/connection.php';
                    $query = "INSERT INTO good_receipt SET ttn_id='$_POST[ttn_id]', good_id='$_POST[good_id]', measure_unit='$_POST[measure_unit]', number='$_POST[number]', price='$_POST[price]', 
                vat_rate='$_POST[vat_rate]', cargo_spaces_number='$_POST[cargo_spaces_number]', cargo_weight='$_POST[cargo_weight]', note='$_POST[note]'";
                    mysqli_query($link,$query) or die(mysqli_error($link));
                    $url = $_SERVER['REQUEST_URI'];
                    if(preg_match('#^/storage/receipt-good\?id=[0-9]+$#',$url,$matches)){
                        header("Location: /storage/receipt-good?id=$_GET[id]");
                    }
                    if(preg_match('#^/storage/edit-receipt-good/goods\?id=[0-9]+$#',$url,$matches)){
                        header("Location: /storage/edit-receipt-good/goods?id=$_GET[id]");
                    }
                }
                else $message = "<p>Используйте символ 'точка' в качестве разделителя целой и дробной части в поле 'ЦЕНА'</p>";
            }
            else $message .= "<p>Заполните все поля, отмеченные звёздочками</p>";
            echo $message;
        }
        else return "";
    }

    public function goodList(){
        $result='';
        require 'project/config/connection.php';
        $query="SELECT id, good_name FROM catalog ORDER BY good_name ASC";
        $obj_goods = mysqli_query($link,$query) or die(mysqli_error($link));
        for($arr_goods=[];$row=mysqli_fetch_assoc($obj_goods);$arr_goods[]=$row);
        if(!empty($arr_goods)){
            $result .= "<select style='max-width: 400px;' name='good_id'><option value='0'>Добавить товар...</option>";
            foreach($arr_goods as $item){
                $result .= "<option value='$item[id]'>$item[good_name]</option>";
            }
            $result .= "</select>";
        }
        return $result;
    }

    public function findSupplier(){
        $result = "<label>Выбор поставщика. Полностью или частично введите наименование поставщика и нажмите ПОИСК*:<br><input type='text' name='find_supplier' value='".$this->echoFindSupplier('')."' size='30'>&nbsp;&nbsp;&nbsp;
            <input type='submit' name='show_supplier_list' value='Поиск'></label>";
        if(isset($_POST['show_supplier_list'])){
            $result .= $this->supplierList();
        }
        return $result;
    }

    public function findSupplierEditTtn($var){
        $result = "<label>Выбор поставщика. Полностью или частично введите наименование поставщика и нажмите ПОИСК*:<br><input type='text' name='find_supplier' value='".$this->echoFindSupplier($var)."' size='30'>&nbsp;&nbsp;&nbsp;
            <input type='submit' name='show_supplier_list' value='Поиск'></label>";
        $result .= $this->supplierListEditTtn($var);
        return $result;
    }

    public function supplierList(){
        $result = "";
        if($_POST['find_supplier']!=''){
            require "project/config/connection.php";
            $query = "SELECT id, partner_name FROM partners WHERE partner_name LIKE '%$_POST[find_supplier]%'";
            $object_partners_list = mysqli_query($link,$query) or die(mysqli_error($link));
            for($partners_list=[];$row = mysqli_fetch_assoc($object_partners_list);$partners_list[]=$row);
            if(!empty($partners_list)){
                $result .= "<p class='mx-0'>Ниже приведён список контрагентов, соответствующих поисковому запросу. Выберите контрагента из выпадающего списка. Если в списке нет нужного поставщика, введите другой поисковый запрос и нажмите ПОИСК</p><label>Поставщик:*<br><select style='width: 420px;' name='partner'>";
                foreach($partners_list as $item){
                    if(isset($_POST['partner'])){
                        if($_POST['partner']==$item['id']){
                            $selected = 'selected';
                        }
                        else $selected = '';
                    }
                    else $selected = '';
                    $result .= "<option value='$item[id]' ".$selected.">$item[partner_name]</option>";
                }
                $result .= "</select></label>";
            }
            else $result .= "<p class='mx-0'>Контрагентов, соответствующих введенному запросу, не найдено. Введите другой поисковый запрос и нажните ПОИСК</p>";
        }
        else {
            $result .= "<p class='mx-0'>Введите наименование поставщика и нажмите ПОИСК</p>";
        }
        return $result;
    }

    public function supplierListEditTtn($var){
        $result = "";
        require "project/config/connection.php";
        if(isset($_POST['find_supplier'])) {
            if ($_POST['find_supplier'] != '') {
                $query = "SELECT id, partner_name FROM partners WHERE partner_name LIKE '%$_POST[find_supplier]%'";
            }
            else $result .= "<p class='mx-0'>Введите наименование поставщика и нажмите ПОИСК</p>";
        }
        else $query = "SELECT id, partner_name FROM partners WHERE partner_name LIKE '%$var%'";
        $object_partners_list = mysqli_query($link,$query) or die(mysqli_error($link));
        for($partners_list=[];$row = mysqli_fetch_assoc($object_partners_list);$partners_list[]=$row);
        if(!empty($partners_list)){
            $result .= "<p class='mx-0'>Ниже приведён список контрагентов, соответствующих поисковому запросу. Выберите контрагента из выпадающего списка. Если в списке нет нужного поставщика, введите другой поисковый запрос и нажмите ПОИСК</p><label>Поставщик:*<br><select style='width: 420px;' name='partner'>";
            foreach($partners_list as $item){
                if(isset($_POST['partner'])){
                    if($_POST['partner']==$item['id']){
                        $selected = 'selected';
                    }
                    else $selected = '';
                }
                else $selected = '';
                $result .= "<option value='$item[id]' ".$selected.">$item[partner_name]</option>";
            }
            $result .= "</select></label>";
        }
        else $result .= "<p class='mx-0'>Контрагентов, соответствующих введенному запросу, не найдено. Введите другой поисковый запрос и нажните ПОИСК</p>";
        return $result;
    }

    public function deleteGoodFromReceipt(){
        if(isset($_POST['ttn_id'])){
            require 'project/config/connection.php';
            $query = "SELECT id FROM good_receipt WHERE ttn_id='$_POST[ttn_id]'";
            $obj_goods = mysqli_query($link,$query) or die(mysqli_error($link));
            for($arr_goods=[];$row=mysqli_fetch_assoc($obj_goods);$arr_goods[]=$row);
            if(!empty($arr_goods)){
                foreach ($arr_goods as $item){
                    if(isset($_POST['delete_good_from_receipt'.$item['id']])){
                        $query = "DELETE FROM good_receipt WHERE id='$item[id]'";
                        mysqli_query($link,$query) or die(mysqli_error($link));
                        header("Location: /storage/receipt-good?id=$_POST[ttn_id]");
                    }
                }
            }
        }
        else return "";
    }

    public function editTtnListResult(){
        $result = "";
        $message = "";
        if(isset($_POST['edit_ttn_list'])){
            if($_POST['find_ttn_number']!=''||($_POST['find_ttn_date_from']!=''&&$_POST['find_ttn_date_to']!='')||(isset($_POST['find_supplier'])&&$_POST['find_supplier']!='')){
                $condition = "";
                if(($_POST['find_ttn_date_from']!=''&&$_POST['find_ttn_date_to']!='')&&(strtotime($_POST['find_ttn_date_from'])>strtotime($_POST['find_ttn_date_to']))){
                    $message .= "<br><br><p class='mx-0'>В интервале дат конечная дата должна быть позднее начальной</p>";
                    return $message;
                }
                else{
                    if($_POST['find_ttn_number']!=''){
                        $condition .= "incoming_invoices.doc_number LIKE '%$_POST[find_ttn_number]%'";
                    }
                    else $condition .= "";
                    if($_POST['find_ttn_date_from']!=''&&$_POST['find_ttn_date_to']!=''){
                        if($condition != ""){
                                $condition .= "AND (incoming_invoices.doc_date BETWEEN '$_POST[find_ttn_date_from]' AND '$_POST[find_ttn_date_to]')";
                        }
                        else $condition .= "(incoming_invoices.doc_date BETWEEN '$_POST[find_ttn_date_from]' AND '$_POST[find_ttn_date_to]')";
                    }
                    if(isset($_POST['find_supplier'])&&$_POST['find_supplier']!=''){
                        if($condition!=''){
                            $condition .= "AND partners.id='$_POST[find_supplier]'";
                        }
                        else $condition .= "partners.id='$_POST[find_supplier]'";
                    }
                    require 'project/config/connection.php';
                    $query = "SELECT incoming_invoices.id as incoming_invoices_id, incoming_invoices.doc_number, incoming_invoices.doc_date, incoming_invoices.partner, partners.id as partners_id, partners.partner_name 
                FROM incoming_invoices LEFT JOIN partners ON incoming_invoices.partner=partners.id WHERE $condition ORDER BY incoming_invoices.doc_date ASC";
                    $obj_ttn = mysqli_query($link,$query) or die(mysqli_error($link));
                    for($arr_ttn=[];$row=mysqli_fetch_assoc($obj_ttn);$arr_ttn[]=$row);
                    if(!empty($arr_ttn)){
                        $result .= "<br><br><p class='mx-0'>Список ТТН, удовлетворяющих поисковому запросу:</p>";
                        foreach ($arr_ttn as $item){
                            $date = date('d.m.Y',strtotime($item['doc_date']));
                            $result .= "<label><input type='radio' name='ttn_for_edit' value='$item[incoming_invoices_id]'>&nbsp;ТТН № <b>$item[doc_number]</b> от <b>$date г.</b> Поставщик: <b>$item[partner_name]</b></label><br>";
                        }
                        $result .= "<br><input type='submit' name='edit_ttn' value='Редактировать выбранную ТТН'>";
                    }
                    else {
                        $message .= "<br><br><p class='mx-0'>ТТН, удовлетворяющие поисковому запросу, не найдены</p>";
                        return $message;
                    }
                }
            }
            else {
                $message .= "<br><br><p class='mx-0'>Заполните минимум один из трёх разделов формы</p>";
                return $message;
            }
        }
        return $result;
    }

    public function editTtn(){
        if(isset($_POST['edit_ttn'])){
            $message = "";
            if(isset($_POST['ttn_for_edit'])&&$_POST['ttn_for_edit']!=''){
                header("Location: /storage/edit-receipt-good/ttn-requisites?id=$_POST[ttn_for_edit]");
            }
            else {
                $message .= "<p>Выберите ТТН для редактирования</p>";
                return $message;
            }
        }
        else return "";
    }

    public function findSupplierResult(){
        $result = "";
        $message = "";
        if(isset($_POST['find_supplier_list'])||isset($_POST['edit_ttn_list'])){
            if($_POST['find_supplier_find_receipt_good']!=''){
                require 'project/config/connection.php';
                $query = "SELECT id, partner_name FROM partners WHERE partner_name LIKE '%$_POST[find_supplier_find_receipt_good]%' ORDER BY partner_name ASC";
                $obj_suppliers = mysqli_query($link,$query) or die(mysqli_error($link));
                for($arr_suppliers=[];$row=mysqli_fetch_assoc($obj_suppliers);$arr_suppliers[]=$row);
                if(!empty($arr_suppliers)){
                    $result .= "<p class='mx-0'>Список контрагентов, удовлетворяющих запросу. Выберите один из предложенных вариантов:</p>";
                    foreach ($arr_suppliers as $item) {
                        $checked = "";
                        if(isset($_POST['find_supplier'])){
                            if($_POST['find_supplier']==$item['id']){
                                $checked .= " checked";
                            }
                        }
                        $result .= "<label><input type='radio' name='find_supplier' value='$item[id]'$checked>&nbsp;$item[partner_name]</label><br>";
                    }
                }
                else $message .= "<p class='mx-0'>Поставщиков, удовлетворяющих запросу, не обнаружено. Введите другой запрос и нажмите ПОИСК</p>";
            }
            else $message .= "<p class='mx-0'>Введите наименование поставщика и нажмите ПОИСК</p>";
        }
        return $message.$result;
    }

    public function editTtnRequisites(){
        $result = "";
        if(isset($_GET['id'])){
            require 'project/config/connection.php';
            $query = "SELECT incoming_invoices.id as incoming_invoices_id, incoming_invoices.partner, incoming_invoices.doc_number, incoming_invoices.doc_date, incoming_invoices.car, incoming_invoices.trailer, incoming_invoices.waybill, 
            incoming_invoices.driver, incoming_invoices.transportation_customer, incoming_invoices.sale_basis, incoming_invoices.loading_point, incoming_invoices.unloading_point, incoming_invoices.readdressing, 
            incoming_invoices.cargo_weight, incoming_invoices.cargo_spaces_number, incoming_invoices.sale_allowed, incoming_invoices.passed, incoming_invoices.passed_seal_number, incoming_invoices.accepted_to_transport, 
            incoming_invoices.attorney_number, incoming_invoices.attorney_date, incoming_invoices.attorney_organization, incoming_invoices.accepted, incoming_invoices.accepted_seal_number, partners.id as partner_id, partners.partner_name, partners.address, partners.unp 
            FROM incoming_invoices LEFT JOIN partners ON incoming_invoices.partner=partners.id WHERE incoming_invoices.id='$_GET[id]'";
            $obj_ttn_requisites = mysqli_query($link,$query) or die(mysqli_error($link));
            $ttn_requisites = mysqli_fetch_assoc($obj_ttn_requisites);
            $date = date('d.m.Y',strtotime($ttn_requisites['doc_date']));
            $result .= "<form class='mx-4' method='POST'  action=''>
                        <p class='mx-0'>ТТН № <b>$ttn_requisites[doc_number]</b> от <b>$date</b>г. Поставщик: <b>$ttn_requisites[partner_name]</b></p>
                        <div class='row my-3 mx-1 p-2' style='border: 1px solid #363434; border-radius: 3px;'>
                            <div class='col-lg-6'>
                                <input type='hidden' name='incoming_invoices_id' value='$ttn_requisites[incoming_invoices_id]'>
                                <label>№ ТТН*:&nbsp;<input type='text' name='doc_number' size='15' value='".$this->echoDocNumber($ttn_requisites['doc_number'])."'></label><br><br>
                                <label>Дата ТТН*:&nbsp;<input type='date' name='doc_date' size='15' value='".$this->echoDocDate($ttn_requisites['doc_date'])."'></label><br><br>
                                ".$this->findSupplierEditTtn($ttn_requisites['partner_name'])."<br><br>
                                <label>Автомобиль (марка, государственный номер):<br><input type='text' name='car' size='50' value='".$this->echoCar($ttn_requisites['car'])."'></label><br><br>
                                <label>Прицеп (марка, государственный номер):<br><input type='text' name='trailer' size='50' value='".$this->echoTrailer($ttn_requisites['trailer'])."'></label><br><br>
                                <label>Путевой лист №:&nbsp;<input type='text' name='waybill' size='30' value='".$this->echoWaybill($ttn_requisites['waybill'])."'></label><br><br>
                                <label>Водитель:<br><input type='text' name='driver' size='50' value='".$this->echoDriver($ttn_requisites['driver'])."'></label><br><br>
                                <label>Заказчик перевозки:<br><input type='text' name='transportation_customer' size='50' value='".$this->echoTransportationCustomer($ttn_requisites['transportation_customer'])."'></label><br><br>
                                <label>Основание отпуска*:<br><input type='text' name='sale_basis' size='50' value='".$this->echoSaleBasis($ttn_requisites['sale_basis'])."'></label><br><br>
                                <label>Пункт погрузки*:<br><input type='text' name='loading_point' size='50' value='".$this->echoLoadingPoint($ttn_requisites['loading_point'])."'></label><br><br>
                                <label>Пункт разгрузки*:<br><input type='text' name='unloading_point' size='50' value='".$this->echoUnloadingPoint($ttn_requisites['unloading_point'])."'></label><br><br>
                            </div>
                            <div class='col-lg-6'>
                                <label>Переадресовка:<br><input type='text' name='readdressing' size='50' value='".$this->echoReaddressing($ttn_requisites['readdressing'])."'></label><br><br>
                                <label>Масса груза (прописью):<br><input type='text' name='cargo_weight' size='50' value='".$this->echoCargoWeight($ttn_requisites['cargo_weight'],'')."'></label><br><br>
                                <label>Количество грузовых мест (прописью):<br><input type='text' name='cargo_spaces_number' size='50' value='".$this->echoCargoSpacesNumber($ttn_requisites['cargo_spaces_number'],'')."'></label><br><br>
                                <label>Отпуск разрешил (должность, ФИО, подпись):<br><input type='text' name='sale_allowed' size='50' value='".$this->echoSaleAllowed($ttn_requisites['sale_allowed'])."'></label><br><br>
                                <label>Сдал грузоотправитель (должность, ФИО, подпись)*:<br><input type='text' name='passed' size='50' value='".$this->echoPassed($ttn_requisites['passed'])."'></label><br><br>
                                <label>Номер пломбы:&nbsp;<input type='text' name='passed_seal_number' size='30' value='".$this->echoPassedSealNumber($ttn_requisites['passed_seal_number'])."'></label><br><br>
                                <label>Товар к перевозке принял (должность, ФИО, подпись):<br><input type='text' name='accepted_to_transport' size='50' value='".$this->echoAcceptedToTransport($ttn_requisites['accepted_to_transport'])."'></label><br><br>
                                <label>По доверенности (номер):<br><input type='text' name='attorney_number' size='50' value='".$this->echoAttorneyNumber($ttn_requisites['attorney_number'])."'></label><br><br>
                                <label>По доверенности (дата):<br><input type='text' name='attorney_date' size='50' value='".$this->echoAttorneyDate($ttn_requisites['attorney_date'])."'></label><br><br>
                                <label>Выданной (наименование организации):<br><input type='text' name='attorney_organization' size='50' value='".$this->echoAttorneyOrganization($ttn_requisites['attorney_organization'])."'></label><br><br>
                                <label>Принял грузополучатель  (должность, ФИО, подпись)*:<br><input type='text' name='accepted' size='50' value='".$this->echoAccepted($ttn_requisites['accepted'])."'></label><br><br>
                                <label>Номер пломбы:&nbsp;<input type='text' name='accepted_seal_number' size='30' value='".$this->echoAcceptedSealNumber($ttn_requisites['accepted_seal_number'])."'></label><br><br>
                            </div>
                        </div>
                        <input type='submit' name='edit_incoming_invoices_requisites' value='Сохранить и перейти к редактированию товара'>&nbsp;&nbsp;&nbsp;<a style='color: black;' href='/storage/edit-receipt-good/ttn-requisites?id=$_GET[id]'>Очистить форму</a>
                    </form>";
        }
        return $result;
    }

    public function editIncomingInvoicesRequisites(){
        if(isset($_POST['edit_incoming_invoices_requisites'])){
            require 'project/config/connection.php';
            $query = "UPDATE incoming_invoices SET doc_number='$_POST[doc_number]', doc_date='$_POST[doc_date]', partner='$_POST[partner]', car='$_POST[car]', trailer='$_POST[trailer]', waybill='$_POST[waybill]', 
                             driver='$_POST[driver]', transportation_customer='$_POST[transportation_customer]', sale_basis='$_POST[sale_basis]', loading_point='$_POST[loading_point]', unloading_point='$_POST[unloading_point]', 
                             readdressing='$_POST[readdressing]', cargo_weight='$_POST[cargo_weight]', cargo_spaces_number='$_POST[cargo_spaces_number]', sale_allowed='$_POST[sale_allowed]', passed='$_POST[passed]', 
                             passed_seal_number='$_POST[passed_seal_number]', accepted_to_transport='$_POST[accepted_to_transport]', attorney_number='$_POST[attorney_number]', attorney_date='$_POST[attorney_date]', 
                             attorney_organization='$_POST[attorney_organization]', accepted='$_POST[accepted]', accepted_seal_number='$_POST[accepted_seal_number]' WHERE id='$_POST[incoming_invoices_id]'";
            mysqli_query($link,$query) or die(mysqli_error($link));
            header("Location: /storage/edit-receipt-good/goods?id=$_POST[incoming_invoices_id]");
        }
        else return "";
    }

    public function editTtnGoods(){
        if(isset($_GET['id'])){
            require 'project/config/connection.php';
            $query="SELECT doc_number, doc_date FROM incoming_invoices WHERE id='$_GET[id]'";
            $obj_ttn = mysqli_query($link,$query) or die(mysqli_error($link));
            $ttn = mysqli_fetch_assoc($obj_ttn);
            $date = date('d.m.Y',strtotime($ttn['doc_date']));
            $query = "SELECT partners.partner_name FROM partners LEFT JOIN incoming_invoices ON partners.id=incoming_invoices.partner WHERE incoming_invoices.id='$_GET[id]'";
            $obj_partner = mysqli_query($link,$query) or die(mysqli_error($link));
            $arr_partner = mysqli_fetch_assoc($obj_partner);
            $result = "<p>Редактирование номенклатуры товара по ТТН № <b>$ttn[doc_number]</b> от <b>$date</b> г. Поставщик: <b>$arr_partner[partner_name]</b></p>";
            $query = "SELECT good_receipt.id as good_receipt_id, good_receipt.ttn_id, good_receipt.good_id, good_receipt.measure_unit, good_receipt.number, good_receipt.price, good_receipt.vat_rate, good_receipt.cargo_spaces_number, good_receipt.cargo_weight, good_receipt.note, catalog.id as catalog_id, catalog.good_name FROM good_receipt LEFT JOIN catalog ON catalog.id=good_receipt.good_id WHERE good_receipt.ttn_id='$_GET[id]'";
            $obj_goods = mysqli_query($link,$query) or die(mysqli_error($link));
            for($goods=[];$row=mysqli_fetch_assoc($obj_goods);$goods[]=$row);
            $result .= "<form class='mx-4' method='POST' action=''><input type='hidden' name='ttn_id' value='$_GET[id]'><table class='ttn_goods_list'>";
            $result .= "<tr><td class='first'>Наименование товара</td><td class='second'>Ед. изм.</td><td class='third'>Кол-во</td><td class='fourth'>Цена, руб.</td><td class='fifth'>Стоимость, руб.</td><td class='sixth'>Ставка НДС, %</td><td class='seventh'>Сумма НДС, руб.</td><td class='eighth'>Стоимость с НДС, руб.</td><td class='ninth'>Кол-во грузовых мест</td><td class='tenth'>Масса груза</td><td class='eleventh'>Примечание</td><td colspan='2' class='twelfth_thirteenth'>Действие</td></tr>
                            <tr><td class='first'>1*</td><td class='second'>2*</td><td class='third'>3*</td><td class='fourth'>4*</td><td class='fifth'>5</td><td class='sixth'>6*</td><td class='seventh'>7</td><td class='eighth'>8</td><td class='ninth'>9</td><td class='tenth'>10</td><td class='eleventh'>11</td><td class='twelfth'>12</td><td class='thirteenth'>13</td></tr>";
            if(!empty($goods)){
                foreach($goods as $item){
                    $count = $item['good_receipt_id'];
                    $result .= "<tr><td class='first' style='text-align: left;'>".$this->goodListEditGood($item['good_id'],$count)."</td><td class='second'><input type='text' name='measure_unit_$count' value='".$this->echoMeasureUnit($item['measure_unit'],$count)."'></td>
                                <td class='third'><input type='text' name='number_$count' value='".$this->echoNumber($item['number'],$count)."'></td><td class='fourth'><input type='text' name='price_$count' value='".$this->echoPrice($item['price'],$count)."'></td>
                                <td class='fifth'>".($item['number']*$item['price'])."</td><td class='sixth'>".$this->vatRateEditGood($item['vat_rate'],$count)."</td><td class='seventh'>".round((($item['vat_rate']*$item['number']*$item['price'])/100),2)."</td>
                                <td class='eighth'>".round(($item['number']*$item['price'])+(($item['vat_rate']*$item['number']*$item['price'])/100),2)."</td><td class='ninth'><input type='text' name='cargo_spaces_number_$count' value='".$this->echoCargoSpacesNumber($item['cargo_spaces_number'],$count)."'></td>
                                <td class='tenth'><input type='text' name='cargo_weight_$count' value='".$this->echoCargoWeight($item['cargo_weight'],$count)."'></td><td class='eleventh'><input type='text' name='note_$count' value='".$this->echoNote($item['note'],$count)."'><input type='hidden' name='count' value='$count'></td>
                                <td class='twelfth'><input type='submit' name='edit_good_in_receipt_$item[good_receipt_id]' value='Изменить'></td><td class='thirteenth'><input type='submit' name='delete_good_from_receipt_$item[good_receipt_id]' value='X'></td></tr>";
                }
            }
            $result .= "<tr><td class='first' style='text-align: left;'>".$this->goodList()."<input type='hidden' name='ttn_id' value='$_GET[id]'></td><td class='second'><input type='text' name='measure_unit' value=''></td><td class='third'><input type='text' name='number' value=''></td><td class='fourth'><input type='text' name='price' value=''></td>
                        <td class='fifth'></td><td class='sixth'><select name='vat_rate'><option value='20'>20</option><option value='10'>10</option><option value='25'>25</option></select></td><td class='seventh'></td><td class='eighth'></td><td class='ninth'><input type='text' name='cargo_spaces_number' value=''></td><td class='tenth'><input type='text' name='cargo_weight' value=''></td><td class='eleventh'><input type='text' name='note' value=''></td><td colspan='2' class='twelfth-thirteenth'><input type='submit' name='add_receipt_good' value='Добавить'></td></tr>";
            $result .= "</table><br><input type='submit' name='add_receipt_good' value='Сохранить последнюю строку'>&nbsp;&nbsp;&nbsp;<a style='color: black;' href='/storage'>Выход</a></form>";
        }
        else $result = "";
        return $result;
    }

    public function editGood(){
        if(isset($_POST['ttn_id'])){
            require 'project/config/connection.php';
            $query = "SELECT id FROM good_receipt WHERE ttn_id='$_POST[ttn_id]'";
            $obj_receipt_good = mysqli_query($link,$query) or die(mysqli_error($link));
            for($arr_receipt_good=[];$row=mysqli_fetch_assoc($obj_receipt_good);$arr_receipt_good[]=$row);
            $message = "";
            foreach($arr_receipt_good as $item){
                if(isset($_POST['edit_good_in_receipt_'.$item['id']])){
                    if($_POST['measure_unit_'.$item['id']]!=''&&$_POST['number_'.$item['id']]!=''&&$_POST['price_'.$item['id']]!=''){
                        $good_id = 'good_id_'.$item['id'];
                        $measure_unit = 'measure_unit_'.$item['id'];
                        $number = 'number_'.$item['id'];
                        $price = 'price_'.$item['id'];
                        $vat_rate = 'vat_rate_'.$item['id'];
                        $cargo_spaces_number = 'cargo_spaces_number_'.$item['id'];
                        $cargo_weight = 'cargo_weight_'.$item['id'];
                        $note = 'note_'.$item['id'];
                        $query = "UPDATE good_receipt SET good_id='$_POST[$good_id]', measure_unit='$_POST[$measure_unit]', number='$_POST[$number]', price='$_POST[$price]', vat_rate='$_POST[$vat_rate]', 
                                cargo_spaces_number='$_POST[$cargo_spaces_number]', cargo_weight='$_POST[$cargo_weight]', note='$_POST[$note]' WHERE id='$item[id]'";
                        mysqli_query($link,$query) or die(mysqli_error($link));
                        header("Location: /storage/edit-receipt-good/goods?id=$_GET[id]");
                    }
                    else $message .= "<p>Заполните все поля, отмеченные звёздочками</p>";
                    return  $message;
                }
            }
        }
        else return "";
    }

    public function deleteGoodFromReceiptEditGood(){
        if(isset($_POST['ttn_id'])){
            require 'project/config/connection.php';
            $query = "SELECT id FROM good_receipt WHERE ttn_id='$_POST[ttn_id]'";
            $obj_receipt_good = mysqli_query($link,$query) or die(mysqli_error($link));
            for($arr_receipt_good=[];$row=mysqli_fetch_assoc($obj_receipt_good);$arr_receipt_good[]=$row);
            foreach($arr_receipt_good as $item){
                if(isset($_POST['delete_good_from_receipt_'.$item['id']])){
                    $query = "DELETE FROM good_receipt WHERE id='$item[id]'";
                        mysqli_query($link,$query) or die(mysqli_error($link));
                        header("Location: /storage/edit-receipt-good/goods?id=$_GET[id]");
                }
            }
        }
        else return '';
    }

    public function goodListEditGood($var,$count){
        $result='';
        require 'project/config/connection.php';
        $query="SELECT id, good_name FROM catalog ORDER BY good_name ASC";
        $obj_goods = mysqli_query($link,$query) or die(mysqli_error($link));
        for($arr_goods=[];$row=mysqli_fetch_assoc($obj_goods);$arr_goods[]=$row);
        if(!empty($arr_goods)){
            $result .= "<select style='max-width: 400px;' name='good_id_$count'>";
            foreach($arr_goods as $item){
                $selected = "";
                if(isset($_POST['good_id_'.$count])){
                    if($item['id']==$_POST['good_id_'.$count]){
                        $selected .= " selected";
                    }
                    $result .= "<option value='$item[id]'$selected>$item[good_name]</option>";
                }
                else{
                    if($item['id']==$var){
                        $selected .= " selected";
                    }
                    $result .= "<option value='$item[id]'$selected>$item[good_name]</option>";
                }
            }
            $result .= "</select>";
        }
        return $result;
    }

    public function vatRateEditGood($var,$count){
        $result = "<select name='vat_rate_$count'>";
        $arr_vat_rate = [20,10,25];
        foreach($arr_vat_rate as $item){
            $selected = "";
            if(isset($_POST['vat_rate_'.$count])){
                if($item==$_POST['vat_rate_'.$count]){
                    $selected .= " selected";
                }
            }
            else{
                if($item==$var){
                    $selected .= " selected";
                }
            }
            $result .= "<option value='$item'$selected>$item</option>";
        }
        $result .= "</select>";
        return $result;
    }

    public function echoDocNumber($var){
        if(isset($_POST['doc_number'])){
            return $_POST['doc_number'];
        }
        else return $var;
    }

    public function echoDocDate($var){
        if(isset($_POST['doc_date'])){
            return $_POST['doc_date'];
        }
        else return $var;
    }

    public function echoFindSupplier($var){
        if(isset($_POST['find_supplier'])){
            return $_POST['find_supplier'];
        }
        else return $var;
    }

    public function echoCar($var){
        if(isset($_POST['car'])){
            return $_POST['car'];
        }
        else return $var;
    }

    public function echoTrailer($var){
        if(isset($_POST['trailer'])){
            return $_POST['trailer'];
        }
        else return $var;
    }

    public function echoWaybill($var){
        if(isset($_POST['waybill'])){
            return $_POST['waybill'];
        }
        else return $var;
    }

    public function echoDriver($var){
        if(isset($_POST['driver'])){
            return $_POST['driver'];
        }
        else return $var;
    }

    public function echoTransportationCustomer($var){
        if(isset($_POST['transportation_customer'])){
            return $_POST['transportation_customer'];
        }
        else return $var;
    }

    public function echoSaleBasis($var){
        if(isset($_POST['sale_basis'])){
            return $_POST['sale_basis'];
        }
        else return $var;
    }

    public function echoLoadingPoint($var){
        if(isset($_POST['loading_point'])){
            return $_POST['loading_point'];
        }
        else return $var;
    }

    public function echoUnloadingPoint($var){
        if(isset($_POST['unloading_point'])){
            return $_POST['unloading_point'];
        }
        else return "Витебская обл., г. Полоцк, ул. Мариненко, 40-6";
    }

    public function echoReaddressing($var){
        if(isset($_POST['readdressing'])){
            return $_POST['readdressing'];
        }
        else return $var;
    }

    public function echoCargoWeight($var,$count){
        if(isset($_POST['cargo_weight'.$count])){
            return $_POST['cargo_weight'.$count];
        }
        else return $var;
    }

    public function echoCargoSpacesNumber($var,$count){
        if(isset($_POST['cargo_spaces_number'.$count])){
            return $_POST['cargo_spaces_number'.$count];
        }
        else return $var;
    }

    public function echoSaleAllowed($var){
        if(isset($_POST['sale_allowed'])){
            return $_POST['sale_allowed'];
        }
        else return $var;
    }

    public function echoPassed($var){
        if(isset($_POST['passed'])){
            return $_POST['passed'];
        }
        else return $var;
    }

    public function echoPassedSealNumber($var){
        if(isset($_POST['passed_seal_number'])){
            return $_POST['passed_seal_number'];
        }
        else return $var;
    }

    public function echoAcceptedToTransport($var){
        if(isset($_POST['accepted_to_transport'])){
            return $_POST['accepted_to_transport'];
        }
        else return $var;
    }

    public function echoAttorneyNumber($var){
        if(isset($_POST['attorney_number'])){
            return $_POST['attorney_number'];
        }
        else return $var;
    }

    public function echoAttorneyDate($var){
        if(isset($_POST['attorney_date'])){
            return $_POST['attorney_date'];
        }
        else return $var;
    }

    public function echoAttorneyOrganization($var){
        if(isset($_POST['attorney_organization'])){
            return $_POST['attorney_organization'];
        }
        else return $var;
    }

    public function echoAccepted($var){
        if(isset($_POST['accepted'])){
            return $_POST['accepted'];
        }
        else return $var;
    }

    public function echoAcceptedSealNumber($var){
        if(isset($_POST['accepted_seal_number'])){
            return $_POST['accepted_seal_number'];
        }
        else return $var;
    }

    public function echoFindTtnNumber(){
        if(isset($_POST['find_ttn_number'])){
            return $_POST['find_ttn_number'];
        }
        else return "";
    }

    public function echoFindTtnDateFrom(){
        if(isset($_POST['find_ttn_date_from'])){
            return $_POST['find_ttn_date_from'];
        }
        else return "";
    }

    public function echoFindTtnDateTo(){
        if(isset($_POST['find_ttn_date_to'])){
            return $_POST['find_ttn_date_to'];
        }
        else return "";
    }

    public function echoFindSupplierFindReceiptGood(){
        if(isset($_POST['find_supplier_find_receipt_good'])){
            return $_POST['find_supplier_find_receipt_good'];
        }
        else return "";
    }

    public function echoMeasureUnit($var,$count){
        if(isset($_POST['measure_unit'.$count])){
            return $_POST['measure_unit'.$count];
        }
        else return $var;
    }

    public function echoNumber($var,$count){
        if(isset($_POST['number'.$count])){
            return $_POST['number'.$count];
        }
        else return $var;
    }

    public function echoPrice($var,$count){
        if(isset($_POST['price'.$count])){
            return $_POST['price'.$count];
        }
        else return $var;
    }
    public function echoNote($var,$count){
        if(isset($_POST['note'.$count])){
            return $_POST['note'.$count];
        }
        else return $var;
    }
}