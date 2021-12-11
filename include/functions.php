<?php

define('DB_NAME','E:\Xampp\htdocs\crud\data\db.txt',);

function seed(){
    $data = array(
        array(
            'id' => 1,
            'fname' => 'Asif',
            'lname' => 'Talukdar',
            'roll' => '10'
        ),array(
            'id' => 2,
            'fname' => 'Mir',
            'lname' => 'Jamal',
            'roll' => '12'
        ),array(
            'id' => 3,
            'fname' => 'Akash',
            'lname' => 'Hossen',
            'roll' => '5'
        ),array(
            'id' => 4,
            'fname' => 'Oyon',
            'lname' => 'Khan',
            'roll' => '9'
        ),array(
            'id' => 5,
            'fname' => 'Jon',
            'lname' => 'Doe',
            'roll' => '3'
        ),
    );

    $serialized_data = serialize($data);
    file_put_contents(DB_NAME, $serialized_data,LOCK_EX);
}

function generateReport(){
    $serialized_data = file_get_contents(DB_NAME);
    $students = unserialize($serialized_data);
    ?>

    <table>
        <tr>
            <th>Name</th>
            <th>Roll</th>
            <th width="25%">Action</th>
        </tr>
        <?php 
        foreach($students as $student){
            ?>
            <tr> 
                <td>
                    <?php printf('%s %s',$student['fname'],$student['lname']); ?>
                </td>
                
                <td>
                    <?php printf('%s',$student['roll']);?>
                </td>
                
                <td>
                    <?php printf('<a href="/index.php?task=edit&id=%s">Edit</a> | <a href="/index.php?task=delete&id=%s">Delete</a>',$student['id'],$student['id']);?>
                </td>
            </tr>  

        <?php
        }    // this is the end of the foreach loop
        ?>

    </table> 

<?php
} // this is the end of the function
?>