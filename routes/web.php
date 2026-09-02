<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SchoolProfileController;
use App\Http\Controllers\MajorController;

use App\Http\Controllers\CMS\PageController;
use App\Http\Controllers\CMS\NewsController;
use App\Http\Controllers\CMS\GalleryController;
use App\Http\Controllers\CMS\CategoryController;
use App\Http\Controllers\CMS\AnnouncementController;
use App\Http\Controllers\CMS\SettingController;

use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\RoleController;
use App\Http\Controllers\Auth\PermissionController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

use App\Http\Controllers\PPDB\ApplicantController;
use App\Http\Controllers\PPDB\RegistrationController;
use App\Http\Controllers\PPDB\DocumentController;
use App\Http\Controllers\PPDB\VerificationController;
use App\Http\Controllers\PPDB\PpdbWizardController;

use App\Http\Controllers\ThemeManager\ThemeController;
use App\Http\Controllers\ThemeManager\ThemeScheduleController;
use App\Http\Controllers\ThemeManager\BannerController;

use App\Http\Controllers\Pakar\QuestionController;
use App\Http\Controllers\Pakar\KnowledgeBaseController;
use App\Http\Controllers\Pakar\RuleController;
use App\Http\Controllers\Pakar\ConsultationController;

use App\Http\Controllers\SPK\CriteriaController;
use App\Http\Controllers\SPK\AlternativeController;
use App\Http\Controllers\SPK\EvaluationController;
use App\Http\Controllers\SPK\RankingController;

use App\Http\Controllers\Reporting\DashboardController;
use App\Http\Controllers\Reporting\ReportController;

