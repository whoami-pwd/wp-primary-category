import PrimaryCategoryInit from './react-components/PrimaryCategoryInit';

function addPrimaryCategoryComponent(PostTaxonomiesComponent) {
	return (props) => {
		return (
			<PrimaryCategoryInit
				TaxonomyComponent={PostTaxonomiesComponent}
				{...props}
			/>
		);
	};
}

const gutenbergInit = () => {
	wp.hooks.addFilter(
		'editor.PostTaxonomyType',
		'evigdev',
		addPrimaryCategoryComponent
	);
};

gutenbergInit();
