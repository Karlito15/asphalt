document.body.addEventListener('htmx:afterRequest', function(evt) {
    let title = 'Inventory';
    let response = evt.detail.xhr.responseText;
    let status = evt.detail.xhr.status;
    let option = {};

    // 1. The requirement to show the sweet alert is that the element has a confirm-with-sweet-alert attribute on it,
    // if it doesn't we can return early and let the default behavior happen
    if (!evt.detail.target.hasAttribute('id')) return

    // 2. Get the question from the attribute
    const id = evt.detail.target.getAttribute('id');

    // 3. Prevent the default behavior (this will prevent the request from being issued)
    evt.preventDefault();

    // 4. Show the sweet alert
    if (status === 200) {
        option = {
            animation: true,
            icon: 'success',
            position: "top-end",
            showCancelButton: false,
            showCloseButton: false,
            showConfirmButton: false,
            showDenyButton: false,
            text: response,
            theme: 'dark',
            timer: 3000,
            timerProgressBar: true,
            title: title,
            toast: true,
            topLayer: true,
            width: '33%',
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        }
    } else {
        option = {
            animation: true,
            icon: 'error',
            position: "top-end",
            showCancelButton: false,
            showCloseButton: false,
            showConfirmButton: false,
            showDenyButton: false,
            text: response,
            theme: 'dark',
            timer: 3000,
            timerProgressBar: true,
            title: title,
            toast: true,
            topLayer: true,
            width: '33%',
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        }
    }

    Swal.fire(option);
});
