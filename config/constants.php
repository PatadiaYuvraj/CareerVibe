<?php

use Illuminate\Support\Env;

return [
  'USER_TYPE' => [
    'user' => 'USER',
    'company' => 'COMPANY',
    'admin' => 'ADMIN',
  ],
  'USER_GUARD' => 'user',
  'COMPANY_GUARD' => 'company',
  'ADMIN_GUARD' => 'admin',
  'CLOUDINARY_FOLDER' => [
    'user' => 'career-vibe/users/profile_image',
    'company' => 'career-vibe/companies/profile_image',
    'admin' => 'career-vibe/admins/profile_image',
  ],
  'USER_RESUME_PATH' => "uploads/users/resumes",
  "APP_URL" => Env::get('APP_URL'),
  "APP_NAME" => Env::get('APP_NAME'),
  'pagination' => 10,
];
