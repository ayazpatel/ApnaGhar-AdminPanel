<?php
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';

?>


<?php
    include_once 'includes/header.php';
?>
<div id="page-wrapper">
    <div class="row">
        <h2 class="page-header"> Update Property</h2>
    </div>
    <!-- Flash messages -->
    <?php
        include('./includes/flash_messages.php')
    ?>

    <form class="" action="" method="post" enctype="multipart/form-data" id="contact_form">
        
        <?php
            //Include the common form for add and edit  
            require_once('./houses_form.php'); 
        ?>
    </form>
</div>




<?php include_once 'includes/footer.php'; ?>