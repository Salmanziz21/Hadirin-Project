<?php

use App\Http\Controllers\TeacherController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GenerateController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\DailyPrintController;
use App\Http\Controllers\MonthlyPrintController;
use App\Http\Controllers\BulkPrintController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {return view('welcome');});

Route::get('/teachers', [TeacherController::class, 'index'])->name('tools.teachers');
Route::post('/teachers/store', [TeacherController::class, 'store'])->name('teacher.store');
Route::post('/teachers/update/{id}', [TeacherController::class, 'update'])->name('teacher.update');
Route::delete('/teachers/delete/{id}', [TeacherController::class, 'destroy'])->name('teacher.destroy');
Route::get('/teachers/search', [TeacherController::class, 'search'])->name('teacher.search');

Route::get('/events', [EventController::class, 'index'])->name('tools.events');
Route::post('/events/store', [EventController::class, 'store'])->name('event.store');
Route::post('/events/update/{id}', [EventController::class, 'update'])->name('event.update');
Route::delete('/events/delete/{id}', [EventController::class, 'destroy'])->name('event.destroy');
Route::get('/events/search', [EventController::class, 'search'])->name('event.search');

Route::get('/generate', [GenerateController::class, 'index'])->name('generate.id.show');
Route::post('/generate-id/process', [GenerateController::class, 'process'])->name('generate.id.process');
Route::get('/generate/search', [GenerateController::class, 'search'])->name('generate.search');

Route::get('/scan', [ScanController::class, 'showScanner'])->name('scan.show');
Route::post('/process', [ScanController::class, 'processScan'])->name('scan.process');
Route::get('/success', [ScanController::class, 'scanSuccess'])->name('scan.success');
Route::get('/error', [ScanController::class, 'scanError'])->name('scan.error');

Route::get('/print/harian', [DailyPrintController::class, 'printHarian'])->name('print.harian');
Route::get('/print/bulanan', [MonthlyPrintController::class, 'printBulanan'])->name('print.bulanan');

Route::get('/card-print', [BulkPrintController::class, 'printCard'])->name('print.card');



