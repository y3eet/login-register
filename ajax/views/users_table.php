<?php
include("../../database.php");
include("../../session.php");


$current_user = get_session();
if ($current_user["role"] !== 'admin') {
    header("Location: ../../unauthorized.php");
}

// table that will be rendered
$result = $conn->query("SELECT * FROM users");
echo '<tr>
        <th>ID</th>
        <th>Username</th>
        <th>Role</th>
        <th>Date Created</th>
        <th>Action</th>
    </tr>';

while ($user = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $user["id"] . "</td>";
    echo "<td>" . $user["username"] . "</td>";
    echo "<td>" . $user["role"] . "</td>";
    echo "<td>" . $user["created_at"] . "</td>";
    echo '<td><button class="edit-btn" data-id="' . $user["id"] .
        '" data-username="' . $user["username"] . '" data-role="' . $user["role"] . '">Edit</button></td>';
    echo "</tr>";
}
