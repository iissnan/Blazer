{if $alert and $alert->is_display() }
    <div class="alert {$alert->get_mode()}">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        {$alert->get_message()}
    </div>
{/if}