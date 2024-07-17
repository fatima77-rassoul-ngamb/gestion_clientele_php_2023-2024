<!DOCTYPE html>
<html>
<head>
    <title>Liste des Clients</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: burlywood;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Liste des Clients</h1>
            <a href="../../public/index.php?action=logout" class="btn btn-danger">Déconnexion</a>
        </div>
        
        <button type="button" class="btn btn-success mb-4" data-toggle="modal" data-target="#addClientModal">
            Ajouter un client
        </button>

        <!-- Formulaire modale d'ajout de client -->
        <div class="modal fade" id="addClientModal" tabindex="-1" role="dialog" aria-labelledby="addClientModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addClientModalLabel">Ajouter un client</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="addClientForm">
                            <input type="hidden" name="action" value="create">
                            <div class="form-group">
                                <label for="nom">Nom</label>
                                <input type="text" name="nom" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="adresse">Adresse</label>
                                <input type="text" name="adresse" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="telephone">Téléphone</label>
                                <input type="text" name="telephone" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="sexe">Sexe</label>
                                <select name="sexe" class="form-control" required>
                                    <option value="M">Masculin</option>
                                    <option value="F">Féminin</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="statut">Statut</label>
                                <select name="statut" class="form-control" required>
                                    <option value="actif">Actif</option>
                                    <option value="inactif">Inactif</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <form method="GET" action="/gestion_clientele/public/index.php" class="form-inline mb-4" id="filterForm">
            <input type="hidden" name="filter" value="true">
            <div class="form-group mr-2">
                <input type="text" name="nom" id="nomFilter" placeholder="Nom" class="form-control">
            </div>
            <div class="form-group mr-2">
                <input type="text" name="adresse" id="adresseFilter" placeholder="Adresse" class="form-control">
            </div>
            <div class="form-group mr-2">
                <input type="text" name="telephone" id="telephoneFilter" placeholder="Téléphone" class="form-control">
            </div>
        </form>

        <div class="mb-4">
            <a href="/gestion_clientele/public/index.php?action=export&type=csv" class="btn btn-success">Exporter en CSV</a>
            <a href="/gestion_clientele/public/index.php?action=export&type=pdf" class="btn btn-danger">Exporter en PDF</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Adresse</th>
                        <th>Téléphone</th>
                        <th>Email</th>
                        <th>Sexe</th>
                        <th>Statut</th>
                        <th>Actions</th>
                        <?php if ($_SESSION['role_id'] == '2'): ?>
                            <th>Historique</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody id="clientTableBody">
                    <?php if (!empty($clients)): ?>
                        <?php foreach ($clients as $client): ?>
                            <tr data-id="<?php echo $client['id']; ?>">
                                <td><?php echo htmlspecialchars($client['nom']); ?></td>
                                <td><?php echo htmlspecialchars($client['adresse']); ?></td>
                                <td><?php echo htmlspecialchars($client['telephone']); ?></td>
                                <td><?php echo htmlspecialchars($client['email']); ?></td>
                                <td><?php echo htmlspecialchars($client['sexe']); ?></td>
                                <td><?php echo htmlspecialchars($client['statut']); ?></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#updateModal<?php echo $client['id']; ?>">
                                        Mettre à jour
                                    </button>

                                    <div class="modal fade" id="updateModal<?php echo $client['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel<?php echo $client['id']; ?>" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="updateModalLabel<?php echo $client['id']; ?>">Mettre à jour le client</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="updateClientForm" data-id="<?php echo $client['id']; ?>">
                                                        <input type="hidden" name="action" value="update">
                                                        <input type="hidden" name="id" value="<?php echo $client['id']; ?>">
                                                        <div class="form-group">
                                                            <label for="nom">Nom</label>
                                                            <input type="text" name="nom" value="<?php echo $client['nom']; ?>" class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="adresse">Adresse</label>
                                                            <input type="text" name="adresse" value="<?php echo $client['adresse']; ?>" class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="telephone">Téléphone</label>
                                                            <input type="text" name="telephone" value="<?php echo $client['telephone']; ?>" class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email">Email</label>
                                                            <input type="email" name="email" value="<?php echo $client['email']; ?>" class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="sexe">Sexe</label>
                                                            <select name="sexe" class="form-control" required>
                                                                <option value="M" <?php if ($client['sexe'] == 'M') echo 'selected'; ?>>Masculin</option>
                                                                <option value="F" <?php if ($client['sexe'] == 'F') echo 'selected'; ?>>Féminin</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="statut">Statut</label>
                                                            <select name="statut" class="form-control" required>
                                                                <option value="actif" <?php if ($client['statut'] == 'actif') echo 'selected'; ?>>Actif</option>
                                                                <option value="inactif" <?php if ($client['statut'] == 'inactif') echo 'selected'; ?>>Inactif</option>
                                                            </select>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-sm btn-danger deleteClientBtn" data-id="<?php echo $client['id']; ?>">Supprimer</button>
                                </td>
                                <?php if ($_SESSION['role_id'] == '2'): ?>
                                    <td>
                                        <a href="../gestion_clientele/public/index.php?action=history&id=<?php echo $client['id']; ?>" class="btn btn-sm btn-info">Historique</a>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="<?php echo ($_SESSION['role_id'] == '2') ? '8' : '7'; ?>" class="text-center">Aucun client trouvé.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php if ($page == 1) echo 'disabled'; ?>">
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php for ($i = 1; $i <= ceil($totalClients / $limit); $i++): ?>
                    <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?php if ($page == ceil($totalClients / $limit)) echo 'disabled'; ?>">
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#addClientForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '/gestion_clientele/public/index.php',
                    data: $(this).serialize(),
                    success: function(response) {
                        console.log("Réponse du serveur : ", response);
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error("Erreur AJAX : ", status, error);
                        alert('Erreur lors de l\'ajout du client.');
                    }
                });
            });

            $('.updateClientForm').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                $.ajax({
                    type: 'POST',
                    url: '/gestion_clientele/public/index.php',
                    data: form.serialize(),
                    success: function(response) {
                        console.log("Réponse du serveur : ", response);
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error("Erreur AJAX : ", status, error);
                        alert('Erreur lors de la mise à jour du client.');
                    }
                });
            });

            $('.deleteClientBtn').on('click', function() {
                if (confirm('Êtes-vous sûr de vouloir supprimer ce client ?')) {
                    const id = $(this).data('id');
                    $.ajax({
                        type: 'POST',
                        url: '../../index.php',
                        data: { action: 'delete', id: id },
                        success: function(response) {
                            console.log("Réponse du serveur : ", response);
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            console.error("Erreur AJAX : ", status, error);
                            alert('Erreur lors de la suppression du client.');
                        }
                    });
                }
            });

            $('#nomFilter, #adresseFilter, #telephoneFilter').on('keyup', function() {
                let formData = {
                    action: 'filter',
                    nom: $('#nomFilter').val(),
                    adresse: $('#adresseFilter').val(),
                    telephone: $('#telephoneFilter').val()
                };
                $.ajax({
                    type: 'POST',
                    url: '/gestion_clientele/public/index.php',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        let clientTableBody = $('#clientTableBody');
                        clientTableBody.empty();
                        if (response.length > 0) {
                            response.forEach(function(client) {
                                let row = '<tr data-id="' + client.id + '">';
                                row += '<td>' + client.nom + '</td>';
                                row += '<td>' + client.adresse + '</td>';
                                row += '<td>' + client.telephone + '</td>';
                                row += '<td>' + client.email + '</td>';
                                row += '<td>' + client.sexe + '</td>';
                                row += '<td>' + client.statut + '</td>';
                                row += '<td>';
                                row += '<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#updateModal' + client.id + '">Mettre à jour</button>';
                                row += '<button type="button" class="btn btn-sm btn-danger deleteClientBtn" data-id="' + client.id + '">Supprimer</button>';
                                row += '</td>';
                                row += '</tr>';
                                clientTableBody.append(row);
                            });
                        } else {
                            clientTableBody.append('<tr><td colspan="7" class="text-center">Aucun client trouvé.</td></tr>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Erreur AJAX : ", status, error);
                    }
                });
            });
        });
    </script>
</body>
</html>
