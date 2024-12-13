<?php
session_start();

date_default_timezone_set("America/New_York");

include_once("inc/autoloader.php");

loadClass("UserManager");
loadClass("User"); 
loadClass("PDOFactory");

$pdo = PDOFactory::getMySQLConnection();

if (isset($_REQUEST['action']) && $_REQUEST['action'] == "connexion") {
    $userManager = new UserManager($pdo);
    $user = $userManager->userExists($_REQUEST['username'], $_REQUEST['mdp']);

    if (is_a($user, 'User')) {
        $_SESSION['user'] = serialize($user);
    } 

} elseif (isset($_REQUEST['action']) && $_REQUEST['action'] == "logout") {
    $_SESSION = array();
    session_destroy();
    header("Location: index.php");
}
?>
