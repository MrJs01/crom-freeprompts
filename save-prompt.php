<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Caminho para o arquivo JSON
$jsonFile = 'prompts.json';

// Função para carregar os prompts do arquivo JSON
// Função para carregar os prompts do arquivo JSON
function loadPrompts()
{
    global $jsonFile;
    if (file_exists($jsonFile)) {
        $jsonData = file_get_contents($jsonFile);
        $prompts = json_decode($jsonData, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $prompts;
        }
    }
    return [];
}

// Função para salvar os prompts no arquivo JSON
function savePrompts($prompts)
{
    global $jsonFile;
    file_put_contents($jsonFile, json_encode($prompts, JSON_PRETTY_PRINT));
}

// Verifica se é uma requisição POST e se a ação é "add" (adicionar)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';
    $category = isset($_POST['category']) ? $_POST['category'] : '';

    // Valida os dados
    if (!$title || !$content || !$category) {
        echo json_encode(['success' => false, 'message' => 'Todos os campos são obrigatórios!']);
        exit;
    }

    // Se o campo category for uma string com categorias separadas por vírgula, converte para um array
    if (strpos($category, ',') !== false) {
        $category = array_map('trim', explode(',', $category)); // Converte para array e remove espaços
    } else {
        $category = [$category]; // Se for uma única categoria, converte para array
    }

    // Carregar os prompts existentes
    $prompts = loadPrompts();

    // Calcular o próximo ID disponível
    $maxId = 0;
    foreach ($prompts as $prompt) {
        if (isset($prompt['id']) && $prompt['id'] > $maxId) {
            $maxId = $prompt['id'];
        }
    }
    $newId = $maxId + 1;

    // Criar o novo prompt com o ID gerado
    $newPrompt = [
        'id' => $newId, // Definindo o ID do novo prompt
        'title' => $title,
        'content' => $content,
        'category' => $category
    ];

    // Adicionar o novo prompt ao array
    $prompts[] = $newPrompt;

    // Salvar novamente o arquivo JSON
    savePrompts($prompts);

    echo json_encode(['success' => true]);
    exit;
}
