<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div style="margin-left:20px">

    <br/>
    <div class="form-grop col-lg-8 col-sm-12">
        <?php if ($emailTemplatesEdit === true && $tiqsId === $vendorId && !empty($emailTemplates)) { ?>
            <label for="selectTemplateName">Create template for predifined event</label>
            <select id='selectTemplateName' class="form-control">
                <option value="">Select template</option>

                <?php foreach ($emailTemplates as $template) { ?>
                    <option
                        value="<?php echo $template; ?>"
                        <?php
                            if (!empty($templateName) && $templateName === $template) {
                                $selected = 'selected';
                                echo $selected;
                            }
                        ?>
                    >
                        <?php echo $template; ?>
                    </option>
                <?php } ?>
            </select>
            <br/>
        <?php } else { ?>
            <input type="hidden" id="selectTemplateName" value="">
        <?php } ?>
        <label for="templateType">Copy Template</label>
        <select class="form-control w-100" id="copyTemplate" onchange="copyTemplate()">
            <option value="" disabled selected>Select default template</option>
            <?php if(is_array($defaultTemplates) && count($defaultTemplates) > 0) { 
                    foreach($defaultTemplates as $defaultTemplate){ 
            ?>
                <option value="<?php echo $defaultTemplate['template_file']; ?>"><?php echo ucfirst($defaultTemplate['template_type']) ?> - <?php echo ucfirst($defaultTemplate['template_name']) ?></option>
            <?php } } ?>
        </select>
        <br/>

        <label for="templateType">Template Type</label>
        <select class="form-control w-100" id="templateType" name="templateType" onchange="checkiIsLandingPage(this, 'landingPage', 'emailTemplate', 'landingPage')">
            <option value="" disabled>Select template</option>
            <?php if ($emailTemplatesEdit === true) { ?>
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
            <?php } ?>
            <?php if ($landingPagesEdit === true) { ?>
                <option
                    value="landingPage"
                    <?php echo (isset($templateType) && $templateType == "landingPage") ? "selected" : '' ?>
                >
                    Landing pages
                </option>
            <?php } ?>
        </select>
        <br/>
        <?php if ($emailTemplatesEdit === true) { ?>
            <!-- email templates elements -->
            <label class="emailTemplate" for="customTemplateName">... or create custom template</label>
            <input type="text" id="customTemplateName" name="templateName" class="form-control emailTemplate"
                <?php if ( !empty($templateName) && empty($selected) ) { ?>
                    value="<?php echo $templateName; ?>"
                <?php } ?> />
            <br />
            <label class="emailTemplate" for="customTemplateSubject">Subject</label>
            <input
                type="text" id="customTemplateSubject" name="templateSubject" class="form-control emailTemplate"
                <?php if ( !empty($templateSubject) && empty($selected) ) { ?>
                    value="<?php echo $templateSubject; ?>"
                <?php } ?>
            />
            <br/>
        <?php } ?>
        <?php if ($landingPagesEdit === true) { ?>
            <!-- landing page elements -->
            <label
                class="landingPage"
                for="selectProductGroup"
                <?php if ($emailTemplatesEdit === true) { ?>
                    style="display:none"
                <?php } ?>
            >
                Product groups
            </label>
            <select
                id='selectProductGroup'
                class="form-control landingPage"
                <?php if ($emailTemplatesEdit === true) { ?>
                    style="display:none"
                <?php } ?>
            >
                <option value="">Select product group</option>
                <?php foreach ($productGroups as $group) { ?>
                <option
                    value="<?php echo $group; ?>"
                    <?php
                        if (!empty($landingPage) && $landingPage->productGroup === $group) {
                            $selected = 'selected';
                            echo $selected;
                        }
                    ?>
                >
                    <?php echo $group; ?>
                </option>
                <?php } ?>
            </select>
            <br />
            <label
                class="landingPage"
                for="selectLandingPage"
                <?php if ($emailTemplatesEdit === true) { ?>
                    style="display:none"
                <?php } ?>
            >
                Landing page
            </label>
            <select
                id='selectLandingPage'
                class="form-control landingPage"
                <?php if ($emailTemplatesEdit === true) { ?>
                    style="display:none"
                <?php } ?>
            >
                <option value="">Select landing page</option>
                <?php foreach ($landingPages as $page) { ?>
                <option
                    value="<?php echo $page; ?>"
                    <?php
                        if (!empty($landingPage) && $landingPage->landingPage === $page) {
                            $selected = 'selected';
                            echo $selected;
                        }
                    ?>
                >
                    <?php echo ucfirst($page); ?>
                </option>
                <?php } ?>
            </select>
            <br/>
            <!-- url editor -->
            <label
                class="landingPage"
                for="ladningPageName"
                <?php if ($emailTemplatesEdit === true) { ?>
                    style="display:none"
                <?php } ?>
            >
                Landing page name
            </label>
            <input
                type="text"
                class="form-control landingPage"
                id="ladningPageName"
                placeholder="Enter landing page name"
                style="<?php if ($emailTemplatesEdit === true) { ?>display:none;<?php } ?> margin-bottom:10px"
                <?php if (!empty($landingPage) && $landingPage->name) { ?>
                    value="<?php echo $landingPage->name; ?>"
                <?php } ?>
            />
            <br/>
            <label
                class="landingPage"
                for="selectLandingType"
                <?php if ($emailTemplatesEdit === true && (empty($landingPage) || $landingPage->landingType !== $urlType)) { ?>
                    style="display:none"
                <?php } ?>
            >
                Landing type
            </label>
            <select
                id='selectLandingType'
                class="form-control landingPage"
                style="margin-bottom:10px;
                    <?php if ($emailTemplatesEdit === true && (empty($landingPage) || $landingPage->landingType !== $urlType)) { ?>
                        display:none;
                    <?php } ?>"
                onchange="switchTypeELement(this, 'mce-container', 'editTemplate', 'ladningPageUrl')"
            >
                <option value="">Select landing type</option>
                <?php foreach ($landingTypes as $type) { ?>
                <option
                    value="<?php echo $type; ?>"
                    <?php
                        if (!empty($landingPage) && $landingPage->landingType === $type) {
                            $selected = 'selected';
                            echo $selected;
                        }
                    ?>
                >
                    <?php echo ucfirst($type); ?>
                </option>
                <?php } ?>
            </select>
            <br/>
            <!-- url editor -->
            <label
                class="ladningPageUrl"
                for="ladningPageUrl"
                <?php if ($emailTemplatesEdit === true || (!empty($landingPage) && $landingPage->landingType !== $urlType)) { ?>
                    style="display:none"
                <?php } ?>
            >
                Add landing page url
            </label>
            <input
                type="text"
                class="form-control ladningPageUrl"
                id="ladningPageUrl"
                placeholder="Enter landing page url"
                style="margin-bottom:10px;
                <?php if ($emailTemplatesEdit === true || (!empty($landingPage) && $landingPage->landingType !== $urlType)) { ?>
                    display:none;
                <?php } ?>"
                <?php if (!empty($landingPage) && $landingPage->landingType === $urlType) { ?>
                    value="<?php echo $landingPage->value; ?>"
                <?php } ?>
            />
            <br/>
            <!-- end url editor -->
        <?php } ?>


        <!-- editor -->
        <label class="editTemplate" for="templateHtml">Edit template</label>
        <textarea id="templateHtml" name="templateHtml"></textarea>
        <!-- end editor -->


        <?php if ($emailTemplatesEdit === true) { ?>
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
        <?php } ?>

        <?php if ($landingPagesEdit === true) { ?>
            <!-- landing page action -->
            <div
                class="w-100 text-right mt-1 landingPage"
                <?php if ($emailTemplatesEdit === true) { ?>
                    style="display:none"
                <?php } ?>
            >
                <button style="height:35px;" class="btn btn-primary mr-auto"
                    onclick="createLandingPage('selectProductGroup', 'selectLandingPage', 'selectLandingType', 'ladningPageName', 'ladningPageUrl')"
                >
                    <?php echo  empty($landingPage) ? 'Create new landing page' : 'Update landing page'; ?>
                </button>
            </div>
        <?php } ?>
    </div>

	<div class="input-group mt-5 mb-3 col-lg-8 col-sm-12">
		<input type="email" name="email" id="email" class="form-control" placeholder="Email">
		<div class="input-group-append">
			<button class="btn btn-success" onclick="sendTestEmail('email', 'templateHtml')" type="button">Send Test Email</button>
		</div>
	</div>
