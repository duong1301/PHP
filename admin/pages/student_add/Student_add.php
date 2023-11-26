<?php
$classQueryStmt = "CALL proc_class_getAll;";
$classes = mysqli_query($conn, $classQueryStmt);
while (mysqli_next_result($conn)) {;
}

$classId = "";
if (isset($_GET['classId'])) {
    $classId = $_GET['classId'];
}
if (isset($_POST['create'])) {
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

    $studentAddStmt = "CALL proc_student_add(
        '$firstName', '$lastName', '$ethnic','$classId','$dob','$fatherName','$fatherPhone','$fatherJob',
        '$motherName', '$motherPhone', '$motherJob'
    )";
    $addResult = mysqli_query($conn, $studentAddStmt);
    if ($addResult) {
        echo "Success";
    } else {
        echo $conn->error;
    }
}

//fake data
if (isset($_POST['fakeData'])) {
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

    $studentAddStmt = "CALL proc_student_add_fakeScore(
        '$firstName', '$lastName', '$ethnic','$classId','$dob','$fatherName','$fatherPhone','$fatherJob',
        '$motherName', '$motherPhone', '$motherJob'
    )";
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
                                <option <?php if($classId == $class["classId"]) echo "selected"?> value="<?php echo $class['classId'] ?>">
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
                            <input name="lastName" type="text">
                            <p class="message"></p>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            Tên
                            <input name="firstName" type="text">
                            <p class="message"></p>
                        </label>
                    </div>
                    <div class="form-group">

                        <label>
                            Ngày sinh
                            <input name="dob" type="date">
                            <p class="message"></p>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            Dân tộc
                            <input name="ethnic" type="text">
                            <p class="message"></p>
                        </label>
                    </div>

                </div>

                <div class="group">
                    <div class="form-group">
                        <label>
                            Họ tên cha
                            <input name="fatherName" type="text">
                            <p class="message"></p>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            Số điện thoại
                            <input name="fatherPhone" type="text">
                            <p class="message"></p>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            Nghề nghiệp
                            <input name="fatherJob" type="text">
                            <p class="message"></p>
                        </label>

                    </div>
                </div>

                <div class="group">
                    <div class="form-group">
                        <label>
                            Họ tên mẹ
                            <input name="motherName" type="text">
                            <p class="message"></p>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            Số điện thoại
                            <input name="motherPhone" type="text">
                            <p class="message"></p>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            Nghề nghiệp
                            <input name="motherJob" type="text">
                            <p class="message"></p>
                        </label>
                    </div>
                </div>
            </div>
            <div>
                <button type="submit" class="btn" name="create">Thêm</button>
                <button type="submit" class="btn" name="clear">Xoá</button>
                <button type="submit" class="btn" name="fakeData">Thêm(fake score)</button>
            </div>
        </form>
    </div>
</div>