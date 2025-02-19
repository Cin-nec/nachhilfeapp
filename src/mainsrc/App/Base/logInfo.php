<section style="display: none" class="popup--hide popup__ontainer--medium popup__container--left logNotificationPopup">
    <div onclick="closeLogPopup()" class="popup__container-icon"><i class="fa-solid fa-x"></i></div>
    <div class="popup__container-header">
        <h2 class="popup__container-heading">Benachrichtigungen</h2>
    </div>
    <?php if(!empty($logDelivered)){ ?>
        <p class="logger__sub-heading">Neu (<?php echo count($logDelivered) ?>)</p>
        <div class="logger__list logger__list--small">
            <?php foreach ($logDelivered as $item): ?>
                <?php if($item->category == "akzeptiert"){?>
                    <div class="logger__container logger__container-delivered logger__container--small">
                        <p class="logger__text--small">Deine Anfrage bei <?php echo $item->contentHeader ?> im <?php echo ucfirst($item->contentBody) ?>-Angebot wurde akzeptiert. <a href="/angeboteGebuchtDetails?id=<?php echo $item->sender ?>" class="logger__link">Siehe mehr...</a></p>
                    </div>
                <?php } elseif($item->category == "abgelehnt"){?>
                    <div class="logger__container logger__container-delivered logger__container--small">
                        <p class="logger__text--small">Deine Anfrage bei <?php echo $item->contentHeader ?> im <?php echo ucfirst($item->contentBody) ?>-Angebot wurde abgelehnt. <a href="/angeboteOffenDetails?id=<?php echo $item->sender ?>" class="logger__link">Siehe mehr...</a></p>
                    </div>
                <?php } elseif($item->category == "beendet"){?>
                    <div class="logger__container logger__container-delivered logger__container--small">
                        <p class="logger__text--small">Die Nachhilfe bei <?php echo $item->contentHeader ?> im <?php echo ucfirst($item->contentBody) ?>-Angebot wurde beendet. <a href="/angeboteOffenDetails?id=<?php echo $item->sender ?>" class="logger__link">Siehe mehr...</a></p>
                    </div>
                <?php } elseif($item->category == "angefragt"){?>
                    <div class="logger__container logger__container-delivered logger__container--small">
                        <p class="logger__text--small"><?php echo $item->contentHeader ?> hat dein <?php echo ucfirst($item->contentBody) ?>-Angebot angefragt. <a href="/angeboteLehrerDetails?id=<?php echo $item->sender ?>" class="logger__link">Siehe mehr...</a></p>
                    </div>
                <?php } ?>
            <?php endforeach; ?>
        </div>
        <a href="/logger" class="logger__link--small">Weitere Benachrichtigungen ansehen</a>
    <?php } else { ?>
        <p class="logger__error">Du hast keine Benachrichtigungen.</p>
        <a href="/logger" class="logger__link--small">Weitere Benachrichtigungen ansehen</a>
    <?php } ?>
</section>