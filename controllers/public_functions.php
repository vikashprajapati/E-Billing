<?php 
$errors = "";

function getBillById($bill_id){
    // use global $conn object in function
	global $conn;
	$sql = "SELECT * FROM bills where id = $bill_id LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if($result){
        $bill = mysqli_fetch_assoc($result);
        $bill['products'] = getBillProducts($bill['id']); 
        $bill['user'] = getBillGeneratedBy($bill['user_id']);
        
        return $bill;
    }else{
        error_log(mysqli_error($conn) . "\n", 3, ROOT_PATH.'/error.log');
        exit();
    }
}

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
        exit();
        error_log(mysqli_error($conn) . "\n", 3, ROOT_PATH.'/error.log');
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

if (isset($_POST['generate_bill_btn'])) {
	generateBill($_POST);
}

function esc(String $value){
	// bring the global db connect object into function
	global $conn;
	// remove empty space sorrounding string
	$val = trim($value); 
	$val = mysqli_real_escape_string($conn, $value);
	return $val;
}

function generateBill($request_values){
    global $conn, $errors;

    $user_id = $_SESSION['user']['id'];
    $client_name = esc($request_values['client_name']);
    $discount = esc($request_values['discount']);;
    $products_id = array();

    foreach($request_values['products_id'] as $product_id){
        array_push($products_id, $product_id);
    }

    $amount = getAmount($products_id);

    $amount = $amount*(1-($discount/100));

	$sql = "INSERT INTO bills (discount, created_at, client_name, user_id, amount) VALUES ('$discount', now(), '$client_name', $user_id, $amount)";
    if(mysqli_query($conn, $sql)){
        $bill_id = mysqli_insert_id($conn);
	    insertInBillProduct($bill_id, $products_id);
    }else{
        error_log(mysqli_error($conn) . "\n", 3, ROOT_PATH.'/error.log');
        exit();
    }
}

function getAmount($products_id){
    global $conn;
    $amount = 0;
    foreach($products_id as $product_id){
        $sql = "Select price from products WHERE id = $product_id";
        $result = mysqli_query($conn, $sql);
        if($result){
            $amount += mysqli_fetch_assoc($result)['price'];
        }else{
            error_log(mysqli_error($conn) . "\n", 3, ROOT_PATH.'/error.log');
            exit();
        }    
    }
    return $amount;
}

function insertInBillProduct($bill_id, $products_id){
    global $conn;
    foreach($products_id as $product_id){
        $sql = "INSERT INTO bill_product (bill_id, product_id) VALUES ($bill_id, $product_id)";
        if(mysqli_query($conn, $sql)){
            continue;
        }else{
            error_log(mysqli_error($conn) . "\n", 3, ROOT_PATH.'/error.log');
            exit();
        }    
    }
    return $amount;
}

function getAllProducts(){
	global $conn;
	
	$sql = "SELECT * FROM products";
	$result = mysqli_query($conn, $sql);
	$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

	return $products;
}

?>