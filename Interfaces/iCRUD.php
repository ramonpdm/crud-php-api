<?php

interface iCRUD
{
    public function findAll();
    public function find();
    public function insert();
    public function update();
    public function delete();
}
