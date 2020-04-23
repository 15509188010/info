<?php
use think\facade\Route;

Route::miss('api/Miss/index');

Route::group('api', function() {
    //
    Route::rule(
        'wx/getUserByCode', 'Wx/getUserByCode', 'get'
    );
    //微信接口调用(获取access_token)
    Route::rule(
        'wx/getAccessToken','Wx/getAccessToken' , 'get'
    );
    Route::rule(
        'wx/getUserByTicket','Wx/getUserByTicket','get'
    );
});