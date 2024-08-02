<?php
include 'db_connect.php'; // تعديل هذا المسار حسب مكان وجود ملف الاتصال بقاعدة البيانات

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$orders = array();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $_POST['user_name'];
    $sql = "SELECT orders.order_id, orders.order_total, orders.order_date, orders.num_of_items 
            FROM orders 
            JOIN users ON orders.user_id = users.user_id 
            WHERE users.user_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_name);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <link href= "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" 
                  rel="stylesheet">
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
    <style>
        .custom-navbar {
            background: #3b5d50 !important;
            padding-top: 20px;
            padding-bottom: 20px; 
        }

        .custom-navbar .navbar-brand {
            font-size: 32px;
            font-weight: 600; 
        }

        .custom-navbar .navbar-brand > span {
            opacity: .4; 
        }

        .custom-navbar .navbar-toggler {
            border-color: transparent; 
        }

        .custom-navbar .navbar-toggler:active, .custom-navbar .navbar-toggler:focus {
            box-shadow: none;
            outline: none; 
        }

        @media (min-width: 992px) {
            .custom-navbar .custom-navbar-nav li {
                margin-left: 15px;
                margin-right: 15px; 
            } 
        }

        .custom-navbar .custom-navbar-nav li a {
            font-weight: 500;
            color: #ffffff !important;
            opacity: .5;
            transition: .3s all ease;
            position: relative; 
        }

        @media (min-width: 768px) {
            .custom-navbar .custom-navbar-nav li a:before {
                content: "";
                position: absolute;
                bottom: 0;
                left: 8px;
                right: 8px;
                background: #f9bf29;
                height: 5px;
                opacity: 1;
                visibility: visible;
                width: 0;
                transition: .15s all ease-out; 
            } 
        }

        .custom-navbar .custom-navbar-nav li a:hover {
            opacity: 1; 
        }

        .custom-navbar .custom-navbar-nav li a:hover:before {
            width: calc(100% - 16px); 
        }

        .custom-navbar .custom-navbar-nav li.active a {
            opacity: 1; 
        }

        .custom-navbar .custom-navbar-nav li.active a:before {
            width: calc(100% - 16px); 
        }

        .custom-navbar .custom-navbar-cta {
            margin-left: 0 !important;
            flex-direction: row; 
        }

        @media (min-width: 768px) {
            .custom-navbar .custom-navbar-cta {
                margin-left: 40px !important; 
            } 
        }

        .custom-navbar .custom-navbar-cta li {
            margin-left: 0px;
            margin-right: 0px; 
        }

        .custom-navbar .custom-navbar-cta li:first-child {
            margin-right: 20px; 
        }

        /* Custom styles for the dropdown menu */
        .custom-navbar .dropdown-menu {
            background-color: #3b5d50;
            border: none; 
        }

        .custom-navbar .dropdown-item {
            color: #ffffff !important;
            opacity: .7;
            transition: .3s all ease; 
        }

        .custom-navbar .dropdown-item:hover {
            background-color: #2e4b41;
            opacity: 1; 
        }


        .greeting {
            margin-left: 1rem;
            font-weight: bold;
            color: #6c757d;
        }
        .greeting {
            margin-left: 1rem;
            font-weight: bold;
            color: #6c757d;
        }
        .account-container, .account-details-container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .order-history, .account-details {
            margin-top: 20px;
        }
        .order-item, .details-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #ccc;
        }
        .logout-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            bs-btn-bg: #3b5d50 !important;
        }
        h1{
            margin-top: 2%;
        }
    </style>
