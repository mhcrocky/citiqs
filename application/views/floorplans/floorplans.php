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
                $floorplanParentELement = 'floorplan_parent_' . $floorplan['id'];
                ?>
                    <div style="width:100%" id="<?php echo $floorplanParentELement; ?>">
                        <div class="row mb-5 canvas_row">
                            <h2 style="margin: 12px">
                                <?php echo $floorplan['floorplanName']; ?>
                            </h2>
                            <div class="col-md-12 mh-100" id="<?php echo $imageId; ?>">
                                <canvas id="<?php echo $canvasId; ?>" width="700" height="700"></canvas>
                            </div>
                            <p style="margin: 12px">
                                <button
                                    class="btn btn-danger"
                                    data-parent-id="<?php echo $floorplanParentELement; ?>"
                                    data-floorplan-id="<?php echo $floorplan['id']; ?>"
                                    data-name="<?php echo  $floorplan['floorplanName']; ?>"
                                    onclick="deleteFloorplan(this)"
                                >
                                    Delete floorplan
                                </button>
                                <a href="edit_floorplan/<?php echo $floorplan['id']; ?>" class="btn btn-info">Edit floorplan</a>
                            </p>
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
