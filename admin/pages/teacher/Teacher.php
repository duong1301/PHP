<?php

const teacherQueryStmt = "CALL proc_teacher_getAll";
$teachers = mysqli_query($conn, teacherQueryStmt);
while(mysqli_next_result($conn)){;}
?>

<div class="page-title">
    <h2>Danh sách giáo viên</h2>
</div>

<div>
    <div class="toolbar">
        <a href="./index.php?page=teacher_add">
            <button class="btn">Thêm giáo viên</button>
        </a>
    </div>
    <div>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Mã giáo viên</th>
                    
                        <th>Tên giáo viên</th>
                    
                        <th>Môn giảng dạy</th>
                    
                        <th>Email</th>
                    
                        <th>Số điện thoại</th>
                        <th>Mật khẩu</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if($teachers){
                            while($teacher = mysqli_fetch_array($teachers)){
                    ?>
                    <tr>
                        <td><?php echo $teacher["teacherCode"] ?></td>
                        <td><?php echo $teacher["fullname"] ?></td>
                        <td><?php echo $teacher["subjectName"] ?></td>
                        <td><?php echo $teacher["email"] ?></td>
                        <td><?php echo $teacher["phone"] ?></td>
                        <td><?php echo $teacher["password"]?></td>
                        <td>
                            <span>
                                <a 
                                    href="./index.php?page=teacher_del&id=<?php echo $teacher["teacherId"] ?>"
                                    onclick="return confirm('Xác nhận xoá giáo viên <?php echo $teacher['fullname'] ?> ')"
                                >Xoá</a>
                            </span>
                            <span> , </span>
                            <span>
                                <a href="./index.php?page=teacher_update&id=<?php echo $teacher["teacherId"] ?>">Cập nhật</a>
                            </span>
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