</head>
<body>
<nav class="custom-navbar navbar navbar-expand-md navbar-dark bg-dark" aria-label="Furni navigation bar">
        <div class="container">
            <a class="navbar-brand" href="index.html">Furni<span>.</span></a>
            
            <!-- Search Form -->
            <form class="d-flex ms-3" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-light" type="submit">Search</button>
            </form>
    
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni" aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
    
            <div class="collapse navbar-collapse" id="navbarsFurni">
                <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a class="nav-link" href="file:///C:/Users/Orange/Desktop/furni-1.0.0/home after login.html">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle"  id="categoryDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Category</a>
                        <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                            <li><a class="dropdown-item" href="file:///C:/Users/Orange/Desktop/furni-1.0.0/categori1.html?#">Sofas</a></li>
                            <li><a class="dropdown-item" href="file:///C:/Users/Orange/Desktop/furni-1.0.0/categoty2.html">Tables</a></li>
                            <li><a class="dropdown-item" href="file:///C:/Users/Orange/Desktop/furni-1.0.0/category3.html">Chairs</a></li>
                        </ul>
                    </li>
                    <li><a class="nav-link" href="file:///C:/Users/Orange/Desktop/furni-1.0.0/about after login.html">About</a></li>
                    <li><a class="nav-link" href="file:///C:/Users/Orange/Desktop/furni-1.0.0/contact after login.html">Contact</a></li>
                    <li><a class="nav-link" href="file:///C:/Users/Orange/Desktop/furni-1.0.0/home.html">Logout</a></li>
                </ul>
    
                <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
                    <li><a class="nav-link" href="file:///C:/Users/Orange/Desktop/furni-1.0.0/User.html"><i class="fa-regular fa-user"></i></a></li>
                    <li><a class="nav-link" href="file:///C:/Users/Orange/Desktop/furni-1.0.0/cart.html"><i class="fa-solid fa-cart-shopping"></i></a></li>
                </ul>
            </div>
        </div>
    </nav>

<div class="container">
  <h1 class="text-center">My Account</h1>
    <form method="post" class="mt-4">
        <div class="mb-3">
            <label for="user_name" class="form-label">Enter Username:</label>
            <input type="text" name="user_name" id="user_name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Fetch Orders</button>
    </form>

    <div class="account-container">
        <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <p>Hello, <?php echo htmlspecialchars($user_name); ?></p>
            <div class="order-history">
                <h4>Order history</h4>
                <?php if(!empty($orders)): ?>
                    <?php foreach ($orders as $order): ?>
                        <div class="order-item">
                            <span>Order ID: <?php echo htmlspecialchars($order['order_id']); ?></span>
                            <span>Total: <?php echo htmlspecialchars($order['order_total']); ?></span>
                            <span>Date: <?php echo htmlspecialchars($order['order_date']); ?></span>
                            <span>Items: <?php echo htmlspecialchars($order['num_of_items']); ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No orders found.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php if (!empty($user_info)): ?>
        <div class="account-details-container">
            <h4>Account Details for <?php echo htmlspecialchars($user_info['user_name']); ?></h4>
            <form method="post">
                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_info['user_id']); ?>">

                <div class="details-item">
                    <label for="new_user_name" class="form-label">Name</label>
                    <input type="text" name="new_user_name" id="new_user_name" class="form-control" value="<?php echo htmlspecialchars($user_info['user_name']); ?>" required>
                </div>
                <div class="details-item">
                    <label for="new_email" class="form-label">Email</label>
                    <input type="email" name="new_email" id="new_email" class="form-control" value="<?php echo htmlspecialchars($user_info['email']); ?>" required>
                </div>
                <div class="details-item">
                    <label for="new_password" class="form-label">Password</label>
                    <input type="password" name="new_password" id="new_password" class="form-control" required>
                </div>
                <button type="submit" name="update_user" class="btn btn-success mt-3">Update Details</button>
            </form>
        </div>
        <?php endif; ?>
    </div>

    <div class="account-details-container">
            <h4>Account Details</h4>
            <div class="details-item">
                <span>Name</span>
                <a href="#" class="btn btn-link">Edit</a>
            </div>
            <div class="details-item">
                <span>Email</span>
                <a href="#" class="btn btn-link">Edit</a>
            </div>
            <div class="details-item">
                <span>Password</span>
                <a href="#" class="btn btn-link">Edit</a>
            </div>
        </div>

</div>

<footer class="footer-section">
        <div class="container relative">
            <div class="border-top copyright">
                <div class="row pt-4">
                    <div class="col-lg-6">
                        <p class="mb-2 text-center text-lg-start">Copyright &copy;<script>document.write(new Date().getFullYear());</script>. All Rights Reserved. &mdash; Designed with love by <a href="https://untree.co">Untree.co</a>  Distributed By <a href="https://themewagon.com">ThemeWagon</a> <!-- License information: https://untree.co/license/ -->
        </p>
                    </div>

                    <div class="col-lg-6 text-center text-lg-end">
                        <ul class="list-unstyled d-inline-flex ms-auto">
                            <li class="me-4"><a href="#">Terms &amp; Conditions</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                        </ul>
                    </div>

                </div>
            </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
