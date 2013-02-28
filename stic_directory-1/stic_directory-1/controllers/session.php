<?php

function signup_controller()
{
    $years = array();

    for ($y = 2002 ; $y <= date('Y')+1 ; $y ++) {
        $years[$y] = $y;
    }

    krsort($years);

    set('years', $years);

    return render('signup.html.php');
}

function signup_action_controller()
{
    // Réception des données
    $form = $_POST['user'];

    // Nettoyage des données reçues
    foreach ($form as $key => $value)
    {
        $value      = trim($value);
        $value      = strip_tags($value);
        $form[$key] = '' != $value ? $value : null;
    }

    // Détection des erreurs
    $errors = array();

    if (empty($form['firstname'])) {
        $errors[] = 'Missing firstname';
    }

    if (empty($form['lastname'])) {
        $errors[] = 'Missing lastname';
    }

    if (empty($form['email'])) {
        $errors[] = 'Missing email';
    }
    else if (false === strpos($form['email'], '@'))
    {
        $errors[] = 'Wrong email';
    }
    // TODO: Email existe déjà dans la base ?
    /*else if (option('db')->query(sprintf('SELECT * FROM user WHERE mailUser = %s', option('db')->quote($form['mailUser'])))->rowCount()) {
        $errors[] = '<b>' . $form['email'] . '</b> is already used';
    }
*/
    if (empty($form['password'])) {
        $errors[] = 'Missing password';
    }
    else if (mb_strlen($form['password']) < 6) {
        $errors[] = 'Too short password (min. 6)';
    }
    else if ($form['password_confirmation'] != $form['password']) {
        $errors[] = 'wrong password confirmation';
    }

    if ($errors)
    {
        set('form', $form);
        set('errors', $errors);

        return signup_controller();
    }

    $salt = uniqid();
    $form['password'] = sha1($form['password'] . $salt);

    $sql = 'INSERT INTO user (nomUser, prenomUser, mailUser, mdpUser, password_salt, createdUser, updatedUser)
            VALUES ( :lastname, :firstname, :email, :password, :password_salt, NOW(), NOW())';

    $query = option('db')->prepare($sql);
    
    $query->bindValue(':lastname', $form['lastname']);
    $query->bindValue(':firstname', $form['firstname']);
    //$query->bindValue(':class_of', $form['class_of']);
    $query->bindValue(':email', $form['email']);
    $query->bindValue(':password', $form['password']);
    $query->bindValue(':password_salt', $salt);
    $query->execute();


    // AUTO LOGIN
    $_SESSION['user_id'] = option('db')->lastInsertId();
    // MESSAGE DE SUCCESS
    flash('success', 'Congrats! You successfully signed up');

    redirect_to('/');
}


function signin_controller()
{
    return render('signin.html.php');
}

function signin_action_controller()
{
    // Réception des données
    $form = $_POST['user'];

    // Nettoyage des données reçues
    foreach ($form as $key => $value)
    {
        $value      = trim($value);
        $value      = strip_tags($value);
        $form[$key] = '' != $value ? $value : null;
    }

    // Détection des erreurs
    $errors = array();

    if (empty($form['email']) || empty($form['password'])) {
        $errors[] = 'Missing credentials';
    }
    else if ($user = option('db')->query(sprintf('SELECT * FROM user WHERE mailUser = %s', option('db')->quote($form['email'])))->fetch())
    {
        if ($user['mdpUser'] != sha1($form['password'] . $user['password_salt'])) {
            $errors[] = 'Wrong credentials';
        }
    }
    else {
        $errors[] = 'Wrong credentials';
    }

    if ($errors)
    {
        set('form', $form);
        set('errors', $errors);

        return signin_controller();
    }

    $_SESSION['user_id'] = $user['idUser'];

    
    
    flash('success', 'Congrats! You successfully signed in');

    redirect_to('/');
}

function signout_action_controller()
{
    unset($_SESSION['user_id']);

    redirect_to('/');
}
