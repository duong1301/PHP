<?php
$semester = 1;
$schoolYearMax = 2023;
$schoolYear = $schoolYearMax;
$schoolYearMin = 2020;
$classId = "";
$GLOBALS["schoolYear"] = $schoolYear;
$GLOBALS["semeter"] = $semester;
if (isset($_POST["yeschoolYear"]) || isset($_POST["semester"])) {
    $schoolYear = $_POST["schoolYear"];
    $semester =  $_POST["semester"];
    $GLOBALS["schoolYear"] = $schoolYear;
    $GLOBALS["semeter"] = $semester;
}
?>

<div class="wrapper">
    <h3>Trường trung học phổ thông 123</h3>
    <div>
        <form id="yearAndSemesterForm" action="" method="POST">
            Năm học
            <select onchange="handleYearAndSemesterChange();" name="schoolYear">
                <?php
                    for($year = $schoolYearMax; $year >= $schoolYearMin; --$year){
                ?>
                    <option 
                        value="<?php echo $year ?>"
                        <?php if($schoolYear == $year) echo "selected" ?>
                    >
                        <?php echo $year."-".($year + 1)?>
                    </option>
                <?php
                    }
                ?>
            </select>
            Học kỳ
            <select onchange="handleYearAndSemesterChange();" name="semester">
                <option <?php if ($semester == 1) echo "selected" ?> value="1">Học kỳ 1</option>
                <option <?php if ($semester == 2) echo "selected" ?> value="2">Học kỳ 2</option>
            </select>
        </form>
    </div>
    <div class="user-infor">
        <div class="name">Nguyen Van A</div>
        <div class="avata">
        </div>
        <?php include('./components/dropdownHeader/dropdownHeader.php') ?>
    </div>

<script>
    function handleYearAndSemesterChange() {
        let form = document.querySelector("#yearAndSemesterForm");
        form.submit();
    }
</script>