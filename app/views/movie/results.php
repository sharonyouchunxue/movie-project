<?php if (isset($movie)): ?>
  <pre><?php print_r($movie); ?></pre>
<?php elseif (isset($error)): ?>
  <p><?php echo htmlspecialchars($error); ?></p>
<?php else: ?>
  <p>No movie data to display.</p>
<?php endif; ?>
