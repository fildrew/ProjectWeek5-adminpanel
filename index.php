<?php 
class Auth {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }
    public function login($email, $password){
        $userDTO = new UserDTO($this->conn);
        $user = $userDTO->getUserByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            return true;
        }else {
            return false;
        }
    }
        public function isLoggedIn() {
            return isset($_SESSION['user_id']);
        }
    
        public function logout() {
            session_unset();
            session_destroy();
        }

}

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once('db.php');
require_once('userDTO.php');
require_once('db_pdo.php');
require_once('Auth.php');
$config = require_once('config.php');

use DB\DB_PDO as DB;

$PDOConn = DB::getInstance($config);
$conn = $PDOConn->getConnection(); 

$auth = new Auth($conn);

if ($auth->isLoggedIn()) {
    header('Location: adminpanel.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($auth->login($email, $password)) {
        if ($_SESSION['role'] === 'admin'){
            header('Location: adminpanel.php');
        } else {
            header('Location: userspanel.php');
        }
        exit;
    } else {
        $_SESSION['error'] = "Credenziali non valide";
        header('Location: index.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <form action="index.php" method="POST">
                <div class="card bg-dark text-white" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
    
                        <div class="mb-md-5 mt-md-4 pb-5">
    
                        <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                        <p class="text-white-50 mb-5">Please enter your login and password!</p>
    
                        <div data-mdb-input-init class="form-outline form-white mb-4">
                            <input type="email" id="typeEmailX" class="form-control form-control-lg"  placeholder="email" name="email" />
                            <label class="form-label" for="typeEmailX">Email</label>
                        </div>
    
                        <div data-mdb-input-init class="form-outline form-white mb-4">
                            <input type="password" id="typePasswordX" class="form-control form-control-lg"  placeholder="Password" name="password" />
                            <label class="form-label" for="typePasswordX">Password</label>
                        </div>
    
                        <p class="small mb-5 pb-lg-2"><a class="text-white-50" href="#!">Forgot password?</a></p>
    
                        <button data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-light btn-lg px-5" name="submit" type="submit">Login</button>
                        <?php
                            if (isset($_SESSION['error'])) {
                                    echo '<div class="alert alert-danger my-3" role="alert">' . $_SESSION['error'] . '</div>';
                                    unset($_SESSION['error']);
                            }
                        ?>

                        <div class="d-flex justify-content-center text-center mt-4 pt-1">
                            <a href="#!" class="text-white"><i class="bi bi-facebook bi-lg"></i></a>
                            <a href="#!" class="text-white"><i class="bi bi-twitter-x mx-4 px-2"></i></a>
                            <a href="#!" class="text-white"><i class="bi bi-google bi-lg"></i></a>
                        </div>
    
                        </div>
    
                        <div>
                            <p class="mb-0">Don't have an account? <a href="register.php" class="text-white-50 fw-bold">Sign Up</a>
                            </p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        </div>
    </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>