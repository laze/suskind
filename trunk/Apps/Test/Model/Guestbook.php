<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Guestbook
 *
 * @author Balazs Ercsey <laze@laze.hu>
 */
class Model_Guestbook extends Suskind_Model {
    protected $comment;
    protected $created;
    protected $email;

    public function __set(string $name, $value);
    public function __get(string $name);

    public function setComment(string $text);
    public function getComment();

    public function setEmail(string $email);
    public function getEmail();

    public function setCreated(date $ts);
    public function getCreated();

    public function save();
    public function find($id);
    public function fetchAll();
}

?>
