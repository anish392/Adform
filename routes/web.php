<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\studentController;
use App\Http\Controllers\FormBuilderController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('frontend.welcome');
});

// create ko lagi form bhayeko thau 
Route::get('', [StudentController::class, 'create'])->name('welcome.create');


//edit ko lagi 
// Route::get('/operation.edit', function () {
//     return view('operation.edit');
// })->name('operation.edit');
//banako page ni halni get / name ma 
//edit,upadate delete garda /{id}dini

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/backend/{id}/edit', [studentController::class, 'edit'])->name('backend.edit');
Route::put('studentupdate/{id}', [studentController::class, 'update'])->name('studentupdate');
Route::delete('studentdelete/{id}', [studentController::class, 'destroy'])->name('studentdelete');
Route::post('student_store', [studentController::class, 'store'])->name('student.store');
Route::get('/view_form', function () {
    return view('./backend/view_form');
})->name('view_form');
Route::get('/view_report', function () {
    return view('./backend/view_form');
})->name('view_report');



//dynamic
// Route::get('/admin/form-builder', 'FormBuilderController@index')->name('form_builder.index');
// use App\Http\Controllers\FormBuilderController;

// Route to display the form builder interface
Route::get('/form-builder', [FormBuilderController::class, 'index'])->name('form_builder.index');

// Route to handle form submissions
Route::post('/form-builder/store', [FormBuilderController::class, 'store'])->name('form_builder.store');

// Define a route for the dynamic form
Route::get('/dynamic-form', [FormBuilderController::class, 'showDynamicForm'])->name('dynamic_form');
//index ko lagi k ma dekhauni
Route::get('view_history', [studentController::class, 'index'])->name('view_history');
