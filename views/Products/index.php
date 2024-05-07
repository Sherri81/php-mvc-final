<!DOCTYPE html>
<html lang="en">

<head>
<a href="/products/new">New Product</a>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products</title>
</head>

<body>

  <h1>Products</h1>

  <?php foreach ($products as $product) : ?>
    <h2><?= htmlspecialchars($product["name"]) ?></h2>
    <p><?= htmlspecialchars($product["description"]) ?></p>
  <?php endforeach; ?>

</body>

<h1>Edit Product Page</h1>

<form action="/products/<?= $product["id"] ?>/update" method="post">

<!-- include the form contents from the new form.php -->
<?php require "form.php" ?>

</form>

<p><a href="/products/<?= $product["id"] ?>/show">Cancel</a></p>

<h1>Delete Product</h1>

<form action="/products/<?= $product["id"] ?>/delete" method="post">

<p>Are you sure you want to delete this product?</p>

<button>Yes</button>

</form>

<p><a href="/products/<?= $product["id"] ?>/show">Cancel</a></p>
  </body>

</html>