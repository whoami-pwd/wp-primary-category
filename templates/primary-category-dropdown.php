<?php
/**
 * Some description.
 */

use \EvigDev\PrimaryCategory\Template\Types\PrimaryCategoryDropdownTemplate as Template;

/**
 * @var array $args
 */
$title         = $args[ Template::TEMPLATE_TITLE ] ?? '';
$fieldName     = $args[ Template::TEMPLATE_FIELD_NAME ] ?? '';
$defaultOption = $args[ Template::TEMPLATE_DEFAULT_OPTION ] ?? '';
$nonce         = $args[ Template::TEMPLATE_NONCE ] ?? '';
?>

<script type="text/html" id="evigdev-primary-category-select">
	<div class="wrapper">
		<h4><?php echo esc_html( $title ); ?></h4>
		<select id="<?php echo esc_attr( $fieldName ); ?>" name="<?php echo esc_attr( $fieldName ); ?>">
			<option><?php echo esc_html( $defaultOption ); ?></option>
			<# _( data.taxonomy.terms ).each( function( term ) { #>
			<option value="{{term.id}}" <# data.taxonomy.primary === term.id ? 'selected' : '' #>>
				{{term.name}}
			</option>
			<# }); #>
		</select>
		<?php echo $nonce; ?>
	</div>
</script>
