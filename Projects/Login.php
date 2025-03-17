<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="LoginCSS.css">
    <title>Login</title>
</head>

<body>
    <div id="title"><a href="https://127.0.0.1/Projects/SitoPrincipale/site.php">World Street Journal</a></div><hr>
    <div id="h1"><h1>Insert Email and Password if you have an existing account</h1></div>

    <form name="Form" id="login-form" action="UserRegistered.php" method="POST">
        <div class="form-group">
            <label for="email"><strong>Email Address</strong></label> </div>
        <div><input type="email" id="email" name="email_address" placeholder required></div>

        <label id="password" for="password"><strong>Password</strong></label>
        <div><input type="password" id="" name="password" placeholder required></div>

        <div class="form-group">
            <button type="submit" id="MySubmit">Continue</button>
        </div>
        <div id="newAccount"><h1>If you are new, create an account</h1></div>
        <a href="http://127.0.0.1/Projects/Register.php" id="otherSubmit">Register</a>
    </form>
</body>
</html>