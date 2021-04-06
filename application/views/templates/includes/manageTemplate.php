<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div style="margin-left:20px">
    <div class="form-grop col-lg-8 col-sm-12">
        <label for="selectTemplateName">Create template for predifined event</label>

        <select id='selectTemplateName' class="form-control">
            <option value="">Select template</option>
            <?php if ($tiqsId === $vendorId) { ?>
            <?php foreach ($emailTemplates as $template) { ?>
            <option value="<?php echo $template; ?>" <?php
                                if (!empty($templateName) && $templateName === $template) {
                                    $selected = 'selected';
                                    echo $selected;
                                }                    
                            ?>>
                <?php echo $template; ?>
            </option>
            <?php } ?>
            <?php } ?>
        </select>
        <br/>
        <label for="templateType">Template Type</label>
        <select class="form-control w-100" id="templateType" name="templateType" onchange="checkiIsLandingPage(this, 'landingPage', 'emailTemplate', 'landingPage')">
            <option value="" disabled>Select type</option>
            <option
                value="general"
                <?php echo (isset($templateType) && $templateType === "general") ? "selected" : '' ?>
            >
                General
            </option>
            <option
                value="reservations"
                <?php echo (isset($templateType) && $templateType === "reservations") ? "selected" : '' ?>
            >
                Reservations
            </option>
            <option
                value="tickets"
                <?php echo (isset($templateType) && $templateType === "tickets") ? "selected" : '' ?>
            >
                Tickets
            </option>
            <option
                value="vouchers"
                <?php echo (isset($templateType) && $templateType === "vouchers") ? "selected" : '' ?>
            >
                Vouchers
            </option>
            <option
                value="landingPage"
                <?php echo (isset($templateType) && $templateType == "landingPage") ? "selected" : '' ?>
            >
                Landing pages
            </option>
        </select>
        <br />


        <!-- email templates elements -->
        <label class="emailTemplate" for="customTemplateName">... or create custom template</label>
        <input type="text" id="customTemplateName" name="templateName" class="form-control emailTemplate"
            <?php if ( !empty($templateName) && empty($selected) ) { ?>
                value="<?php echo $templateName; ?>"
            <?php } ?> />
        <br />
        <label class="emailTemplate" for="customTemplateSubject">Subject</label>
        <input type="text" id="customTemplateSubject" name="templateSubject" class="form-control emailTemplate"
            <?php if ( !empty($templateSubject) && empty($selected) ) { ?>
                value="<?php echo $templateSubject; ?>"
            <?php } ?> />
        <br />
        <label class="emailTemplate" for="templateHtml">Edit template</label>

        <!-- landing page elements -->
        <label class="landingPage" for="selectProductGroup" style="display:none">Product groups</label>
        <select id='selectProductGroup' class="form-control landingPage"  style="display:none">
            <option value="">Select product group</option>
            <?php foreach ($productGroups as $group) { ?>
            <option
                value="<?php echo $group; ?>"
                <?php
                    // if (!empty($templateName) && $templateName === $template) {
                    //     $selected = 'selected';
                    //     echo $selected;
                    // }
                ?>
            >
                <?php echo $group; ?>
            </option>
            <?php } ?>
        </select>
        <br />
        <label class="landingPage" for="selectLandingPage" style="display:none">Landing page</label>
        <select id='selectLandingPage' class="form-control landingPage"  style="display:none">
            <option value="">Select landing page</option>
            <?php foreach ($landingPages as $page) { ?>
            <option
                value="<?php echo $page; ?>"
                <?php
                    // if (!empty($templateName) && $templateName === $template) {
                    //     $selected = 'selected';
                    //     echo $selected;
                    // }
                ?>
            >
                <?php echo ucfirst($page); ?>
            </option>
            <?php } ?>
        </select>
        <br />
        <label class="landingPage" for="selectLandingType" style="display:none">Landing type</label>
        <select id='selectLandingType' class="form-control landingPage"  style="display:none" onchange="switchTypeELement(this, 'mce-container', 'ladningPageUrl')">
            <option value="">Select landing type</option>
            <?php foreach ($landingTypes as $type) { ?>
            <option
                value="<?php echo $type; ?>"
                <?php
                    // if (!empty($templateName) && $templateName === $template) {
                    //     $selected = 'selected';
                    //     echo $selected;
                    // }
                ?>
            >
                <?php echo ucfirst($type); ?>
            </option>
            <?php } ?>
        </select>
        <br />
        <!-- url editor -->
        <label class="landingPage" for="ladningPageName" style="display:none">Landing page name</label>
        <input type="text" class="form-control landingPage" id="ladningPageName" placeholder="Enter landing page name" style="display:none; margin-bottom:10px" />
        <br />
        <!-- url editor -->
        <label class="ladningPageUrl" for="ladningPageUrl" style="display:none">Add landing page url</label>
        <input type="text" class="form-control ladningPageUrl" id="ladningPageUrl" placeholder="Enter landing page url" style="display:none" />
        <br />
        <br />
        <!-- end url editor -->
        <!-- editor -->
        <textarea id="templateHtml" name="templateHtml"></textarea>
        <!-- end editor -->


        <!-- email template action -->
        <div class="w-100 text-right mt-1 emailTemplate">
            <button style="height:35px;" class="btn btn-primary mr-auto"
                <?php if (empty($templateId)) { ?>
                    onclick="createEmailTemplate('selectTemplateName', 'customTemplateName', 'customTemplateSubject', 'templateType')"
                <?php } else { ?>
                    onclick="customUpdateEmailTemplate('selectTemplateName', 'customTemplateName', 'customTemplateSubject', 'templateType', '<?php echo $templateId; ?>')"
                <?php } ?>
            >
                <?php echo empty($templateId) ? 'Create new template' : 'Update'; ?>
            </button>
        </div>

        <!-- landing page action -->
        <div class="w-100 text-right mt-1 landingPage"  style="display:none">
            <button style="height:35px;" class="btn btn-primary mr-auto"
                onclick="createLandingPage('selectProductGroup', 'selectLandingPage', 'selectLandingType', 'ladningPageName', 'ladningPageUrl')"
            >
                <?php echo 'Create new landing page'; ?>
            </button>
        </div>
    </div>
</div>
<script>
const templateGlobals = (function() {
    let globals = {
        'templateHtmlId': 'templateHtml',
        'templateType' : '<?php echo $templateType; ?>',
    }

    <?php if (!empty($templateContent)) { ?>
    globals['templateContent'] = `<?php echo $templateContent; ?>`
    <?php } ?>
    <?php if (!empty($templateId)) { ?>
    globals['templateId'] = '<?php echo $templateId; ?>'
    <?php } ?>
    <?php if (!empty($urlType)) { ?>
    globals['urlType'] = `<?php echo $urlType; ?>`
    <?php } ?>

    Object.freeze(globals);

    return globals;
}());
</script>