<?php
session_start();

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', ''); 
define('DB_NAME', 'login');

if (isset($_SESSION['flash'])) {
    $error = $_SESSION['flash'];
    unset($_SESSION['flash']);
} else {
    $error = '';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = trim($_POST['email'] ?? ''); 
    $password = $_POST['password'] ?? '';

    if ($identifier === '' || $password === '') {
        $error = 'Please enter email/username and password.';
    } else {
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($mysqli->connect_errno) {
            $error = 'Database connection failed: ' . $mysqli->connect_error;
        } else {
            $sql = 'SELECT id, username, password, email FROM users WHERE email = ? OR username = ? LIMIT 1';
            $stmt = $mysqli->prepare($sql);
            if ($stmt) {
                $stmt->bind_param('ss', $identifier, $identifier);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($row = $result->fetch_assoc()) {
                    $hash = $row['password'];
                    $verified = false;
                    if (password_verify($password, $hash)) {
                        $verified = true;
                    } elseif ($password === $hash) {
                        $verified = true;
                    }

                    if ($verified) {
                        $_SESSION['user_id'] = $row['id'];
                        $_SESSION['username'] = $row['username'];
                        header('Location: dashboard.php');
                        exit;
                    } else {
                        $error = 'Invalid credentials.';
                    }
                } else {
                    $error = 'Invalid credentials.';
                }
                $stmt->close();
            } else {
                $error = 'Database query failed.';
            }
            $mysqli->close();
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>LGU2 — Login</title>
    <link href="assets/img/Quezon_City.svg.png" rel="icon">
    <link href="assets/css/login.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body class="g-0">
    <div class="main-container container-fluid g-0">
        <div class="left col-lg-7 col-md-12 row-md-2 d-flex align-items-center justify-content-center">
            <img class="text-pic" src="assets/img/QC.png" alt="">
            <h4 class="fw-bolder ms-1">LOCAL GOVERNMENT UNIT 2</h4>
        </div>    
            
        
        <div class="right col-lg-5 col-md-12 row-md- d-flex align-items-center justify-content-center">
            
            <div class="form-box" role="form" aria-labelledby="login-title">
                <h3 id="login-title fw-bolder">Login</h3>
                <p class="sub">Sign in to your account</p>

                <?php if ($error): ?>
                    <div class="error" style="color:#c0392b; margin-bottom:12px;"><?=htmlspecialchars($error)?></div>
                <?php endif; ?>

                <form method="post" action="" class="d-flex align-items-center justify-content-center flex-column">
                    <div class="form-field">
                        
                        <input id="email" name="email" type="text" placeholder="Enter your email or username" autocomplete="username" value="<?=isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''?>">
                    </div>

                    <div class="form-field">
                        
                        <input id="password" name="password" type="password" placeholder="Enter your password" autocomplete="current-password">
                    </div>

                    <div class="controls">
                        <a class="forgot" href="#">Forgot Password?</a>
                    </div>

                    <button class="btn-login" id="btnLogin" type="submit">LOGIN</button>
                </form>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>
</html>