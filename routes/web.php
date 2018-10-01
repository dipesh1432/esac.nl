<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    //return the home page
    return redirect('/home', 301);
});

Auth::routes();

//import routes Important: Remove import routes in production
Route::get('import/users','ImportController@importUsers');


//Admin routes
Route::get('beheer/home','ManageController@index');

//extra user routes
Route::get('users/old_members','UserController@indexOldMembers');
Route::get('users/exportUsers','UserController@exportUsers');
Route::patch('users/{user}/removeAsActiveMember', 'UserController@removeAsActiveMember');

//user certification routes
Route::get('users/{user}/addCertificate','UserCertificateController@addCertificate');
Route::get('users/{user}/addCertificate/{certificate}','UserCertificateController@editUserCertificate');
Route::post('users/{user}/addCertificate','UserCertificateController@saveCertificate');
Route::patch('users/{user}/addCertificate/{certificate}','UserCertificateController@updateUserCertificate');
Route::delete('users/{user}/addCertificate/{certificate}','UserCertificateController@deleteUserCertificate');

//crud routes
Route::resource('users','UserController');
Route::resource('rols', 'RolController');
Route::resource('pages', 'PaginaBeheerController');
Route::resource('certificates', 'CertificateController');
Route::resource('agendaItems', 'AgendaItemController');
Route::resource('agendaItemCategories', 'AgendaItemCategorieController');
Route::resource('applicationForms', 'ApplicationFormController');
Route::resource('newsItems', 'NewsItemController');
Route::resource('frontEndReplacement', 'FrontEndReplacementController');
Route::resource('mailList', 'MailListController');


//inschrijf routes
Route::get('forms/{agendaItem}', array('as' => 'editSchedule', 'uses' => 'InschrijfController@showPersonalRegistrationForm'));
Route::post('forms/{agendaItem}', array('as' => 'editSchedule', 'uses' => 'InschrijfController@savePersonalRegistrationForm'));
Route::get('forms/admin/{agendaItem}','InschrijfController@showRegistrationform');
Route::post('forms/admin/{agendaItem}','InschrijfController@saveRegistrationform');
Route::get('forms/users/{agendaItem}', array('as' => 'editSchedule', 'uses' => 'InschrijfController@index'));
Route::get("forms/users/{user}/detail/{agendaItem}","InschrijfController@showApplicationFormInformation");
Route::get('forms/users/{inschrijfId}/export', array('as' => 'editSchedule', 'uses' => 'InschrijfController@exportUsers'));
Route::delete('forms/{agenda_id}/remove/{applicationResponseId}', array('as' => 'editSchedule', 'uses' => 'InschrijfController@destroy'));

Route::resource('forms', 'InschrijfController');

//mailist routes
Route::delete('/mailList/{mailistid}/member/{memberid}','MailListController@deleteMeberOfMailList');
Route::post('/mailList/{mailistid}/member','MailListController@addMember');

//photo routes
Route::post('photoalbum/{albumId}/upload', ['as'=>'addPhoto','uses'=>'photoController@addPhotoToAlbum'])->name('uploadPhoto');

//front-end routes
Route::get('/photoalbum/{albumId}','PhotoController@index')->name('PhotoAlbum');;
Route::get('/photo/{id}','PhotoController@getPhotos')->name('getPhotos');
Route::get('/zekeringen','frontEndController@zekeringen');
Route::get('/agenda','frontEndController@agenda');
Route::get('/agenda/{agendaItem}','frontEndController@agendaDetailView');
Route::get('/home','frontEndController@home');
Route::get('/nieuws','frontEndController@news');
Route::get('/ledenlijst','frontEndController@memberList');
Route::get('/{menuItem}', function () {
    return redirect(strtolower($menuItem), 301, 'frontEndController@showPage');
});
