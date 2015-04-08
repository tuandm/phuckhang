<?php
/**
 * LandBook Loader is a class that is responsible for
 * coordinating all actions and filters used throughout the plugin
 *
 * @author Tuan Duong <duongthaso@gmail.com>
 * @package LandBook
 */
 

class LandBook_Loader
{
    /**
     * A reference to the collection of actions used throughout the plugin.
     *
     * @access protected
     * @var    array    $_actions    The array of actions that are defined throughout the plugin.
     */
    protected $_actions;

    /**
     * A reference to the collection of filters used throughout the plugin.
     *
     * @access protected
     * @var    array    $_actions    The array of filters that are defined throughout the plugin.
     */
    protected $_filters;

    /**
     * A reference to the collection of shortcodes used thoughout the plugin.
     */
    protected $_shortcodes;

    /**
     * Instantiates the plugin by setting up the data structures that will
     * be used to maintain the actions and the filters.
     */
    public function __construct()
    {
        $this->_actions      = array();
        $this->_filters     = array();
        $this->_shortcodes  = array();
    }

    /**
     * Registers the actions with WordPress and the respective objects and
     * their methods.
     *
     * @param  string    $hook        The name of the WordPress hook to which we're registering a callback.
     * @param  object    $component   The object that contains the method to be called when the hook is fired.
     * @param  string    $callback    The function that resides on the specified component.
     * @param  int       $priority    Optional. Used to specify the order in which the functions
     *                                  associated with a particular action are executed. Default 10.
     *                                  Lower numbers correspond with earlier execution,
     *                                  and functions with the same priority are executed
     *                                  in the order in which they were added to the action.
     * @param  int       $accepted_args   Optional. The number of arguments the function accept. Default 1.
     */
    public function addAction($hook, $component, $callback, $priority = 10, $accepted_args = 1)
    {
        $this->_actions = $this->_add($this->_actions, $hook, $component, $callback, $priority, $accepted_args);
    }

    /**
     * Registers the filters with WordPress and the respective objects and
     * their methods.
     *
     * @param  string    $hook        The name of the WordPress hook to which we're registering a callback.
     * @param  object    $component   The object that contains the method to be called when the hook is fired.
     * @param  string    $callback    The function that resides on the specified component.
     * @param  int       $priority        Optional. Used to specify the order in which the functions
     *                                  associated with a particular action are executed. Default 10.
     *                                  Lower numbers correspond with earlier execution,
     *                                  and functions with the same priority are executed
     *                                  in the order in which they were added to the action.
     * @param  int       $accepted_args   Optional. The number of arguments the function accepts. Default 1.
     */
    public function addFilter($hook, $component, $callback, $priority = 10, $accepted_args = 1)
    {
        $this->_filters = $this->_add($this->_filters, $hook, $component, $callback, $priority, $accepted_args);
    }

    /**
     * Registers the shortcodes with WordPress and the respective objects and
     * their methods.
     *
     * @param  string    $hook        The name of the WordPress hook to which we're registering a callback.
     * @param  object    $component   The object that contains the method to be called when the hook is fired.
     * @param  string    $callback    The function that resides on the specified component.
     */
    public function addShortcode($hook, $component, $callback)
    {
        $this->_shortcodes = $this->_add($this->_shortcodes, $hook, $component, $callback);
    }

    /**
     * Registers the filters with WordPress and the respective objects and
     * their methods.
     *
     * @access private
     *
     * @param  array     $hooks       The collection of existing hooks to add to the collection of hooks.
     * @param  string    $hook        The name of the WordPress hook to which we're registering a callback.
     * @param  object    $component   The object that contains the method to be called when the hook is fired.
     * @param  string    $callback    The function that resides on the specified component.
     * @param  int       $priority    The priority of this action
     * @param  int       $priority    Optional. Used to specify the order in which the functions
     *                                  associated with a particular action are executed. Default 10.
     *                                  Lower numbers correspond with earlier execution,
     *                                  and functions with the same priority are executed
     *                                  in the order in which they were added to the action.
     * @param  int       $accepted_args   Optional. The number of arguments the function accept. Default 1.
     *
     * @return array                  The collection of hooks that are registered with WordPress via this class.
     */
    private function _add($hooks, $hook, $component, $callback, $priority = 10, $accepted_args = 1)
    {
        $hooks[] = array(
            'hook'              => $hook,
            'component'         => $component,
            'callback'          => $callback,
            'priority'          => $priority,
            'acccepted_args'    => $accepted_args,
        );
        return $hooks;
    }

    /**
     * Registers all of the defined filters and actions with WordPress.
     */
    public function run()
    {
        foreach ($this->_filters as $hook) {
            add_filter($hook['hook'], array($hook['component'], $hook['callback']), $hook['priority'], $hook['acccepted_args']);
        }

        foreach ($this->_actions as $hook) {
            add_action($hook['hook'], array($hook['component'], $hook['callback']), $hook['priority'], $hook['acccepted_args']);
        }

        foreach ($this->_shortcodes as $hook) {
            add_shortcode($hook['hook'], array($hook['component'], $hook['callback']));
        }
    }
}
