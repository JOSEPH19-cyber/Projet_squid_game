<?php

/* Initialiser la session */
function init_session() : bool
{
    if(!session_id())
    {
        session_start();
        session_regenerate_id(true); 
        return true;
    }

    return false;
}

/* Détruire la session */
function clean_session() : void
{
    session_unset();
    session_destroy();
}

/* Vérifier si l'utilisateur est connecté */
function is_logged() : bool
{
    return isset($_SESSION['user_id']);
}

/* Vérifier si l'utilisateur est administrateur */
function is_admin() : bool
{
    return is_logged() && isset($_SESSION['rank']) && $_SESSION['rank'] == 1;
}

/* Rediriger si l'utilisateur n'est pas connecté */
function redirect_if_not_logged(string $url) : void
{
    if(!is_logged())
    {
        header("Location: $url");
        exit;
    }
}

/* Récupérer le nom de l'utilisateur */
function get_user_name() : ?string
{
    return $_SESSION['user_name'] ?? null;
}

/* Récupérer l'ID de l'utilisateur */
function get_user_id() : ?int
{
    return $_SESSION['user_id'] ?? null;
}
