// Récupérer la valeur du radio coché dans le groupe
const selected = document.querySelector('input[name="mode"]:checked');

if (selected) {
    if (selected.value === 'normal') {
        document.querySelector('label[for="option1"]').classList.replace('btn-primary', 'btn-secondary');
        document.querySelector('label[for="option2"]').classList.replace('btn-secondary', 'btn-primary');
        // Masquer les divs
        document.querySelectorAll('div.expert').forEach(elements => {
            elements.classList.add('d-none');
        });
    }
    if (selected.value === 'expert') {
        document.querySelector('label[for="option1"]').classList.replace('btn-secondary', 'btn-primary');
        document.querySelector('label[for="option2"]').classList.replace('btn-primary', 'btn-secondary');
        // Afficher les divs
        document.querySelectorAll('div.expert').forEach(elements => {
            elements.classList.add('d-block');
        });
    }
}

// Change la class du label
document.querySelectorAll('input[name="mode"]').forEach(radio => {
    radio.addEventListener('change', function () {
        if (this.value === 'normal') {
            // Change BTN Color
            document.querySelector('label[for="option1"]').classList.replace('btn-primary', 'btn-secondary');
            document.querySelector('label[for="option2"]').classList.replace('btn-secondary', 'btn-primary');
            // Masquer les divs
            document.querySelectorAll('div.expert').forEach(elements => {
                elements.classList.replace('d-flex', 'd-none');
            });
        }
        if (this.value === 'expert') {
            document.querySelector('label[for="option1"]').classList.replace('btn-secondary', 'btn-primary');
            document.querySelector('label[for="option2"]').classList.replace('btn-primary', 'btn-secondary');
            // Afficher les divs
            document.querySelectorAll('div.expert').forEach(elements => {
                elements.classList.replace('d-none', 'd-flex');
            });
        }
    });
});
