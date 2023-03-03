<?php

function users_online()
{
  if (isset($_GET["onlineusers"])) {
    global $connection;

    if (!$connection) {
      session_start();

      include "../includes/db.php";

      $session = session_id();
      $time = time();
      $time_out_in_seconds = 05;
      $time_out = $time - $time_out_in_seconds;

      $query = "SELECT * FROM users_online WHERE session = '$session'";
      $send_query = mysqli_query($connection, $query);
      $count = mysqli_num_rows($send_query);

      if ($count == null) {
        mysqli_query(
          $connection,
          "INSERT INTO users_online(session, time) VALUES('$session','$time')"
        );
      } else {
        mysqli_query(
          $connection,
          "UPDATE users_online SET time = '$time' WHERE session = '$session'"
        );
      }

      $users_online_query = mysqli_query(
        $connection,
        "SELECT * FROM users_online WHERE time > '$time_out'"
      );
      echo $count_user = mysqli_num_rows($users_online_query);
    }
  } // get request isset()
}

users_online();

function confirmQuery($query)
{
  global $connection;

  if (!$query) {
    die("QUERY FAILED ." . mysqli_error($connection));
  }
}

function insert_categories()
{
  global $connection;

  if (isset($_POST["add_category"])) {
    $cat_title = $_POST["cat_title"];

    if ($cat_title == "" || empty($cat_title)) {
      echo "This field should not be empty";
    } else {
      $query = "INSERT INTO categories(cat_title) ";
      $query .= "VALUE('{$cat_title}') ";

      $create_category_query = mysqli_query($connection, $query);
      header("Location: categories.php");

      confirmQuery($create_category_query);
    }
  }
}

function findAllCategories()
{
  global $connection;

  // $query = "SELECT * FROM categories LIMIT 3";
  $query = "SELECT * FROM categories";
  $select_categories = mysqli_query($connection, $query);
  while ($row = mysqli_fetch_assoc($select_categories)) {
    $cat_id = $row["cat_id"];
    $cat_title = $row["cat_title"];

    echo "<tr>";
    echo "<td>{$cat_id}</td>";
    echo "<td>{$cat_title}</td>";
    echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
    echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
    echo "</tr>";
  }
}

function deleteCategory()
{
  global $connection;

  if (isset($_GET["delete"])) {
    $cat_id = $_GET["delete"];

    $query = "DELETE FROM categories WHERE cat_id = {$cat_id} ";
    $delte_query = mysqli_query($connection, $query);

    confirmQuery($delte_query);
    header("Location: categories.php");
  }
}
?>
