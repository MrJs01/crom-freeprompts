<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Caminho para o arquivo JSON que contém os prompts
$jsonFile = 'prompts.json';

// Função para carregar os prompts do arquivo JSON
function loadPrompts() {
    global $jsonFile;

    if (file_exists($jsonFile)) {
        $jsonData = file_get_contents($jsonFile);

        // Verificar se o JSON é válido
        $prompts = json_decode($jsonData, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $prompts;
        } else {
            return []; // Retorna um array vazio se o JSON for inválido
        }
    }

    return [];
}

// Função para filtrar os prompts pela categoria ou por um termo de busca
function filterPrompts($prompts, $category = null, $searchTerm = null) {
    // Filtra por categoria se fornecida
    if ($category) {
        $prompts = array_filter($prompts, function ($prompt) use ($category) {
            return strtolower($prompt['category']) === strtolower($category);
        });
    }

    // Filtra por termo de busca, buscando no título e conteúdo
    if ($searchTerm) {
        $prompts = array_filter($prompts, function ($prompt) use ($searchTerm) {
            return strpos(strtolower($prompt['title']), strtolower($searchTerm)) !== false ||
                   strpos(strtolower($prompt['content']), strtolower($searchTerm)) !== false;
        });
    }

    return $prompts;
}

// Carregar todos os prompts do arquivo
$prompts = loadPrompts();

// Verificar se foi enviada uma requisição de filtro
$category = isset($_GET['category']) ? $_GET['category'] : null;
$searchTerm = isset($_GET['search']) ? $_GET['search'] : null;

// Filtrar os prompts conforme as condições passadas
$filteredPrompts = filterPrompts($prompts, $category, $searchTerm);

// Retorna os prompts filtrados como resposta JSON
header('Content-Type: application/json');
echo json_encode($filteredPrompts);
?>
