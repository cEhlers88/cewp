import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

import Edit from './edit';
import save from './save';

registerBlockType( 'create-block/starter-block', {
	title: __( 'Starter Block', 'starter-block' ),
	description: __(
		'Das hier ist so ein komischer starter.',
		'Nu hab ichs :)'
	),
	category: 'widgets',
	icon: 'smiley',
	supports: {
		// Removes support for an HTML mode.
		html: false,
	},
	edit: Edit,
	save,
} );
