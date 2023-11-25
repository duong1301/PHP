<?php
include("../config/connect.php");
$classId = "";

if (isset($_GET["classId"])) {
    $classId = $_GET["classId"];
}

$query = "CALL proc_score_getByClass('$classId',1,1)";
$result = $conn->query($query);
echo $result->num_rows;

?>

<div class="page user">
    <div class="page-title">
        <h2>Bảng điểm lớp <?php echo 123 ?></h2>
    </div>

    <div class="page-content">
        <div>
            <table>
                <thead>
                    <tr>
                        <th>
                            Mã học sinh
                        </th>
                        <th>
                            Họ tên
                        </th>
                        <th>
                            Môn
                        </th>
                        <th>
                            điểm miệng
                        </th>
                        <th>
                            Trung bình
                        </th>
                        <th>Năm học</th>
                        <th>học kỳ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if($result){
                            while($row = mysqli_fetch_array($result)){
                    ?>
                        <tr>
                            <td><?php echo $row["studentCode"] ?></td>
                            <td><?php echo $row["studentName"] ?></td>
                            <td><?php echo $row["subjectName"] ?></td>
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