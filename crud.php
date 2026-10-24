<?php
function crud_read_all()
{
    if (!file_exists(DATA_LOCATION)) {
        return [];
    }

    $users = json_decode(file_get_contents(DATA_LOCATION), true);

    return is_array($users) ? $users : [];
}
function crud_find_by_email($email)
{
    foreach (crud_read_all() as $user) {
        if (strtolower($user['email']) === strtolower($email)) {
            return $user;
        }
    }

    return false;
}

function crud_create($user)
{
    $users = crud_read_all();
    $users[] = $user;

    file_put_contents(DATA_LOCATION, json_encode($users, JSON_PRETTY_PRINT));
}