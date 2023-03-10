<?php if (isset($_POST["create_post"])) {
  $post_title = escape($_POST["title"]);
  $post_user = escape($_POST["post_user"]);
  $post_category_id = escape($_POST["post_category_id"]);
  $post_status = escape($_POST["post_status"]);

  $post_image = escape($_FILES["post_image"]["name"]);
  $post_image_temp = escape($_FILES["post_image"]["tmp_name"]);

  $post_tags = escape($_POST["post_tags"]);
  $post_content = escape($_POST["post_content"]);
  $post_date = escape(date("d-m-y"));

  move_uploaded_file($post_image_temp, "../images/$post_image");

  $query =
    "INSERT INTO posts(post_category_id, post_title, post_user, post_date, post_image, post_content, post_tags, post_status)";
  $query .= "VALUES({$post_category_id}, '{$post_title}', '{$post_user}', now(), '{$post_image}',' {$post_content}', '{$post_tags}', '{$post_status}' )";

  $create_post_query = mysqli_query($connection, $query);

  confirmQuery($create_post_query);

  $post_id = mysqli_insert_id($connection);

  echo "<p class='bg-success'>Post Created. <a href='../post.php?p_id={$post_id}'> View Post </a> OR <a href='posts.php'>Edit More Posts</a></p>";
} ?>


<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title"/>
    </div>

    <div class="form-group">
        <label for="categories">Categories</label>
        <select name="post_category_id" id="">
            <option selected disabled hidden>Select Category</option>
            <?php
            $query = "SELECT * FROM categories ";
            $select_categories = mysqli_query($connection, $query);
            confirmQuery($select_categories);

            while ($row = mysqli_fetch_assoc($select_categories)) {
              $cat_id = $row["cat_id"];
              $cat_title = $row["cat_title"];

              echo "<option value='{$cat_id}'>{$cat_title}</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="users">Users</label>
        <select name="post_user" id="">
            <option selected disabled hidden>Select User</option>
            <?php
            $query = "SELECT * FROM users ";
            $select_users_query = mysqli_query($connection, $query);
            confirmQuery($select_users_query);

            while ($row = mysqli_fetch_assoc($select_users_query)) {
              $user_id = $row["user_id"];
              $username = $row["username"];

              echo "<option value='{$username}'>{$username}</option>";
            }
            ?>
        </select>
    </div>

    <!-- <div class="form-group">
        <label for="post_author">Post Author</label>
        <input type="text" class="form-control" name="post_author"/>
    </div> -->

    <div class="form-group">
        <select name="post_status" id="">
            <option selected disabled hidden value="draft">Post Status</option>
            <option value="published">Publish</option>
            <option value="draft">Draft</option>
        </select>
    </div>

    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="post_image"/>
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags"/>
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control w-full" name="post_content" id="" cols="30" rows="10"></textarea>
    </div>

    <div class="form-group">
        <button class="btn btn-primary" type="submit" name="create_post">Publish Post</button>
    </div>
</form>