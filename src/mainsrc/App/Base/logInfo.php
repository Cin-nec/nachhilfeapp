<section style="display: none" class="popup--hide popup--container-medium popup--container-left logNotificationPopup">
    <div onclick="closeLogPopup()" class="popup--container-icon"><i class="fa-solid fa-x"></i></div>
    <div class="popup--container-header">
        <h2 class="popup--container-heading">Benachrichtigungen</h2>
    </div>
    <?php if(!empty($logDelivered)){ ?>
        <p class="logger--sub-heading">Neu (<?php echo count($logDelivered) ?>)</p>
        <div class="logger--list logger--list-small">
            <?php foreach ($logDelivered as $item): ?>
                <?php if($item->category == "akzeptiert"){?>
                    <div class="logger--container logger--container-delivered logger--container-small">
                        <p class="logger--text-small">Deine Anfrage bei <?php echo $item->contentHeader ?> im <?php echo ucfirst($item->contentBody) ?>-Angebot wurde akzeptiert. <a href="/angeboteGebuchtDetails?id=<?php echo $item->sender ?>" class="logger--link">Siehe mehr...</a></p>
                    </div>
                <?php } elseif($item->category == "abgelehnt"){?>
                    <div class="logger--container logger--container-delivered logger--container-small">
                        <p class="logger--text-small">Deine Anfrage bei <?php echo $item->contentHeader ?> im <?php echo ucfirst($item->contentBody) ?>-Angebot wurde abgelehnt. <a href="/angeboteOffenDetails?id=<?php echo $item->sender ?>" class="logger--link">Siehe mehr...</a></p>
                    </div>
                <?php } elseif($item->category == "beendet"){?>
                    <div class="logger--container logger--container-delivered logger--container-small">
                        <p class="logger--text-small">Die Nachhilfe bei <?php echo $item->contentHeader ?> im <?php echo ucfirst($item->contentBody) ?>-Angebot wurde beendet. <a href="/angeboteOffenDetails?id=<?php echo $item->sender ?>" class="logger--link">Siehe mehr...</a></p>
                    </div>
                <?php } elseif($item->category == "angefragt"){?>
                    <div class="logger--container logger--container-delivered logger--container-small">
                        <p class="logger--text-small"><?php echo $item->contentHeader ?> hat dein <?php echo ucfirst($item->contentBody) ?>-Angebot angefragt. <a href="/angeboteLehrerDetails?id=<?php echo $item->sender ?>" class="logger--link">Siehe mehr...</a></p>
                    </div>
                <?php } ?>
            <?php endforeach; ?>
        </div>
        <a href="/logger" class="logger--link-small">Weitere Benachrichtigungen ansehen</a>
    <?php } else { ?>
        <p class="logger--error">Du hast keine Benachrichtigungen.</p>
        <a href="/logger" class="logger--link-small">Weitere Benachrichtigungen ansehen</a>
    <?php } ?>
</section>