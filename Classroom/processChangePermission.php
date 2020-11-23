<?php
    if (isset($_POST['edit'])){
        $newPermission = $_POST['permission'];
        // check ID
        require_once('connection.php');
        
        $stmt = $conn->prepare("INSERT INTO baitap(TieuDe, NoiDung) VALUES (?, ?)");
        $stmt->bind_param("ss", $title, $content);
        
        if ($stmt->execute() === TRUE) {
           header("Location: Permission.php");
            
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
?>