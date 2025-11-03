console.clear();

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

// CSS
console.info('CSS');
import '../styles/app.css';
import '../styles/fonts.css';
import '../styles/scrollbar.css';
import '../styles/theme-karlito-web.css';
import '../libraries/scroll-to-top-button/dist/jquery-backToTop.min.css';
import '../libraries/fontawesome/6.7.2/css/all.min.css';

/*
 * Bootstrap Table
 */
// console.info('Bootstrap Table');
// import './bs-table/garage.js';
// import './bs-table/mission.js';
// import './bs-table/race.js';


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


/*
 * HTMX
 */
import htmx from 'htmx.org';
window.htmx = htmx;

console.log('🎉🎉🎉');
console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
