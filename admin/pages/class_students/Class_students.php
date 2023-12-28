<?php

if (isset($_GET["id"])) {
    $classId = $_GET['id'];

    $studentQueryStmt = "CALL proc_student_class('$classId')";
    $students = mysqli_query($conn, $studentQueryStmt);
    $numsOfStudent = mysqli_num_rows($students);

    while (mysqli_next_result($conn)) {;
    }

    $classQueryStmt = "CALL proc_class_getById('$classId')";
    $classQueryResult = mysqli_query($conn, $classQueryStmt);
    $class = mysqli_fetch_array($classQueryResult);
    while (mysqli_next_result($conn)) {;
    }
}
?>

<div class="page-title">
    <h2>Danh sách học sinh lớp <?php echo $class["name"] ?></h2>
    <h2>Niên khoá <?php echo $class["schoolYear"] . " - " . $class["schoolYearEnd"] ?></h2>
</div>

<div class="page-content class-students-page">
    <div class="toolbar">
        <a href="./index.php?page=student_add&classId=<?php echo $classId ?>">

            <button class="btn pri">Thêm</button>
        </a>

    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã HS</th>
                    <th>Họ và tên</th>
                    <th>Dân tộc</th>
                    <th>Ngày sinh</th>
                    <th>Tên bố</th>
                    <th>Số điện thoại</th>
                    <th>Nghề nghiệp</th>
                    <th>Tên mẹ</th>
                    <th>Số điện thoại</th>
                    <th>Nghề nghiệp</th>
                    <th class="sticky--right">Hành động</th>

                </tr>
            </thead>
            <tbody>
                <?php
                if ($studentQueryStmt) {
                    $i = 0;
                    while ($student = mysqli_fetch_array($students)) {
                        $i +=1;
                ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $student["studentCode"] ?></td>
                            <td><?php echo $student["fullname"] ?></td>
                            <td><?php echo $student["ethnic"] ?></td>
                            <td><?php echo $student["dob"] ?></td>
                            <td><?php echo $student["fatherName"] ?></td>
                            <td><?php echo $student["fatherPhone"] ?></td>
                            <td><?php echo $student["fatherJob"] ?></td>
                            <td><?php echo $student["motherName"] ?></td>
                            <td><?php echo $student["motherPhone"] ?></td>
                            <td><?php echo $student["motherJob"] ?></td>
                            <td class="sticky--right">
                                <a onclick="return confirm('Xác nhận xoá học sinh <?php echo $student['fullname'] ?> mã học sinh <?php echo $student['studentCode'] ?>')" href="./index.php?page=student_del&id=<?php echo $student["studentId"] ?>&classId=<?php echo $class['classId'] ?>">
                                    <div class="icon-wrapper warning">
                                        <span class="icon">
                                            <i class="far fa-trash"></i>
                                        </span>
                                    </div>
                                </a>
                                <a href="./index.php?page=student_update&id=<?php echo $student["studentId"] ?>&classId=<?php echo $class['classId'] ?>">
                                    <div class="icon-wrapper infor">
                                        <span class="icon ">
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
    <div class="table-footer">
        Tổng số học sinh: <?php echo $numsOfStudent ?>
    </div>
</div>