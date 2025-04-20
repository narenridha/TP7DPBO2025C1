<?php
require_once 'class/Teacher.php';
require_once 'class/Assignment.php';
require_once 'class/TeamMember.php';

$teacher = new Teacher();
$assignment = new Assignment();
$member = new TeamMember();

if (isset($_POST['start'])) {
    $assignment->assignTeacher($_POST['teacher_id'], $_POST['member_id']);
}
if (isset($_GET['complete'])) {
    $assignment->completeAssignment($_GET['complete']);
    header("Location: ?page=assignments"); // Redirect after completion
}
if (isset($_GET['delete'])) {
    $assignment->deleteAssignment($_GET['delete']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>F1 System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'view/header.php'; ?> <!-- Jika tidak ada header.php bisa diabaikan -->
    <main>
        <h2>Welcome to F1 Teachers System</h2>
        <nav>
            <a href="?page=teachers">Teachers</a> |
            <a href="?page=assignments">Assignments</a> |
            <a href="?page=teammembers">Team Members</a>
        </nav>

        <?php
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            if ($page == 'teachers') include 'view/teachers.php'; 
            elseif ($page == 'assignments') include 'view/assignments.php';
            elseif ($page == 'teammembers') include 'view/team_members.php'; 
        }
        ?>
    </main>
    <?php include 'view/footer.php'; ?> <!-- Jika tidak ada footer.php bisa diabaikan -->
</body>
</html>
