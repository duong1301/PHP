<?php

const classQueryStmt = "CALL proc_class_getAll";
$classes = mysqli_query($conn, classQueryStmt);
while (mysqli_next_result($conn)) {;
}
?>


<div class="page-title">
    <h2>Kết quả học tập</h2>
</div>

<div class="page-content page-score">

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Tên lớp</th>
                    <th>Niên khoá</th>
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
                            <td><?php echo $class['schoolYear'] . " - " . $class["schoolYearEnd"] ?></td>
                            <td><?php echo $class['qlt'] ?></td>
                            <td>
                                <a href="./index.php?page=score_class&id=<?php echo $class['classId'] ?>">
                                    <span class="icon">
                                        <i class="fal fa-eye"></i>
                                    </span>
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