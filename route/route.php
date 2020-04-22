<?php
use think\facade\Route;

Route::miss('api/Miss/index');

Route::group('api', function() {
    Route::rule(
        'wx/auth', 'Wx/auth', 'get'
    );
});