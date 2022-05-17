<?php

namespace Media;

class Controller_Frontend_Post extends \Controller_Base_Frontend {

    public function before() {

        parent::before();
        $this->dataGlobal['themes'] = FALSE;
        $this->dataGlobal['docsheader'] = '';
        $this->menu_cats =  isset($this->dataGlobal['menu_cats']) ? $this->dataGlobal['menu_cats'] : '';

    }

    /**
     * 
     * Get all posts from category
     * @param  string $category slug
     * 
     */
    
    public function action_show_by_category($category = false) {

        $category = $this->dataGlobal['category'] = \Model_Category::query()->where('slug', $category)->get_one();

        /**
         *  CHECKING POST STATUS & PERMISSION
         */

        // Check category Status
        if ( ! $category || $category->status == 'draft' ) {
            \Message::warning(__('module.video.frontend.category.not-found'));
            \Response::redirect_back(\Router::get('homepage'));

        }

        // Check category permission
        if ( ! \Auth::check() && $category->permission == 'private' ) {
            \Message::warning(__('module.video.frontend.category.private'));
            \Response::redirect_back(\Router::get('homepage'));

        }

        $this->dataGlobal['title'] = \Config::get('application.seo.frontend.site') . ' | ' . $category->name;

        /* */
            
        // Pagination
        $config = array(
            'pagination_url' => \Uri::current(),
            'total_items'    => $category->post_count,
            'per_page'       => \Config::get('application.setup.page.pagination_global'),
            'uri_segment'    => 'page',
        );
        $this->data['pagination'] = $pagination = \Pagination::forge('post_pagination', $config);
        
        // setup UI
        $this->dataGlobal['navbar'] = '';
        $this->dataGlobal['header_img']     = 'category/recettes.jpg';
        $this->dataGlobal['header_title']   = $category->name;
        $this->dataGlobal['body'] = 'list';

        // Get posts
        $this->data['posts'] = \Model_Post::query()
                                        ->where('status','published')
                                        ->where('category_id', $category->id)
                                        ->order_by('created_at', 'DESC')
                                        ->offset($pagination->offset)
                                        ->limit($pagination->per_page)
                                        ->get();
        $this->dataGlobal['body'] = 'frontend category';

        $this->theme->set_partial('content', 'media/frontend/gallery/category')->set($this->data, null, false);

    }


    /**
     * 
     * Get all posts from author
     * @param  string $author username
     * 
     */
    
    public function action_show_by_author($author = false) {

        $author = $this->data['author'] = \User\Model_User::query()->where('username', $author)->get_one();

        if ( ! $author) {

            \Message::warning(__('module.video.frontend.author.not-found'));
            \Response::redirect_back(\Router::get('homepage'));

        } else {

            // Pagination
            $config = array(
                'pagination_url' => \Uri::current(),
                'total_items'    => count($author->posts),
                'per_page'       => \Config::get('application.setup.page.pagination_global'),
                'uri_segment'    => 'page',
            );
            $this->data['pagination'] = $pagination = \Pagination::forge('post_pagination', $config);
            // setup UI
            $this->dataGlobal['navbar']         = '';
            $this->dataGlobal['header_title']   = $author->username;
            $this->dataGlobal['header_img']     = 'category/recettes.jpg';
            $this->dataGlobal['body'] = 'list';

            // Get posts
            $this->data['posts'] = \Model_Post::query()
                                            ->where('status','published')
                                            ->where('user_id', $author->id)
                                            ->order_by('created_at', 'DESC')
                                            ->offset($pagination->offset)
                                            ->limit($pagination->per_page)
                                            ->get();
            $this->dataGlobal['body'] = 'frontend author';
            $this->dataGlobal['title'] = \Config::get('application.seo.frontend.site') . ' | Articles de ' . $author->username;
            $this->theme->set_partial('content', 'media/frontend/gallery/author')->set($this->data, null, false);
        }
    }


    /**
     * 
     * Show a post
     * @param  string $slug 
     * 
     */
    
