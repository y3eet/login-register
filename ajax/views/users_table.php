<?php
include("../../database.php");
include("../../session.php");

$result = $conn->query("SELECT * FROM users");
$current_username = get_session()["username"];
function disable_edit(string $username, string $current_username)
{
    return $current_username === $username ? 'disabled' : '';
}
?>
<!-- table that will be rendered -->
<thead>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Role</th>
        <th>Date Created</th>
        <th>Action</th>
    </tr>
</thead>

<tbody>
    <?php
    while ($user = $result->fetch_assoc()) {
    ?>
        <tr>
            <td><?= $user["id"]; ?></td>
            <td><?= $user["username"]; ?></td>
            <td><?= $user["role"]; ?></td>
            <td><?= $user["created_at"]; ?></td>
            <td>
                <button id="editBtn" <?= disable_edit($user["username"], $current_username) ?>
                    data-bs-toggle="modal" data-bs-target="#editUserModal"
                    class="btn btn-success" data-id="<?= $user["id"]; ?>"
                    data-username="<?= $user["username"]; ?>"
                    data-role="<?= $user["role"]; ?>">Edit</button>
            </td>
        </tr>
    <?php
    }
    ?>
</tbody>