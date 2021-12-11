<?php 
require_once "include/functions.php";
$info = '';
$task = $_GET['task'] ?? 'report';
if('seed' == $task) {
    seed(); // this is a function
    $info = "Seeding done";
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
    <title>Crud</title>
    <style>
        body {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="column column-60 column-offset-20">
                <h2>Crud</h2>
                <p>A simple crud project with PHP</p>

                <?php include_once('include/templates/nav.php')?>

                <hr/>
                <?php 
                    if($info!=''){
                        echo "<p>($info)</p>";
                    }
                ?>
            </div>
        </div>

        <?php if('report' == $task): ?>
        <div class="row">
            <div class="column column-60 column-offset-20">
                <?php generateReport(); ?>
            </div>
        </div>
        <?php endif; ?>

    </div>   
</body>
</html>