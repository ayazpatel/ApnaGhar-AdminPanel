<?php

// $password  = "superadmin";
// $hashed_password = '$2y$10$eo7.w0Ttuy8mOBMvDlGqDeewQERkXu//7qO3jXp5NC76LwfAZpNrO';

// $valid_password = password_verify($password, $hashed_password);
// echo $valid_password;
// if($valid_password) {
//     echo "success";
// } else {
//     echo "failed";
// }

$raw_password = "admin123"; // Replace with the actual password
$hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);

echo $hashed_password;
?>