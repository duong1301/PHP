<?php
include("../config/connect.php");
$classId = "";

if (isset($_GET["classId"])) {
    $classId = $_GET["classId"];
}

if(isset($_POST["delete"])){
    echo 123;
    $studentId = $_POST["delete"];
    echo $studentId;
    $stmt = "CALL proc_student_del('$studentId')";
    $result = $conn->query($stmt);
    echo $conn->error;
    while (mysqli_next_result($conn)) {
    }
}

$classQuery = "CALL proc_class_getById('$classId')";
$classQueryResult = $conn->query($classQuery);
$class = mysqli_fetch_array($classQueryResult);
while (mysqli_next_result($conn)) {
}

$query = "CALL proc_student_class('$classId')";
$result = $conn->query($query);
echo $result->num_rows;
?>

<div class="page user">
    <div class="page-title">
        <h2>Danh sách học sinh Lớp <?php echo $class["name"] ?></h2>
    </div>

    <div class="page-content">
        <a href="./index.php?page=student_add&classId=<?php echo $classId ?>">
            <button class="btn">Thêm học sinh</button>
        </a>
        <table border="1">
            <thead>
                <tr>
                    <th>Mã học sinh</th>
                    <th>Họ và tên</th>
                    <th>Lớp</th>
                    <th>Ngày sinh</th>

                </tr>
            </thead>
            <tbody>

                <?php
                if ($result->num_rows > 0)
                    while ($row = mysqli_fetch_array($result)) {
                ?>
                    <tr>
                        <td><?php echo $row["studentCode"] ?></td>
                        <td><?php echo $row["lastName"]." ".$row["firstName"] ?></td>
                        <td><?php echo $row["className"] ?></td>
                        <td><?php echo $row["dob"] ?></td>
                        <td><a href="<?php echo './index.php?page=studentScore&studentId=' . $row["studentId"] . '&s=1' . '&y=1' . '&classId=' . $class['classId'] ?>">Xem kết quả học tập</a></td>
                        <td><a href="<?php echo './index.php?page=studentScore&studentId=' . $row["studentId"] . '&s=1' . '&y=1' . '&classId=' . $class['classId'] ?>">Xem thông tin chi tiết</a></td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="delete" value="<?php echo $row["studentId"] ?>"/>
                                <button type="submit" class=" btn">Xoá</button>
                            </form>
                        </td>
                    </tr>

                <?php
                    }
                ?>
            </tbody>

        </table>

    </div>
</div>