<!DOCTYPE html>
<html>
<head>
    <title>News Editor</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
</head>
<style>
    body {
        background-color: #f2f2f2;
        font-family: Arial, sans-serif;
    }
    .container {
        margin-top: 30px;
    }
    .box {
        width: 100%;
        max-width: 600px;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 20px;
        margin: 0 auto;
    }
    h3 {
        text-align: center;
    }
    .form-group {
        margin-bottom: 20px;
    }
    label {
        font-weight: bold;
    }
    /* Increase the height of the content textarea */
    .form-control.tall-textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        height: 400px; /* Increase this value for a taller textarea */
    }
    .btn-primary {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
    }
    .btn-primary:hover {
        background-color: #0056b3;
    }
    .error {
        color: red;
    }
    .ck-editor__editable[role="textbox"] {
        /* editing area */
        min-height: 300px;
    }
</style>
<body>
 
 <?php 
$server = "localhost";
$username = "ayaz";
$password = "ayaz29292";
$database = "test_ayafitech_com";
$connection = mysqli_connect("$server","$username","$password");
$select_db = mysqli_select_db($connection, $database);
if(!$select_db)
{
	echo("connection terminated");
}
if(isset($_POST['submit'])) // Use POST method to submit the form
{
    $title = $_POST['title']; // Retrieve title from the form
    $content = $_POST['content']; // Retrieve content from the form

    // Check if both title and content are not empty
    if (!empty($title) && !empty($content)) {
        // Additional fields
        $writer_id = $_POST['writer_id'];
        $writer_name = $_POST['writer_name'];
        $writer_email = $_POST['writer_email'];
        $writer_phone = $_POST['writer_phone'];
        $content_region_state = $_POST['content_region_state'];
        $content_region_city = $_POST['content_region_city'];

        // Get the current date and time
        $current_datetime = date("Y-m-d H:i:s");

        // Insert data into the 'news' table with the current date and time
        $insert_query = "INSERT INTO news (title, content, writer_id, writer_name, writer_email, writer_phone, content_region_state, content_region_city, created_at) VALUES ('$title', '$content', '$writer_id', '$writer_name', '$writer_email', '$writer_phone', '$content_region_state', '$content_region_city', '$current_datetime')";
        
        $insert_result = mysqli_query($connection, $insert_query);

        if($insert_result)
        {
            $msg = "Data Inserted";
        }
        else
        {
            $msg = "Error: " . mysqli_error($connection);
        }
    } else {
        $msg = "Title and Content fields cannot be empty.";
    }
}
?>
<div class="container">
    <h3>News Editor</h3>
    <div class="box">
        <form method="post">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" class="form-control">
            </div>
            <div class="form-group">
                <label for="content">Content:</label>
                <textarea id="content" name="content" class="form-control tall-textarea" rows="10"></textarea>
            </div>
            <!-- Additional fields -->
            <div class="form-group">
                <label for="writer_id">Writer ID:</label>
                <input type="text" id="writer_id" name="writer_id" class="form-control">
            </div>
            <div class="form-group">
                <label for="writer_name">Writer Name:</label>
                <input type="text" id="writer_name" name="writer_name" class="form-control">
            </div>
            <div class="form-group">
                <label for="writer_email">Writer Email:</label>
                <input type="text" id="writer_email" name="writer_email" class="form-control">
            </div>
            <div class="form-group">
                <label for="writer_phone">Writer Phone:</label>
                <input type="text" id="writer_phone" name="writer_phone" class="form-control">
            </div>
            <div class="form-group">
                <label for="content_region_state">Content Region State:</label>
                <input type="text" id="content_region_state" name="content_region_state" class="form-control">
            </div>
            <div class="form-group">
                <label for="content_region_city">Content Region City:</label>
                <input type="text" id="content_region_city" name="content_region_city" class="form-control">
            </div>
            <!-- End of additional fields -->
            <div class="form-group">
                <input type="submit" name="submit" value="Save" class="btn btn-primary">
            </div>
        </form>
        <div class="error"><?php if(!empty($msg)){ echo $msg; } ?></div>
    </div>
</div>
</body>
</html>
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#content' ))
        .catch( error => {
            console.error( error );
        });
    // ClassicEditor
    //     .create( document.querySelector( '#content' ), {
    //         plugins: [ 'Image' ], // Enable the Image plugin
    //         toolbar: [ 'imageUpload', '|', 'undo', 'redo' ] // Add the 'imageUpload' button to the toolbar
    //     } )
    //     .catch( error => {
    //         console.error( error );
    //     });
</script>