    public function action_show($slug = false) {

        // Get post by slug
    	$post = $this->data['post'] = \Model_Post::query()->where('slug', $slug)->related('comments')->get_one();
        
        // Check post Status
        if (!isset($post)) {
            \Message::warning(__('module.video.frontend.post.not-found'));
            \Response::redirect_back(\Router::get('_404_'));
            
        }

        $this->data['comments'] = \Model_Comment::query()->where('post_id', $post->id)->where('published', 'on')->get();
        $this->dataGlobal['google_description'] = html_entity_decode(\Security::strip_tags($post->summary), ENT_QUOTES | ENT_XML1, 'UTF-8');
        
        if ( ! $post) {
            \Message::warning(__('module.video.frontend.post.not-found'));
            \Response::redirect_back(\Router::get('_404_'));

        }
        
        /**
         * CHECKING POST STATUS & PERMISSION
         */

        // Check post Status
        if ( $post->status == 'draft' ) {
            \Message::warning(__('module.video.frontend.post.not-found'));
            \Response::redirect_back(\Router::get('homepage'));
        }

        // Check post permission 
        if ( ! \Auth::check() && $post->permission == 'private' ) {
            \Message::warning(__('module.video.frontend.post.private'));
            \Response::redirect_back(\Router::get('homepage'));

        }

        $post->name = preg_replace('~\s*([?!])~',  '&nbsp;$1', \Security::strip_tags($post->name));
        $post->content = preg_replace('~\s*([?!])~',  '&nbsp;$1', $post->content);
        $category = \Model_Category::find($post->category_id);

        // Check category Status for post
        if ( ! $category || $category->status == 'draft' ) {
            \Message::warning(__('module.video.frontend.post.category-not-found'));
            \Response::redirect_back(\Router::get('homepage'));

        }


        // Check category permission for post
        if ( ! \Auth::check() && $category->permission == 'private' ) {
            \Message::warning(__('module.video.frontend.post.category-private'));
            \Response::redirect_back(\Router::get('homepage'));

        }

        $this->dataGlobal['title'] = \Config::get('application.seo.frontend.site') . ' | ' . $post->name . ' par ' . $post->users->username;

        /* */

        // Prepare comment form fieldset
        $form = \Fieldset::forge('post_comment');
        $form->add_model('Model_Comment');
        $form->add('submit', '', array(
            'type' => 'submit',
            'value' => __('application.submit'),
            'class' => 'btn btn-primary')
        );

        // If submit comment
        if (\Input::post('submit')) {

            $form->validation()->run();

            if ( ! $form->validation()->error()) {
                // Create and populate the comment object
                $comment = \Model_Comment::forge();
                $comment->from_array(array(
                    'username'      => $form->validated('username'),
                    'mail'          => $form->validated('mail'),
                    'content'       => $form->validated('content'),
                    'published'     => 'off',
                    'post_id'       => $post->id,
                ));
                if ($comment->save()) {

                    \Message::success(__('module.video.frontend.comment.added'));
                    \Response::redirect(\Router::get('show_post', array('segment' => $post->slug)));

                }  else {

                    \Message::warning(__('application.error'));
                }
                
            } else {

                // Output validation errors     
                /* foreach ($form->validation()->error() as $error) {
                    \Message::danger($error);
                } */
                \Message::danger(__('application.fix-fields-error'));

            }
        }

        $form->repopulate();
        $this->data['form'] = $form;
        $this->dataGlobal['header_on'] = false;
        $this->dataGlobal['body'] = 'frontend show';
        $this->theme->set_partial('content', 'frontend/gallery/show')->set($this->data, null, false);

    	
    }

    /**
     * 
     * Get the sidebar view (HMVC Only)
     * 
     */
    
    public function action_sidebar() {

        if (\Request::is_hmvc()) {
            // Get sidebar in cache
            try {
                $sidebar = \Cache::get('sidebar');

            } catch (\CacheNotFoundException $e) {

                // If Cache doesn't exist, get data and cache the view
                $this->data['categories'] = \Model_Category::find('all');
                $this->data['lastPosts'] = \Model_Post::query()->order_by('created_at', 'DESC')->limit(5)->get();
                $sidebar = $this->theme->view('frontend/gallery/sidebar', $this->data);

                \Cache::set('sidebar', $sidebar);
            }

            return $sidebar;
        }
    }

}
