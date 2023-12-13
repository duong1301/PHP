<?php

const classQueryStmt = "CALL proc_class_getAll";
$classes = mysqli_query($conn, classQueryStmt);
while (mysqli_next_result($conn)) {;
}
$error = "";
if (isset($_GET['error'])) {
    $error = "Không thể xoá lớp đang có học sinh";
}
?>


<div class="page-title">
    <h2>Danh sách lớp học</h2>
</div>

<div class="page-content page-class">
    <div class="toolbar">
        <a href="./index.php?page=class_add">
            <button class="btn">Thêm lớp học</button>
        </a>
    </div>
    <div class="message-container">
        <div class="toast <?php if($error!="") echo "error" ?>">
            <p>
                <?php if ($error != "") echo $error ?>
            </p>
        </div>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Tên lớp</th>
                    <th>Niên khoá</th>
                    <th>Sĩ số</th>
                    <th>Danh sách học sinh</th>
                    <th>Phân công giảng dạy</th>
                    <th>Xoá</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($classes) {
                    while ($class = mysqli_fetch_array($classes)) {
                ?>
                        <tr>
                            <td><?php echo $class['name'] ?></td>
                            <td><?php echo $class['schoolYear'] . " - " . $class["schoolYearEnd"] ?></td>
                            <td><?php echo $class['qlt'] ?></td>

                            <td>
                                <a href="./index.php?page=class_students&id=<?php echo $class['classId'] ?>">Xem danh sách lớp học</a>
                            </td>
                            <td>
                                
                                    <a href="./index.php?page=class_teaching&id=<?php echo $class['classId'] ?>">
                                        Thực hiện phân công
                                    </a>
                                
                            </td>
                            <td>
                                <span class="icon">
                                    <a onclick="return confirm('Xác nhận xoá lớp học')" href="./index.php?page=class_del&id=<?php echo $class['classId'] ?>">
                                        <i class="far fa-trash"></i>
                                    </a>
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