<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Username</th>
            <th>Firstname</th>
            <th>LastName</th>
            <th>Email</th>
            <th>Role</th>
            <th>Admin</th>
            <th>User</th>
            <th>Edit</th>
            <th>Delete</th>
            <!-- <th>Date</th> -->
        </tr>
    </thead>
    <tbody>

    <?php
    $query = "SELECT * FROM users";
    $select_all_users_query = mysqli_query($connection, $query);

    confirmQuery($select_all_users_query);
    while ($row = mysqli_fetch_assoc($select_all_users_query)) {
      $user_id = $row["user_id"];
      $username = $row["username"];
      $user_password = $row["user_password"];
      $user_firstname = $row["user_firstname"];
      $user_lastname = $row["user_lastname"];
      $user_email = $row["user_email"];
      $user_image = $row["user_image"];
      $user_role = $row["user_role"];
      // $user_date = $row["user_date"];

      echo "<tr>";
      echo "<td>{$user_id}</td>";
      echo "<td>{$username}</td>";
      echo "<td>{$user_firstname}</td>";
      echo "<td>{$user_lastname}</td>";
      echo "<td>{$user_email}</td>";

      // $query = "SELECT * FROM posts WHERE post_id = {$comment_post_id}";
      // $select_post_id_query = mysqli_query($connection, $query);
      // while ($row = mysqli_fetch_assoc($select_post_id_query)) {
      //   $post_id = $row["post_id"];
      //   $post_title = $row["post_title"];

      //   echo "<td><a href='../post.php?p_id=$post_id'>{$post_title}</a></td>";
      // }

      $role = $user_role == 0 ? "User" : "Admin";

      echo "<td>{$role}</td>";
      echo "<td><a href='users.php?change_to_admin={$user_id}'>Change To Admin</a></td>";
      echo "<td><a href='users.php?change_to_user={$user_id}'>Change To User</a></td>";
      echo "<td><a href='users.php?source=edit_user&u_id={$user_id}'>Edit</a></td>";
      echo "<td><a href='users.php?delete={$user_id}'>Delete</a></td>";
      echo "</tr>";
    }
    ?>
                                
    </tbody>
</table>

<?php
if (isset($_GET["change_to_admin"])) {
  $user_id = escape($_GET["change_to_admin"]);

  $query = "UPDATE users SET user_role = 1 WHERE user_id = {$user_id} ";
  $admin_role_query = mysqli_query($connection, $query);

  header("Location: users.php");

  confirmQuery($admin_role_query);
}

if (isset($_GET["change_to_user"])) {
  $user_id = escape($_GET["change_to_user"]);

  $query = "UPDATE users SET user_role = 0 WHERE user_id = {$user_id} ";
  $user_role_query = mysqli_query($connection, $query);

  header("Location: users.php");

  confirmQuery($user_role_query);
}

if (isset($_GET["delete"])) {
  if (isset($_SESSION["user_role"])) {
    if ($_SESSION["user_role"] == 1) {
      $comment_id = escape($_GET["delete"]);

      $query = "DELETE FROM users WHERE user_id = {$user_id} ";
      $delete_query = mysqli_query($connection, $query);

      header("Location: users.php");

      confirmQuery($delete_query);
    }
  }
}


?>
