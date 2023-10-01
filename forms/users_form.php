<?php
// Check if user_id is provided in the URL
if (isset($_GET['user_id'])) {
    $user_id_to_edit = $_GET['user_id'];

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
    $sql = "SELECT * FROM users WHERE user_id = '$user_id_to_edit'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user_data = $result->fetch_assoc();
    } else {
        echo "User not found";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "User ID not provided in the URL";
}

// Arrays for state and city options
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


// Check if the form is submitted for updating
if (isset($_POST['btn_save'])) {
    // Get data from the form
    $user_id = $_POST['user_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone_no = $_POST['phone_no'];
    $email_id = $_POST['email_id'];
    $wallet = $_POST['wallet'];
    $is_verified = isset($_POST['is_verified']) ? 1 : 0;
    $state = $_POST['prefered_state']; // Corrected column name
    $city = $_POST['prefered_city']; // Corrected column name

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

    // Update the record in the database
    $sql = "UPDATE users SET 
        first_name = '$first_name',
        last_name = '$last_name',
        phone_no = '$phone_no',
        email_id = '$email_id',
        wallet = '$wallet',
        prefered_state = '$state',
        prefered_city = '$city', 
        is_verified = '$is_verified'
        WHERE user_id = '$user_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
}
?>

<!-- HTML form to edit user data -->
<form method="post" action="">
    <input type="hidden" name="user_id" value="<?php echo $user_data['user_id']; ?>">

    <fieldset>
        <div class="form-group">
            <label for="first_name">First Name *</label>
            <input type="text" name="first_name" value="<?php echo htmlspecialchars($user_data['first_name'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="First Name" class="form-control" required="required" id="first_name">
        </div>

        <div class="form-group">
            <label for="last_name">Last name *</label>
            <input type="text" name="last_name" value="<?php echo htmlspecialchars($user_data['last_name'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Last Name" class="form-control" required="required" id="last_name">
        </div>
        
        <div class="form-group">
            <label for="phone_no">Phone</label>
            <input type="text" name="phone_no" value="<?php echo htmlspecialchars($user_data['phone_no'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Phone No" class="form-control" required="required" id="phone_no">
        </div>

        <div class="form-group">
            <label for="email_id">Email</label>
            <input type="text" name="email_id" value="<?php echo htmlspecialchars($user_data['email_id'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Email Id" class="form-control" required="required" id="email_id">
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" value="" placeholder="Password" class="form-control" required="required" id="password">
        </div>

        <div class="form-group">
            <label>Email Status *</label>
            <label class="radio-inline">
                <input type="radio" name="is_verified" value="1" <?php echo ($user_data['is_verified'] == 1) ? "checked" : ""; ?> required="required"> Verified
            </label>
            <label class="radio-inline">
                <input type="radio" name="is_verified" value="0" <?php echo ($user_data['is_verified'] == 0) ? "checked" : ""; ?> required="required"> Not Verified
            </label>
        </div>
        
        <div class="form-group">
            <label for="wallet">Wallet</label>
            <input type="text" name="wallet" value="<?php echo htmlspecialchars($user_data['wallet'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Wallet Balance" class="form-control" required="required" id="wallet">
        </div>

        <div class="form-group">
            <label>State</label>
            <select name="prefered_state" class="form-control selectpicker" id="stateSelect" required>
                <option value="">Please select your state</option>
                <?php
                foreach ($stateOptions as $stateOption) {
                    $selected = ($user_data['prefered_state'] == $stateOption) ? "selected" : "";
                    echo '<option value="' . $stateOption . '" ' . $selected . '>' . $stateOption . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label>City</label>
            <select name="prefered_city" class="form-control selectpicker" id="citySelect" required>
                <option value="">Please select your city</option>
                <?php
                $selectedState = $user_data['prefered_state'];
                if (isset($cityOptions[$selectedState])) {
                    foreach ($cityOptions[$selectedState] as $cityOption) {
                        $selected = ($user_data['prefered_city'] == $cityOption) ? "selected" : "";
                        echo '<option value="' . $cityOption . '" ' . $selected . '>' . $cityOption . '</option>';
                    }
                }
                ?>
            </select>
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
</script>
