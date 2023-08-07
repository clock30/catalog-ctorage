<?php
namespace classes;
spl_autoload_register();

require 'project/session.php';

$url = $_SERVER['REQUEST_URI'];

if(preg_match('#^/$#',$url,$matches)){
    $index = new Page;
    $layout = file_get_contents('project/layouts/index.tpl');
    $layout = str_replace('{{header}}',$index->header(),$layout);
    $layout = str_replace('{{footer}}',$index->footer(),$layout);
    $layout = str_replace('{{slyder}}',$index->slyder(),$layout);
    echo $layout;
}

if(preg_match('#^/about$#',$url,$matches)){
    $about = new Page;
    $layout = file_get_contents('project/layouts/about.tpl');
    $layout = str_replace('{{header}}',$about->header(),$layout);
    $layout = str_replace('{{footer}}',$about->footer(),$layout);
    echo $layout;
}

if(preg_match('#^/warranty$#',$url,$matches)){
    $warranty = new Page;
    $layout = file_get_contents('project/layouts/warranty.tpl');
    $layout = str_replace('{{header}}',$warranty->header(),$layout);
    $layout = str_replace('{{footer}}',$warranty->footer(),$layout);
    echo $layout;
}

if(preg_match('#^/payment$#',$url,$matches)){
    $payment = new Page;
    $layout = file_get_contents('project/layouts/payment.tpl');
    $layout = str_replace('{{header}}',$payment->header(),$layout);
    $layout = str_replace('{{footer}}',$payment->footer(),$layout);
    echo $layout;
}

if(preg_match('#^/delivery$#',$url,$matches)){
    $delivery = new Page;
    $layout = file_get_contents('project/layouts/delivery.tpl');
    $layout = str_replace('{{header}}',$delivery->header(),$layout);
    $layout = str_replace('{{footer}}',$delivery->footer(),$layout);
    echo $layout;
}

if(preg_match('#^/contacts$#',$url,$matches)){
    $contacts = new Page;
    $layout = file_get_contents('project/layouts/contacts.tpl');
    $layout = str_replace('{{header}}',$contacts->header(),$layout);
    $layout = str_replace('{{footer}}',$contacts->footer(),$layout);
    echo $layout;
}

if(preg_match('#^/catalog[/a-z0-9-_]*$#',$url,$matches)){
    $catalog = new Catalog;
    $layout = file_get_contents('project/layouts/catalog.tpl');
    $layout = str_replace('{{header}}',$catalog->header(),$layout);
    $layout = str_replace('{{footer}}',$catalog->footer(),$layout);
    $layout = str_replace('{{catalogCathegories}}',$catalog->catalogCathegories(),$layout);
    $layout = str_replace('{{path}}',$catalog->path(),$layout);
    echo $layout;
}

if(preg_match('#^/admin$#',$url,$matches)){
    $admin = new Admin;
    $layout = file_get_contents('project/layouts/admin.tpl');
    $layout = str_replace('{{header}}',$admin->header(),$layout);
    $layout = str_replace('{{footer}}',$admin->footer(),$layout);
    echo $layout;
}

if(preg_match('#^/admin/add-cathegory$#',$url,$matches)){
    $add_cathegory = new Admin;
    $layout = file_get_contents('project/layouts/add_cathegory.tpl');
    $layout = str_replace('{{header}}',$add_cathegory->header(),$layout);
    $layout = str_replace('{{footer}}',$add_cathegory->footer(),$layout);
    $layout = str_replace('{{addCathegoryForm}}',$add_cathegory->addCathegoryForm(),$layout);
    $layout = str_replace('{{echoCathegoryName}}',$add_cathegory->echoCathegoryName(),$layout);
    $add_cathegory->addCathegory();
    echo $layout;
}

