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

    public function getTemplate($id)
    {
        $template = $this->templateModel->getTemplate($id);
        if (!$template) {
            http_response_code(404);
            echo json_encode(['error' => 'Template not found']);
            return;
        }
        echo json_encode($template);
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

    public function updateTemplate($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $result = $this->templateModel->updateTemplate($id, $data);
        echo json_encode(['updated' => $result]);
    }

    public function deleteTemplate($id)
    {
        $result = $this->templateModel->deleteTemplate($id);
        echo json_encode(['deleted' => $result]);
    }
}