import PrimaryCategorySelectComponent from './PrimaryCategorySelectComponent';
import React from "react";
import EvigDevContext from "../evigDevContext";

const CategoryInit = (props) => {
	const {TaxonomyComponent} = props;
	const EvigDev = React.useContext(EvigDevContext);

	return (
		<>
			<TaxonomyComponent {...props} />
			<PrimaryCategorySelectComponent
				primaryTaxonomy={'category'}
				primaryId={EvigDev.evigdev_primary_category ?? 0}
			/>
		</>
	);
}

export default CategoryInit;
