<?php require_once('config.php') ?>
<?php require_once( ROOT_PATH . '/admin/controllers/admin_functions.php') ?>
<?php require_once( ROOT_PATH . '/admin/controllers/product_functions.php') ?>
<?php 
    if(!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], ['Admin'])){
        header('location: index.php');
    }

    $products = getAllProducts();
?>


<?php include_once('resources/views/header.php') ?>
    <title>Ebilling</title>
</head>
<body class="bg-grey-lighter flex flex-col">
    <?php include_once('resources/views/navbar.php') ?>
    <main class="flex flex-1 flex-col m-5">
    <div class="Login-container bg-white w-1/4 m-auto px-4 py-5 rounded">
                <h2 class="text-orange-dark text-center">Add Product</h2>
                <form method = "post" action="<?php echo BASE_URL . 'products.php'; ?>" class="flex flex-col">
                    <?php if ($isEditingProduct === true): ?>
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                    <?php endif ?>
                    <input class="my-2 p-2 border rounded" type="text" value="<?php echo $product_name; ?>" name="name" placeholder="Product name">
                    <input class="my-2 p-2 border rounded" type="text" value="<?php echo $product_price; ?>" name="price" placeholder="Price">
                    <div class="btn-group flex justify-center">
                        <?php if ($isEditingProduct === true): ?> 
                            <div class="text-center">
                                <button class="my-2 p-2 border rounded hover:bg-orange-dark hover:text-white" type="submit" name="update_product">Update product</button>
                            </div>
                        <?php else: ?>
                            <div class="text-center">
                                <button class="my-2 p-2 border rounded hover:bg-orange-dark hover:text-white" type="submit" name="create_product">Add product</button>
                            </div>
                        <?php endif ?>
                    </div>
                </form>
            </div>
    </main>

    <?php include_once('resources/views/footer.php') ?>
</body>
</html>