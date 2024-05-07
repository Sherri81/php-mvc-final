<?php
...
    public function edit(string $id = NULL)
    {
        $model = new Product;

        $product = $model->find($id);

        if ($product === false) {

            throw new PageNotFoundException("Product not found");

        }

        $viewer = new Viewer;

        echo $viewer->render("shared/header.php", [
            "title" => "Edit Product"
        ]);

        echo $viewer->render("Products/edit.php", [
            "product" => $product
        ]);
    }
    