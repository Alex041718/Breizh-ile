<?php
    require_once("../../../services/HousingService.php");
    require_once("../../../services/OwnerService.php");
    require_once("../../../services/TypeService.php");
    require_once("../../../services/CategoryService.php");
    require_once("../../../services/ArrangementService.php");

    if(isset($_GET['q']) && !empty($_GET['q'])) {
        $q = intval($_GET['q']);
    } else {
        $q = 1;
    }

    $housings = HousingService::GetHousingsByOffset($q*9);

    for ($i=0; $i < count($housings); $i++) {
        require_once("../HousingCard/HousingCard.php");
        require_once("../../../models/Housing.php");
        require_once("../../../models/Type.php");
        require_once("../../../models/Image.php");
        require_once("../../../models/Address.php");
        require_once("../../../models/Category.php");
        require_once("../../../models/Owner.php");
        require_once("../../../models/Gender.php");

        HousingCard::render($housings[$i]);
    }
?>
