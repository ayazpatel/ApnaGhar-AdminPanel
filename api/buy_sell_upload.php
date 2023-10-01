<?php
// $servername = "localhost";
// $username = "ayaz";
// $db_password = "ayaz29292";
// $dbname = "test_ayafitech_com";

// $conn = new mysqli($servername, $username, $db_password, $dbname);
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// function uploadImage($imageData, $imageNumber) {
//     $path = "images/" . date("d-m-y") . "-" . time() . "-" . rand(10000, 100000) . ".jpg";
//     if (file_put_contents($path, base64_decode($imageData))) {
//         return $path;
//     }
//     return false;
// }

// $imageData1 = $_POST['image'];
// $imageData2 = $_POST['image2'];

// if (!empty($imageData1) && !empty($imageData2)) {
//     $path1 = uploadImage($imageData1, 1);
//     $path2 = uploadImage($imageData2, 2);

//     if ($path1 && $path2) {
//         // Perform SQL injection-safe insertion
//         $stmt = $conn->prepare("INSERT INTO buy_sell (Image1, Image2, BS_Type, BS_Sub_Type, Price, Address, Landmark, State, City, Owner, Phone_No, Email_Id, is_Featured, is_Sold, Created_At) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
//         // $stmt->bind_param("sssssssssssss", $path1, $path2, $bsType,$bsSubType, $price, $address, $landmark, $state, $city, $owner, $phoneNo, $emailId, $isFeatured, $isSold);
//         $stmt->bind_param("sssssssssssssi", $path1, $path2, $bsType, $bsSubType, $price, $address, $landmark, $state, $city, $owner, $phoneNo, $emailId, $isFeatured, $isSold);

//         $bsType = $_POST['BS_Type'];
//         $bsSubType = $_POST['BS_Sub_Type'];
//         $price = $_POST['Price'];
//         $address = $_POST['Address'];
//         $landmark = $_POST['Landmark'];
//         $state = $_POST['State'];
//         $city = $_POST['City'];
//         $owner = $_POST['Owner'];
//         $phoneNo = $_POST['Phone_No'];
//         $emailId = $_POST['Email_Id'];
//         $isFeatured = $_POST['is_Featured'];
//         $isSold = $_POST['is_Sold'];

//         if ($stmt->execute()) {
//             echo "success";
//         } else {
//             echo "failed to insert into the database";
//         }
//         $stmt->close();
//     } else {
//         echo "failed to upload image";
//     }
// } else {
//     echo "image data not found";
// }
// echo "<br>";
// print_r($_POST);


// $conn->close();
?>
<?php

// $servername = "localhost";
// $username = "ayaz";
// $db_password = "ayaz29292";
// $dbname = "test_ayafitech_com";

// $conn = new mysqli($servername, $username, $db_password, $dbname);
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// $imageData1 = $_POST['image'];
// $imageData2 = $_POST['image2'];

// function uploadImage($imageData, $imageNumber) {
//     $path = "images/" . date("d-m-y") . "-" . time() . "-" . rand(10000, 100000) . ".jpg";
//     if (file_put_contents($path, base64_decode($imageData))) {
//         return $path;
//     }
//     return false;
// }


// if (!empty($imageData1) && !empty($imageData2)) {
//     $path1 = uploadImage($imageData1, 1);
//     $path2 = uploadImage($imageData2, 2);

//     if ($path1 && $path2) {
//         // Insert data into the database
//         $bsType = $_POST['BS_Type'];
//         $bsSubType = $_POST['BS_Sub_Type'];
//         $bsSubType2 = $_POST['BS_Sub_Type2'];
//         $price = $_POST['Price'];
//         $address = $_POST['Address'];
//         $landmark = $_POST['Landmark'];
//         $state = $_POST['State'];
//         $city = $_POST['City'];
//         $description = $_POST['Description'];
//         $owner = $_POST['Owner'];
//         $phoneNo = $_POST['Phone_No'];
//         $emailId = $_POST['Email_Id'];
//         $isFeatured = $_POST['is_Featured'];
//         $isSold = $_POST['is_Sold'];

//         $sql = "INSERT INTO buy_sell (Image1, Image2, BS_Type, BS_Sub_Type, BS_Sub_Type2, Price, Address, Landmark, State, City, Owner, Phone_No, Email_Id, is_Featured, is_Sold, Created_At) VALUES ('$path1', '$path2', '$bsType', '$bsSubType', '$bsSubType2', '$price', '$address', '$landmark', '$state', '$city', '$description', '$owner', '$phoneNo', '$emailId', '$isFeatured', '$isSold', NOW())";

//         if ($conn->query($sql) === TRUE) {
//             echo "success";
//         } else {
//             echo "failed to insert into the database";
//         }
//     } else {
//         echo "failed to upload image";
//     }
// } else {
//     echo "image data not found";
// }