/*
|--------------------------------------------------------------------------
| Halaman Publik (Homepage, Profil, Jurusan, PPDB, Konsultasi)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [SchoolProfileController::class, 'index'])->name('profil');
Route::get('/guru', [SchoolProfileController::class, 'teachers'])->name('guru');
Route::get('/prestasi', [SchoolProfileController::class, 'achievements'])->name('prestasi');
Route::get('/ekstrakurikuler', [SchoolProfileController::class, 'extracurriculars'])->name('ekstrakurikuler');
Route::get('/struktur-organisasi', [SchoolProfileController::class, 'orgStructure'])->name('struktur-organisasi');

Route::get('/jurusan', [MajorController::class, 'index'])->name('jurusan.index');
Route::get('/jurusan/{slug}', [MajorController::class, 'show'])->name('jurusan.show');

Route::get('/storage/{path}', function (string $path) {
    $disk = Storage::disk('public');

    abort_unless($disk->exists($path), 404);

    return response()->file($disk->path($path));
})->where('path', '.*')->name('storage.file');

Route::prefix('ppdb')->name('ppdb.')->group(function () {
 
    // Nama route ini SENGAJA dipertahankan sama seperti sebelumnya (applicants.create)
    // supaya semua tombol "Daftar PPDB" yang sudah ada di navbar/hero/footer otomatis
    // ikut terhubung ke wizard baru, tanpa perlu edit file lain satu-satu.
    Route::get('/daftar', [PpdbWizardController::class, 'biodataForm'])->name('applicants.create');
 
    Route::prefix('wizard')->name('wizard.')->group(function () {
        Route::get('/biodata', [PpdbWizardController::class, 'biodataForm'])->name('biodata');
        Route::post('/biodata', [PpdbWizardController::class, 'biodataStore'])->name('biodata.store');
 
        Route::get('/orang-tua', [PpdbWizardController::class, 'parentsForm'])->name('parents');
        Route::post('/orang-tua', [PpdbWizardController::class, 'parentsStore'])->name('parents.store');
 
        Route::get('/dokumen', [PpdbWizardController::class, 'documentsForm'])->name('documents');
        Route::post('/dokumen', [PpdbWizardController::class, 'documentsStore'])->name('documents.store');
 
        Route::get('/rapor', [PpdbWizardController::class, 'reportCardForm'])->name('reportCard');
        Route::post('/rapor', [PpdbWizardController::class, 'reportCardStore'])->name('reportCard.store');
 
        Route::get('/konfirmasi-nilai', [PpdbWizardController::class, 'ocrReviewForm'])->name('ocrReview');
        Route::post('/konfirmasi-nilai', [PpdbWizardController::class, 'ocrReviewStore'])->name('ocrReview.store');
 
        Route::get('/rekomendasi', [PpdbWizardController::class, 'recommendationShow'])->name('recommendation');
 
        Route::get('/pilih-jurusan', [PpdbWizardController::class, 'majorChoiceForm'])->name('majorChoice');
        Route::post('/submit', [PpdbWizardController::class, 'submitFinal'])->name('submit');
 
        Route::get('/selesai/{registrationNumber}', [PpdbWizardController::class, 'result'])->name('result');
        Route::get('/bukti/{registrationNumber}', [PpdbWizardController::class, 'downloadProofPdf'])->name('downloadProof');
    });
});

    Route::get('/ppdb/persyaratan', function () {
        return view('ppdb.persyaratan');
    })->name('ppdb.persyaratan');

    Route::get('/ppdb/pengumuman', function () {
        return view('ppdb.pengumuman');
    })->name('ppdb.pengumuman');

/*
|--------------------------------------------------------------------------
| Login / Logout Staff & Admin
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Area Admin (dilindungi middleware auth)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ---- CMS ----
    Route::prefix('cms')->name('cms.')->group(function () {
        Route::resource('pages', PageController::class);
        Route::resource('news', NewsController::class)->except(['edit']);
        Route::get('news/{news}/edit', [NewsController::class, 'edit'])->name('news.edit');
        Route::resource('gallery', GalleryController::class)->only(['index', 'store', 'destroy']);
        Route::resource('categories', CategoryController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::resource('announcements', AnnouncementController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    });

    // ---- Authentication / Users ----
    Route::prefix('auth')->name('auth.')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
        Route::resource('roles', RoleController::class)->except(['show']);
        Route::resource('permissions', PermissionController::class)->only(['index', 'store', 'destroy']);
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    });

    // ---- PPDB (admin sisi panitia) ----
    Route::prefix('ppdb')->name('ppdb.')->group(function () {
        Route::get('applicants', [ApplicantController::class, 'index'])->name('applicants.index');
        Route::delete('applicants/{applicant}', [ApplicantController::class, 'destroy'])->name('applicants.destroy');
        Route::get('registrations', [RegistrationController::class, 'index'])->name('registrations.index');
        Route::put('registrations/{registration}', [RegistrationController::class, 'updateStatus'])->name('registrations.update');
        Route::delete('documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
        Route::get('verification', [VerificationController::class, 'index'])->name('verification.index');
        Route::post('verification/{registration}', [VerificationController::class, 'store'])->name('verification.store');
        
    });


    // ---- Theme Manager ----
    Route::prefix('theme')->name('theme.')->group(function () {
        Route::resource('themes', ThemeController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::post('themes/{theme}/activate', [ThemeController::class, 'activate'])->name('themes.activate');
        Route::resource('schedules', ThemeScheduleController::class)->only(['index', 'store', 'destroy']);
        Route::resource('banners', BannerController::class)->only(['index', 'store', 'destroy']);
        Route::post('banners/{banner}/toggle', [BannerController::class, 'toggle'])->name('banners.toggle');
    });


    // ---- SPK (Sistem Pendukung Keputusan) ----
    Route::prefix('spk')->name('spk.')->group(function () {
        Route::resource('criteria', CriteriaController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::resource('alternatives', AlternativeController::class)->only(['index', 'store', 'destroy']);
        Route::get('evaluations', [EvaluationController::class, 'index'])->name('evaluations.index');
        Route::post('evaluations', [EvaluationController::class, 'store'])->name('evaluations.store');
        Route::get('rankings', [RankingController::class, 'index'])->name('rankings.index');
        Route::post('rankings/calculate', [RankingController::class, 'calculate'])->name('rankings.calculate');
    });

    // ---- Reporting Module ----
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('ppdb', [ReportController::class, 'ppdbIndex'])->name('ppdb.index');
        Route::get('ppdb/pdf', [ReportController::class, 'ppdbPdf'])->name('ppdb.pdf');
        Route::get('ppdb/excel', [ReportController::class, 'ppdbExcel'])->name('ppdb.excel');
    });
});