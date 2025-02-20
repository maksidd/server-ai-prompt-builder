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
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createBlock($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO blocks (content, category, tags) VALUES (:content, :category, :tags)");
        $stmt->execute([
            'content' => $data['content'],
            'category' => $data['category'],
            'tags' => json_encode($data['tags'])
        ]);
        return $this->pdo->lastInsertId();
    }

    public function updateBlock($id, $data)
    {
        $fields = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
        }
        $query = "UPDATE blocks SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $data['id'] = $id;
        $stmt->execute($data);
        return $stmt->rowCount();
    }

    public function deleteBlock($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM blocks WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount();
    }
}
