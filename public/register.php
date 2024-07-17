<?php
require_once __DIR__ . '/../controllers/AuthController.php';

session_start();
$authController = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if ($authController->register(['username' => $username, 'password' => $password, 'role' => $role])) {
        echo "Compte créé avec succès. <a href='login.php'>Connectez-vous ici</a>.";
    } else {
        $error = "Erreur lors de la création du compte.";
    }
}
?>

<!DOCTYPE html>
<html>
head>
    <title>Créer un Compte Administrateur</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Créer un Compte Administrateur</h1>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="register.php" method="POST">
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
