<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

// Costumers class
require_once BASE_PATH . '/lib/Costumers/notification.php';
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
$select = array('id','segment','campaign','content');

//Start building query according to input parameters.
// If search string
if ($search_string) {
	$db->where('id', '%' . $search_string . '%', 'like');
	$db->orwhere('segment', '%' . $search_string . '%', 'like');
	$db->orwhere('campaign', '%' . $search_string . '%', 'like');
	$db->orwhere('content', '%' . $search_string . '%', 'like');
}

//If order by option selected
if ($order_by) {
	$db->orderBy($filter_col, $order_by);
}

// Set pagination limit
$db->pageLimit = $pagelimit;

// Get result of the query.
$rows = $db->arraybuilder()->paginate('notification', $page, $select);
$total_pages = $db->totalPages;

include BASE_PATH . '/includes/header.php';
?>
<!-- Main container -->
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-6">
            <h1 class="page-header">Notifications</h1>
        </div>
    </div>
    <?php include BASE_PATH . '/includes/flash_messages.php';?>

    <!-- Filters -->
    <div class="well text-center filter-form">
        <form class="form form-inline" action="">
            <label for="input_search">Search</label>
            <input type="text" class="form-control" id="input_search" name="search_string" value="<?php echo $search_string ?>">
            <label for="input_order">Order By</label>
            <select name="filter_col" class="form-control">
                <?php
foreach ($costumers->setOrderingValues() as $opt_value => $opt_name):
	($order_by === $opt_value) ? $selected = 'selected' : $selected = '';
	echo ' <option value="' . $opt_value . '" ' . $selected . '>' . $opt_name . '</option>';
endforeach;
?>
            </select>
            <select name="order_by" class="form-control" id="input_order">
                <option value="Asc" <?php
if ($order_by == 'Asc') {
	echo 'selected';
}
?> >Asc</option>
                <option value="Desc" <?php
if ($order_by == 'Desc') {
	echo 'selected';
}
?>>Desc</option>
            </select>
            <input type="submit" value="Go" class="btn btn-primary">
        </form>
    </div>
    <hr>
    <table class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="15%">Segment</th>
                <th width="20%">Campaign</th>
                <th width="50%">Content</th>
                <th width="5%">Send</th>
                <th width="5%">Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $row): ?>
            <tr><?php $ayaz = $row['id']; ?>
                <td><?php echo $ayaz ?></td>
                <td><?php echo xss_clean($row['segment']); ?></td>
                <td><?php echo xss_clean($row['campaign']); ?></td>
                <td><?php echo xss_clean($row['content']); ?></td>
                <td>
                    <a href="./api/one_signal/send.php?id=<?php echo $ayaz; ?>" class="btn btn-primary"><i class="fa fa-send"></i>
                </td>
                <td>
                    <a href="./delete_notification.php?delete_id=<?php echo $ayaz; ?>" class="btn btn-danger delete_btn"><i class="glyphicon glyphicon-trash"></i>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
    <div class="text-center">
    <?php echo paginationLinks($page, $total_pages, 'notification.php'); ?>
    </div>
</div>
<?php include BASE_PATH . '/includes/footer.php';?>