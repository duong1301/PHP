<?php
if (isset($_GET["id"])) {
    $id = $_GET['id'];
    $studentDelStmt = "CALL proc_student_del('$id')";
    $deleteResult = mysqli_query($conn, $studentDelStmt);
    if ($deleteResult) {
        echo "success";
    }
    echo $conn->error;
}
