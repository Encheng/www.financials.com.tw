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

         Route::prefix('companies')
              ->group(function () {
                  Route::get('/', 'CompanyController@index')
                       ->name('admin.company.index');
                  Route::get('create', 'CompanyController@create')
                       ->name('admin.company.create');
                  Route::post('/', 'CompanyController@store')
                       ->name('admin.company.store');
                  Route::get('{id}/edit', 'CompanyController@edit')
                       ->name('admin.company.edit');
                  Route::put('{id}', 'CompanyController@update')
                       ->name('admin.company.update');
                  Route::get('{id}/analyze', 'CompanyController@analyze')
                       ->name('admin.company.analyze');
                    Route::prefix('financial')
                       ->group(function () {
                         Route::get('create', 'CompanyController@financialCreate')
                              ->name('admin.company.financial.create');
                         Route::post('/', 'CompanyController@financialStore')
                              ->name('admin.company.financial.store');
                         Route::get('import', 'CompanyController@import')
                              ->name('admin.company.financial.import');
                         Route::post('import_process', 'CompanyController@importProcess')
                              ->name('admin.company.financial.import.process');

                    });
              });
     });
