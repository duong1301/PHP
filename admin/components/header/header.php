<?php
    
?>
<div class="header">
    <h3>Trường trung học phổ thông 123</h3>
    <div class="user-infor">
        <p><?php echo $_SESSION["user"]["name"] ?></p>
        <div class="avata">
            <img src="./avatas/<?php echo $_SESSION['user']['avata'] ?>" alt="">
        </div>
        <?php include('components/dropdownHeader/dropdownHeader.php')?>
              
    </div>
</div>