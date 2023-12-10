<?php
include('common/phoneValidation.php');
include('common/nameValidation.php');
include('common/emailValidation.php');
const subjectQueryStmt = "CALL proc_subject_getAll";
$subjects = mysqli_query($conn, subjectQueryStmt);


while (mysqli_next_result($conn)) 
if(isset($_POST["create"])){
    $firstName = trim($_POST["firstName"]);
    $lastName = trim($_POST["lastName"]);
    $phone = trim($_POST["phone"]);
    $email = trim($_POST["email"]);
    $subject = $_POST["subject"];   

    $firstNameErr = "";
    $lastNameErr = "";
    $phoneErr = "";
    $emailErr = "";

    /**
     * Validate
     * nvduong 12/07/2023
     */

    //firstName
    if(empty($firstName)){
        $firstNameErr ="Không được để trống";
    }else{
        $firstNameErr = validate_name($firstName);
    }
    

    //lastname
    if(empty($lastName)){
        $lastNameErr ="Không được để trống";
    }else{
        $lastNameErr = validate_name($lastName);
    }
    

    //phone
    if(empty($phone)){
        $phoneErr = "Không được để trống";
    }else{
        $phoneErr = validate_phone($phone);
    }   

    

    //email
    if(empty($email)){
        $emailErr = "Không được để trống";
    }else{
        $emailErr = validate_email($email);
    }
        

    if(
        empty($firstNameErr) &&
        empty($lastNameErr) &&
        empty($emailErr) &&
        empty($phoneErr)
    ){
        $teacherAddStatement = "CALL proc_teacher_add('$firstName','$lastName','$phone', '$email','$subject')";
        $addResult = mysqli_query($conn, $teacherAddStatement);
        if($addResult){
            echo "Success";
        }else{
            echo $conn->error;
        }
    }    
}
?>
<style>    *{
        font-family:sans-serif;
    }
    button:hover{
        background:black;
        color:white;
        transition:  1s ease ;
        transition-property: color,background;
    }
    .form-group{
        position: relative;
    }
    .form-group .error{
        position: absolute;
        top:40px;
        left:320px;
        font-size:1rem;
        }
        .form-group .subject{
            font-size:1rem;
        }
</style>
<div class="page-title">
    <h2>Thêm giáo viên</h2>
</div>
<div>
    <div>
        <form action="" method="post">
            <div class="form-group">
                <label  style="font-size: 1.2rem;">
                    Họ
                    <input value="<?php if(isset($_POST["lastName"])) echo $_POST["lastName"]?>" name="lastName" type="text">
                    <p class="error">
                        <?php if(isset($lastNameErr))echo $lastNameErr  ?>
                    </p>
                </label>
            </div>
            <div class="form-group">
                <label style="font-size: 1.2rem;">
                    Tên
                    <input value="<?php if(isset($_POST["firstName"])) echo $_POST["firstName"]?>" name="firstName" type="text">
                    <p class="error">
                        <?php if(isset($firstNameErr))echo $firstNameErr  ?>
                    </p>
                </label>
            </div>
            <div class="form-group">
                <label style="font-size: 1.2rem;">
                    Số điện thoại
                    <input
                         value="<?php if(isset($_POST["phone"])) echo $_POST["phone"]?>" 
                         name="phone" 
                         type="tel"
                    
                    >
                    <p class="error">
                        <?php if(isset($phoneErr))echo $phoneErr  ?>
                    </p>
                </label>
            </div>
            <div class="form-group">
                <label style="font-size: 1.2rem;">
                    Email
                    <input 
                        value="<?php if(isset($_POST["email"])) echo $_POST["email"]?>" 
                        name="email" >
                        
                    <p class="error">
                        <?php if(isset($emailErr)) echo $emailErr ?>
                    </p>
                </label>
            </div>
            <div class="form-group">
                <label style="font-size: 1.2rem;">
                    Môn giảng dạy
                    <select name="subject" class="subject">
                        <?php
                        if ($subjects) {
                            while ($subject = mysqli_fetch_array($subjects)) {
                        ?>
                                <option 
                                    <?php if(isset($_POST["subject"])){
                                        if($_POST["subject"] == $subject["subjectId"]) echo "selected";
                                    } ?> 
                                    value="<?php echo $subject["subjectId"] ?>"><?php echo $subject['name'] ?>
                                </option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </label>
            </div>
            <div>
                <button class="btn" name="create">Tạo</button>
            </div>
        </form>
    </div>
</div>