if(preg_match('#^/admin/edit-cathegory$#',$url,$matches)){
    $edit_cathegory = new Admin;
    $layout = file_get_contents('project/layouts/edit_cathegory.tpl');
    $layout = str_replace('{{header}}',$edit_cathegory->header(),$layout);
    $layout = str_replace('{{footer}}',$edit_cathegory->footer(),$layout);
    $layout = str_replace('{{editCathegoryForm}}',$edit_cathegory->editCathegoryForm(),$layout);
    $layout = str_replace('{{allCathegoryList}}',$edit_cathegory->allCathegoryList(),$layout);
    $layout = str_replace('{{echoNewCathegoryName}}',$edit_cathegory->echoNewCathegoryName(),$layout);
    $layout = str_replace('{{echoCheckedEditCathegoryName}}',$edit_cathegory->echoCheckedEditCathegoryName(),$layout);
    $edit_cathegory->editCathegory();
    echo $layout;
}

if(preg_match('#^/admin/change-cathegory$#',$url,$matches)){
    $change_cathegory = new Admin;
    $layout = file_get_contents('project/layouts/change_cathegory.tpl');
    $layout = str_replace('{{header}}',$change_cathegory->header(),$layout);
    $layout = str_replace('{{footer}}',$change_cathegory->footer(),$layout);
    $layout = str_replace('{{changeCathegoryForm}}',$change_cathegory->changeCathegoryForm(),$layout);
    $change_cathegory->changeCathegory();
    echo $layout;
}

if(preg_match('#^/admin/delete-cathegory$#',$url,$matches)){
    $delete_cathegory = new Admin;
    $layout = file_get_contents('project/layouts/delete_cathegory.tpl');
    $layout = str_replace('{{header}}',$delete_cathegory->header(),$layout);
    $layout = str_replace('{{footer}}',$delete_cathegory->footer(),$layout);
    $layout = str_replace('{{deleteCathegoryForm}}',$delete_cathegory->deleteCathegoryForm(),$layout);
    $delete_cathegory->deleteCathegory();
    echo $layout;
}

if(preg_match('#^/admin/add-good$#',$url,$matches)){
    $add_good = new Admin;
    $layout = file_get_contents('project/layouts/add_good.tpl');
    $layout = str_replace('{{header}}',$add_good->header(),$layout);
    $layout = str_replace('{{footer}}',$add_good->footer(),$layout);
    $layout = str_replace('{{cathegoryList}}',$add_good->cathegoryList(),$layout);
    $layout = str_replace('{{echoGoodName}}',$add_good->echoGoodName(),$layout);
    $layout = str_replace('{{echoGoodDescription}}',$add_good->echoGoodDescription(),$layout);
    $layout = str_replace('{{echoGoodMaterial}}',$add_good->echoGoodMaterial(),$layout);
    $layout = str_replace('{{echoGoodColor}}',$add_good->echoGoodColor(),$layout);
    $layout = str_replace('{{echoGoodPrice}}',$add_good->echoGoodPrice(),$layout);
    $layout = str_replace('{{echoGoodPhoto}}',$add_good->echoGoodPhoto(),$layout);
    $layout = str_replace('{{echoAddInfo}}',$add_good->echoAddInfo(),$layout);
    echo $layout;
}

if(preg_match('#^/scripts/add_good.php$#',$url,$matches)){
    require "scripts/add_good.php";
}

if(preg_match('#^/admin/delete-good$#',$url,$matches)){
    $delete_good = new Admin;
    $layout = file_get_contents('project/layouts/delete_good.tpl');
    $layout = str_replace('{{header}}',$delete_good->header(),$layout);
    $layout = str_replace('{{footer}}',$delete_good->footer(),$layout);
    $layout = str_replace('{{deleteEditGoodSelectForm}}',$delete_good->deleteEditGoodSelectForm(),$layout);
    $delete_good->deleteGood();
    echo $layout;
}

if(preg_match('#^/admin/edit-good$#',$url,$matches)){
    $edit_good = new Admin;
    $layout = file_get_contents('project/layouts/edit_good.tpl');
    $layout = str_replace('{{header}}',$edit_good->header(),$layout);
    $layout = str_replace('{{footer}}',$edit_good->footer(),$layout);
    $layout = str_replace('{{deleteEditGoodSelectForm}}',$edit_good->deleteEditGoodSelectForm(),$layout);
    $edit_good->goEditGoodForm();
    echo $layout;
}

