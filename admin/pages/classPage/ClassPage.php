<?php
include("../config/connect.php");
$query = "CALL proc_class_getAll";
$result = $conn->query($query);
echo $result->num_rows;
?>

<div class="page class">
    <div class="page-title">
        <h2>Danh sách lớp học</h2>
    </div>

    <div class="page-content">
    <div class="toolbar">
            <a href="./index.php?page=class_add">
                <button>Thêm lớp</button>
            </a>
        </div>
        <table border="1">
            <thead>
                <tr>
                    <th>Niên khoá</th>
                    <th>Tên lớp</th>
                    <th>Sĩ số</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                ?>
                    <tr>
                        <td><?php echo $row["schoolYear"]."-".$row["schoolYearFinish"] ?></td>
                        <td><?php echo $row["name"]?></td>
                        <td><?php echo $row["qlt"]?></td>
                        <td> <a onclick="return confirm('xác nhận')" href="./index.php?page=student&classId=<?php echo $row['classId'] ?>">Xem danh sách học sinh</a> </td>
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