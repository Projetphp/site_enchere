<?php


function my_profile_show_controller()
{
    if (!array_key_exists('form', set())) {
        set('form', params('user'));
    }
   
    $infoUser = option('db')->query(sprintf('SELECT * FROM user WHERE idUser = %s', option('db')->quote($_SESSION['user_id'])))->fetch();
    $_SESSION['infoUser'] = $infoUser;

    return render('my_profile.html.php');
}



function my_profile_action_controller()
{
    $user = params('user');

    /*-------------------------------------------------------------------------------------
    ================================ RECEPTION DES DONNEES ================================
    ________________________________________________________________________________________*/
    
    $form = $_POST['user'];

    // Nettoyage des données reçues
    foreach ($form as $key => $value)
    {
        $value      = trim($value);
        $value      = strip_tags($value);
        $form[$key] = '' != $value ? $value : null;
    }

    /*-------------------------------------------------------------------------------------
    ================================ DETECTION DES ERREURS ================================
    ________________________________________________________________________________________*/

    $errors = array();

    
    // erreur de pseudo
    if (empty($form['pseudo']) || $form['pseudo'==" " ]) {
        $form['pseudo'] = $user['pseudoUser'];
    }
    
    //erreurs de mail
    if (empty($form['email'])) {
        $form['email'] = $user['mailUser'];
    }
    $sql = 'SELECT mailUser FROM user WHERE mailUser=:verifmail';
    $query = option('db')->prepare($sql);
    $query -> bindValue(':verifmail',$form['email']);
    $query -> execute();
    $query -> fetch();
    $nbligne = $query -> rowCount();

    if ($nbligne >= 1) {//NE MARCHE PAS
        $errors[] = '<b>' . $form['email'] . '</b> is already used';
    }
    else if (false === strpos($form['email'], '@'))
    {
        $errors[] = 'Wrong email';
    }

    //erreurs de prénom
    if (empty($form['firstname']) || $form['firstname'==" " ]) {
        $form['firstname'] = $user['prenomUser'];
    }
    
    //erreurs de nom de famille
    if (empty($form['lastname']) || $form['lastname'==" " ]) {
        $form['lastname'] = $user['nomUser']; 
    }
    
    //erreurs de nom de société
    if (empty($form['society']) || $form['society']==" ") {
        $form['society'] = $user['societyUser'];
    }

    //erreurs d'adresse
    if (empty($form['adress']) || $form['adress'==" " ]) {
        $form['adress'] = $user['adressUser'];
    }
    
    // SI CHANGEMENT DE MOT DE PASSE
    //erreurs de password
    if (!empty($form['password'])){
        if (mb_strlen($form['password']) < 6) {
            $errors[] = 'Too short password (min. 6)';
        }
        else if ($form['password_confirmation'] != $form['password']) {
            $errors[] = 'wrong password confirmation';
        }
    }

    //formatage du nouveau password
    if ($form['password']) {
        $form['password'] = sha1($form['password'] . $user['password_salt']);
    }
    else {
        $form['password'] = $user['mdpUser'];
    }

    // MESSAGE D'ERREUR
    if ($errors)
    {
        //set('form', $form);
        set('errors', $errors);

        return my_profile_show_controller();
        redirect_to('my_profile');
    }


    /*-------------------------------------------------------------------------------------
    ============= MODIFIE LES CHAMPS DE LA TABLE USER AVEC LES DONNEES RECUEILLIS ===========
    ________________________________________________________________________________________*/


    $sql = 'UPDATE user SET prenomUser  = :firstname, nomUser = :lastname, mailUser = :email, mdpUser = :password, updatedUser = NOW(), pseudoUser  = :pseudo, societyUser = :society, adressUser  = :adress WHERE idUser = :id';
    $query = option('db')->prepare($sql);

    $query->bindValue(':firstname', $form['firstname']);
    $query->bindValue(':lastname', $form['lastname']);
    $query->bindValue(':email', $form['email']);
    $query->bindValue(':password', $form['password']);
    $query->bindValue(':pseudo', $form['pseudo']);
    $query->bindValue(':society', $form['society']);
    $query->bindValue(':adress', $form['adress']);
    $query->bindValue(':id', $_SESSION['user_id']);
    $query->execute();

    // MESSAGE DE SUCCESS
    flash('success', 'Changes saved');
    redirect_to('/my_profile');
}