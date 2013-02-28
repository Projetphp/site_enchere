<?php

function people_list_controller()
{
    $sql = 'SELECT * FROM people ORDER BY lastname, firstname';

    $rows = option('db')->query($sql)->fetchAll();

    set('rows', $rows);

    $subnav = array();

    foreach ($rows as $row)
    {
        $letter = mb_substr($row['lastname'], 0, 1);
        $subnav[$letter][] = $row;
    }

    set('subnav', $subnav);

    return render('people_list.html.php');
}

function people_show_controller()
{
    $sql = 'SELECT * FROM people ORDER BY lastname, firstname';

    $rows = option('db')->query($sql)->fetchAll();

    $people = null;
    $subnav = array();

    foreach ($rows as $row)
    {
        $letter = mb_substr($row['lastname'], 0, 1);
        $subnav[$letter][] = $row;

        if (preg_match('/-' . $row['id'] . '$/', params('firstname-lastname'))) {
            $people = $row;
        }
    }

    set('subnav', $subnav);
    set('people', $people);

    return render('people_show.html.php');
}

function profile_controller()
{
    $years = array();

    for ($y = 2002 ; $y <= date('Y')+1 ; $y ++) {
        $years[$y] = $y;
    }

    krsort($years);

    set('years', $years);

    if (!array_key_exists('form', set())) {
        set('form', params('user'));
    }

    return render('profile.html.php');
}

function profile_action_controller()
{
    $user = params('user');

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
    // else if () {}

    if ($_FILES['user']['error']['photo'] <> 4)
    {
        if (false === strpos($_FILES['user']['type']['photo'], 'image/')) {
            $errors[] = 'Wrong photo type';
        }
        elseif ($_FILES['user']['error']['photo'] <> 0) {
            $errors[] = 'Upload photo error detected';
        }
        else {
            $form['photo'] = $user['id'] . '.' . pathinfo($_FILES['user']['name']['photo'], PATHINFO_EXTENSION);
        }
    }

    if ($form['password'])
    {
        if (mb_strlen($form['password']) < 6) {
            $errors[] = 'Too short password (min. 6)';
        }
        else if ($form['password_confirmation'] != $form['password']) {
            $errors[] = 'wrong password confirmation';
        }
    }

    if ($errors)
    {
        set('form', $form);
        set('errors', $errors);

        return profile_controller();
    }

    // SI CHANGEMENT DE MOT DE PASSE
    if ($form['password']) {
        $form['password'] = sha1($form['password'] . $user['password_salt']);
    }
    else {
        $form['password'] = $user['password'];
    }

    // SI CHANGEMENT DE PHOTO
    if (array_key_exists('photo', $form))
    {
        // SI NOUVELLE PHOTO
        if ($form['photo']) {
            move_uploaded_file($_FILES['user']['tmp_name']['photo'], option('root_dir') . '/public/user/' . $form['photo']);
        }
        // SI SUPPRESSION DE PHOTO
        elseif (null == $form['photo']) {
            unlink(option('root_dir') . '/public/user/' . $user['photo']);
        }
    }
    else {
        $form['photo'] = $user['photo'];
    }

    $sql = 'UPDATE people SET firstname = :firstname, lastname = :lastname, class_of = :class_of, email = :email, password = :password, photo = :photo, updated_at = NOW()
            WHERE id = :id';

    $query = option('db')->prepare($sql);
    $query->bindValue(':firstname', $form['firstname']);
    $query->bindValue(':lastname', $form['lastname']);
    $query->bindValue(':class_of', $form['class_of']);
    $query->bindValue(':email', $form['email']);
    $query->bindValue(':password', $form['password']);
    $query->bindValue(':photo', $form['photo']);
    $query->bindValue(':id', $user['id']);
    $query->execute();

    // MESSAGE DE SUCCESS
    flash('success', 'Changes saved');

    redirect_to('/profile');
}
