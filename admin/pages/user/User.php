<?php

$userQueryStmt = "CALL proc_user_getAll";
$users = mysqli_query($conn, $userQueryStmt);
while (mysqli_next_result($conn)) {;
}
?>

<div class="page-title">
    <h2>Quản lý nhân viên</h2>
</div>

<div class="page-content">
    <div class="main-content">

        <div class="toolbar">
            <a href="index.php?page=user_add">
                <button class="btn pri">Thêm nhân viên</button>
            </a>
        </div>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Họ và tên</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Mật khẩu</th>
                        <th>Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($users) {
                        while ($user = mysqli_fetch_array($users)) {
                            if ($user["level"] != 0) {
                    ?>
                                <tr>
                                    <td><?php echo $user["name"] ?></td>
                                    <td><?php echo $user["username"] ?></td>
                                    <td><?php echo $user["email"] ?></td>
                                    <td><?php echo $user["password"] ?></td>

                                    <td>
                                        <?php if ($user["level"] != 0) {
                                        ?>
                                            <a onclick="return confirm('Xác nhận xoá nhân viên <?php echo $user['name'] ?>')" href="./pages/user_del/User_del.php?id=<?php echo $user["userId"] ?>">
                                                <div class="icon-wrapper warning">
                                                    <span class="icon">
                                                        <i class="far fa-trash"></i>
                                                    </span>
                                                </div>
                                            </a>

                                            <a href="./index.php?page=user_update&id=<?php echo $user["userId"] ?>">
                                                <div class="icon-wrapper infor">
                                                    <span class="icon ">
                                                        <i class="far fa-edit"></i>
                                                    </span>
                                                </div>
                                            </a>

                                        <?php
                                        } ?>

                                    </td>

                                </tr>
                    <?php
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>