// $conn->close();


?>
<?php
$servername = "localhost";
$username = "ayaz";
$db_password = "ayaz29292";
$dbname = "test_ayafitech_com";

$conn = new mysqli($servername, $username, $db_password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$imageData1 = $_POST['image'];
$imageData2 = $_POST['image2'];

function uploadImage($imageData, $imageNumber) {
    $path = "images/" . date("d-m-y") . "-" . time() . "-" . rand(10000, 100000) . ".jpg";
    if (file_put_contents($path, base64_decode($imageData))) {
        return $path;
    }
    return false;
}

if (!empty($imageData1) && !empty($imageData2)) {
    $path1 = uploadImage($imageData1, 1);
    $path2 = uploadImage($imageData2, 2);

    if ($path1 && $path2) {
        // Insert data into the database
        $bsType = $_POST['BS_Type'];
        $bsSubType = $_POST['BS_Sub_Type'];
        $bsSubType2 = $_POST['BS_Sub_Type2']; 
        $bsFor = $_POST['BS_For'];// New field
        $price = $_POST['Price'];
        $address = $_POST['Address'];
        $landmark = $_POST['Landmark'];
        $state = $_POST['State'];
        $city = $_POST['City'];
        $description = $_POST['Description']; // New field
        $owner = $_POST['Owner'];
        $phoneNo = $_POST['Phone_No'];
        $emailId = $_POST['Email_Id'];
        $isFeatured = $_POST['is_Featured'];
        $isSold = $_POST['is_Sold'];

        $sql = "INSERT INTO buy_sell (Image1, Image2, BS_Type, BS_Sub_Type, BS_Sub_Type2, BS_For, Price, Address, Landmark, State, City, Description, Owner, Phone_No, Email_Id, is_Featured, is_Sold, Created_At) VALUES ('$path1', '$path2', '$bsType', '$bsSubType', '$bsSubType2', '$bsFor', '$price', '$address', '$landmark', '$state', '$city', '$description', '$owner', '$phoneNo', '$emailId', '$isFeatured', '$isSold', NOW())";

        if ($conn->query($sql) === TRUE) {
            echo "success";
        } else {
            echo "failed to insert into the database";
        }
    } else {
        echo "failed to upload image";
    }
} else {
    echo "image data not found";
}

$conn->close();
?>

<?php
// $servername = "localhost";
// $username = "ayaz";
// $db_password = "ayaz29292";
// $dbname = "test_ayafitech_com";

// // Create a new connection
// $conn = new mysqli($servername, $username, $db_password, $dbname);

// // Check the connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// // Check if the required fields are present in the POST data
// if (isset($_POST['image'], $_POST['image2'], $_POST['BS_Type'], $_POST['Price'], $_POST['Address'], $_POST['Landmark'], $_POST['State'], $_POST['City'], $_POST['Owner'], $_POST['Phone_No'], $_POST['Email_Id'], $_POST['is_Featured'], $_POST['is_Sold'])) {
//     // Assign the POST data to variables
//     $imageData1 = $_POST['image'];
//     $imageData2 = $_POST['image2'];
//     $bsType = $_POST['BS_Type'];
//     $price = $_POST['Price'];
//     $address = $_POST['Address'];
//     $landmark = $_POST['Landmark'];
//     $state = $_POST['State'];
//     $city = $_POST['City'];
//     $owner = $_POST['Owner'];
//     $phoneNo = $_POST['Phone_No'];
//     $emailId = $_POST['Email_Id'];
//     $isFeatured = $_POST['is_Featured'];
//     $isSold = $_POST['is_Sold'];

//     // Process the image data and insert into the database
//     $path1 = "images/" . date("d-m-y") . "-" . time() . "-" . rand(10000, 100000) . ".jpg";
//     $path2 = "images/" . date("d-m-y") . "-" . time() . "-" . rand(10000, 100000) . ".jpg";

//     if (file_put_contents($path1, base64_decode($imageData1)) && file_put_contents($path2, base64_decode($imageData2))) {
//         // Insert data into the database
//         $sql = "INSERT INTO buy_sell (Image1, Image2, BS_Type, Price, Address, Landmark, State, City, Owner, Phone_No, Email_Id, is_Featured, is_Sold, Created_At) VALUES ('$path1', '$path2', '$bsType', '$price', '$address', '$landmark', '$state', '$city', '$owner', '$phoneNo', '$emailId', '$isFeatured', '$isSold', NOW())";

//         if ($conn->query($sql) === TRUE) {
//             echo "success";
//         } else {
//             echo "Error: " . $sql . "<br>" . $conn->error;
//         }
//     } else {
//         echo "Failed to upload image";
//     }
// } else {
//     echo "Required fields are missing in POST data";
// }

// // Close the database connection
// $conn->close();
?>


