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

    if ($semester != 0) {
        $studentQueryStmt = "CALL proc_score_getbyClass('$classId','$year','$semester')";
        $students_scores = mysqli_query($conn, $studentQueryStmt);
        $student_scores =  [];
        while (mysqli_next_result($conn)) {;
        }

        $studentSemesterAverageScoreStmt = "CALL proc_score_semesterAverage('$classId', '$semester', '$year')";
        $studentSemesterAverageScoreResult = mysqli_query($conn, $studentSemesterAverageScoreStmt);
        $studentSemesterAverageScore = [];

        while ($score = mysqli_fetch_array($studentSemesterAverageScoreResult)) {
            $studentSemesterAverageScore[$score['studentId']] = $score;
        }
        while (mysqli_next_result($conn)) {;
        }

        echo "<pre>";
        while ($row = mysqli_fetch_array($students_scores)) {
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
    } else {
        $studentQueryStmt = "CALL proc_score_year('$classId','$year')";
        $students_scores = mysqli_query($conn, $studentQueryStmt);
        $student_scores =  [];
        while (mysqli_next_result($conn)) {;
        }

        $studentSemesterAverageScoreStmt = "CALL proc_score_yearAverage('$classId', '$year')";
        $studentSemesterAverageScoreResult = mysqli_query($conn, $studentSemesterAverageScoreStmt);
        $studentSemesterAverageScore = [];

        while ($score = mysqli_fetch_array($studentSemesterAverageScoreResult)) {
            $studentSemesterAverageScore[$score['studentId']] = $score;
        }
        while (mysqli_next_result($conn)) {;
        }

        echo "<pre>";
        while ($row = mysqli_fetch_array($students_scores)) {
            $student_scores[$row["studentId"]]["studentId"] = $row["studentId"];
            $student_scores[$row["studentId"]]["fullName"] = $row["fullName"];
            $student_scores[$row["studentId"]]["studentCode"] = $row["studentCode"];
            $student_scores[$row["studentId"]][$row["subjectId"]] = $row["yearAverage"];
            $student_scores[$row["studentId"]]["yearAvg"] = $studentSemesterAverageScore[$row["studentId"]]["yearAverage"];
        }
        // print_r($student_scores);
        echo "</pre>";
        while (mysqli_next_result($conn)) {;
        }
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
                <option <?php if ($semester == 0) echo "selected" ?> value="0">Cả năm</option>▬
            </select>
        </form>
    </div>
    <div class="table-wrapper">

        <?php if ($semester != 0) {

        ?>
            <table>
                <thead>
                    <tr>
                        <th class="sticky--left" style="min-width: 100px; width: 100px;">Mã HS</th>
                        <th class="sticky--left" style="left:100px">Họ và tên</th>
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
                        <th class="sticky--right" style="right:150px">Xếp loại</th>
                        <th class="sticky--right" style="min-width: 150px; width: 150px;">Điểm thành phần</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    define('NO_INFOR', 0);
                    define('EXCELLENT', 1);
                    define('GOOD', 2);
                    define('AVERAGE', 3);
                    define('BELOW_AVERAGE', 4);
                    $i = 1;
                    while ($row = array_pop($student_scores)) {
                        $classification = 0;
                        if (
                            $row["s01"] != NULL ||
                            $row["s02"] != NULL ||
                            $row["s03"] != NULL ||
                            $row["s04"] != NULL ||
                            $row["s05"] != NULL ||
                            $row["s06"] != NULL ||
                            $row["s07"] != NULL ||
                            $row["s08"] != NULL ||
                            $row["s09"] != NULL ||
                            $row["s10"] != NULL ||
                            $row["s11"] != NULL ||
                            $row["s12"] != NULL
                        ) {
                            $classification = 1;
                            if ($row["semesterAvg"] < 8) $classification += 1;
                            if ($row["semesterAvg"] < 6.5) $classification += 1;
                            if ($row["semesterAvg"] < 5) $classification += 1;
                            if ($row["s12"] < 5) $classification += 1;
                        }

                    ?>
                        <tr>
                            <td class="sticky--left" style="min-width: 100px; width: 100px;"><?php echo $row["studentCode"];?></td>
                            <td class="sticky--left" style="left:100px"><?php echo $row["fullName"] ?></td>
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
                            <td><?php if ($row["s12"] > 5) echo "Đ";
                                else echo "CĐ" ?></td>
                            <td><?php echo $row["s13"] ?></td>
                            <td><?php echo $row["semesterAvg"] ?></td>
                            <td class="sticky--right" style="right:150px;">
                                <?php
                                switch ($classification) {
                                    case NO_INFOR:
                                        echo "<div class='chip'>Chưa xếp loại</div>";
                                        break;
                                    case EXCELLENT:
                                        echo "<div class='chip '>Giỏi</div>";
                                        break;
                                    case GOOD:
                                        echo "<div class='chip infor'>Khá</div>";
                                        break;
                                    case AVERAGE:
                                        echo "<div class='chip warning'>Trung Bình</div>";
                                        break;
                                    case $classification >= BELOW_AVERAGE:
                                        echo "<div class='chip error'>Yếu</div>";
                                        break;
                                    default:
                                        
                                        break;
                                }
                                ?>
                            </td>
                            <td class="sticky--right">
                                <a href="./index.php?page=score_student<?php echo '&studentId=' . $row['studentId'] . '&classId=' . $classId ?>">
                                    <span class="icon">
                                        <i class="fal fa-eye"></i>
                                    </span>
                                </a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        <?php

        } else {
        ?>
            <table>
                <thead>
                    <tr>
                        <th class="sticky--left" style="min-width: 100px; width: 100px;">Mã HS</th>
                        <th class="sticky--left" style="left:100px">Họ và tên</th>
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
                        <th class="sticky--right" style="right:150px">Xếp loại</th>
                        <th class="sticky--right">Xét lên lớp</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    define('NO_INFOR', 0);
                    define('EXCELLENT', 1);
                    define('GOOD', 2);
                    define('AVERAGE', 3);
                    define('BELOW_AVERAGE', 4);
                    while ($row = array_pop($student_scores)) {
                        $classification = 0;
                        if (
                            $row["s01"] != NULL ||
                            $row["s02"] != NULL ||
                            $row["s03"] != NULL ||
                            $row["s04"] != NULL ||
                            $row["s05"] != NULL ||
                            $row["s06"] != NULL ||
                            $row["s07"] != NULL ||
                            $row["s08"] != NULL ||
                            $row["s09"] != NULL ||
                            $row["s10"] != NULL ||
                            $row["s11"] != NULL ||
                            $row["s12"] != NULL
                        ) {
                            $classification = 1;

                            if ($row["yearAvg"] < 8) $classification += 1;
                            if ($row["yearAvg"] < 6.5) $classification += 1;
                            if ($row["yearAvg"] < 5) $classification += 1;
                            if ($row["s12"] < 5) $classification += 1;
                        }
                    ?>
                        <tr>
                            <td class="sticky--left"><?php echo $row["studentCode"] ?></td>
                            <td class="sticky--left" style="left:100px"><?php echo $row["fullName"] ?></td>
                            <td><?php if ($row["s01"] != NULL) echo number_format($row["s01"], 2) ?></td>
                            <td><?php if ($row["s02"] != NULL) echo number_format($row["s02"], 2) ?></td>
                            <td><?php if ($row["s03"] != NULL) echo number_format($row["s03"], 2) ?></td>
                            <td><?php if ($row["s04"] != NULL) echo number_format($row["s04"], 2) ?></td>
                            <td><?php if ($row["s05"] != NULL) echo number_format($row["s05"], 2) ?></td>
                            <td><?php if ($row["s06"] != NULL) echo number_format($row["s06"], 2) ?></td>
                            <td><?php if ($row["s07"] != NULL) echo number_format($row["s07"], 2) ?></td>
                            <td><?php if ($row["s08"] != NULL) echo number_format($row["s08"], 2) ?></td>
                            <td><?php if ($row["s09"] != NULL) echo number_format($row["s09"], 2) ?></td>
                            <td><?php if ($row["s10"] != NULL) echo number_format($row["s10"], 2) ?></td>
                            <td><?php if ($row["s11"] != NULL) echo number_format($row["s11"], 2) ?></td>
                            <td><?php if ($row["s12"] != NULL) if ($row["s12"] > 5) echo "Đ";
                                else echo "CĐ" ?></td>
                            <td><?php if ($row["s13"] != NULL) echo number_format($row["s13"]) ?></td>


                            <td><?php if ($row["yearAvg"] != NULL) echo number_format($row["yearAvg"], 2)  ?></td>
                            <td class="sticky--right" style="right: 150px;">
                                <?php
                                switch ($classification) {
                                    case NO_INFOR:
                                        echo "<div class='chip'>Chưa xếp loại</div>";
                                        break;
                                    case EXCELLENT:
                                        echo "<div class='chip '>Giỏi</div>";
                                        break;
                                    case GOOD:
                                        echo "<div class='chip infor'>Khá</div>";
                                        break;
                                    case AVERAGE:
                                        echo "<div class='chip warning'>Trung Bình</div>";
                                        break;
                                    case BELOW_AVERAGE:
                                        echo "<div class='chip error'>Yếu</div>";
                                        break;
                                    default:
                                        echo "Yếu";
                                        break;
                                }
                                ?>
                            </td>
                            <td class="sticky--right" style="min-width: 150px; width: 150px;">
                                <?php
                                if ($classification != NO_INFOR)
                                    if ($classification <= AVERAGE) {
                                        echo "<div class='chip success'>Được lên lớp</div>";
                                    } else {
                                        echo "<div class='chip error'>Ở lại lớp</div>";
                                    }
                                ?>
                            </td>

                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        <?php
        } ?>


    </div>
</div>

<script>
    function handleYearAndSemesterChange() {
        let form = document.querySelector("#yearAndSemesterForm");
        form.submit();
    }
</script>