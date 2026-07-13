// Change la class du label
document.querySelectorAll('input[name="mode"]').forEach(radio => {
    radio.addEventListener('change', function () {
        if (this.value === 'light') {
            // Masquer les divs
            document.querySelectorAll('div#light').forEach(elements => {
                elements.classList.replace('d-block', 'd-none');
            });
        }
        if (this.value === 'full') {
            // Afficher les divs
            document.querySelectorAll('div#light').forEach(elements => {
                elements.classList.replace('d-none', 'd-block');
            });
        }
    });
});
