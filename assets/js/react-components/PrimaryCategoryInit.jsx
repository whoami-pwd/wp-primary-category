import { Component, Fragment } from '@wordpress/element';
import PrimaryCategorySelectComponent from './PrimaryCategorySelectComponent';

class PrimaryCategoryInit extends Component {
	constructor() {
		super();

		this.state = {
			hasError: false,
			error: null,
		};
	}

	static getDerivedStateFromError(error) {
		return {
			hasError: true,
			error,
		};
	}

	render() {
		const { TaxonomyComponent } = this.props;

		if (this.state.hasError) {
			return <TaxonomyComponent {...this.props} />;
		}

		return (
			<Fragment>
				<TaxonomyComponent {...this.props} />
				<PrimaryCategorySelectComponent
					primaryTaxonomy={'category'}
					primaryId={EvigDev.evigdev_primary_category ?? 0}
				/>
			</Fragment>
		);
	}
}

export default PrimaryCategoryInit;
