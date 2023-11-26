<?php
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
if (isset($_POST["create"])) {
    $name = trim($_POST["name"], " ");
    $username = trim($_POST["username"], " ");
    $email = trim($_POST["email"], " ");
    $level = trim($_POST["level"], " ");
    $password = trim($_POST["password"], " ");
    $passwordConfirm = trim($_POST["passwordConfirm"], " ");

    //to do: validate

    //

    $addUserStmt = "CALL proc_user_add('$name','$username','$email','$password','$level');";
    $addUserResult = mysqli_query($conn, $addUserStmt);
    if($addUserResult){
        $state = success;
        $message = "Thêm mới thành công";
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
                <?php if($message != "") echo $message ?>
            </p>

        </div>
    </div>
    <div>
        <form action="" method="post">
            <div class="form group">
                <label>
                    Họ và tên
                    <input name="name" value="<?php if (isset($_POST["name"])) echo $_POST["name"] ?>" type="text">
                </label>
                <p class="message"></p>
            </div>

            <div class="form group">
                <label>
                    Username
                    <input name="username" value="<?php if (isset($_POST["username"])) echo $_POST["username"] ?>" type="text">
                </label>
                <p class="message"></p>
            </div>

            <div class="form group">
                <label>
                    Email
                    <input name="email" value="<?php if (isset($_POST["email"])) echo $_POST["email"] ?>" type="text">
                </label>
                <p class="message"></p>
            </div>

            <div class="form group">
                <label>
                    Mật khẩu
                    <input name="password" type="password">
                </label>
                <p class="message"></p>
            </div>

            <div class="form group">
                <label>
                    Nhập lại mật khẩu
                    <input name="passwordConfirm" type="password">
                </label>
                <p class="message"></p>
            </div>

            <div class="form group">
                <label>
                    Quyền
                    <select name="level">
                        <option value="1">Member</option>
                        <option value="0">Admin</option>
                    </select>
                </label>
                <p class="message"></p>
            </div>

            <button type="submit" name="create" class="btn">Tạo</button>
            <button type="submit" name="clear" class="btn">Xoá</button>

        </form>
    </div>

</div>