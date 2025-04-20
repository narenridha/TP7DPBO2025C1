<?php
// Handle Create
if (isset($_POST['add'])) {
    $member->addMember($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['role']);
    header("Location: ?page=teammembers");
    exit;
}

// Handle Update
if (isset($_POST['update'])) {
    $member->updateMember($_POST['id'], $_POST['name'], $_POST['email'], $_POST['phone'], $_POST['role']);
    header("Location: ?page=teammembers");
    exit;
}

// Handle Delete
if (isset($_GET['delete'])) {
    $member->deleteMember($_GET['delete']);
    header("Location: ?page=teammembers");
    exit;
}

// Get data if editing
$editMember = null;
if (isset($_GET['edit'])) {
    $editMember = $member->getMemberById($_GET['edit']);
}
?>
<h2 style="color:#d32f2f;"><i>👥 F1 Team Roster</i></h2>
<form method="GET" style="margin-bottom: 20px; font-family:'Segoe UI', sans-serif;">
    <input type="hidden" name="page" value="teammembers">
    <input type="text" name="search" placeholder="🔍 Search Team Member..." value="<?= $_GET['search'] ?? '' ?>" style="padding:8px; width: 250px;">
    <button type="submit" style="padding:8px 15px; background-color:#1976d2; color:white; border:none; border-radius:5px; cursor:pointer;">Search</button>
</form>

<table style="width:100%; border-collapse: collapse; font-family: 'Segoe UI', sans-serif; background-color:#fdfdfd; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin-bottom: 30px;">
    <thead style="background-color:#212121; color:#ffffff;">
        <tr>
            <th style="padding:10px;">#</th>
            <th style="padding:10px;">Name</th>
            <th style="padding:10px;">Email</th>
            <th style="padding:10px;">Phone</th>
            <th style="padding:10px;">Role</th>
            <th style="padding:10px;">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $search = $_GET['search'] ?? null;
            $i=1;
            foreach ($member->getAllMembers($search) as $m): 
        ?>
        <tr style="text-align:center;">
            <td style="padding:10px;"><?= $i ?></td>
            <td style="padding:10px;"><?= $m['name'] ?></td>
            <td style="padding:10px;"><?= $m['email'] ?></td>
            <td style="padding:10px;"><?= $m['phone'] ?></td>
            <td style="padding:10px;">
                <?php
                    switch (strtolower($m['role'])) {
                        case 'driver': echo '🏎️ Driver'; break;
                        case 'engineer': echo '🔧 Engineer'; break;
                        case 'mechanic': echo '🛠️ Mechanic'; break;
                        default: echo $m['role'];
                    }
                ?>
            </td>
            <td style="padding:10px;">
                <a href="?page=teammembers&edit=<?= $m['id'] ?>" style="color:#1976d2; text-decoration:none;">✏️ Edit</a> |
                <a href="?page=teammembers&delete=<?= $m['id'] ?>" style="color:#d32f2f; text-decoration:none;" onclick="return confirm('Delete this member?')">🗑️ Delete</a>
            </td>
        </tr>
        <?php $i++; endforeach; ?>
    </tbody>
</table>

<h2 style="color:#388e3c;"><i><?= $editMember ? '✏️ Edit' : '➕ Add' ?> Team Member</i></h2>

<form method="POST" style="font-family: 'Segoe UI', sans-serif; display:flex; flex-wrap:wrap; gap:10px; align-items:center;">
    <?php if ($editMember): ?>
        <input type="hidden" name="id" value="<?= $editMember['id'] ?>">
    <?php endif; ?>
    <input type="text" name="name" placeholder="Name" value="<?= $editMember['name'] ?? '' ?>" required style="padding:5px;">
    <input type="email" name="email" placeholder="Email" value="<?= $editMember['email'] ?? '' ?>" required style="padding:5px;">
    <input type="text" name="phone" placeholder="Phone" value="<?= $editMember['phone'] ?? '' ?>" required style="padding:5px;">
    <select name="role" required style="padding:5px;">
        <option value="">-- Role --</option>
        <option value="Driver" <?= (isset($editMember['role']) && $editMember['role'] == 'Driver') ? 'selected' : '' ?>>🏎️ Driver</option>
        <option value="Engineer" <?= (isset($editMember['role']) && $editMember['role'] == 'Engineer') ? 'selected' : '' ?>>🔧 Engineer</option>
        <option value="Mechanic" <?= (isset($editMember['role']) && $editMember['role'] == 'Mechanic') ? 'selected' : '' ?>>🛠️ Mechanic</option>
    </select>
    <button type="submit" name="<?= $editMember ? 'update' : 'add' ?>" style="background-color:#d32f2f; color:white; padding:8px 15px; border:none; border-radius:5px; cursor:pointer;">
        <?= $editMember ? 'Update' : 'Add' ?>
    </button>
</form>
