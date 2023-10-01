<?php

$stateOptions = array(
    "Andhra Pradesh",
    "Arunachal Pradesh",
    "Assam",
    "Bihar",
    "Chhattisgarh",
    "Goa",
    "Gujarat",
    "Haryana",
    "Himachal Pradesh",
    "Jharkhand",
    "Karnataka",
    "Kerala",
    "Madhya Pradesh",
    "Maharashtra",
    "Manipur",
    "Meghalaya",
    "Mizoram",
    "Nagaland",
    "Odisha",
    "Punjab",
    "Rajasthan",
    "Sikkim",
    "Tamil Nadu",
    "Telangana",
    "Tripura",
    "Uttar Pradesh",
    "Uttarakhand",
    "West Bengal"
);
$cityOptions = array(
    "Andaman and Nicobar Islands" => array("Port Blair", "Havelock Island", "Neil Island"),
    "Andhra Pradesh" => array("Visakhapatnam", "Vijayawada", "Guntur", "Tirupati", "Nellore", "Kurnool"),
    "Arunachal Pradesh" => array("Itanagar", "Naharlagun", "Tawang", "Bomdila"),
    "Assam" => array("Guwahati", "Dibrugarh", "Silchar", "Jorhat", "Tezpur", "Nagaon"),
    "Bihar" => array("Patna", "Gaya", "Bhagalpur", "Muzaffarpur", "Darbhanga", "Purnia"),
    "Chandigarh" => array("Chandigarh"),
    "Chhattisgarh" => array("Raipur", "Bhilai", "Durg", "Bilaspur", "Korba", "Raigarh"),
    "Dadra and Nagar Haveli" => array("Silvassa"),
    "Daman and Diu" => array("Daman", "Diu"),
    "Delhi" => array("New Delhi", "Delhi Cantonment", "Noida", "Gurgaon", "Faridabad"),
    "Goa" => array("Panaji", "Margao", "Vasco da Gama", "Mapusa", "Ponda"),
    "Gujarat" => array("Ahmedabad", "Surat", "Vadodara", "Rajkot", "Bhavnagar", "Jamnagar"),
    "Haryana" => array("Faridabad", "Gurgaon", "Rohtak", "Panipat", "Karnal", "Hisar"),
    "Himachal Pradesh" => array("Shimla", "Mandi", "Dharamshala", "Kullu", "Manali", "Solan"),
    "Jammu and Kashmir" => array("Srinagar", "Jammu", "Anantnag", "Leh", "Sopore", "Kathua"),
    "Jharkhand" => array("Ranchi", "Jamshedpur", "Dhanbad", "Bokaro", "Deoghar", "Hazaribagh"),
    "Karnataka" => array("Bengaluru", "Mysuru", "Hubballi", "Mangalore", "Belgaum", "Gulbarga"),
    "Kerala" => array("Thiruvananthapuram", "Kochi", "Kozhikode", "Thrissur", "Kollam", "Palakkad"),
    "Lakshadweep" => array("Kavaratti", "Agatti"),
    "Madhya Pradesh" => array("Bhopal", "Indore", "Jabalpur", "Gwalior", "Ujjain", "Sagar"),
    "Maharashtra" => array("Mumbai", "Pune", "Nagpur", "Thane", "Nashik", "Aurangabad"),
    "Manipur" => array("Imphal", "Thoubal"),
    "Meghalaya" => array("Shillong"),
    "Mizoram" => array("Aizawl", "Lunglei"),
    "Nagaland" => array("Kohima", "Dimapur"),
    "Odisha" => array("Bhubaneswar", "Cuttack", "Rourkela", "Brahmapur", "Sambalpur", "Puri"),
    "Puducherry" => array("Puducherry"),
    "Punjab" => array("Chandigarh", "Ludhiana", "Amritsar", "Jalandhar", "Patiala", "Bathinda"),
    "Rajasthan" => array("Jaipur", "Jodhpur", "Udaipur", "Kota", "Bikaner", "Ajmer"),
    "Sikkim" => array("Gangtok", "Namchi"),
    "Tamil Nadu" => array("Chennai", "Coimbatore", "Madurai", "Tiruchirappalli", "Salem", "Vellore"),
    "Telangana" => array("Hyderabad", "Warangal", "Nizamabad", "Khammam", "Karimnagar", "Ramagundam"),
    "Tripura" => array("Agartala"),
    "Uttar Pradesh" => array("Lucknow", "Kanpur", "Varanasi", "Agra", "Prayagraj", "Ghaziabad"),
    "Uttarakhand" => array("Dehradun", "Haridwar", "Rishikesh", "Haldwani", "Roorkee", "Kashipur"),
    "West Bengal" => array("Kolkata", "Howrah", "Durgapur", "Asansol", "Siliguri", "Bardhaman")
);


$CategoryOptions = array(
    "FLAT",
    "ROW_HOUSE",
    "BUNGLOW",
    "PLOT"
);

