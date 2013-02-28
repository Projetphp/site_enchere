<h1>People list</h1>

<div class="row">
  <div class="span4 subnavspy">
    <div class="well sidebar-nav">
      <ul class="nav nav-list">
        <?php foreach ($subnav as $letter => $items): ?>
        <li class="nav-header"><?= mb_strtoupper($letter) ?></li>
        <?php foreach ($items as $item): ?>
        <li><a href="#people-<?= $item['id'] ?>"><?= $item['lastname'] ?> <small><?= $item['firstname'] ?></small></a></li>
        <?php endforeach; ?>
        <?php endforeach; ?>
        <!-- <li class="active"><a href="#">Link</a></li> -->
      </ul>
    </div><!--/.well -->
  </div><!--/span-->
  <div class="span8">

    <?php foreach ($rows as $row): ?>
      <h2 id="people-<?= $row['id'] ?>">
        <img src="<?= url_for_user_photo($row) ?>" alt="avatar" style="width:30px;height:30px" />
        <a href="<?= url_for('/people', $row['firstname'] . ' ' . $row['lastname'] . '-' . $row['id']) ?>"><?= h($row['firstname']) ?> <small><?= h($row['lastname']) ?></small></a></h2>
      <span class="label label-info pull-right"><?= h($row['class_of']) ?></span>
      <p><a href="mailto:<?= h($row['email']) ?>"><i class="icon-envelope"></i> <?= h($row['email']) ?></a></p>
      <hr />
    <?php endforeach; ?>

  </div><!--/span-->
</div><!--/row-->
