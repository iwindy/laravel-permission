<?php

namespace Illuminate\Routing{
   class Route extends \Illuminate\Support\Facades\Route{
       /**
        * @param string $var
        * @param array $vars
        * @return $this|static
        * @static
        */
       public function auth(string $var, ...$vars){
        return $this;
       }
   }
   class PendingResourceRegistration {
       /**
        * @param array $vars
        * @return $this|static
        * @static
        */
       public function auth(...$vars){
           return $this;
       }
   }
}



