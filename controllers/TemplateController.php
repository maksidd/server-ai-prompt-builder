<?php
// controllers/TemplateController.php

require_once __DIR__ . '/../models/Template.php';
require_once __DIR__ . '/../config/db.php';

class TemplateController
{
    private $templateModel;

    public function __construct()
    {
        global $pdo;
        $this->templateModel = new Template($pdo);
    }

    public function getTemplates()
    {
        $templates = $this->templateModel->getTemplates();
        echo json_encode($templates);
    }


    public function createTemplate()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        // Валидация данных
        if (empty($data['title']) || empty($data['content'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid template data']);
            return;
        }

        // Создание шаблона
        $id = $this->templateModel->createTemplate($data);
        echo json_encode(['id' => $id, 'title' => $data['title']]);
    }

    public function deleteTemplate($id)
    {
        $result = $this->templateModel->deleteTemplate($id);
        echo json_encode(['deleted' => $result]);
    }
}