if(preg_match('#^/admin/edit-good\?id=[0-9]+$#',$url,$matches)){
    $edit_good_form = new Admin;
    $layout = file_get_contents('project/layouts/edit_good_form.tpl');
    $layout = str_replace('{{header}}',$edit_good_form->header(),$layout);
    $layout = str_replace('{{footer}}',$edit_good_form->footer(),$layout);
    $layout = str_replace('{{editGoodForm}}',$edit_good_form->editGoodForm(),$layout);
    $layout = str_replace('{{editedGood}}',$edit_good_form->editedGood(),$layout);
    echo $layout;
}

if(preg_match('#^/scripts/edit_good.php$#',$url,$matches)){
    require "scripts/edit_good.php";
}

if(preg_match('#^/storage$#',$url,$matches)){
    $storage = new Storage;
    $layout = file_get_contents('project/layouts/storage.tpl');
    $layout = str_replace('{{header}}',$storage->header(),$layout);
    $layout = str_replace('{{footer}}',$storage->footer(),$layout);
    echo $layout;
}

if(preg_match('#^/storage/receipt-good$#',$url,$matches)){
    $receipt_good = new Storage;
    $layout = file_get_contents('project/layouts/receipt_good.tpl');
    $layout = str_replace('{{header}}',$receipt_good->header(),$layout);
    $layout = str_replace('{{footer}}',$receipt_good->footer(),$layout);
    $layout = str_replace('{{ttnRequisites}}',$receipt_good->ttnRequisites(),$layout);
    $receipt_good->addIncomingInvoices();
    echo $layout;
}

if(preg_match('#^/storage/receipt-good\?id=[0-9]+$#',$url,$matches)){
    $receipt_good = new Storage;
    $layout = file_get_contents('project/layouts/receipt_good_form.tpl');
    $layout = str_replace('{{header}}',$receipt_good->header(),$layout);
    $layout = str_replace('{{footer}}',$receipt_good->footer(),$layout);
    $layout = str_replace('{{receiptGoodForm}}',$receipt_good->receiptGoodForm(),$layout);
    $receipt_good->receiptGood();
    $receipt_good->deleteGoodFromReceipt();
    echo $layout;
}

if(preg_match('#^/storage/edit-receipt-good$#',$url,$matches)){
    $edit_receipt_good = new Storage;
    $layout = file_get_contents('project/layouts/edit_receipt_good.tpl');
    $layout = str_replace('{{header}}',$edit_receipt_good->header(),$layout);
    $layout = str_replace('{{footer}}',$edit_receipt_good->footer(),$layout);
    $layout = str_replace('{{echoFindTtnNumber}}',$edit_receipt_good->echoFindTtnNumber(),$layout);
    $layout = str_replace('{{echoFindTtnDateFrom}}',$edit_receipt_good->echoFindTtnDateFrom(),$layout);
    $layout = str_replace('{{echoFindTtnDateTo}}',$edit_receipt_good->echoFindTtnDateTo(),$layout);
    $layout = str_replace('{{echoFindSupplierFindReceiptGood}}',$edit_receipt_good->echoFindSupplierFindReceiptGood(),$layout);
    $layout = str_replace('{{findSupplierResult}}',$edit_receipt_good->findSupplierResult(),$layout);
    $layout = str_replace('{{editTtnListResult}}',$edit_receipt_good->editTtnListResult(),$layout);
    $edit_receipt_good->editTtn();
    echo $layout;
}

if(preg_match('#^/storage/edit-receipt-good/ttn-requisites\?id=[0-9]+$#',$url,$matches)){
    $edit_receipt_good_form_requisites = new Storage;
    $layout = file_get_contents('project/layouts/edit_receipt_good_form_requisites.tpl');
    $layout = str_replace('{{header}}',$edit_receipt_good_form_requisites->header(),$layout);
    $layout = str_replace('{{footer}}',$edit_receipt_good_form_requisites->footer(),$layout);
    $layout = str_replace('{{editTtnRequisites}}',$edit_receipt_good_form_requisites->editTtnRequisites(),$layout);
    $edit_receipt_good_form_requisites->editIncomingInvoicesRequisites();
    echo $layout;
}

