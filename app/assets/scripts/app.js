console.clear();

/*
 * Stimulus
 */
import './stimulus_bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */

// CSS
console.info('CSS');
import '../styles/app.css';

/*
 * Load HTMX
 */
import htmx from 'htmx.org';
window.htmx = htmx;


/*
 * Bingo !
 */
console.log('🎉🎉🎉');
console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
