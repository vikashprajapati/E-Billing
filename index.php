<?php require_once('config.php') ?>
<?php require_once( ROOT_PATH . '/controllers/public_functions.php') ?>

<?php $bills = getCurrentDayBills(); ?>

<?php include_once('resources/views/header.php') ?>
    <title>Ebilling</title>
</head>
<body class="bg-grey-lighter flex flex-col">
    <?php include_once('resources/views/navbar.php') ?>
    <main class="flex flex-1 flex-col m-5">
        <h2 class="font-monospace text-orange-dark px-4 my-5">Current Day Bills</h2>
        <div class="content flex flex-1 ">
            <div class="main-content w-3/4 mx-1">
                <?php foreach($bills as $bill): ?>
                    <div class="card min-h-20 my-5 bg-white rounded flex flex-1 flex-col p-4">
                        <div class="card-header ">
                            <h2><a href = <?php echo "invoice.php?bill_id=".$bill['id']; ?>>Invoice</a></h2>
                            <h3 class="text-orange-dark py-2"> <a href="#"> <?php echo $bill['client_name'] ?></a><small class="text-grey-darkest font-light text-base float-right">issued-by:</small></h3>
                        </div>
                        <div class="card-content">
                            <ul>
                                <?php foreach($bill['products'] as $product): ?>
                                    <li><?php echo $product['name'] ?></li> 
                                <?php endforeach ?>
                            </ul>
                        </div>
                        <div class="card-footer ">
                            <?php echo $bill['user']['username'] ?>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
            <div class="sidebar w-1/4 mx-1 flex flex-col">
                <?php include_once('resources/views/sidebar.php') ?>
            </div>
        </div>
    </main>

    <?php include_once('resources/views/footer.php') ?>
</body>
</html>