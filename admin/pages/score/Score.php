<?php

$year = $_SESSION["schoolYear"];
$classQueryStmt = "CALL proc_class_getByYear($year)";
$classes = mysqli_query($conn, $classQueryStmt);
while (mysqli_next_result($conn)) {;
}
?>


<div class="page-title">
    <h2>Kết quả học tập</h2>
</div>

<div class="page-content page-score">
    <div class="main-content">

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Tên lớp</th>
                        <th>Khối</th>
                        <th>Sĩ số</th>
                        <th>Xem chi tiết</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($classes) {
                        while ($class = mysqli_fetch_array($classes)) {
                    ?>
                            <tr>
                                <td><?php echo $class['name'] ?></td>
                                <td><?php echo $class['grade'] ?></td>
                                <td><?php echo $class['qlt'] ?></td>
                                <td>
                                    <a href="./index.php?page=score_class&id=<?php echo $class['classId'] ?>">
                                        <div class="icon-wrapper success">
                                            <span class="icon">
                                                <i class="fal fa-eye"></i>
                                            </span>
                                        </div>

                                    </a>
                                </td>

                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>
</div>