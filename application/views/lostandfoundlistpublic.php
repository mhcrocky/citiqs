<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<link href="<?php echo base_url(); ?>tiqscss/tiqscss.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>tiqscss/tiqsballoontip.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<style type="text/css">
    @import url("https://fast.fonts.net/lt/1.css?apiType=css&c=f98384f2-47d2-4642-aecf-2e7d78ccc4f4&fontids=692088");
    @font-face{
        font-family:"Century Gothic W01";
        src:url("<?php echo base_url(); ?>tiqscss/Fonts/692088/bd45538f-4200-4946-b177-02de8337032d.eot?#iefix");
        src:url("<?php echo base_url(); ?>tiqscss/Fonts/692088/bd45538f-4200-4946-b177-02de8337032d.eot?#iefix") format("eot"),url("<?php echo base_url(); ?>tiqscss/Fonts/692088/700cfd4c-3384-4654-abe1-aa1a6e8058e4.woff2") format("woff2"),url("<?php echo base_url(); ?>tiqscss/Fonts/692088/9908cdad-7524-4206-819e-4f345a666324.woff") format("woff"),url("<?php echo base_url(); ?>tiqscss/Fonts/692088/b710c26a-f1ae-4fb8-a9fe-570fd829cbf1.ttf") format("truetype");
    }
</style>
<style type="text/css">
    .thumbnail-file{
        width: 100px;
        height: 100px;
    }
    .thumbnail-file img{
        width: 100%;
        height: 100%;
        min-height: 100%;
        min-width: 100%;
        object-fit: cover;
    }
    .file_form input[type="file"], .file_form button{
        position: absolute;
        z-index: -1;
    }
</style>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <?php
                    if(!empty($userRecords))
                    {
                        foreach($userRecords as $record)
                        {}
                        $location = $record->username; }
                    else{
                        $location = "No data";
                    }

        ?>
      <h1>
        <i class="fa fa-tags"></i>  <large><?php echo $location ?></large> <small><?php echo $this->language->line("xxx-xxx",'Found items');?>
          </small>
      </h1>
    </section>

    <section class="content">
<!--        <div class="row">-->
<!--            <div class="col-xs-12 text-right">-->
<!--                <div class="form-group">-->
<!--                    <a class="btn btn-info" href="--><?php //echo base_url(); ?><!--addNewlabel"><i class="fa fa-plus"></i> Add New</a>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->


        <?php
        $this->load->helper('form');
        $error = $this->session->flashdata('error');
        if($error){
            ?>
            <div id="mydivs1">
                <div class="alert alert-danger alert-dismissable" id="mydivs">
                    <button id="mydevs" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $error; ?>
                </div>
            </div>
        <?php }
        $success = $this->session->flashdata('success');
        if($success){
            ?>
            <div class="alert alert-success alert-dismissable" id="mydivs2">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $success; ?>
            </div>
        <?php } ?>

        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo $this->language->line("xxx-xxx",'list of items');?></h3>
                    <div class="box-tools">
                        <form action="<?php echo base_url() ?>lostandfoundlistpublic" method="POST" id="searchList">
                            <div class="input-group">
                              <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder=<?php echo $this->language->line("xxx-xxx","Search");?> >
                              <div class="input-group-btn">
                                <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                              </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
