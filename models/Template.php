<?php
// models/Template.php

class Template
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getTemplates()
    {
        $stmt = $this->pdo->query("SELECT * FROM templates");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTemplate($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM templates WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createTemplate($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO templates (title, description, content, tags, rating) VALUES (:title, :description, :content, :tags, :rating)");
        $stmt->execute([
            'title' => $data['title'],
            'description' => $data['description'],
            'content' => $data['content'],
            'tags' => json_encode($data['tags']),
            'rating' => $data['rating']
        ]);
        return $this->pdo->lastInsertId();
    }

    public function updateTemplate($id, $data)
    {
        $fields = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
        }
        $query = "UPDATE templates SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $data['id'] = $id;
        $stmt->execute($data);
        return $stmt->rowCount();
    }

    public function deleteTemplate($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM templates WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount();
    }
}