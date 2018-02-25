<?php if (!empty($foods)): ?>
    <?php foreach ($foods as $title => $ingredients): ?>
        <h3><?= $title?></h3>
        <p><?= $ingredients ?></p>
    <?php endforeach; ?>
<?php endif; ?>