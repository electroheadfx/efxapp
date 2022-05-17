
                  <div id="tags">
                      <p class="category" style="display: none;" ><?= $category_slug ?></p>
                      <?php if ($is_amorething): ?>
                        <p class="amorething" style="display: none;" >A more thing</p>
                        <p class="amorething2" style="display: none;" >Text</p>
                      <?php endif; ?>
                      <p class="name" style="display: none;" ><?= $name ?></p>
                      <p class="meta" style="display: none;" ><?= strtolower($meta) ?></p>
                      <p class="id" style="display: none;" ><?= $id ?></p>
                      <p class="date" style="display: none;" ><?= $date ?></p>
                      <p class="attr-status-meta"       style="display: none;" data-icon-draft="chain" data-icon-published="chain-broken"    data-text-draft="<?= __('model.post.attribute.status.published') ?>"     data-text-published="<?= __('model.post.attribute.status.draft') ?>"    ><?= __('model.post.attribute.status.'.$status); ?></p>
                      <p class="attr-featured-meta"     style="display: none;" data-icon-no="heart" data-icon-yes="heart-o"                  data-text-no="<?= __('model.post.attribute.featured.yes') ?>"            data-text-yes="<?= __('model.post.attribute.featured.no') ?>"     ><?= __('model.post.attribute.featured.'.$featured); ?></p>
                      <p class="attr-permission-meta"   style="display: none;" data-icon-private="globe" data-icon-public="user"             data-text-private="<?= __('model.post.attribute.permission.public') ?>"  data-text-public="<?= __('model.post.attribute.permission.private') ?>"   ><?= __('model.post.attribute.permission.'.$permission); ?></p>                      
                  </div>