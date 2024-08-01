<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>signup</title>
    <link rel="https://www.flaticon.com/free-icon/user_747376?term=user&page=1&position=10&origin=search&related_id=747376">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #1d3b37;
            color: #ffffff;
            direction: ltr;
        }

        header {
            background-color: #1d3b37;
            padding: 10px 50px;
        }

        nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #f2c33a;
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 20px;
        }

        .nav-links a {
            text-decoration: none;
            color: #c7d4d0;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: #f2c33a;
        }

        .icons {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-icon::before,
        .cart-icon::before {
            content: '';
            display: inline-block;
            width: 20px;
            height: 20px;
            background-size: cover;
        }

        .user-icon::before {
            background-image: url('https://img.icons8.com/?size=100&id=108652&format=png&color=000000');
        }

        .cart-icon::before {
            background-image: url('<ion-icon name="cart-outline"></ion-icon>');
        }

        .login-section {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 150px);
            background: url(https://i.pinimg.com/564x/c9/19/3e/c9193efb2ff431290270b586df00a939.jpg) no-repeat;
            background-size: cover;
            background-position: center;
        }

        .login-container {
            background-color: #2b4d45;
            border-radius: 20px;
            box-shadow: 5px 0 10px rgba(255, 255, 255, 0.579);
            width: 600px;
            height: 400px;
            padding: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            margin-top: 10px;
        }

        .login-container h2 {
            margin-bottom: 30px;
            color: #ffffff;
            font-size: 30px;
        }

        .input-group {
            margin-bottom: 20px;
            width: 100%;
            text-align: left;
            position: relative;
        }

        .input-group label {
            display: block;
            color: #c7d4d0;
            margin-bottom: 5px;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
            margin-bottom: 50px;

        }

        .btn {
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            text-decoration: none;
            transition: background-color 0.3s, color 0.3s;
            cursor: pointer;
            width: 50%;
            margin-left: 10%;
        }

        .btn-primary {
            background-color: #f2c33a;
            color: #1d3b37;
            border: none;
        }

        .btn-primary:hover {
            background-color: #e6b82e;
        }

        .error-message {
            color: #ff6b6b;
            font-size: 14px;
            position: absolute;
            bottom: -20px;
            left: 0;
            right: 0;
            margin-top: 200px;
            margin-bottom: 15px;
        }



        .success-message {
            color: #4caf50;
            margin-top: 10px;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <header>
        <nav>
            <div class="logo">Furni.</div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="#">Shop</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Our Services</a></li>
                <li><a href="#">Blog</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>
            <div class="icons">
                <a href="login.php"><i class="user-icon"></i></a>
                <a href="#"><i class="cart-icon"></i></a>
            </div>
        </nav>
    </header>

    <main>
        <section class="login-section">
            <div class="login-container">
                <h2>Welcome!</h2>
                <form id="loginForm" action="authenticate.php" method="post">
                    <div class="input-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required>
                        <div class="error-message" id="username-error"></div>
                        <div class="input-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" required>
                            <div class="error-message" id="password-error"></div>
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
        </section>
    </main>

    <script>
        class Validator {
            constructor(username, password) {
                this.username = username;
                this.password = password;
            }

            validate() {
                let errors = {};

                if (this.username === '') {
                    errors.username = 'Username is required.';
                } else if (this.username.length < 3) {
                    errors.username = 'Username must be at least 3 characters long.';
                }

                if (this.password === '') {
                    errors.password = 'Password is required.';
                } else if (this.password.length < 6) {
                    errors.password = 'Password must be at least 6 characters long.';
                }

                return errors;
            }
        }


        document.getElementById('loginForm').addEventListener('submit', function(event) {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();

            const validator = new Validator(username, password);
            const errors = validator.validate();


            document.getElementById('username-error').innerText = '';
            document.getElementById('password-error').innerText = '';


            if (Object.keys(errors).length > 0) {
                event.preventDefault();

                if (errors.username) {
                    document.getElementById('username-error').innerText = errors.username;
                }
                if (errors.password) {
                    document.getElementById('password-error').innerText = errors.password;
                }
            }
        });
    </script>
</body>

</html>