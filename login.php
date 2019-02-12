<?php require_once('config.php') ?>
<?php require_once( ROOT_PATH . '/controllers/registration_login.php') ?>
<?php include_once('resources/views/header.php') ?>
    <title>Login</title>
</head>
<body class="bg-grey-lighter h-screen flex flex-col">
    <?php include_once('resources/views/navbar.php') ?>
    <main class="flex flex-1 flex-col">
            <div class="Login-container bg-white w-1/4 m-auto px-4 py-5 rounded">
                <h2 class="text-orange-dark text-center">Login</h2>
                <form method = "post" action="login.php" class="flex flex-col">
                    <label class="mb-1 mt-2">Username</label>
                    <input class="my-2 p-2 border rounded" type="text" name="username" placeholder="Enter your username...">
                    <label class="mb-1 mt-2">Password</label>
                    <input class="my-2 p-2 border rounded" type="password" name="password" placeholder="Enter your password">
                    <div class="text-center">
                        <button class="my-2 p-2 border rounded hover:bg-orange-dark hover:text-white" type="submit" name="login_btn">Login</button>
                    </div>
                </form>
            </div>
    </main>

    <?php include_once('resources/views/footer.php') ?>
</body>
</html>