<?php $eventDate = new DateTime(get_field('event_date')); ?>
<div class="event-summary">
<a class="event-summary__date t-center" href="#">
    <span class="event-summary__month"><?php echo $eventDate->format('M'); ?></span>
    <span class="event-summary__day"><?php echo $eventDate->format('d'); ?></span>
</a>
<div class="event-summary__content">
    <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
    <p><?php wp_trim_words(get_the_Content(), 19); ?><a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
</div>
</div>