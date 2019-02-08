<?php 
function getAllBills() {
	// use global $conn object in function
	global $conn;
	$sql = "SELECT * FROM bills";
    $result = mysqli_query($conn, $sql);
    if($result){
        $bills = mysqli_fetch_all($result, MYSQLI_ASSOC);

        $final_bills = array();
        foreach ($bills as $bill) {
            $bill['products'] = getBillProducts($bill['id']); 
            $bill['user'] = getBillGeneratedBy($bill['user_id']);
            array_push($final_bills, $bill);
        }
        return $final_bills;
    }else{
        error_log(mysqli_error($conn) . "\n", 3, ROOT_PATH.'/error.log');
        exit();
    }
}

function getLastMonthBills() {
	// use global $conn object in function
	global $conn;
	$sql = "SELECT * FROM table
            WHERE YEAR(created_at) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
            AND MONTH(created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)";
    $result = mysqli_query($conn, $sql);
    if($result){
        $bills = mysqli_fetch_all($result, MYSQLI_ASSOC);

        $final_bills = array();
        foreach ($bills as $bill) {
            $bill['products'] = getBillProducts($bill['id']); 
            $bill['user'] = getBillGeneratedBy($bill['user_id']);
            array_push($final_bills, $bill);
        }
        return $final_bills;
    }else{
        error_log(mysqli_error($conn) . "\n", 3, ROOT_PATH.'/error.log');
        exit();
    }
}

function getCurrentDayBills() {
	// use global $conn object in function
	global $conn;
	$sql = "SELECT * FROM bills WHERE date(created_at) = CURRENT_DATE";
    $result = mysqli_query($conn, $sql);
    if($result){
        $bills = mysqli_fetch_all($result, MYSQLI_ASSOC);

        $final_bills = array();
        foreach ($bills as $bill) {
            $bill['products'] = getBillProducts($bill['id']); 
            $bill['user'] = getBillGeneratedBy($bill['user_id']);
            array_push($final_bills, $bill);
        }
        return $final_bills;
    }else{
        error_log(mysqli_error($conn) . "\n", 3, ROOT_PATH.'/error.log');
        return NULL;
    }
}

function getBillsByClient($client_name) {
	global $conn;
	$sql = "SELECT * FROM bills WHERE client_name = '$client_name'";
	$result = mysqli_query($conn, $sql);
	if($result){
        $bills = mysqli_fetch_all($result, MYSQLI_ASSOC);

        $final_bills = array();
        foreach ($bills as $bill) {
            $bill['products'] = getBillProducts($bill['id']);
            $bill['user'] = getBillGeneratedBy($bill['user_id']);
            array_push($final_bills, $bill);
        }
        return $final_bills;
    }else{
        error_log(mysqli_error($conn) . "\n", 3, ROOT_PATH.'/error.log');
        exit();
    }
}

function getBillGeneratedBy($user_id){
    global $conn;
	$sql = "SELECT * FROM users WHERE id = $user_id LIMIT 1";
	$result = mysqli_query($conn, $sql);
    if($result){
        $user = mysqli_fetch_assoc($result);
	    return $user;
    }else{
        error_log(mysqli_error($conn) . "\n", 3, ROOT_PATH.'/error.log');
        exit();
    }
}

function getBillProducts($bill_id){
	global $conn;
	$sql = "SELECT * FROM products WHERE id IN
			(SELECT product_id FROM bill_product WHERE bill_id=$bill_id)";
	$result = mysqli_query($conn, $sql);
    if($result){
        $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
	    return $products;
    }else{
        error_log(mysqli_error($conn) . "\n", 3, ROOT_PATH.'/error.log');
        exit();
    }
}

function generateBill($products_id, $discount, $client_name){
    if(isset($_SESSION['user'])){
        $user_id = $_SESSION['user']['id'];
    }else{
        exit();
    }
    global $conn;
	$sql = "INSERT INTO bills (discount, created_at, client_name, user_id) VALUES ('$discount', now(), '$client_name', $user_id)";
    if(mysqli_query($conn, $sql)){
        $bill_id = mysqli_insert_id($conn);
	    insertInBillProduct($bill_id, $products_id);
    }else{
        error_log(mysqli_error($conn) . "\n", 3, ROOT_PATH.'/error.log');
        exit();
    }
}

function insertInBillProduct($bill_id, $products_id){
    global $conn;
    foreach($products_id as $product_id){
        $sql = "INSERT INTO bill_product (bill_id, product_id) VALUES ($bill_id, $product_id)";
        if(mysqli_query($conn, $sql)){
            return true;
        }else{
            error_log(mysqli_error($conn) . "\n", 3, ROOT_PATH.'/error.log');
            exit();
        }    
    }
}

?>