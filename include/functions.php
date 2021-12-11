<?php

define('DB_NAME','E:\Xampp\htdocs\crud\data\db.txt',);

function seed($filename){
    $data = array(
        array(
            'fname' => 'Asif',
            'lname' => 'Talukdar',
            'roll' => '10'
        ),array(
            'fname' => 'Mir',
            'lname' => 'Jamal',
            'roll' => '12'
        ),array(
            'fname' => 'Akash',
            'lname' => 'Hossen',
            'roll' => '5'
        ),array(
            'fname' => 'Oyon',
            'lname' => 'Khan',
            'roll' => '9'
        ),array(
            'fname' => 'Jon',
            'lname' => 'Doe',
            'roll' => '3'
        ),
    );

    $serialized_data = serialize($data);
    file_put_contents($filename, $serialized_data,LOCK_EX);
}