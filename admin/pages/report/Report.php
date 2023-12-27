<?php

define('NO_INFOR', 0);
define('EXCELLENT', 1);
define('GOOD', 2);
define('AVERAGE', 3);
define('BELOW_AVERAGE', 4);


$maxYear = date("Y");
$minYear = 2020;
$grades = [10, 11, 12];

if (!isset($_COOKIE["reportYear"])) {
    setcookie("reportYear", $maxYear, time() + (86400 * 30));
    $year = $_COOKIE["reportYear"];
}

if (isset($_POST["year"]) || isset($_POST["semester"])) {
    if (isset($_POST["year"])) {
        $year = $_POST["year"];
        $_COOKIE["reportYear"] = $_POST["year"];
    }
    if (isset($_POST["semester"])) {
        $semester =  $_POST["semester"];
        $_COOKIE["reportSemester"] = $_POST["semester"];
    }
}
$year = $_COOKIE["reportYear"];

if (!isset($_COOKIE["reportSemester"])) {
    setcookie("reportSemester", 1, time() + (86400 * 30));
    $semester = $_COOKIE["reportSemester"];
} else {
    $semester = $_COOKIE["reportSemester"];
}

if (!isset($_COOKIE["reportGrades"])) {
    setcookie("reportGrades", "10-11-12", time() + (86400 * 30));
}
if (isset($_POST["apply"])) {
    if (isset($_POST["grade"])) {
        $grades = $_POST["grade"];
        $_COOKIE["reportGrades"] = implode("-", $grades);
    } else {
        $grades = [];
        $_COOKIE["reportGrades"] = implode("-", $grades);
    }
}
$grades = explode("-", $_COOKIE["reportGrades"]);



// start get general infor
$numsOfTeacher = 0;
$numsOfStudents = 0;
$numsOfClasses = 0;
$numsOfTeacherQuery = "CALL proc_report_getGeneralInfor($year,@numsOfTeacher,@numsOfStudents,@numsOfClasses)";
mysqli_query($conn, $numsOfTeacherQuery);
$select = mysqli_query($conn, 'SELECT @numsOfTeacher,@numsOfStudents,@numsOfClasses');
$result =  mysqli_fetch_array($select);
$numsOfTeacher = $result['@numsOfTeacher'];
$numsOfStudents = $result['@numsOfStudents'];
$numsOfClasses = $result['@numsOfClasses'];

//end get general infor

//start get scoresConditional
$query = "CALL proc_report_semesterClassificationScoreCondition($year, $semester)";
if ($semester == 0) {
    $query = "CALL proc_report_yearClassificationScoreCondition($year)";
}
$scoresConditionalResult = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($scoresConditionalResult)) {
    $conditions[$row["studentId"]] = $row["average"];
}
while (mysqli_next_result($conn));
//end get scoresConditional

//start get student average score

$query = "CALL proc_report_semesterScoreAverage($year,$semester)";
if ($semester == 0) {
    $query = "CALL proc_report_yearScoreAverage($year)";
}
$studentsAverageScoreResult = mysqli_query($conn, $query);
$numsOfExcellent = 0;
$numsOfGood = 0;
$numsOfAverage = 0;
$numsOfBelowAverage = 0;

while ($row = mysqli_fetch_array($studentsAverageScoreResult)) {
    $scores[$row["grade"]][$row["classId"]]["name"] = $row["name"];
    if (!isset($scores[$row["grade"]][$row["classId"]]["excellent"])) {
        $scores[$row["grade"]][$row["classId"]]["excellent"] = 0;
    };
    if (!isset($scores[$row["grade"]][$row["classId"]]["good"])) {
        $scores[$row["grade"]][$row["classId"]]["good"] = 0;
    };
    if (!isset($scores[$row["grade"]][$row["classId"]]["average"])) {
        $scores[$row["grade"]][$row["classId"]]["average"] = 0;
    };
    if (!isset($scores[$row["grade"]][$row["classId"]]["belowAverage"])) {
        $scores[$row["grade"]][$row["classId"]]["belowAverage"] = 0;
    };
    $classification = 0;
    $condition = $conditions[$row["studentId"]];
    $score = $row["semesterAverage"];
    if (!$score == null) {
        $classification = 1;
        if ($condition < 5) $classification += 1;
        if ($score < 8) $classification += 1;
        if ($score < 6.5) $classification += 1;
        if ($score < 5) $classification += 1;
        switch ($classification) {
            case NO_INFOR:
                break;
            case EXCELLENT:
                $numsOfExcellent += 1;
                $scores[$row["grade"]][$row["classId"]]["excellent"] += 1;
                break;
            case GOOD:
                $numsOfGood += 1;
                $scores[$row["grade"]][$row["classId"]]["good"] += 1;
                break;
            case AVERAGE:
                $numsOfAverage += 1;
                $scores[$row["grade"]][$row["classId"]]["average"] += 1;
                break;
            case $classification >= BELOW_AVERAGE:
                $numsOfBelowAverage += 1;
                $scores[$row["grade"]][$row["classId"]]["belowAverage"] += 1;
                break;
            default:

                break;
        }
    }
}
//end get student average score

?>

<div class="page-title">

</div>

