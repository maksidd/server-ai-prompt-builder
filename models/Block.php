<?php
// models/Block.php

class Block
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getBlocks()
    {
        $stmt = $this->pdo->query("SELECT * FROM blocks");
        $blocks = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($blocks as &$block) {
            if (isset($block['tags'])) {
                $block['tags'] = json_decode($block['tags'], true);
            }
        }
        return $blocks;
    }

    public function createBlock($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO blocks (content, category, tags) VALUES (:content, :category, :tags::jsonb)");
        $stmt->execute([
            'content' => $data['content'],
            'category' => $data['category'],
            'tags' => json_encode($data['tags'])
        ]);
        return $this->pdo->lastInsertId();
    }

    public function updateBlock($id, $data)
    {
        $stmt = $this->pdo->prepare("
            UPDATE blocks 
            SET content = :content, category = :category, tags = :tags::jsonb 
            WHERE id = :id
        ");
        $stmt->execute([
            'content' => $data['content'],
            'category' => $data['category'],
            'tags' => json_encode($data['tags']), // преобразуем массив в JSON
            'id' => $id
        ]);
        return $stmt->rowCount();
    }

    public function deleteBlock($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM blocks WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount();
    }
}
