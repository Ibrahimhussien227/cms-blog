<?php
if (isset($_GET["u_id"])) {

  $user_id = escape($_GET["u_id"]);

  $query = "SELECT * FROM users WHERE user_id = $user_id ";
  $select_users_query = mysqli_query($connection, $query);

  while ($row = mysqli_fetch_assoc($select_users_query)) {
    $user_id = $row["user_id"];
    $username = $row["username"];
    $user_password = $row["user_password"];
    $user_firstname = $row["user_firstname"];
    $user_lastname = $row["user_lastname"];
    $user_email = $row["user_email"];
    $user_image = $row["user_image"];
    $user_role = $row["user_role"];
  }
  ?>

<?php // Post request to update user

  if (isset($_POST["edit_user"])) {
  $user_firstname = escape($_POST["user_firstname"]);
  $user_lastname = escape($_POST["user_lastname"]);
  $user_role = escape($_POST["user_role"]);
  $username = escape($_POST["username"]);
  $user_email = escape($_POST["user_email"]);
  $user_password = escape($_POST["user_password"]);
  $post_date = escape(date("d-m-y"));

  // $user_image = $_FILES["user_image"]["name"];
  // $user_image_temp = $_FILES["user_image"]["tmp_name"];

  // move_uploaded_file($user_image_temp, "../images/$user_image");

  // if (empty($post_image)) {
  //   $query = "SELECT * FROM posts WHERE post_id = $post_id";
  //   $select_image = mysqli_query($connection, $query);

  //   while ($row = mysqli_fetch_array($select_image)) {
  //     $post_image = $row["post_image"];
  //   }
  // }

  if (!empty($user_password)) {
    $query_password = "SELECT user_password FROM users WHERE user_id =  $user_id";
    $get_user_query = mysqli_query($connection, $query_password);
    confirmQuery($get_user_query);

    $row = mysqli_fetch_array($get_user_query);

    $db_user_password = $row["user_password"];

    if ($db_user_password != $user_password) {
      $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, [
        "cost" => 12,
      ]);
    }

    $query = "UPDATE users SET ";
    $query .= "user_firstname  = '{$user_firstname}', ";
    $query .= "user_lastname = '{$user_lastname}', ";
    $query .= "user_role   =  '{$user_role}', ";
    $query .= "username = '{$username}', ";
    $query .= "user_email = '{$user_email}', ";
    $query .= "user_password   = '{$hashed_password}' ";
    $query .= "WHERE user_id = {$user_id} ";

    $edit_user_query = mysqli_query($connection, $query);

    confirmQuery($edit_user_query);

    echo "User Updated" . " <a href='users.php'>View Users?</a>";
  } // if password empty check end
} // Post reques to update user end
} else {
  // If the user id is not present in the URL we redirect to the home page

  header("Location: index.php");
} ?>





<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Firstname</label>
        <input type="text" value="<?php echo $user_firstname; ?>" class="form-control" name="user_firstname"/>
    </div>

    <div class="form-group">
        <select name="user_role" id="">
          <?php
          $role = $user_role == 0 ? "User" : "Admin";
          echo "<option value='{$user_role}'>{$role}</option>";
          ?>
            
            <?php if ($user_role == 1) {
              echo "<option value='0'>User</option>";
            } else {
              echo "<option value='1'>Admin</option>";
            } ?>
        </select>
    </div>

    <div class="form-group">
        <label for="post_author">Lastname</label>
        <input type="text" value="<?php echo $user_lastname; ?>" class="form-control" name="user_lastname"/>
    </div>

    <div class="form-group">
        <label for="post_status">Username</label>
        <input type="text" value="<?php echo $username; ?>" class="form-control" name="username"/>
    </div>

    <div class="form-group">
        <label for="post_status">Email</label>
        <input type="emai;" value="<?php echo $user_email; ?>" class="form-control" name="user_email"/>
    </div>

    <div class="form-group">
        <label for="post_status">Password</label>
        <input autocomplete="off" type="password" class="form-control" name="user_password"/>
    </div>

    <!-- <div class="form-group">
        <label for="post_image">User Image</label>
        <input type="file" name="post_image"/>
    </div> -->

    <div class="form-group">
        <button class="btn btn-primary" type="submit" name="edit_user">Edit User</button>
    </div>
</form>
