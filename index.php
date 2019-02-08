<?php include_once('resources/views/header.php') ?>
    <title>Tile goes here</title>
</head>
<body class="bg-grey-lighter h-screen flex flex-col">
    <?php include_once('resources/views/navbar.php') ?>

    <main class="flex-1 mx-5">
        <h1 class="font-monospace text-orange px-4 my-4">Homepage</h1>
        <div class="content flex my-5">
            <div class="main-content w-3/4  h-screen">
                <?php foreach (range(1,5) as $i) ?>
                {
                    <div class="card min-h-20 bg-white rounded flex flex-1 flex-col p-4">
                        <div class="card-header ">
                            <h3 class="text-orange-dark py-2">Customer-Name  <span class="text-grey-darkest float-right"><strong>issued-by: </strong></span></h3>
                        </div>
                        <div class="card-content">
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Tempora, vel?
                        </div>
                    </div>
                }
                <?php endforeach ?> 
            </div>
            <div class="sidebar w-1/4 mx-1 h-screen">
                <?php include_once('resources/views/navbar.php') ?>
            </div>
        </div>
    </main>

    <?php include_once('resources/views/footer.php') ?>
</body>
</html>