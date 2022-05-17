<div class="container">
    <h1 class="text-center mt20">Delete Table Row using Sweetalert2</h1>
    <div class="row justify-content-center">
        <div class="col-sm-8">
            <table class="table table-bordered mt20">
                <thead>
                <th>ID</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Address</th>
                <th>Action</th>
                </thead>
                <tbody id="tbody">
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php
//connection
$conn = new mysqli('localhost', 'root', '', 'mydatabase');

$action = 'fetch';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

if ($action == 'fetch') {
    $output = '';
    $sql = "SELECT * FROM members";
    $query = $conn->query($sql);
    while ($row = $query->fetch_assoc()) {
        $output .= "
				<tr>
					<td>" . $row['id'] . "</td>
					<td>" . $row['firstname'] . "</td>
					<td>" . $row['lastname'] . "</td>
					<td>" . $row['address'] . "</td>
					<td><button class='btn btn-sm btn-danger delete_product' data-id='" . $row['id'] . "'>Delete</button></td>
				</tr>
			";
    }

    echo json_encode($output);
}

if ($action == 'delete') {
    $id = $_POST['id'];
    $output = array();
    $sql = "DELETE FROM members WHERE id = '$id'";
    if ($conn->query($sql)) {
        $output['status'] = 'success';
        $output['message'] = 'Member deleted successfully';
    } else {
        $output['status'] = 'error';
        $output['message'] = 'Something went wrong in deleting the member';
    }

    echo json_encode($output);
}
?>