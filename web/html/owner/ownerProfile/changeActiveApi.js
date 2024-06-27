export function changeActiveApi(apiKey, index) {
    let formData = new FormData();
    formData.append('apiKey', apiKey);

    fetch('/owner/ownerProfile/changeActiveApi.php', {
        method: 'POST',
        body: formData
    }).then(_ => {
        let currentApiKeys = document.querySelectorAll('.content__api__keys__key')[index];

        if (currentApiKeys.querySelector('.status').classList.contains('status--online')) {
            currentApiKeys.querySelector('.status').classList.remove('status--online');
            currentApiKeys.querySelector('.status').classList.add('status--offline');
            currentApiKeys.querySelector('.description-status').innerHTML = currentApiKeys.querySelector('.description-status').innerHTML.replace('Active', 'Inactive');
        } else {
            currentApiKeys.querySelector('.status').classList.remove('status--offline');
            currentApiKeys.querySelector('.status').classList.add('status--online');
            currentApiKeys.querySelector('.description-status').innerHTML = currentApiKeys.querySelector('.description-status').innerHTML.replace('Inactive', 'Active');
        }
    })
}