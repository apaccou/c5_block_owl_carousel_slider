<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));
$al = Loader::helper('concrete/asset_library');
$ah = Loader::helper('concrete/interface');
$pageSelector = Loader::helper('form/page_selector');
?>

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    <li class="active"><a href="#slides" role="tab" data-toggle="tab"><?php  echo t("Ajout de Slides"); ?></a></li>
    <li><a href="#settings" role="tab" data-toggle="tab"><?php  echo t("Configuration globale"); ?></a></li>
    <li><a href="#infos" role="tab" data-toggle="tab">Infos</a></li>
</ul>

<!-- Tab panes Start -->
<div class="tab-content">
    <!-- Slides Start -->
    <div class="tab-pane active" id="slides">

        <h5 style="margin-bottom:20px;"><?php  echo t('Configure slides');?></h5>
        
        <div id="ccm-slideshowBlock-imgRows"> 
            <?php   if ($fsID <= 0) {
                foreach($images as $imgInfo){ 
                    $f = File::getByID($imgInfo['fID']);
                    $fp = new Permissions($f);
                    $imgInfo['thumbPath'] = $f->getThumbnailSRC(1);
                    $imgInfo['fileName'] = $f->getTitle();
                    if ($fp->canRead()) { 
                        $this->inc('image_row_include.php', array('imgInfo' => $imgInfo));
                    }
                }
            } ?>
        </div>
        
        <span id="ccm-slideshowBlock-chooseImg"><?php  echo $ah->button_js(t('Add Image'), 'SlideshowBlock.chooseImg()', 'left');?></span>

    </div>
    <!-- Slides End -->

    <!-- Settings Start --> 
    <div class="tab-pane" id="settings">

        <h5 style="margin-bottom:20px;"><?php  echo t('Configure slider settings');?></h5>

        <div class="form-horizontal" role="form">

            <p>This variable allows you to set the maximum amount of items displayed at a time with the widest browser width</p>
            <div class="form-group">
                <?php echo $form->label(items, items, array('class' => 'col-sm-2')); ?>
                <div class="col-sm-10">
                <?php echo $form->text('items', empty($items) ? $defaultItems : $items, array('class' => 'form-control')); ?>
                </div>
            </div>

            <p>Option to not stretch items when it is less than the supplied items.</p>
            <div class="form-group">
                <?php echo $form->label(itemsScaleUp, itemsScaleUp, array('class' => 'col-sm-2')); ?>
                <?php empty($itemsScaleUp) ? $defaultItemsScaleUp : $itemsScaleUp ; ?>
                <label class="radio-inline">
                <?php echo $form->radio(itemsScaleUp, 1, $itemsScaleUp); ?>true
                </label>
                <label class="radio-inline">
                <?php echo $form->radio(itemsScaleUp, 0, $itemsScaleUp); ?>false
                </label>
            </div>

            <p>Slide speed in milliseconds</p>
            <div class="form-group">
                <?php echo $form->label(slideSpeed, slideSpeed, array('class' => 'col-sm-2')); ?>
                <div class="col-sm-10">
                <?php echo $form->text('slideSpeed', empty($slideSpeed) ? $defaultSlideSpeed : $slideSpeed, array('class' => 'form-control')); ?>
                </div>
            </div>

            <p>Pagination speed in milliseconds</p>
            <div class="form-group">
                <?php echo $form->label(paginationSpeed, paginationSpeed, array('class' => 'col-sm-2')); ?>
                <div class="col-sm-10">
                <?php echo $form->text('paginationSpeed', empty($paginationSpeed) ? $defaultPaginationSpeed : $paginationSpeed, array('class' => 'form-control')); ?>
                </div>
            </div>

        <p>Change to any integrer for example autoPlay : 5000 to play every 5 seconds. If you set autoPlay: true default speed will be 5 seconds</p>
        <div class="form-group">
            <?php echo $form->label(autoPlay, autoPlay, array('class' => 'col-sm-2')); ?>
            <div class="col-sm-10">
            <?php echo $form->text('autoPlay', empty($autoPlay) ? $defaultAutoPlay : $autoPlay, array('class' => 'form-control')); ?>
            </div>
        </div>
        
            <p>Stop autoplay on mouse hover</p>
            <div class="form-group">
                <?php echo $form->label(stopOnHover, stopOnHover, array('class' => 'col-sm-2')); ?>
                <?php empty($stopOnHover) ? $defaultStopOnHover : $stopOnHover ; ?>
                <label class="radio-inline">
                <?php echo $form->radio(stopOnHover, 1, $stopOnHover); ?>true
                </label>
                <label class="radio-inline">
                <?php echo $form->radio(stopOnHover, 0, $stopOnHover); ?>false
                </label>
            </div>

            <p>Display "next" and "prev" buttons.</p>
            <div class="form-group">
                <?php echo $form->label(navigation, navigation, array('class' => 'col-sm-2')); ?>
                <?php empty($navigation) ? $defaultNavigation : $navigation ; ?>
                <label class="radio-inline">
                <?php echo $form->radio(navigation, 1, $navigation); ?>true
                </label>
                <label class="radio-inline">
                <?php echo $form->radio(navigation, 0, $navigation); ?>false
                </label>
            </div>

            <p>You can customize your own text for navigation. To get empty buttons use navigationText : false. Also HTML can be used here</p>        
            <?php 
            empty($navigationText) ? $navigationText = $defaultNavigationText : $navigationText = unserialize($navigationText);
            $navigationTextPrevious = $navigationText[0];
            $navigationTextNext = $navigationText[1];
            ?>
            <div class="form-group">
                <?php echo $form->label(navigationTextPrevious, 'navigationText Previous' , array('class' => 'col-sm-2')); ?>
                <div class="col-sm-10">
                <?php echo $form->text('navigationTextPrevious', $navigationTextPrevious, array('class' => 'form-control')); ?>
                </div>
            </div>
            <div class="form-group">
                <?php echo $form->label(navigationTextNext, 'navigationText Next', array('class' => 'col-sm-2')); ?>
                <div class="col-sm-10">
                <?php echo $form->text('navigationTextNext', $navigationTextNext, array('class' => 'form-control')); ?>
                </div>           
            </div>

            <p>Scroll per page not per item. This affect next/prev buttons and mouse/touch dragging.</p>
            <div class="form-group">
                <?php echo $form->label(scrollPerPage, scrollPerPage, array('class' => 'col-sm-2')); ?>
                <?php empty($scrollPerPage) ? $defaultScrollPerPage : $scrollPerPage ; ?>
                <label class="radio-inline">
                <?php echo $form->radio(scrollPerPage, 1, $scrollPerPage); ?>true
                </label>
                <label class="radio-inline">
                <?php echo $form->radio(scrollPerPage, 0, $scrollPerPage); ?>false
                </label>
            </div>

            <p>Show pagination.</p>
            <div class="form-group">
                <?php echo $form->label(pagination, pagination, array('class' => 'col-sm-2')); ?>
                <?php empty($pagination) ? $defaultPagination : $pagination ; ?>
                <label class="radio-inline">
                <?php echo $form->radio(pagination, 1, $pagination); ?>true
                </label>
                <label class="radio-inline">
                <?php echo $form->radio(pagination, 0, $pagination); ?>false
                </label>
            </div>

            <p>Show numbers inside pagination buttons</p>
            <div class="form-group">
                <?php echo $form->label(paginationNumbers, paginationNumbers, array('class' => 'col-sm-2')); ?>
                <?php empty($paginationNumbers) ? $defaultPaginationNumbers : $paginationNumbers ; ?>
                <label class="radio-inline">
                <?php echo $form->radio(paginationNumbers, 1, $paginationNumbers); ?>true
                </label>
                <label class="radio-inline">
                <?php echo $form->radio(paginationNumbers, 0, $paginationNumbers); ?>false
                </label>
            </div>

            <p>Default Owl CSS styles for navigation and buttons. Change it to match your own theme</p>
            <div class="form-group">
                <?php echo $form->label(theme, theme, array('class' => 'col-sm-2')); ?>
                <div class="col-sm-10">
                <?php echo $form->select('theme', $themes, empty($theme) ? $defaultTheme : $theme); ?>
                </div>
            </div>

            <p>Delays loading of images. Images outside of viewport won't be loaded before user scrolls to them. Great for mobile devices to speed up page loadings. IMG need special markup class="lazyOwl" and data-src="your img path".</p>            
            <div class="form-group">
                <?php echo $form->label(lazyLoad, lazyLoad, array('class' => 'col-sm-2')); ?>
                <?php empty($lazyLoad) ? $defaultLazyLoad : $lazyLoad ; ?>
                <label class="radio-inline">
                <?php echo $form->radio(lazyLoad, 1, $lazyLoad); ?>true
                </label>
                <label class="radio-inline">
                <?php echo $form->radio(lazyLoad, 0, $lazyLoad); ?>false
                </label>
            </div>           

            <p>Add height to owl-wrapper-outer so you can use different heights on slides. Use it only for one item per page setting.</p>
            <div class="form-group">
                <?php echo $form->label(autoHeight, autoHeight, array('class' => 'col-sm-2')); ?>
                <?php empty($autoHeight) ? $defaultAutoHeight : $autoHeight ; ?>
                <label class="radio-inline">
                <?php echo $form->radio(autoHeight, 1, $autoHeight); ?>true
                </label>
                <label class="radio-inline">
                <?php echo $form->radio(autoHeight, 0, $autoHeight); ?>false
                </label>
            </div>

            <p>Add CSS3 transition style. Works only with one item on screen. <a href='http://owlgraphic.com/owlcarousel/demos/transitions.html' target='_blank'>See Demo</a></p>
            <div class="form-group">
                <?php echo $form->label(transitionStyle, transitionStyle, array('class' => 'col-sm-2')); ?>       
                <div class="col-sm-10">
                <?php  echo $form->select('transitionStyle', array('false' => 'cycle', 'fade' => 'fade', 'backSlide' => 'backSlide', 'goDown' => 'goDown', 'scaleUp' => 'scaleUp'
                ), empty($transitionStyle) ? $defaulTransitionStyle : $transitionStyle); ?>
                </div>
            </div>

        <input type="hidden" name="type" value="CUSTOM">

        </div>







    </div>
    <!-- Settings End -->

    <!-- Infos End -->
    <div class="tab-pane" id="infos">        

        <h3>OWL Carousel Slider <small>par <a href="http://www.coteo.com/">COTEO</a></small></h3>
        
        <h4>Touch enabled jQuery plugin that lets you create beautiful responsive carousel slider.</h4>
        <p>
            <strong>Version utilisée</strong> : v.1.3.3<br>
            <strong>Fontionnalités</strong> :
        </p>
        <ul>
            <li>Carousel ET slideshow</li>
            <li>Tactile (Touch)</li>
            <li>Aggripable avec la souris (Grab)</li>
            <li>Responsive</li>
            <li>Transitions CSS3</li>
            <li>Possibilité d'en mettre plusieurs sur une seule page</li>
            <li>Configurable (durée d’animation, délai entre deux slides, fonctions de callback, etc).</li>
            <li>Permet de définir le nombre de slides à afficher en fonction de la largeur de son conteneur. Ainsi, vous pouvez contrôler précisément le comportement du carousel, par exemple 5 slides sur desktop, 3 slides sur tablette et 1 slide sur smartphone.</li>
            <li>Léger (24Ko)</li>
            <li>Fonctionne avec n’importe quel contenu HTML</li>
        </ul>
        <p class="demo">
            <strong>Requis</strong> : jQuery 1.7+<br>
            <strong>Compatibilité</strong> : Chrome, Safari, Firefox, Opera, IE7+, Dolphin, iPhone, iPad, Google Nexus<br>
            <strong>GitHub</strong> : <a href="https://github.com/OwlFonk/OwlCarousel">https://github.com/OwlFonk/OwlCarousel</a><br>
            <strong>Démonstration</strong> : <a href="http://owlgraphic.com/owlcarousel/">http://owlgraphic.com/owlcarousel/</a><br>
            <strong>Licence</strong> : MIT
        </p>
        <p>           
            <h4>Roadmap</h4>
            <ul>
                <li>Bouton RESET pour la configuration globale</li>
                <li>Vérifier protection des données html dans le champ Description avant insertion BDD http://fr.openclassrooms.com/forum/sujet/proteger-ses-champs-de-formulaire-71157</li>
                <li>Permettre l'insertion de slides sans images</li>
                <li>Proposer plusieurs thèmes</li>
                <li>Internationnalisation</li>
                <li>Désactivation des options "incompatibles" dans l'admin</li>
            </ul>
            <strong>New version 2.0.0-beta now available for testers</strong> : infinity scroll/circle/loop slides<br>

        </p>
    </div>
    <!-- Infos End -->
