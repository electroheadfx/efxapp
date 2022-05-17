<!-- Menus -->

            <div class="row">
                <div class="col-md-12">
                    <hr class="hr-menu" />
                </div>
                <div class="col-md-12">
                    <?php if ($list_mode != 'preview'): ?>
                        <div class="btn-group margin-menu">
                            <a href="<?= \Uri::base(false). 'media/admin/'.$this->submodule.$list_mode.'?category=all&menu=all' ?>" class="btn btn-default <?= $activedmenu == 'all' ? 'active' : ''; ?>" ><?= __('application.all_menus'); ?></a>
                        </div>
                    <?php endif; ?>
                    <?php foreach ($menus as $menu): ?>
                        
                        <!-- Split button -->
                        <div class="btn-group margin-menu">
                          <?php if ($list_mode != 'preview'): ?>
                            <a href="<?= \Uri::base(false). 'media/admin/'.$this->submodule.$list_mode.'?menu='. $menu->id ?>&category=all" class="btn btn-default text-default <?= $activedmenu == $menu->id ? 'active' : ''; ?>" data-toggle="tooltip-menu" data-title="Menu <?= $menu->name; ?> (<?= ucfirst($menu->route) ?>)" ><?= isset($menu->postselect) ? $menu->postselect == 'max' ? '<i class="fa fa-search-plus"></i>' : '<i class="fa fa-list-ul"></i>' : '<i class="fa fa-list-ul"></i>'; ?> <?= $menu->name ?> <span class="badge categorized badge-<?= $menu->route; ?>" style="margin-left: 3px;" ><?= $menu['count']; ?></span></a>
                          <?php else: ?>
                            <a href="<?= \Uri::base(false). 'media/admin/'.$this->submodule.'/preview/'.$menu->id.'?menu='. $menu->id ?>&category=all" class="btn btn-default text-default <?= $activedmenu == $menu->id ? 'active' : ''; ?>" data-toggle="tooltip-menu" data-title="Menu <?= $menu->name; ?> (<?= ucfirst($menu->route) ?>)" ><?= $menu->name ?> <span class="badge categorized badge-<?= $menu->route; ?>" style="margin-left: 3px;" ><?= $menu['count']; ?></span></a>
                          <?php endif; ?>
                          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu">
                            <?php if ($activedmenu !== $menu->id): ?>
                                <li><a href="<?= \Uri::base(false). 'media/admin/'.$this->submodule.$list_mode.'?menu='. $menu->id ?>" ><i class="fa fa-search text-<?= $menu->route ?>"></i> <?= __('application.view_post') ?> <?= $menu->name ?></a></li>
                            <?php endif; ?>
                            <li><a href="<?= \Uri::base(false). 'project/admin/category?menu='. $menu->id ?>" ><i class="fa fa-folder-open text-<?= $menu->route ?>"></i> <?= __('backend.menu.show_categories') ?> <?= $menu->name ?></a></li>
                            <li><a href="<?= \Router::get('admin_project_menu_add').'/'.$menu->id ?>"><i class="fa fa-list text-<?= $menu->route ?>"></i> <?= __('backend.menu.edit'); ?></a></li>
                          </ul>
                        </div> 

                    <?php endforeach; ?>
                </div>
                <div class="col-md-12">
                    <hr/>
                </div>
            </div>
        <!-- end Menus -->