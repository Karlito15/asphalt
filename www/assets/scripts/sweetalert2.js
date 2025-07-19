/**
 * Sweet Alert
 */
import Swal from 'sweetalert2';

export default class Flash extends HTMLElement
{
    async connectedCallback() {
        const type    = this.getAttribute('type')
        const message = this.getAttribute('message')
        const Toast = Swal.mixin({
            toast: false,
            // actions: false,
            animation: true,
            draggable: false,
            heightAuto: true,
            showCancelButton: false,
            showCloseButton: true,
            showConfirmButton: false,
            showDenyButton: false,
            timerProgressBar: true,
            timer: 3000,
            width: '32rem',
            padding: '0 0 1rem',
            // position: 'top-end',
            position: 'top-start',
            theme: 'dark',
            closeButtonHtml: '&times;',
            closeButtonAriaLabel: 'close this dialog',
            cancelButtonText: 'Cancel',
            confirmButtonText: 'OK',
            denyButtonText: 'No',
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

        await Toast.fire({
            icon: type,
            title: message,
        })
    }
}
