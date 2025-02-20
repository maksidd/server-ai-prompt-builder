<?php
// models/BlockCategory.php

class BlockCategory
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getBlockCategories()
    {
        $stmt = $this->pdo->query("SELECT * FROM block_categories");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createBlockCategory($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO block_categories (name) VALUES (:name)");
        $stmt->execute(['name' => $data['name']]);
        return $this->pdo->lastInsertId();
    }
}
