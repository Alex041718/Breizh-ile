function main() {
    const housings = document.querySelector(".housings");
    const columns = document.querySelectorAll(".title p");

    const addButton = document.getElementById("addButton");

    housings.innerHTML = "Chargement...";
    
    function clearSort() {
        columns.forEach(column => {
            column.classList.remove("title--selected");
        });
    }

    function showReservations(sort="", isReverse=false) {
        let xhr = new XMLHttpRequest();
        let params = (sort === "") ? "" : `sort=${sort}&isReverse=${isReverse}`;

        xhr.open("POST", "/owner/consulter_logements/getHousing.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                housings.innerHTML = this.responseText;
            }
        };
        xhr.send(params);
    }

    columns.forEach((column) => {
        column.addEventListener("click", () => {
            let sort = column.dataset.sort;

            let isReverse = false;
            if(column.classList.contains("title--selected")) isReverse = true;
            if(column.classList.contains("title--reverse")) isReverse = false;

            clearSort();

            column.classList.add("title--selected");
            column.classList.toggle("title--reverse", isReverse);

            switch (sort) {
                case "title":
                    showReservations("getTitle", isReverse);
                    break;
                case "address":
                    showReservations("getAddress", isReverse);
                    break;
                case "price":
                    showReservations("getPriceIncl", isReverse);
                    break;
                case "nbPerson":
                    showReservations("getNbPerson", isReverse);
                    break;
                case "date-begin":
                    showReservations("getBeginDate", isReverse);
                    break;
                case "date-end":
                    showReservations("getEndDate", isReverse);
                    break;
                case "status":
                    showReservations("getIsOnline", isReverse);
                    break;
                default:
                    showReservations();
                    break;
            }
        });
    });

    showReservations();
}

document.addEventListener("DOMContentLoaded", () => {
    main();
});