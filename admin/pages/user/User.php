<?php

$userQueryStmt = "CALL proc_user_getAll";
$users = mysqli_query($conn, $userQueryStmt);
while (mysqli_next_result($conn)) {;
}
?>
<style>
.icon{
    text-align:center;
}    a{
    color:blue;
}
</style>
<div class="page-title">
    <h2>Danh sách nhân viên</h2>
</div>

<div class="page-content">
    <div class="toolbar">
        <a href="index.php?page=user_add">

            <button class="btn">Thêm nhân viên</button>
        </a>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Họ tên</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Quyền</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($users) {
                    while ($user = mysqli_fetch_array($users)) {
                        if($user["level"] !=0){
                ?>
                        <tr>
                            <td><?php echo $user["name"] ?></td>
                            <td><?php echo $user["username"] ?></td>
                            <td><?php echo $user["email"] ?></td>
                            <td><?php echo $user["level"] == 0 ? "Admin" : "Member" ?></td>
                            <td>
                                <?php if($user["level"] != 0) {
                                ?>
                                    <div class="icon">
                                    <span>
                                        <a onclick="return confirm('Xác nhận xoá nhân viên<?php echo $user['name']?>')" href="./pages/user_del/User_del.php?id=<?php echo $user["userId"] ?>">
                                        <i class="fa-solid fa-trash"></i></a>
                                    </span>
                                    <span>&emsp;</span>
                                    <span>
                                        <a href="./index.php?page=user_update&id=<?php echo $user["userId"] ?>">
                                        <i class="fa-solid fa-arrows-rotate"></i></a>
                                    </span>
                                    </div>
                                <?php
                                } ?>
                                
                            </td>

                        </tr>
                <?php
                    }}
                }
                ?>
            </tbody>
        </table>
    </div>
</div>