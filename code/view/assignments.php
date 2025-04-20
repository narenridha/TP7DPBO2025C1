<h2 style="color:#d32f2f;"><i>🏎️ F1 Skill Assignments</i></h2>
<form method="GET" style="margin-bottom: 20px; font-family:'Segoe UI', sans-serif;">
    <input type="hidden" name="page" value="assignments">
    <input type="text" name="search" placeholder="🔍 Search Teacher Name..." value="<?= $_GET['search'] ?? '' ?>" style="padding:8px; width: 250px;">
    <button type="submit" style="padding:8px 15px; background-color:#1976d2; color:white; border:none; border-radius:5px; cursor:pointer;">Search</button>
</form>
<table style="width:100%; border-collapse: collapse; font-family: 'Segoe UI', sans-serif; background-color:#f9f9f9; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin-bottom: 30px;">
    <thead style="background-color:#212121; color:#ffffff;">
        <tr>
            <th style="padding:10px;">#</th>
            <th style="padding:10px;">Teacher</th>
            <th style="padding:10px;">Team Member</th>
            <th style="padding:10px;">Assignment Date</th>
            <th style="padding:10px;">Completion Date</th>
            <th style="padding:10px;">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $search = $_GET['search'] ?? null;
            $i=1;
            foreach ($assignment->getAllAssignments($search) as $a):
                ?>
        <tr style="text-align:center;">
            <td style="padding:10px;"><?= $i?></td>
            <td style="padding:10px;"><?= $a['teacher_name'] ?></td>
            <td style="padding:10px;"><?= $a['member_name'] ?></td>
            <td style="padding:10px;"><?= $a['assignment_date'] ?></td>
            <td style="padding:10px;">
                <?= $a['completion_date'] ?? '<span style="color: red;">🏁 Not Completed</span>' ?>
            </td>
            <td style="padding:10px;">
                <?php if (!$a['completion_date']): ?>
                    <a href="?page=assignments&complete=<?= $a['id'] ?>" style="color:#388e3c; text-decoration: none;">✔️ Complete</a>
                    <?php else: ?>
                        <span style="color:#aaa;">Completed</span>
                        <?php endif; ?>
                        | <a href="?page=assignments&delete=<?= $a['id'] ?>" style="color:#d32f2f; text-decoration: none;">🗑️ Delete</a>
                    </td>
                </tr>
                 
        <?php $i++;endforeach; ?>
    </tbody>
</table>

<h2 style="color:#1976d2;"><i>📥 Start an Assignment</i></h2>
<form method="POST" style="font-family:'Segoe UI', sans-serif;">
    <label style="margin-right:10px;">Select Teacher:</label>
    <select name="teacher_id" style="padding:5px; margin-right:20px;">
        <?php foreach ($teacher->getAllTeachers() as $t): ?>
            <option value="<?= $t['id'] ?>"><?= $t['name'] ?></option>
        <?php endforeach; ?>
    </select>

    <label style="margin-right:10px;">Team Member:</label>
    <select name="member_id" style="padding:5px; margin-right:20px;">
        <?php foreach ($member->getAllMembers() as $tm): ?>
            <option value="<?= $tm['id'] ?>"><?= $tm['name'] ?> (<?= $tm['role'] ?>)</option>
        <?php endforeach; ?>
    </select>

    <button type="submit" name="start" style="background-color:#d32f2f; color:white; padding:8px 15px; border:none; border-radius:5px; cursor:pointer;">Start</button>
</form>
