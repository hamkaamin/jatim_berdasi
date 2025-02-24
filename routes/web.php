<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\FaseController;
use App\Http\Controllers\InovasiController;
use App\Http\Controllers\JuriController;
use App\Http\Controllers\KategoriOPDAjaxController;
use App\Http\Controllers\KategoriOPDController;
use App\Http\Controllers\KategoriTahapanController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PenilaianInovasiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['XSS']], function () {
    Route::get('/insert_data_opd_sekolah', [App\Http\Controllers\HomeController::class, 'insert_data_opd_sekolah'])->name('insert_data_opd_sekolah');
    Route::get('/coba_insert_inovasi', [App\Http\Controllers\HomeController::class, 'coba_insert_inovasi'])->name('coba_insert_inovasi');
    Route::get('/get_all_opd', [App\Http\Controllers\HomeController::class, 'get_all_opd'])->name('get_all_opd');
    Route::middleware(['auth'])->group(function () {
        Route::get('/', [App\Http\Controllers\HomeController::class, 'home'])->name('home');
        Route::get('/insert_user_opd/{kota}', [App\Http\Controllers\HomeController::class, 'insert_user_opd'])->name('insert_user_opd');
        Route::get('/insert_all_user_opd_prov_jatim', [App\Http\Controllers\HomeController::class, 'insert_all_user_opd_prov_jatim'])->name('insert_all_user_opd_prov_jatim');
        Route::get('/insert_all_opd_kategori', [App\Http\Controllers\HomeController::class, 'insert_all_opd_kategori'])->name('insert_all_opd_kategori');
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'home'])->name('home');
        Route::get('/export/{type}', [App\Http\Controllers\HomeController::class, 'export'])->name('export-inovasi');
        Route::post('/modal', [App\Http\Controllers\HomeController::class, 'modal'])->name('modal');
        Route::post('/change-area', [App\Http\Controllers\HomeController::class, 'change_area'])->name('change-area');
        Route::post('/setting', [App\Http\Controllers\HomeController::class, 'setting_save'])->name('setting.save');

        Route::prefix('profil')->name('profil.')->group(function () {
            Route::get('/', [App\Http\Controllers\ProfilController::class, 'index'])->name('index');
            Route::post('/change-password', [App\Http\Controllers\ProfilController::class, 'change_pass'])->name('change-pass');
        });

        Route::middleware(['superadmin'])->group(function () {
            Route::prefix('pengumuman')->name('pengumuman.')->group(function () {
                Route::get('/', [App\Http\Controllers\PengumumanController::class, 'index'])->name('index');
                Route::post('/', [App\Http\Controllers\PengumumanController::class, 'save'])->name('save');
                Route::post('/delete', [App\Http\Controllers\PengumumanController::class, 'delete'])->name('delete');
            });

            Route::prefix('master')->name('master.')->group(function () {
                Route::prefix('indikator')->name('indikator.')->group(function () {
                    Route::get('/', [App\Http\Controllers\IndikatorController::class, 'index'])->name('index');
                    Route::post('/', [App\Http\Controllers\IndikatorController::class, 'save'])->name('save');
                    Route::post('/delete', [App\Http\Controllers\IndikatorController::class, 'delete'])->name('delete');
                });
                Route::prefix('definisi')->name('definisi.')->group(function () {
                    Route::get('/', [App\Http\Controllers\DefinisiController::class, 'index'])->name('index');
                    Route::post('/', [App\Http\Controllers\DefinisiController::class, 'save'])->name('save');
                    Route::post('/delete', [App\Http\Controllers\DefinisiController::class, 'delete'])->name('delete');
                    // route post show_indikator
                    Route::post('/show_indikator', [App\Http\Controllers\DefinisiController::class, 'show_indikator'])->name('show_indikator');
                });
                Route::prefix('parameter')->name('parameter.')->group(function () {
                    Route::post('/add', [App\Http\Controllers\ParameterController::class, 'add'])->name('add');
                    Route::post('/', [App\Http\Controllers\ParameterController::class, 'save'])->name('save');
                    Route::post('/delete', [App\Http\Controllers\ParameterController::class, 'delete'])->name('delete');
                });
                Route::prefix('tahapan')->name('tahapan.')->group(function () {
                    Route::get('/', [App\Http\Controllers\TahapanController::class, 'index'])->name('index');
                    Route::post('/', [App\Http\Controllers\TahapanController::class, 'save'])->name('save');
                    Route::post('/delete', [App\Http\Controllers\TahapanController::class, 'delete'])->name('delete');
                });
                Route::prefix('kategoritahapan')->name('kategoritahapan.')->group(function () {
                    Route::get('/', [KategoriTahapanController::class, 'index'])->name('index');
                    Route::post('/', [KategoriTahapanController::class, 'save'])->name('save');
                    Route::post('/delete', [KategoriTahapanController::class, 'delete'])->name('delete');
                });
                Route::prefix('kategoriopd')->name('kategoriopd.')->group(function () {
                    Route::get('/', [KategoriOPDController::class, 'index'])->name('index');
                    Route::get('/show', [KategoriOPDController::class, 'show'])->name('show');
                    Route::get('/table', [KategoriOPDController::class, 'table'])->name('table');
                    Route::post('/', [KategoriOPDController::class, 'save'])->name('save');
                    Route::post('/switch', [KategoriOPDController::class, 'switch'])->name('switch');
                    Route::post('/delete', [KategoriOPDController::class, 'delete'])->name('delete');
                });

                Route::prefix('kategori_opd')->name('kategori_opd.')->group(function () {
                    Route::get('/{kategori_id}', [KategoriOPDAjaxController::class, 'index'])->name('index');
                    Route::get('/show', [KategoriOPDAjaxController::class, 'show'])->name('show');
                    Route::get('/table/{kategori_id}', [KategoriOPDAjaxController::class, 'table'])->name('table');
                    Route::post('/', [KategoriOPDAjaxController::class, 'save'])->name('save');
                    Route::post('/switch', [KategoriOPDAjaxController::class, 'switch'])->name('switch');
                    Route::post('/delete', [KategoriOPDAjaxController::class, 'delete'])->name('delete');
                });

                Route::prefix('inisiator')->name('inisiator.')->group(function () {
                    Route::get('/', [App\Http\Controllers\InisiatorController::class, 'index'])->name('index');
                    Route::post('/', [App\Http\Controllers\InisiatorController::class, 'save'])->name('save');
                    Route::post('/delete', [App\Http\Controllers\InisiatorController::class, 'delete'])->name('delete');
                });
                Route::prefix('jenis')->name('jenis.')->group(function () {
                    Route::get('/', [App\Http\Controllers\JenisController::class, 'index'])->name('index');
                    Route::post('/', [App\Http\Controllers\JenisController::class, 'save'])->name('save');
                    Route::post('/delete', [App\Http\Controllers\JenisController::class, 'delete'])->name('delete');
                });
                Route::prefix('urusan')->name('urusan.')->group(function () {
                    Route::get('/', [App\Http\Controllers\UrusanController::class, 'index'])->name('index');
                    Route::post('/', [App\Http\Controllers\UrusanController::class, 'save'])->name('save');
                    Route::post('/delete', [App\Http\Controllers\UrusanController::class, 'delete'])->name('delete');
                });
                Route::prefix('bentuk')->name('bentuk.')->group(function () {
                    Route::get('/', [App\Http\Controllers\BentukController::class, 'index'])->name('index');
                    Route::post('/', [App\Http\Controllers\BentukController::class, 'save'])->name('save');
                    Route::post('/delete', [App\Http\Controllers\BentukController::class, 'delete'])->name('delete');
                });
                Route::prefix('jabatan')->name('jabatan.')->group(function () {
                    Route::get('/', [App\Http\Controllers\JabatanController::class, 'index'])->name('index');
                    Route::post('/', [App\Http\Controllers\JabatanController::class, 'save'])->name('save');
                    Route::post('/delete', [App\Http\Controllers\JabatanController::class, 'delete'])->name('delete');
                });
                Route::prefix('golongan')->name('golongan.')->group(function () {
                    Route::get('/', [App\Http\Controllers\GolonganController::class, 'index'])->name('index');
                    Route::post('/', [App\Http\Controllers\GolonganController::class, 'save'])->name('save');
                    Route::post('/delete', [App\Http\Controllers\GolonganController::class, 'delete'])->name('delete');
                });
                Route::prefix('faq')->name('faq.')->group(function () {
                    Route::get('/', [App\Http\Controllers\FaqController::class, 'index'])->name('index');
                    Route::post('/', [App\Http\Controllers\FaqController::class, 'save'])->name('save');
                    Route::post('/delete', [App\Http\Controllers\FaqController::class, 'delete'])->name('delete');
                });
                Route::prefix('kategori')->name('kategori.')->group(function () {
                    Route::get('/', [App\Http\Controllers\KategoriController::class, 'index'])->name('index');
                    Route::post('/', [App\Http\Controllers\KategoriController::class, 'save'])->name('save');
                    Route::post('/delete', [App\Http\Controllers\KategoriController::class, 'delete'])->name('delete');
                });
                Route::prefix('tematik')->name('tematik.')->group(function () {
                    Route::get('/', [App\Http\Controllers\TematikController::class, 'index'])->name('index');
                    Route::post('/', [App\Http\Controllers\TematikController::class, 'save'])->name('save');
                    Route::post('/delete', [App\Http\Controllers\TematikController::class, 'delete'])->name('delete');
                });
                Route::prefix('detail_tematik')->name('detail_tematik.')->group(function () {
                    Route::get('/', [App\Http\Controllers\DetailTematikController::class, 'index'])->name('index');
                    Route::post('/', [App\Http\Controllers\DetailTematikController::class, 'save'])->name('save');
                    Route::post('/delete', [App\Http\Controllers\DetailTematikController::class, 'delete'])->name('delete');
                });

                Route::prefix('fase')->name('fase.')->group(function () {
                    Route::get('/', [FaseController::class, 'index'])->name('index');
                    Route::post('/', [FaseController::class, 'store'])->name('save');
                    Route::post('/delete', [FaseController::class, 'delete'])->name('delete');
                });

                Route::prefix('penilaian')->name('penilaian.')->group(function () {
                    Route::get('/', [PenilaianController::class, 'index'])->name('index');
                    Route::post('/', [PenilaianController::class, 'save'])->name('save');
                    Route::post('/delete', [PenilaianController::class, 'delete'])->name('delete');
                });
                Route::prefix('juri')->name('juri.')->group(function () {
                    Route::get('/', [JuriController::class, 'index'])->name('index');
                    Route::post('/', [JuriController::class, 'save'])->name('save');
                    Route::post('/delete', [JuriController::class, 'delete'])->name('delete');
                });


                Route::prefix('contact')->name('contact.')->group(function () {
                    Route::get('/', [ContactController::class, 'index'])->name('index');
                    Route::post('/', [ContactController::class, 'save'])->name('save');
                    Route::post('/delete', [ContactController::class, 'delete'])->name('delete');
                });
            });

            Route::prefix('setting')->name('setting.')->group(function () {
                Route::get('/', [App\Http\Controllers\SettingController::class, 'index'])->name('index');
                Route::put('/{id}', [App\Http\Controllers\SettingController::class, 'update'])->name('update');
            });
        });

        Route::get('/faq', [App\Http\Controllers\FaqController::class, 'index_user'])->name('faq.index');

        Route::prefix('profil-pemda')->name('profil-pemda.')->group(function () {
            Route::get('/', [App\Http\Controllers\ProfilPemdaController::class, 'index'])->name('index');
            Route::get('/detail', [App\Http\Controllers\ProfilPemdaController::class, 'index_detail'])->name('detail');
            Route::get('/detail_kota_kab', [App\Http\Controllers\ProfilPemdaController::class, 'index_detail_kota_kab'])->name('detail_kota_kab');
            Route::get('/export/{type}', [App\Http\Controllers\ProfilPemdaController::class, 'export'])->name('export');
            Route::post('/upload-pakta', [App\Http\Controllers\ProfilPemdaController::class, 'upload_pakta'])->name('upload-pakta');
            Route::post('/saveParam', [App\Http\Controllers\ProfilPemdaController::class, 'saveParam'])->name('saveParam');

            Route::prefix('upload')->name('upload.')->group(function () {
                Route::get('/', [App\Http\Controllers\ProfilPemdaController::class, 'index_upload'])->name('index');
                Route::post('/add', [App\Http\Controllers\UploadController::class, 'add'])->name('add');
                Route::post('/', [App\Http\Controllers\UploadController::class, 'save'])->name('save');
                Route::post('/delete', [App\Http\Controllers\UploadController::class, 'delete'])->name('delete');
            });
        });

        Route::prefix('bank_data')->name('bank_data.')->group(function () {
            Route::get('/{area}', [App\Http\Controllers\InovasiController::class, 'bank_data'])->name('index');
        });
        Route::prefix('inovasi')->name('inovasi.')->group(function () {
            Route::get('/{area}', [App\Http\Controllers\InovasiController::class, 'index'])->name('index');
            Route::get('/filter/area', [App\Http\Controllers\InovasiController::class, 'index'])->name('filter-area');
            Route::get('/form/edit', [App\Http\Controllers\InovasiController::class, 'edit'])->name('edit');
            Route::get('/form/detail', [App\Http\Controllers\InovasiController::class, 'detail'])->name('detail');
            Route::get('/export/{type}', [App\Http\Controllers\InovasiController::class, 'export'])->name('export');
            Route::post('/', [App\Http\Controllers\InovasiController::class, 'save'])->name('save');
            Route::post('/show_tahapan', [App\Http\Controllers\InovasiController::class, 'show_tahapan'])->name('show_tahapan');
            Route::post('/show_inovasi', [App\Http\Controllers\InovasiController::class, 'show_inovasi'])->name('show_inovasi');
            Route::post('/delete', [App\Http\Controllers\InovasiController::class, 'delete'])->name('delete');
            Route::post('/update', [App\Http\Controllers\InovasiController::class, 'update'])->name('update');
            Route::post('/sent', [App\Http\Controllers\InovasiController::class, 'sent'])->name('sent');
            #get detail tematik using post
            Route::post('/inovasi/ajax_detail_tematik', [InovasiController::class, 'detail_tematik'])->name('ajax_detail_tematik');
            Route::post('/inovasi/ajax_kategori_inovasi', [InovasiController::class, 'kategori_inovasi'])->name('ajax_kategori_inovasi');


            Route::prefix('indikator')->name('indikator.')->group(function () {
                Route::get('/list', [App\Http\Controllers\InovasiController::class, 'index_indikator'])->name('index');
                Route::post('/chooseParam', [App\Http\Controllers\IndikatorController::class, 'chooseParam'])->name('chooseParam');
                Route::post('/saveParam', [App\Http\Controllers\IndikatorController::class, 'saveParam'])->name('saveParam');
                Route::post('/show_definisi_parameter', [App\Http\Controllers\ParameterController::class, 'show'])->name('show');

                Route::prefix('upload')->name('upload.')->group(function () {
                    Route::get('/', [App\Http\Controllers\InovasiController::class, 'index_upload'])->name('index');
                    Route::post('/add', [App\Http\Controllers\UploadController::class, 'add'])->name('add');
                    Route::post('/', [App\Http\Controllers\UploadController::class, 'save'])->name('save');
                    Route::post('/delete', [App\Http\Controllers\UploadController::class, 'delete'])->name('delete');
                });
            });
        });

        Route::prefix('pengguna')->name('pengguna.')->group(function () {
            Route::get('/', [App\Http\Controllers\PenggunaController::class, 'index'])->name('index');
            Route::get('/filter-area', [App\Http\Controllers\PenggunaController::class, 'index'])->name('filter-area');
            Route::post('/', [App\Http\Controllers\PenggunaController::class, 'save'])->name('save');
            Route::post('/change-role', [App\Http\Controllers\PenggunaController::class, 'change_role'])->name('change-role');
            Route::post('/reset-pass', [App\Http\Controllers\PenggunaController::class, 'reset_pass'])->name('reset-pass');
            Route::post('/delete', [App\Http\Controllers\PenggunaController::class, 'delete'])->name('delete');
        });

        Route::prefix('opd')->name('opd.')->group(function () {
            Route::get('/', [App\Http\Controllers\OpdController::class, 'index'])->name('index');
            Route::get('/filter-area', [App\Http\Controllers\OpdController::class, 'index'])->name('filter-area');
            Route::post('/change-scope', [App\Http\Controllers\OpdController::class, 'change_scope'])->name('change-scope');
            Route::post('/', [App\Http\Controllers\OpdController::class, 'save'])->name('save');
            Route::post('/delete', [App\Http\Controllers\OpdController::class, 'delete'])->name('delete');
        });
        Route::prefix('penilaian')->name('penilaian.')->group(function () {
            Route::get('/index/{jenis}', [PenilaianInovasiController::class, 'index'])->name('index');
            Route::get('/form/edit', [PenilaianInovasiController::class, 'edit'])->name('edit');
            Route::post('/form/save', [PenilaianInovasiController::class, 'save'])->name('save');
            Route::get('/show', [PenilaianInovasiController::class, 'show'])->name('show');

            Route::get('/ranking/{jenis}', [PenilaianInovasiController::class, 'ranking'])->name('ranking');
        });

        Route::prefix('rekap')->name('rekap.')->group(function () {
            Route::get('/{type}', [App\Http\Controllers\RekapController::class, 'index'])->name('index');
        });
        Route::get('/panduan', [App\Http\Controllers\PanduanController::class, 'index'])->name('panduan');
    });
    Auth::routes(['register' => false]);
});