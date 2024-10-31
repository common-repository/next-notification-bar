<?php

use NextNotificationBar\Utility;

$styles = $data['styles'];
$settings = $data['settings'];

$bar_styles = [
	'display' => 'none',
	'line-height' => '1.5',
	'font-size' => '16px',
	'background' => $styles['background'],
	'color' => $styles['color'],
	'position' => 'relative',
];

if (strpos($data['position'], 'fixed') !== false) {
	$bar_styles['z-index'] = 9999999;
}

if ($data['position'] === 'fixed_top') {
	$bar_styles['position'] = 'sticky';
	$bar_styles['top'] = is_admin_bar_showing() ? '32px' : 0;
}

if ($data['position'] === 'fixed_bottom') {
	$bar_styles['position'] = 'fixed';
	$bar_styles['left'] = 0;
	$bar_styles['right'] = 0;
	$bar_styles['bottom'] = 0;
}

$bar_inner_styles = [
	'justify-content' => $data['alignment']['justifyContent'],
	'max-width' => $data['width'] . 'px',
	'min-height' => $data['height'] . 'px',
];

$content_styles = [
	'margin-right' => '16px',
];

$button_styles = [
	'display' => 'inline-block',
	'background' => $styles['buttonBackground'],
	'color' => $styles['buttonColor'],
	'padding' => '8px 16px',
	'border-radius' => '4px',
	'text-decoration' => 'none',
	'white-space' => 'nowrap',
];

$close_button_styles = [
	'position' => 'absolute',
	'top' => '50%',
	'right' => '10px',
	'margin-top' => '-10px',
	'cursor' => 'pointer',
	'opacity' => 0.5,
	'color' => '#000'
];
?>

<style>
	/** Responsive for Next Notification Bar **/
	.next-notification-bar__inner {
		display: flex;
		flex-wrap: wrap;
		align-items: center;
		margin: 0 auto;
		padding: 15px 15px;
	}

	.next-notification-bar__button {
		margin-top: 10px;
	}

	@media all and (min-width: 768px) {
		.next-notification-bar__inner {
			flex-wrap: nowrap;
			padding: 0 45px 0 15px;
		}

		.next-notification-bar__button {
			margin-top: 0;
		}
	}
</style>

<div
	class="js-nnb-bar next-notification-bar"
	data-preview="<?php echo json_encode($data['is_preview']); ?>"
	data-admin-user="<?php echo json_encode(current_user_can('manage_options')); ?>"
	style="<?php echo Utility::convert_styles($bar_styles); ?>"
>
	<div class="next-notification-bar__inner" style="<?php echo Utility::convert_styles($bar_inner_styles); ?>">
		<div style="<?php echo Utility::convert_styles($content_styles); ?>">
			<?php echo $data['content']; ?>
		</div>

		<?php if ($data['showButton']) : ?>
		<div>
			<a class="next-notification-bar__button" href="<?php echo $data['buttonLink']; ?>" style="<?php echo Utility::convert_styles($button_styles); ?>">
				<?php echo $data['buttonText']; ?>
			</a>
		</div>
		<?php endif; ?>
	</div>

	<?php if ($settings['closeButton']): ?>
	<div class="js-nnb-close-button" style="<?php echo Utility::convert_styles($close_button_styles); ?>">
		<svg width="20" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"></path></svg>
	</div>
	<?php endif; ?>
</div>
