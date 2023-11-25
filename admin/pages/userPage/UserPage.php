<?php
include("../config/connect.php");
$query = "CALL proc_user_getAll";
$result = $conn->query($query);
echo $result->num_rows;
?>

<div class="page user">
    <div class="page-title">
        <h2>Quản lý nhân viên</h2>
    </div>

    <div class="page-content">
        <div class="toolbar">
            <a href="./index.php?page=user_add">
                <button class="btn">Thêm nhân viên</button>
            </a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Họ và tên</th>
                    <th>Email</th>
                    <th>Quyền</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                ?>
                    <tr>
                        <td><?php echo $row["name"] ?></td>
                        <td><?php echo $row["email"] ?></td>
                        <td><?php echo $row["level"] ?></td>
                        <td>Sửa, xoá</td>
                    </tr>
                <?php
                    }
                }

                ?>


            </tbody>
        </table>

    </div>
</div>