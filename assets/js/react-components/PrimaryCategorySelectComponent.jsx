import { withSelect, withDispatch } from '@wordpress/data';
import apiFetch from '@wordpress/api-fetch';
import { addQueryArgs } from '@wordpress/url';
import { compose } from '@wordpress/compose';
import { __ } from '@wordpress/i18n';

import React from 'react'; // npm install.

const PrimaryCategorySelect = (props) => {
	const { selectedTermsIds, updateMeta, primaryId } = props;

	const [primaryCategoryId, setPrimaryCategoryId] = React.useState(0);
	const [terms, setTerms] = React.useState(null);

	const onSelectChange = React.useCallback(
		(event) => {
			const metaObj = {};
			metaObj.evigdev_primary_category = parseInt(event.target.value, 10);
			updateMeta(metaObj);
			setPrimaryCategoryId( event.target.value);
		},
		[
			updateMeta,
		]
	);

	React.useEffect(
		() => {
			const termsRequest = apiFetch({
				path: addQueryArgs('/wp/v2/categories', {
					_fields: 'id,name',
					orderby: 'count',
					order: 'desc',
					per_page: 100,
				}),
			});


			termsRequest.then((termsResponse) => {
				setTerms(termsResponse);
			});

			setPrimaryCategoryId(primaryId);
		},
		[]
	);

	return (
		<>
			<h4>{__('Primary Category', 'evigdev')}</h4>
			<select onChange={onSelectChange}>
				<option>
					{__('- Select Primary Category -', 'evigdev')}
				</option>
				{terms && terms.map((term) => {
					if (!selectedTermsIds.includes(term.id)) {
						return '';
					}

					const selected =
						primaryCategoryId === term.id.toString()
							? ' selected'
							: '';

					return (
						<option
							key={term.id}
							value={term.id}
							selected={!!selected}
						>
							{term.name}
						</option>
					);
				})}
			</select>
		</>
	);
}

export default compose([
	withSelect((select) => { // Hook for withselect
		const { getEditedPostAttribute } = select('core/editor');

		return {
			selectedTermsIds: getEditedPostAttribute('categories'),
			meta: getEditedPostAttribute('meta'),
		};
	}),
	withDispatch((dispatch) => {
		const { editPost } = dispatch('core/editor');

		return {
			updateMeta(newMeta) {
				editPost({ meta: newMeta });
			},
		};
	}),
])(PrimaryCategorySelect);
