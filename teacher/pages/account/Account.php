<?php
include('common/emailValidation.php');
include('common/phoneValidation.php');


$id = $_SESSION["teacher"]["teacherId"];

$userQueryStmt = "CALL proc_teacher_getById('$id')";
$userQueryResult = mysqli_query($conn, $userQueryStmt);
$teacher = mysqli_fetch_array($userQueryResult);
while (mysqli_next_result($conn)) {;
};
$name = "";
$username = "";
$email = "";
$password = "";
$passwordConfirm = "";
$level = "";
$message = "";
const success = "success";
const error = "error";

if (mysqli_num_rows($userQueryResult) != 0) {
    $firstName = $teacher["firstName"];
    $lastName = $teacher["lastName"];
    $_SESSION['user']['name'] = $name;
    $email = $teacher["email"];
    $phone = $teacher["phone"];
}

if (isset($_POST["updateInfor"])) {
    $firstName = trim($_POST["firstName"], " ");
    $lastName = trim($_POST["lastName"], " ");
    $firstNameErr = "";$lastNameErr = "";
    $email = trim($_POST["email"], " ");
    $phone = trim($_POST["phone"], " ");
    $emailErr = "";
    $phoneErr = "";

    //to do: validate
    //name
    if (empty($firstName)) {
        $firstNameErr = "Không được để trống";
    }
    //username
    if (empty($lastName)) {
        $lastNameErr = "Không được để trống";
    }
    //email
    if (empty($email)) {
        $emailErr = "Không được để trống";
    } else {
        $emailErr = validate_email($email);
    }
    //phone
    if(empty($phone)){
        $phoneErr = "Không được để trống";
    }else{
        $phoneErr = validate_phone($phone);
    }
    //
    if (
        empty($firstNameErr) &&
        empty($lastNameErr) &&
        empty($phoneNameErr) &&
        empty($emailErr)
    ) {
        $addUserStmt = "CALL proc_teacher_update('$id','$lastName','$firstName','$phone','$email');";
        $addUserResult = mysqli_query($conn, $addUserStmt);
        if ($addUserResult) {
            $state = success;
            $_SESSION['user']['name'] = $name;
            // header("Location: ./index.php?page=account");
            echo 12;
        } else {
            echo $conn->error;
        }
    }
}

if (isset($_POST["updatePassword"])) {
    $oldPassword = trim($_POST["oldPassword"], " ");
    $oldPasswordErr = "";
    $password = trim($_POST["password"], " ");
    $passwordErr = "";
    $passwordConfirm = trim($_POST["passwordConfirm"], " ");
    $passwordConfirmErr = "";

    //to do: validate
    //oldPassword
    if (empty($oldPassword)) {
        $oldPasswordErr = "Không được để trống";
    }
   
    //password
    if (empty($password)) {
        $passwordErr = "Không được để trống";
    }elseif($password == $oldPassword){
        $passwordErr = "Mật khẩu mới phải khác mật khẩu cũ";
    }
    //passwordConfirm
    if (empty($passwordConfirm)) {
        $passwordConfirmErr = "Không được để trống";
    }else
    if (strcmp($password, $passwordConfirm) != 0) {
        $passwordConfirmErr = "Mật khẩu không trùng khớp";
    }

    if (
        empty($nameErr) &&
        empty($usernameErr) &&
        empty($emailErr) &&
        empty($passwordErr) &&
        empty($passwordConfirmErr)
    ){
        echo "update password";
        $updateUserPasswordStmt = "CALL proc_teacher_updatePassword('$id','$password','$oldPassword');";
        $updateUserPasswordResult = mysqli_query($conn, $updateUserPasswordStmt);
        if(mysqli_affected_rows($conn) == 0){
            echo "Cập nhật thất bại, mật khẩu cũ không đúng";
        }elseif ($updateUserPasswordResult) {
            $state = success;   
                
            header("Location: ./logout.php");
        }else{
            echo $conn->error;
        }
    }
    
}




?>

<div class="page-title">
    <h2>Tài khoản</h2>
</div>

<div class="page-content">
    <div class="message-container">
        <div class="toast <?php echo $state ?>">
            <p>
                <?php if ($message != "") echo $message ?>
            </p>

        </div>
    </div>
    <style>
        .flex {
            display: flex;
            column-gap: 24px;
        }
    </style>
    <div class="flex">
        <div>
            Thông tin cá nhân
            <form action="" method="post">
                <div class="form group">
                    <label>
                        Họ
                        <input name="lastName" value="<?php if (isset($lastName)) echo $lastName ?>" type="text">
                    </label>
                    <p class="message">
                        <?php if (isset($lastNameErr)) echo $lastNameErr ?>
                    </p>
                </div>

                <div class="form group">
                    <label>
                        Tên
                        <input name="firstName" value="<?php if (isset($firstName)) echo $firstName ?>" type="text">
                    </label>
                    <p class="message">
                        <?php if (isset($firstNameErr)) echo $firstNameErr ?>
                    </p>
                </div>

                <div class="form group">
                    <label>
                        phone
                        <input name="phone" value="<?php if (isset($phone)) echo $phone ?>" type="text">
                    </label>
                    <p class="message">
                        <?php if (isset($phoneErr)) echo $phoneErr ?>
                    </p>
                </div>

                <div class="form group">
                    <label>
                        Email
                        <input name="email" value="<?php if (isset($email)) echo $email ?>" type="text">
                    </label>
                    <p class="message">
                        <?php if (isset($emailErr)) echo $emailErr ?>
                    </p>
                </div>

                <button type="submit" name="updateInfor" class="btn">Lưu thay đổi</button>
                <button type="submit" name="clear" class="btn">Huỷ</button>
            </form>
        </div>

        <div>
            Đổi mật khẩu
            <form action="" method="post">

                <div class="form group">
                    <label>
                        Nhập khẩu cũ
                        <input value="<?php if (isset($oldPassword)) echo $oldPassword ?>" name="oldPassword" type="password">
                    </label>
                    <p class="message">
                        <?php if (isset($oldPasswordErr)) echo $oldPasswordErr ?>
                    </p>
                </div>
                <div class="form group">
                    <label>
                        Nhập khẩu mới
                        <input value="<?php if (isset($password)) echo $password ?>" name="password" type="password">
                    </label>
                    <p class="message">
                        <?php if (isset($passwordErr)) echo $passwordErr ?>
                    </p>
                </div>

                <div class="form group">
                    <label>
                        Nhập lại mật khẩu
                        <input value="<?php if (isset($passwordConfirm)) echo $passwordConfirm ?>" name="passwordConfirm" type="password">
                    </label>
                    <p class="message">
                        <?php if (isset($passwordConfirmErr)) echo $passwordConfirmErr ?>
                    </p>
                </div>

                <button type="submit" name="updatePassword" class="btn">Lưu thay đổi</button>
                <button type="submit" name="clear" class="btn">Huỷ</button>
            </form>
        </div>
    </div>

</div>