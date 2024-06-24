<?php
include 'koneksi.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btnnewpass'])) {
    $txtemaillupapass = $_POST['txtemail']; // Mengambil nilai email dari form
    $txtnewpass = $_POST['txtnewpass']; // Mengambil nilai sandi baru dari form

    // Validasi email dan sandi baru di sini jika diperlukan
    if (!filter_var($txtemaillupapass, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Email tidak valid');</script>";
    } else {
        // Lakukan query untuk memeriksa apakah email ada di database
        $query_check_email = "SELECT * FROM user WHERE email=?";
        $stmt_check_email = mysqli_prepare($conn, $query_check_email);
        mysqli_stmt_bind_param($stmt_check_email, "s", $txtemaillupapass);
        mysqli_stmt_execute($stmt_check_email);
        $result_check_email = mysqli_stmt_get_result($stmt_check_email);

        if (mysqli_num_rows($result_check_email) > 0) {
            // Email ditemukan, lanjutkan dengan proses update password
            // Lakukan pengenkripsian sandi baru menggunakan password_hash()
            $hashed_password = password_hash($txtnewpass, PASSWORD_DEFAULT);

            // Update sandi baru ke dalam database
            $query_update_pass = "UPDATE user SET password=? WHERE email=?";
            $stmt_update_pass = mysqli_prepare($conn, $query_update_pass);
            mysqli_stmt_bind_param($stmt_update_pass, "ss", $hashed_password, $txtemaillupapass);
            mysqli_stmt_execute($stmt_update_pass);

            if (mysqli_stmt_affected_rows($stmt_update_pass) > 0) {
                echo "<script>alert('Password berhasil diubah');</script>";
                // Redirect atau lakukan sesuatu setelah berhasil mengubah password
            } else {
                echo "<script>alert('Gagal mengubah password');</script>";
            }
            mysqli_stmt_close($stmt_update_pass);
        } else {
            // Email tidak ditemukan di database
            echo "<script>alert('Email tidak valid');</script>";
        }

        mysqli_stmt_close($stmt_check_email);
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hajuenter password</title>
    <link rel="stylesheet" href="./css/output.css">
</head>
<body>
<main id="content" role="main" class="w-full  max-w-md mx-auto p-6">
    <div class="mt-7 bg-gradient-to-r from-slate-900 to-slate-700  rounded-xl shadow-lg dark:bg-gray-800 dark:border-gray-700 border-3 border-indigo-300">
      <div class="p-4 sm:p-7">
        <div class="text-center">
          <h1 class="block text-2xl font-bold text-indigo-500 dark:text-white">Forgot password?</h1>
          <p class="mt-2 text-sm text-neutral-400 dark:text-gray-400">
            Remember your password?
            <a class="text-blue-600 decoration-2 hover:underline font-medium" href="index.php">
                  Login here
            </a>
          </p>
        </div>

        <div class="mt-5">
          <form method="post">
            <div class="grid gap-y-4">
              <div>
                <label for="email" class="block text-sm font-bold ml-1 mb-2 text-neutral-400 dark:text-white">Email address</label>
                <div class="relative">
                  <input type="email" id="email" name="txtemail" class="py-3 px-4 block w-full border-2 border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm" required aria-describedby="email-error">
                </div>
                <p class="hidden text-xs text-red-600 mt-2" id="email-error">Please include a valid email address so we can get back to you</p>
              </div>
              <div>
                <label for="newPass" class="block text-sm font-bold ml-1 mb-2 text-neutral-400 dark:text-white">New password</label>
                <div class="relative">
                  <input type="password" id="password" name="txtnewpass" class="py-3 px-4 block w-full border-2 border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm" required aria-describedby="email-error">
                </div>
              </div>
              <button type="submit" name="btnnewpass" class="py-3 px-4 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-blue-600 hover:bg-blue-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800">Reset password</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <p class="mt-3 flex justify-center items-center text-center divide-x divide-gray-300 dark:divide-gray-700">
      <a class="pr-3.5 inline-flex items-center gap-x-2 text-sm text-gray-600 decoration-2 hover:underline hover:text-blue-600 dark:text-gray-500 dark:hover:text-gray-200" href="https://github.com/hajuenter" target="_blank">
        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
          <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z" />
        </svg>
        View Github
      </a>
      <a class="pl-3 inline-flex items-center gap-x-2 text-sm text-gray-600 decoration-2 hover:underline hover:text-blue-600 dark:text-gray-500 dark:hover:text-gray-200" href="#">
        Contact us!
      </a>
    </p>
  </main>
</body>
</html>