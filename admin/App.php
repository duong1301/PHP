<?php
include('../config/connect.php');
if (null == isset($_SESSION["email"]))
    header("Location: login.php ");
$page = "";
if (isset($_GET["page"]))
    $page = $_GET["page"];
?>


<div class="App">
    <header class="header">
        <?php include_once('./components/header/header.php') ?>
    </header>
    <div class="app-container">
        <nav class="navbar">
            <?php include_once('./components/navbar/Navbar.php') ?>
        </nav>
        <main class="main">
            <?php
            switch ($page) {
                case 'user':
                    include_once('./pages/user/User.php');
                    break;
                case 'user_add':
                    include_once('./pages/user_add/User_add.php');
                    break;

                case 'subject':
                    include_once('./pages/subject/Subject.php');
                    break;
                
                case 'teacher':
                    include_once('./pages/teacher/Teacher.php');
                    break;
                case 'teacher_add':
                    include_once('./pages/teacher_add/Teacher_add.php');
                    break;
                case 'teacher_del':
                    include_once('./pages/teacher_del/Teacher_del.php');
                    break;
                
                case 'class':
                    include_once('./pages/class/Class.php');
                    break;
                case 'class_add':
                    include_once('./pages/class_add/Class_add.php');
                    break;
                case 'class_del':
                    include_once('./pages/class_del/Class_del.php');
                    break;
                case 'class_students':
                    include_once('./pages/class_students/Class_students.php');
                    break;

                case 'student_del':
                    include_once('./pages/student_del/Student_del.php');
                    break;
                
                default:
                    echo 404;
                    break;
            }

            ?>

        </main>
    </div>

</div>