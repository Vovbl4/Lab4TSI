<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testare Criptografie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container mt-5">

    {{--DES--}}
    <div class="row">
        <div class="col-4">
            <form action="/encrypt-des" method="POST" class="mb-3">
                @csrf
                <div class="mb-3">
                    <label for="messageDES" class="form-label">Mesaj pentru criptarea DES:</label>
                    <input type="text" class="form-control" id="messageDES" name="message" required>
                </div>
                <button type="submit" class="btn btn-success">Criptează DES</button>
            </form>

            <form action="/decrypt-des" method="POST" class="mb-3">
                @csrf
                <div class="mb-3">
                    <label for="encryptedMessageDES" class="form-label">Mesaj criptat pentru decriptare DES:</label>
                    <input type="text" class="form-control" id="encryptedMessageDES" name="encrypted_message" required>
                </div>
                <button type="submit" class="btn btn-secondary">Decriptează DES</button>
            </form>
        </div>


    {{--RSA--}}
        <div class="col-4">
            <form action="/encrypt-rsa" method="POST" class="mb-3">
                @csrf
                <div class="mb-3">
                    <label for="messageRSA" class="form-label">Mesaj pentru criptarea RSA:</label>
                    <input type="text" class="form-control" id="messageRSA" name="message" required>
                </div>
                <label for="encryptedMessageRSA" class="form-label">Cheia publică RSA:</label>
                <textarea type="text" class="form-control mb-3" name="public_key">{{ $publicKey }}</textarea>
                <button type="submit" class="btn btn-success">Criptează RSA</button>
            </form>

            <form action="/decrypt-rsa" method="POST" class="mb-3">
                @csrf
                <div class="mb-3">
                    <label for="encryptedMessageRSA" class="form-label">Mesaj criptat pentru decriptare RSA:</label>
                    <input type="text" class="form-control" id="encryptedMessageRSA" name="encrypted_message" required>
                </div>
                <div class="mb-3">
                    <label for="privateKeyRSA" class="form-label">Cheie privată RSA (preîncărcată):</label>
                    <textarea type="text" class="form-control" id="privateKeyRSA" name="private_key" required>{{ $privateKey }}</textarea>
                </div>
                <button type="submit" class="btn btn-secondary">Decriptează RSA</button>
            </form>
        </div>

    {{--DSA--}}
        <div class="col-4">
            <form action="/generate-signature" method="POST" class="mb-3">
                @csrf
                <div class="mb-3">
                    <label for="messageSignature" class="form-label">Mesaj pentru generarea semnăturii:</label>
                    <input type="text" class="form-control" id="messageSignature" name="message" required>
                </div>
                <div class="mb-3">
                    <label for="privateKeyDSA" class="form-label">Cheie privată DSA:</label>
                    <textarea type="text" class="form-control" id="privateKeyDSA" name="private_key" required>{{ $DSAPrivateKey }}</textarea>
                </div>
                <button type="submit" class="btn btn-success">Generează Semnătură</button>
            </form>

            <form action="/verify-signature" method="POST" class="mb-3">
                @csrf
                <div class="mb-3">
                    <label for="messageVerify" class="form-label">Mesaj pentru verificare:</label>
                    <input type="text" class="form-control" id="messageVerify" name="message" required>
                </div>
                <div class="mb-3">
                    <label for="signatureVerify" class="form-label">Semnătură pentru verificare:</label>
                    <input type="text" class="form-control" id="signatureVerify" name="signature" required>
                </div>
                <div class="mb-3">
                    <label for="publicKeyDSA" class="form-label">Cheie publică DSA:</label>
                    <textarea type="text" class="form-control" id="publicKeyDSA" name="public_key" required>{{ $DSAPublicKey }}</textarea>
                </div>
                <button type="submit" class="btn btn-secondary">Verifică Semnătură</button>
            </form>
        </div>
    </div>


    @if(session('encrypted_message'))
        <div class="alert alert-info" style="word-wrap: break-word;">
            Mesaj criptat: <span>{{ session('encrypted_message') }}</span>
        </div>
    @endif


@if(session('decrypted_message'))
        <div class="alert alert-secondary">Mesaj decriptat: {{ session('decrypted_message') }}</div>
    @endif

    @if(session('signature'))
        <div class="alert alert-info">Semnătură generată: {{ session('signature') }}</div>
    @endif

    @if(session('verification_result'))
        <div class="alert alert-secondary">Rezultatul verificării semnăturii: {{ session('verification_result') }}</div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
