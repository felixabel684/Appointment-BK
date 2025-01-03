<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\ClinicsController;
use App\Http\Controllers\Admin\DoctorsController;
use App\Http\Controllers\Admin\ExaminationsAdminController;
use App\Http\Controllers\Doctor\ExaminationsController;
use App\Http\Controllers\Doctor\HistoryController;
use App\Http\Controllers\Admin\MedicinesController;
use App\Http\Controllers\Admin\PatientsController;
use App\Http\Controllers\Doctor\ProfileController;
use App\Http\Controllers\Doctor\SchedulesController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LoginPatientController;
use App\Http\Controllers\Auth\RegisterPatientController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Patient\ExaminationPatientsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login-patient', [LoginPatientController::class, 'showLoginForm'])->name('patient.login.form');
Route::post('/login-patient', [LoginPatientController::class, 'login'])->name('patient.login');
Route::post('/logout-patient', [LoginPatientController::class, 'logout'])->name('patient.logout');

Route::get('/register-patient', [RegisterPatientController::class, 'showRegistrationForm'])->name('patient.register.form');
Route::post('/register-patient', [RegisterPatientController::class, 'register'])->name('patient.register');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::prefix('/admin')
    ->middleware(['auth', 'admin'])
    ->group(function () { //prefix untuk menambahkan awalan URL ke semua rute yang didefinisikan di dalam grup, cth : http://example.com, rute ini akan menjadi http://example.com/admin.
        Route::get('/', [DashboardController::class, 'admin_dash'])->name('dashboard-admin'); //merujuk ke function index dari DashboardController dan route ini diberi nama 'dashboard' supaya tau route ini utk bagian apa

        Route::resource('patients', PatientsController::class);
        Route::resource('doctors', DoctorsController::class);
        Route::resource('medicines', MedicinesController::class);
        Route::resource('clinics', ClinicsController::class);
        Route::resource('examinations_admin', ExaminationsAdminController::class);
    });

Route::prefix('/doctor')
    ->middleware(['auth', 'doctor'])
    ->group(function () { //prefix untuk menambahkan awalan URL ke semua rute yang didefinisikan di dalam grup, cth : http://example.com, rute ini akan menjadi http://example.com/admin.
        Route::get('/', [DashboardController::class, 'doctor_dash'])->name('dashboard-doctor'); //merujuk ke function index dari DashboardController dan route ini diberi nama 'dashboard' supaya tau route ini utk bagian apa

        Route::resource('schedules', SchedulesController::class);
        Route::resource('history', HistoryController::class);
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('/profile/update/{redirect}', [ProfileController::class, 'update'])->name('profile.update');

        Route::get('examinations', [ExaminationsController::class, 'index'])->name('examinations.index');
        Route::get('examinations/{id}/create', [ExaminationsController::class, 'create'])->name('examinations.create');
        Route::post('examinations', [ExaminationsController::class, 'store'])->name('examinations.store');
        Route::get('examinations/{id}/edit', [ExaminationsController::class, 'edit'])->name('examinations.edit');
        // Route::get('/examinations/{id}/edit/{list_clinics_id}', [ExaminationsController::class, 'edit'])->name('examinations.edit');
        Route::put('examinations/{id}', [ExaminationsController::class, 'update'])->name('examinations.update');
        Route::delete('examinations/{id}', [ExaminationsController::class, 'destroy'])->name('examinations.destroy');

        Route::get('/doctor/medicines/search', [ExaminationsController::class, 'search'])->name('medicines.search');
    });

Route::prefix('/patient')
    ->middleware(['patient'])
    ->group(function () { //prefix untuk menambahkan awalan URL ke semua rute yang didefinisikan di dalam grup, cth : http://example.com, rute ini akan menjadi http://example.com/admin.
        Route::get('/', [DashboardController::class, 'patient_dash'])->name('dashboard-patient'); //merujuk ke function index dari DashboardController dan route ini diberi nama 'dashboard' supaya tau route ini utk bagian apa

        Route::resource('examination_patients', ExaminationPatientsController::class);
    });

Auth::routes();
