<?php

const subjectQueryStmt = "CALL proc_subject_getAll";
$subjects = mysqli_query($conn, subjectQueryStmt);


while (mysqli_next_result($conn)) 
if(isset($_POST["create"])){
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $subject = $_POST["subject"];   

    /**
     * to do
     * Validate
     */
    $teacherAddStatement = "CALL proc_teacher_add('$firstName','$lastName','$phone', '$email','$subject')";
    $addResult = mysqli_query($conn, $teacherAddStatement);
    if($addResult){
        echo "Success";
    }else{
        echo $conn->error;
    }


}
?>

<div class="page-title">
    <h2>Thêm giáo viên</h2>
</div>
<div>
    <div>
        <div></div>
        <form action="" method="post">
            <div class="form-group">
                <label>
                    Họ
                    <input value="<?php if(isset($_POST["lastName"])) echo $_POST["lastName"]?>" name="lastName" type="text">
                </label>
            </div>
            <div class="form-group">
                <label>
                    Tên
                    <input value="<?php if(isset($_POST["firstName"])) echo $_POST["firstName"]?>" name="firstName" type="text">
                </label>
            </div>
            <div class="form-group">
                <label>
                    Số điện thoại
                    <input value="<?php if(isset($_POST["phone"])) echo $_POST["phone"]?>" name="phone" type="tel">
                </label>
            </div>
            <div class="form-group">
                <label>
                    Email
                    <input value="<?php if(isset($_POST["email"])) echo $_POST["email"]?>" name="email" type="email">
                </label>
            </div>
            <div class="form-group">
                <label>
                    Môn giảng dạy
                    <select name="subject">
                        <?php
                        if ($subjects) {
                            while ($subject = mysqli_fetch_array($subjects)) {
                        ?>
                                <option 
                                    <?php if(isset($_POST["subject"])){
                                        if($_POST["subject"] == $subject["subjectId"]) echo "selected";
                                    } ?> 
                                    value="<?php echo $subject["subjectId"] ?>"><?php echo $subject['name'] ?>
                                </option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </label>
            </div>
            <div>
                <button class="btn" name="create">Tạo</button>
            </div>
        </form>
    </div>
</div>