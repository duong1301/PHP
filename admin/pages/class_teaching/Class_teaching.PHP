<?php

$year = 1;
$classId = "";
if (isset($_POST["year"])) {
    $year = $_POST["year"];
}
if(isset($_POST["updateTeaching"])){
    $teacherId = $_POST["teacherId"];
    $semester = $_POST["semester"];
    $subjectId = $_POST["subjectId"];
    $year = $_POST["year"];
    $classId = $_POST["classId"];
    
    if($teacherId == "NULL"){
        $updateTeachingStmt = "CALL proc_teacherClass_update(NULL,'$classId',$semester,$year,'$subjectId')";
    }else
        $updateTeachingStmt = "CALL proc_teacherClass_update('$teacherId','$classId',$semester,$year,'$subjectId')";
    $result = mysqli_query($conn,$updateTeachingStmt);  
    echo $conn->error; 
}

$teachersBySubject = [];
if (isset($_GET["id"])) {
    $classId = $_GET['id'];

    $classQueryStmt = "CALL proc_class_getById('$classId')";
    $classQueryResult = mysqli_query($conn, $classQueryStmt);
    $class = mysqli_fetch_array($classQueryResult);
    while (mysqli_next_result($conn)) {;
    }

    $subjectsQueryStmt = "CALL proc_subject_getAll";
    $subjectsQueryResult = mysqli_query($conn, $subjectsQueryStmt);
    while (mysqli_next_result($conn)) {;
    }

    $teacherQueryStmt = "CALL proc_teacher_getAll";
    $teacherQueryResult = mysqli_query($conn, $teacherQueryStmt);
    
    while ($teacher = mysqli_fetch_array($teacherQueryResult)) {
        $teachersBySubject[$teacher["subjectId"]][$teacher["teacherId"]] = $teacher;
    }
    while (mysqli_next_result($conn)) {;}

    $teachingsQueryStmt = "CALL proc_teacherClass('$classId',0,'$year')";
    $teachingsQueryResult = mysqli_query($conn, $teachingsQueryStmt);
    $teachings = [];
    echo "<pre>";
    while($teaching = mysqli_fetch_array($teachingsQueryResult)){
        
        $teachings[$teaching["subjectId"]][$teaching["semester"]] = $teaching;
    }
    while(mysqli_next_result($conn)){;}
    // print_r($teachings);
    echo "</pre>";
}


?>

<div class="page-title">
    <h2>Phân công giảng dạy lớp <?php echo $class["name"] ?></h2>
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
        </form>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Mã môn</th>
                    <th>Tên môn</th>
                    <th>Học kì 1</th>
                    <th>Học kỳ 2</th>
                </tr>
            </thead>

            <tbody>
                <?php
                while ($subject = mysqli_fetch_array($subjectsQueryResult)) {
                ?>
                    <tr>
                        <td><?php echo $subject["subjectCode"] ?></td>
                        <td><?php echo $subject["name"] ?></td>
                        <td>
                            <!-- <form action="./pages/updateTeaching/Updateteaching.php" method="post"> -->
                            <form action="" method="post">
                                <input type="hidden" name="year" value="<?php echo$year ?>">
                                <input type="hidden" name="classId" value="<?php echo$classId ?>">
                                <input type="hidden" value="1" name="semester">
                                <input type="hidden" value="<?php echo $subject["subjectId"]?>" name="subjectId">
                                <select name="teacherId" id="">
                                    <option value="NULL">Chưa phân công</option>
                                    <?php
                                    if (isset($teachersBySubject[$subject["subjectId"]])) {
                                        $teachers = $teachersBySubject[$subject["subjectId"]];
                                        while ($teacher = array_shift($teachers)) {
                                    ?>
                                            <option 
                                                value="<?php echo $teacher["teacherId"] ?>"
                                                <?php if(isset($teachings[$subject["subjectId"]][1])) if($teachings[$subject["subjectId"]][1]["teacherId"] == $teacher["teacherId"]) echo "selected" ?>
                                            >
                                                <?php echo $teacher["fullname"] . " - " . $teacher["teacherCode"] ?>
                                            </option>
                                    <?php
                                        }
                                    }
                                    ?>
    
                                </select>
                                <button type="submit" name="updateTeaching" class="btn">Lưu thay đổi</button>
                            </form>

                        </td>

                        <td>
                            <!-- <form action="./pages/updateTeaching/Updateteaching.php" method="post"> -->
                            <form action="" method="post">
                                <input type="hidden" name="year" value="<?php echo$year ?>">
                                <input type="hidden" name="classId" value="<?php echo$classId ?>">
                                <input type="hidden" value="2" name="semester">
                                <input type="hidden" value="<?php echo $subject["subjectId"]?>" name="subjectId">
                                <select name="teacherId" id="">
                                    <option value="NULL">Chưa phân công</option>
                                    <?php
                                    if (isset($teachersBySubject[$subject["subjectId"]])) {
                                        $teachers = $teachersBySubject[$subject["subjectId"]];
                                        while ($teacher = array_shift($teachers)) {
                                    ?>
                                            <option 
                                                value="<?php echo $teacher["teacherId"] ?>"
                                                <?php if(isset($teachings[$subject["subjectId"]][2])) if($teachings[$subject["subjectId"]][2]["teacherId"] == $teacher["teacherId"]) echo "selected" ?>
                                            >
                                                <?php echo $teacher["fullname"] . " - " . $teacher["teacherCode"] ?>
                                            </option>
                                    <?php
                                        }
                                    }
                                    ?>
    
                                </select>
                                <button type="submit" name="updateTeaching" class="btn">Lưu thay đổi</button>
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

<script>
    function handleYearAndSemesterChange() {
        let form = document.querySelector("#yearAndSemesterForm");
        form.submit();
    }
</script>