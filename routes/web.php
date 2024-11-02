<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/docs', function () {
    $path = resource_path('docs/api-documentation.md');

    if (!File::exists($path)) {
        abort(404, 'Documentation not found.');
    }

    $markdownContent = File::get($path);
    $parsedown = new Parsedown();
    $htmlContent = $parsedown->text($markdownContent);

    return view('documentation', ['content' => $htmlContent]);
});

require __DIR__.'/auth.php';
