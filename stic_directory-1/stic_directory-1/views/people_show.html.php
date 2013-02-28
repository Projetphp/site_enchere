<h1>People show</h1>

<div class="row">
  <div class="span4 subnavspy">
    <div class="well sidebar-nav">
      <ul class="nav nav-list">
        <?php foreach ($subnav as $letter => $items): ?>
        <li class="nav-header"><?= mb_strtoupper($letter) ?></li>
        <?php foreach ($items as $item): ?>
        <li><a href="<?= url_for('/people', $people['firstname'] . ' ' . $item['lastname'] . '-' . $item['id']) ?>"><?= $item['lastname'] ?> <small><?= $item['firstname'] ?></small></a></li>
        <?php endforeach; ?>
        <?php endforeach; ?>
        <!-- <li class="active"><a href="#">Link</a></li> -->
      </ul>
    </div><!--/.well -->
  </div><!--/span-->
  <div class="span8">

    <h2 id="people-<?= $people['id'] ?>">
    <img src="http://www.gravatar.com/avatar/<?= md5($people['email']) ?>?s=30" alt="avatar" />
    <?= h($people['firstname']) ?> <small><?= h($people['lastname']) ?></small></h2>
    <span class="label label-info pull-right"><?= h($people['class_of']) ?></span>
    <p><a href="mailto:<?= h($people['email']) ?>"><i class="icon-envelope"></i> <?= h($people['email']) ?></a></p>
    <hr />

  </div><!--/span-->
</div><!--/row-->
