<?php include "includes/admin_header.php"; ?>

<?php if (isset($_SESSION["username"])) {

  $username = $_SESSION["username"];

  $query = "SELECT * FROM users WHERE username = '{$username}' ";
  $select_current_user_profile_query = mysqli_query($connection, $query);
  confirmQuery($select_current_user_profile_query);

  while ($row = mysqli_fetch_array($select_current_user_profile_query)) {
    $user_id = $row["user_id"];
    $user_firstname = $row["user_firstname"];
    $user_lastname = $row["user_lastname"];
    $username = $row["username"];
    $user_password = $row["user_password"];
    $user_email = $row["user_email"];
    // $user_role = $row["user_role"];
    // $user_image = $row["user_image"];
  }
  ?>

  <?php if (isset($_POST["edit_current_user"])) {
    $user_firstname = $_POST["user_firstname"];
    $user_lastname = $_POST["user_lastname"];
    $username = $_POST["username"];
    $user_password = $_POST["user_password"];
    $user_email = $_POST["user_email"];
    // $user_role = $_POST["user_role"];

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

    $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, [
      "cost" => 12,
    ]);

    $query = "UPDATE users SET ";
    $query .= "user_firstname = '{$user_firstname}', ";
    $query .= "user_lastname = '{$user_lastname}', ";
    $query .= "username = '{$username}', ";
    $query .= "user_password = '{$hashed_password}', ";
    $query .= "user_email = '{$user_email}' ";
    // $query .= "user_role = '{$user_role}' ";
    // $query .= "post_image  = '{$post_image}' ";
    $query .= "WHERE user_id = {$user_id} ";

    $edit_user_query = mysqli_query($connection, $query);

    header("Location: users.php");

    confirmQuery($edit_user_query);
  }
} ?>

    <div id="wrapper">

        <!-- Navigation -->
<?php include "includes/admin_nav.php"; ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to admin
                            <small>Author</small>
                        </h1>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Firstname</label>
        <input type="text" value="<?php echo $user_firstname; ?>" class="form-control" name="user_firstname"/>
    </div>

    <!-- <div class="form-group">
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
    </div> -->

    <div class="form-group">
        <label for="post_author">Lastname</label>
        <input type="text" value="<?php echo $user_lastname; ?>" class="form-control" name="user_lastname"/>
    </div>

    <div class="form-group">
        <label for="post_status">Username</label>
        <input type="text" value="<?php echo $username; ?>" class="form-control" name="username"/>
    </div>

    <div class="form-group">
        <label for="post_status">Password</label>
        <input autocomplete="off" type="password" class="form-control" name="user_password"/>
    </div>

    <div class="form-group">
        <label for="post_status">Email</label>
        <input type="emai;" value="<?php echo $user_email; ?>" class="form-control" name="user_email"/>
    </div>

    <!-- <div class="form-group">
        <label for="post_image">User Image</label>
        <input type="file" name="post_image"/>
    </div> -->

    <div class="form-group">
        <button class="btn btn-primary" type="submit" name="edit_current_user">Update Profile</button>
    </div>
</form>


                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

        <?php include "includes/admin_footer.php"; ?>
