<?php

const numsOfSubject = 13;
if (isset($_GET["id"])) {
    $classId = $_GET['id'];
    $studentQueryStmt = "CALL proc_score_getbyClass('$classId',1,1)";
    $students_scores = mysqli_query($conn, $studentQueryStmt);
    $student_scores =  [];

    echo "<pre>";
    while (true) {
        $flag = true;
        $score  = [];        
        for($i = 0; $i < numsOfSubject; ++$i){
            $row = mysqli_fetch_array($students_scores);
            if(!$row){
                $flag = false;
                break;
            }
            $score += array($row['subjectId']=>$row['average']);
            $score += $row;   
        }
        if($flag == false) break;
        array_push($student_scores, $score);
    }
    
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
        Năm học
        <select name="year">
            <option value="1"><?php echo ($class['schoolYear']) . ' - ' . ($class['schoolYear'] + 1) ?></option>
            <option value="2"><?php echo ($class['schoolYear'] + 1) . ' - ' . ($class['schoolYear'] + 2) ?></option>
            <option value="3"><?php echo ($class['schoolYear'] + 2) . ' - ' . ($class['schoolYear'] + 3) ?></option>
        </select>
        Học kỳ
        <select>
            <option value="1">Học kỳ 1</option>
            <option value="2">Học kỳ 2</option>
        </select>
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
                    <th></th>

                </tr>
            </thead>

            <tbody>
                <?php
                    while($row = array_pop($student_scores)){
                ?>
                    <tr>
                        <td><?php echo $row["studentCode"]?></td>
                        <td><?php echo $row["fullName"]?></td>
                        <td><?php echo $row["s01"] ?></td>
                        <td><?php echo $row["s02"] ?></td>
                        <td><?php echo $row["s03"] ?></td>
                        <td><?php echo $row["s04"] ?></td>
                        <td><?php echo $row["s05"] ?></td>
                        <td><?php echo $row["s05"] ?></td>
                        <td><?php echo $row["s07"] ?></td>
                        <td><?php echo $row["s08"] ?></td>
                        <td><?php echo $row["s09"] ?></td>
                        <td><?php echo $row["s10"] ?></td>
                        <td><?php echo $row["s11"] ?></td>
                        <td><?php echo $row["s12"] ?></td>
                        <td><?php echo $row["s13"] ?></td>
                        <td>
                            <a 
                                href="./index.php?page=score_student<?php echo '&studentId='.$row['studentId'].'&classId='.$classId?>"
                            >Điểm thành phần</a>
                        </td>
                    </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>