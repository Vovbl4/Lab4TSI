<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use phpseclib3\Crypt\DES;
use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Crypt\RSA;
use phpseclib3\Crypt\DSA;
use phpseclib3\Crypt\DSA\PrivateKey;
use phpseclib3\Crypt\DSA\PublicKey;

class CryptoController extends Controller
{
    public function showForm()
    {
        $privateKeyPath = storage_path('keys/private_key.pem');
        $privateKeyString = file_get_contents($privateKeyPath);
        $privateKey = RSA::load($privateKeyString);
        $cleanPrivateKeyString = str_replace(["-----BEGIN PRIVATE KEY-----", "-----END PRIVATE KEY-----", "\r", "\n"], '', $privateKey->toString('PKCS8'));

        $publicKey = $privateKey->getPublicKey();
        $publicKeyString = str_replace(["-----BEGIN PUBLIC KEY-----", "-----END PUBLIC KEY-----", "\r", "\n"], '', $publicKey->toString('PKCS8'));

        $DSAprivateKeyPath = storage_path('keys/dsa_private_key.pem');
        $DSAprivateKeyString = file_get_contents($DSAprivateKeyPath);
        $DSAprivateKeyString = str_replace(["-----BEGIN PRIVATE KEY-----", "-----END PRIVATE KEY-----", "\r", "\n"], '', $DSAprivateKeyString);

        $DSApublicKeyPath = storage_path('keys/dsa_public_key.pem');
        $DSApublicKeyString = file_get_contents($DSApublicKeyPath);
        $DSApublicKeyString = str_replace(["-----BEGIN PUBLIC KEY-----", "-----END PUBLIC KEY-----", "\r", "\n"], '', $DSApublicKeyString);


        return view('crypto', [
            'privateKey' => $cleanPrivateKeyString,
            'publicKey' => $publicKeyString,
            'DSAPublicKey' => $DSApublicKeyString,
            'DSAPrivateKey' => $DSAprivateKeyString
        ]);
    }

    public function encryptDES(Request $request)
    {
        $des = new DES('ecb');
        $des->setKey('12345678');
        $encrypted = base64_encode($des->encrypt($request->input('message')));

        return back()->with('encrypted_message', $encrypted);
    }

    public function decryptDES(Request $request)
    {
        $des = new DES('ecb');
        $des->setKey('12345678');
        $decrypted = $des->decrypt(base64_decode($request->input('encrypted_message')));

        return back()->with('decrypted_message', $decrypted);
    }


    public function encryptRSA(Request $request)
    {
        $publicKeyString = $request->input('public_key');
        $publicKey = RSA::load($publicKeyString);

        $plaintext = $request->input('message');
        $encrypted = base64_encode($publicKey->encrypt($plaintext));

        return back()->with('encrypted_message', $encrypted);
    }


    public function decryptRSA(Request $request)
    {
        $privateKey = PublicKeyLoader::load($request->input('private_key'));
        $decrypted = $privateKey->decrypt(base64_decode($request->input('encrypted_message')));

        return back()->with('decrypted_message', $decrypted);
    }

    public function generateSignature(Request $request)
    {
        $privateKeyPath = storage_path('keys/dsa_private_key.pem');
        $privateKeyString = file_get_contents($privateKeyPath);
        $privateKey = DSA::load($privateKeyString);

        $signature = base64_encode($privateKey->sign($request->input('message')));

        return back()->with('signature', $signature);
    }

    public function verifySignature(Request $request)
    {
        $publicKeyPath = storage_path('keys/dsa_public_key.pem');
        $publicKeyString = file_get_contents($publicKeyPath);
        $publicKey = DSA::load($publicKeyString);

        $result = $publicKey->verify(
            $request->input('message'),
            base64_decode($request->input('signature'))
        );

        $verificationResult = $result ? 'Semnătura este validă.' : 'Semnătura nu este validă.';
        return back()->with('verification_result', $verificationResult);
    }
}
