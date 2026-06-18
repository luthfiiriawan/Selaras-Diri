<?php

return [
    'admin_email' => env('CMS_ADMIN_EMAIL') ?: 'admin@selaras.local',
    'admin_password' => env('CMS_ADMIN_PASSWORD'),

    // Vercel Blob read-write token for image uploads (serverless FS is read-only).
    'blob_token' => env('BLOB_READ_WRITE_TOKEN'),
];
