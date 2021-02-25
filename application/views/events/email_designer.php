<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div style="margin-left:20px">
    <div class="form-grop col-lg-8 col-sm-12">
        <label for="selectTemplateName">Create template for predifined event</label>
        
            <select id='selectTemplateName' class="form-control" >
                <option value="">Select template</option>
                <?php if ($tiqsId === $vendorId) { ?>
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
            </select>
            <br/>
        
        <label for="customTemplateName">... or create custom template</label>
        <input
            type="text"
            id="templateName"
            oninput="emailTemplateName(this)"
            class="form-control"
            <?php if ( !empty($templateName) && empty($selected) ) { ?>
                value ="<?php echo str_replace('ticketing_', '', $templateName); ?>"
            <?php } ?>
        />
        <input
            type="hidden"
            id="customTemplateName"
            name="templateName"
            <?php if ( !empty($templateName) && empty($selected) ) { ?>
                value ="<?php echo $templateName; ?>"
            <?php } ?>
        />
        <br/>
        <label for="templateHtml">Edit template</label>
        <textarea id="templateHtml" name="templateHtml"></textarea>
        <div class="w-100 text-right mt-1">
            <button
                style="height:35px;"
                class="btn btn-primary mr-auto"
                id="btn-save"
                <?php if (empty($templateId)) { ?>
                    onclick="createEmailTemplate('selectTemplateName', 'customTemplateName')"
                <?php } else { ?>
                    onclick="createEmailTemplate('selectTemplateName', 'customTemplateName', '<?php echo $templateId; ?>')"
                <?php } ?>
            >
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
