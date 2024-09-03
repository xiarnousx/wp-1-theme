
<form class="search-form" method="GET" action="<?php echo esc_url(site_url('/')); ?>" >
    <label class="headline headline--medium" for="s">Perform a New Sarch:</label>
    <div class="search-form-row">
        <input id="s" class="s" type="search" name="s" placeholder="What are you looking for?" />
        <input type="submit" class="search-submit" value="Search" />
    </div>
</form>