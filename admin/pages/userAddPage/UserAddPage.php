<?php
include("../config/connect.php");
$name = "";
$userName = "";
$email = "";
$password = "";
$passwordConfirm = "";
$level = 1;

if (isset($_POST["create"])) {
    $name = $_POST["name"];
    $userName = $_POST["userName"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $passwordConfirm = $_POST["passwordConfirm"];
    $level = $_POST["level"];

    $query = "CALL proc_user_add('$name', '$userName', '$email', '$password',$level)";
    $result = $conn->query($query);
    if(!$result == true){
        echo $conn->error;
    }else{
        echo "Success";
        header("Location: index.php?page=user");
    }
}

?>

<div class="page class">
    <div class="page-title">
        <h2>Thêm nhân viên</h2>
    </div>

    <div class="page-content">
        <form action="" method="post">
            <div>
                <label>
                    <p>Họ và tên</p>
                    <input value="<?php echo $name ?>" required name="name" />
                </label>
                <label>
                    <p>User name</p>
                    <input value="<?php echo $userName ?>" required name="userName" />
                </label>
                <label>
                    <p>email</p>
                    <input value="<?php echo $email ?>" required type="email" name="email" />
                </label>

                <label>
                    <p>Mật khẩu</p>
                    <input required type="password" name="password" />
                </label>

                <label>
                    <p>Nhập lại mật khẩu</p>
                    <input required type="password" name="passwordConfirm" />
                </label>


                <label>
                    <p>Quyền</p>
                    <select  required name="level">
                        <option value="1">Nhân viên</option>
                        <option value="0">Admin</option>
                    </select>
                </label>

            </div>
            <div>
                <input type="submit" name="create" value="Tạo" />
                <input type="submit" name="clear" value="Huỷ" />
            </div>
        </form>


    </div>
</div>