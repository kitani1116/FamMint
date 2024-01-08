<?php

use App\Http\Controllers\UserDataController;
use Illuminate\Support\Facades\Route;

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

Route::post('/', [UserDataController::class,'authentication']);
Route::get('/', function () {
    return view('login');
});

Route::post('/logout', [UserDataController::class,'logout'])->name('logoutclick');

Route::get('/main_signup', function () {
    return view('Signup.main_signup');
});
Route::post('/main_conf', [UserDataController::class,'conf']);
Route::get('/main_conf', function () {
    return redirect('/main_signup');
});

Route::post('/main_complete', [UserDataController::class,'comp']);
Route::get('/main_complete', function () {
    if(session() -> get('flg') == 1){
        session() -> forget('flg');
        return view('Signup.main_complete');
    }else{
        return redirect('/main_signup');
    }
    
});


Route::get('/contact', function () {
    return view('Contact.contact');
})->name('contact');;

Route::post('/contact_conf', [UserDataController::class,'contactconf']);

Route::post('/contact_complete', [UserDataController::class,'contactcomp']);
Route::get('/contact_complete', function () {
    return view('Contact.contact_complete');
});


Route::get('/passlost', function () {
    return view('PassLost.passlost');
});

Route::post('/passreset', [UserDataController::class,'passlost']);
Route::get('/passreset', function () {
    if(session()->has('email')){
        return view('PassLost.passreset');
    }else{
        return redirect('/');
    }
});

Route::post('/passreset_complete', [UserDataController::class,'passcomp']);
Route::get('/passreset_complete', function () {
    if(session()->has('email')){
        session()->flush();
    return view('PassLost.passreset_complete');
}else{
    return redirect('/');
}
});







Route::get('/main_toppage', [UserDataController::class,'toplist']);

Route::post('/JobDdelete', [UserDataController::class,'jobdataDelete'])->name('JobDclick');
Route::post('/CompJobdelete', [UserDataController::class,'CompjobdataDelete']);
Route::post('/CompJobPay', [UserDataController::class,'Compjobpay']);


Route::post('/ItemDdelete', [UserDataController::class,'itemdataDelete'])->name('ItemDclick');
Route::post('/CompItemdelete', [UserDataController::class,'CompItemdataDelete']);
Route::post('/Compitempay', [UserDataController::class,'Compitempay']);

Route::get('/new_job_edit', [UserDataController::class,'jobdate']);
Route::post('/job_update', [UserDataController::class,'jobupdate']);


Route::get('/new_item_edit', [UserDataController::class,'itemdate']);
Route::post('/item_update', [UserDataController::class,'itemupdate']);




Route::get('/new_job', function () {
    if(session()->has('id')){
        return view('mainaccount.new_job');
    }else{
        return redirect('/');
    }
});

Route::post('/new_job_conf', [UserDataController::class,'jobconf']);
Route::get('/new_job_conf', function () {
    return redirect('mainaccount.new_job');
});

Route::post('/new_job_complete', [UserDataController::class,'jobcomp']);
Route::get('/new_job_complete', function () {
    if(session() -> get('flg') == 1){
        session() -> forget('flg');
        return view('mainaccount.new_job_complete');
    }else{
        return redirect('/main_toppage');
    }
});

Route::get('/new_item', function () {
    if(session()->has('id')){
    return view('mainaccount.new_item');
    }else{
        return redirect('/');
    }
});

Route::post('/new_item_conf', [UserDataController::class,'itemconf']);
Route::get('/new_item_conf', function () {
    return redirect('mainaccount.new_item');
});

Route::post('/new_item_complete', [UserDataController::class,'itemcomp']);
Route::get('/new_item_complete', function () {
    if(session() -> get('flg') == 1){
        session() -> forget('flg');
        return view('mainaccount.new_item_complete');
    }else{
        return redirect('/main_toppage');
    }
});


Route::get('/other_menu', [UserDataController::class,'otherlist']);

Route::post('/money_conf', [UserDataController::class,'moneyconf']);
Route::post('/money_comp', [UserDataController::class,'moneycomp']);

Route::post('/child_account_conf', [UserDataController::class,'childconf']);
Route::post('/child_account_comp', [UserDataController::class,'childcomp']);
Route::post('/childdelete', [UserDataController::class,'childataDelete']);
Route::get('/child_pass_edit', [UserDataController::class,'childPass']);
Route::post('/child_pass_comp', [UserDataController::class,'childPassComp']);


Route::get('/unsubscrib', function () {
    return view('mainaccount.unsubscrib');
});
Route::post('/unsubscrib_complete', [UserDataController::class,'unsubscribConf']);
Route::get('/unsubscrib_complete', [UserDataController::class,'unsubscribConf']);
Route::post('/unsubscrib_end', [UserDataController::class,'unsubscribComp']) -> name('unsubscribButton');

Route::get('/child_toppage', [UserDataController::class,'childtoplist']);

Route::get('/child_jobcomp', [UserDataController::class,'JobComplete']);
Route::get('/child_itemcomp', [UserDataController::class,'itemComplete']);

Route::get('/JobFavoriteAddition', [UserDataController::class,'JFA']);
Route::get('/favoriteJobDelete', [UserDataController::class,'FJD']);
Route::get('/ItemFavoriteAddition', [UserDataController::class,'IFA']);
Route::get('/favoriteItemDelete', [UserDataController::class,'FID']);


Route::get('/favorite', [UserDataController::class,'favoriteList']);
Route::get('/history', [UserDataController::class,'Hislist']);

Route::get('/search_result', [UserDataController::class,'searchlist']);

Route::get('/api/get-balance', [UserDataController::class, 'getBalance']);






















Route::get('/test', [UserDataController::class,'test']);