<!--                        <th class="text-left">Found items</th>-->
<!--                        <th class="text-left">Claimed</th>-->
                        <th><?php echo $this->language->line("xxx-xxx",'Code');?></th>
                        <th><?php echo $this->language->line("xxx-xxx",'Image');?></th>
                        <th><?php echo $this->language->line("xxx-xxx",'Description');?></th>
                        <th><?php echo $this->language->line("xxx-xxx",'Category');?></th>
                        <th><?php echo $this->language->line("xxx-xxx",'Date found');?></th>

                    </tr>
                    <?php
                    if(!empty($userRecords))
                    {
                        foreach($userRecords as $record)
                        {
                    ?>
                    <tr>
<!--                        <td class="text-left">-->
<!--                            <a class="btn btn-sm --><?php //if ($record->lost) echo('btn-danger'); ?><!--" href="--><?php //echo base_url().'setlost/'.$record->id; ?><!----><?php //if ($record->lost) echo('/0'); else echo('/1'); ?><!--" title="lost"><img height="64" width="64" src="--><?php //if ($record->lost) echo(base_url() . 'tiqsimg/lostandfoundwhite.png'); else echo(base_url() . 'tiqsimg/lostandfoundwhite.png'); ?><!--"></a>-->
<!--                        </td>-->
<!--                        <td class="text-left">-->
<!--                            --><?php
//                            if (!empty($record->userfoundId)) {
//                                ?>
<!--                                <img height="64" width="64" src="--><?php //echo base_url(); ?><!--tiqsimg/lostandfoundgreen-3.png" title="Your item has been found by someone!">-->
<!--                                --><?php
//                            }
//                            else
//                            {
//                            ?>
<!--                                &nbsp;-->
<!--                            --><?php
//                            }
//                            ?>
<!--                        </td>-->
                        <td><?php echo $record->code ?></td>
                        <!-- Image -->
                        <td>
<!--                            --><?php //$this->load->helper("form"); ?>
<!--                            <form id="addUser_--><?php //echo $record->id; ?><!--" class="file_form" action="--><?php //echo base_url() ?><!--userLabelImageCreate" method="post" role="form" enctype='multipart/form-data' >-->
                                <label class="thumbnail-file" for="file_<?php echo $record->id; ?>">
                                    <?php if (!empty($record->image)){ ?>
                                    <img src="<?php echo base_url(); ?>uploads/LabelImages/<?php $record->userId?>-<?php $record->code;?>-<?php $record->image;?>">
                                    <?php } else { ?>
                                        <img src="<?php echo base_url(); ?>uploads/default.jpg">
                                    <?php }?>
                                </label>
<!--                                <input type="file" name="imgfile" id="file_--><?php //echo $record->id; ?><!--"  accept="image/jpg, image/jpeg, image/png"/>-->
<!--                                <input type="hidden" value="--><?php //echo $record->id; ?><!--" name="id" id="id" />-->
<!--                                <button type="submit" name="labelimage" value="Submit" >Submit</button>-->
                                <?php if (!empty($record->image)) { ?>
                                <a data-fancybox="gallery" href="<?php echo base_url(); ?>uploads/LabelImages/<?php $record->userId?>-<?php $record->code;?>-<?php $record->image;?>" _target="blank"><img height="32" width="32" src="<?php echo base_url(); ?>tiqsimg/zoomIn.png" title=<?php echo $this->language->line("xxx-xxx","Zoom");?>></a>
                                <?php } ?>
                            </form>
                        </td>
<!--                        hier hebben we een probleem, de omschrijving kan in verschillende talen zijn.....-->
                        <td><?php echo $this->language->line($record->descript,$record->descript) ?></td>
                        <td><?php echo $this->language->line($record->categoryname,$record->categoryname)  ?></td>
						<?php if($record->showdate==1){?>
							<td><?php echo date("d-m-Y", strtotime($record->createdDtm)) ?></td>
						<?php }?>

                        <td class="text-left">
                            <a href="<?php echo base_url().'claim/'.$record->code; ?>" >
                                <input style="font-family:'Century Gothic W01'; font-size:100%;" type="button" class="myButtonLightOrange" value="CLAIM" >
                            </a>
<!--                            <a class="btn btn-sm btn-info" href="--><?php //echo base_url().'claim/'.$record->code; ?><!--" title="Claim"><i class="fa fa-pencil"></i></a>-->
<!--                            <a class="btn btn-sm btn-warning deleteUser" href="#" data-userid="--><?php //echo $record->id; ?><!--" title="Delete"><i class="fa fa-trash"></i></a>-->
                        </td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                  </table>

                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "lostandfoundlistpublic/" + value);
            jQuery("#searchList").submit();
        });
        $('input[type=file]').change(function() {
            var fileID = $(this).attr('id');
            if( document.getElementById(fileID).files.length == 0 ){
                alert("no files selected");
            }
            else{
                $('#'+fileID).parent('form').submit();
            }
        });
    });
</script>

<?php
if(isset($_SESSION['error'])){
    unset($_SESSION['error']);
}
if(isset($_SESSION['success'])){
    unset($_SESSION['success']);
}
if(isset($_SESSION['message'])){
    unset($_SESSION['message']);
}
?>
