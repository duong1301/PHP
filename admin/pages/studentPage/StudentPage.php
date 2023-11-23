<?php
include("../config/connect.php");
$classId = "";

if (isset($_GET["class_id"])) {
    $classId = $_GET["class_id"];
}

$query = "CALL proc_student_class('$classId')";
$result = $conn->query($query);
echo $result->num_rows;


?>

<div class="page user">
    <div class="page-title">
        <h2>Quản lý học sinh</h2>
    </div>

    <div class="page-content">
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Họ</th>
                    <th>Tên</th>
                    <th>Lớp</th>
                    <th>Ngày sinh</th>

                </tr>
            </thead>
            <tbody>

                <?php
                if ($result->num_rows > 0)
                    while ($row = $result->fetch_assoc()) {
                ?>
                    <tr>
                        <td><?php echo $row["studentId"] ?></td>
                        <td><?php echo $row["lastName"] ?></td>
                        <td><?php echo $row["firstName"] ?></td>
                        <td><?php echo $row["className"] ?></td>
                        <td><?php echo $row["dob"] ?></td>
                    </tr>

                <?php
                    }
                ?>
                <td></td>

            </tbody>

        </table>

    </div>
</div>