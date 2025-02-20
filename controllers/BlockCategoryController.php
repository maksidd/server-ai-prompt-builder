<?php
// controllers/BlockCategoryController.php

require_once __DIR__ . '/../models/BlockCategory.php';
require_once __DIR__ . '/../config/db.php';

class BlockCategoryController
{
    private $blockCategoryModel;

    public function __construct()
    {
        global $pdo;
        $this->blockCategoryModel = new BlockCategory($pdo);
    }

    public function getBlockCategories()
    {
        $categories = $this->blockCategoryModel->getBlockCategories();
        echo json_encode($categories);
    }

    public function createBlockCategory()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        // Валидация данных
        if (empty($data['name']) || !is_string($data['name'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid category data']);
            return;
        }

        // Создание категории
        $id = $this->blockCategoryModel->createBlockCategory(['name' => $data['name']]);
        echo json_encode(['id' => $id, 'name' => $data['name']]);
    }
}
