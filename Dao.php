<?php
interface Dao{
    public function create($entity);
    public function update($entity);
    public function delete($entity);
    public function get($id);
    public function count();
    public function exist($id);
    public function getAll();
}