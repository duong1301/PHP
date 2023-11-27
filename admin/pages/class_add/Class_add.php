<?php

if (isset($_POST["create"])) {
    $name = $_POST["name"];
    $schoolYear = $_POST["schoolYear"];
    $classAddStmt = "CALL proc_class_add('$name', '$schoolYear')";
    $addResult = mysqli_query($conn, $classAddStmt);
    if ($addResult) {
        echo "Success";
        // header("location: ./index.php?page=class");
    } else {
        echo $conn->error;
    }
}
?>


<div class="page-title">
    <h2>Thêm lớp học</h2>
</div>
<div class="page-content">
    <div>
        <form action="" method="post">
            <div class="form-control">
                <label for="">
                    Tên lớp học
                    <input value="<?php
                                    if (isset($_POST["name"])) echo $_POST["name"];
                                    ?>" type="text" name="name" />
                </label>
                <p class="message"></p>
            </div>

            <div class="form-control">
                <label for="">
                    Niên khoá (Nhập năm bắt đầu)
                    <input value="<?php if (isset($_POST["schoolYear"])) echo $_POST["schoolYear"] ?>" placeholder="VD: 2020" type="number" min=2020 max=2050 name="schoolYear" id="">
                </label>
                <p class="message"></p>
            </div>

            <button class="btn" name="create">Tạo</button>
        </form>

    </div>
</div>