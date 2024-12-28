<?php

$basePath = app_path() . '/../../' . env('OUTPUTFOLDER', 'data');

return [
    'blog_path' => $basePath . '/blog/posts',
    'media_path' => $basePath . '/blog/media',
    'lib_path' => $basePath . '/lib',
    'urls_output_path' => $basePath . '/urls',
    'feeds_output_path' => $basePath . '/urls/feeds',
];
