<?php

namespace App\Controllers;

use App\Models\Product;
use Framework\Viewer;

class Products
{
    public function index()
    {
        $model = new Product;

        $products = $model->getData();

        $viewer = new Viewer;

        echo $viewer->render("Products/index.php", [
            "products" => $products
        ]);
    }

    public function show()
    {
        $viewer = new Viewer;

        echo $viewer->render("Products/show.php");
    }
    <?php
...
    public function new()
    {
        // display empty form for new product
        $viewer = new Viewer;

        echo $viewer->render("shared/header.php", [
            "title" => "New Product"
        ]);

        echo $viewer->render("Products/new.php");
    }

    public function create()
    {
        // create a data array to hold form field data
        $data = [
            "name" => $_POST["name"],
            "description" => $_POST["description"]
        ];

        $model = new Product;

        // capture the last ID inserted into the db for a new record
        $insertID = $model->insert($data);

        // used to check successful database insert of new record
        if ($insertID) {

            // use insertID to redirect the user to the product page for the new product
            header("Location: " . WEB_ROOT . "products/{$id}/show");
            exit;

        } else {

            // default form view for form with errors displayed
            $viewer = new Viewer;

            echo $viewer->render("shared/header.php", [
                "title" => "New Product"
            ]);

            echo $viewer->render("Products/new.php", [
                "errors" => $model->getErrors()
            ]);
        }
    }
}
<?php
...
<?php
...
    public function update(string $id, array $data): bool
    {
        if ( ! $this->validate($data) ) {
            return false;
        }

        unset($data["id"]);

        $fields = array_keys($data);

        array_walk($fields, function (&$value) {
            $value = "$value = ?";
        });

        $sql = "UPDATE `products` SET " . implode(", ", $fields) . " WHERE id = ?";

        $conn = $this->getConnection();

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(1, $data["name"], PDO::PARAM_STR);
        $stmt->bindValue(2, $data["description"], PDO::PARAM_STR);
        $stmt->bindValue(3, $id, PDO::PARAM_INT);

        return $stmt->execute();
    }