<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        hr{
            margin-top: 20px;
            margin-bottom: 20px;
        }
        ul li{
            margin-bottom: 10px;
        }
        h1, h2, h3, h4, h5, h6{
            margin-bottom: 10px;
        }
        .prose > p{
            margin-bottom: 8px;
        }
        .prose pre {
            border: 1px solid #D3DAEA;
            background: linear-gradient(to bottom,#fff 0,#fff .75rem,#f5f7fa .75rem,#f5f7fa 2.75rem,#fff 2.75rem,#fff 4rem);
            background-size: 100% 4rem;
            line-height: 2rem;
            padding: .66001rem 9.5px 9.5px;
        }
        .prose code:not(.prose pre code) {
            background-color: #f9f2f4;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            color: #c7254e;
            font-size: 0.875rem;
            font-family: Menlo, Monaco, Consolas, 'Courier New', monospace;
        }
        .prose pre {
            background-color: #1f2937;
            color: #f9fafb;
            padding: 1rem;
            border-radius: 0.5rem;
            overflow-x: auto;
            font-size: 0.875rem;
        }
        .prose table {
            width: 100%;
            border-collapse: collapse;
        }
        .prose table th, .prose table td {
            border: 1px solid #e5e7eb;
            padding: 0.75rem;
            text-align: left;
            font-size: 14px;
        }
        .prose table th {
            background-color: #f9fafb;
            font-weight: 500;
            font-size: 14px;
        }
        pre code{
            color: #36454F;
            font-weight: 500 !important;
        }
        h2{
            font-size: 24px;
            font-weight: 500;
        }
        h3{
            font-size: 20px;
            font-weight: 500;
        }
        h4{
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 20px;
        }
        strong{
            font-weight: 600 !important;
            font-size: 15px;
        }
        p, li{
            font-size: 14px;
        }
        table{
            margin-bottom: 20px;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900">
<div class="container mx-auto p-8">
    <h1 class="text-3xl font-bold mb-6 text-green-600 text-center">API Documentation</h1>
    <div class="prose max-w-none">
        {!! $content !!}
    </div>
    <a href="/" class="mt-6 inline-block text-green-600 hover:underline">Back to Home</a>
</div>
</body>
</html>
