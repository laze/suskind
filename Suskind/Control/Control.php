<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Basic
 *
 * @author laze
 */
class Suskind_Control_Control implements Suskind_Control_Interface {
	protected $model;
	protected $control = null;
	protected $event = null;
	protected $events = array(
		'List', //- First item is the default
		'Add',
		'Modify',
		'Delete'
	);

	/**
	 * Return with the view object to show.
	 *
	 * @return Suskind_View_View
	 */
    public function getView() {
		if (is_null($this->control)) throw new Suskind_Exception(Suskind_Exception_Control::NotExists());
		if (is_null($this->event)) {
			$viewClass = str_replace('Control', 'View', $this->control.'_'.$this->events[0]);
			if (class_exists($viewClass)) return new $viewClass($viewClass);
			else return new Suskind_View_View(str_replace('Control', 'View', $this->control.'_Default'));
		} else return $this->event->getView();
	}
}
?>
