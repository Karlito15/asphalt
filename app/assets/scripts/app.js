/*
 * Load Stimulus
 */
console.info('Load Stimulus');
import './stimulus_bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */

/*
 * JS
 */
// import '@popperjs/core';

/*
 * Load CSS
 */
console.info('Load CSS');
import '../styles/app.css';

/*
 * Load HTMX
 */
console.info('Load HTMX');
import htmx from 'htmx.org';
window.htmx = htmx;

/*
 * Load DataTable
 */
// console.info('Load DataTable');
// import './datatable-garage.js';
// import './datatable-mission.js';
// import './datatable-race.js';

/*
 * Bingo !
 */
console.log('🎉🎉🎉');
console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
