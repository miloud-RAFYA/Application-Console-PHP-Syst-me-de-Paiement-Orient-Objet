<?php
require_once __DIR__ . '/repository/ClientRepository.php';
require_once __DIR__ . '/repository/CommandeRepository.php';
require_once __DIR__ . '/repository/PaiementRepository.php';
require_once __DIR__ . '/entity/paypal.php';
require_once __DIR__ . '/entity/virement.php';
require_once __DIR__ . '/entity/carteBancaire.php';


function menu()
{
    do {
        echo "┌─────────────────────────────────────────────────────────┐\n";
        echo "│ MENU PRINCIPAL                                          │\n";
        echo "├─────────────────────────────────────────────────────────┤\n";
        echo "│ 1. Créer un client                                      │\n";
        echo "│ 2. Lister les clients                                   │\n";
        echo "│ 3. Créer une commande                                   │\n";
        echo "│ 4. Lister les commandes                                 │\n";
        echo "│ 5. Créer un paiement                                    │\n";
        echo "│ 6. Traiter un paiement                                  │\n";
        echo "│ 7. Consulter le statut d'un paiement                    │\n";
        echo "│ 8. Lister tous les paiements                            │\n";
        echo "│ 0. Quitter                                              │\n";
        echo "└─────────────────────────────────────────────────────────┘\n";
        $ch = readline('Votre choix :');
        switch ($ch) {
            case '1':
                createClient();
                break;
            case '2':
                displayClient();
                break;
            case '3':
                createcommande();
                break;
            case '4':
                displayCommande();
                break;
            case '5':
                menuPaiement();
                break;
            default:
                echo '';
                break;
        }
    } while ($ch != 0);
}
menu();
function createClient()
{
    $username = readline("entre le name :");
    $email = readline("entre le email :");
    $client = new client($username, $email);
    $clientRep = new ClientRepository();
    $isInsert = $clientRep->insert($client);
    if ($isInsert) {
        echo " client est create";
    }
    return menu();
}
function displayClient()
{
    $clientRep = new ClientRepository();
    $res = $clientRep->fetchClient();
    foreach ($res as $row) {
        $client = new client($row['name'], $row['email']);
        $client->setClientId($row['id']);
        echo $client;
    }
    ;

}
function createcommande()
{
    displayClient();

    $user_id = readline("entre le nemuro de client :");
    $commandeRep = new CommendeRepository();
    $client = $commandeRep->checkId($user_id);
    $montantTotal = readline("entre le montant total  :");
    $statut = readline("entre la statut  :");
    $commande = new commande($montantTotal, $statut);
    $commande->setClient($client);

    $isInsert = $commandeRep->insert($commande);
    if ($isInsert) {
        echo " commnde est create\n";
    }
    return menu();
}
function displayCommande()
{
    $commandeRep = new CommendeRepository();
    $res = $commandeRep->fetchCommande();
    echo "\tles information des commandes\n";
    foreach ($res as $row) {
        $commande = new commande($row->montant_total, $row->statut);
        $client = $commandeRep->checkId($row->user_id);
        $commande->setId($row->id);
        $commande->setClient($client);
        echo $commande;
    }
    ;
}
function menuPaiement()
{
    displayCommande();

    $commande_id = readline("entre le nemuro de commande :");
    $paiementRep = new PaiementRepository();
    $commande = $paiementRep->checkId($commande_id);
    echo "\n\n";
    echo "┌────────────────────────────┐\n";
    echo "│ Payment  MENU              │\n";
    echo "├────────────────────────────┤\n";
    echo "│ 1. Virement                │\n";
    echo "│ 2. Carte                   │\n";
    echo "│ 3. PayPal                  │\n";
    echo "└────────────────────────────┘\n";

    $choix = readline("\n Veuillez choisir un mode de payment: ");

    match ($choix) {
        "1" => createVirement($commande),
        "2" => createCarte($commande),
        "3" => createPaypal($commande)
    };


    return menu();
}

function createVirement($commande)
{
    $montantTotal = readline("entre le montant  :");
    $statut = readline("entre la statut  :");
    $bank_name = readline("entre la bank_name  :");
    $iban = readline("entre l' iban  :");


    $paiement = new Virement($statut, $montantTotal, $bank_name, $iban);
    $paiement->setCommande($commande);

    $paiementRep = new PaiementRepository();
    $isInsert = $paiementRep->create($paiement);

    if ($isInsert) {
        echo "Paiement par virement est créé avec succès\n";
    } else {
        echo "Erreur lors de la création du paiement\n";
    }

    return menu();
}
function createCarte($commande)
{
    $montantTotal = readline("entre le montant  :");
    $statut = readline("entre la statut  :");
    $card_holder = readline("entre la card_holder  :");
    $card_type = readline("entre la card_type  :");
    $card_number_last4 = readline("entre la card_number_last4  :");


    $paiement = new CarteBancaire($statut, $montantTotal, $card_holder, $card_type, $card_number_last4);
    $paiement->setCommande($commande);

    $paiementRep = new PaiementRepository();
    $isInsert = $paiementRep->create($paiement);

    if ($isInsert) {
        echo "Paiement par virement est créé avec succès\n";
    } else {
        echo "Erreur lors de la création du paiement\n";
    }

    return menu();
}
function createPaypal($commande)
{
   $montantTotal = readline("entre le montant  :");
    $statut = readline("entre la statut  :");
    $paypal_email = readline("entre la paypal_email  :");
    $account_type = readline("entre la account_type  :");
    


    $paiement = new Paypal($statut, $montantTotal, $account_type, $paypal_email);
    $paiement->setCommande($commande);

    $paiementRep = new PaiementRepository();
    $isInsert = $paiementRep->create($paiement);

    if ($isInsert) {
        echo "Paiement par virement est créé avec succès\n";
    } else {
        echo "Erreur lors de la création du paiement\n";
    }

    return menu();
}

function displayPaiement()
{
    $paiementRep = new PaiementRepository();
    $res = $paiementRep->fetchPaiement();
    echo "\tles information des paiements\n";

    foreach ($res as $row) {
        $paiement = new Paypal($row->statut, $row->montant, $row->paypal_email, $row->account_type);
        $commande = $paiementRep->checkId($row->commande_id);
        $paiement->setId($row->id);
        $paiement->setCommande($commande);

    }
    ;
}






?>