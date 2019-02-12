<?php require_once('config.php') ?>
<?php require_once( ROOT_PATH . '/admin/controllers/admin_functions.php') ?>
<?php 
    if(!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], ['Admin'])){
        header('location: index.php');
    }
    $roles = ['Admin', 'User'];
?>


<?php include_once('resources/views/header.php') ?>
    <title>Ebilling</title>
</head>
<body class="bg-grey-lighter flex flex-col">
    <?php include_once('resources/views/navbar.php') ?>
    <main class="flex flex-1 flex-col m-5">
            <!-- login styles -->
            <div class="Login-container bg-white w-1/4 m-auto px-4 py-5 rounded">
                <h2 class="text-orange-dark text-center">Add User</h2>
                <form method = "post" action="<?php echo BASE_URL . 'users.php'; ?>" class="flex flex-col">
                    <?php if ($isEditingUser === true): ?>
                        <input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>">
                    <?php endif ?>
                    <input class="my-2 p-2 border rounded" type="text" value="<?php echo $username; ?>" name="username" placeholder="Username">
                    <input class="my-2 p-2 border rounded" type="email" value="<?php echo $email; ?>" name="email" placeholder="Email">
                    <input class="my-2 p-2 border rounded" type="password" name="password" placeholder="Enter your password">
                    <input type="password" class="my-2 p-2 border rounded" name="passwordConfirmation" placeholder="Password confirmation">
                    <select name="role" class="my-2 p-2 border rounded">
                        <option value="" selected disabled>Assign role</option>
                        <?php foreach ($roles as $key => $role): ?>
                            <option value="<?php echo $role; ?>"><?php echo $role; ?></option>
                        <?php endforeach ?>
                    </select>
                    <div class="btn-group flex justify-center">
                        <?php if ($isEditingUser === true): ?> 
                            <div class="text-center">
                                <button class="my-2 p-2 border rounded hover:bg-orange-dark hover:text-white" type="submit" name="update_admin">Update</button>
                            </div>
                        <?php else: ?>
                            <div class="text-center">
                                <button class="my-2 p-2 border rounded hover:bg-orange-dark hover:text-white" type="submit" name="create_admin" value="true">Add User</button>
                            </div>
                        <?php endif ?>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <?php include_once('resources/views/footer.php') ?>
</body>
</html>