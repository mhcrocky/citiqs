<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<main class="container" style="margin-top:20px">
    <div class="row">
        <div class="col-lg-6">
            <form method="post" id="<?php echo $id; ?>" onsubmit="return saveDesign(this)">
                <fieldset id="selectTypeView" class="hideFieldsets">
                    <legend>Select type view</legend>
                    <div class="form-group col-sm-12">
                        <label>
                            Background color:
                            <input
                                type="color"
                                class="form-control"
                                name="selectType[id][selectTypeBody][background-color]"
                                data-css-selector="id"
                                data-css-selector-value="selectTypeBody"
                                data-css-property="background-color"
                                onfocus="styleELements(this)"
                                oninput="styleELements(this)"
                                <?php if ( isset($design['selectType']['id']['selectTypeBody']['background-color']) ) { ?>
                                value = "<?php echo $design['selectType']['id']['selectTypeBody']['background-color']?>"
                                data-value="1"
                                <?php } ?>
                            />
                        </label>
                    </div>
                    <div class="form-group col-sm-12">
                        <label>
                            Headline font color:
                            <input
                                type="color"
                                class="form-control"
                                name="selectType[id][selectTypeH1][color]"
                                data-css-selector="id"
                                data-css-selector-value="selectTypeH1"
                                data-css-property="color"
                                onfocus="styleELements(this)"
                                oninput="styleELements(this)"
                                <?php if ( isset($design['selectType']['id']['selectTypeH1']['color']) ) { ?>
                                value = "<?php echo $design['selectType']['id']['selectTypeH1']['color']?>"
                                data-value="1"
                                <?php } ?>
                            />
                        </label>
                    </div>
                    <div class="form-group col-sm-12">
                        <label>
                            Headline backgorund color:
                            <input
                                type="color"
                                class="form-control"
                                name="selectType[id][selectTypeH1][background-color]"
                                data-css-selector="id"
                                data-css-selector-value="selectTypeH1"
                                data-css-property="background-color"
                                onfocus="styleELements(this)"
                                oninput="styleELements(this)"
                                <?php if ( isset($design['selectType']['id']['selectTypeH1']['background-color']) ) { ?>
                                value = "<?php echo $design['selectType']['id']['selectTypeH1']['background-color']?>"
                                data-value="1"
                                <?php } ?>
                            />
                        </label>
                    </div>
                    <div class="form-group col-sm-12">
                        <label>
                            Types background color:
                            <input
                                type="color"
                                class="form-control"
                                name="selectType[class][selectTypeLabels][background-color]"
                                data-css-selector="class"
                                data-css-selector-value="selectTypeLabels"
                                data-css-property="background-color"
                                onfocus="styleELements(this)"
                                oninput="styleELements(this)"
                                <?php if ( isset($design['selectType']['class']['selectTypeLabels']['background-color']) ) { ?>
                                value = "<?php echo $design['selectType']['class']['selectTypeLabels']['background-color']?>"
                                data-value="1"
                                <?php } ?>
                            />
                        </label>
                    </div>
                </fieldset>
                <fieldset id="selectSpotView" class="hideFieldsets">
                    <legend>Select spot view</legend>
                </fieldset>
                <fieldset id="selectedSpotView" class="hideFieldsets">
                    <legend>Selected spot view</legend>
                </fieldset>
                <fieldset id="checkoutOrderView" class="hideFieldsets">
                    <legend>Checkout form view</legend>
                    <div class="form-group col-sm-12">
                        <label>
                            Background color:
                            <input
                                type="color"
                                class="form-control"
                                name="checkoutOrder[id][checkoutOrderBody][background-color]"
                                data-css-selector="id"
                                data-css-selector-value="checkoutOrderBody"
                                data-css-property="background-color"
                                onfocus="styleELements(this)"
                                oninput="styleELements(this)"
                                <?php if ( isset($design['checkoutOrder']['id']['checkoutOrderBody']['background-color']) ) { ?>
                                value = "<?php echo $design['checkoutOrder']['id']['checkoutOrderBody']['background-color']?>"
                                data-value="1"
                                <?php } ?>
                            />
                        </label>
                    </div>
                </fieldset>
                <fieldset id="buyerDetailsView" class="hideFieldsets">
                    <legend>Buyer details view</legend>
                    <div class="form-group col-sm-12">
                        <labe>
                            Background color:
                            <input
                                type="color"
                                class="form-control"
                                name="buyerDetails[id][buyerDetails][background-color]"
                                data-css-selector="id"
                                data-css-selector-value="buyerDetails"
                                data-css-property="background-color"
                                onfocus="styleELements(this)"
                                oninput="styleELements(this)"
                                <?php if ( isset($design['buyerDetails']['id']['buyerDetails']['background-color']) ) { ?>
                                value = "<?php echo $design['buyerDetails']['id']['buyerDetails']['background-color']?>"
                                data-value="1"
                                <?php } ?>
                            />
                        </label>
                </fieldset>
                <fieldset id="payOrderView" class="hideFieldsets">
                    <legend>Pay order view</legend>
                </fieldset>
                <input type="submit" class="btn btn-primary" value="submit">
            </form>
        </div>
        <div class="col-lg-6">
            <div  style="margin:auto; width:80%">
                <iframe id="iframe" src="<?php echo $iframeSrc; ?>" width="400px" height="650px"></iframe>
            </div>
        </div>
    </div>
</main>