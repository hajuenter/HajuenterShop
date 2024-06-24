<?php
include 'koneksi.php';
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btnlogin'])) {
    // Validasi checkbox "remember-me"
    if (!isset($_POST['remember-me'])) {
        echo "<script>alert('Harap setujui persyaratan untuk login');</script>";
    } else {
        $txtemail = $_POST['txtemail'];
        $txtpassword = $_POST['txtpassword'];

        // Enkripsi password menggunakan password_hash()
        $hashed_password = password_hash($txtpassword, PASSWORD_DEFAULT);

        // Prepared statement untuk query
        $stmt = mysqli_prepare($conn, "SELECT * FROM user WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $txtemail);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            // Verifikasi password menggunakan password_verify()
            if (password_verify($txtpassword, $row['password'])) {
                echo "<script>alert('Login sukses');</script>";
                // Lakukan sesuatu setelah login berhasil, misalnya set session
                session_start();
                $_SESSION['user_id'] = $row['id']; // Simpan ID pengguna ke session
                header("Location: dashboard.php"); // Redirect ke halaman dashboard
                exit();
            } else {
                echo "<script>alert('Login gagal');</script>";
            }
        } else {
            echo "<script>alert('Login gagal: Email tidak ditemukan');</script>";
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hajuenter login</title>
    <link rel="stylesheet" href="./css/output.css">
</head>
<body>
<div class="bg-white font-[sans-serif]">
      <div class="min-h-screen flex flex-col items-center justify-center py-2 px-4">
        <div class="max-w-md w-full">
          <img src="./img/logo14-removebg-preview.png" alt="logo" class="w-40 mb-0 mx-auto block"/>  
          <div class="p-8 rounded-2xl bg-gradient-to-r from-slate-900 to-slate-700 border-3 border-white">
            <h2 class="text-indigo-500 text-center text-2xl font-bold">Login</h2>
            <form method="post" class="mt-8 space-y-4">
              <div>
                <label class="text-neutral-400 text-sm mb-2 block">Email</label>
                <div class="relative flex items-center">
                  <input name="txtemail" type="email" required class="w-full text-gray-800 text-sm border border-gray-300 px-4 py-3 rounded-md outline-blue-600" placeholder="Enter email"/>
                  <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-4 h-4 absolute right-4" viewBox="0 0 24 24">
                    <circle cx="10" cy="7" r="6" data-original="#000000"></circle>
                    <path d="M14 15H6a5 5 0 0 0-5 5 3 3 0 0 0 3 3h12a3 3 0 0 0 3-3 5 5 0 0 0-5-5zm8-4h-2.59l.3-.29a1 1 0 0 0-1.42-1.42l-2 2a1 1 0 0 0 0 1.42l2 2a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42l-.3-.29H22a1 1 0 0 0 0-2z" data-original="#000000"></path>
                  </svg>
                </div>
              </div>
              <div>
                <label class="text-neutral-400 text-sm mb-2 block">Password</label>
                <div class="relative flex items-center">
                  <input name="txtpassword" type="password" required class="w-full text-gray-800 text-sm border border-gray-300 px-4 py-3 rounded-md outline-blue-600" placeholder="Enter password" />
                  <!-- <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-4 h-4 absolute right-4 cursor-pointer" viewBox="0 0 128 128">
                    <path d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z" data-original="#000000"></path>
                  </svg> -->
                </div>
              </div>

              <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center">
                  <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 shrink-0 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" />
                  <label for="remember-me" class="ml-3 block text-sm text-neutral-400">
                    Remember me
                  </label>
                </div>
                <div class="text-sm">
                  <a href="lupaPassword.php" class="text-blue-600 hover:underline font-semibold">
                    Forgot your password?
                  </a>
                </div>
              </div>
              <div class="!mt-8">
                <button name="btnlogin" type="submit" class="w-full py-3 px-4 text-sm tracking-wide rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
                  Sign in
                </button>
              </div>
              <p class="text-neutral-400 text-sm !mt-8 text-center">Don't have an account? <a href="register.php" class="text-blue-600 hover:underline ml-1 whitespace-nowrap font-semibold">Register here</a></p>
            </form>
          </div>
        </div>
      </div>
    </div>
</body>
</html>