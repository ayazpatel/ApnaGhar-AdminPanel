<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

// Costumers class
require_once BASE_PATH . '/lib/Costumers/buy_sell.php';
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
$select = array('id','BS_Type','BS_Sub_Type','BS_Sub_Type2','BS_For','Image1','Image2','Image3','Price','Address','Landmark','State','City','Description','Owner','Phone_No','Email_Id','is_Featured','is_Sold','created_at');

//Start building query according to input parameters.
// If search string
if ($search_string) {
	$db->where('State', '%' . $search_string . '%', 'like');
	$db->orwhere('City', '%' . $search_string . '%', 'like');
}

//If order by option selected
if ($order_by) {
	$db->orderBy($filter_col, $order_by);
}

// Set pagination limit
$db->pageLimit = $pagelimit;

// Get result of the query.
$rows = $db->arraybuilder()->paginate('buy_sell', $page, $select);
$total_pages = $db->totalPages;

include BASE_PATH . '/includes/header.php';
?>
<!-- Main container -->
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-6">
            <h1 class="page-header">Property Detail</h1>
        </div>
        <div class="col-lg-6">
            <div class="page-action-links text-right">
                <a href="add_houses.php?operation=create" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Add Property</a>
            </div>
        </div>
    </div>
    <?php include BASE_PATH . '/includes/flash_messages.php';?>

    <!-- Filters -->
    <div class="well text-center filter-form">
        <form class="form form-inline" action="">
            <label for="input_search">Search</label>
            <input type="text" class="form-control" id="input_search" name="search_string" value="<?php echo $search_string; ?>">
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
    <!--<div id="export-section">-->
    <!--    <a href="export_customers.php"><button class="btn btn-sm btn-primary">Export to CSV <i class="glyphicon glyphicon-export"></i></button></a>-->
    <!--</div>-->
    <table class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="10%">Image</th>
                <th width="10%">Detail</th>
                <th width="10%">Price</th>
                <th width="10%">Status</th>
                <th width="10%">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $row): ?>
            <tr><?php $ayaz = $row['id']; ?>
                <td><?php echo $ayaz ?></td>
                <td><img width="150" height="150" src="https://et.ayafitech.com/api/<?php echo htmlspecialchars($row['Image1']); ?>" /></td>
                <td><?php echo $row['BS_Sub_Type'] . " " . $row['BS_Sub_Type2'] . " - " . $row['BS_Type'] . "<br>For " . $row['BS_For'] . " <br>" .
                "<br><b>Landmark: </b>". $row['Landmark'] .
                "<br><b>City: </b>". $row['City'] .
                "<br><b>State: </b>". $row['State'] . 
                "<br><b>Address: </b>" . $row['Address'] . 
                "<br><b>Name: </b>" . $row['Owner'].
                "<br><b>Phone: </b>" . $row['Phone_No'].
                "<br><b>Email: </b>" . $row['Email_Id']; ?></td>

                <td><?php echo xss_clean($row['Price']); ?></td>
                <td><?php 
                    if($row['is_Sold'] == 1) {
                        if($row['BS_For'] == "SELL") {
                            echo "Sold";
                        } else {
                            echo "Leased";
                        }
                    } else {
                        echo "Available";
                    }
                ?></td>
                
                <td>
                    <a href="edit_house.php?id=<?php echo $row['id']; ?>" class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i></a>
                    <a href="delete_house.php?delete_id=<?php echo $ayaz; ?>" class="btn btn-danger delete_btn"><i class="glyphicon glyphicon-trash"></i></a>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
    <div class="text-center">
    <?php echo paginationLinks($page, $total_pages, 'houses.php'); ?>
    </div>
</div>
<?php include BASE_PATH . '/includes/footer.php';?>