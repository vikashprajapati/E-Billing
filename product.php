<?php require_once('config.php') ?>
<?php require_once( ROOT_PATH . '/controllers/public_functions.php') ?>

<?php 
    $products = getCurrentDayProducts();
?> 

<?php include_once('resources/views/header.php') ?>
    <title>Ebilling</title>
</head>
<body class="bg-grey-lighter flex flex-col min-h-screen">
    <?php include_once('resources/views/navbar.php') ?>
    <main class="flex flex-1 flex-col m-5">
        <h2 class="font-monospace text-orange-dark w-3/4 mx-auto my-5" id = "heading">List of Products</h2>
        <div class="content flex">
            <div class="main-content flex-1 w-3/4 mx-1">
                <div class="flex w-3/4 m-auto justify-end px-5">
                    <div>
                        <p class="inline-flex">Filter-by:</p>
                        <select name="filter" onchange = "filter()" id="select" class="p-1">
                            <option value="1">Current Day Bills</option>
                            <option value="2">Past Week Bills</option>
                            <option value="3">Past Month Bills</option>
                            <option value="4">All Bills</option>
                        </select>
                    </div>
                </div>
                <div class="product-container w-3/4 flex justify-between my-4">
                    <?php foreach($products as $product): ?>
                        <div class="product-card w-1/4 bg-white rounded shadow flex flex-col mx-2">
                            <div class="h-64 bg-grey m-2"></div>
                            <div class="p-4">
                                    <h3 class="text-grey-darkest"><?php echo $product['product']['name']; ?><span class="font-normal text-grey-darker float-right"><?php echo $product['c']; ?></span></h3>                    
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
                <div id = 'pages'>
                </div>
            </div>
        </div>
    </main>

    <?php include_donce('resources/views/footer.php') ?>
</body>
<script>
    function filter(){
        select = document.getElementById('select').value;
        header = document.getElementById('heading');
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                bills = JSON.parse(this.responseText);
                paginate(1);
                switch(select){
                    case '1':
                        header.innerHTML = 'Current Day products';
                        break;
                    case '2':
                        header.innerHTML = 'Past Week products';
                        break;
                    case '3':
                        header.innerHTML = 'Past Month products';
                        break;
                    case '4':
                        header.innerHTML = 'All Bills';
                        break;
                }
            }
        };
        xhttp.open("GET", "filter.php?filter_products="+select, true);
        xhttp.send();
    }
</script>
</html>