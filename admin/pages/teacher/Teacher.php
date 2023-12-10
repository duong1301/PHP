<?php

const teacherQueryStmt = "CALL proc_teacher_getAll";
$teachers = mysqli_query($conn, teacherQueryStmt);
while(mysqli_next_result($conn)){;}
?>
<style>
.icon{
    text-align:center;
}    a{
    color:blue;
}
</style>
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
                        <td>
                            <div class="icon"><span>
                                <a 
                                    href="./index.php?page=teacher_del&id=<?php echo $teacher["teacherId"] ?>"
                                    onclick="return confirm('Xác nhận xoá giáo viên <?php echo $teacher['fullname'] ?> ')"
                                ><i class="fa-solid fa-trash"></i></a>
                            </span>
                            <span> &emsp; </span>
                            <span>
                                <a href="./index.php?page=teacher_update&id=<?php echo $teacher["teacherId"] ?>"> <i class="fa-solid fa-arrows-rotate"></i></a>
                            </span></div>
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