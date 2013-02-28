<?php

require_once 'lib/limonade.php';

function configure()
{
    # A. Setting environment
    // $env =  $_SERVER['SERVER_NAME'] == 'localhost' ? ENV_DEVELOPMENT : ENV_PRODUCTION;
    // option('env', $env);
    // option('debug', $env == ENV_DEVELOPMENT);
    option('base_uri', '/stic_directory-1');

    # B. Initiate db connexion
    $dsn  = 'mysql:host=localhost;dbname=site_enchere';
    $user = 'root';
    $pass = 'root';

    try
    {
        $db = new PDO($dsn, $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }
    catch (Exception $e) {
        halt('Connexion failed: ' . $e); # raises an error / renders the error page and exit.
    }
    option('db', $db);

    # C. Others options
    // setlocale(LC_TIME, 'fr_FR');
    ini_set('date.timezone', 'Europe/Paris');
    ini_set('default_charset', 'UTF-8');
    ini_set('mbstring.internal_encoding', 'UTF-8');
}

function before($route)
{
    layout('layout.html.php');

    if (isset($_SESSION['user_id']))
    {
        //ramasse toute la table user pour l'utilisateur loggé
        $user = option('db')->query('SELECT * FROM user WHERE idUser = ' . ((int) $_SESSION['user_id']))->fetch();

        params('user', $user);
        set('user', $user);

        //ramasse toute la table produit pour l'utilisateur loggé
        $sql = 'SELECT * FROM produit WHERE idUser = :id AND idUser_idProduit = $:id';
        $query = option('db')->prepare($sql);
        $query -> bindValue(':id',$user["idUser"]);
        $query -> execute();
        $produit = $query->fetch();

        params('produit',$produit);
        set('produit',$produit);

        //ramasse tout les pseudo de la table user
        $sql = 'SELECT pseudoUser FROM user';
        $query = option('db')->prepare($sql);
        $query->execute();
        $pseudoUsers = $query->fetchAll();
        //var_dump($pseudoUsers);
        foreach ($pseudoUsers as $value) {
            $pseudos [] = $value; 
        }
        
        params('pseudos',$pseudos);
        set('pseudos', $pseudos);
        
    }
}

dispatch('/', 'home_controller'); // HOME




dispatch('/catalog', 'catalog_list_controller'); // CATALOGUE DE PRODUIT DU SITE
dispatch('/catalog-produit', 'product_show_controller'); // FICHE D'UN PRODUIT

dispatch('/about', 'about_controller'); // A PROPOS DE LA SOCIETE

dispatch('/signup', 'signup_controller'); // INSCRIPTION
dispatch_post('/signup_action', 'signup_action_controller'); // INSCRIPTION TRAITEMENT

dispatch('/my_product', 'my_product_show_controller'); // LISTE DE MES PRODUITS A VENDRE
dispatch_post('/my_product_action_ajout', 'my_product_action_ajout_controller'); // TRAITEMENT DE MES PRODUITS A VENDRE_
dispatch_post('/my_product_action_mail', 'my_product_action_mail_controller'); // TRAITEMENT DES MESSAGES A ENVOYER

dispatch('/my_bid', 'my_bid_show_controller'); // LISTE DES ENCHERES OU JE MISE
dispatch_post('/my_bid_action', 'my_bid_action_controller'); // INSCRIPTION TRAITEMENT

dispatch('/my_profile', 'my_profile_show_controller'); // INSCRIPTION
dispatch_post('/my_profile_action', 'my_profile_action_controller'); // INSCRIPTION TRAITEMENT

dispatch('/signin', 'signin_controller'); // IDENTIFICATION
dispatch_post('/signin_action', 'signin_action_controller'); // IDENTIFICATION TRAITEMENT


/*dispatch('/profile', 'profile_controller'); // MON PROFIL
dispatch_post('/profile_action', 'profile_action_controller'); // MON PROFIL TRAITEMENT
dispatch('/people', 'people_list_controller'); // LISTE DE PERSONNES DE L'ANNUAIRE
dispatch('/people/:firstname-lastname', 'people_show_controller'); // FICHE D'UNE PERSONNE DE L'ANNUAIRE
*/

dispatch('/signout', 'signout_action_controller'); // DECONNEXION


run();
