<div class="form-view" style="width:600px">
    <div class="form-header">
        <h3>{$form->title}</h3>
    </div>
    <div class="form-body form-horizontal">
        <span>
            <form name="{$form->name}" action="{$form->action}" method="post">
                {foreach $form->getWidgets() as $widget}
                <div class="control-group">
                    <label class="control-label" for="{$widget->getId()}">{$widget->getFieldLabel()}</label>
                    <div class="controls">{$widget->getGenerated('html')}</div>
                </div>
                {/foreach}
                <hr/>
                <div align="right" style="padding-right: 20px">
                    <button class="btn" type="submit">Save changes</button>
                    <button class="btn">Cancel</button>
                </div>
            </form>
        </span>
    </div>
</div>