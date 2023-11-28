<?php

$classQueryStmt = "CALL proc_class_getAll;";
$classes = mysqli_query($conn, $classQueryStmt);
while (mysqli_next_result($conn)) {;
}

$classId = "";
if (isset($_GET['classId'])) {
    $classId = $_GET['classId'];
}



$lastName  = "";
$firstName = "";
$dob = "";
$ethnic = "";
echo $classId;

$fatherName = "";
$fatherPhone = "";
$fatherJob = "";

$motherName = "";
$motherPhone = "";
$motherJob = "";

if (isset($_GET["id"])) {
    
    $studentId = $_GET['id'];
    $studentQueryStmt = "CALL proc_student_getById('$studentId')";
    $studentQueryResult = mysqli_query($conn, $studentQueryStmt);
    echo $conn->error;
    while (mysqli_next_result($conn)) {;
    }

    if ($studentQueryResult) {
        echo 123;
        $student = mysqli_fetch_array($studentQueryResult);
        $lastName  = $student['lastName'];
        $firstName = $student['firstName'];
        $dob = $student['dob'];
        $ethnic = $student['ethnic'];

        $fatherName = $student['fatherName'];
        $fatherPhone = $student['fatherPhone'];
        $fatherJob = $student['fatherJob'];

        $motherName = $student['motherName'];
        $motherPhone = $student['motherPhone'];
        $motherJob = $student['motherJob'];
    }
}


if (isset($_POST['save'])) {
    $lastName  = $_POST['lastName'];
    $firstName = $_POST['firstName'];
    $dob = $_POST['dob'];
    $ethnic = $_POST['ethnic'];
    echo $classId;

    $fatherName = $_POST['fatherName'];
    $fatherPhone = $_POST['fatherPhone'];
    $fatherJob = $_POST['fatherJob'];

    $motherName = $_POST['motherName'];
    $motherPhone = $_POST['motherPhone'];
    $motherJob = $_POST['motherJob'];

    /**
     * to do
     * validate
     */

    $studentAddStmt = "CALL proc_student_update('$studentId','$firstName', '$lastName','$dob','$ethnic','$fatherName','$fatherPhone','$fatherJob','$motherName', '$motherPhone', '$motherJob','$classId');";
    $addResult = mysqli_query($conn, $studentAddStmt);
    if ($addResult) {
        echo "Success";
    } else {
        echo $conn->error;
    }
}

?>

<div class="page-title">
    <h2>Thêm học sinh</h2>
</div>
<div class="page-content">
    <div>

    </div>
    <div>
        <form action="" method="post">
            <div class="form-group">
                <label>
                    Lớp
                    <select>
                        <?php
                        if ($classes) {
                            while ($class = mysqli_fetch_array($classes)) {
                        ?>
                                <option <?php if ($classId == $class["classId"]) echo "selected" ?> value="<?php echo $class['classId'] ?>">
                                    <?php echo $class['name'] ?>
                                    Niên khoá
                                    <?php echo $class['schoolYear'] ?> - <?php echo $class['schoolYearEnd'] ?>
                                </option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </label>
            </div>

            <div class="form-container">
                <div class="group">
                    <div class="form-group">
                        <label>
                            Họ
                            <input value="<?php echo $lastName ?>" name="lastName" type="text">
                            <p class="message"></p>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            Tên
                            <input value="<?php echo $firstName ?>" name="firstName" type="text">
                            <p class="message"></p>
                        </label>
                    </div>
                    <div class="form-group">

                        <label>
                            Ngày sinh
                            <input value="<?php echo $dob ?>" name="dob" type="date">
                            <p class="message"></p>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            Dân tộc
                            <input value="<?php echo $ethnic ?>" name="ethnic" type="text">
                            <p class="message"></p>
                        </label>
                    </div>

                </div>

                <div class="group">
                    <div class="form-group">
                        <label>
                            Họ tên cha
                            <input value="<?php echo $fatherName ?>" name="fatherName" type="text">
                            <p class="message"></p>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            Số điện thoại
                            <input value="<?php echo $fatherPhone ?>" name="fatherPhone" type="text">
                            <p class="message"></p>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            Nghề nghiệp
                            <input value="<?php echo $fatherJob ?>" name="fatherJob" type="text">
                            <p class="message"></p>
                        </label>

                    </div>
                </div>

                <div class="group">
                    <div class="form-group">
                        <label>
                            Họ tên mẹ
                            <input value="<?php echo $motherName ?>" name="motherName" type="text">
                            <p class="message"></p>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            Số điện thoại
                            <input value="<?php echo $motherPhone ?>" name="motherPhone" type="text">
                            <p class="message"></p>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            Nghề nghiệp
                            <input value="<?php echo $motherJob ?>" name="motherJob" type="text">
                            <p class="message"></p>
                        </label>
                    </div>
                </div>
            </div>
            <div>
                <button type="submit" class="btn" name="save">Lưu</button>
                <button type="submit" class="btn" name="clear">Xoá</button>
            </div>
        </form>
    </div>
</div>