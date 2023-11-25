<?php
include("../config/connect.php");
$studentId = "";
$semester = "";
$year = "";
$classId = "";

if (isset($_GET["studentId"])) {
    $studentId = $_GET["studentId"];
    $semester = $_GET["s"];
    $year = $_GET['y'];
    $classId = $_GET['classId'];
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $year = $_POST["year"];
    $semester = $_POST["semester"];
}


$query = "CALL proc_score_getByStudent('$studentId',$semester,$year)";
$result = $conn->query($query);
while (mysqli_next_result($conn)) {
}

$query = "Call proc_student_getById('$studentId')";
$studentQueryResult = $conn->query($query);
$student = mysqli_fetch_array($studentQueryResult);
while (mysqli_next_result($conn)) {
}

$classQuery = "CALL proc_class_getById('$classId')";
$classQueryResult = $conn->query($classQuery);
$class = mysqli_fetch_array($classQueryResult);
while (mysqli_next_result($conn)) {
}

?>

<div class="page user">
    <div class="page-title">
        <h2>Bảng điểm chi tiết</h2>
    </div>


    <div class="page-content">
        <div>
            <h2>Họ và tên: <?php echo $student['lastName'] . ' ' . $student['firstName'] ?></h2>
            <p>Mã số học sinh <?php echo $student['studentCode'] ?></p>

            <form onchange="handleYearChange();" action="" id="year" method="post">
                Học kỳ :
                <select name="semester">
                    <option <?php if ($semester == 1) echo "selected" ?> value="1">Học kỳ 1</option>
                    <option <?php if ($semester == 2) echo "selected" ?> value="2">Học kỳ 2</option>
                </select>

                <div></div>
                Năm học:
                <select name="year">
                    <option <?php if ($year == 1) echo "selected" ?> value="1"><?php echo ($class["schoolYear"] + 1 - 1) ?> - <?php echo ($class["schoolYear"] + 1) ?></option>
                    <option <?php if ($year == 2) echo "selected" ?> value="2"><?php echo ($class["schoolYear"] + 2 - 1) ?> - <?php echo ($class["schoolYear"] + 2) ?></option>
                    <option <?php if ($year == 3) echo "selected" ?> value="3"><?php echo ($class["schoolYear"] + 3 - 1) ?> - <?php echo ($class["schoolYear"] + 3) ?></option>
                </select>
            </form>
        </div>
        <div>
            <table>
                <thead>
                    <tr>
                        <th>
                            Môn
                        </th>
                        <th>
                            điểm miệng
                        </th>
                        <th>
                            điểm 15 phút 1
                        </th>
                        <th>
                            điểm 15 phút 2
                        </th>
                        <th>
                            điểm 1 tiết 1
                        </th>
                        <th>
                            điểm 1 tiết 2
                        </th>
                        <th>
                            điểm thi
                        </th>
                        <th>
                            Trung bình
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result) {
                        while ($row = mysqli_fetch_array($result)) {
                    ?>
                            <tr>
                                <td><?php echo $row["subjectName"] ?></td>
                                <td><?php echo $row["oralTest"] ?></td>
                                <td><?php echo $row["fifTest1"] ?></td>
                                <td><?php echo $row["fifTest2"] ?></td>
                                <td><?php echo $row["periodTest1"] ?></td>
                                <td><?php echo $row["periodTest2"] ?></td>
                                <td><?php echo $row["finalTest"] ?></td>
                                <td><?php echo $row["average"] ?></td>
                                <td></td>
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

<script>
    let form = document.querySelector("#year");

    function handleYearChange() {
        form.submit();
    }
</script>