<?php
if (isset($_POST['btn_save'])) {
    $first_name = $_POST['user_name'];
    $raw_password = $_POST['password'];
    $admin_type = $_POST['admin_type'];
    
    $hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);

    $servername = "localhost";
    $username = "ayaz";
    $password = "ayaz29292";
    $dbname = "test_ayafitech_com";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO admin_accounts (user_name, password, series_id, remember_token,expires,admin_type) 
            VALUES ('$first_name','$hashed_password', 'Created By Ayaz','$hashed_password', '2023-10-21 14:30:00', '$admin_type')";

    if ($conn->query($sql) === TRUE) {
        echo "Record inserted successfully";
    } else {
        echo "Error inserting record: " . $conn->error;
    }

    $conn->close();
}
?>
<form method="post" action="">
    <fieldset>
        <div class="form-group">
            <label for="user_name">Username</label>
            <input type="text" name="user_name" value="" placeholder="Username" class="form-control" required="required" id="user_name">
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" value="" placeholder="Password" class="form-control" required="required" id="password">
        </div>
        <div class="form-group">
            <label>Admin Type *</label>
            <label class="radio-inline">
                <input type="radio" name="admin_type" value="super" required="required"> Super Admin
            </label>
            <label class="radio-inline">
                <input type="radio" name="admin_type" value="admin" required="required"> Admin
            </label>
        </div>
        <div class="form-group text-center">
            <button type="submit" class="btn btn-warning" id="btn_save" name="btn_save">Add User</button>
        </div>
    </fieldset>
</form>