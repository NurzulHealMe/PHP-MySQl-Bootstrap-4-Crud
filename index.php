<?php
//make connection to mysql server
$conn = new mysqli('127.0.0.1', 'root', 'rootroot', 'bs4crud');

//create user
if (isset($_POST['new_user'])) {
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];

    $sql_insert = "INSERT INTO users (user_name,user_email) VALUES ('$user_name', '$user_email')";

    if ($conn->query($sql_insert) === TRUE) {
        header('location:index.php');
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
    $conn->close();
}

//read
$sql_select = "SELECT * FROM users";
$result = $conn->query($sql_select);


//update

if (isset($_POST['edit_user'])){
    $user_id = $_POST['e_user_id'];
    $user_name = $_POST['e_user_name'];
    $user_email = $_POST['e_user_email'];

    $sql_update = "UPDATE users SET user_name='$user_name',user_email='$user_email' WHERE user_id='$user_id'";
    if ($conn->query($sql_update) === TRUE) {
        header('location:index.php');
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
    $conn->close();
}

//delete/ destroy

if (isset($_POST['delete_user'])){
    $user_id = $_POST['d_user_id'];
    $sql_delete = "DELETE FROM users WHERE user_id = '$user_id'";
    if ($conn->query($sql_delete) === TRUE) {
        header('location:index.php');
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap 4 Website Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="jumbotron text-center" style="margin-bottom:0">
    <h1>Bootstrap 4 CRUD , PHP & MYSQL</h1>

</div>

<div class="container" style="margin-top:30px">

    <!-- Button to Open the Modal -->
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#newUser">New User</button>
    <br>
    <br>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th width="20%">--</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['user_name'] . "</td>";
                echo "<td>" . $row['user_email'] . "</td>";
                echo "<td><button class='btn-sm btn-warning' data-toggle=\"modal\" data-target=\"#editUser\" data-user_id='" . $row['user_id'] . "' data-user_name='" . $row['user_name'] . "' data-user_email='" . $row['user_email'] . "'>Edit</button>";
                echo "&nbsp;&nbsp;<button class='btn-sm btn-danger' data-toggle=\"modal\" data-target=\"#deleteUser\" data-user_id='" . $row['user_id'] . "' data-user_name='" . $row['user_name'] . "'>Delete</button></td>";
                echo "</tr>";
            }
        }
        ?>
        </tbody>
    </table>

    <!-- The Modal -->
    <div class="modal" id="newUser">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add New User</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <form method="post" action="index.php">


                    <div class="modal-body">
                        Name:
                        <input type="text" name="user_name" class="form-control" required="required"><br>
                        Email:
                        <input type="email" name="user_email" class="form-control" required="required"><br>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success" name="new_user" value="Save">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- The Modal -->
    <div class="modal" id="editUser">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit User Information</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <form method="post" action="index.php">


                    <div class="modal-body">
                        Name:
                        <input type="text" name="e_user_name" class="form-control" required="required"><br>
                        Email:
                        <input type="email" name="e_user_email" class="form-control" required="required"><br>
                    </div>
                    <input name="e_user_id" type="hidden">
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success" name="edit_user" value="Save">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- delete Modal -->
    <div class="modal" id="deleteUser">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Are You Sure To Delete <br>
                    <span class="text text-danger" id="nameToDel"></span>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <form method="post" action="index.php">



                    <input name="d_user_id" type="hidden">
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success" name="delete_user" value="Delete">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</div>
</body>
</html>

<script>
    //triggered when modal is about to be shown
    $('#editUser').on('show.bs.modal', function (e) {

        //get data-id attribute of the clicked element
        var userId = $(e.relatedTarget).data('user_id');

        $(e.currentTarget).find('input[name="e_user_id"]').val(userId);


        var userName = $(e.relatedTarget).data('user_name');
        $(e.currentTarget).find('input[name="e_user_name"]').val(userName);

        var userEmail = $(e.relatedTarget).data('user_email');
        $(e.currentTarget).find('input[name="e_user_email"]').val(userEmail);

    });

    $('#deleteUser').on('show.bs.modal', function (e) {

        //get data-id attribute of the clicked element
        var userId = $(e.relatedTarget).data('user_id');

        $(e.currentTarget).find('input[name="d_user_id"]').val(userId);


        var userName = $(e.relatedTarget).data('user_name');
      $("#nameToDel").text(userName);


    });
</script>