if(preg_match('#^/storage/edit-receipt-good/goods\?id=[0-9]+$#',$url,$matches)){
    $edit_receipt_good_form_goods = new Storage;
    $layout = file_get_contents('project/layouts/edit_receipt_good_form_goods.tpl');
    $layout = str_replace('{{header}}',$edit_receipt_good_form_goods->header(),$layout);
    $layout = str_replace('{{footer}}',$edit_receipt_good_form_goods->footer(),$layout);
    $layout = str_replace('{{editTtnGoods}}',$edit_receipt_good_form_goods->editTtnGoods(),$layout);
    $edit_receipt_good_form_goods->editGood();
    $edit_receipt_good_form_goods->receiptGood();
    $edit_receipt_good_form_goods->deleteGoodFromReceiptEditGood();
    echo $layout;
}

if(preg_match('#^/sales$#',$url,$matches)){
    $sales = new Sales;
    $layout = file_get_contents('project/layouts/sales.tpl');
    $layout = str_replace('{{header}}',$sales->header(),$layout);
    $layout = str_replace('{{footer}}',$sales->footer(),$layout);
    echo $layout;
}

if(preg_match('#^/sales/retail$#',$url,$matches)){
    $retail = new Sales;
    $layout = file_get_contents('project/layouts/retail.tpl');
    $layout = str_replace('{{header}}',$retail->header(),$layout);
    $layout = str_replace('{{footer}}',$retail->footer(),$layout);
    $layout = str_replace('{{deleteEditGoodSelectForm}}',$retail->deleteEditGoodSelectForm(),$layout);
    echo $layout;
}

if(preg_match('#^/sales/edit-retail$#',$url,$matches)){
    $edit_retail = new Sales;
    $layout = file_get_contents('project/layouts/edit_retail.tpl');
    $layout = str_replace('{{header}}',$edit_retail->header(),$layout);
    $layout = str_replace('{{footer}}',$edit_retail->footer(),$layout);
    $layout = str_replace('{{editRetailSelectForm}}',$edit_retail->editRetailSelectForm(),$layout);
    $layout = str_replace('{{editRetailForm}}',$edit_retail->editRetailForm(),$layout);
    $edit_retail->goEditRetailForm();
    echo $layout;
}

if(preg_match('#^/sales/edit-retail\?id=[0-9]+$#',$url,$matches)){
    $edit_retail_form = new Sales;
    $layout = file_get_contents('project/layouts/edit_retail.tpl');
    $layout = str_replace('{{header}}',$edit_retail_form->header(),$layout);
    $layout = str_replace('{{footer}}',$edit_retail_form->footer(),$layout);
    $layout = str_replace('{{editRetailSelectForm}}',$edit_retail_form->editRetailSelectForm(),$layout);
    $layout = str_replace('{{editRetailForm}}',$edit_retail_form->editRetailForm(),$layout);
    echo $layout;
}

if(preg_match('#^/sales/refund$#',$url,$matches)){
    $refund = new Sales;
    $layout = file_get_contents('project/layouts/refund.tpl');
    $layout = str_replace('{{header}}',$refund->header(),$layout);
    $layout = str_replace('{{footer}}',$refund->footer(),$layout);
    $layout = str_replace('{{editRetailSelectForm}}',$refund->editRetailSelectForm(),$layout);
    $layout = str_replace('{{refundForm}}',$refund->refundForm(),$layout);
    $refund->goRefundForm();
    echo $layout;
}

if(preg_match('#^/sales/refund\?id=[0-9]+$#',$url,$matches)){
    $refund_form = new Sales;
    $layout = file_get_contents('project/layouts/refund.tpl');
    $layout = str_replace('{{header}}',$refund_form->header(),$layout);
    $layout = str_replace('{{footer}}',$refund_form->footer(),$layout);
    $layout = str_replace('{{editRetailSelectForm}}',$refund_form->editRetailSelectForm(),$layout);
    $layout = str_replace('{{refundForm}}',$refund_form->refundForm(),$layout);
    echo $layout;
}

