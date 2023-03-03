<?php if (isset($_POST["create_user"])) {
  $user_firstname = $_POST["user_firstname"];
  $user_lastname = $_POST["user_lastname"];
  $username = $_POST["username"];
  $user_password = $_POST["user_password"];
  $user_email = $_POST["user_email"];
  $user_role = $_POST["user_role"];

  $user_password = password_hash($user_password, PASSWORD_BCRYPT, [
    "cost" => 10,
  ]);

  // $user_image = $_FILES["user_image"]["name"];
  // $user_image_temp = $_FILES["user_image"]["tmp_name"];

  // move_uploaded_file($user_image_temp, "../images/$user_image");

  $query =
    "INSERT INTO users(user_firstname, user_lastname, username, user_password, user_email, user_role) ";

  $query .= "VALUES('{$user_firstname}', '{$user_lastname}', '{$username}', '{$user_password}', '{$user_email}', '{$user_role}') ";

  $create_user_query = mysqli_query($connection, $query);

  confirmQuery($create_user_query);

  echo "User " .
    $user_firstname .
    " Created: " .
    " " .
    "<a href='users.php'>View Users</a>";
} ?>


<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Firstname</label>
        <input type="text" class="form-control" name="user_firstname"/>
    </div>

    <div class="form-group">
        <select name="user_role" id="">
            <option value="0" selected disabled hidden>Select Option</option>
            <option value="0">User</option>
            <option value="1">Admin</option>
        </select>
    </div>

    <div class="form-group">
        <label for="post_author">Lastname</label>
        <input type="text" class="form-control" name="user_lastname"/>
    </div>

    <div class="form-group">
        <label for="post_status">Username</label>
        <input type="text" class="form-control" name="username"/>
    </div>

    <div class="form-group">
        <label for="post_status">Password</label>
        <input type="password" class="form-control" name="user_password"/>
    </div>

    <div class="form-group">
        <label for="post_status">Email</label>
        <input type="email" class="form-control" name="user_email"/>
    </div>

    <!-- <div class="form-group">
        <label for="post_image">User Image</label>
        <input type="file" name="post_image"/>
    </div> -->

    <div class="form-group">
        <button class="btn btn-primary" type="submit" name="create_user">Add User</button>
    </div>
</form>