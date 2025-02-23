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
        $templates = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($templates as &$template) {
            if (isset($template['tags'])) {
                $template['tags'] = json_decode($template['tags'], true);
            }
        }
        return $templates;
    }

    public function createTemplate($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO templates (title, description, content, tags, rating) VALUES (:title, :description, :content, :tags::jsonb, :rating)");
        $stmt->execute([
            'title' => $data['title'],
            'description' => $data['description'],
            'content' => $data['content'],
            'tags' => json_encode($data['tags']),
            'rating' => $data['rating']
        ]);
        return $this->pdo->lastInsertId();
    }

    public function deleteTemplate($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM templates WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount();
    }
}
