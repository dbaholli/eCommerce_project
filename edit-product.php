<?php
    session_start();
    include 'autoload.php';

    $errors = [];

    $id = $_SESSION['product_id'];
    $products = new Products;

    if($id > 0) 
        $product = $products->get($id);
    
    if(isset($_POST['update_product_btn'])) {
        $title = $_POST['title'];  
        $price = $_POST['price'];   
        $qty = $_POST['qty'];   

        if(!empty($title) && !empty($price) && !empty($qty)) {
            if($products->update($id, ['title' => $title, 'price' => $price, 'qty' => $qty]))
                header("Location: admin-panel.php");
            else 
                $errors[] = "Something went wrong while updating the product!";
        } else 
            $errors[] = "All fields are required!";
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
    <h3>Update product</h3>
        <div class="row">
        <?php
            if(count($errors)) {
        ?>
            <div class="alert alert-danger">
            <ul>
                <?php foreach($errors as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
                </ul>
            </div>
        <?php
            }
        ?>
            <!-- CREATE PRODUCT --->
            <div class="col-md-8">
                <form method="POST">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" class="form-control" id="title" value="<?= $product['title'] ?>" />
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="text" name="price" class="form-control" id="price" value="<?= $product['price'] ?>" />
                    </div>
                    <div class="form-group">
                        <label for="qty">Quantity</label>
                        <input type="number" name="qty" class="form-control" id="qty" value="<?= $product['qty'] ?>" />
                    </div>
                    <div class="form-group">

                    </div>
                    <div class="form-group">
                        <label for="images">Images</label>
                        <br />
                        <input type="file" name="images[]" multiple  id="images" />
                    </div>
                    <button type="submit" name="update_product_btn" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>