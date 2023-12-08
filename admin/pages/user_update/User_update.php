<?php
include('common/emailValidation.php');

$name = "";
$username = "";
$email = "";
$password = "";
$passwordConfirm = "";
$level = "";
$message = "";
const success = "success";
const error = "error";
$state;
$id = "";
if(isset($_GET["id"])){
    $id = $_GET["id"];
}
$userQueryStmt = "CALL proc_user_getById('$id')";
$userQueryResult = mysqli_query($conn,$userQueryStmt);
$user = mysqli_fetch_array($userQueryResult);
while(mysqli_next_result($conn)){;}
if(mysqli_num_rows($userQueryResult) !=0){
    $name = $user["name"];
    $username = $user["username"];
    $email = $user["email"];
    $password = $user["password"];
    $passwordConfirm = $user["password"];
    $level = $user["level"];
}
if (isset($_POST["update"])) {
    $name = trim($_POST["name"], " ");
    $nameErr = "";
    $username = trim($_POST["username"], " ");
    $usernameErr = "";
    $email = trim($_POST["email"], " ");
    $emailErr = "";
    $level = trim($_POST["level"], " ");
    $password = trim($_POST["password"], " ");
    $passwordErr = "";
    $passwordConfirm = trim($_POST["passwordConfirm"], " ");
    $passwordConfirmErr = "";

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
    //password
    if (empty($password)) {
        $passwordErr = "Không được để trống";
    }
    //passwordConfirm
    if (strcmp($password, $passwordConfirm) != 0) {
        $passwordConfirmErr = "Mật khẩu không trùng khớp";
    }
    //
    if (
        empty($nameErr) &&
        empty($usernameErr) &&
        empty($emailErr) &&
        empty($passwordErr) &&
        empty($passwordConfirmErr)
    ) {
        $addUserStmt = "CALL proc_user_update('$id','$name','$username','$email','$password','$level');";
        $addUserResult = mysqli_query($conn, $addUserStmt);
        if ($addUserResult) {
            $state = success;
            $message = "Thêm mới thành công";
        } else {
            echo $conn->error;
        }
    }
}

?>

<div class="page-title">
    <h2>Thêm nhân viên</h2>
</div>

<div class="page-content">
    <div class="message-container">
        <div class="toast <?php echo $state ?>">
            <p>
                <?php if ($message != "") echo $message ?>
            </p>

        </div>
    </div>
    <div>
        <form action="" method="post">
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
                    Mật khẩu
                    <input value="<?php if(isset($password)) echo $password ?>" name="password" type="password">
                </label>
                <p class="message">
                    <?php if (isset($passwordErr)) echo $passwordErr ?>
                </p>
            </div>

            <div class="form group">
                <label>
                    Nhập lại mật khẩu
                    <input value="<?php if(isset($passwordConfirm)) echo $passwordConfirm ?>"  name="passwordConfirm" type="password">
                </label>
                <p class="message">
                    <?php if (isset($passwordConfirmErr)) echo $passwordConfirmErr ?>
                </p>
            </div>

            <div class="form group">
                <label>
                    Quyền
                    <select name="level">
                        <option <?php if(isset($user)) if($user["level"] == 1) echo "selected" ?> value="1">Member</option>
                        <option <?php if(isset($user)) if($user["level"] == 0) echo "selected" ?> value="0">Admin</option>
                    </select>
                </label>
                <p class="message"></p>
            </div>
            <button type="submit" name="update" class="btn">Lưu</button>
            <button type="submit" name="clear" class="btn">Xoá</button>
        </form>
    </div>

</div>