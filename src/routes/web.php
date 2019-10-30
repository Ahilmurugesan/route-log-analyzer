<?php
/**
 * Routes for the Log viewer package
 *
 * @author Ahilan
 */

$nameSpace = 'Ahilan\LogViewer\Http\Controllers';
Route::group(['namespace' => $nameSpace, 'middleware' => ['routeusage']],
    function () {
    Route::get('/logviewer', 'LogViewerController@index')->name('logviewer');

    Route::get('/routeusage', 'RouteUsageController@index')
            ->name('routeusage');

    Route::get('/logdwnld/{file}', 'LogViewerController@download')
            ->name('logdwnld');
});
