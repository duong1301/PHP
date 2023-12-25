<?php
    
?>
<div class="header">

    <div class="logo">
        <img class="logo__img" src="../asset/logo.png" style="height: 40px; " alt="">
        <h2 class="logo__text">Trường trung học phổ thông PHP</h2>
    </div>
    <div class="user-infor">
        <p><?php echo $_SESSION["user"]["name"] ?></p>
        <div class="avata">
            <img src="./avatas/<?php echo $_SESSION['user']['avata'] ?>" alt="">
        </div>
        <?php include('components/dropdownHeader/dropdownHeader.php')?>
              
    </div>
</div>