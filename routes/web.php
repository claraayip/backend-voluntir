use App\Http\Controllers\KegiatanController;

Route::post('/kegiatan', [KegiatanController::class, 'store']);