<?php

use Illuminate\Support\Env;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

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
  'CLOUDINARY_FOLDER_DEMO' => [
    'user-profile-image' => 'career-vibe/users/profile_image',
    'user-resume' => 'career-vibe/users/resumes',
    'user-post-image' => 'career-vibe/users/posts/image',
    'user-post-video' => 'career-vibe/users/posts/video',
    'company-profile-image' => 'career-vibe/companies/profile_image',
    'company-post-image' => 'career-vibe/companies/posts/image',
    'company-post-video' => 'career-vibe/companies/posts/video',
    'admin-profile-image' => 'career-vibe/admins/profile_image',
    "temp_local_path" => "temp",
  ],
  "TAGE_NAMES" => [
    'user-profile-image' => 'user-profile-image',
    'user-resume' => 'user-resume',
    'user-post-image' => 'user-post-image',
    'user-post-video' => 'user-post-video',
    'company-profile-image' => 'company-profile-image',
    'company-post-image' => 'company-post-image',
    'company-post-video' => 'company-post-video',
    'admin-profile-image' => 'admin-profile-image',
  ],
  'Allowed_File_Types' => [
    'image' => 'image',
    'video' => 'video',
    'pdf' => 'pdf',
    'doc' => 'doc',
    'docx' => 'docx',
  ],

  ' Allowed_File_Types_With_Extensions' => [
    'image' => ['jpg', 'jpeg', 'png', 'gif'],
    'video' => ['mp4', 'avi', 'mov', 'wmv', 'flv', '3gp'],
    'pdf' => ['pdf'],
    'doc' => ['doc'],
    'docx' => ['docx'],
  ],

  'USER_RESUME_PATH' => "uploads/users/resumes",
  "APP_URL" => Env::get('APP_URL', 'http://localhost:8000'),
  "APP_NAME" => Env::get('APP_NAME', 'Career Vibe'),
  'pagination' => Env::get('PAGINATEVALUE', 10),
  'gender' => [
    "MALE" => 'Male',
    "FEMALE" => 'Female',
    "OTHER" => 'Other',
  ],
  "IS_NOTIFICATION_SERVICE_ENABLED" => Env::get('IS_NOTIFICATION_SERVICE_ENABLED', true),
  "IS_MAIL_SERVICE_ENABLED" => Env::get('IS_MAIL_SERVICE_ENABLED', true),
  "IS_FILE_UPLOAD_SERVICE_ENABLED" => Env::get('IS_FILE_UPLOAD_SERVICE_ENABLED', true),
  'mail' => [
    'email_verification' => true,
    'password_reset' => true,
    'change_password' => true,

  ],
  'post' => [
    'type' => [
      'TEXT' => 'text',
      'IMAGE' => 'image',
      'VIDEO' => 'video',
    ],
  ],
  'report' => [
    'type' => [
      'INAPPROPRIATE' => 'inappropriate',
      'SPAM' => 'spam',
      'FRAUD' => 'fraud',
      'HATE_SPEECH' => 'hate speech',
      'ABUSIVE' => 'abusive',
      'OTHER' => 'other',
    ],
  ],
  'job' => [
    'work_type' => [
      'REMOTE' => 'Remote',
      'ONSITE' => 'Onsite',
      'HYBRID' => 'Hybrid',
    ],
    'job_type' => [
      'FULL_TIME' => 'Full Time',
      'PART_TIME' => 'Part Time',
      'INTERNSHIP' => 'Internship',
      'CONTRACT' => 'Contract',
      'FREELANCE' => 'Freelance',
      'VOLUNTEER' => 'Volunteer',
      'TEMPORARY' => 'Temporary',
    ],
    'experience_level' => [
      'FRESHER' => 'Fresher',
      'EXPERIENCED' => 'Experienced',
    ],
    'experience_type' => [
      'ANY' => 'Any',
      '0-1' => '0-1',
      '1-2' => '1-2',
      '2-3' => '2-3',
      '3-5' => '3-5',
      '5-8' => '5-8',
      '8-10' => '8-10',
      '10+' => '10+',
    ],
  ],
];