$TypeOptions = array(
    "FLAT" => array("BHK", "BK", "K"),
    "ROW_HOUSE" => array("WITH_PARKING", "NO_PARKING"),
    "BUNGLOW" => array("BUNGLOW"),
    "PLOT" => array("PARTY", "PRIVATE", "PUBLIC", "NORMAL"),
);

$ForOptions = array(
    "SELL",
    "RENT"
);

if (isset($_POST['btn_save'])) {
    $City = $_POST['City'];
    $State = $_POST['State'];
    $category = $_POST['BS_Type'];
    $rooms = $_POST['BS_Sub_Type'];
    $property_type = $_POST['BS_Sub_Type2'];
    $property_for = $_POST['BS_For'];
    $is_sold = $_POST['is_Sold'];
    $is_featured = $_POST['is_Featured'];
    $address = $_POST['Address'];
    $description = $_POST['Description'];
    $owner_name = $_POST['Owner'];
    $owner_phone = $_POST['Phone_No'];
    $owner_email = $_POST['Email_Id'];
    $price = $_POST['Price'];
    $landmark = $_POST['Landmark'];

    // Handle image uploads
    $image1_name = '';
    if ($_FILES['Image1']['error'] === UPLOAD_ERR_OK) {
        $image1_name = 'image' . uniqid() . '.jpg'; // Generate a unique name
        $image1_path = './api/images/' . $image1_name;
        move_uploaded_file($_FILES['Image1']['tmp_name'], $image1_path);
    }

    $image2_name = '';
    if ($_FILES['Image2']['error'] === UPLOAD_ERR_OK) {
        $image2_name = 'image' . uniqid() . '.jpg'; // Generate a unique name
        $image2_path = './api/images/' . $image2_name;
        move_uploaded_file($_FILES['Image2']['tmp_name'], $image2_path);
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
    
    $initials_1 = "images/".$image1_name;
    $initials_2 = "images/".$image2_name;

    // Insert the record into the database
    $sql = "INSERT INTO buy_sell (Image1, Image2, BS_Type, BS_Sub_Type, BS_Sub_Type2, BS_For, is_Sold, is_Featured, State, City, landmark, Price, Address, Description, Email_Id, Phone_No, Owner,created_at) 
            VALUES ('$initials_1', '$initials_2', '$category', '$rooms', '$property_type', '$property_for', '$is_sold', '$is_featured', '$State', '$City', '$landmark', '$price', '$address', '$description', '$owner_email', '$owner_phone', '$owner_name', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo "Record inserted successfully";
    } else {
        echo "Error inserting record: " . $conn->error;
    }

    $conn->close();
}
?>
<form method="post" action="" enctype="multipart/form-data">
    <!--<input type="hidden" name="id" value="<?php 
    // echo $home_data['id'];
    ?>">-->

    <fieldset>
        <div class="form-group">
            <label for="Image1">Property Image 1</label>
            <input type="file" name="Image1" value="" placeholder="Select 1st Image" class="form-control" required="required" id="Image1">
        </div>
        <div>
             <label for="Image1">Property Image 2</label>
            <input type="file" name="Image2" value="" placeholder="Select 2nd Image" class="form-control" required="required" id="Image2">
        </div><br>
        <div class="form-group">
    <label>Property Category</label>
    <select name="BS_Type" class="form-control selectpicker" id="BS_Type" required>
        <option value="">Please select a category</option>
        <?php
        foreach ($CategoryOptions as $CategoryOption) {
            $selected = ($home_data['BS_Type'] == $CategoryOption) ? "selected" : "";
            echo '<option value="' . $CategoryOption . '" ' . $selected . '>' . $CategoryOption . '</option>';
        }
        ?>
    </select>
</div>

        <div class="form-group">
            <label for="BS_Sub_Type">No of Rooms</label>
            <input type="text" name="BS_Sub_Type" value="" placeholder="Number of Rooms" class="form-control" required="required" id="BS_Sub_Type">
        </div>

        <div class="form-group">
    <label>Property Type</label>
    <select name="BS_Sub_Type2" class="form-control selectpicker" id="BS_Sub_Type2" required>
        <option value="">Please select your home type</option>
        <?php
        if (isset($_POST['BS_Type'])) {
            $selectedCategory = $_POST['BS_Type'];
            if (isset($TypeOptions[$selectedCategory])) {
                foreach ($TypeOptions[$selectedCategory] as $typeOption) {
                    echo '<option value="' . $typeOption . '">' . $typeOption . '</option>';
                }
            }
        }
        ?>
    </select>
        </div>


        <div class="form-group">
            <label>Property For</label>
            <select name="BS_For" class="form-control selectpicker" id="BS_For" required>
                <option value="">Please select your property for</option>
                <?php
                foreach ($ForOptions as $ForOption) {
                    $selected = ($home_data['BS_Sub_Type2'] == $ForOption) ? "selected" : "";
                    echo '<option value="' . $ForOption . '" ' . $selected . '>' . $ForOption . '</option>';
                }
                ?>
            </select>
        </div>
        
         
        <div class="form-group">
            <label for="Price">Price</label>
            <input type="text" name="Price" value="" placeholder="Price" class="form-control" required="required" id="Price">
        </div>

        <div class="form-group">
            <label>Property Status *</label>
            <label class="radio-inline">
                <input type="radio" name="is_Sold" value="1" required="required"> Sold or Leased
            </label>
            <label class="radio-inline">
                <input type="radio" name="is_Sold" value="0" required="required"> Available
            </label>
        </div>
        
        <div class="form-group">
            <label>Property Featured Status *</label>
            <label class="radio-inline">
                <input type="radio" name="is_Featured" value="1" required="required"> Sold or Leased
            </label>
            <label class="radio-inline">
                <input type="radio" name="is_Featured" value="0" required="required"> Available
            </label>
        </div>

        <div class="form-group">
            <label>State</label>
            <select name="State" class="form-control selectpicker" id="stateSelect" required>
                <option value="">Please select your state</option>
                <?php
                foreach ($stateOptions as $stateOption) {
                    $selected = ($home_data['State'] == $stateOption) ? "selected" : "";
                    echo '<option value="' . $stateOption . '" ' . $selected . '>' . $stateOption . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label>City</label>
            <select name="City" class="form-control selectpicker" id="citySelect" required>
                <option value="">Please select your city</option>
                <?php
                $selectedState = $home_data['State'];
                if (isset($cityOptions[$selectedState])) {
                    foreach ($cityOptions[$selectedState] as $cityOption) {
                        $selected = ($home_data['City'] == $cityOption) ? "selected" : "select option";
                        echo '<option value="' . $cityOption . '" ' . $selected . '>' . $cityOption . '</option>';
                    }
                }
                ?>
            </select>
        </div>
        
         
        <div class="form-group">
            <label for="Landmark">Landmark</label>
            <input type="text" name="Landmark" value="" placeholder="Landmark Name" class="form-control" required="required" id="Landmark">
        </div>
        
        <div class="form-group">
            <label for="Address">Property Address</label>
            <textarea name="Address" placeholder="Address" rows="5" class="form-control" required="required" id="Address"></textarea>
        </div>
        <div class="form-group">
            <label for="Description">Description</label>
            <textarea name="Description" placeholder="Description" rows="5" class="form-control" required="required" id="Description"></textarea>
        </div>
        
        <div class="form-group">
            <label for="Owner">Owner Name</label>
            <input type="text" name="Owner" value="" placeholder="Owner Name" class="form-control" required="required" id="Owner">
        </div>
        
        <div class="form-group">
            <label for="Phone_No">Owner Phone</label>
            <input type="text" name="Phone_No" value="" placeholder="Owner Phone" class="form-control" required="required" id="Phone_No">
        </div>
        
        <div class="form-group">
            <label for="Email_Id">Owner Email</label>
            <input type="text" name="Email_Id" value="" placeholder="Owner Email" class="form-control" required="required" id="Email_Id">
        </div>
        
        <div class="form-group text-center">
            <button type="submit" class="btn btn-warning" id="btn_save" name="btn_save">Save Changes</button>
        </div>
        
    </fieldset>
</form>

<script>
    // JavaScript to show/hide city options based on selected state
    const stateSelect = document.getElementById('stateSelect');
    const citySelect = document.getElementById('citySelect');

    // Define city options for each state
    const cityOptionsMap = <?php echo json_encode($cityOptions); ?>;

    // Function to update city options based on selected state
    function updateCityOptions() {
        const selectedState = stateSelect.value;
        const cityOptions = cityOptionsMap[selectedState] || [];
        
        // Clear existing city options
        citySelect.innerHTML = '';

        // Add new city options
        cityOptions.forEach(cityOption => {
            const option = document.createElement('option');
            option.value = cityOption;
            option.textContent = cityOption;
            citySelect.appendChild(option);
        });
    }

    // Add event listener to state select element
    stateSelect.addEventListener('change', updateCityOptions);

    // Call the function initially to set the initial city options
    updateCityOptions();
    
    // JavaScript to dynamically populate type dropdown based on category selection
    const categorySelect = document.getElementById('BS_Type');
    const typeSelect = document.getElementById('BS_Sub_Type2');

    // Define type options for each category
    const typeOptionsMap = <?php echo json_encode($TypeOptions); ?>;

    // Function to update type options based on selected category
    function updateTypeOptions() {
        const selectedCategory = categorySelect.value;
        const typeOptions = typeOptionsMap[selectedCategory] || [];

        // Clear existing type options
        typeSelect.innerHTML = '<option value="">Please select your home type</option>';

        // Add new type options
        typeOptions.forEach(typeOption => {
            const option = document.createElement('option');
            option.value = typeOption;
            option.textContent = typeOption;
            typeSelect.appendChild(option);
        });
    }

    categorySelect.addEventListener('change', updateTypeOptions);

    updateTypeOptions();
</script>
