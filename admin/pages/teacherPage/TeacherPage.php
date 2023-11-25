<?php
include("../config/connect.php");
$query = "CALL proc_teacher_getAll";
$result = $conn->query($query);
echo $result->num_rows;

?>

<div class="page user">
    <div class="page-title">
        <h2>Quản lý giáo viên</h2>
    </div>

    <div class="page-content">
        <div class="toolbar">
            <a href="./index.php?page=teacher_add">
                <button>Thêm nhân viên</button>
            </a>
        </div>
        <table border="1">
            <thead>
                <tr>
                    <th>Họ và tên</th>
                    <th>Môn giảng dạy</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                ?>
                        <tr>
                            <td><?php echo $row["lastName"]." ".$row["firstName"] ?></td>
                            <td><?php echo $row["subjectName"] ?></td>
                            <td><?php echo $row["email"] ?></td>
                            <td><?php echo $row["phone"] ?></td>
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