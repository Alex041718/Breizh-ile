document.addEventListener("DOMContentLoaded", function() {
    const textElement = document.getElementById('dynamic-text');
    const texts = ['Breizh\'Ile', 'Dévoués','Bretons','Bardella'];
    const typingSpeed = 100;
    const erasingSpeed = 50;
    const delayBetweenTexts = 1000;

    let textIndex = 0;
    let charIndex = 0;
    let isErasing = false;

    function type() {
        if (!isErasing && charIndex < texts[textIndex].length) {
            textElement.textContent += texts[textIndex].charAt(charIndex);
            charIndex++;
            setTimeout(type, typingSpeed);
        } else if (isErasing && charIndex > 0) {
            textElement.textContent = texts[textIndex].substring(0, charIndex - 1);
            charIndex--;
            setTimeout(type, erasingSpeed);
        } else if (!isErasing && charIndex === texts[textIndex].length) {
            setTimeout(() => {
                isErasing = true;
                setTimeout(type, erasingSpeed);
            }, delayBetweenTexts);
        } else if (isErasing && charIndex === 0) {
            isErasing = false;
            textIndex = (textIndex + 1) % texts.length;
            setTimeout(type, typingSpeed);
        }
    }

    type();
});
