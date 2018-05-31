<?php


Route::group(['namespace' => 'CaoJiayuan\Io\Laravel'], function () {
    Route::post('/io-broadcast/master', 'IoController@startUp');
});

