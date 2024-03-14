<?php
/**
*  This file is part of the VCL for PHP project
*
*  Copyright (c) 2004-2007 qadram software <support@qadram.com>
*
*  Checkout AUTHORS file for more information on the developers
*
*  This library is free software; you can redistribute it and/or
*  modify it under the terms of the GNU Lesser General Public
*  License as published by the Free Software Foundation; either
*  version 2.1 of the License, or (at your option) any later version.
*
*  This library is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
*  Lesser General Public License for more details.
*
*  You should have received a copy of the GNU Lesser General Public
*  License along with this library; if not, write to the Free Software
*  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
*  USA
*
*/

use_unit("classes.inc.php");

/**
 * ActionList Class
 *
 * A list of actions for processing web requests.
 * Currently the ActionList is just a list of strings (actions) and when matched
 * by a web request the OnExecute event is fired.
 *
 * Example: If an ActionList1 is defined in unit1.php and the list contains
 *          the string "showmessage" following URL will trigger an OnExecute:
 *          http://localhost/unit1.php/?ActionList1=showmessage
 *          Use the $params["action"] of the OnExecute event handler to distinguish
 *          between actions.
 */
class ActionList extends Component
{
        protected $_actions = array();
        protected $_onexecute = null;


        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
        }

        function init()
        {
                parent::init();

                $action = $this->input->{$this->_name};
                if (is_object($action))
                {
                        $this->executeAction($action->asString());
                }
        }

        /**
        * Add a new action to the Actions array.
        * @param string $action  Name of the action.
        */
        function addAction($action)
        {
                $this->_actions[] = $action;
        }

        /**
        * Deletes an action from the Actions array.
        * @param string $action  Name of the action.
        */
        function deleteAction($action)
        {
                if (in_array($action, $this->_actions))
                {
                        $key = array_search($action, $this->_actions);
                        array_splice($this->_actions, $key, 1);
                }
        }

        /**
        * Generates an OnExecute event.
        * @param string $action  Name of the action.
        * @return bool Returns true if the OnExecute event was successfully called,
        *              false otherwise.
        */
        function executeAction($action)
        {
                // only execute the action if a handler has been assigned and
                // the action is in the list
                if ($this->_onexecute != null && in_array($action, $this->_actions))
                {
                        return $this->callEvent('onexecute', array("action" => $action));
                }
                // action was not handled
                return false;
        }

        /**
        * Add an action to an URL.
        * Note: Currently only one action per ActionList and URL can be added.
        *       If more actions of the same list are added the behavior is undefined.
        * @param string $action  Name of the action.
        * @param string $url     An URL to another script. If empty the same
        *                        script as ActionList is defined will be called.
        * @return bool Returns true if the action was successfully added to the
        *              URL, false otherwise.
        */
        function expandActionToURL($action, &$url)
        {
                // get the key of the action (if exists);
                if (in_array($action, $this->_actions))
                {
                        $key = array_search($action, $this->_actions);

                        // check if the query already started
                        $url .= (strpos($url, '?') === false) ? "?" : "&";
                        // expand the URL with the action
                        $url .= urlencode($this->_name)."=".urlencode($this->_actions[$key]);
                        return true;
                }

                // attachActionToURL failed to expand the URL
                return false;
        }

        /**
        * OnExecute event
        * Occurs when a web request contained an action of the list.
        * Use the $params argument passed to the event handler to get the name
        * of the executed action (e.g. $params["action"]).
        * @return mixed
        */
        function getOnExecute() { return $this->_onexecute; }
        /**
        * OnExecute event
        * Occurs when a web request contained an action of the list.
        * Use the $params argument passed to the event handler to get the name
        * of the executed action (e.g. $params["action"]).
        * @param mixed $value
        */
        function setOnExecute($value) { $this->_onexecute=$value; }
        function defaultOnExecute() { return null; }

        /**
        * Array of all actions in the list.
        * Use addAction() and deleteAction() to modify the array easily.
        * @return array
        */
        function getActions() { return $this->_actions; }
        /**
        * Array of all actions in the list.
        * Use addAction() and deleteAction() to modify the array easily.
        * @param array $value
        */
        function setActions($value) { $this->_actions=$value; }
        function defaultActions() { return array(); }



}

?>
