<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div id="templateHtmlUnlayer" style="width: 1024px; height:800px"></div>
<?php if ($emailTemplatesEdit === true) { ?>
    <!-- email template action -->
    <div class="w-100 text-right mt-1 emailTemplate">
        <button style="height:35px;" class="btn btn-primary mr-auto"
            <?php if (empty($templateId)) { ?>
                onclick="createEmailTemplate('selectTemplateName', 'customTemplateName', 'customTemplateSubject', 'templateType', 0, false)"
            <?php } else { ?>
                onclick="customUpdateEmailTemplate('selectTemplateName', 'customTemplateName', 'customTemplateSubject', 'templateType', '<?php echo $templateId; ?>', false)"
            <?php } ?>
        >
            <?php echo empty($templateId) ? 'Create new template' : 'Update'; ?>
        </button>
    </div>
<?php } ?>