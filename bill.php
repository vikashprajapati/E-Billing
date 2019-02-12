<?php require_once('config.php') ?>
<?php require_once( ROOT_PATH . '/controllers/public_functions.php') ?>
<?php 
    if(!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], ['Admin', 'User'])){
        header('location: index.php');
    }
?>

<?php $products = getAllProducts(); ?>

<?php include_once('resources/views/header.php') ?>
    <title>Ebilling</title>
</head>
<body class="bg-grey-lighter flex flex-col">
    <?php include_once('resources/views/navbar.php') ?>
    <main class="flex flex-1 flex-col m-5 items-center">
        <div class="Bill-container flex p-4 flex-col w-1/2 bg-white rounded shadow">
            <h2 class="font-monospace text-center text-orange-dark px-4 my-4">Generate Bill</h2>
            <div class="form-container w-1/2 mx-auto">
                <form method = "post" action = "bill.php" class="flex flex-col">
                    <div class="my-2">
                        <label class="text-grey-darkest block">Customer-Name</label>
                        <input type = "text" name = "client_name" placeholder = "Enter Customer Name" class="w-full p-2 border border-orange-dark rounded my-1" /><br/>
                    </div>
                    <div class="my-4">
                        <label class="text-grey-darkest block">Select products to buy:</label>
                        <div class="flex my-2 flex-col h-32 overflow-y-auto p-2">
                            <?php foreach($products as $product): ?>
                                <div class="m-2">
                                    <input type='checkbox' name='products_id[]' value=<?php echo $product['id'] ?>> <span class="text-grey-darkest mx-1"><?php echo $product['name'] ?></span> <br>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                    <div class="my-2">
                        <label class="text-grey-darkest block">Discount</label>
                        <input type = "text" name = "discount" placeholder = "Discount" class="w-full p-2 my-1 border border-orange-dark rounded" /><br/>
                    </div>
                    <div class="my-2 flex justify-center">
                        <button class="w-full p-2 border rounded hover:bg-orange-dark hover:text-white" type="submit" name="generate_bill_btn">Generate Bill</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <?php include_once('resources/views/footer.php') ?>
</body>
</html>