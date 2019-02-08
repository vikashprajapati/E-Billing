<?php 
$product_id = 0;
$isEditingProduct = false;
$product_name = "";
$product_price = 0;
$featured_image = "";
$errors = "";

function getAllProducts(){
	global $conn;
	
	$sql = "SELECT * FROM products";
	$result = mysqli_query($conn, $sql);
	$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

	return $products;
}


/* - - - - - - - - - - 
-  Product actions
- - - - - - - - - - -*/
// if user clicks the create post button
if (isset($_POST['create_product'])) { createProduct($_POST); }
// if user clicks the Edit post button
if (isset($_GET['edit-product'])) {
	$isEditingProduct = true;
	$product_id = $_GET['edit-product'];
	editProduct($product_id);
}
// if user clicks the update post button
if (isset($_POST['update_product'])) {
	updateProduct($_POST);
}
// if user clicks the Delete post button
if (isset($_GET['delete-product'])) {
	$post_id = $_GET['delete-product'];
	deleteProduct($post_id);
}

/* - - - - - - - - - - 
-  Post functions
- - - - - - - - - - -*/
function createProduct($request_values){
    global $conn, $errors, $product_name, $post_price, $featured_image;
    $product_name = esc($request_values['name']);
    $product_price = esc($request_values['price']);
    if (empty($product_name)) { array_push($errors, "Product name is required"); }
    if (empty($product_price)) { array_push($errors, "Product price is required"); }
    // Get image name
    $featured_image = $_FILES['featured_image']['name'];
    if (empty($featured_image)) { array_push($errors, "Featured image is required"); }
    // image file directory
    $target = "../static/images/" . basename($featured_image);
    if (!move_uploaded_file($_FILES['featured_image']['tmp_name'], $target)) {
        array_push($errors, "Failed to upload image. Please check file settings for your server");
    }
    // Ensure that no product is saved twice. 
    $product_check_query = "SELECT * FROM products WHERE name = '$product_name' LIMIT 1";
    $result = mysqli_query($conn, $product_check_query);

    if (mysqli_num_rows($result) > 0) { // if product exists
        array_push($errors, "A product already exists with that name.");
    }
    // create post if there are no errors in the form
    if (count($errors) == 0) {
        $query = "INSERT INTO products (name, price, image, created_at, updated_at) VALUES('$product_name', $product_price, $featured_image, now(), now())";
        if(mysqli_query($conn, $query)){ // if product created successfully
            $_SESSION['message'] = "Product created successfully";
            header('location: products.php');
            exit(0);
        }
    }
}

/* * * * * * * * * * * * * * * * * * * * *
* - Takes product id as parameter
* - Fetches the product from database
* - sets product fields on form for editing
* * * * * * * * * * * * * * * * * * * * * */
function editProduct($role_id)
{
    global $conn, $product_name, $post_price, $isEditingProduct, $product_id;
    $sql = "SELECT * FROM products WHERE id=$role_id LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $product = mysqli_fetch_assoc($result);
    // set form values on the form to be updated
    $product_name = $post['name'];
    $product_price = $post['price'];
}

function updateProduct($request_values)
{
    global $conn, $errors, $product_id, $product_name, $post_price, $featured_image;

    $product_name = esc($request_values['name']);
    $product_price = esc($request_values['price']);
    $product_id = esc($request_values['product_id']);
    
    if (empty($product_name)) { array_push($errors, "Product name is required"); }
    if (empty($product_price)) { array_push($errors, "Product price is required"); }
    // if new featured image has been provided
    if (isset($_POST['featured_image'])) {
        // Get image name
        $featured_image = $_FILES['featured_image']['name'];
        // image file directory
        $target = "../static/images/" . basename($featured_image);
        if (!move_uploaded_file($_FILES['featured_image']['tmp_name'], $target)) {
            array_push($errors, "Failed to upload image. Please check file settings for your server");
        }
    }

    // register topic if there are no errors in the form
    if (count($errors) == 0) {
        $query = "UPDATE products SET name = $product_name, price = $product_price, image='$featured_image', updated_at=now() WHERE id=$product_id";
        if(mysqli_query($conn, $query)){
            $_SESSION['message'] = "Products updated successfully";
            header('location: products.php');
            exit(0);
        }
    }
}
// delete blog post
function deleteProduct($product_id)
{
    global $conn;
    $sql = "DELETE FROM products WHERE id=$post_id";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = "Product successfully deleted";
        header("location: products.php");
        exit(0);
    }
}

?>