<?php   
defined('C5_EXECUTE') or die(_("Access Denied.")); 
$nh = Loader::helper('navigation');
?>

<script type="text/javascript">

( function($) {	      
	$(document).ready( function() {

		$("#owl-slider<?php  echo $bID; ?>").owlCarousel({
			<?php if ($items > 1) { echo 'items : '. $items .','; } else { echo 'singleItem : true,'; } ?>
			<?php if ($itemsScaleUp) { echo 'itemsScaleUp : true,'; } ?>
			<?php if ($slideSpeed <> 200) { echo 'slideSpeed : ' .$slideSpeed .','; } ?>
			<?php if ($paginationSpeed <> 800) { echo 'paginationSpeed : ' .$paginationSpeed .','; } ?>
			<?php if ($autoPlay) { echo 'autoPlay : '. $autoPlay .','; } ?>
			<?php if ($stopOnHover) { echo 'stopOnHover : true,'; } ?>
			<?php if ($navigation) { echo 'navigation : true,'; } ?>
			<?php if ($navigationText) { $navigationText = unserialize($navigationText); echo 'navigationText : ["'. $navigationText[0] .'","'. $navigationText[1] .'"],'; } ?>
			<?php if ($scrollPerPage) { echo 'scrollPerPage : true,'; } ?>
			<?php if (!$pagination) { echo 'pagination : false,'; } ?>
			<?php if ($paginationNumbers) { echo 'paginationNumbers : true,'; } ?>
			<?php if ($theme) { echo 'theme : "'. $themes[$theme] .'"'; } ?>
			<?php if ($lazyLoad) { echo 'lazyLoad : true,'; } ?>
			<?php if ($autoHeight) { echo 'autoHeight : true,'; } ?>		
			<?php if ($transitionStyle != "false") { echo 'transitionStyle : "'. $transitionStyle .'",'; } ?>
		});		
	} );
} ) ( jQuery );

</script>

<div id="owl-slider<?php  echo $bID; ?>" class="owl-carousel">
	<?php
	$page = Page::getCurrentPage();   
	foreach($images as $slide) { 
		$f = File::getByID($slide['fID']);
		$fp = new Permissions($f);
		$slide_page = Page::getByID($slide['pageID']);
		$slide_page_link = $nh->getLinkToCollection($slide_page, true);
		$slide_page_name = $slide_page->getCollectionName();

	?>
	<div class="item">
		<?php if ($lazyLoad) : ?>		
		<img src="<?php  echo $f->getRelativePath()?>" alt="<?php echo $slide['itemTitle'] .' '. $page->getCollectionName(); ?>" />
		<?php else: ?>
		<img class="lazyOwl" data-src="<?php  echo $f->getRelativePath()?>" alt="<?php echo $slide['itemTitle'] .' '. $page->getCollectionName(); ?>" />
		<?php endif; ?>
		<div>	                			
			<?php if ($slide['itemTitle']): ?><h2><?php  echo $slide['itemTitle']?></h2><?php else: ?><?php endif; ?>
			<?php if ($slide['itemDesc']): ?><p><?php  echo $slide['itemDesc']?></p><?php else: ?><?php endif; ?>
			<?php if ($slide_page): ?><a href="<?php echo $slide_page_link; ?>" class="ensavoirplus"><?php echo $slide_page_name; ?></a><?php else: ?><?php endif; ?>
		</div>		
	</div>		
	<?php
	}
	?>
                 		                		
</div>