<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- editor -->
<label class="editTemplate" for="templateHtml">Edit template</label>
<textarea id="templateHtml" name="templateHtml"></textarea>
<!-- end editor -->


<?php if ($emailTemplatesEdit === true) { ?>
    <!-- email template action -->
    <div class="w-100 text-right mt-1 emailTemplate">
        <button style="height:35px;" class="btn btn-primary mr-auto"
            <?php if (empty($templateId)) { ?>
                onclick="createEmailTemplate('selectTemplateName', 'customTemplateName', 'customTemplateSubject', 'templateType', 0, true)"
            <?php } else { ?>
                onclick="customUpdateEmailTemplate('selectTemplateName', 'customTemplateName', 'customTemplateSubject', 'templateType', '<?php echo $templateId; ?>', true)"
            <?php } ?>
        >
            <?php echo empty($templateId) ? 'Save' : 'Update'; ?>
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

<div class="input-group mt-5 mb-3 col-lg-8 col-sm-12">
    <input type="email" name="email" id="email" class="form-control" placeholder="Email">
    <div class="input-group-append">
        <button class="btn btn-success" onclick="sendTestEmail('email', 'templateHtml')" type="button">Send Test Email</button>
    </div>
</div>
