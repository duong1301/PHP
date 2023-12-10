<?php
$semester = 1;
$year = 1;
$classId = "";
if (isset($_POST["year"]) || isset($_POST["semester"])) {
    $year = $_POST["year"];
    $semester =  $_POST["semester"];
}
const numsOfSubject = 13;
if (isset($_GET["id"])) {
    $classId = $_GET['id'];
    $studentQueryStmt = "CALL proc_score_getbyClass('$classId','$year','$semester')";
    $students_scores = mysqli_query($conn, $studentQueryStmt);
    $student_scores =  [];
    while(mysqli_next_result($conn)){;}

    $studentSemesterAverageScoreStmt = "CALL proc_score_semesterAverage('$classId', '$semester', '$year')";
    $studentSemesterAverageScoreResult = mysqli_query($conn, $studentSemesterAverageScoreStmt);
    $studentSemesterAverageScore = [];
    
    while($score = mysqli_fetch_array($studentSemesterAverageScoreResult)){
        $studentSemesterAverageScore[$score['studentId']] = $score;
    }
    while(mysqli_next_result($conn)){;}
    
    echo "<pre>";
        while($row = mysqli_fetch_array($students_scores)){
            $student_scores[$row["studentId"]]["studentId"] = $row["studentId"];
            $student_scores[$row["studentId"]]["fullName"] = $row["fullName"];
            $student_scores[$row["studentId"]]["studentCode"] = $row["studentCode"];
            $student_scores[$row["studentId"]][$row["subjectId"]] = $row["average"]; 
            $student_scores[$row["studentId"]]["semesterAvg"] = $studentSemesterAverageScore[$row["studentId"]]["semesterAverage"]; 
        }
        // print_r($student_scores);
    echo "</pre>";
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
    <h2>Bảng điểm lớp <?php echo $class["name"] ?></h2>
    <h2>Niên khoá <?php echo $class["schoolYear"] . " - " . $class["schoolYearEnd"] ?></h2>
</div>

<div class="page-content page-scoreClass">
    <div class="toolbar">
        <form id="yearAndSemesterForm" action="" method="POST">
            Năm học
            <select onchange="handleYearAndSemesterChange();" name="year">
                <option <?php if ($year == 1) echo "selected" ?> value="1"><?php echo ($class['schoolYear']) . ' - ' . ($class['schoolYear'] + 1) ?></option>
                <option <?php if ($year == 2) echo "selected" ?> value="2"><?php echo ($class['schoolYear'] + 1) . ' - ' . ($class['schoolYear'] + 2) ?></option>
                <option <?php if ($year == 3) echo "selected" ?> value="3"><?php echo ($class['schoolYear'] + 2) . ' - ' . ($class['schoolYear'] + 3) ?></option>
            </select>
            Học kỳ
            <select onchange="handleYearAndSemesterChange();" name="semester">
                <option <?php if ($semester == 1) echo "selected" ?> value="1">Học kỳ 1</option>
                <option <?php if ($semester == 2) echo "selected" ?> value="2">Học kỳ 2</option>
            </select>
        </form>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Mã HS</th>
                    <th>Họ và tên</th>
                    <th>Toán</th>
                    <th>Vật lý</th>
                    <th>Hoá học</th>
                    <th>Sinh học</th>
                    <th>Tin học</th>
                    <th>Văn</th>
                    <th>Lịch sử</th>
                    <th>Địa lý</th>
                    <th>NN</th>
                    <th>GDCD</th>
                    <th>Công nghệ</th>
                    <th>Thể dục</th>
                    <th>QPAN</th>
                    <th>TB</th>
                    <th></th>

                </tr>
            </thead>

            <tbody>
                <?php
                while ($row = array_pop($student_scores)) {
                    
                ?>
                    <tr>
                        <td><?php echo $row["studentCode"] ?></td>
                        <td><?php echo $row["fullName"] ?></td>
                        <td><?php echo $row["s01"] ?></td>
                        <td><?php echo $row["s02"] ?></td>
                        <td><?php echo $row["s03"] ?></td>
                        <td><?php echo $row["s04"] ?></td>
                        <td><?php echo $row["s05"] ?></td>
                        <td><?php echo $row["s06"] ?></td>
                        <td><?php echo $row["s07"] ?></td>
                        <td><?php echo $row["s08"] ?></td>
                        <td><?php echo $row["s09"] ?></td>
                        <td><?php echo $row["s10"] ?></td>
                        <td><?php echo $row["s11"] ?></td>
                        <td><?php if($row["s12"] > 5) echo "Đ"; else echo "CĐ" ?></td>
                        <td><?php echo $row["s13"] ?></td>
                        <td><?php echo $row["semesterAvg"] ?></td>                        
                        <td>
                            <a href="./index.php?page=score_student<?php echo '&studentId=' . $row['studentId'] . '&classId=' . $classId ?>">Điểm thành phần</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function handleYearAndSemesterChange() {
        let form = document.querySelector("#yearAndSemesterForm");
        form.submit();
    }
</script>