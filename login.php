<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
        max-width: 500px;
        width: 80vw;
        display: flex;
        flex-direction: column;
        border: 2px, solid;
        margin: 10px;
        padding: 30px;
        gap: 20px;
        border-radius: 10px;
    }
</style>

<body data-bs-theme="dark">
    <div class="container">
        <form id="login-form" method="POST">
            <div class="border">
                <h1>Login</h1>
                <div>
                    <input required class="form-control" type="text" name="username" id="username" placeholder="Username">
                    <!-- div text will be rendered if ajax call has error -->
                    <div class="invalid-feedback" id="username-error"></div>
                </div>
                <div>
                    <input required class="form-control" type="password" name="password" id="password" placeholder="Password">
                    <!-- div text will be rendered if ajax call has error -->
                    <div class="invalid-feedback" id="password-error"></div>
                </div>
                <input type="hidden" name="function" value="login">
                <button class="btn btn-primary" type="submit" name="login">
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
                if (response.success) {
                    window.location.href = response.redirect;
                } else {
                    const field = response.field;
                    $(`#${field}`).addClass("is-invalid");
                    $(`#${field}-error`).text(response.message);
                }
            }).fail((response) => {
                $("#error").html(`<strong>Server Error, Please Try Again Later</strong>`);
                 //TODO: use toast
            })
        });
    </script>

</body>

</html>