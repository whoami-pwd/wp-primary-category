/**
 * Check if Gutenberg is active and load correspondent controller.
 */

if ('undefined' !== typeof wp && 'undefined' !== typeof wp.blocks) {
	if ('undefined' === typeof EvigDev) {
		throw new Error('Data object not loaded.');
	}
	import('./js/primary-category-gutenberg');
} else {
	console.log('Please enable gutenberg or add jQuery fallback');
}