<div class="page-content report">

    <div class="toolbar">

        <form id="yearAndSemesterForm" action="" method="POST">
            Năm học
            <select onchange="handleYearAndSemesterChange();" name="year">
                <?php
                for ($y = $maxYear; $y >= $minYear; $y -= 1) {
                ?>
                    <option <?php if ($y == $year) echo "selected" ?> value="<?php echo $y ?>"><?php echo $y . " - " . ($y + 1) ?></option>
                <?php
                }
                ?>
            </select>
            Kỳ đánh giá
            <select onchange="handleYearAndSemesterChange();" name="semester">
                <option <?php if ($semester == 1) echo "selected" ?> value="1">Học kỳ 1</option>
                <option <?php if ($semester == 2) echo "selected" ?> value="2">Học kỳ 2</option>
                <option <?php if ($semester == 0) echo "selected" ?> value="0">Cả năm</option>▬
            </select>
        </form>
        <div>
            Khối
            <form action="" method="post">
                <label class="form-group">
                    <input
                    checked
                    onchange="
                        let isShow = document.getElementById('grade--10');
                        isShow.checked = event.target.checked;                      
                    " value="10" type="checkbox" name="grade[]" id="">
                    <span>Khối lớp 10</span>
                </label>
                <label class="form-group">
                    <input
                    checked
                     onchange="
                        let isShow = document.getElementById('grade--11');
                        isShow.checked = event.target.checked;                      
                    " value="11" type="checkbox" name="grade[]" id="">
                    <span>Khối lớp 11</span>
                </label>
                <label class="form-group">
                    <input
                    checked
                    onchange="
                        let isShow = document.getElementById('grade--12');
                        isShow.checked = event.target.checked;                      
                    " value="12" type="checkbox" name="grade[]" id="">
                    <span>Khối lớp 12</span>
                </label>
                
            </form>
        </div>

    </div>
    <div class="content">
        <h3>Thông tin toàn trường</h3>
        <div class="general-infor ">
            <div class="infor flex-container">
                <div class="card">
                    <div class="card__icon">
                        <i class="far fa-users-class"></i>
                    </div>
                    <div class="card__content">
                        <div class="quantity"><?php echo $numsOfStudents ?></div>
                        <div>Học sinh</div>
                    </div>
                </div>
                <div class="card success">
                    <div class="card__icon">
                        <i class="far fa-chalkboard-teacher"></i>
                    </div>
                    <div class="card__content">
                        <div class="quantity"><?php echo $numsOfExcellent ?></div>
                        <div>Giỏi</div>
                        <div><?php echo number_format($numsOfExcellent * 100 / $numsOfStudents, 2) ?>%</div>
                    </div>
                </div>

                <div class="card infor">
                    <div class="card__icon">
                        <i class="far fa-chalkboard-teacher"></i>
                    </div>
                    <div class="card__content">
                        <div class="quantity"><?php echo $numsOfGood ?></div>
                        <div>Khá</div>
                        <div><?php echo number_format($numsOfGood * 100 / $numsOfStudents, 2) ?>%</div>
                    </div>
                </div>

                <div class="card warning">
                    <div class="card__icon">
                        <i class="far fa-chalkboard-teacher"></i>
                    </div>
                    <div class="card__content">
                        <div class="quantity"><?php echo $numsOfAverage ?></div>
                        <div>Trung bình</div>
                        <div><?php echo number_format($numsOfAverage * 100 / $numsOfStudents, 2) ?>%</div>
                    </div>
                </div>

                <div class="card error">
                    <div class="card__icon">
                        <i class="far fa-chalkboard-teacher"></i>
                    </div>
                    <div class="card__content">
                        <div class="quantity"><?php echo $numsOfBelowAverage ?></div>
                        <div>Yếu</div>
                        <div><?php echo number_format($numsOfBelowAverage * 100 / $numsOfStudents, 2) ?>%</div>
                    </div>
                </div>

            </div>

        </div>
        <div class="classes-report">
            <input hidden checked type="checkbox" id="grade--10">
            <input hidden checked type="checkbox" id="grade--11">
            <input hidden checked type="checkbox" id="grade--12">
            <?php
            if (isset($scores[10]))
                $classes = $scores[10];
            if (isset($scores[10]))
                foreach ($classes as $class) {
            ?>
                <div class="class-card grade--10">
                    <h3 class="name">Lớp <?php echo "10" . " " . $class["name"] ?></h3>
                    <div>Loại giỏi: <?php echo $class["excellent"] ?></div>
                    <div>Loại khá: <?php echo $class["good"] ?></div>
                    <div>Loại trung bình: <?php echo $class["average"] ?></div>
                    <div>Loại yếu: <?php echo $class["belowAverage"] ?></div>
                </div>

            <?php
                }
            ?>

            <?php
            if (isset($scores[11]))
                $classes = $scores[11];
            if (isset($scores[11]))
                foreach ($classes as $class) {
            ?>
                <div class="class-card grade--11">
                    <h3 class="name">Lớp <?php echo "11" . " " . $class["name"] ?></h3>
                    <div>Loại giỏi: <?php echo $class["excellent"] ?></div>
                    <div>Loại khá: <?php echo $class["good"] ?></div>
                    <div>Loại trung bình: <?php echo $class["average"] ?></div>
                    <div>Loại yếu: <?php echo $class["belowAverage"] ?></div>
                </div>

            <?php
                }
            ?>

            <?php
            if (isset($scores[12]))
                $classes = $scores[12];
            if (isset($scores[12]))
                foreach ($classes as $class) {
            ?>
                <div class="class-card grade--12">
                    <h3 class="name">Lớp <?php echo "12" . " " . $class["name"] ?></h3>
                    <div>Loại giỏi: <?php echo $class["excellent"] ?></div>
                    <div>Loại khá: <?php echo $class["good"] ?></div>
                    <div>Loại trung bình: <?php echo $class["average"] ?></div>
                    <div>Loại yếu: <?php echo $class["belowAverage"] ?></div>
                </div>

            <?php
                }
            ?>
        </div>
    </div>



</div>

<script>
    function handleYearAndSemesterChange() {
        let form = document.querySelector("#yearAndSemesterForm");
        form.submit();
    }
</script>