</div>
<script>
const templateGlobals = (function() {
    let globals = {
        'templateHtmlId': 'templateHtml',
    }

    <?php if (!empty($templateType)) { ?>
        globals['templateType'] = `<?php echo $templateType; ?>`
    <?php } ?>
    <?php if (!empty($templateContent)) { ?>
        globals['templateContent'] = decodeHtml(`<?php echo htmlentities($templateContent); ?>`)
    <?php } ?>
    <?php if (!empty($templateId)) { ?>
        globals['templateId'] = '<?php echo $templateId; ?>'
    <?php } ?>
    <?php if (!empty($urlType)) { ?>
        globals['urlType'] = '<?php echo $urlType; ?>'
    <?php } ?>
    <?php if (!empty($landingPage) && $landingPage->landingType === $urlType) { ?>
        globals['hideTemplateEditor'] = true
    <?php } ?>
    <?php if (!empty($landingPage)) { ?>
        globals['landingPageId'] = parseInt(<?php echo $landingPage->id; ?>)
    <?php } ?>

    Object.freeze(globals);

    return globals;
}());

function decodeHtml(html) {
    let txt = document.createElement('textarea');
    txt.innerHTML = html;
    let decodeValue = txt.value;
    txt.remove();
    return decodeValue;
}

function readTextFile(url)
{
    var tempData = '';

    $.ajax({
        url: url,
        type: 'GET',
        async: false, //blocks window close
        success: function(data) {
            tempData = data;
        }
    });
    tinymce.get(templateGlobals.templateHtmlId).setContent(tempData.replaceAll('[QRlink]', '<?php echo base_url(); ?>assets/images/qrcode_preview.png'));
    return ;
}

function copyTemplate() {
    let filename = $('#copyTemplate option:selected').val();
    let url = '<?php echo base_url(); ?>assets/email_templates/1/' + filename + '.txt';
    readTextFile(url);
}
</script>
