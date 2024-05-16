<html lang="fr">
    <head>
        <title>Admin Connection</title>
        <link rel="stylesheet" href="../style/ui.css">
    </head>
    <body>
        <h1>Admin Connection</h1>
        <form action="/controllers/admin/adminConnectionController.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
    </body>
</html>
