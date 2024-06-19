export function changeVisibility(housingID, index) {
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