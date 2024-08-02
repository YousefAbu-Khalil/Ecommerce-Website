<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-container {
            display: none;
        }

        .form-check-input {
            position: static !important;
            margin-top: 0rem !important;
            margin-left: 0rem !important;
        }

        .checkContainer {
            border: 1px solid black;
            margin: 2px;
            padding: 2px;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#products">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#categories">Categories</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#users">Users</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                </div>

                <!-- Products Section -->
                <div id="products" class="mt-4">
                    <h2>Manage Products</h2>
                    <form action="add_product.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="product_name">Product Name</label>
                            <input type="text" class="form-control" id="product_name" name="product_name">
                        </div>
                        <div class="form-group">
                            <label for="product_price">Product Price</label>
                            <input type="number" class="form-control" id="product_price" name="price">
                        </div>
                        <div class="form-group">
                            <label for="product_description">Product Description</label>
                            <textarea class="form-control" id="product_description" name="description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="product_image">Product Image URL</label>
                            <input type="file" class="form-control" id="product_image" name="image">
                        </div>
                        <div class="form-group">
                            <h3>Categories</h3>
                            <?php
                            $apiurl = 'http://127.0.0.1/Ecommerce-Website/brief4/get_categories.php';
                            $response = file_get_contents($apiurl);

                            if ($response === FALSE) {
                                die('Error occurred while fetching data from API.');
                            }

                            $data = json_decode($response, true);

                            if ($data === NULL) {
                                die('Error occurred while decoding JSON response.');
                            }

                            if (isset($data) && is_array($data)) {
                                foreach ($data as $category) {
                                    echo "
                                <span class='checkContainer'>
                                <input class='form-check-input' type='checkbox' name='category_ids[]' value='{$category['category_id']}' id='defaultCheck{$category['category_id']}'>
                                <label class='form-check-label' for='defaultCheck{$category['category_id']}'>
                                    {$category['category_name']}
                                </label>
                            </span>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>No products found or API response is not as expected.</td></tr>";
                            }
                            ?>


                        </div>
                        <button type="submit" class="btn btn-primary">Add Product</button>
                    </form>

                    <button class="btn btn-info mb-3 mt-4" onclick="toggleTable('products-table')">Show/Hide Products Table</button>
                    <div id="products-table-container">
                        <table class="table table-striped" id="products-table">
                            <thead>
                                <tr>
                                    <th scope="col">Product ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $apiurl = 'http://127.0.0.1/Ecommerce-Website/brief4/get_products.php';
                                $response = file_get_contents($apiurl);

                                if ($response === FALSE) {
                                    die('Error occurred while fetching data from API.');
                                }

                                $data = json_decode($response, true);

                                if ($data === NULL) {
                                    die('Error occurred while decoding JSON response.');
                                }

                                if (isset($data) && is_array($data)) {
                                    foreach ($data as $product) {
                                        echo "
                                <tr>
                                    <td>{$product['product_id']}</td>
                                    <td>{$product['product_name']}</td>
                                    <td>{$product['price']}</td>
                                    <td>{$product['description']}</td>
                                    <td><img src='./product_images/{$product['product_image']}' width='40px' height='40px'</td>
                                    <td><a href='update_product_page.php?id={$product['product_id']}' class='btn btn-warning btn-sm'>Edit</a>
                                    <a href='delete_product.php?id={$product['product_id']}' class='btn btn-danger btn-sm'>Delete</a>
                                    </td>
                                </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6'>No products found or API response is not as expected.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Categories Section -->
                <div id="categories" class="mt-4">
                    <h2>Manage Categories</h2>
                    <form action="add_category.php" method="POST">
                        <div class="form-group">
                            <label for="category_name">Category Name</label>
                            <input type="text" class="form-control" id="category_name" name="category_name">
                        </div>
                        <button type="submit" class="btn btn-primary">Add Category</button>
                    </form>

                    <button class="btn btn-info mb-3 mt-4" onclick="toggleTable('categories-table')">Show/Hide Categories Table</button>
                    <div id="categories-table-container">
                        <table class="table table-striped" id="categories-table">
                            <thead>
                                <tr>
                                    <th scope="col">Category ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $apiurl = 'http://127.0.0.1/Ecommerce-Website/brief4/get_categories.php';
                                $response = file_get_contents($apiurl);

                                if ($response === FALSE) {
                                    die('Error occurred while fetching data from API.');
                                }

                                $data = json_decode($response, true);

                                if ($data === NULL) {
                                    die('Error occurred while decoding JSON response.');
                                }

                                if (is_array($data) && !empty($data)) {
                                    foreach ($data as $category) {
                                        if (is_array($category) && isset($category['category_id']) && isset($category['category_name'])) {
                                            echo "
                                        <tr>
                                            <td>{$category['category_id']}</td>
                                            <td>{$category['category_name']}</td>
                                            <td><a href='update_category_page.php?id={$category['category_id']}' class='btn btn-warning btn-sm'>Edit</a>
                                            <a href='delete_category.php?id={$category['category_id']}' class='btn btn-danger btn-sm'>Delete</a>
                                            </td>
                                        </tr>";
                                        } else {
                                            echo "<tr><td colspan='3'>Invalid category data received.</td></tr>";
                                        }
                                    }
                                } else {
                                    echo "<tr><td colspan='3'>No categories found or API response is not as expected.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Users Section -->
                <div id="users" class="mt-4">
                    <h2>Manage Users</h2>
                    <form action="add_user.php" method="POST">
                        <div class="form-group">
                            <label for="user_name">User Name</label>
                            <input type="text" class="form-control" id="user_name" name="user_name">
                        </div>
                        <div class="form-group">
                            <label for="role_id">Role ID</label>
                            <input type="number" class="form-control" id="role_id" name="role_id">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <button type="submit" class="btn btn-primary">Add User</button>
                    </form>

                    <button class="btn btn-info mb-3 mt-4" onclick="toggleTable('users-table')">Show/Hide Users Table</button>
                    <div id="users-table-container">
                        <table class="table table-striped" id="users-table">
                            <thead>
                                <tr>
                                    <th scope="col">User ID</th>
                                    <th scope="col">User Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Role ID</th>
                                    <th scope="col">Password</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $apiurl = 'http://127.0.0.1/Ecommerce-Website/brief4/get_users.php';
                                $response = file_get_contents($apiurl);

                                if ($response === FALSE) {
                                    die('Error occurred while fetching data from API.');
                                }

                                $data = json_decode($response, true);

                                if ($data === NULL) {
                                    die('Error occurred while decoding JSON response.');
                                }

                                if (is_array($data) && isset($data['data']) && !empty($data['data'])) {
                                    foreach ($data['data'] as $user) {
                                        if (is_array($user) && isset($user['user_id']) && isset($user['user_name']) && isset($user['email']) && isset($user['password']) && isset($user['role_id'])) {
                                            echo "
                                    <tr>
                                        <td>{$user['user_id']}</td>
                                        <td>{$user['user_name']}</td>
                                        <td>{$user['email']}</td>
                                        <td>{$user['role_id']}</td>
                                        <td>{$user['password']}</td>
                                        <td><a href='update_user_page.php?id={$user['user_id']}' class='btn btn-warning btn-sm'>Edit</a>
                                        <a href='delete_user.php?id={$user['user_id']}' class='btn btn-danger btn-sm'>Delete</a>
                                        </td>
                                    </tr>";
                                        } else {
                                            echo "<tr><td colspan='6'>Invalid user data received.</td></tr>";
                                        }
                                    }
                                } else {
                                    echo "<tr><td colspan='6'>No users found or API response is not as expected.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function toggleTable(tableId) {
            var table = document.getElementById(tableId);
            if (table.style.display === 'none' || table.style.display === '') {
                table.style.display = 'table';
            } else {
                table.style.display = 'none';
            }
        }
    </script>
</body>

</html>