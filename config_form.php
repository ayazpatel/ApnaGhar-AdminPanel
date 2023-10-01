<?php
// Check if user_id is provided in the URL
if (isset($_GET['id'])) {
    $config_id_to_update = $_GET['id'];

    // Database connection (replace with your actual database credentials)
    $servername = "localhost";
    $username = "ayaz";
    $password = "ayaz29292";
    $dbname = "test_ayafitech_com";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch the user's data
    $sql = "SELECT * FROM config WHERE id = '$config_id_to_update'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $home_data = $result->fetch_assoc();
    } else {
        echo "Data not found";
    }
    $conn->close();
} else {
    echo "ID not provided in the URL";
}

$SmtpProtocol = array(
    "tls",
    "ssl"
);

if (isset($_POST['btn_save'])) {
    $razorpay_name = $_POST['razorpay_name'];
    $razorpay_api_key = $_POST['razorpay_api_key'];
    $razorpay_api_secret = $_POST['razorpay_api_secret'];
    $onesignal_app_id = $_POST['onesignal_app_id'];
    $onesignal_api_key = $_POST['onesignal_api_key'];
    $whatsapp_webhook_url = $_POST['whatsapp_webhook_url'];
    $whatsapp_auth_key = $_POST['whatsapp_auth_key'];
    $whatsapp_app_key = $_POST['whatsapp_app_key'];
    $telegram_master_bot_token = $_POST['telegram_master_bot_token'];
    $telegram_admin_bot_token = $_POST['telegram_admin_bot_token'];
    $telegram_payment_bot_token = $_POST['telegram_payment_bot_token'];
    $sms_api_url = $_POST['sms_api_url'];
    $sms_api_key = $_POST['sms_api_key'];
    $smtp_host = $_POST['smtp_host'];
    $smtp_port = $_POST['smtp_port'];
    $smtp_protocol = $_POST['smtp_protocol'];
    $smtp_email = $_POST['smtp_email'];
    $smtp_pass = $_POST['smtp_pass'];

    // Handle image uploads
    $image1_name = '';
    if ($_FILES['Image1']['error'] === UPLOAD_ERR_OK) {
        $image1_name = 'razorpay_logo_' . uniqid() . '.jpg'; // Generate a unique name
        $image1_path = './api/razorpay/assets/' . $image1_name;
        move_uploaded_file($_FILES['Image1']['tmp_name'], $image1_path);
    }

    // Database connection (replace with your actual database credentials)
    $servername = "localhost";
    $username = "ayaz";
    $password = "ayaz29292";
    $dbname = "test_ayafitech_com";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $initials_1 = "https://et.ayafitech.com/api/razorpay/assets/".$image1_name;
    // Update the record in the database
    $sql = "UPDATE config SET 
        razorpay_name = '$razorpay_name',
        razorpay_image = '$initials_1',
        razorpay_api_key = '$razorpay_api_key',
        razorpay_api_secret = '$razorpay_api_secret',
        onesignal_app_id = '$onesignal_app_id',
        onesignal_api_key = '$onesignal_api_key',
        whatsapp_webhook_url = '$whatsapp_webhook_url',
        whatsapp_auth_key = '$whatsapp_auth_key',
        whatsapp_app_key = '$whatsapp_app_key',
        telegram_master_bot_token = '$telegram_master_bot_token',
        telegram_admin_bot_token = '$telegram_admin_bot_token',
        telegram_payment_bot_token = '$telegram_payment_bot_token',
        sms_api_url = '$sms_api_url',
        sms_api_key = '$sms_api_key',
        smtp_host = '$smtp_host',
        smtp_port = '$smtp_port',
        smtp_protocol = '$smtp_protocol',
        smtp_email = '$smtp_email',
        smtp_pass = '$smtp_pass'
        WHERE id = $config_id_to_update";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
}

