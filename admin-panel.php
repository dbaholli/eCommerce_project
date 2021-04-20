<?php
    session_start();
    include 'autoload.php';

    $errors = [];

    $p = new Products;
    $products = $p->all();

    if(isset($_POST['save_product_btn'])) {
        $title = $_POST['title'];  
        $price = $_POST['price'];   
        $qty = $_POST['qty'];

        $images = [];
        // $upload_errors = false;

        // foreach($_FILES['images']['size'] as $image_size) {
        //     if($image_size > 123123123)
        //         $upload_errors = true; 
        // }

        // echo "<pre>";
        // if($upload_errors) { 
        //     foreach($_FILES['images']['name'] as $image_name) {
        //         $images[] = $images;
        //     }
        // }


        if(!empty($title) && !empty($price) && !empty($qty) && count($_FILES['images']['name'])) {
            foreach($_FILES['images']['name'] as $image_name) {
                $images[] = $image_name;
            }
    
            foreach($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                move_uploaded_file($images[$key], "assets/img/products/".$tmp_name);
            }
            if($p->create(['title' => $title, 'price' => $price, 'qty' => $qty, 'images' => json_encode($images)]))
                header("Location: admin-panel.php");
            else 
                $errors[] = "Something went wrong while adding the product!";
        } else 
            $errors[] = "All fields are required!";

    }

    if(isset($_GET['action']) && ($_GET['action'] == 'edit')) {
        if(isset($_GET['product_id']) && (is_numeric($_GET['product_id']))) {
            $_SESSION['product_id'] = $_GET['product_id'];
            header("Location: edit-product.php");
        } else 
            $errors[] = "Product doesnt exist!";
    }

    if(isset($_GET['action']) && ($_GET['action'] == 'delete')) {
        if(isset($_GET['product_id']) && (is_numeric($_GET['product_id']))) {
            if($p->delete($_GET['product_id'])) 
                header("Location: admin-panel.php");
            else
                $errors[] = "Something went wrong while deleting product with id: " .$_GET['product_id'];
        } else 
            $errors[] = "Product doesnt exist!";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | e-commerce</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
</head>
<body>

    <div class="container my-5">
    <h3>Create product</h3>
        <div class="row">
            <!-- CREATE PRODUCT --->
            <div class="col-md-8">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" class="form-control" id="title" />
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="text" name="price" class="form-control" id="price" />
                    </div>
                    <div class="form-group">
                        <label for="qty">Quantity</label>
                        <input type="number" name="qty" class="form-control" id="qty" />
                    </div>
                    <div class="form-group">
                        <label for="images">Images</label>
                        <br />
                        <input type="file" name="images[]" multiple  id="images" />
                    </div>
                    <button type="submit" name="save_product_btn" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container my-5">
    <h3>Products</h3>
        <div class="row">
            <!-- CREATE PRODUCT --->
            <div class="col-md-8">
                <?php if(count($products) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th></th>
                        </tr>
                        <?php foreach($products as $product): ?>
                            <tr>
                                <th><?= $product['id'] ?></th>
                                <th><?= $product['title'] ?></th>
                                <th><?= $product['price'] ?> &euro;</th>
                                <th><?= $product['qty'] ?></th>
                                <th>
                                    <a href="?action=edit&product_id=<?= $product['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="?action=delete&product_id=<?= $product['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                                </th>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php else: ?>
                    0 products
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>