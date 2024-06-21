document.addEventListener("DOMContentLoaded", function() {
    const passwordInput = document.querySelector('#firstPasswordEntry input');
    const lengthCriteria = document.getElementById('length');
    const uppercaseCriteria = document.getElementById('uppercase');
    const lowercaseCriteria = document.getElementById('lowercase');
    const specialCriteria = document.getElementById('special');
    const containsCriteria = document.getElementById('contains');

    passwordInput.addEventListener('input', function () {
        const password = passwordInput.value;
        console.log(password);
        // Longueur
        if (password.length >= 10) {
            lengthCriteria.style.color = 'green';
        } else {
            lengthCriteria.style.color = 'red';
        }
        // Majuscule
        if (/[A-Z]/.test(password)) {
            uppercaseCriteria.style.color = 'green';
        } else {
            uppercaseCriteria.style.color = 'red';
        }
        
        // Minuscule
        if (/[a-z]/.test(password)) {
            lowercaseCriteria.style.color = 'green';
        } else {
            lowercaseCriteria.style.color = 'red';
        }
        
        // Caractère spécial
        if (/[#@\$%\^&\+=\?]/.test(password)) {
            specialCriteria.style.color = 'green';
        } else {
            specialCriteria.style.color = 'red';
        }
        // Mot de passe contient Majuscule, Minuscule, Caractère spécial
        if (/[A-Z]/.test(password) && /[a-z]/.test(password) && /[#@\$%\^&\+=\?]/.test(password)){
            containsCriteria.style.color = 'green';
        } else {
            containsCriteria.style.color = 'red';
        }
    });

    const infos = document.getElementById('infos');
    const security = document.querySelector('.content__security');

    const infosBtn = document.getElementById('infos__btn');
    const securityBtn = document.getElementById('security__btn');

    const securityForm = document.querySelector('.content__security form');
    const personalDataForm = document.querySelector('.content__personnal-data form');

    securityBtn.addEventListener("click", function() {
        toggle();
    });

    infosBtn.addEventListener("click", function() {
        toggle();
    });

    function toggle() {
        securityBtn.classList.toggle("active");
        infosBtn.classList.toggle("active");
        infos.classList.toggle('content__display');
        security.classList.toggle('content__display');
    }

    function handleFormSubmit(form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            const formData = new FormData(form);

            // Check if passwords match before submitting
            const firstPassword = formData.get('firstPasswordEntry');
            const secondPassword = formData.get('secondPasswordEntry');

            if (firstPassword !== secondPassword ) {
                Toast("Les Mot de passe sont différents.", "warning"); // Log "KO" if passwords do not match
                return; // Exit function if passwords do not match
            }

            // If passwords match, proceed with form submission
            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(() => {
                Toast("Modification terminée.", "success");
            })
            .catch(() => {
                console.log('KO'); // Log "KO" if submission failed
            });
        });
    }

    // Handle submission for security form
    handleFormSubmit(securityForm);

    // Handle submission for personal data form (if needed)
    handleFormSubmit(personalDataForm);
});
