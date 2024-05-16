<?php
// pour hacher un mot de passe on utilise password_hash($password, PASSWORD_DEFAULT)
// c'est un fonction donné par php qui permet de hacher un mot de passe
// on peut aussi vérifier un mot de passe haché avec password_verify($password, $hash)
// PASSWORD_DEFAULT est une constante qui permet de choisir l'algorithme de hachage


$password = 'admin';
$hash = password_hash($password, PASSWORD_DEFAULT);
echo $hash; // le hash est différent à chaque fois mais par exemple pour admin on peut avoir : $2y$10$O.JEDin2vwFgbA3FQnKMheSSJDhaevnV3m5AXetQP6H7TeLrh9HaK

// $hash est le mot de passe haché
// si on veut vérifier un mot de passe haché
// on peut utiliser password_verify($password, $hash)
// si le mot de passe est correct, la fonction retourne true

if (password_verify($password, $hash)) {
    echo 'Mot de passe correct';
} else {
    echo 'Mot de passe incorrect';
}
?>
