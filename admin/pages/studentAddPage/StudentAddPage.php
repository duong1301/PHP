<?php
include("../config/connect.php");
$classId = "";

if (isset($_GET["classId"])) {
    $classId = $_GET["classId"];
}

$classQuery = "CALL proc_class_getById('$classId')";
$classQueryResult = mysqli_query($conn,$classQuery);
$class = mysqli_fetch_array($classQueryResult);
while (mysqli_next_result($conn)) {
}

$firstName = "";
$lastName = "";
$dob = "";
if (isset($_POST["create"])) {
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $dob = $_POST["dob"];
    $studentCreateQuery = "CALL proc_student_add('$firstName', '$lastName', '$classId', '$dob')";
    $studentCreateQueryResult = mysqli_query($conn,$studentCreateQuery);
    if(!$studentCreateQueryResult == true){
        echo $conn->error;
    }else{
        echo "Success";
        
    }
}

?>

<div class="page user">
    <div class="page-title">
        <h2>Thêm học sinh lớp <?php echo $class["name"] ?></h2>
    </div>

    <div class="page-content">
        <div>
            <form action="" method="post">
                <div>
                    <p>Tên</p>
                    <input type="text" name="firstName" id="">
                </div>

                <div>
                    <p>Họ</p>
                    <input type="text" name="lastName" id="">
                </div>

                <div>
                    <p>Ngày tháng năm sinh</p>
                    <input type="date" name="dob" id="">
                </div>
                <div>
                    <button class="btn" type="submit" name="create">Thêm</button>
                </div>
            </form>
        </div>

    </div>
</div>