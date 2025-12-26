<?php
require_once __DIR__ .'/..repository/ClientRepository.php';

function menu()
{
    do {
        echo "  \t\t \t============================== \n";
        echo "  \t\t\tSYSTEME DE PAIEMENT - MENU\n";
        echo "  \t\t\t==============================\n";
        echo "  \t\t\t 1. Créer un client\n";
        echo "  \t\t\t 2. Créer une commande\n";
        echo "  \t\t\t 3. Payer une commande\n";
        echo "  \t\t\t 4. Afficher les commandes\n";
        echo "  \t\t\t 0. Quitter  \n";
        echo "\t\t ------------------------------\n";
        $ch = readline('Votre choix :');
        switch ($ch) {
            case '1':
                createClient();
                break;
            case '2':
                echo '';
                break;
            case '3':
                echo '';
                break;
            case '4':
                echo '';
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








?>