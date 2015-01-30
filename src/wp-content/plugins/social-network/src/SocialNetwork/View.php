    <?php
    class SocialNetwork_View
    {
        public static function render($view, $data = null)
        {
            // Handle data
            ($data) ? extract($data) : null;

            ob_start();
            include(plugin_dir_path(__FILE__).'../../views/'.$view.'.php');
            $view = ob_get_contents();
            ob_end_clean();

            // Optimize the view by removing linefeeds and multiple spaces
            if (isset($pd_options['remove_lf'])) {
                $view = trim(preg_replace('/\s+/', ' ', $view));
            }

            return $view;
        }
    }
    ?>