                  
                  <div data-post-id="<?= $id ?>" class="category-chosen" data-exposition="<?= $module; ?>" > 

                    <select data-placeholder="<?= __('module.menu.backend.chosen-categories-select') ?>" multiple name="chosen-categories[]" class="chosen-select" tabindex="2">

                      <?php foreach ($categories as $key => $category): ?>

            						<?php if ($exposition == $category['exposition'] || $category['slug'] == 'uncategorized' || $category['exposition'] == 'cms' ): ?>
                              
                              <?php if( $category['exposition'] == $module || $category['slug'] == 'uncategorized' ): ?>

                                <option id="<?= strtolower($category['slug']) ?>"
                                       data-cat-id="<?= $category['id'] ?>" 
                                       value="<?= $category['id'].','.strtolower($category['slug']).','.$category['name']; ?>" 
                                       <?php if ( strpos($category_slug, $category['slug']) !== false) echo 'selected'; ?> 
                                       style="<?= ( $category['slug'] == 'uncategorized' ) ? 'display:none;' : ''; ?>" 
                                       <?= $category['exposition'] !== $module ? 'disabled' : ''; ?>
                                >
                                  <?= ucfirst($category['name']); ?>

                              <?php // elseif ( strpos($category_slug, $category['slug']) !== false ): ?>
                              <?php elseif ( in_arrayi($category['slug'], $arr_categories) ): ?>
                                
                                <option id="<?= strtolower($category['slug']) ?>"
                                       data-cat-id="<?= $category['id'] ?>" 
                                       value="<?= $category['id'].','.strtolower($category['slug']).','.$category['name']; ?>" 
                                       <?php if ( strpos($category_slug, $category['slug']) !== false) echo 'selected'; ?> 
                                       style="display:none;" 
                                       <?= $category['exposition'] !== $module ? 'disabled="disabled"' : ''; ?>
                                >
                                  <?= ucfirst($category['name']); ?>

                              <?php endif; ?>
                        
                        <?php endif; ?>

                      <?php endforeach; ?>

                    </select>

                  </div>

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