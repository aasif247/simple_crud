<?php 
require_once "include/functions.php";
$info = '';
$task = $_GET['task'] ?? 'report';
$error = $_GET['error'] ?? '0';

if('delete'== $task) {
    if(!isAdmin()){
        header('location: /index.php?task=report');
        return;
    }
    $id = filter_input(INPUT_GET, 'id',FILTER_SANITIZE_STRING);
    if($id>0){
        deleteStudent($id);
        header('location: /index.php?task=report');
    }
}
if('seed' == $task) {
    if(!isAdmin()){
        header('location: /index.php?task=report');
    }
    seed(); // this is a function
    $info = "Seeding done";
}

if('edit' == $task){
    if(!hasPrivilege()){
        header('location: /index.php?task=report');
    }
}
$fname = ''; 
$lname = ''; 
$roll = ''; 

if(isset($_POST['submit'])){
    $fname = filter_input(INPUT_POST, 'fname',FILTER_SANITIZE_STRING);
    $lname = filter_input(INPUT_POST, 'lname',FILTER_SANITIZE_STRING);
    $roll = filter_input(INPUT_POST, 'roll',FILTER_SANITIZE_STRING);
    $id = filter_input(INPUT_POST, 'id',FILTER_SANITIZE_STRING);

    if($id){
        // Update existing student
        if($fname !='' && $lname !='' && $roll !='' ){
           $result =  updateStudent($id, $fname, $lname, $roll);
           if($result) {
            header('location: /index.php?task=report');
           }else {
            $error = 1;
           }
        }
    }else{
        // Add new student
        if($fname !='' && $lname !='' && $roll !='' ){ 
            $result = addStudent($fname,$lname,$roll);
            if($result){
                header('location: /index.php?task=report');
            }else{
                $error = 1;
            }
        }
    }
    
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
        
        <?php if($error == '1'): ?>
        <div class="row">
            <div class="column column-60 column-offset-20">
                <blockquote>
                    Duplicate roll found
                </blockquote>
            </div>
        </div>
        <?php endif; ?>


        <?php if('report' == $task): ?>
        <div class="row">
            <div class="column column-60 column-offset-20">
                <?php generateReport(); ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if('add' == $task): ?>
        <div class="row">
            <div class="column column-60 column-offset-20">
                <form action="index.php?task=add" method="POST">
                    <label for="fname">First Name</label>
                    <input type="text" name="fname" id="fname" value="<?php echo $fname; ?>">

                    <label for="lname">Last Name</label>
                    <input type="text" name="lname" id="lname" value="<?php echo $lname; ?>">

                    <label for="roll">Roll</label>
                    <input type="number" name="roll" id="roll" value="<?php echo $roll; ?>">

                    <button type="submit" class="button-primary"  name="submit">Save</button>
                </form>
            </div>
        </div>
        <?php endif; ?>

        <?php  
          if('edit' == $task):
            $id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_STRING);
            $student = getStudent($id);
            if ($student): 
        
        ?>
        <div class="row">
            <div class="column column-60 column-offset-20">
                <form action=""  method="POST">
                    <input type="hidden" name="id" value="<?php echo $id ?>">
                    <label for="fname">First Name</label>
                    <input type="text" name="fname" id="fname" value="<?php echo $student['fname']; ?>">

                    <label for="lname">Last Name</label>
                    <input type="text" name="lname" id="lname" value="<?php echo $student['lname']; ?>">

                    <label for="roll">Roll</label>
                    <input type="number" name="roll" id="roll" value="<?php echo $student['roll']; ?>">

                    <button type="submit" class="button-primary"  name="submit">Update</button>
                </form>
            </div>
        </div>
      <?php 
        endif; 
    endif; 
    ?>

    </div>
<script type="text/javascript" src="assets/js/script.js"></script>
</body>
</html>