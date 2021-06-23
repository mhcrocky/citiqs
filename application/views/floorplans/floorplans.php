<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<main class="row" style="margin:20px 20px">
    <?php if (is_null($floorplans)) { ?>
        <p>No floorplans for your object. <a href="<?php echo $this->baseUrl; ?>add_floorplan">Add</a></p>
    <?php } else { ?>
        <script>
            var floorplans = [];
        </script>

        <?php
            foreach ($floorplans as $data) {
                $floorplan = $data['floorplan'];
                $areas = $data['areas'];
                $imageId = 'floor_image_' . $floorplan['id'];
                $canvasId = 'canvas_' . $floorplan['id'];
                ?>
                    <div style="width:100%">
                        <div class="row mb-5 canvas_row">
                            <div class="col-md-12 mh-100" id="<?php echo $imageId; ?>">
                                <canvas id="<?php echo $canvasId; ?>" width="700" height="700"></canvas>
                            </div>
                        </div>
                    </div>
                    <script>
                        floorplans.push({
                            floorplanID: '<?php echo $floorplan['id']; ?>',
                            floor_name: '<?php echo $floorplan['floorplanName']; ?>',
                            areas: $.parseJSON('<?php echo json_encode($areas); ?>'),
                            canvasJSON: '<?php echo $floorplan['canvas']; ?>',
                            imageId: '<?php echo $imageId; ?>',
                            canvasId: '<?php echo $canvasId; ?>',
                        });
                    </script>
                <?php
            }
        ?>
    <?php } ?>
</main>

<?php if ($floorplans)  { ?>
    <script>
        var floorplansGlobals = (function(){
            let globals = {
                'floorplans' : floorplans,
                'floorplanObjects' : []
            }
            Object.freeze(globals);
            return globals;
        })();
    </script>
<?php } ?>
