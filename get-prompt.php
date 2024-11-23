<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Caminho do arquivo JSON
$jsonFile = 'prompts.json';

// Função para carregar os prompts do arquivo JSON
function loadPrompts()
{
    global $jsonFile;
    if (file_exists($jsonFile)) {
        $jsonData = file_get_contents($jsonFile);
        // Verifica se o JSON é válido
        $prompts = json_decode($jsonData, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $prompts;
        } else {
            return []; // Retorna um array vazio se o JSON for inválido
        }
    }
    return [];
}

// Verifica se o parâmetro 'id' foi fornecido
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Converte para inteiro

    // Carrega os prompts
    $prompts = loadPrompts();

    // Procura pelo prompt com o ID fornecido
    foreach ($prompts as $prompt) {
        if ($prompt['id'] === $id) {
            echo json_encode($prompt); // Retorna o prompt como JSON
            exit;
        }
    }

    // Se o prompt não for encontrado, retorna um erro
    echo json_encode(['error' => 'Prompt não encontrado.']);
} else {
    echo json_encode(['error' => 'ID não fornecido.']);
}
