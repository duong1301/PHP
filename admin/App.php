<?php
if (null == isset($_SESSION["email"]))
    header("Location: login.php ");
$page = "";
if (isset($_GET["page"]))
    $page = $_GET["page"];
?>


<div class="App">
    <header>
        <?php include_once('./components/header/header.php') ?>
    </header>
    <div class="container">
        <nav class="navbar">
            <?php include_once('./components/navbar/Navbar.php') ?>
        </nav>
        <main class="main">
            <?php
            switch ($page) {
                case 'user':
                    include_once('./pages/userPage/UserPage.php');
                    break;
                case 'teacher':
                    include_once('./pages/teacherPage/TeacherPage.php');
                    break;
                case 'subject':
                    include_once('./pages/subjectPage/SubjectPage.php');
                    break;
                case 'class':
                    include_once('./pages/classPage/ClassPage.php');
                    break;
                case 'student':
                    include_once('./pages/studentPage/studentPage.php');
                    break;
                case 'user_edit':
                    include_once('./pages/userEditPage/UserEditPage.php');
                    break;
                case 'user_add':
                    include_once('./pages/userAddPage/UserAddPage.php');
                    break;
                case 'teacher_add':
                    include_once('./pages/teacherAddPage/TeacherAddPage.php');
                    break;
                case 'class_add':
                    include_once('./pages/classAddPage/ClassAddPage.php');
                    break;
                case 'student_add':
                    include_once('./pages/studentAddPage/StudentAddPage.php');
                    break;
                case 'score':
                    include_once('./pages/scorePage/ScorePage.php');
                    break;
                case 'classScore':
                    include_once('./pages/classScorePage/ClassScorePage.php');
                    break;
                case 'studentScore':
                    include_once('./pages/studentScorePage/StudentScorePage.php');
                    break;

                default:
                    echo 404;
                    break;
            }

            ?>

        </main>
    </div>
    <footer>

    </footer>



</div>