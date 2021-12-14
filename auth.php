<?php
session_start(
    [
        'cookie_lifetime' => 3600, //60 min
]);
$error = false;
// session_destroy();

$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
$fp = fopen("data/users.txt", "r");
if($username && $password){
    $_SESSION['loggedin'] = false;
    $_SESSION['user'] = false;
    while($data = fgetcsv($fp)){
        if($data[0] == $username && $data[1] == sha1($password)){
            $_SESSION['loggedin'] = true;
            $_SESSION['user'] = $username;
            header('location: index.php');
        }
    }
    if(!$_SESSION['loggedin']){
        $error = true;
    }   
}

if(isset($_GET['logout'])){
    $_SESSION['loggedin'] = false;
    $_SESSION['user'] = false;
    session_destroy();
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="//cdn.rawgit.com/necolas/normalize.css/master/normalize.css">
    <link rel="stylesheet" href="//cdn.rawgit.com/milligram/milligram/master/dist/milligram.min.css">
    <title>Session</title>
    <style>
        body{
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="contailer">
        <div class="row">
            <div class="column column-60 column-offset-20">
                <h2>Simple Auth</h2>
            </div>    
        </div>

        <div class="row">
            <div class="column column-60 column-offset-20">
                <?php
                // echo md5("rabbit")."<br/>";
                if($_SESSION['loggedin'] == true)
                // if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true)
                {
                    echo "Hello Admin,Welcome";
                }else{
                    echo "Hello Stranger,Login Below";
                }
                ?>
            </div>    
        </div>

        <div class="row">
            <div class="column column-60 column-offset-20">
                <?php
                if($error){
                    echo "<blockquote>Invalid Username or Password</blockquote>";
                } 
                if($_SESSION['loggedin'] == false):
                
                // if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true): // it's working but didn't figure it out why?   
                ?>
                <form method="POST">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username">
                    
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password">
                    
                    <button type="submit" class="button-primary" name="submit">Log in</button>
                </form>
                    <?php 
                    else:
                ?>
                <form action="auth.php?logout=true" method="POST">
                    <input type="hidden" name="logout" value="1">
                    <button type="submit" class="button-primary" name="submit">Logout</button>
                </form>
                    <?php
                    endif;
                ?>
            </div>    
        </div>
    </div> 
    
</body>
</html>