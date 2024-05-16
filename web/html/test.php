<?php

$res = password_verify("CrepeTech2024!", '$2y$10$Jwak6WFdujs7jcqPP8anCep961zYVHhwYDy46QZEklgTVCPzUeRke');

var_dump($res);



echo($res);


$hash = password_hash("CrepeTech2024!", PASSWORD_DEFAULT);

echo $hash;

?>
