<?php
if(isset($_POST)){
    $classId = "71da426a-96e8-11ee-80bc-4ae3953e7697";
    $subjectId = "s01";
    $semester = 1;
    $year = 1;
    foreach($students as $student){
        $scores[$student["studentId"]]["oral"] = $_POST["oral-".$student["studentId"]]; 
        $scores[$student["studentId"]]["fif1"] = $_POST["fif1-".$student["studentId"]]; 
        $scores[$student["studentId"]]["fif2"] = $_POST["fif2-".$student["studentId"]]; 
        $scores[$student["studentId"]]["period1"] = $_POST["period1-".$student["studentId"]]; 
        $scores[$student["studentId"]]["period2"] = $_POST["period2-".$student["studentId"]]; 
        $scores[$student["studentId"]]["final"] = $_POST["final-".$student["studentId"]]; 

        $oral = $_POST["oral-".$student["studentId"]]; 
        $fif1 = $_POST["fif1-".$student["studentId"]]; 
        $fif2 = $_POST["fif2-".$student["studentId"]]; 
        $per1 = $_POST["period1-".$student["studentId"]]; 
        $per2 = $_POST["period2-".$student["studentId"]]; 
        $final = $_POST["final-".$student["studentId"]]; 

        updateScore($conn, $student["studentId"],$classId,$subjectId,$oral,$fif1,$fif2,$per1,$per2,$final,1,1);
    }   
      
}

echo "</pre>";
function updateScore($conn,
    $studentId,$classId, $subjectId, $oralTest, 
    $fifTest1, $fifTest2, $periodTest1, 
    $periodTest2,$finalTest, $semester, $year)
{
    $updateScoreStmt = "CALL proc_score_update('$studentId','$classId','$subjectId',$year,$semester,$oralTest,$fifTest1,$fifTest2,$periodTest1,$periodTest2,$finalTest)";
    mysqli_query($conn,$updateScoreStmt);
    echo $conn->error;
}