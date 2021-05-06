<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div style="margin-left:20px">
    <div class="form-grop col-lg-8 col-sm-12">
        <label for="selectTemplateName">Create template for predifined event</label>
        
            <select id='selectTemplateName' class="form-control" >
                <option value="">Select template</option>
                <?php if ($tiqsId === $vendorId) { ?>
                    <?php if (count($emailTemplates) > 0) { ?>
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
                    <?php } ?>
                <?php } ?>
            </select>
            <br/>
        <label for="templateType">Template Type</label>
        <select class="form-control w-100" id="templateType" name="templateType">
            <option value="" disabled>Select type</option>
            <option value="general"
                <?php echo (isset($templateType) && $templateType == "general") ? "selected" : '' ?>>General</option>
            <option value="reservations"
                <?php echo (isset($templateType) && $templateType == "reservations") ? "selected" : '' ?>>Reservations
            </option>
            <option value="tickets"
                <?php echo (isset($templateType) && $templateType == "tickets") ? "selected" : '' ?>>Tickets</option>
            <option value="vouchers"
                <?php echo (isset($templateType) && $templateType == "vouchers") ? "selected" : '' ?>>Vouchers</option>
        </select>
        <br />

        <label for="customTemplateName">... or create custom template</label>
        <input type="text" id="customTemplateName" name="templateName" class="form-control"
            <?php if ( !empty($templateName) && empty($selected) ) { ?> value="<?php echo $templateName; ?>"
            <?php } ?> />
        <br />
        <label class="emailTemplate" for="customTemplateSubject">Subject</label>
            <input
                type="text" id="customTemplateSubject" name="templateSubject" class="form-control emailTemplate"
                <?php if ( !empty($templateSubject) && empty($selected) ) { ?>
                    value="<?php echo $templateSubject; ?>"
                <?php } ?>
            />
        <label for="templateHtml">Edit template</label>
        <textarea id="templateHtml" name="templateHtml"></textarea>
        <div class="w-100 text-right mt-1"> 
            <button style="height:35px;" class="btn btn-primary mr-auto" <?php if (empty($templateId)) { ?>
                onclick="createEmailTemplate('selectTemplateName', 'customTemplateName', 'customTemplateSubject', 'templateType')" <?php } else { ?>
                onclick="customUpdateEmailTemplate('selectTemplateName', 'customTemplateName', 'customTemplateSubject', 'templateType', '<?php echo $templateId; ?>')"
                <?php } ?>>
                <?php echo empty($templateId) ? 'Create new template' : 'Update'; ?>
            </button>
        </div>
    </div>
</div>
<script>
    const templateGlobals = (function(){
        let globals = {
            'templateHtmlId' : 'templateHtml',
        }

        <?php if (!empty($templateContent)) { ?>
            globals['templateContent'] = `<?php echo $templateContent; ?>`
        <?php } ?>
        <?php if (!empty($templateId)) { ?>
            globals['templateId'] = '<?php echo $templateId; ?>'
        <?php } ?>

        Object.freeze(globals);

        return globals;
    }());
    function emailTemplateName(el){
        let name = $(el).val();
        $(el).attr('style', '');
        if(name != ''){
            $('#customTemplateName').val('ticketing_'+name);
        } else {
            $('#customTemplateName').val('');
        }
        return ;
    }

    $('#btn-save').on('click', function(){
        let style = $('#customTemplateName').attr('style');
        return $('#templateName').attr('style', style);
    });
</script>
