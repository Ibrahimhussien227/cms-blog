<?php

if (isset($_POST["checkBoxArray"])) {
  foreach ($_POST["checkBoxArray"] as $postValueId) {
    $bulk_options = $_POST["bulk_options"];

    switch ($bulk_options) {
      case "published":
        $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id= {$postValueId}";
        $update_to_published_status = mysqli_query($connection, $query);
        confirmQuery($update_to_published_status);
        break;

      case "draft":
        $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id= {$postValueId}";
        $update_to_draft_status = mysqli_query($connection, $query);
        confirmQuery($update_to_draft_status);
        break;
      case "delete":
        $query = "DELETE FROM posts WHERE post_id= {$postValueId}";
        $update_to_delete = mysqli_query($connection, $query);
        confirmQuery($update_to_delete);
        break;

      case "clone":
        $query = "SELECT * FROM posts WHERE post_id= {$postValueId}";
        $select_post_query = mysqli_query($connection, $query);
        confirmQuery($select_post_query);

        while ($row = mysqli_fetch_array($select_post_query)) {
          $post_title = $row["post_title"];
          $post_category_id = $row["post_category_id"];
          $post_date = $row["post_date"];
          $post_author = $row["post_author"];
          $post_status = $row["post_status"];
          $post_image = $row["post_image"];
          $post_tags = $row["post_tags"];
          $post_content = $row["post_content"];
        }

        $query =
          "INSERT INTO posts (post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status) ";
        $query .= "VALUES ({$post_category_id}, '{$post_title}', '{$post_author}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}') ";
        $clone_query = mysqli_query($connection, $query);
        confirmQuery($clone_query);
        header("Location: posts.php");
        break;

      default:
        # code...
        break;
    }
  }
} ?>

<form action="" method="post">

  <div id="bulkOptionContainer" class="col-xs-4 bulkOptionContainer">
    <select class="form-control" name="bulk_options" id="">
    <option selected disabled hidden>Select Option</option>
      <option value="published">Published</option>
      <option value="draft">Draft</option>
      <option value="delete">Delete</option>
      <option value="clone">Clone</option>
    </select>
  </div>

  <div class="col-xs-4">
    <button type="submit" name="submit" class="btn btn-success">Apply</button>
    <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
  </div>

  <table class="table table-bordered table-hover">
      <thead>
          <tr>
            <th><input id="selectAllBoxes" type="checkbox"/></th>
            <th>Id</th>
            <th>User</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Image</th>
            <th>Tags</th>
            <th>Comments</th>
            <th>Date</th>
            <th>View Post</th>
            <th>Edit</th>
            <th>Delete</th>
            <th>Views</th>
          </tr>
      </thead>
      <tbody>

      <?php
      $query = "SELECT * FROM posts ORDER BY post_id DESC";
      $select_all_posts = mysqli_query($connection, $query);

      confirmQuery($select_all_posts);
      while ($row = mysqli_fetch_assoc($select_all_posts)) {

        $post_id = $row["post_id"];
        $post_author = $row["post_author"];
        $post_user = $row["post_user"];
        $post_title = $row["post_title"];
        $post_category_id = $row["post_category_id"];
        $post_status = $row["post_status"];
        $post_image = $row["post_image"];
        $post_tags = $row["post_tags"];
        $post_comment_count = $row["post_comment_count"];
        $post_date = $row["post_date"];
        $post_view_count = $row["post_view_count"];

        echo "<tr>";
        ?>

        <td><input class="checkBoxes" type="checkbox" name="checkBoxArray[]" value="<?php echo $post_id; ?>"/></td>

        <?php
        echo "<td>{$post_id}</td>";

        if (!empty($post_author)) {
          echo "<td>{$post_author}</td>";
        } elseif (!empty($post_user)) {
          echo "<td>{$post_user}</td>";
        }

        echo "<td>{$post_title}</td>";

        $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id} ";
        $select_categories_id = mysqli_query($connection, $query);

        confirmQuery($select_categories_id);
        while ($row = mysqli_fetch_assoc($select_categories_id)) {
          $cat_id = $row["cat_id"];
          $cat_title = $row["cat_title"];

          echo "<td>{$cat_title}</td>";
        }

        echo "<td>{$post_status}</td>";
        echo "<td><img width='100' src='../images/$post_image' alt='post-image'/></td>";
        echo "<td>{$post_tags}</td>";

        $query = "SELECT * FROM comments WHERE comment_post_id = {$post_id}";
        $send_comment_query = mysqli_query($connection, $query);

        $count_comments = mysqli_num_rows($send_comment_query);

        echo "<td><a href='post_comments.php?id=$post_id'>{$count_comments}</a></td>";

        echo "<td>{$post_date}</td>";
        echo "<td><a href='../post.php?p_id={$post_id}'>View Post</a></td>";
        echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
        ?>

        <form method="post">

        <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">

        <?php echo '<td><input class="btn btn-danger" type="submit" name="delete" value="Delete"></td>'; ?>


        </form>

        <?php
        // echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete?'); \" href='posts.php?delete={$post_id}'>Delete</a></td>";
        echo "<td><a href='posts.php?reset={$post_id}'>{$post_view_count}</a></td>";
        echo "</tr>";

      }
      ?>
                                  
      </tbody>
  </table>
</form>

<?php
if (isset($_POST["delete"])) {
  $post_id = escape($_POST["post_id"]);

  $query = "DELETE FROM posts WHERE post_id = {$post_id} ";
  $delete_query = mysqli_query($connection, $query);

  header("Location: /cms/admin/posts.php");

  confirmQuery($delete_query);
}

if (isset($_GET["reset"])) {
  $post_id = escape($_GET["reset"]);

  $query =
    "UPDATE posts SET post_view_count = 0 WHERE post_id =" . $post_id . "";
  $reset_query = mysqli_query($connection, $query);

  header("Location: posts.php");

  confirmQuery($reset_query);
}


?>
