<!DOCTYPE html>
<html>
<head>
    <title>Créer un Compte Administrateur</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Créer un Compte Administrateur</h1>
        <form action="/gestion_clientele/public/register.php" method="POST">
            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="role">Rôle</label>
                <select name="role" class="form-control" required>
                    <option value="1">Admin</option>
                    <option value="2">Superadmin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Créer un Compte</button>
        </form>
    </div>
</body>
</html>
