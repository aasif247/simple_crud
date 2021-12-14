<?php

session_start();
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
            <?php if(isAdmin() || isEditor() ): ?>
            <th width="25%">Action</th>
            <?php endif; ?>

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

                <?php if(isAdmin() ): ?>
                <td>
                    <?php printf('<a href="/index.php?task=edit&id=%s">Edit</a> | <a class="delete" href="/index.php?task=delete&id=%s">Delete</a>',$student['id'],$student['id']);?>
                </td>
                <?php elseif(isEditor() ): ?>
                <td>
                    <?php printf('<a href="/index.php?task=edit&id=%s">Edit</a>',$student['id']);?>
                </td>
                <?php endif; ?>
            </tr>  

        <?php
        }    // this is the end of the foreach loop
        ?>

    </table> 

<?php
} // this is the end of the function


function addStudent($fname, $lname, $roll){
    $found = false;
    $serialized_data = file_get_contents(DB_NAME);
    $students = unserialize($serialized_data);
    foreach($students as $student){
        if($student['roll']==$roll){
            $found = true;
            break;
        }
    }
    if(!$found){
        $newId = getNewId($students); // this is the new id
        $student = array(
            'id' => $newId,
            'fname' => $fname,
            'lname' => $lname,
            'roll' => $roll
        );
        array_push($students, $student);
        $serialized_data = serialize($students);
        file_put_contents(DB_NAME, $serialized_data,LOCK_EX);
        return true;
    }
    return false;

}

function getStudent($id){
    $serialized_data = file_get_contents(DB_NAME);
    $students = unserialize($serialized_data);
    foreach($students as $student){
        if($student['id']==$id){
            return $student;
        }
    }
    return false;
}

function updateStudent($id, $fname, $lname, $roll){
    $found = false;
    $serialized_data = file_get_contents(DB_NAME);
    $students = unserialize($serialized_data);
    foreach($students as $student){
        if($student['roll']==$roll & $student['id']!=$id){  // if the roll is already taken
            $found = true;
            break;
        }
    }
    if(!$found){
        $students[$id-1]['fname'] = $fname;
        $students[$id-1]['lname'] = $lname;
        $students[$id-1]['roll']  = $roll;
        $serialized_data = serialize($students);
        file_put_contents(DB_NAME, $serialized_data,LOCK_EX);
        return true;
    }
    return false; 
        
}

function deleteStudent($id){
    $serialized_data = file_get_contents(DB_NAME);
    $students = unserialize($serialized_data);

    foreach($students as $offset=>$student){
        if($student['id']== $id){
            unset($students[$offset]);
        }
    }
    $serialized_data = serialize($students);
    file_put_contents(DB_NAME, $serialized_data,LOCK_EX);
}


function getNewId($students){
    $maxId = max(array_column($students, 'id'));
    return $maxId+1;  
}

function isAdmin(){
    return ('admin' == $_SESSION['role']);
}

function isEditor(){
    return ('editor' == $_SESSION['role']);
}

function hasPrivilege(){
    return (isAdmin() || isEditor());
}