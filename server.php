<?php
header('Content-Type: application/json');

// 1. Pega a mensagem do usuário
$input = json_decode(file_get_contents("php://input"), true);
$userMessage = $input['message'] ?? "";

if (!$userMessage) {
    echo json_encode(["error" => "Mensagem vazia"]);
    exit;
}

// 2. BUSCA A CHAVE DA API (Corrigido para ler do Railway ou do arquivo)
$apiKey = getenv('OPENROUTER_KEY');

if (!$apiKey) {
    // Se não estiver no Railway, tenta ler do arquivo config.php
    $configFile = __DIR__ . '/config/config.php';
    if (file_exists($configFile)) {
        $config = include $configFile;
        $apiKey = $config['OPENROUTER_KEY'] ?? null;
    }
}

if (!$apiKey) {
    echo json_encode(["error" => "API Key não encontrada. Configure OPENROUTER_KEY no Railway."]);
    exit;
}

// 3. Pega o prompt do sistema
$systemPromptFile = __DIR__ . "/system_prompt.txt";
$systemPrompt = file_exists($systemPromptFile) ? file_get_contents($systemPromptFile) : "Você é um assistente útil.";

// 4. Configura a chamada para a OpenRouter
$ch = curl_init("https://openrouter.ai/api/v1/chat/completions");

$payload = [
    // Mudei para um modelo gratuito para garantir que funcione sem saldo
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
        "HTTP-Referer: http://localhost", // Obrigatório pela OpenRouter
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

// 5. Retorna a resposta para o Chat
echo $response;
?>
