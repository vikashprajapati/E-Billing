<?php require_once('config.php') ?>
<?php require_once( ROOT_PATH . '/controllers/public_functions.php') ?>
<?php
    if(isset($_GET['name'])){
        $client_name = esc($_GET['name']);
        $bills = getBillsByName($client_name);
        echo json_encode($bills);
    }else if(isset($_GET['filter_bills'])){
        $option = $_GET['filter_bills'];
        switch($option){
            case '1':
                $bills = getCurrentDayBills();
                break;
            case '2':
                $bills = getLastWeekBills();
                break;
            case '3':
                $bills = getLastMonthBills();
                break;
            case '4':
                $bills = getAllBills();
                break;
        }
        echo json_encode($bills);
    }else if(isset($_GET['filter_products'])){
        $option = $_GET['filter_products'];
        switch($option){
            case '1':
                $bills = getCurrentDayProducts();
                break;
            case '2':
                $bills = getLastWeekProducts();
                break;
            case '3':
                $bills = getLastMonthProducts();
                break;
            case '4':
                $bills = getAllProductsCount();
                break;
        }
        echo json_encode($bills);
    }
?>