<?php
// Forçar a exibição de erros para descobrirmos o que está travando se não funcionar
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

$input = json_decode(file_get_contents("php://input"), true);
$userMessage = $input['message'] ?? "";

if (!$userMessage) {
    echo json_encode(["error" => "Mensagem vazia"]);
    exit;
}

// Busca a chave no Railway
$apiKey = getenv('OPENROUTER_KEY');

if (!$apiKey) {
    echo json_encode(["error" => "Chave OPENROUTER_KEY não configurada no Railway"]);
    exit;
}

// Prompt padrão caso o arquivo não seja encontrado
$systemPrompt = "Você é um assistente prestativo.";
$promptPath = __DIR__ . "/system_prompt.txt";
if (file_exists($promptPath)) {
    $systemPrompt = file_get_contents($promptPath);
}

$ch = curl_init("https://openrouter.ai/api/v1/chat/completions");

$payload = [
    "model" => "google/gemini-pro-1.5-exp-free-v2:free",
    "messages" => [
        ["role" => "system", "content" => $systemPrompt],
        ["role" => "user", "content" => $userMessage]
    ]
];

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "Authorization: Bearer " . $apiKey,
        "HTTP-Referer: https://railway.app", // Necessário para OpenRouter
        "X-Title: MeuChatBot"
    ],
    CURLOPT_POSTFIELDS => json_encode($payload)
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    echo json_encode(["error" => curl_error($ch)]);
    exit;
}
curl_close($ch);

// Retorna exatamente o que a OpenRouter respondeu
echo $response;
