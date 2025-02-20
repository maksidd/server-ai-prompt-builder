<?php
// controllers/BlockController.php

require_once __DIR__ . '/../models/Block.php';
require_once __DIR__ . '/../config/db.php';

class BlockController
{
    private $blockModel;

    public function __construct()
    {
        global $pdo;
        $this->blockModel = new Block($pdo);
    }

    public function getBlocks()
    {
        $blocks = $this->blockModel->getBlocks();
        echo json_encode($blocks);
    }

    public function createBlock()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        // Валидация данных
        if (empty($data['content']) || empty($data['category'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid block data']);
            return;
        }

        // Создание блока
        $id = $this->blockModel->createBlock($data);
        echo json_encode(['id' => $id, 'content' => $data['content']]);
    }

    public function updateBlock($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $result = $this->blockModel->updateBlock($id, $data);
        echo json_encode(['updated' => $result]);
    }

    public function deleteBlock($id)
    {
        $result = $this->blockModel->deleteBlock($id);
        echo json_encode(['deleted' => $result]);
    }
}