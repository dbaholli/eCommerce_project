<?php
    session_start();
    include 'classes/autoload.php';
    $products = new Products;

    if(isset($_GET['action']) && ($_GET['action'] == 'add_to_cart')) {
        if(isset($_GET['product_id']) && (is_numeric($_GET['product_id']))) {
            add_to_cart($products->get($_GET['product_id']));
        }
    }

    /** 
     * 
     * 
     * 
     */

    function add_to_cart($products) {

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | e-commerce</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
</head>
<body>

    <div class="container my-5">
        <div class="row">
            <?php foreach($products->all() as $product): ?>
                <div class="col-md-4 my-2">
                    <div class="card">
                        <div class="card-body">
                            <?php
                                $images = json_decode($product['images'], true);

                                if(count($images)) {
                            ?>
                                <img src="./assets/img/products/<?= $images[0] ?>" alt="<?= $product['title'] ?>" class="img-fluid" />
                                <?php } ?>
                            <h4><?= $product['title'] ?></h4>
                            <p>
                                Price: <strong><?= $product['price'] ?></strong>
                            </p>
                            <form method="POST">
                                    <input type="number" name="qty" min="1" max="<?= $product['qty'] ?>" value="1">
                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-primary">Add to cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    
</body>
</html>