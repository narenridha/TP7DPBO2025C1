<?php
// Handle Create
if (isset($_POST['add'])) {
    $teacher->addTeacher($_POST['name'], $_POST['expertise'], $_POST['code'], $_POST['category'], $_POST['availability']);
    header("Location: ?page=teachers");
    exit;
}

// Handle Update
if (isset($_POST['update'])) {
    $teacher->updateTeacher($_POST['id'], $_POST['name'], $_POST['expertise'], $_POST['code'], $_POST['category'], $_POST['availability']);
    header("Location: ?page=teachers");
    exit;
}

// Handle Delete
if (isset($_GET['delete'])) {
    $teacher->deleteTeacher($_GET['delete']);
    header("Location: ?page=teachers");
    exit;
}

// Get data if editing
$editTeacher = null;
if (isset($_GET['edit'])) {
    $editTeacher = $teacher->getTeacherById($_GET['edit']);
}
?>
<h2 style="color:#d32f2f;"><i>👨‍🏫 F1 Instructors</i></h2>
<form method="GET" style="margin-bottom: 20px; font-family:'Segoe UI', sans-serif;">
    <input type="hidden" name="page" value="teachers">
    <input type="text" name="search" placeholder="🔍 Search Teacher Name..." value="<?= $_GET['search'] ?? '' ?>" style="padding:8px; width: 250px;">
    <button type="submit" style="padding:8px 15px; background-color:#1976d2; color:white; border:none; border-radius:5px; cursor:pointer;">Search</button>
</form>

<table style="width:100%; border-collapse: collapse; font-family: 'Segoe UI', sans-serif; background-color:#f9f9f9; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin-bottom: 30px;">
    <thead style="background-color:#212121; color:#ffffff;">
        <tr>
            <th style="padding:10px;">#</th>
            <th style="padding:10px;">Name</th>
            <th style="padding:10px;">Expertise</th>
            <th style="padding:10px;">Code</th>
            <th style="padding:10px;">Category</th>
            <th style="padding:10px;">Availability (Days)</th>
            <th style="padding:10px;">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $search = $_GET['search'] ?? null;
        $i=1;
        foreach ($teacher->getAllTeachers($search) as $t): ?>
        <tr style="text-align:center;">
            <td style="padding:10px;"><?= $i?></td>
            <td style="padding:10px;"><?= $t['name'] ?></td>
            <td style="padding:10px;"><?= $t['expertise'] ?></td>
            <td style="padding:10px;"><?= $t['code'] ?></td>
            <td style="padding:10px;">
                <?php
                    switch ($t['category']) {
                        case 'Driving Skill': echo '🏁 Driving Skill'; break;
                        case 'Race Strategy': echo '📊 Race Strategy'; break;
                        case 'Engineering': echo '📐 Engineering'; break;
                        
                        default: echo $t['category'];
                    }
                ?>
            </td>
            <td style="padding:10px;"><?= $t['availability'] ?> Days</td>
            <td style="padding:10px;">
                <a href="?page=teachers&edit=<?= $t['id'] ?>" style="color:#1976d2; text-decoration:none;">✏️</a> |
                <a href="?page=teachers&delete=<?= $t['id'] ?>" style="color:#d32f2f; text-decoration:none;" onclick="return confirm('Delete this teacher?')">🗑️</a>
            </td>
        </tr>
        <?php $i++;endforeach; ?>
    </tbody>
</table>

<h2 style="color:#388e3c;"><i><?= $editTeacher ? '✏️ Edit' : '➕ Add' ?> Teacher</i></h2>

<form method="POST" style="font-family: 'Segoe UI', sans-serif; display:flex; flex-wrap:wrap; gap:10px; align-items:center;">
    <?php if ($editTeacher): ?>
        <input type="hidden" name="id" value="<?= $editTeacher['id'] ?>">
    <?php endif; ?>
    <input type="text" name="name" placeholder="Name" value="<?= $editTeacher['name'] ?? '' ?>" required style="padding:5px;">
    <input type="text" name="expertise" placeholder="Expertise" value="<?= $editTeacher['expertise'] ?? '' ?>" required style="padding:5px;">
    <input type="text" name="code" placeholder="Code" value="<?= $editTeacher['code'] ?? '' ?>" required style="padding:5px;">
    <select name="category" required style="padding:5px;">
        <option value="">-- Category --</option>
        <option value="Driving Skill" <?= (isset($editTeacher['category']) && $editTeacher['category'] == 'Driving Skill') ? 'selected' : '' ?>>🏁 Driving Skill</option>
        <option value="Race Strategy" <?= (isset($editTeacher['category']) && $editTeacher['category'] == 'Race Strategy') ? 'selected' : '' ?>>📊 Race Strategy</option>
        <option value="Engineering" <?= (isset($editTeacher['category']) && $editTeacher['category'] == 'Engineering') ? 'selected' : '' ?>>📐 Engineering</option>
    </select>
    <input type="number" name="availability" placeholder="Availability (Days)" value="<?= $editTeacher['availability'] ?? '' ?>" required style="padding:5px; width:80px;">
    <button type="submit" name="<?= $editTeacher ? 'update' : 'add' ?>" style="background-color:#d32f2f; color:white; padding:8px 15px; border:none; border-radius:5px; cursor:pointer;">
        <?= $editTeacher ? 'Update' : 'Add' ?>
    </button>
</form>