if(preg_match('#^/sales/edit-refund$#',$url,$matches)){
    $edit_refund = new Sales;
    $layout = file_get_contents('project/layouts/edit_refund.tpl');
    $layout = str_replace('{{header}}',$edit_refund->header(),$layout);
    $layout = str_replace('{{footer}}',$edit_refund->footer(),$layout);
    $layout = str_replace('{{selectEditRefundForm}}',$edit_refund->selectEditRefundForm(),$layout);
    //$layout = str_replace('{{editRefundForm}}',$edit_refund->editRefundForm(),$layout);
    //$refund->goRefundForm();
    echo $layout;
}

if(preg_match('#^/sales/wholesale$#',$url,$matches)){
    $wholesale = new Sales;
    $layout = file_get_contents('project/layouts/wholesale.tpl');
    $layout = str_replace('{{header}}',$wholesale->header(),$layout);
    $layout = str_replace('{{footer}}',$wholesale->footer(),$layout);
    $layout = str_replace('{{ttnRequisites}}',$wholesale->ttnRequisites(),$layout);
    $wholesale->addOutcomingInvoices();
    echo $layout;
}

if(preg_match('#^/sales/wholesale\?id=[0-9]+$#',$url,$matches)){
    $wholesale = new Sales;
    $layout = file_get_contents('project/layouts/wholesale_form.tpl');
    $layout = str_replace('{{header}}',$wholesale->header(),$layout);
    $layout = str_replace('{{footer}}',$wholesale->footer(),$layout);
    $layout = str_replace('{{wholesaleForm}}',$wholesale->wholesaleForm(),$layout);
    $wholesale->wholesale();
    $wholesale->deleteGoodFromWholesale();
    echo $layout;
}

if(preg_match('#^/partners$#',$url,$matches)){
    $partners = new Partners;
    $layout = file_get_contents('project/layouts/partners.tpl');
    $layout = str_replace('{{header}}',$partners->header(),$layout);
    $layout = str_replace('{{footer}}',$partners->footer(),$layout);
    echo $layout;
}

if(preg_match('#^/partners/add-partner$#',$url,$matches)){
    $add_partner = new Partners;
    $layout = file_get_contents('project/layouts/add_partner.tpl');
    $layout = str_replace('{{header}}',$add_partner->header(),$layout);
    $layout = str_replace('{{footer}}',$add_partner->footer(),$layout);
    $add_partner->addPartner();
    echo $layout;
}

if(preg_match('#^/partners/edit-partner$#',$url,$matches)){
    $edit_partner = new Partners;
    $layout = file_get_contents('project/layouts/edit_partner.tpl');
    $layout = str_replace('{{header}}',$edit_partner->header(),$layout);
    $layout = str_replace('{{footer}}',$edit_partner->footer(),$layout);
    $layout = str_replace('{{findEditPartnerForm}}',$edit_partner->findEditPartnerForm(),$layout);
    $edit_partner->goEditPartnerForm();
    echo $layout;
}

if(preg_match('#^/partners/edit-partner\?id=[0-9]+$#',$url,$matches)){
    $edit_partner_form = new Partners;
    $layout = file_get_contents('project/layouts/edit_partner_form.tpl');
    $layout = str_replace('{{header}}',$edit_partner_form->header(),$layout);
    $layout = str_replace('{{footer}}',$edit_partner_form->footer(),$layout);
    $layout = str_replace('{{editPartnerForm}}',$edit_partner_form->editPartnerForm(),$layout);
    $edit_partner_form->editPartner();
    echo $layout;
}

if(preg_match('#^/partners/delete-partner$#',$url,$matches)){
    $delete_partner = new Partners;
    $layout = file_get_contents('project/layouts/delete_partner.tpl');
    $layout = str_replace('{{header}}',$delete_partner->header(),$layout);
    $layout = str_replace('{{footer}}',$delete_partner->footer(),$layout);
    $layout = str_replace('{{findDeletePartnerForm}}',$delete_partner->findEditPartnerForm(),$layout);
    $delete_partner->deletePartner();
    echo $layout;
}

if(preg_match('#^/reports$#',$url,$matches)){
    $reports = new Reports;
    $layout = file_get_contents('project/layouts/reports.tpl');
    $layout = str_replace('{{header}}',$reports->header(),$layout);
    $layout = str_replace('{{footer}}',$reports->footer(),$layout);
    echo $layout;
}