<?php


namespace App\Traits;


use App\User;
use Illuminate\Database\QueryException;
use Mockery\Exception;

/**
 * Trait DeleteMassive
 * @package App\Traits
 */
trait DeleteMassive
{
   use LogsTrail;

   public $destroy;

   public function deleteMassive($relation)
   {
      $restrictions = 0;
      $this->setLog('info', 'Eliminar masivamente', 'deleteMassive', "module {$relation}", [
         'selected' => $this->selected
      ]);
      if (empty($this->selected)) {
         $this->emit('showAlert', 'alert-error', "Debes tener minimo un elemento seleccionado");
         $this->selected = [];
         $this->setLog('error', 'Debes tener minimo un elemento seleccionado', 'deleteMassive', "module {$relation}", [
            'selected' => $this->selected
         ]);;
      } else {
         try {
            switch ($relation) {
               case 'enrollment' :
               case 'user'       :
                  $this->model::destroy($this->selected);
                  break;
               case 'group'            :
               case 'state_enrollment' :
               case 'student'          :
                  foreach ($this->selected as $id) {
                     $u = $this->model::find($id);
                     if ($u->enrollments->isEmpty()) {
                        $u->delete();
                     } else {
                        $restrictions++;
                     }
                  }
                  break;
               case 'category'   :
                  foreach ($this->selected as $id) {
                     $u = $this->model::find($id);
                     if ($u->programs->isEmpty()) {
                        $u->delete();
                     } else {
                        $restrictions++;
                     }
                  }
                  break;
               case 'program'    :
                  foreach ($this->selected as $id) {
                     $u = $this->model::find($id);
                     if ($u->courses->isEmpty()) {
                        $u->delete();
                     } else {
                        $restrictions++;
                     }
                  }
                  break;
               case 'course'     :
                  foreach ($this->selected as $id) {
                     $u = $this->model::find($id);
                     if ($u->groups->isEmpty()) {
                        $u->delete();
                     } else {
                        $restrictions++;
                     }
                  }
                  break;
                case 'role_moodle'     :

                    foreach ($this->selected as $id) {
                        $u = $this->model::find($id);

                        if ($u->enrollments->isEmpty()) {
                            $u->delete();
                        } else {
                            $restrictions++;
                        }
                    }
                    break;
               default           :
                  dd("Not Found relation. 1", $relation);
            }
//            $this->selected = [];
            if ($restrictions > 0) {
               $this->emit('showAlert', 'alert-info', "Algunos registros no se eliminaron porque tienen restricciones. \n Total elementos que no fueron eliminados:{$restrictions}");
               $this->setLog('warning', "Algunos registros no se eliminaron porque tienen restricciones. Total elementos que no fueron eliminados:{$restrictions}", 'deleteMassive', "type {$relation}", [
                  'restrictions' => $restrictions
               ]);
            } else {
               $this->emit('showAlert', 'alert-success', __('messages.success.delete'));
               $this->setLog('info', __('messages.success.delete'), 'deleteMassive', "Type {$relation}", [
               ]);
            }
         } catch  (QueryException $queryException) {
            $this->emit('showAlert', 'alert-error', __('messages.errors.delete'));
            $this->setLog('error', __('messages.errors.delete'), 'deleteMassive', "Type {$relation}", [
               'exception' => $queryException->getMessage(),
            ]);
         }
      }
   }

   public function deleted($relation, $id)
   {
      $flag = false;
      $this->setLog('info', 'Acción eliminar', 'deleted', "type {$relation}");
      try {
         switch ($relation) {
            case 'user'       :
            case 'enrollment' :
               $u = $this->model::find($id);
               $flag = $u->delete();
               break;
            case 'group'            :
            case 'state_enrollment' :
            case 'student'          :
               $u = $this->model::find($id);
               if ($u->enrollments->isEmpty()) {
                  $flag = $u->delete();
               }
               $message = "El registro tiene matrículas asociadas.";
               break;
            case 'category'   :
               $u = $this->model::find($id);
               if ($u->programs->isEmpty()) {
                  $flag = $u->delete();
               }
               $message = "La categoria tiene programas asociados.";
               break;
            case 'program'    :
               $u = $this->model::find($id);
               if ($u->courses->isEmpty()) {
                  $flag = $u->delete();
               }
               $message = "La asignatura tiene grupos asociados.";
               break;
            case 'course'     :
               $u = $this->model::find($id);
               if ($u->groups->isEmpty()) {
                  $flag = $u->delete();
               }
               $message = "El grupo tiene matrículas asociadas.";
               break;
            default           :
               dd("Not Found relation. 2");
         }
         if ($flag) {
            $this->emit('showAlert', 'alert-success', __('messages.success.delete'));
            $this->setLog('info', __('messages.success.delete'), 'deleted', "type {$relation}", [
               'id' => $id, 'model' => $u
            ]);
         } else {
            $this->emit('showAlert', 'alert-info', $message);
            $this->setLog('warning', $message, 'deleted', "type {$relation}", [
               'id' => $id, 'model' => $u
            ]);
         }
      } catch (QueryException $queryException) {
         $this->emit('showAlert', 'alert-error', __('messages.errors.delete'));
         $this->setLog('error', __('messages.errors.delete'), 'deleted', "type {$relation}", [
            'id' => $id, 'exception' => $queryException->getMessage()
         ]);
      }
   }
}
