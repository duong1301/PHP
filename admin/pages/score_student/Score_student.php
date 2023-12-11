<?php

const numsOfSubject = 13;
$isEdit = false;
$year = 1;
$semester = 1;
$classId = "";
$studentId = "";
if (isset($_GET["classId"]) && isset($_GET["studentId"])) {
    $classId = $_GET['classId'];
    $studentId = $_GET['studentId'];
}


if (isset($_POST["year"]) || isset($_POST["semester"])) {
    $year = $_POST["year"];
    $semester =  $_POST["semester"];
}

$studentScoreQueryStmt = "CALL proc_score_getByStudent('$studentId',$semester,$year)";
$studentScores = mysqli_query($conn, $studentScoreQueryStmt);
while (mysqli_next_result($conn)) {;
}

$studentQueryStmt = "CALL proc_student_getById('$studentId')";
$studentQueryResult  = mysqli_query($conn, $studentQueryStmt);
$student = mysqli_fetch_array($studentQueryResult);
while (mysqli_next_result($conn)) {;
}

$classQueryStmt = "CALL proc_class_getById('$classId')";
$classQueryResult = mysqli_query($conn, $classQueryStmt);
$class = mysqli_fetch_array($classQueryResult);
while (mysqli_next_result($conn)) {;
}

?>

<div class="page-title">
    <h2>Bảng điểm chi tiết </h2>
    <h3>Họ và tên: <?php echo $student["fullName"] ?></h3>
    <h3>Niên khoá <?php echo $class["schoolYear"] . " - " . $class["schoolYearEnd"] ?></h3>
</div>

<div class="page-content page-scoreStudent">
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
                    <th>Tên môn</td>
                    <th colspan="3">Điểm hệ số 1</td>
                    <th colspan="2">Điểm hệ số 2</td>
                    <th>Điểm thi </td>
                    <th>Trung bình</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <?php
                while ($score = mysqli_fetch_array($studentScores)) {
                ?>
                    <tr>
                        <form action="./pages/score_update/Score_update.php" method="post">

                            <input value="<?php echo $year ?>" type="hidden" name="year">
                            <input value="<?php echo $studentId ?>" type="hidden" name="studentId">
                            <input value="<?php echo $classId ?>" type="hidden" name="classId">
                            <input value="<?php echo $semester ?>" type="hidden" name="semester">
                            <input value="<?php echo $score['subjectId'] ?>" type="hidden" name="subjectId">


                            <td>
                                <?php echo $score['subjectName'] ?>
                            </td>
                            <td><input class="inp-<?php echo $score['subjectId'] ?>" readonly 
 style="width: 40px; padding:4px;" value="<?php echo $score['oralTest'] ?>" name="oralTest" type="text"></td>
                            <td><input class="inp-<?php echo $score['subjectId'] ?>" readonly onkeydown="scoreValidate(event)" style="width: 40px; padding:4px;" value="<?php echo $score['fifTest1'] ?>" name="fifTest1" type="text"></td>
                            <td><input class="inp-<?php echo $score['subjectId'] ?>" readonly onkeydown="scoreValidate(event)" style="width: 40px; padding:4px;" value="<?php echo $score['fifTest2'] ?>" name="fifTest2" type="text"></td>
                            <td><input class="inp-<?php echo $score['subjectId'] ?>" readonly onkeydown="scoreValidate(event)" style="width: 40px; padding:4px;" value="<?php echo $score['periodTest1'] ?>" name="periodTest1" type="text"></td>
                            <td><input class="inp-<?php echo $score['subjectId'] ?>" readonly onkeydown="scoreValidate(event)" style="width: 40px; padding:4px;" value="<?php echo $score['periodTest2'] ?>" name="periodTest2" type="text"></td>
                            <td><input class="inp-<?php echo $score['subjectId'] ?>" readonly onkeydown="scoreValidate(event)" style="width: 40px; padding:4px;" value="<?php echo $score['finalTest'] ?>" name="finalTest" type="text"></td>
                            <td> <?php echo $score['average'] ?> </td>
                            <td id="col-save-<?php echo $score['subjectId'] ?>" class="hide">
                                <button name="update" class="btn update-btn">Lưu</button>
                                <button name="cancel" class="btn">Huỷ</button>
                            </td>
                        </form>

                        <td id="col-update-<?php echo $score['subjectId'] ?>">
                            <button onclick="handleHide('<?php echo $score['subjectId'] ?>')" class="btn">Cập nhật</button>
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

    function scoreValidate(e) {
        const key = e.keyCode;
        const keyValid = [8, 46, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 190];

        if (!keyValid.includes(key)) {
            e.preventDefault();
        }
        if (key !== 8) {
            const nextValue = Number(e.target.value + e.key);
            if (nextValue > 10 || nextValue < 0 || Number.isNaN(nextValue)) {
                e.preventDefault();
            }
            if ((e.target.value + " ").length > 4) {
                e.preventDefault();
            }

            if (Number(e.target.value) === 10) {
                e.preventDefault();
            }
        }
    }


    function handleHide(e) {
        let colSave = document.querySelector('#col-save-' + e);
        let colUpdate = document.querySelector('#col-update-' + e);
        let inpElements = document.querySelectorAll('.inp-' + e);
        inpElements.forEach((item) => {
            item.removeAttribute('readonly');
        })
        colSave.classList.remove('hide');
        colUpdate.classList.add('hide');
    }
</script>