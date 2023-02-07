<?php

$message = [];
$name = "";
$surname = "";
$email = "";
$password = "";
$passwordConfirmation = "";
$users = array(
    array(
        'id' => 1,
        'name' => 'John',
        'email' => 'john@mail.com',
    ),
    array(
        'id' => 2,
        'name' => 'Sally',
        'email' => 'sally@mail.com',
    ),
    array(
        'id' => 3,
        'name' => 'Jane',
        'email' => 'jane@mail.com',
    ),
    array(
        'id' => 4,
        'name' => 'Peter',
        'email' => 'peter@mail.com',
    )
);

if(empty($_POST["name"])) {
    $message[] = "Name is required";
} else {
    $name = $_POST["name"];
}

if(empty($_POST["surname"])) {
    $message[] = "Surname is required";
} else {
    $surname = $_POST["surname"];
}

if (empty($_POST["email"])) {
    $message[] = "Email is required";
} else if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    $message[] = "Invalid email format";
}else {
    $email = $_POST["email"];
}

if(empty($_POST["password"])) {
    $message[] = "Password is required";
} else {
    $password = $_POST["password"];
}

if(empty($_POST["passwordConfirmation"])) {
    $message[] = "Password Confirmation is required";
} else if($_POST["password"] !== $_POST["passwordConfirmation"]) {
    $message[] = "Password Confirmation failed";
} else {
    $passwordConfirmation = $_POST["passwordConfirmation"];
}

if(empty($message)){
    $emails = array_column($users, 'email');
    $key = array_search($email, $emails);

    if($key) {
        writeLog("#" . date("Y-m-d H:i:s") . " registration is successful. Email: " . $emails[$key]);

        echo json_encode(['success'=> 1, 'message'=>'Registration is successful']);
    } else {
        writeLog("#" . date("Y-m-d H:i:s") . " registration is failed. " . $email . " does not exist in the list");

        echo json_encode(['success'=> 0, 'errors'=>['Email does not exist in the list']]);
    }
} else {
    echo json_encode(['success'=>0, 'errors'=>$message]);
}

function writeLog($message)
{
    $logfile = 'log-' . date('Y-m-d') . '.log';
    file_put_contents($logfile, $message . "\n", FILE_APPEND);
}

