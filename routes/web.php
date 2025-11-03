<?
use App\Http\Controllers\ReceivingReportController;
use App\Http\Controllers\DisplayTimetableController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\LecturerLoginController;
use App\Http\Controllers\SetupExamRoomController;
use App\Http\Controllers\SetupTimetableController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;

// Existing route
Route::get('/', function () {
    return view('Admin-Login');
});
Route::get('/admin/receiving-report', [ReceivingReportController::class, 'index'])->name('receiving.report');
Route::post('/report/{id}/accept', [ReceivingReportController::class, 'accept'])->name('report.accept');
Route::delete('/report/{id}/remove', [ReceivingReportController::class, 'remove'])->name('report.remove');
Route::post('/receiving-report/{id}/accept', [App\Http\Controllers\ReportController::class, 'accept'])->name('receiving.report.accept');
Route::delete('/receiving-report/{id}', [App\Http\Controllers\ReportController::class, 'destroy'])->name('receiving.report.remove');



Route::get('/lecturer/report', [ReportController::class, 'create'])->name('report.form');
// Lecturer report
Route::get('/report', [App\Http\Controllers\ReportController::class, 'create'])->name('report.index');
Route::post('/report/submit', [App\Http\Controllers\ReportController::class, 'store'])->name('report.submit');

// Admin receiving / report management
Route::get('/receiving-report', [App\Http\Controllers\ReportController::class, 'index'])->name('receiving.report');



// 🧱 Add these:
Route::get('/setup-timetable', [SetupTimetableController::class, 'index'])->name('setup.timetable');
Route::post('/setup-timetable', [SetupTimetableController::class, 'store'])->name('setup.timetable.store');
Route::get('/setup-timetable/edit/{id}', [SetupTimetableController::class, 'edit'])->name('setup.timetable.edit');
Route::post('/setup-timetable/update/{id}', [SetupTimetableController::class, 'update'])->name('setup.timetable.update');
Route::delete('/setup-timetable/delete/{id}', [SetupTimetableController::class, 'destroy'])->name('setup.timetable.delete');

Route::get('/display-timetable', [DisplayTimetableController::class, 'index'])->name('display.timetable');
Route::get('/download/all-timetable-pdf', [DisplayTimetableController::class, 'downloadAllTimetablesPDF'])
    ->name('timetable.download.pdf');

Route::get('/download/personal-timetable-pdf', [DisplayTimetableController::class, 'downloadPersonalTimetablePDF'])
    ->name('timetable.download.personal.pdf');

Route::get('/student-timetable-pdf', [DisplayTimetableController::class, 'downloadStudentTimetablePDF'])
    ->name('timetable.download.students.pdf');

    
Route::get('/admin/setup-exam-room', [SetupExamRoomController::class, 'index'])->name('examroom.index');
Route::post('/admin/setup-exam-room', [SetupExamRoomController::class, 'store'])->name('examroom.store');
Route::get('/admin/setup-exam-room/edit/{id}', [SetupExamRoomController::class, 'edit'])->name('examroom.edit');
Route::post('/admin/setup-exam-room/update/{id}', [SetupExamRoomController::class, 'update'])->name('examroom.update');
Route::delete('/admin/setup-exam-room/delete/{id}', [SetupExamRoomController::class, 'destroy'])->name('examroom.delete');


Route::get('/admin/setup-timetable', [SetupTimetableController::class, 'index'])->name('timetable.index');
Route::post('/admin/setup-timetable', [SetupTimetableController::class, 'store'])->name('timetable.store');


Route::get('/admin/login', [AdminLoginController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
Route::get('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
Route::get('/admin/homepage', function () {
    return view('Homepage-Admin'); // your admin homepage
})->name('admin.homepage');



Route::get('/lecturer/login', [LecturerLoginController::class, 'showLogin'])->name('lecturer.login');
Route::post('/lecturer/login', [LecturerLoginController::class, 'login'])->name('lecturer.login.submit');
Route::get('/lecturer/logout', [LecturerLoginController::class, 'logout'])->name('lecturer.logout');
Route::get('/lecturer/homepage', function () {
    return view('Homepage-Lecturer'); // change to your actual lecturer homepage view
})->name('lecturer.homepage');

