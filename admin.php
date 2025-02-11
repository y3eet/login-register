<?php
include("session.php");
include("database.php");
$user = get_session();
if ($user["role"] !== 'admin') {
    header("Location: unauthorized.php");
}
?>
<?php

function get_all_users($conn)
{
    $sql = "SELECT * FROM users";
    try {
        $res = mysqli_query($conn, $sql);
        if (mysqli_num_rows($res) > 0) {
            $rows = [];
            while ($row = mysqli_fetch_assoc($res)) {
                $rows[] = $row;
            }
            return $rows;
        }
    } catch (mysqli_sql_exception $e) {
        echo "Server Error";
    }
    return [];
}

$users = get_all_users($conn);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
</head>
<style>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        margin-top: 10px;
        max-width: 800px;
    }

    td,
    th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }
</style>

<body>
    <h1>Admin Page</h1>

    <form action="user.php" method="POST">
        <button type="submit" name="logout" value="logout">Logout</button>
    </form>

    <table>
        <tr>
            <th>Username</th>
            <th>Role</th>
        </tr>
        <?php
        foreach ($users as $user) {
            echo "<tr>";
            echo "<td>" . $user["username"] . "</td>";
            echo "<td>" . $user["role"] . "</td>";
            echo "</tr>";
        }
        ?>
        <!-- <tr>
            <td>Alfreds Futterkiste</td>
            <td>Maria Anders</td>
        </tr> -->
    </table>
</body>

</html>

<?php
if (isset($_POST["logout"])) {
    session_destroy();
    header("Location: login.php");
}
?>