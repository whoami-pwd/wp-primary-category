import CategoryInit from './react-components/PrimaryCategoryInit';

function addPrimaryCategoryComponent(PostTaxonomiesComponent) {
	return ( props ) => {
		return (
			<CategoryInit TaxonomyComponent={PostTaxonomiesComponent}
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
