<?php
include("session.php");
$user = get_session();
if ($user["role"] !== 'user') {
    header("Location: unauthorized.php");
}
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<style>
    .container {
        display: flex;
        height: 70vh;
        width: 95vw;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    .spoiler {
        color: transparent;
        background-color: black;
        cursor: pointer;
        transition: color 0.3s ease, background-color 0.3s ease;
    }

    .spoiler:hover {
        color: inherit;
        background-color: inherit;
    }
</style>

<body data-bs-theme="dark" style="margin: 20px">
    <h1>User Page</h1>
    <form action="user.php" method="POST">
        <button type="submit" name="logout" value="logout" class="btn btn-danger">Logout</button>
    </form>
    <div class="container">
        <h1>Welcome, <?= $user["username"] ?>!</h1>
        <!-- IP Info -->
        <h3 class="mt-5">IP Info</h3>
        <span id="loading">Loading...</span>
        <ul class="list-group" id="ipList">
        </ul>
    </div>
</body>
<script>
    $(document).ready(function() {
        function displayIp() {
            $("#loading").show()
            $.ajax({
                    url: "https://log.y3eet.xyz/ip",
                    type: "GET",
                })
                .done(function(response) {
                    const ip = response.ip;
                    const isp = response.isp.isp;
                    const org = response.isp.org;
                    const country = response.location.country;
                    const city = response.location.country;
                    const state = response.location.state;
                    const timezone = response.location.timezone;
                    const html =
                        `<li class="list-group-item"><strong>IP:</strong> <span class="spoiler">${ip}</span></li>
                        <li class="list-group-item"><strong>ISP:</strong> ${isp}</li>
                        <li class="list-group-item"><strong>ORG:</strong> ${org}</li>
                        <li class="list-group-item"><strong>Country:</strong> ${country}</li>
                        <li class="list-group-item"><strong>City:</strong> ${city}</li>
                        <li class="list-group-item"><strong>State:</strong> ${state}</li>
                        <li class="list-group-item"><strong>Timezone:</strong> ${timezone}</li>
                        `
                    $("#ipList").html(html);
                    $("#loading").hide();
                })
                .fail(function(response) {
                    $("#ipList").html(`<li class="list-group-item">A second item</li>`)
                    $("#loading").hide();
                })
        }
        displayIp()
    })
</script>

</html>

<?php
if (isset($_POST["logout"])) {
    session_destroy();
    header("Location: login.php");
}
?>