?>
<div class="container">
  <form method="post" action="" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $config_data['id']; ?>">
    
    <div class="form-group">
            <label for="razorpay_name">Razorpay Payment Name</label>
            <input type="text" name="razorpay_name" value="<?php echo htmlspecialchars($home_data['razorpay_name'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Number of Rooms" class="form-control" required="required" id="razorpay_name">
    </div>
    <div class="form-group">
            <label for="Image1">Razorpay Payment Logo</label>
            <input type="file" name="Image1" value="<?php echo htmlspecialchars($home_data['razorpay_image'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Select 1st Image" class="form-control" required="required" id="Image1">
    </div>
    <div class="form-group">
            <label for="razorpay_name">Razorpay Api Key</label>
            <input type="text" name="razorpay_api_key" value="<?php echo htmlspecialchars($home_data['razorpay_api_key'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Number of Rooms" class="form-control" required="required" id="razorpay_api_key">
    </div>
    <div class="form-group">
            <label for="razorpay_api_secret">Razorpay Api Secret</label>
            <input type="text" name="razorpay_api_secret" value="<?php echo htmlspecialchars($home_data['razorpay_api_secret'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Number of Rooms" class="form-control" required="required" id="razorpay_api_secret">
    </div>
    <div class="form-group">
            <label for="onesignal_app_id">One Signal App Id</label>
            <input type="text" name="onesignal_app_id" value="<?php echo htmlspecialchars($home_data['onesignal_app_id'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Number of Rooms" class="form-control" required="required" id="onesignal_app_id">
    </div>
    <div class="form-group">
            <label for="onesignal_api_key">One Signal Api Key</label>
            <input type="text" name="onesignal_api_key" value="<?php echo htmlspecialchars($home_data['onesignal_api_key'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Number of Rooms" class="form-control" required="required" id="onesignal_api_key">
    </div>
    <div class="form-group">
            <label for="whatsapp_webhook_url">WhatsApp Webhook Url</label>
            <input type="text" name="whatsapp_webhook_url" value="<?php echo htmlspecialchars($home_data['whatsapp_webhook_url'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Number of Rooms" class="form-control" required="required" id="whatsapp_webhook_url">
    </div>
    <div class="form-group">
            <label for="whatsapp_auth_key">WhatsApp Webhook Auth Key</label>
            <input type="text" name="whatsapp_auth_key" value="<?php echo htmlspecialchars($home_data['whatsapp_auth_key'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Number of Rooms" class="form-control" required="required" id="whatsapp_auth_key">
    </div>
    <div class="form-group">
            <label for="whatsapp_app_key">WhatsApp Webhook App Key</label>
            <input type="text" name="whatsapp_app_key" value="<?php echo htmlspecialchars($home_data['whatsapp_app_key'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Number of Rooms" class="form-control" required="required" id="whatsapp_app_key">
    </div>
    <div class="form-group">
            <label for="telegram_master_bot_token">Telegram Master Admin Bot</label>
            <input type="text" name="telegram_master_bot_token" value="<?php echo htmlspecialchars($home_data['telegram_master_bot_token'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Number of Rooms" class="form-control" required="required" id="telegram_master_bot_token">
    </div>
    <div class="form-group">
            <label for="telegram_admin_bot_token">Telegram Admin Bot</label>
            <input type="text" name="telegram_admin_bot_token" value="<?php echo htmlspecialchars($home_data['telegram_admin_bot_token'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Number of Rooms" class="form-control" required="required" id="telegram_admin_bot_token">
    </div><div class="form-group">
            <label for="telegram_payment_bot_token">Telegram Payment Bot</label>
            <input type="text" name="telegram_payment_bot_token" value="<?php echo htmlspecialchars($home_data['telegram_payment_bot_token'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Number of Rooms" class="form-control" required="required" id="telegram_payment_bot_token">
    </div>
    <div class="form-group">
            <label for="sms_api_url">SMS Api Url</label>
            <input type="text" name="sms_api_url" value="<?php echo htmlspecialchars($home_data['sms_api_url'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Number of Rooms" class="form-control" required="required" id="sms_api_url">
    </div>
    <div class="form-group">
            <label for="sms_api_key">SMS Api Key</label>
            <input type="text" name="sms_api_key" value="<?php echo htmlspecialchars($home_data['sms_api_key'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Number of Rooms" class="form-control" required="required" id="sms_api_key">
    </div>
    <div class="form-group">
            <label for="smtp_host">SMTP Host</label>
            <input type="text" name="smtp_host" value="<?php echo htmlspecialchars($home_data['smtp_host'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Number of Rooms" class="form-control" required="required" id="smtp_host">
    </div>
    <div class="form-group">
            <label for="smtp_port">SMTP Port</label>
            <input type="text" name="smtp_port" value="<?php echo htmlspecialchars($home_data['smtp_port'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Number of Rooms" class="form-control" required="required" id="smtp_port">
    </div>
    <div class="form-group">
            <label for="smtp_protocol">SMTP Connection</label>
            <input type="text" name="smtp_protocol" value="<?php echo htmlspecialchars($home_data['smtp_protocol'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Number of Rooms" class="form-control" required="required" id="smtp_protocol">
    </div>
    <div class="form-group">
            <label for="smtp_email">SMTP Sender Mail</label>
            <input type="text" name="smtp_email" value="<?php echo htmlspecialchars($home_data['smtp_email'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Number of Rooms" class="form-control" required="required" id="smtp_email">
    </div>
    <div class="form-group">
            <label for="smtp_pass">SMTP Sender Password</label>
            <input type="text" name="smtp_pass" value="<?php echo htmlspecialchars($home_data['smtp_pass'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Number of Rooms" class="form-control" required="required" id="smtp_pass">
    </div>
     <div class="form-group text-center">
            <button type="submit" class="btn btn-warning" id="btn_save" name="btn_save">Save Changes</button>
        </div>
</form>
  
</div>

