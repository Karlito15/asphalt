// console.clear();

/*
 * Stimulus
 */
import './bootstrap.js';

/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import '../styles/app.css';
import '../styles/theme-karlito-web.css';
/* StyleSheets */
// import '../styles/bootstrap/5.3.7.sass';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

/*
 * Bootstrap Table
 */
// import './bs-table-garage.js';
// import './bs-table-mission.js';
// import './bs-table-race.js';

/*
 * Sweet Alert
 */
// import Flash from './sweet-alert.js';
// console.log(Flash);
// import Swal from 'sweetalert';
// class Flash extends HTMLElement {
//     connectedCallback() {
//         Swal.fire({
//             position: "top-end",
//             icon: "info",
//             title: "sweet-alert.js",
//             text: "Vel cupiditat ullamco. Culpa qui voluptua laborum duis aliquid. Consequat ullamco consectetuer.",
//             showConfirmButton: false,
//             timer: 3000
//         });
//     }
// }
// customElements.define('app-notification', Flash);


/* HTMX */
import htmx from 'htmx.org';

window.htmx = require('htmx.org');

console.log('🎉🎉🎉');
