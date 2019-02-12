<?php require_once('config.php') ?>
<?php require_once( ROOT_PATH . '/admin/controllers/admin_functions.php') ?>
<?php require_once( ROOT_PATH . '/admin/controllers/product_functions.php') ?>
<?php 
    if(!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], ['Admin'])){
        header('location: index.php');
    }

    $users = getUsers();
    $products = getAllProducts();
?>


<?php include_once('resources/views/header.php') ?>
    <title>Ebilling</title>
</head>
<body class="bg-grey-lighter flex flex-col">
    <?php include_once('resources/views/navbar.php') ?>
    <main class="flex flex-1 flex-col m-5">
        <h2 class="font-monospace text-orange-dark my-5 text-center">Welcome to your Dashboard</h2>
        <div class="tables m-5 flex">
            <?php if (empty($users)): ?>
                <h1>No admins in the database.</h1>
            <?php else: ?>
            <div class="users-table flex-1 bg-white rounded shadow mx-1 p-4">
                <div class="flex justify-between">
                    <h3 class="text-grey-darkest">Registered users <span class="font-normal px-3 bg-orange-dark rounded-full"><?php echo sizeof($users) ?></span></h3>
                    <a href="users.php" class="p-1 float-right rounded border border-orange-dark hover:bg-orange-dark hover:text-white">Add User</a>
                </div>
                <div class="table flex flex-col flex-1 m-4 border rounded p-2">
                    <div class="table-head flex justify-between border-b p-2">
                        <h4 class="text-center">S.no</h4>
                        <h4 class="text-center">Name</h4>
                        <h4 class="text-center">Authority</h4>
                        <h4 class="text-center">Edit</h4>
                        <h4 class="text-center">Delete</h4>
                    </div>
                    <!-- insert for each here -->
                    <?php foreach($users as $key => $user): ?>
                        <div class="table-row flex justify-between p-1 my-2 border-b">
                            <p class="pl-1"><?php echo $key + 1 ?></p>
                            <p class="pl-1"><?php echo $user['username'] ?></p>
                            <p class="pl-1"><?php echo $user['role'] ?></p>
                            <a class="fa fa-pencil btn edit"
                                href="users.php?edit-admin=<?php echo $user['id'] ?>">Edit
                            </a>
                            <a class="fa fa-trash btn delete pr-5" 
                                href="users.php?delete-admin=<?php echo $user['id'] ?>">
                            </a>
                        </div>
                    <?php endforeach ?>
                    <!-- foreach ends here -->
                </div>
            </div>
            <?php endif ?>
            <div class="product-table flex-1 bg-white rounded shadow mx-1 p-4">
                <div class="flex justify-between">
                    <h3 class="text-grey-darkest text-center">Available products <span class="font-normal px-3 bg-orange-dark rounded-full"><?php echo sizeof($products) ?></span></h3>
                    <a href="products.php" class="p-1 float-right rounded border border-orange-dark hover:bg-orange-dark hover:text-white">Add Products</a>
                </div>
                <div class="table flex flex-col flex-1 m-4 border rounded p-2">
                    <div class="table-head flex justify-between border-b p-2">
                        <h4 class="text-center">S.no</h4>
                        <h4 class="text-center">Product</h4>
                        <h4 class="text-center">Price</h4>
                        <h4 class="text-center">Edit</h4>
                        <h4 class="text-center">Delete</h4>
                    </div>
                    <!-- insert for each here -->
                    <?php foreach($products as $key => $product): ?>
                        <div class="table-row flex justify-between p-1 my-2 border-b">
                            <p class="pl-3"><?php echo $key + 1 ?></p>
                            <p class="pl-3"><?php echo $product['name'] ?></p>
                            <p class="pl-3"><?php echo $product['price'] ?></p>
                            <a class="fa fa-pencil btn edit pr-5"
                                href="products.php?edit-product=<?php echo $product['id'] ?>">Edit
                            </a>
                            <a  class="fa fa-trash btn delete pr-5" 
                                href="products.php?delete-product=<?php echo $product['id'] ?>">
                            </a>
                        </div>
                    <?php endforeach ?>
                    <!-- foreach ends here -->
                </div>
            </div>
            </div>
        </div>
    </main>

    <?php include_once('resources/views/footer.php') ?>
</body>
</html>