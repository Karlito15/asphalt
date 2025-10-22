/**
 * Sweet Alert
 *
 * @link : https://sweetalert2.github.io/
 */
import Swal from 'sweetalert';

export default class Flash extends HTMLElement {
    async connectedCallback() {
        // const type = this.getAttribute('type')
        // const message = this.getAttribute('message')
        // const Toast = Swal.mixin({
        //     // actions: false,
        //     animation: true,
        //     draggable: false,
        //     heightAuto: true,
        //     showCancelButton: false,
        //     showCloseButton: false,
        //     showConfirmButton: false,
        //     showDenyButton: false,
        //     timerProgressBar: true,
        //     toast: true,
        //     timer: 3000,
        //     cancelButtonText: 'Cancel',
        //     closeButtonAriaLabel: 'close this dialog',
        //     closeButtonHtml: '&times;',
        //     confirmButtonText: 'OK',
        //     denyButtonText: 'No',
        //     padding: '0 0 1rem',
        //     position: 'top-end',
        //     theme: 'dark',
        //
        //     width: '32rem',
        //     didOpen: (toast) => {
        //         toast.onmouseenter = Swal.stopTimer;
        //         toast.onmouseleave = Swal.resumeTimer;
        //     }
        // });

        // await Toast.fire({
        //     icon: type,
        //     title: 'Error!',
        //     text: message,
        //     template: "#my-template"
        // })

        await Swal.fire({
            position: "top-start",
            icon: "info",
            title: "sweet-alert.js",
            showConfirmButton: false,
            timer: 3000
        });
    }
}
