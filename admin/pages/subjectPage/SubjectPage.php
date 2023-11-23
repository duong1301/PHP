<?php
    include("../config/connect.php");
    $query = "CALL proc_subject_getAll";
    $result = $conn->query($query);
    echo $result->num_rows;
?>

<div class="page subject">
    <div class="page-title"> 
        <h2>Quản lý môn học</h2>

    </div>

    <div class="page-content">
    <div class="toolbar">
            <a href="./index.php?page=user_edit&id=1">
                <button>Thêm nhân viên</button>
            </a>
        </div>
        <table border="1">
            <thead>
                <tr>
                    <th>Mã môn</th>
                    <th>Tên môn học</th>
                    
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <tr>
                            <td><?php echo $row["subjectCode"]?></td>
                            <td><?php echo $row["name"] ?></td>
                            <td>Sửa, xoá</td>
                        </tr>
                <?php
                    }
                }

                ?>


            </tbody>
        </table>


    </div>
</div>