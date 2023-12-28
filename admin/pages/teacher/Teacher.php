<?php

const teacherQueryStmt = "CALL proc_teacher_getAll";
$teachers = mysqli_query($conn, teacherQueryStmt);
while (mysqli_next_result($conn)) {;
}
?>

<div class="page-title">
    <h2>Quản lý giáo viên</h2>
</div>

<div>
    <div class="main-content">
        <div class="toolbar">
            <a href="./index.php?page=teacher_add">
                <button class="btn pri">Thêm giáo viên</button>
            </a>
        </div>

        <style>
            .tabler__teacher {
                max-height: calc(100vh - 200px);
                border-top: 1px #e0e0e0 solid;
            }
        </style>
        <div>
            <div class="table-wrapper tabler__teacher">
                <table>
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Mã giáo viên</th>

                            <th>Tên giáo viên</th>

                            <th>Môn giảng dạy</th>

                            <th>Email</th>

                            <th>Số điện thoại</th>
                            <th>Mật khẩu</th>
                            <th class="sticky--right">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        if ($teachers) {
                            while ($teacher = mysqli_fetch_array($teachers)) {
                                $i+=1;
                        ?>
                                <tr>
                                    <td><?php echo $i ?></td>
                                    <td><?php echo $teacher["teacherCode"] ?></td>
                                    <td><?php echo $teacher["fullname"] ?></td>
                                    <td><?php echo $teacher["subjectName"] ?></td>
                                    <td><?php echo $teacher["email"] ?></td>
                                    <td><?php echo $teacher["phone"] ?></td>
                                    <td><?php echo $teacher["password"] ?></td>
                                    <td class="sticky--right">
                                        <a href="./index.php?page=teacher_del&id=<?php echo $teacher["teacherId"] ?>" onclick="return confirm('Xác nhận xoá giáo viên <?php echo $teacher['fullname'] ?> ')">
                                            <div class="icon-wrapper warning">
                                                <span class="icon">
                                                    <i class="far fa-trash"></i>
                                                </span>
                                            </div>
                                        </a>

                                        <a href="./index.php?page=teacher_update&id=<?php echo $teacher["teacherId"] ?>">
                                            <div class="icon-wrapper infor">
                                                <span class="icon">
                                                    <i class="far fa-edit"></i>
                                                </span>
                                            </div>
                                        </a>
                                    </td>
                                </tr>

                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>


</div>