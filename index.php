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

switch ($requestUri) {
    case '/api/block-categories':
        if ($requestMethod === 'GET') {
            $blockCategoryController->getBlockCategories();
        } elseif ($requestMethod === 'POST') {
            $blockCategoryController->createBlockCategory();
        }
        break;

    case '/api/templates':
        if ($requestMethod === 'GET') {
            $templateController->getTemplates();
        } elseif ($requestMethod === 'POST') {
            $templateController->createTemplate();
        }
        break;

    case '/api/blocks':
        if ($requestMethod === 'GET') {
            $blockController->getBlocks();
        } elseif ($requestMethod === 'POST') {
            $blockController->createBlock();
        }
        break;

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Route not found']);
        break;
}