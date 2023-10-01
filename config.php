<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

// Costumers class
require_once BASE_PATH . '/lib/Costumers/config.php';
$costumers = new Costumers();

// Get Input data from query string
$search_string = filter_input(INPUT_GET, 'search_string');
$filter_col = filter_input(INPUT_GET, 'filter_col');
$order_by = filter_input(INPUT_GET, 'order_by');

// Per page limit for pagination.
$pagelimit = 15;

// Get current page.
$page = filter_input(INPUT_GET, 'page');
if (!$page) {
	$page = 1;
}

// If filter types are not selected we show latest added data first
if (!$filter_col) {
	$filter_col = 'id';
}
if (!$order_by) {
	$order_by = 'Desc';
}

//Get DB instance. i.e instance of MYSQLiDB Library
$db = getDbInstance();
$select = array('id','razorpay_name','razorpay_image','razorpay_api_key','razorpay_api_secret','onesignal_app_id','onesignal_api_key','whatsapp_webhook_url','whatsapp_auth_key','whatsapp_app_key','telegram_master_bot_token','telegram_admin_bot_token','telegram_payment_bot_token','sms_api_url','sms_api_key','smtp_host','smtp_port','smtp_protocol','smtp_email','smtp_pass');

// Set pagination limit
$db->pageLimit = $pagelimit;

// Get result of the query.
$rows = $db->arraybuilder()->paginate('config', $page, $select);
$total_pages = $db->totalPages;

include BASE_PATH . '/includes/header.php';
?>
<!-- Main container -->
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-6">
            <h1 class="page-header">App Server Configuration</h1>
        </div>
    </div>
    <?php include BASE_PATH . '/includes/flash_messages.php';?>
    <hr>
    <div class="container mt-4">
        <table class="table table-striped table-bordered table-condensed">
            <tbody>
                <?php foreach ($rows as $row): ?>
                <?php $ayaz = $row['id']; ?>
                <tr>
                    <th scope="row" width="30%">Razorpay Payment Title</th>
                    <td><?php echo xss_clean($row['razorpay_name']); ?>
                </tr>
                <tr>
                    <th scope="row" width="30%">Razorpay Payment Logo</th>
                    <td>
                        <img width="70" height="70" src="<?php echo xss_clean($row['razorpay_image']); ?>"/>
                </tr>
                <tr>
                    <th scope="row" width="30%">Razorpay Api Key</th>
                    <td><?php echo xss_clean($row['razorpay_api_key']); ?>
                </tr>
                <tr>
                    <th scope="row" width="30%">Razorpay Api Secret</th>
                    <td><?php echo xss_clean($row['razorpay_api_secret']); ?>
                </tr>
                <tr>
                    <th scope="row" width="30%">One Signal App Id</th>
                    <td><?php echo xss_clean($row['onesignal_app_id']); ?>
                </tr>
                <tr>
                    <th scope="row" width="30%">One Signal Api Key</th>
                    <td><?php echo xss_clean($row['onesignal_api_key']); ?>
                </tr>
                <tr>
                    <th scope="row" width="30%">WhatsApp Webhook Url</th>
                    <td><?php echo xss_clean($row['whatsapp_webhook_url']); ?>
                </tr>
                <tr>
                    <th scope="row" width="30%">WhatsApp Auth Key</th>
                    <td><?php echo xss_clean($row['whatsapp_auth_key']); ?>
                </tr>
                <tr>
                    <th scope="row" width="30%">WhatsApp App Key</th>
                    <td><?php echo xss_clean($row['whatsapp_app_key']); ?>
                </tr>
                <tr>
                    <th scope="row" width="30%">Telegram Master Admin Bot Token</th>
                    <td><?php echo xss_clean($row['telegram_master_bot_token']); ?>
                </tr>
                <tr>
                    <th scope="row" width="30%">Telegram Admin Bot Token</th>
                    <td><?php echo xss_clean($row['telegram_admin_bot_token']); ?>
                </tr>
                <tr>
                    <th scope="row" width="30%">Telegram Payment Bot Token</th>
                    <td><?php echo xss_clean($row['telegram_payment_bot_token']); ?>
                </tr>
                <tr>
                    <th scope="row" width="30%">SMS Api Url</th>
                    <td><?php echo xss_clean($row['sms_api_url']); ?>
                </tr>
                <tr>
                    <th scope="row" width="30%">SMS Api Key</th>
                    <td><?php echo xss_clean($row['sms_api_key']); ?>
                </tr>
                <tr>
                    <th scope="row" width="30%">SMTP Host</th>
                    <td><?php echo xss_clean($row['smtp_host']); ?>
                </tr>
                <tr>
                    <th scope="row" width="30%">SMTP Port</th>
                    <td><?php echo xss_clean($row['smtp_port']); ?>
                </tr>
                <tr>
                    <th scope="row" width="30%">SMTP Connection</th>
                    <td><?php echo xss_clean($row['smtp_protocol']); ?>
                </tr>
                <tr>
                    <th scope="row" width="30%">SMTP Sender Username</th>
                    <td><?php echo xss_clean($row['smtp_email']); ?>
                </tr>
                <tr>
                    <th scope="row" width="30%">SMTP Sender Password</th>
                    <td><?php echo xss_clean($row['smtp_pass']); ?>
                </tr>
                <tr>
                    <th scope="row" width="30%">Action</th>
                    <td> <a href="edit_config.php?id=1" class="btn btn-primary"><i class="glyphicon glyphicon-edit"> Edit Configuration</i></a>
                </tr>
                <?php ;endforeach; ?>
            </tbody>
        </table>
    </div>
  
    <div class="text-center">
    <?php echo paginationLinks($page, $total_pages, 'notification.php'); ?>
    </div>
</div>
<?php include BASE_PATH . '/includes/footer.php';?>