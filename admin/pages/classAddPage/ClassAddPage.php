<?php
include("../config/connect.php");
$name = "";
$schoolYear = "";

if (isset($_POST["create"])) {
    $name = $_POST["name"];
    $schoolYear = $_POST["schoolYear"];
   

    $query = "CALL proc_class_add('$name', $schoolYear)";
    $result = $conn->query($query);
    if(!$result == true){
        echo $conn->error;
    }else{
        echo "Success";
        header("Location: index.php?page=class");
    }
}

?>

<div class="page class">
    <div class="page-title">
        <h2>Thêm nhân viên</h2>
    </div>

    <div class="page-content">
        <form action="" method="post">
            <div>
                <label>
                    <p>Tên lớp</p>
                    <input value="<?php echo $name ?>" required name="name" />
                </label>
                <label>
                    <p>Niên khoá</p>
                    <input value="<?php echo $schoolYear ?>" required name="schoolYear" />
                </label>
                
            </div>
            <div>
                <input class="btn" type="submit" name="create" value="Tạo" />
                <input class="btn" type="submit" name="clear" value="Huỷ" />
            </div>
        </form>


    </div>
</div>