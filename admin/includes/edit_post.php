<?php
if (isset($_GET["p_id"])) {
  $post_id = escape($_GET["p_id"]);
}

$query = "SELECT * FROM posts WHERE post_id = {$post_id} ";
$select_post_by_id = mysqli_query($connection, $query);
while ($row = mysqli_fetch_assoc($select_post_by_id)) {
  $post_id = $row["post_id"];
  $post_user = $row["post_user"];
  $post_title = $row["post_title"];
  $post_content = $row["post_content"];
  $post_category_id = $row["post_category_id"];
  $post_status = $row["post_status"];
  $post_image = $row["post_image"];
  $post_tags = $row["post_tags"];
  $post_comment_count = $row["post_comment_count"];
  $post_date = $row["post_date"];
}

if (isset($_POST["update_post"])) {
  $post_user = escape($_POST["post_user"]);
  $post_title = escape($_POST["post_title"]);
  $post_category_id = escape($_POST["post_category_id"]);
  $post_status = escape($_POST["post_status"]);

  $post_image = escape($_FILES["post_image"]["name"]);
  $post_image_temp = escape($_FILES["post_image"]["tmp_name"]);

  $post_content = escape($_POST["post_content"]);
  $post_tags = escape($_POST["post_tags"]);

  move_uploaded_file($post_image_temp, "../images/$post_image");

  if (empty($post_image)) {
    $query = "SELECT * FROM posts WHERE post_id = $post_id";
    $select_image_query = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_array($select_image_query)) {
      $post_image = $row["post_image"];
    }
  }

  $query = "UPDATE posts SET ";
  $query .= "post_title  = '{$post_title}', ";
  $query .= "post_category_id = '{$post_category_id}', ";
  $query .= "post_date   =  now(), ";
  $query .= "post_user = '{$post_user}', ";
  $query .= "post_status = '{$post_status}', ";
  $query .= "post_tags   = '{$post_tags}', ";
  $query .= "post_content= '{$post_content}', ";
  $query .= "post_image  = '{$post_image}' ";
  $query .= "WHERE post_id = {$post_id} ";

  $update_post_query = mysqli_query($connection, $query);

  // header("Location: posts.php");

  confirmQuery($update_post_query);

  echo "<p class='bg-success'>Post Updated. <a href='../post.php?p_id={$post_id}'> View Post </a> OR <a href='posts.php'>Edit More Posts</a></p>";
}
?>



<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input value="<?php echo $post_title; ?>" type="text" class="form-control" name="post_title"/>
    </div>

    <div class="form-group">
        <label for="Categories">Categories</label>
        <select name="post_category_id" id="">
            <?php
            $query = "SELECT * FROM categories ";
            $select_categories = mysqli_query($connection, $query);
            confirmQuery($select_categories);

            while ($row = mysqli_fetch_assoc($select_categories)) {
              $cat_id = $row["cat_id"];
              $cat_title = $row["cat_title"];

              if ($post_category_id == $cat_id) {
                echo "<option selected value='{$cat_id}'>{$cat_title}</option>";
              } else {
                echo "<option value='{$cat_id}'>{$cat_title}</option>";
              }
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="users">Users</label>
        <select name="post_user" id="">
            <?php
            $query = "SELECT * FROM users ";
            $select_users_query = mysqli_query($connection, $query);
            confirmQuery($select_users_query);

            while ($row = mysqli_fetch_assoc($select_users_query)) {
              $user_id = $row["user_id"];
              $username = $row["username"];

              if ($post_user == $username) {
                echo "<option selected value='{$username}'>{$username}</option>";
              } else {
                echo "<option value='{$username}'>{$username}</option>";
              }
            }
            ?>
        </select>
    </div>

    <div class="form-group">
      <select name="post_status" id="">
        <option value='<?php echo $post_status; ?>'><?php echo $post_status; ?></option>

        <?php if ($post_status == "published") {
          echo "<option value='draft'>Draft</option";
        } else {
          echo "<option value='published'>Published</option";
        } ?>
      </select>
    </div>

    <div class="form-group">
        <img src="../images/<?php echo $post_image; ?>" alt=""/>
        <input type="file" name="post_image"/>
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input value="<?php echo $post_tags; ?>" type="text" class="form-control" name="post_tags"/>
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control" name="post_content" id="" cols="30" rows="10"><?php echo $post_content; ?></textarea>
    </div>

    <div class="form-group">
        <button class="btn btn-primary" type="submit" name="update_post">Update Post</button>
    </div>
</form>
