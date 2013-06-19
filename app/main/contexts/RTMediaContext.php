<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RTMediaContext
 *
 * Default Context - The page on from which the request is generating will be taken
 * as the default context; if any context/context_id is not passed while uploading any media
 * or displaying the gallery.
 *
 * @author saurabh
 */
class RTMediaContext {

	/**
	 *
	 * @var type
	 *
	 * $type - Context Type. It can be any type among these. (post, page, custom_post, home_page, archive etc.)
	 * $id - context id of the context
	 */
	public $type,$id;

	/**
	 *
	 * @return \RTMediaContext
	 */
	function __construct() {
		$this->set_context();
		return $this;
	}

	/**
	 *
	 */
	function set_context() {
        if (class_exists('BuddyPress')) {
            $this->set_bp_context();
        } else {
            $this->set_wp_context();
        }
    }

	/**
	 *
	 * @global type $post
	 */
    function set_wp_context() {
        global $post;
		if(isset($post->post_type)){
			$this->type = $post->post_type;
			$this->id = $post->ID;
		}
    }

	/**
	 *
	 */
    function set_bp_context() {
        if (bp_is_blog_page()) {
            $this->set_wp_context();
        } else {
            $this->set_bp_component_context();
        }
    }

	/**
	 *
	 */
    function set_bp_component_context() {
		if(bp_is_user() && !bp_is_group())
			$this->type = 'profile';
		else if(!bp_is_user() && bp_is_group())
			$this->type = 'group';
        $this->id = $this->get_current_bp_component_id();
    }

	/**
	 *
	 * @return type
	 */
    function get_current_bp_component_id() {
        switch (bp_current_component()) {
            case 'groups': return bp_get_current_group_id();
                break;
            default:
                return bp_displayed_user_id();
                break;
        }
    }


}

?>