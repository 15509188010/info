<?php
use think\facade\Route;

Route::miss('api/Miss/index');

Route::group('admin', function() {
    Route::rule(
        'Login/index', 'admin/Login/index', 'post'
    );
});