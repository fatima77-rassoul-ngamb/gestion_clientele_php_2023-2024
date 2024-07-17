<!DOCTYPE html>
<html>
<head>
    <title>Historique des Modifications</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: burlywood;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Historique des Modifications pour le Client ID: <?php echo htmlspecialchars($_GET['id']); ?></h1>
        <a href="/gestion_clientele/public/index.php" class="btn btn-primary mb-4">Retour à la liste des clients</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Action</th>
                    <th>Détails</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($history)): ?>
                    <?php foreach ($history as $entry): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($entry['action']); ?></td>
                            <td><?php echo htmlspecialchars($entry['details']); ?></td>
                            <td><?php echo htmlspecialchars($entry['created_at']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center">Aucune modification trouvée.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
