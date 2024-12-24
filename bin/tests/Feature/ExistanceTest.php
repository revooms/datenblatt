<?php

it('makes sure the essential folder "data" exist', function () {
    $has_folder = is_dir(env('OUTPUTFOLDER'));
    expect($has_folder)->toBeTrue();
});

it('makes sure the required folder "urls" exist', function () {
    $has_folder = is_dir(env('OUTPUTFOLDER_URLS'));
    expect($has_folder)->toBeTrue();
});

it('makes sure the required folder "feeds" exist', function () {
    $has_folder = is_dir(env('OUTPUTFOLDER_FEEDS'));
    expect($has_folder)->toBeTrue();
});

it('makes sure the required folder "snippets" exist', function () {
    $has_folder = is_dir(env('OUTPUTFOLDER_SNIPPETS'));
    expect($has_folder)->toBeTrue();
});
