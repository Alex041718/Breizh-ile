<?php
require_once '../../../services/SessionService.php';

// Gestion de la session
SessionService::system('owner', '/back/logements');

$isOwnerAuthenticated = SessionService::isOwnerAuthenticated();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation des logements</title>
    <link rel="stylesheet" href="../../style/ui.css">
    <link rel="stylesheet" href="/owner/consulter_logements/consulter_logements.css">
    <script src="https://kit.fontawesome.com/a12680d986.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/components/Toast/Toast.css">
    <link rel="stylesheet" href="/components/Button/Button.css">
</head>
<body>
    <?php
        require_once("../../components/Header/header.php");
        require_once("../../components/OwnerNavBar/ownerNavBar.php");
        require_once("../../../services/HousingService.php");
        require_once("../../../services/OwnerService.php");

        $owner = OwnerService::getOwnerById($_SESSION['user_id']);

        $housings = HousingService::getAllHousingsByOwnerID($owner->getOwnerID());
        $_SESSION["housings"] = $housings;
        
        Header::render(True, True, $isOwnerAuthenticated, '/back/logements');
        OwnerNavBar::render(1);
    ?>
    <main>
        <h3>Vos logements</h3>
        <section class="title">
            <p data-sort="title">Titre</p>
            <p data-sort="address">Adresse</p>
            <p data-sort="price">Prix TTC</p>
            <p data-sort="nbPerson">Nombre personnes</p>
            <p data-sort="date-begin">Date début</p>
            <p data-sort="date-end">Date fin</p>
            <p data-sort="status">Status</p>
            <button id="header__settings" class="filter"><i class="fa-solid fa-filter"></i></button>
        </section>
        

        <section class="housings">
            <script type="module" src="/owner/consulter_logements/consulter_logements.js"></script>
            <script >
                const container = document.querySelector(".housings")
                // const sorter = document.getElementById("sorter")
                const filter_submit = document.getElementById("filter_submit")

                let nbPerson = <?= json_encode($_POST['peopleNumber'] ?? null) ?>;
                let beginDate = <?= json_encode($_POST['startDate'] ?? null) ?>;
                let endDate = <?= json_encode($_POST['endDate'] ?? null) ?>;
                let city = <?= json_encode($_POST['searchText'] ?? null) ?>;

                let rawMinPrice = <?= json_encode($_POST['minPrice'] ?? null) ?>;
                let rawMaxPrice = <?= json_encode($_POST['maxPrice'] ?? null) ?>;

                let rawAppartement = <?= json_encode($_POST['appartement'] ?? null) ?>;
                let rawChalet = <?= json_encode($_POST['chalet'] ?? null) ?>;
                let rawMaison = <?= json_encode($_POST['maison'] ?? null) ?>;
                let rawBateau = <?= json_encode($_POST['bateau'] ?? null) ?>;
                let rawVilla = <?= json_encode($_POST['villa'] ?? null) ?>;
                let rawInsol = <?= json_encode($_POST['insol'] ?? null) ?>;

                let rawt1 = <?= json_encode($_POST['t1'] ?? null) ?>;
                let rawt2 = <?= json_encode($_POST['t2'] ?? null) ?>;
                let rawt3 = <?= json_encode($_POST['t3'] ?? null) ?>;
                let rawt4 = <?= json_encode($_POST['t4'] ?? null) ?>;
                let rawt5 = <?= json_encode($_POST['t5'] ?? null) ?>;
                let rawt6 = <?= json_encode($_POST['t6'] ?? null) ?>;

                let rawf1 = <?= json_encode($_POST['f1'] ?? null) ?>;
                let rawf2 = <?= json_encode($_POST['f2'] ?? null) ?>;
                let rawf3 = <?= json_encode($_POST['f3'] ?? null) ?>;
                let rawf4 = <?= json_encode($_POST['f4'] ?? null) ?>;
                let rawf5 = <?= json_encode($_POST['f5'] ?? null) ?>;

                let rawBaignade = <?= json_encode($_POST['baignade'] ?? null) ?>;
                let rawVoile = <?= json_encode($_POST['voile'] ?? null) ?>;
                let rawCanoe = <?= json_encode($_POST['canoe'] ?? null) ?>;
                let rawGolf = <?= json_encode($_POST['golf'] ?? null) ?>;
                let rawEquitation = <?= json_encode($_POST['equitation'] ?? null) ?>;
                let rawAccrobranche = <?= json_encode($_POST['accrobranche'] ?? null) ?>;
                let rawRandonnee = <?= json_encode($_POST['randonnee'] ?? null) ?>;

                let rawJardin = <?= json_encode($_POST['jardin'] ?? null) ?>;
                let rawBalcon = <?= json_encode($_POST['balcon'] ?? null) ?>;
                let rawTerrasse = <?= json_encode($_POST['terrasse'] ?? null) ?>;
                let rawPiscine = <?= json_encode($_POST['piscine'] ?? null) ?>;
                let rawJacuzzi = <?= json_encode($_POST['jacuzzi'] ?? null) ?>;


                if(city) city = city.split(' ')[0];

                let sort;
                let desc = 0;
                let cpt = 0

                filter_submit.addEventListener("click", function() {
                    const popupFilter = filter_submit.parentNode.parentNode;
                    popupFilter.parentNode.classList.remove("popup--open");
                    document.body.style.overflow = '';
                    showUser(cpt, sort, desc, true);
                })
                

                function showUser(cpt, sort, desc, isFirst, isVeryFirst = false) {

                    const minPrice = rawMinPrice && isVeryFirst ? rawMinPrice : document.getElementById("minInput").value;
                    const maxPrice = rawMaxPrice && isVeryFirst ? rawMaxPrice : document.getElementById("maxInput").value;
                    
                    const appartement = rawAppartement && isVeryFirst ? rawAppartement : (document.getElementById("appart").checked === true ? 1 : 0);
                    const chalet = rawChalet && isVeryFirst ? rawChalet : (document.getElementById("chalet").checked === true ? 1 : 0);
                    const maison = rawMaison && isVeryFirst ? rawMaison : (document.getElementById("maison").checked === true ? 1 : 0);
                    const bateau = rawBateau && isVeryFirst ? rawBateau : (document.getElementById("bateau").checked === true ? 1 : 0);
                    const villa = rawVilla && isVeryFirst ? rawVilla : (document.getElementById("villa").checked === true ? 1 : 0);
                    const insol = rawInsol && isVeryFirst ? rawInsol : (document.getElementById("insol").checked === true ? 1 : 0);

                    const t1 = rawt1 && isVeryFirst ? rawt1 : (document.getElementById("t1").checked === true ? 1 : 0);
                    const t2 = rawt2 && isVeryFirst ? rawt2 : (document.getElementById("t2").checked === true ? 1 : 0);
                    const t3 = rawt3 && isVeryFirst ? rawt3 : (document.getElementById("t3").checked === true ? 1 : 0);
                    const t4 = rawt4 && isVeryFirst ? rawt4 : (document.getElementById("t4").checked === true ? 1 : 0);
                    const t5 = rawt5 && isVeryFirst ? rawt5 : (document.getElementById("t5").checked === true ? 1 : 0);
                    const t6 = rawt6 && isVeryFirst ? rawt6 : (document.getElementById("t6").checked === true ? 1 : 0);

                    const f1 = rawf1 && isVeryFirst ? rawf1 : (document.getElementById("f1").checked === true ? 1 : 0);
                    const f2 = rawf2 && isVeryFirst ? rawf2 : (document.getElementById("f2").checked === true ? 1 : 0);
                    const f3 = rawf3 && isVeryFirst ? rawf3 : (document.getElementById("f3").checked === true ? 1 : 0);
                    const f4 = rawf4 && isVeryFirst ? rawf4 : (document.getElementById("f4").checked === true ? 1 : 0);
                    const f5 = rawf5 && isVeryFirst ? rawf5 : (document.getElementById("f5").checked === true ? 1 : 0);
                    
                    const baignade = rawBaignade && isVeryFirst ? rawBaignade : (document.getElementById("baignade").checked === true ? 1 : 0);
                    const voile = rawVoile && isVeryFirst ? rawVoile : (document.getElementById("voile").checked === true ? 1 : 0);
                    const canoe = rawCanoe && isVeryFirst ? rawCanoe : (document.getElementById("canoe").checked === true ? 1 : 0);
                    const golf = rawGolf && isVeryFirst ? rawGolf : (document.getElementById("golf").checked === true ? 1 : 0);
                    const equitation = rawEquitation && isVeryFirst ? rawEquitation : (document.getElementById("equitation").checked === true ? 1 : 0);
                    const accrobranche = rawAccrobranche && isVeryFirst ? rawAccrobranche : (document.getElementById("accrobranche").checked === true ? 1 : 0);
                    const randonnee = rawRandonnee && isVeryFirst ? rawRandonnee : (document.getElementById("randonnee").checked === true ? 1 : 0);
                    
                    const jardin = rawJardin && isVeryFirst ? rawJardin : (document.getElementById("jardin").checked === true ? 1 : 0);
                    const balcon = rawBalcon && isVeryFirst ? rawBalcon : (document.getElementById("balcon").checked === true ? 1 : 0);
                    const terrasse = rawTerrasse && isVeryFirst ? rawTerrasse : (document.getElementById("terrasse").checked === true ? 1 : 0);
                    const piscine = rawPiscine && isVeryFirst ? rawPiscine : (document.getElementById("piscine").checked === true ? 1 : 0);
                    const jacuzzi = rawJacuzzi && isVeryFirst ? rawJacuzzi : (document.getElementById("jacuzzi").checked === true ? 1 : 0);
                    


                    if(isFirst) cpt = 0;
                    const itemsToHide = document.querySelectorAll(".show-more");

                    itemsToHide.forEach(itemToHide => {
                        itemToHide.remove();
                    });
                    const loader = document.createElement("span");
                    loader.classList.add("loader");
                    container.appendChild(loader);

                    var xmlhttp = new XMLHttpRequest();
                    const params = `q=${cpt}&desc=${desc}&nbPerson=${nbPerson}&beginDate=${beginDate}&endDate=${endDate}&city=${city}&minPrice=${minPrice}&maxPrice=${maxPrice}&appartement=${appartement}&chalet=${chalet}&maison=${maison}&bateau=${bateau}&villa=${villa}&insol=${insol}&t1=${t1}&t2=${t2}&t3=${t3}&t4=${t4}&t5=${t5}&t6=${t6}&f1=${f1}&f2=${f2}&f3=${f3}&f4=${f4}&f5=${f5}&baignade=${baignade}&voile=${voile}&canoe=${canoe}&golf=${golf}&equitation=${equitation}&accrobranche=${accrobranche}&randonnee=${randonnee}&jardin=${jardin}&balcon=${balcon}&terrasse=${terrasse}&piscine=${piscine}&jacuzzi=${jacuzzi}&ownerID=${<?= json_encode($owner->getOwnerID()); ?>}`;

                    xmlhttp.open("POST", "/owner/consulter_logements/getHousingFilter.php", true);

                    xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

                    xmlhttp.onreadystatechange = function() {
                        if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            container.removeChild(loader)
                            if(isFirst) container.innerHTML = this.responseText;
                            else container.innerHTML += this.responseText;

                            const popups = document.querySelectorAll(".popup");

                            popups.forEach(popup => {

                                const popupBtnId = popup.dataset.btn;
                                const popupBtns = document.querySelectorAll(`[id="${popupBtnId}"]`);
                                const popupCloseBtn = popup.querySelector(".popup--close");

                                popup.addEventListener("click", function(event) {
                                    if(event.target === popup){
                                        popup.classList.remove("popup--open");
                                        document.body.style.overflow = '';
                                    } 
                                })

                                if(!popupCloseBtn) return;

                                popupCloseBtn.addEventListener("click", function closePopup() {
                                    popup.classList.remove("popup--open");
                                    document.body.style.overflow = '';
                                })

                                popupBtns.forEach(popupBtn => {
                                    popupBtn.addEventListener("click", function() {
                                        popup.classList.add("popup--open");
                                        document.body.style.overflow = "hidden";
                                    })
                                })

                            
                            });


                            const popUpVisibilityBtns = document.querySelectorAll("[id^='popUpVisibility-btn']");
                            const acceptBtn = document.querySelector("[id^='acceptButton']");

                            
                            popUpVisibilityBtns.forEach((popUpVisibilityBtn) => {

                                
                                popUpVisibilityBtn.addEventListener("click", () => {

                                    popUpVisibilityBtn.classList.add("popup--open");

                                    housingID = popUpVisibilityBtn.dataset.housingid;
                                    index = popUpVisibilityBtn.dataset.index;
                                });
                            });

                            acceptBtn.addEventListener("click", () => {
                                if (housingID === null || index === null) {
                                    Toast("Erreur lors de la modification de la visibilité", "error");
                                    return 
                                };
                                changeVisibility(housingID, index);
                                document.querySelector(".popUpVisibility").classList.remove("popup--open");
                                Toast("Visibilité modifiée avec succès", "success");
                            });

                        }
                    }

                    xmlhttp.send(params);
                    cpt++;

                }

                function changeVisibility(housingID, index) {
                    let formData = new FormData();
                    formData.append('housingID', housingID);

                    fetch('/owner/consulter_logements/changeHousingVisibility.php', {
                        method: 'POST',
                        body: formData
                    }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            let currentHousings = document.querySelectorAll('.housing')[index];

                            if (currentHousings.querySelector('.status').classList.contains('status--online')) {
                                currentHousings.querySelector('.status').classList.remove('status--online');
                                currentHousings.querySelector('.status').classList.add('status--offline');
                                currentHousings.querySelector('.description-status').innerHTML = currentHousings.querySelector('.description-status').innerHTML.replace('En ligne', 'Hors ligne');
                            } else {
                                currentHousings.querySelector('.status').classList.remove('status--offline');
                                currentHousings.querySelector('.status').classList.add('status--online');
                                currentHousings.querySelector('.description-status').innerHTML = currentHousings.querySelector('.description-status').innerHTML.replace('Hors ligne', 'En ligne');
                            }
                        }
                    })
                }
            </script>
        </section>
        <?php
            require_once("../../components/Button/Button.php");
            Button::render("add__button", "addButton", "Ajouter un logement", ButtonType::Owner, "window.location.href = '/back/creer-logement';", false, false, '<i class="fa-solid fa-plus"></i>'); 
        ?>
    </main>

    <?php
        require_once("../../components/Footer/footer.php");
        Footer::render(True);
    ?>
</body>
</html>