<?php

function erreur($err='param invalide'){
    switch ($err) {
        case 'pas connecter':
            http_response_code(401);
            break;
        case 'pas perm':
            http_response_code(403);
            break;
        default:
            http_response_code(500);
            break;
    }
}

?>