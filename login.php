<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<style>
    .container {
        display: flex;
        height: 90vh;
        width: 100vw;
        align-items: center;
        justify-content: center;
    }

    .border {
        display: flex;
        flex-direction: column;
        border: 1px, solid;
        margin: 10px;
        padding: 50px;
        gap: 10px;
        border-radius: 10px;
    }

    .input {
        width: 400px;
        height: 30px;
        font-size: 15px;
    }

    .button {
        width: 400px;
        height: 30px;
    }

    .error {
        color: red;
        font-size: 14px;
    }
</style>

<body>
    <div class="container">
        <form id="login-form" method="POST">
            <div class="border">
                <h1>Login</h1>
                <label for="username">Username</label>
                <input required class="input" type="text" name="username" id="username">
                <label for="password">Password</label>
                <input required class="input" type="password" name="password" id="password">
                <input type="hidden" name="function" value="login">
                <!-- div will be rendered if ajax call has error -->
                <div id="error" class="error"></div>

                <button style="margin-top: 10px;" class="button" type="submit" name="login">
                    Login
                </button>

                <a href="register.php">Don't have an account?</a>
            </div>
        </form>
    </div>
    <script>
        $("#login-form").submit((event) => {
            event.preventDefault();

            let username = $("#username").val();
            let password = $("#password").val();

            $.ajax({
                url: 'ajax/auth.php',
                type: "POST",
                data: $("#login-form").serialize(),

            }).done((response) => {
                console.log(response);
                if (response.success) {
                    window.location.href = response.redirect;
                } else {
                    $("#error").html(`<strong>${response.message}</strong>`);
                }
            }).fail((response) => {
                $("#error").html(`<strong>Server Error, Please Try Again Later</strong>`);
            })
        });
    </script>
</body>

</html>