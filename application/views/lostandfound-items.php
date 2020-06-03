<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $this->pageTitle; ?></title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/home/images/tiqsiconlogonew.png" alt="" />
        <link rel="stylesheet" type="text/css" href="assets/home/styles/main-style.css" />
        <link rel="stylesheet" type="text/css" href="assets/home/styles/how-it-works.css" />
        <link rel="stylesheet" type="text/css" href="assets/home/styles/home-page.css" />
        <link rel="stylesheet" type="text/css" href="assets/home/styles/grid.css" />
        <link rel="stylesheet" type="text/css"href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css" />
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />        
        <style>
            .grid-wrapper {
                background-color: <?php echo $datasettings->backgroundcolor; ?>;
            }
            .grid-wrapper .grid-item {
                background-color: <?php echo $datasettings->griditembackground; ?>;
                border-radius: <?php echo $datasettings->griditemborderradius; ?>px;
                border-color: <?php echo $datasettings->bordercolor; ?>;
            }
            .grid-wrapper .grid-item .grid-button {
                border-radius: <?php echo $datasettings->buttonborderradius; ?>px;
                background-color: <?php echo $datasettings->buttonbackgroundcolor; ?>;
                color: <?php echo $datasettings->buttontextcolor; ?>
            }
            .grid-wrapper .grid-item p {
                font-size: <?php echo $datasettings->textsize; ?>px;
                color: <?php echo $datasettings->textcolor; ?>;
            }
        </style>
    </head>
    <body>
        <div class="main-wrapper">
            <div class="grid-wrapper">
                <div class="grid-list">
                    <?php
                    if(!empty($userRecords))
                    {
                        foreach($userRecords as $record)
                        {
                            ?>
                            <div class="grid-item">
                                <div class="item-header">
									<?php if($record->showdate==1){?>
										<p class="item-date"><?php echo $record->createdDtm?></p>
<!--										<td>--><?php //echo date("d-m-Y", strtotime($record->createdDtm)) ?><!--</td>-->
									<?php }?>
                                    <p class="item-code"><?php echo $record->code?></p>
                                    <div class='grid-image'>
                                        <?php $sensitiveImage = File_helper::getSensitiveImage(intval($record->categoryid)); ?>
                                        <?php if ($sensitiveImage) { ?>
                                            <img src="<?php echo $sensitiveImage; ?>" alt="" />
                                        <?php } elseif (!empty($record->image)) { ?>
                                            <?php if (file_exists(FCPATH . 'uploads/LabelImagesBig/' . $record->userId . '-' . $record->code . '-' . $record->image)) { ?>
                                                <a class="image-link" href="<?php echo base_url() . 'uploads/LabelImagesBig/' . $record->userId . '-' . $record->code . '-' . $record->image; ?>" >
                                            <?php } ?>
                                            <img src="<?php echo $this->baseUrl . 'uploads/LabelImages/' . $record->userId . '-' . $record->code . '-' . $record->image; ?>" alt="" />
                                            <?php if (file_exists(FCPATH . 'uploads/LabelImagesBig/' . $record->userId . '-' . $record->code . '-' . $record->image )) { ?>
                                                </a>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <img src="<?php echo $this->baseUrl; ?>uploads/default.jpg" alt="">
                                        <?php } ?>
                                    </div>
                                    <p class='item-description'><?php echo $this->language->line($record->descript,$record->descript) ?></p>
                                    <p class='item-category'><?php echo $this->language->line($record->categoryname,$record->categoryname)  ?></p>
                                </div>
                                <div class="grid-footer">
                                    <a href="<?php echo base_url().'claim/'.$record->code; ?>" >
                                    <button class='grid-button button'>Claim</button>
                                    </a>
                                </div>
                            </div><!-- end grid item -->
                            <?php
                        }
                    }
                    ?>
                </div><!-- end grid list -->
            </div><!-- end grid wrapper -->
            
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js'></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="assets/home/js/vanilla-picker.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js" integrity="sha256-P93G0oq6PBPWTP1IR8Mz/0jHHUpaWL0aBJTKauisG7Q=" crossorigin="anonymous"></script>
    </body>
</html>

<script>
	$(document).ready(function() {
		if ($('.image-link').length > 0) {
			$('.image-link').magnificPopup({type:'image'});
		}
	});
</script>