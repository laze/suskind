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
	protected $defaultView = 'List';
	protected $model;
	protected $event = null;
	protected $events = array(
		'List',
		'Add',
		'Modify',
		'Delete'
	);

    public function getView() {
		return (is_null($this->event)) ? $this->getDefaultView() : $this->event->getView();
	}

	public function getDefaultView() {
	}
}
?>
