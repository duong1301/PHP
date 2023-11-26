<?php
    const classQueryStmt = "CALL proc_class_getAll";
    $classes = mysqli_query($conn, classQueryStmt);
    while(mysqli_next_result($conn)){;}
?>


<div class="page-title">
    <h2>Danh sách lớp học</h2>
</div>

<div class="">
   
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Tên lớp</th>
                    <th>Niên khoá</th>
                    <th>Sĩ số</th>
                    <th></th>
                 
                </tr>
            </thead>
            <tbody>
                <?php 
                    if($classes){
                        while($class = mysqli_fetch_array($classes)){
                ?>
                    <tr>
                        <td><?php echo $class['name']?></td>
                        <td><?php echo $class['schoolYear']." - ".$class["schoolYearEnd"]?></td>
                        <td><?php echo $class['qlt'] ?></td>
                        <td>
                            <a href="./index.php?page=score_class&id=<?php echo $class['classId'] ?>">Xem danh sách lớp học</a>
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