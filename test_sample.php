<?php 
// Include configuration file 
require_once './includes/init.php';
 
$status = $statusMsg = ''; 
if(!empty($_SESSION['status_response'])){ 
    $status_response = $_SESSION['status_response']; 
    $status = $status_response['status']; 
    $statusMsg = $status_response['status_msg']; 
     
    unset($_SESSION['status_response']); 
} 
?>

<!-- Status message -->
<?php if(!empty($statusMsg)){ ?>
    <div class="alert alert-<?php echo $status; ?>"><?php echo $statusMsg; ?></div>
<?php } ?>

<div class="col-md-12">
    <form method="post" action="test_sample.php" class="form" enctype="multipart/form-data">
        <div class="form-group">
            <label>File</label>
            <input type="file" name="file" class="form-control">
        </div>
        <div class="form-group">
            <input type="submit" class="form-control btn-primary" name="submit" value="Upload"/>
        </div>
    </form>
</div>
    
<?php
 
$statusMsg = $valErr = '';
 
// If the form is submitted 
if(isset($_POST['submit'])){ 
     
    // Validate form input fields 
    if(empty($_FILES["file"]["name"])){ 
        $valErr .= 'Please select a file to upload.<br/>'; 
    } 
     
    // Check whether user inputs are empty 
    if(empty($valErr)){ 
        $targetDir = "uploads/"; 
        $fileName = basename($_FILES["file"]["name"]); 
        $targetFilePath = $targetDir . $fileName; 
         
        // Upload file to local server 
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){ 
             
            // Insert data into the database 
            $sqlQ = "INSERT INTO drive_files (file_name,created) VALUES (?,NOW())"; 
            $stmt = $db->prepare($sqlQ); 
            $stmt->bind_param("s", $db_file_name); 
            $db_file_name = $fileName; 
            $insert = $stmt->execute(); 
             
            if($insert){ 
                $file_id = $stmt->insert_id; 
                 
                // Store DB reference ID of file in SESSION 
                $_SESSION['last_file_id'] = $file_id; 
                 
                header("Location: $googleOauthURL"); 
                //redirect_to_root("google_drive_sync.php");
                exit(); 
            }else{ 
                $statusMsg = 'Something went wrong, please try again after some time.'; 
            } 
        }else{ 
            $statusMsg = 'File upload failed, please try again after some time.'; 
        } 
    }else{ 
        $statusMsg = '<p>Please fill all the mandatory fields:</p>'.trim($valErr, '<br/>'); 
    } 
}else{ 
    $statusMsg = 'Form submission failed!'; 
} 
 
$_SESSION['status_response'] = array('status' => $status, 'status_msg' => $statusMsg); 
?>