<?php

// Vercel serverless entry point.
// Vercel only allows function entry-points inside the /api directory,
// so we forward every request to Laravel's normal public/index.php.
require __DIR__ . '/../public/index.php';
