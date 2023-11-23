<?php
    session_start();
    $email = "";   
    if(isset($_POST["email"])){ 
        $email = $_POST["email"];
        if($email == "1"){
            $_SESSION["email"]  = $email;          
            
            header("Location: index.php?page=user");
        }
    }    
?>
<div class="login">
    <div class="container">
        <form action="" method="post">
            <div>
                <input value="1" type="text" name="email" id="">
            </div>

            <div>
                <input type="password" name="password" id="">
            </div>
            <div>
                <button type="submit">Login</button>
            </div>
        </form>
    </div>
</div>


