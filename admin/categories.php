<?php include "includes/admin_header.php"; ?>

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

                        <div class="col-xs-6">

                        <!-- ADD CATEGORY -->
                        <?php insert_categories(); ?>

                        <form action="" method="post">
                            <div class="form-group">
                                <label for="cat_title">Add Category</label>
                                <input class="form-control" type="text" name="cat_title">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit" name="add_category">Add Category</button>
                            </div>
                        </form>
                        
                        <!-- EDIT AND INCLUDE QUERY -->
                        <?php if (isset($_GET["edit"])) {
                          $cat_id = $_GET["edit"];

                          include "includes/edit_categories.php";
                        } ?>

                        </div>
                        <!--Add Category Form-->

                        <div class="col-xs-6">

                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Category Title</th>
                                        <th>Edit</th>                                        
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <!-- FIND ALL CATEGORIES -->
                                <?php findAllCategories(); ?>

                                <!-- DELETE CATEGORY -->
                                <?php deleteCategory(); ?>
                            
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

        <?php include "includes/admin_footer.php"; ?>
