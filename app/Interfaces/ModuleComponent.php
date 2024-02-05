<?php


namespace App\Interfaces;


interface ModuleComponent
{
   /**
    * Metodo para render el component de Livewire
    * @return mixed
    */
   public function render();

   /**
    * Metodo para crear nuevo item del módulo
    * @return mixed
    */
   public function store();

   /**
    * Metodo para reiniciar las propiedades
    * @return mixed
    */
   public function cancel();

   /**
    * MEtodo para conultar los datos del elemento a editar
    * @param int $id
    * @return mixed
    */
   public function edit(int $id);

   /**
    * Metodo para actualizar el item con el valor de las propiedades
    * @return mixed
    */
   public function update();
}