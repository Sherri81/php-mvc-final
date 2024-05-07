<?php
...
    public function delete(string $id)
    {
        $model = new Product;

        $product = $model->find($id);

        // this if block checks the request method of the delete request
        // if the request method is post, the query will be executed
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $model->delete($id);

            header("Location: /products/index");
            exit;
        }

        // this block displays the initial delete verification page
        $viewer = new Viewer;

        echo $viewer->render("shared/header.php", [
            "title" => "Delete Product"
        ]);

        echo $viewer->render("Products/delete.php", [
            "product" => $product
        ]);
    }