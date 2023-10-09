<?php

Route::namespace('Auth')
     ->group(function () {
         // login
         Route::get('login', 'LoginController@index')
              ->name('admin.login.index')
              ->middleware('guest:admin');

         Route::get('logout', 'LoginController@logout')
              ->name('admin.logout');

         // oauth
         Route::middleware('guest:admin')
              ->prefix('oauth')
              ->group(function () {
                  Route::get('google', 'GoogleLoginController@redirect')
                       ->name('admin.oauth.google.redirect');
                  Route::get('google/callback', 'GoogleLoginController@callback')
                       ->name('admin.oauth.google.callback');
              });
     });

Route::middleware(['admin_auth:admin', 'gates'])
     ->group(function () {
         Route::get('/', 'IndexController@index')
              ->name('admin.index');

         Route::prefix('accounts')
              ->group(function () {
                  Route::get('/', 'AccountController@index')
                       ->name('admin.accounts.index');
                  Route::get('create', 'AccountController@create')
                       ->name('admin.accounts.create');
                  Route::post('/', 'AccountController@store')
                       ->name('admin.accounts.store');
                  Route::get('{id}/edit', 'AccountController@edit')
                       ->name('admin.accounts.edit');
                  Route::put('{id}', 'AccountController@update')
                       ->name('admin.accounts.update');
              });
     });
