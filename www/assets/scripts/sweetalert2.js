/**
 * Sweet Alert
 */
import Swal from 'sweetalert2';

const Toast = Swal.mixin({
    toast: true,
    draggable:              false,
    position:               'center',
    theme:                  'dark',
    closeButtonAriaLabel:   'Close this dialog',
    closeButtonHtml:        '&times;',
    denyButtonText:         "Don't save",
    showCancelButton:       true,
    showCloseButton:        true,
    showConfirmButton:      true,
    showDenyButton:         true,
    timer:                  10000,
    timerProgressBar:       true,
});

Toast.fire({
    icon: "success",
    title: "Database",
    template: "#my-template",
});
