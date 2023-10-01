<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vertical Table with Bootstrap</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <table class="table table-striped">
            <tbody>
                <tr>
                    <th scope="row" width="10%">OneSignal App ID</th>
                    <td><?php echo "ab"; ?></td>
                </tr>
                <tr>
                    <th scope="row" width="10%">OneSignal API Key</th>
                    <td><?php echo "abc"; ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Include Bootstrap JS and jQuery (for Bootstrap functionality) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
