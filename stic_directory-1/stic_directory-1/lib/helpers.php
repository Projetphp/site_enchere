<?php

function current_menu($url)
{
    if ('/' == $url)
    {
        if ('/' == request_uri()) {
            return 'active';
        }
    }
    else
    {
      if (0 === strpos(request_uri(), $url)) {
            return 'active';
        }
    }

    return '';
}

function url_for_user_photo($user)
{
    if ($user['photo']) {
        return url_for('public/user', $user['photo']);
    }

    return 'http://www.gravatar.com/avatar/' . md5($user['email']) .'?s=30';
}
