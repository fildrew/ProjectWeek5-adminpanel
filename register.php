<?php 
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($password !== $confirmPassword) {
        $_SESSION['error'] = "Le password non corrispondono.";
        header("Location: register.php");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        $sql = "INSERT INTO users (firstname, lastname, email, password) VALUES (:firstname, :lastname, :email, :password)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->execute();

        header('Location: successregister.php');
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Errore durante l'inserimento dell'utente nel database: " . $e->getMessage();
        header("Location: register.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
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
        
                            <h2 class="fw-bold mb-2 text-uppercase">Sign Up</h2>
                            <p class="text-white-50 mb-5">Create an account!</p>
        
                            <div data-mdb-input-init class="form-outline form-white mb-4">
                                <input type="text" id="" class="form-control form-control-lg" name="firstname" placeholder="Firstname" />
                                <label for=""></label>
                            </div>
        
                            <div data-mdb-input-init class="form-outline form-white mb-4">
                                <input type="text" id="" class="form-control form-control-lg"  name="lastname" placeholder="Lastname"/>
                                <label for=""></label>
                            </div>

                            <div data-mdb-input-init class="form-outline form-white mb-4">
                                <input type="email" id="" class="form-control form-control-lg"  name="email" placeholder="Email"/>
                                <label for=""></label>
                            </div>

                            <div data-mdb-input-init class="form-outline form-white mb-4">
                                <input type="password" id="password" class="form-control form-control-lg"  name="password" placeholder="Password"/>
                                <label for="password"></label>
                            </div>

                            <div data-mdb-input-init class="form-outline form-white mb-4">
                                <input type="password" id="confirmPassword" class="form-control form-control-lg"  name="confirmPassword" placeholder="Confirm Password" value=""/>
                                <label for="confirmPassword"></label>
                            </div>

        
                            <button data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-light btn-lg px-5" name="submit" type="submit">Register</button>
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
                                <p class="mb-0">Already have an account? <a href="index.php" class="text-white-50 fw-bold">Login</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>