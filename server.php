<?php

header('Content-Type: application/json');

$input = json_decode(file_get_contents("php://input"), true);
$userMessage = $input["message"] ?? "";

if (!$userMessage) {
    echo json_encode(["error" => "Pesan tidak boleh kosong"]);
    exit;
}

$configFile = __DIR__ . '/config/config.php';

if (!file_exists($configFile)) {
    echo json_encode(["error" => "config.php tidak ditemukan"]);
    exit;
}

$config = include $configFile;
$apiKey = $config['OPENROUTER_KEY'] ?? null;

if (!$apiKey) {
    echo json_encode(["error" => "API key tidak ditemukan di config"]);
    exit;
}

$systemPromptFile = __DIR__ . "/system_prompt.txt";

if (!file_exists($systemPromptFile)) {
    echo json_encode(["error" => "File system_prompt.txt tidak ditemukan"]);
    exit;
}

$systemPrompt = file_get_contents($systemPromptFile);

$ch = curl_init("https://openrouter.ai/api/v1/chat/completions");

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "Authorization: Bearer $apiKey",
        "User-Agent: AI-ChatBot/1.0"
    ],

    CURLOPT_POSTFIELDS => json_encode([
        "model" => "deepseek/deepseek-chat",   // model bisa diganti sesuai kebutuhan
        // "max_tokens" => 1000,
        "messages" => [
            ["role" => "system", "content" => $systemPrompt],
            ["role" => "user", "content" => $userMessage]
        ]
    ])
]);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode(["error" => curl_error($ch)]);
    exit;
}

$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$decoded = json_decode($response, true);

if (!$decoded) {
    $decoded = ["raw_response" => $response];
}

echo json_encode([
    "status" => $httpcode,
    "response" => $decoded
]);
?>
