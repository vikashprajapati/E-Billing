<?php require_once('config.php') ?>
<?php require_once( ROOT_PATH . '/controllers/public_functions.php') ?>

<?php 
    $bill_id = $_GET['bill_id'];
    $bill = getBillById($bill_id);
?>

<?php include_once('resources/views/header.php') ?>
    <title>Invoice</title>
</head>
<body class="bg-grey-lighter h-screen flex flex-col">
    <?php include_once('resources/views/navbar.php') ?>
    <main class="flex flex-1 flex-col">
            <div class="invoice-header bg-white w-4/5 mx-auto my-5 px-4 py-5 rounded">
                <div class="flex justify-between py-2 border-b">
                    <h1 class="text-orange-dark">Invoice</h1>
                    <div class="text-grey-darkest">
                        <h4 class="font-normal">Issued by: name</h4>
                        <h4 class="font-normal">some more details</h4>
                    </div>
                </div>
                <div class="invoice-details flex justify-between m-10 ">
                    <div class="text-center">
                        <h4 class="text-grey-darkest">Invoice Id</h4>
                        <p>#001</p>
                    </div>
                    <div class="text-center">
                        <h4 class="text-grey-darkest">Customer name</h4>
                        <p>qwewre</p>
                    </div>
                    <div class="text-center">
                        <h4 class="text-grey-darkest">Date</h4>
                        <p>29/04/2019</p>
                    </div>
                    <div class="text-center">
                        <h4 class="text-grey-darkest">Time</h4>
                        <p>02:11</p>
                    </div>
                </div>
                <div class="invoice-content flex flex-col">
                    <div class="content-head flex">
                        <h5 class="flex-1 border p-4">Product</h5>
                        <h5 class="w-32 border text-center py-4">Price</h5>
                        <h5 class="w-32 border text-center py-4">Discount</h5>
                    </div>
                    <!-- use for each here -->
                    <div class="content-body flex">
                        <p class="flex-1 border px-4 py-2">qwerty</p>
                        <p class="w-32 border text-center py-2">1000</p>
                        <p class="w-32 border text-center py-2">12%</p>
                    </div>
                    <!-- foreah ends here -->
                    <div class="flex flex-col items-end mt-5 p-10 border-t">
                        <h2 class="text-orange-dark text-center">Total</h2>
                        <p class="text-center">rs 10000</p>
                    </div>

                    <div class="invoice-footer flex flex-col mt-5 p-5 border-t">
                        <h3 class="text-grey-darkest py-2">Contact</h3>
                        <h5 class="text-grey-darkest">Email: <span class="font-normal text-grey-darker">lorem@qwerty.com</span></h5> 
                        <h5 class="text-grey-darkest">Phone no: <span class="font-normal text-grey-darker">78944xxxx</span></h5>
                    </div>
                </div>
            </div>
    </main>

    <?php include_once('resources/views/footer.php') ?>
</body>
</html>