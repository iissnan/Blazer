{if $error || $show_alert}
    <div class="alert {$alert_mode}">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        {$alert_message}
    </div>
{/if}