<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class mdValidatedFile extends sfValidatedFile {
   public function generateFilename()
   {
      $d = dir($this->path);
      $ind = 0;
      $orig =  substr($this->getOriginalName(), 0, strrpos($this->getOriginalName(), '.'));  
      $orig_suffix = substr($this->getOriginalName(), strrpos($this->getOriginalName(), '.'));
      while (false !== ($entry = $d->read())) {
         $e1 = substr($entry, 0, strrpos($entry, '.'));
         $e2 = substr($e1, 0, -3);	 
         if ($e1 == $orig || $e2 == $orig) {
            $ind++;
         }
      }
      $d->close();
      $filename = $orig . ($ind > 0 ? sprintf("_%02d", $ind) : '') . $orig_suffix;
      return $filename;
   }
}
?>