</div>
<!-- Tab panes End -->


	




        


			
      





<?php  
Loader::model('file_set');
$s1 = FileSet::getMySets();
$sets = array();
foreach ($s1 as $s){
    $sets[$s->fsID] = $s->fsName;
}
$fsInfo['fileSets'] = $sets;

if ($fsID > 0) {
	$fsInfo['fsID'] = $fsID;
	$fsInfo['duration']=$duration;
	$fsInfo['fadeDuration']=$fadeDuration;
} else {
	$fsInfo['fsID']='0';
	$fsInfo['duration']=$defaultDuration;
	$fsInfo['fadeDuration']=$defaultFadeDuration;
}
$this->inc('fileset_row_include.php', array('fsInfo' => $fsInfo)); ?> 

<div id="imgRowTemplateWrap" style="display:none">
<?php  
$imgInfo['slideshowImgId']='tempSlideshowImgId';
$imgInfo['fID']='tempFID';
$imgInfo['fileName']='tempFilename';
$imgInfo['origfileName']='tempOrigFilename';
$imgInfo['thumbPath']='tempThumbPath';
$imgInfo['duration']=$defaultDuration;
$imgInfo['fadeDuration']=$defaultFadeDuration;
$imgInfo['groupSet']=0;
$imgInfo['imgHeight']=tempHeight;
$imgInfo['url']='';
$imgInfo['class']='ccm-slideshowBlock-imgRow';
?>
<?php   $this->inc('image_row_include.php', array('imgInfo' => $imgInfo)); ?> 
</div>


