<div align="center">

# 🚀 AI WebChat – Simple PHP + JS Chatbot (OpenRouter API)

[![PHP Version](https://img.shields.io/badge/PHP-7.4%2B-777bb4?style=for-the-badge&logo=php)](https://www.php.net/)
[![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)](LICENSE)
[![AI Powered](https://img.shields.io/badge/AI-OpenRouter-orange?style=for-the-badge)](https://openrouter.ai/)

**AI WebChat** is a web-based chatbot application that leverages the **OpenRouter API** to access various AI models like **DeepSeek, GPT, and Llama**. Built with a focus on simplicity, security, and responsiveness.

</div>

---

## Key Features

- **Real-time Interactive Chat** – Seamless communication with AI.
- **Multi-Model Support** – Access any model available via OpenRouter (DeepSeek, GPT, Llama, etc.).
- **Secure API Handling** – API Keys are stored server-side to prevent exposure in the browser.
- **Modern & Responsive UI** – Fully optimized for both desktop and mobile devices.
- **Lightweight & Fast** – Minimalist codebase, perfect for personal assistants or integration.
- **Dark Mode Support** – Comfortable viewing experience in low-light environments.
- **Extensible** – Easy to customize for customer service, virtual assistants, or educational tools.

---

## Installation Guide

### 1. Clone the Repository
```bash
git clone https://github.com/pangeran-droid/AI-WebChat.git
cd AI-WebChat
   ```

### 2. Configure Your API Key

Open `config.php` and insert your OpenRouter API key:
```php
<?php 
return [
    'OPENROUTER_KEY' => 'YOUR_API_KEY_HERE'
];
```
Get your API key from ([get one here](https://openrouter.ai/)).

### 3. Run on Local Server (XAMPP / Laragon / Hosting)

Move the project folder to your server directory:
- XAMPP → `htdocs/AI-WebChat`
- Laragon → `www/AI-WebChat`

Access it in your browser via:
```bash
http://localhost/AI-WebChat
```

### Tech Stack

- HTML5 + CSS3 – Frontend UI
- Vanilla JavaScript – Chat logic
- PHP – Server-side request handler
- OpenRouter API – AI model provider

### Roadmap
- [ ] 💾 Chat History – Save conversations using LocalStorage or Database.
- [ ] 👤 Avatars – Custom profile pictures for AI and users.
- [ ] ⚡ Streaming Responses – Real-time text generation (typing effect).
- [ ] 🎤 Multimodal – Support for image uploads and voice input.
- [ ] 🤖 Direct Integration – Native support for OpenAI, Anthropic, and Gemini.

### Licensi
**MIT License.**

