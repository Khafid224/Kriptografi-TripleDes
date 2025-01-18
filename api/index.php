<?php

// Fungsi untuk mengenkripsi pesan menggunakan Triple DES
function encrypt3DES($key, $message)
{
    // Menggunakan mode CBC dan padding PKCS7
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('des-ede3-cbc'));
    $encryptedMessage = openssl_encrypt($message, 'des-ede3-cbc', $key, OPENSSL_RAW_DATA, $iv);
    return base64_encode($iv . $encryptedMessage); // Menggabungkan IV dan pesan terenkripsi
}

// Fungsi untuk mendekripsi pesan menggunakan Triple DES
function decrypt3DES($key, $encryptedMessage)
{
    $data = base64_decode($encryptedMessage);
    $ivLength = openssl_cipher_iv_length('des-ede3-cbc');
    $iv = substr($data, 0, $ivLength);
    $encryptedMessage = substr($data, $ivLength);
    return openssl_decrypt($encryptedMessage, 'des-ede3-cbc', $key, OPENSSL_RAW_DATA, $iv);
}

// Cek jika form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'encrypt') {
            $keyInput = $_POST['key'];
            $message = $_POST['message'];
            $encryptedMessage = encrypt3DES($keyInput, $message);
        } elseif ($_POST['action'] == 'decrypt') {
            $keyInput = $_POST['key'];
            $encryptedMessage = $_POST['encrypted_message'];
            $decryptedMessage = decrypt3DES($keyInput, $encryptedMessage);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Triple DES Encryption and Decryption</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .btn {
            transition: background-color 0.3s, transform 0.3s;
        }

        .btn:hover {
            background-color: #c53030;
            /* Warna saat hover */
            transform: scale(1.05);
            /* Efek zoom saat hover */
        }

        .btn:active {
            transform: scale(0.95);
            /* Efek zoom saat ditekan */
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-900">

    <div class="container mx-auto my-10 p-5 bg-white rounded shadow-md fade-in">
        <h1 class="text-3xl font-bold mb-6 text-center bg-yellow-500 text-white p-3 rounded">
            Enkripsi dan Dekripsi Dengan Kriptografi Triple DES
        </h1>

        <div class="mb-4">
        </div>
        <br><br>
        <!-- Error Message -->
        <?php if (isset($error)): ?>
            <div class="bg-red-100 text-red-700 p-4 rounded mb-6">
                <strong>Error:</strong> <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <!-- Encrypt Form -->
        <div class="mb-6">
            <h2 class="text-2xl mb-4">Enkripsi Pesan</h2>
            <form action="" method="POST">
                <input type="hidden" name="action" value="encrypt">
                <textarea name="message" class="w-full p-2 bg-gray-100 rounded-md" placeholder="Masukkan pesan yang ingin dienkripsi" required></textarea>
                <textarea name="key" class="w-full p-2 bg-gray-100 rounded-md mt-4" placeholder="Masukkan kunci" required></textarea>
                <button type="submit" class="btn px-4 py-2 bg-red-500 text-white rounded-md mt-4">Enkripsi</button>
            </form>
        </div>

        <?php if (isset($encryptedMessage)): ?>
            <div class="mb-6">
                <p><strong>Hasil Enkripsi:</strong></p>
                <textarea rows="4" class="w-full p-2 bg-gray-100 rounded-md" readonly><?php echo $encryptedMessage; ?></textarea>
            </div>
        <?php endif; ?>

        <!-- Decrypt Form -->
        <div class="mb-6">
            <h2 class="text-2xl mb-4">Dekripsi Pesan</h2>
            <form action="" method="POST">
                <input type="hidden" name="action" value="decrypt">
                <textarea name="encrypted_message" class="w-full p-2 bg-gray-100 rounded-md" placeholder="Masukkan pesan terenkripsi" required></textarea>
                <textarea name="key" class="w-full p-2 bg-gray-100 rounded-md mt-4" placeholder="Masukkan kunci" required></textarea>
                <button type="submit" class="btn px-4 py-2 bg-green-500 text-white rounded-md mt-4">Dekripsi</button>
            </form>
        </div>

        <?php if (isset($decryptedMessage)): ?>
            <div class="mb-6">
                <p><strong>Hasil Dekripsi:</strong></p>
                <textarea rows="4" class="w-full p-2 bg-gray-100 rounded-md" readonly><?php echo $decryptedMessage; ?></textarea>
            </div>
        <?php endif; ?>
        <br>
        <p class="text-center">©presented_by_Abdul Hafid</p>
        <p class="text-center">TUGAS MATKUL KEAMANAN SI</p>
    </div>

</body>

</html>