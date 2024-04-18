<?php

use App\Http\Controllers\CryptoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/crypto');
});

Route::get('/crypto', [CryptoController::class, 'showForm']);

Route::post('/encrypt-des', [CryptoController::class, 'encryptDES'])->name('encrypt-des');
Route::post('/decrypt-des', [CryptoController::class, 'decryptDES'])->name('decrypt-des');

Route::post('/encrypt-rsa', [CryptoController::class, 'encryptRSA'])->name('encrypt-rsa');
Route::post('/decrypt-rsa', [CryptoController::class, 'decryptRSA'])->name('decrypt-rsa');

Route::post('/generate-signature', [CryptoController::class, 'generateSignature'])->name('generate-signature');
Route::post('/verify-signature', [CryptoController::class, 'verifySignature'])->name('verify-signature');

Route::get('/generate-dsa-keys', [CryptoController::class, 'generateDSAKeys'])->name('generate-dsa-keys');
