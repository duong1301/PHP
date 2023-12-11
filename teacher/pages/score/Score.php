<?php
echo $GLOBALS["semester"];
$classId = "";
if(isset($_GET["classId"])) $classId = $_GET["classId"];
if(isset($_GET["grade"])) $grade = $_GET["grade"];

$subjectId = "s01";
$studentScoresQueryStmt = "CALL proc_score_getBySubject('$classId','$subjectId',1,1)";
$studentScoresQueryResult = mysqli_query($conn, $studentScoresQueryStmt);
$students = [];
while ($student = mysqli_fetch_array($studentScoresQueryResult)) {
    $students[$student["studentId"]] = $student;
}
while (mysqli_next_result($conn));

if (isset($_POST["update"])) {
    $semester = 1;
    $year = 1;
    foreach ($students as $student) {
        $oral = $_POST["oral-" . $student["studentId"]];
        $fif1 = $_POST["fif1-" . $student["studentId"]];
        $fif2 = $_POST["fif2-" . $student["studentId"]];
        $per1 = $_POST["period1-" . $student["studentId"]];
        $per2 = $_POST["period2-" . $student["studentId"]];
        $final = $_POST["final-" . $student["studentId"]];
        updateScore($conn, $student["studentId"], $classId, $subjectId, $oral, $fif1, $fif2, $per1, $per2, $final, 1, 1);
        // header("Location: ./index.php?classId=".$classId."&grade=".$grade);
    }
} 

$studentScoresQueryResult = mysqli_query($conn, $studentScoresQueryStmt);
$students = [];
while ($student = mysqli_fetch_array($studentScoresQueryResult)) {
    $students[$student["studentId"]] = $student;
}
while (mysqli_next_result($conn));


function updateScore(
    $conn,
    $studentId,
    $classId,
    $subjectId,
    $oralTest,
    $fifTest1,
    $fifTest2,
    $periodTest1,
    $periodTest2,
    $finalTest,
    $semester,
    $year
) {
    $updateScoreStmt = "CALL proc_score_update('$studentId','$classId','$subjectId',$year,$semester,$oralTest,$fifTest1,$fifTest2,$periodTest1,$periodTest2,$finalTest)";
    mysqli_query($conn, $updateScoreStmt);
    echo $conn->error;
}

$classQueryStmt = "CALL proc_class_getById('$classId')";
$classQueryResult = mysqli_query($conn, $classQueryStmt);
$class = mysqli_fetch_array($classQueryResult);
?>

<div class="page-content page-score">
    <div>
        <h2>Lớp <?php echo $grade.$class["name"] ?></h2>
    </div>

    <form action="" method="post">
        <button class="btn" name="update">Lưu</button>
        <table border=1>
            <thead>
                <tr>
                    <th>Họ </th>
                    <th>Tên</th>
                    <th colspan="3">Điểm hệ số 1</th>
                    <th colspan="2">Điểm hệ số 2</th>
                    <th>Điểm thi</th>
                    <th>Trung bình</th>
                </tr>
            </thead>
            <tbody>


                <?php
                foreach ($students as $score) {
                ?>
                    <tr>
                        <td><?php echo $score["lastName"] ?></td>
                        <td><?php echo $score["firstName"] ?></td>
                        <td><input onkeydown="scoreValidate(event)" type="text" value="<?php echo $score["oralTest"] ?>" name="<?php echo "oral-" . $score["studentId"] ?>"></td>
                        <td><input onkeydown="scoreValidate(event)" type="text" value="<?php echo $score["fifTest1"] ?>" name="<?php echo "fif1-" . $score["studentId"] ?>"></td>
                        <td><input onkeydown="scoreValidate(event)" type="text" value="<?php echo $score["fifTest2"] ?>" name="<?php echo "fif2-" . $score["studentId"] ?>" id=""></td>
                        <td><input onkeydown="scoreValidate(event)" type="text" value="<?php echo $score["periodTest1"] ?>" name="<?php echo "period1-" . $score["studentId"] ?>" id=""></td>
                        <td><input onkeydown="scoreValidate(event)" type="text" value="<?php echo $score["periodTest2"] ?>" name="<?php echo "period2-" . $score["studentId"] ?>" id=""></td>
                        <td><input onkeydown="scoreValidate(event)" type="text" value="<?php echo $score["finalTest"] ?>" name="<?php echo "final-" . $score["studentId"] ?>" id=""></td>
                        <td><?php echo $score["average"] ?></td>
                    </tr>
                <?php
                }
                ?>

            </tbody>

        </table>
    </form>
</div>

<script>
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
</script>