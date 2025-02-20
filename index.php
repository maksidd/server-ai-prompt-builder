<?php
// index.php

require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/controllers/BlockCategoryController.php';
require_once __DIR__ . '/controllers/TemplateController.php';
require_once __DIR__ . '/controllers/BlockController.php';

header("Content-Type: application/json");

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

$blockCategoryController = new BlockCategoryController();
$templateController = new TemplateController();
$blockController = new BlockController();

// Разделяем URL на части для обработки динамических маршрутов (например, /api/blocks/1)
$uriParts = explode('/', $requestUri);
$resource = $uriParts[2] ?? ''; // Например, 'blocks', 'templates'
$id = $uriParts[3] ?? null; // ID ресурса, например, 1, 2, 3

switch ($resource) {
    case 'block-categories':
        if ($requestMethod === 'GET') {
            $blockCategoryController->getBlockCategories();
        } elseif ($requestMethod === 'POST') {
            $blockCategoryController->createBlockCategory();
        }
        break;

    case 'templates':
        if ($requestMethod === 'GET') {
            $templateController->getTemplates();
        } elseif ($requestMethod === 'POST') {
            $templateController->createTemplate();
        } elseif ($requestMethod === 'DELETE' && $id) {
            $templateController->deleteTemplate($id);
        }
        break;

    case 'blocks':
        if ($requestMethod === 'GET') {
            $blockController->getBlocks();
        } elseif ($requestMethod === 'POST') {
            $blockController->createBlock();
        } elseif ($requestMethod === 'PATCH' && $id) {
            $blockController->updateBlock($id);
        } elseif ($requestMethod === 'DELETE' && $id) {
            $blockController->deleteBlock($id);
        }
        break;

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Route not found']);
        break;
}
