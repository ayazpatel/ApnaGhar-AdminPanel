<?php
if (isset($_POST['btn_save'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone_no = $_POST['phone_no'];
    $email_id = $_POST['email_id'];
    $raw_password = $_POST['password'];
    $wallet = $_POST['wallet'];
    $is_verified = isset($_POST['is_verified']) ? 1 : 0;
    $state = $_POST['prefered_state'];
    $city = $_POST['prefered_city'];
    
    $hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);

    $servername = "localhost";
    $username = "ayaz";
    $password = "ayaz29292";
    $dbname = "test_ayafitech_com";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO users (first_name, last_name, phone_no, email_id,password,verification_token, wallet, prefered_state, prefered_city, is_verified,created_at) 
            VALUES ('$first_name', '$last_name', '$phone_no', '$email_id', '$hashed_password', 'Created By Admin','$wallet', '$state', '$city', '$is_verified',NOW())";

    if ($conn->query($sql) === TRUE) {
        echo "Record inserted successfully";
    } else {
        echo "Error inserting record: " . $conn->error;
    }

    $conn->close();
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

?>

<!-- HTML form to edit user data -->
<form method="post" action="">

    <fieldset>
        <div class="form-group">
            <label for="first_name">First Name *</label>
            <input type="text" name="first_name" value="" placeholder="First Name" class="form-control" required="required" id="first_name">
        </div>

        <div class="form-group">
            <label for="last_name">Last name *</label>
            <input type="text" name="last_name" value="" placeholder="Last Name" class="form-control" required="required" id="last_name">
        </div>
        
        <div class="form-group">
            <label for="phone_no">Phone</label>
            <input type="text" name="phone_no" value="" placeholder="Phone No" class="form-control" required="required" id="phone_no">
        </div>

        <div class="form-group">
            <label for="email_id">Email</label>
            <input type="text" name="email_id" value="" placeholder="Email Id" class="form-control" required="required" id="email_id">
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" value="" placeholder="Password" class="form-control" required="required" id="password">
        </div>

        <div class="form-group">
            <label>Email Status *</label>
            <label class="radio-inline">
                <input type="radio" name="is_verified" value="1" required="required"> Verified
            </label>
            <label class="radio-inline">
                <input type="radio" name="is_verified" value="0" required="required"> Not Verified
            </label>
        </div>
        
        <div class="form-group">
            <label for="wallet">Wallet</label>
            <input type="text" name="wallet" value="" placeholder="Wallet Balance" class="form-control" required="required" id="wallet">
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

