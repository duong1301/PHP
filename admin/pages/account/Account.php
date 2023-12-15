<?php
include('common/emailValidation.php');

$id = $_SESSION["user"]["userId"];
$userQueryStmt = "CALL proc_user_getById('$id')";
$userQueryResult = mysqli_query($conn, $userQueryStmt);
$user = mysqli_fetch_array($userQueryResult);
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
    $name = $user["name"];
    $_SESSION['user']['name'] = $name;
    $_SESSION['user']['avata'] = $user['avata'];
    $avata = $user['avata'];
    $username = $user["username"];
    $email = $user["email"];
}

if (isset($_POST["updateInfor"])) {
    $name = trim($_POST["name"], " ");
    $nameErr = "";
    $username = trim($_POST["username"], " ");
    $usernameErr = "";
    $email = trim($_POST["email"], " ");
    $emailErr = "";
    $avataErr = "";    
    if(isset($_FILES["avata"])){
        $maxSizeFileUpload = 5;
        $file = $_FILES["avata"];
        $fileName = $file["name"];
        $explodeResult = explode(".",$fileName);
        $ext = end($explodeResult);
        $size = $file["size"]/1024/1024;
        $allowedFile = ["jpg","jpeg","png"];
        print_r($file);
        
        if($file["error"] == 0)
        if($size > $maxSizeFileUpload){
            $avataErr = "Vui lòng chọn file dung lượng < 5MB";
        }else
        if(!in_array($ext,$allowedFile)){
            $avataErr = "Vui lòng chọn định dạng .png hoặc .jpg";
        }else
        if($file["error"] == 0){
            $newName = $id.".".$ext;
            $avata = $newName;
        }
    }

    //to do: validate
    //name
    if (empty($name)) {
        $nameErr = "Không được để trống";
    }
    //username
    if (empty($username)) {
        $usernameErr = "Không được để trống";
    }
    //email
    if (empty($email)) {
        $emailErr = "Không được để trống";
    } else {
        $emailErr = validate_email($email);
    }
    //
    if (
        empty($avataErr) &&
        empty($nameErr) &&
        empty($usernameErr) &&
        empty($emailErr)
    ) {
        $addUserStmt = "CALL proc_user_update('$id','$name','$username','$email',NULL,'$level');";
        $addUserResult = mysqli_query($conn, $addUserStmt);
        if ($addUserResult) {
            $state = success;
            $avataUpdateQuery = "CALL proc_user_avata('$id','$avata')";
            move_uploaded_file($file["tmp_name"],"avatas/$avata");
            mysqli_query($conn,$avataUpdateQuery);
            $_SESSION['user']['avata'] = $avata;
            $_SESSION['user']['name'] = $name;
            header("Location: ./index.php?page=account");
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
        $updateUserPasswordStmt = "CALL proc_user_updatePassword('$id','$password','$oldPassword');";
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
            Thông tin tài khoản
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form group">
                    <label>
                        Họ và tên
                        <input name="name" value="<?php if (isset($name)) echo $name ?>" type="text">
                    </label>
                    <p class="message">
                        <?php if (isset($nameErr)) echo $nameErr ?>
                    </p>
                </div>

                <div class="form group">
                    <label>
                        Username
                        <input name="username" value="<?php if (isset($username)) echo $username ?>" type="text">
                    </label>
                    <p class="message">
                        <?php if (isset($usernameErr)) echo $usernameErr ?>
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

                <div class="form group">
                    <label>
                        <span class="label">Avata</span>
                        <input accept="image/png, image/jpeg" type="file" name="avata">
                        <p class="message">
                            <?php if (isset($avataErr)) echo $avataErr ?>
                        </p>
                    </label>
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