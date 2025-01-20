<?php
function transitionSQL($sql)
{
    global $conn;
    try {
        $conn->begin_transaction();
        $conn->query($sql);
        $conn->commit();
        return true;
    } catch (Exception $e) {
        echo $e->getMessage();
        echo "<script>console.log('{$e->getMessage()}')</script>";
        $conn->rollback();
        return false;
    }
}

function requireRole($roleRequire) {
    global $role;
    if ($roleRequire == 'admin') {
        if ($role != 'admin') {
            header("Location: index.php");
        }
    } else if ($roleRequire == 'quanly') {
        if ($role == 'user') {
            header("Location: index.php");
        }
    }
}