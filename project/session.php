<?php
session_start();

if(isset($_SESSION['upload'])){
    echo $_SESSION['upload'];
    unset($_SESSION['upload']);
}

if(isset($_SESSION['edit_cathegory'])){
    echo $_SESSION['edit_cathegory'];
    unset($_SESSION['edit_cathegory']);
}

if(isset($_SESSION['add_cathegory'])){
    echo $_SESSION['add_cathegory'];
    unset($_SESSION['add_cathegory']);
}

if(isset($_SESSION['change_cathegory'])){
    echo $_SESSION['change_cathegory'];
    unset($_SESSION['change_cathegory']);
}

if(isset($_SESSION['delete_cathegory'])){
    echo $_SESSION['delete_cathegory'];
    unset($_SESSION['delete_cathegory']);
}

if(isset($_SESSION['delete_good'])){
    echo $_SESSION['delete_good'];
    unset($_SESSION['delete_good']);
}

if(isset($_SESSION['edit_good'])){
    echo $_SESSION['edit_good'];
    unset($_SESSION['edit_good']);
}

if(isset($_SESSION['edit'])){
    echo $_SESSION['edit'];
    unset($_SESSION['edit']);
}

if(isset($_SESSION['add_partner'])){
    echo $_SESSION['add_partner'];
    unset($_SESSION['add_partner']);
}

if(isset($_SESSION['edit_partner'])){
    echo $_SESSION['edit_partner'];
    unset($_SESSION['edit_partner']);
}

if(isset($_SESSION['delete_partner'])){
    echo $_SESSION['delete_partner'];
    unset($_SESSION['delete_partner']);
}