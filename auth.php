<?php
function checkAuth(string $login, string $password): bool 
{
    $conn = require __DIR__ . '/db_functions/conn.php';
    $result =  $conn->query("SELECT * FROM user");
	$users = $result->fetchAll();

    foreach ($users as $user) {
        //echo 'Comparing ' . $login . ' and ' . $password . ' to: ' . $user['email'] . ' ' . $user['phonenumber'] . ' ' . $user['pass'] . '</br>';
        if ($user['email'] === $login){ if ($user['pass'] === $password){ return true;};}
        if ($user['phonenumber'] == $login){ if ($user['pass'] === $password){ return true;};}
    }

    //echo 'login fail for login: ' . $login . ' pass: ' . $password;
    return false;
}


function getUserLogin(): ?string
{
    $loginFromCookie = $_COOKIE['login'] ?? '';
    $passwordFromCookie = $_COOKIE['password'] ?? '';
    if (checkAuth($loginFromCookie, $passwordFromCookie)) {
        return $loginFromCookie;
    }

    return null;
}

function getUser(string $login)
{
    $conn = require __DIR__ . '/db_functions/conn.php';
    $email_result =  $conn->query("SELECT * FROM user where email = '${login}'")->fetch();
    $phone_result =  $conn->query("SELECT * FROM user where phonenumber = '${login}'")->fetch();

    if ($email_result)
    {
        return $email_result;
    }
    elseif ($phone_result)
    {
        return $phone_result;
    }
    else { return null; }
}

/*
$conn = require __DIR__ . '/db_functions/conn.php';
$result =  $conn->query("SELECT * FROM user");
$user_result = $result->fetchAll();
foreach ($user_result as $index => $value)
{
    echo $index . ' ' . $value['email'] . ' ' . $value['phonenumber'] . ' ' . $value['pass']. '</br>';
}
*/

//$userdata = getUser('999');
//var_dump($userdata);
?>
