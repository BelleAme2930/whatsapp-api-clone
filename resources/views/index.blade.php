<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhatsApp API Server Clone</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-900">
<header class="bg-green-600 py-6 shadow-lg">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-white text-center">WhatsApp API Server Clone</h1>
        <p class="text-center text-gray-200 mt-2">A simulated WhatsApp API server, built using Laravel</p>
    </div>
</header>

<main class="py-10">
    <div class="container mx-auto px-4">
        <!-- About Section -->
        <section class="bg-white p-8 rounded-lg shadow-md mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">About This Project</h2>
            <p class="text-gray-700">
                This project is a clone of the WhatsApp API server, designed to replicate core functionalities such as creating chatrooms, sending messages, and managing chat interactions in real-time. It leverages Laravel and WebSocket for an efficient, responsive experience.
            </p>
        </section>

        <!-- Backend Overview Section -->
        <section class="bg-white p-8 rounded-lg shadow-md mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Backend Overview</h2>
            <p class="text-gray-700">
                This project is a fully functional backend solution ready to be integrated with any frontend application. It features:
            </p>
            <ul class="list-disc list-inside text-gray-700 mt-4 space-y-2">
                <li><strong>WebSocket functionality:</strong> Ensures real-time messaging and updates across chatrooms.</li>
                <li><strong>Multithreading support:</strong> Efficiently handles concurrent operations, providing smooth performance.</li>
                <li><strong>Comprehensive features:</strong> All core functionalities of a WhatsApp-like API, including chatroom management, message history, file attachments, and more.</li>
            </ul>
        </section>

        <!-- API Documentation Section -->
        <section class="bg-white p-8 rounded-lg shadow-md mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">API Documentation</h2>
            <p class="text-gray-700">
                Access the full API documentation, including endpoint details, request formats, and response examples.
            </p>
            <a href="/docs" class="inline-block mt-4 px-4 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition">
                View Markdown API Documentation
            </a>
        </section>

        <!-- Key Features Section -->
        <section class="bg-white p-8 rounded-lg shadow-md mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Key Features</h2>
            <ul class="list-disc list-inside text-gray-700 space-y-2">
                <li>Create and manage chatrooms, allowing users to join or leave at any time.</li>
                <li>List all available chatrooms, making it easy for users to discover active conversations.</li>
                <li>Enable users to send and receive text messages seamlessly within chatrooms.</li>
                <li>Support for file attachments in messages with no size limit, allowing users to share pictures and videos.
                    <ul class="list-disc list-inside ml-6">
                        <li>Attachments are saved on the server in designated directories (`root/picture`, `root/video`).</li>
                    </ul>
                </li>
                <li>Real-time messaging powered by WebSocket, ensuring instant updates across chatrooms for all connected users.</li>
                <li>Users automatically connect to the socket upon entering each chatroom, providing real-time engagement.</li>
                <li>Message history available for each chatroom, providing users with context for ongoing conversations.</li>
                <li>Multi-threading is used to handle chat features efficiently, ensuring smooth and responsive performance.</li>
                <li>Designed to follow the MVC pattern, ensuring a structured and maintainable codebase.</li>
                <li>Built-in maximum member count for each chatroom, preventing overcrowding and managing server load effectively.</li>
            </ul>
        </section>

        <!-- Usage Instructions Section -->
        <section class="bg-white p-8 rounded-lg shadow-md mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Usage Instructions</h2>
            <p class="text-gray-700">
                Follow these steps to interact with the API:
            </p>
            <ol class="list-decimal list-inside text-gray-700 mt-4 space-y-2">
                <li>Create a new chatroom by sending a POST request to the <code class="bg-gray-100 text-green-600 px-2 py-1 rounded">/api/chatrooms</code> endpoint.</li>
                <li>Join a chatroom and send messages using the <code class="bg-gray-100 text-green-600 px-2 py-1 rounded">/api/messages</code> endpoint.</li>
                <li>Use WebSocket for real-time updates; users in the same chatroom will see messages instantly.</li>
            </ol>
        </section>

        <!-- Contact Section -->
        <section class="bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Contact</h2>
            <p class="text-gray-700">
                For any questions or further information about this API, please reach out.
            </p>
            <p class="mt-4 text-gray-800">
                <span class="font-semibold">Email:</span> <a href="mailto:umairsaif.pk@gmail.com">umairsaif.pk@gmail.com</a>
            </p>
        </section>
    </div>
</main>

<footer class="bg-gray-800 py-6 mt-10">
    <div class="container mx-auto px-4 text-center text-gray-300">
        <p>&copy; {{ date('Y') }} WhatsApp API Server Clone. All rights reserved.</p>
    </div>
</footer>
</body>
</html>
