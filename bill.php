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
    <main class="flex flex-1 flex-col m-5">
        <h2 class="font-monospace text-orange-dark px-4 my-5">Generate Bill</h2>
        <div class="content flex flex-1 ">
            <form method = "post" action = "bill.php">
                <input type = "text" name = "client_name" placeholder = "Client Name" /><br/>
                <?php foreach($products as $product): ?>
                    <input type='checkbox' name='products_id[]' value=<?php echo $product['id'] ?>><?php echo $product['name'] ?><br>
                <?php endforeach ?>
                <input type = "text" name = "discount" placeholder = "Discount" /><br/>
                <button class="my-2 p-2 border rounded hover:bg-orange-dark hover:text-white" type="submit" name="generate_bill_btn">Generate Bill</button>
            </form>
        </div>
    </main>

    <?php include_once('resources/views/footer.php') ?>
</body>
</html>