<?php

namespace App\Models;

use PDO;

class Product
{
    public function getConnection(): PDO
    {
        $dsn = "mysql:
                host={$_ENV['DB_HOST']};
                dbname={$_ENV['DB_NAME']};
                charset=utf8;
                port=3306";

        return new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES, false
        ]);
    }
    // create an empty array to store errors
    protected array $errors = [];

    // method to add errors when validation fails
    protected function addError(string $field, string $message): void
    {
        $this->errors[$field] = $message;
    }

    // method to test form data against validation requirements
    protected function validate(array $data): bool
    {
        if (empty($data["name"])) {
            
            $this->addError("name", "Required");

        }

        return empty($this->errors);
    }

    // method for returning errors on validation
    public function getErrors(): array
    {
        return $this->errors;
    }
public function insert(array $data): int|bool
        // validate form data
        if ( ! $this->validate($data) ) {
            return false;
        }

        $sql = "INSERT INTO `products` (name, description) VALUES (?, ?)";

        $conn = $this->getConnection();

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(1, $data["name"], PDO::PARAM_STR);
        $stmt->bindValue(2, $data["description"], PDO::PARAM_STR);

        $stmt->execute();

        return $conn->lastInsertId();
    }
    public function delete(string $id): bool
    {
        $sql = "DELETE FROM `products` WHERE id = :id";

        $conn = $this->getConnection();

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        return $stmt->execute();
}
    public function delete(string $id): bool
    {
        $sql = "DELETE FROM `products` WHERE id = :id";

        $conn = $this->getConnection();

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        return $stmt->execute();
    }