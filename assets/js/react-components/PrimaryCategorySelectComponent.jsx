import { Component, Fragment } from '@wordpress/element';
import { withSelect, withDispatch } from '@wordpress/data';
import apiFetch from '@wordpress/api-fetch';
import { addQueryArgs } from '@wordpress/url';
import { compose } from '@wordpress/compose';
import { __ } from '@wordpress/i18n';

class PrimaryCategorySelectComponent extends Component {
	constructor() {
		super();

		this.state = {
			terms: null,
			primaryTermId: 0,
		};
	}

	componentDidMount() {
		const termsRequest = apiFetch({
			path: addQueryArgs('/wp/v2/categories', {
				_fields: 'id,name',
				orderby: 'count',
				order: 'desc',
				per_page: 100,
			}),
		});

		termsRequest.then((termsResponse) => {
			this.setState({ terms: termsResponse });
		});

		this.setState({ primaryTermId: this.props.primaryId });
	}

	onSelectChange(event) {
		const metaObj = {};
		metaObj.evigdev_primary_category = parseInt(event.target.value, 10);
		this.props.updateMeta(metaObj);
		this.setState({ primaryTermId: event.target.value });
	}

	render() {
		const { selectedTermsIds } = this.props;

		return (
			<Fragment>
				<h4>{__('Primary Category', 'evigdev')}</h4>
				<select onChange={this.onSelectChange.bind(this)}>
					<option>
						{__('- Select Primary Category -', 'evigdev')}
					</option>
					{this.state.terms &&
						this.state.terms.map((term) => {
							if (!selectedTermsIds.includes(term.id)) {
								return '';
							}

							const selected =
								this.state.primaryTermId === term.id.toString()
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
			</Fragment>
		);
	}
}

export default compose([
	withSelect((select) => {
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
])(PrimaryCategorySelectComponent);
