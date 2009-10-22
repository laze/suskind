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
	protected $defaultLayout = null;

	public function  __call($name,  $arguments) {
		$className = 'Application_View_'.substr($this->control, strrpos($this->control, '_')+1).'_'.ucfirst($name);
		if (class_exists($className)) return new $className;
	}

	/**
	 * Return with the view object to show.
	 *
	 * @return Suskind_View_View
	 */
    public function getView(Suskind_View_Layout $layout = null) {
		if (is_null($layout)) $layout = $this->defaultLayout;
		else {
			/**
			 * @todo we have to know, may layout has or not has view for this control.
			 */
		}
		if (is_null($this->control)) throw new Suskind_Exception(Suskind_Exception_Control::NotExists());
		if (is_null($this->event)) {
			$viewClass = str_replace('Control', 'View', $this->control.'_'.$this->events[0]);
			if (class_exists($viewClass)) Suskind_Fountain::getInstance()->setApplicationLayout(new $viewClass($viewClass));
			else Suskind_Fountain::getInstance()->setApplicationLayout(new Suskind_View_View(str_replace('Control', 'View', $this->control.'_Default')));
		} else Suskind_Fountain::getInstance()->setApplicationLayout($this->event->getView());
	}
}

?>