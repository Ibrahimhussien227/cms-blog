<?php include "db.php"; ?>
<?php include "../admin/functions.php"; ?>
<?php session_start(); ?>

<?php if (isset($_POST["login"])) {
  $username = escape($_POST["username"]);
  $password = escape($_POST["password"]); // $username_login = $_POST["username"]; // $password_login = $_POST["password"];
  $query = "SELECT * FROM users WHERE username = '{$username}' ";
  $select_user_query = mysqli_query($connection, $query);
  confirmQuery($select_user_query);
  while ($row = mysqli_fetch_array($select_user_query)) {
    $user_id = $row["user_id"];
    $username = $row["username"];
    $user_password = $row["user_password"];
    $user_firstname = $row["user_firstname"];
    $user_lastname = $row["user_lastname"];
    $user_role = $row["user_role"];
  }
  if (password_verify($password, $user_password)) {
    $_SESSION["username"] = $username;
    $_SESSION["user_firstname"] = $user_firstname;
    $_SESSION["user_lastname"] = $user_lastname;
    $_SESSION["user_role"] = $user_role;
    echo $_SESSION["user_role"];
    header("Location: ../admin");
  } else {
    header("Location: ../index.php");
  }
} ?>
