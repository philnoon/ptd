<?php

/* An autoloader for ReCaptcha\Foo classes. This should be require()d
 * by the user before attempting to instantiate any of the ReCaptcha
 * classes.
 */

spl_autoload_register(function ($class) {
    if (substr($class, 0, 10) !== 'ReCaptcha\\') {
      /* If the class does not lie under the "ReCaptcha" namespace,
       * then we can exit immediately.
       */
      return;
    }


});
