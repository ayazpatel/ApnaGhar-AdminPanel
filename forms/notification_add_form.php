<?php

$segmentOptions = array(
    "Total Subscriptions",
    "Active Users",
    "Inactive Users"
);


if (isset($_POST['btn_save'])) {
    $CampaignName = $_POST['campaign'];
    $ContentMessage = $_POST['content'];
    $SegmentName = $_POST['segment']; 
    
    
    $servername = "localhost";
    $username = "ayaz";
    $password = "ayaz29292";
    $dbname = "test_ayafitech_com";

    $conn = new mysqli($servername, $username, $password, $dbname);
    
    //  $sql = "INSERT INTO buy_sell (Image1, Image2, BS_Type, BS_Sub_Type, BS_Sub_Type2, BS_For, is_Sold, is_Featured, State, City, landmark, Price, Address, Description, Email_Id, Phone_No, Owner,created_at) 
    //         VALUES ('$initials_1', '$initials_2', '$category', '$rooms', '$property_type', '$property_for', '$is_sold', '$is_featured', '$State', '$City', '$landmark', '$price', '$address', '$description', '$owner_email', '$owner_phone', '$owner_name', NOW())";
    $sql = "INSERT INTO notification (segment,campaign,content) VALUES ('$SegmentName','$CampaignName','$ContentMessage')";

    if ($conn->query($sql) === TRUE) {
        // echo "Record inserted successfully";
        header("Location: https://et.ayafitech.com/notification.php");
    } else {
        echo "Error inserting record: " . $conn->error;
    }

    $conn->close();
    
}

?>

<form method="post" action="" enctype="multipart/form-data">
    <fieldset>
        <div class="form-group">
            <label for="campaign">Campaign Name</label>
            <input type="text" name="campaign" value="" placeholder="Campaign Name" class="form-control" required="required" id="campaign">
        </div>
         <div class="form-group">
            <label for="content">Notification Content</label>
            <textarea name="content" placeholder="Notification Content" rows="5" class="form-control" required="required" id="content"></textarea>
        </div>
        
         <div class="form-group">
            <label>Property Category</label>
            <select name="segment" class="form-control selectpicker" id="segment" required>
            <option value="">Select Segment</option>
            <?php
                foreach ($segmentOptions as $segmentOption) {
                    $selected = ($home_data['segment'] == $segmentOption) ? "selected" : "";
                    echo '<option value="' . $segmentOption . '" ' . $selected . '>' . $segmentOption . '</option>';
                }
                ?>
            </select>
        </div>
        
        <div class="form-group text-center">
            <button type="submit" class="btn btn-warning" id="btn_save" name="btn_save">Save Template</button>
        </div>
        
    </fieldset>
</form>


